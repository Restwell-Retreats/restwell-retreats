#!/usr/bin/env bash
# Generate Opt WebP siblings for theme image masters (delivery path used by
# restwell_theme_image_url). Requires cwebp (libwebp).
#
# Usage:
#   ./restwell-theme/tools/generate-opt-webp.sh
#   ./restwell-theme/tools/generate-opt-webp.sh bungalow stock
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)/assets/images"
MAX_EDGE="${RESTWELL_OPT_MAX_EDGE:-1600}"
QUALITY="${RESTWELL_OPT_QUALITY:-78}"

if ! command -v cwebp >/dev/null 2>&1; then
	echo "cwebp not found. Install libwebp (e.g. brew install webp)." >&2
	exit 1
fi

dirs=("$@")
if [ "${#dirs[@]}" -eq 0 ]; then
	dirs=(bungalow stock journey partners)
fi

count=0
for dir in "${dirs[@]}"; do
	src_dir="$ROOT/$dir"
	[ -d "$src_dir" ] || continue
	mkdir -p "$src_dir/opt"
	while IFS= read -r -d '' file; do
		base="$(basename "$file")"
		stem="${base%.*}"
		out="$src_dir/opt/${stem}.webp"
		# Skip if opt is newer than source.
		if [ -f "$out" ] && [ "$out" -nt "$file" ]; then
			continue
		fi
		echo "→ $dir/opt/${stem}.webp"
		cwebp -quiet -q "$QUALITY" -resize "$MAX_EDGE" 0 "$file" -o "$out"
		count=$((count + 1))
	done < <(find "$src_dir" -maxdepth 1 -type f \( -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' -o -iname '*.webp' \) -print0)
done

echo "Generated/updated $count Opt WebP file(s)."
