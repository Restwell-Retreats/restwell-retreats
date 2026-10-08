#!/usr/bin/env bash
# Bundle and minify the front-end stylesheets into assets/css/site.min.css.
#
# Order matches the unminified cascade in inc/enqueue.php:
#   fonts.css → shared.css → shared-wp.css → polish.css
# The first line records a sha1 of the concatenated sources; tests/CssBundleTest
# fails when the bundle is stale, so rerun this after editing any of them.
# Then rerun tools/build-critical-css.mjs (needs the site running): the inlined
# critical CSS is keyed to this hash and is skipped while it is stale.
#
# Usage: ./restwell-theme/tools/build-css.sh
set -euo pipefail

THEME="$(cd "$(dirname "$0")/.." && pwd)"
CSS="$THEME/assets/css"
ESBUILD="$THEME/../node_modules/.bin/esbuild"
SOURCES=(fonts.css shared.css shared-wp.css polish.css)

if [ ! -x "$ESBUILD" ]; then
	echo "esbuild not found at $ESBUILD (run npm install in the repo root)." >&2
	exit 1
fi

tmp="$(mktemp)"
trap 'rm -f "$tmp"' EXIT
for f in "${SOURCES[@]}"; do
	cat "$CSS/$f" >> "$tmp"
	printf '\n' >> "$tmp"
done
hash="$(shasum -a 1 "$tmp" | awk '{print $1}')"

{
	printf '/* restwell site.min.css src-sha1:%s */\n' "$hash"
	"$ESBUILD" --loader=css --minify --log-level=warning < "$tmp"
} > "$CSS/site.min.css"

printf 'site.min.css: %s bytes (sources %s bytes)\n' "$(wc -c < "$CSS/site.min.css" | tr -d ' ')" "$(wc -c < "$tmp" | tr -d ' ')"
