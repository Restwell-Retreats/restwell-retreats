#!/usr/bin/env bash
# Build a deployable theme tarball that omits image masters when an Opt WebP
# sibling exists (restwell_theme_image_url already prefers Opt). Keeps masters
# that have no Opt counterpart so nothing breaks on the live site.
#
# Usage:
#   ./restwell-theme/tools/build-slim-theme.sh
#   ./restwell-theme/tools/build-slim-theme.sh /tmp/restwell-theme.tgz
set -euo pipefail

THEME_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="${1:-$THEME_ROOT/../restwell-theme-slim.tgz}"
STAGE="$(mktemp -d "${TMPDIR:-/tmp}/restwell-slim.XXXXXX")"
trap 'rm -rf "$STAGE"' EXIT

rsync -a \
	--exclude '.git/' \
	--exclude 'node_modules/' \
	--exclude 'mockups/' \
	--exclude 'docs/archive/' \
	--exclude '*.map' \
	"$THEME_ROOT/" "$STAGE/restwell-theme/"

# Drop masters that have a matching Opt WebP (by stem).
while IFS= read -r -d '' master; do
	dir="$(dirname "$master")"
	stem="$(basename "$master")"; stem="${stem%.*}"
	# Masters live next to an opt/ folder: .../bungalow/foo.jpg → .../bungalow/opt/foo.webp
	parent="$(dirname "$dir")"
	base="$(basename "$dir")"
	if [ "$base" = "opt" ]; then
		continue
	fi
	opt="$dir/opt/${stem}.webp"
	if [ -f "$opt" ]; then
		rm -f "$master"
	fi
done < <(find "$STAGE/restwell-theme/assets/images" -type f \( -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' -o -iname '*.webp' \) ! -path '*/opt/*' -print0)

# Also drop root-level webp/jpg when opt sibling exists under the same folder.
tar -czf "$OUT" -C "$STAGE" restwell-theme
echo "Wrote $OUT"
du -sh "$OUT" "$THEME_ROOT"
