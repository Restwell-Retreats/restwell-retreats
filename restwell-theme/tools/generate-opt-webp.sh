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

# Responsive width variants (opt/<stem>-<w>w.webp) for srcset. Built from the
# master when it is large enough, else from the opt file; never upscaled.
# restwell_theme_image_srcset() discovers these by filename.
# Partner logos and badges render small, so they also get 160/320 variants.
WIDTHS="${RESTWELL_SRCSET_WIDTHS:-480 800 1200 1920}"
variants=0
for dir in "${dirs[@]}" ""; do
	src_dir="$ROOT${dir:+/$dir}"
	[ -d "$src_dir/opt" ] || continue
	while IFS= read -r -d '' opt; do
		base="$(basename "$opt")"
		stem="${base%.webp}"
		case "$stem" in *-[0-9]*w) continue ;; esac
		master="$(find "$src_dir" -maxdepth 1 -type f -name "${stem}.*" \( -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' -o -iname '*.webp' \) | head -n1)"
		master_w=0
		if [ -n "$master" ]; then
			master_w="$(sips -g pixelWidth "$master" 2>/dev/null | awk '/pixelWidth/ {print $2}')"
		fi
		opt_w="$(sips -g pixelWidth "$opt" 2>/dev/null | awk '/pixelWidth/ {print $2}')"
		widths="$WIDTHS"
		if [ "$dir" = "partners" ] && [ -z "${RESTWELL_SRCSET_WIDTHS:-}" ]; then
			widths="160 320 $WIDTHS"
		fi
		for w in $widths; do
			out="$src_dir/opt/${stem}-${w}w.webp"
			if [ -f "$out" ] && [ "$out" -nt "$opt" ]; then
				continue
			fi
			if [ -n "$master" ] && [ "${master_w:-0}" -ge "$w" ]; then
				src="$master"
			elif [ "${opt_w:-0}" -gt "$w" ] && [ "$w" -lt 1920 ]; then
				src="$opt"
			else
				continue
			fi
			# Skip a variant within 10% of the opt width: it would duplicate it.
			if [ "$w" -lt 1920 ] && [ $(( opt_w * 9 / 10 )) -le "$w" ]; then
				continue
			fi
			cwebp -quiet -q "$QUALITY" -resize "$w" 0 "$src" -o "$out"
			variants=$((variants + 1))
		done
	done < <(find "$src_dir/opt" -maxdepth 1 -type f -name '*.webp' -print0)
done
echo "Generated/updated $variants responsive variant(s)."
