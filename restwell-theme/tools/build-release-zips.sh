#!/usr/bin/env bash
# Build the two release zips from the committed theme (not the working tree, so
# stray local files never ship):
#
#   restwell-theme-<version>.zip         the theme without assets/images
#                                        (WP Admin → Appearance → Themes → Upload)
#   restwell-theme-media-<version>.zip   restwell-theme/assets/images
#                                        (WP Admin → Media → Restwell Media Import,
#                                        or unzip inside wp-content/themes/)
#
# The media zip carries the optimised images only. Every photo master in
# bungalow/, stock/ and journey/ that has an Opt WebP is left out: the site
# serves the Opt WebPs, and the code that copies photos into the Media Library
# or checks they exist falls back to them (restwell_theme_image_abs_path()).
# The PNG logos and partners/ ship as they are: emails, the printable access
# statement and Theme Setup's Seed media use those files by name.
#
# The theme zip leaves out everything the site doesn't run: internal notes and
# audits (the server would serve those .md files to anyone), docs, briefs,
# tests, build tools, mockups and the unused Phosphor icon font. It keeps
# copy-overwrites/ (the migrations read it; its .htaccess keeps browsers out)
# and llms.txt (served at /llms.txt).
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

rm -rf "$THEME/docs" "$THEME/seo-briefs" "$THEME/tests" "$THEME/tools" "$THEME/scripts" "$THEME/mockups" "$THEME/assets/fonts/phosphor"
find "$THEME" -maxdepth 1 -type f \( -name '*.md' -o -name '.cursorrules' -o -name 'package.json' -o -name 'package-lock.json' -o -name 'phpunit.xml*' \) -delete
# Internal notes anywhere else (inc/*.md); the copy briefs stay, behind their .htaccess.
find "$THEME" -type f -name '*.md' ! -path "$THEME/copy-overwrites/*" -delete

dropped=0
while IFS= read -r -d '' master; do
	stem="$(basename "$master")"; stem="${stem%.*}"
	if [ -f "$(dirname "$master")/opt/${stem}.webp" ]; then
		rm -f "$master"
		dropped=$((dropped + 1))
	fi
done < <(find "$THEME/assets/images/bungalow" "$THEME/assets/images/stock" "$THEME/assets/images/journey" -type f ! -path '*/opt/*' -print0)

THEME_ZIP="$OUT_DIR/restwell-theme-$VERSION.zip"
MEDIA_ZIP="$OUT_DIR/restwell-theme-media-$VERSION.zip"
rm -f "$THEME_ZIP" "$MEDIA_ZIP"
(cd "$STAGE" && zip -rqX "$THEME_ZIP" restwell-theme -x 'restwell-theme/assets/images/*')
(cd "$STAGE" && zip -rqX "$MEDIA_ZIP" restwell-theme/assets/images)

echo "Version $VERSION: left out $dropped photo masters; the media zip holds their Opt WebPs."
left="$(find "$THEME/assets/images/bungalow" "$THEME/assets/images/stock" "$THEME/assets/images/journey" -type f ! -path '*/opt/*' | wc -l | tr -d ' ')"
[ "$left" = 0 ] || echo "Note: $left photo masters have no Opt WebP and ship as they are (run tools/generate-opt-webp.sh)." >&2
ls -lh "$THEME_ZIP" "$MEDIA_ZIP"
