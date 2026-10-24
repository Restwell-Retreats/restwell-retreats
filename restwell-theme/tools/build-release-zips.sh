#!/usr/bin/env bash
# Build the two release zips from the committed theme (not the working tree, so
# stray local files never ship):
#
#   restwell-theme-<version>.zip         the theme without assets/images
#                                        (WP Admin → Appearance → Themes → Upload)
#   restwell-theme-media-<version>.zip   restwell-theme/assets/images, unzipped
#                                        inside wp-content/themes/ on the server
#
# Image masters with an Opt WebP sibling are dropped, as in build-slim-theme.sh,
# except photos copied into the Media Library by exact path (the migrations and
# the default social images): dropping those would silently skip a hero swap.
#
# Usage:
#   ./restwell-theme/tools/build-release-zips.sh            # zips land in the repo root
#   ./restwell-theme/tools/build-release-zips.sh /some/dir
set -euo pipefail

THEME_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
REPO_ROOT="$(cd "$THEME_ROOT/.." && pwd)"
OUT_DIR="${1:-$REPO_ROOT}"
STAGE="$(mktemp -d "${TMPDIR:-/tmp}/restwell-release.XXXXXX")"
trap 'rm -rf "$STAGE"' EXIT

if [ -n "$(git -C "$REPO_ROOT" status --porcelain -- restwell-theme ':!restwell-theme/mockups')" ]; then
	echo "Note: restwell-theme has uncommitted changes; the zips are built from HEAD and leave them out." >&2
fi

git -C "$REPO_ROOT" archive HEAD restwell-theme | tar -x -C "$STAGE"
THEME="$STAGE/restwell-theme"
VERSION="$(sed -n 's/^Version:[[:space:]]*//p' "$THEME/style.css" | head -1)"

# Photos copied into the Media Library by exact path: the migrations, and the
# default social images Theme Setup sideloads (inc/seo-social-meta.php).
KEEP="$STAGE/keep.txt"
grep -hoE "['\"](bungalow|stock|journey|partners)/[A-Za-z0-9_.-]+\.(jpe?g|png|webp)['\"]" "$THEME/inc/theme-setup/migrations.php" "$THEME/inc/seo-social-meta.php" \
	| tr -d "'\"" | sort -u > "$KEEP"

dropped=0
while IFS= read -r -d '' master; do
	dir="$(dirname "$master")"
	[ "$(basename "$dir")" = "opt" ] && continue
	stem="$(basename "$master")"; stem="${stem%.*}"
	rel="${master#"$THEME/assets/images/"}"
	if grep -qxF "$rel" "$KEEP"; then
		continue
	fi
	if [ -f "$dir/opt/${stem}.webp" ]; then
		rm -f "$master"
		dropped=$((dropped + 1))
	fi
done < <(find "$THEME/assets/images" -type f \( -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' -o -iname '*.webp' \) ! -path '*/opt/*' -print0)

THEME_ZIP="$OUT_DIR/restwell-theme-$VERSION.zip"
MEDIA_ZIP="$OUT_DIR/restwell-theme-media-$VERSION.zip"
rm -f "$THEME_ZIP" "$MEDIA_ZIP"
(cd "$STAGE" && zip -rqX "$THEME_ZIP" restwell-theme -x 'restwell-theme/assets/images/*' -x 'restwell-theme/mockups/*')
(cd "$STAGE" && zip -rqX "$MEDIA_ZIP" restwell-theme/assets/images)

echo "Version $VERSION: dropped $dropped masters with an Opt WebP; kept $(wc -l < "$KEEP" | tr -d ' ') the Media Library copies by name."
ls -lh "$THEME_ZIP" "$MEDIA_ZIP"
