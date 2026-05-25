# Media Optimization TODO

Scope: `assets/images/media/`

This checklist covers the static media currently stored in the theme, using the `/file-uploads` and `/seo-images` rules: verify real file types, keep filenames safe, compress large assets, prevent layout shift, and avoid hurting LCP.

## Current State

- Images are now correctly stored as `.webp` files.
- The homepage hero video is `restwell-whitstable-tankerton-beach-flyover.mp4`.
- There is a `.DS_Store` file in `assets/images/media/`; remove it before committing.
- Several portrait images are still full-size `2400x3200` files. WordPress can generate responsive sizes after upload, but static theme usage should not serve those originals directly.

## Homepage Hero Video

Current file:

- `restwell-whitstable-tankerton-beach-flyover.mp4`
- Size: about `8.7MB`
- Dimensions: `3840x720`
- Duration: about `15.7s`
- Codec: H.264
- Bitrate: about `4.56Mbps`

Action:

- Keep this file as the source/master only.
- Create a web hero version targeting about `1.5-2.5MB`.
- Create a smaller mobile fallback targeting about `800KB-1.5MB`.
- Keep the hero video muted, autoplaying, looped, and decorative with `aria-hidden="true"`.
- Keep `preload="metadata"`; do not preload the full video.
- Use a poster image for the hero if possible. Best candidates:
  - `restwell-whitstable-rainbow-coast.webp`
  - `restwell-whitstable-coastline-panorama.webp`
  - `restwell-whitstable-beach-huts.webp`

Suggested derivatives:

- `restwell-whitstable-tankerton-beach-flyover-hero.mp4` at around `1920x720`, 24-30fps, lower bitrate.
- `restwell-whitstable-tankerton-beach-flyover-mobile.mp4` at around `960x540` or `1280x480`, lower bitrate.

Do not use the `8.7MB` original as the public homepage hero long-term. It will be expensive on mobile and can delay the page becoming usable.

## Images To Compress Or Replace

These are the highest-priority image files to reduce:

- `ext-patio-door.webp` — about `665KB`, `2400x3200`
- `conservatory-patio-doors.webp` — about `584KB`, `2400x3200`
- `adjustable-sink.webp` — about `370KB`, `2400x3200`
- `int-front-door.webp` — about `351KB`, `2400x3200`
- `conservatory-doors.webp` — about `274KB`, `2400x3200`
- `int-conservatory-doors.webp` — about `233KB`, `2400x3200`
- `kitchen-portrait-view.webp` — about `211KB`, `2400x3200`

Action:

- Generate display-sized copies for page use.
- Target portrait content images at `1080x1350` or smaller.
- Target gallery images under `100KB` where quality allows.
- Target hero/banner images under `200KB`.
- Keep originals only if they are needed as source files or for WordPress to generate responsive sizes.

Note: `kitchen-portrait-view-webp.webp` is also `2400x3200` but only about `95KB`. Prefer it over `kitchen-portrait-view.webp` if the visual quality is acceptable.

## Images Already In Good Shape

Good hero/banner candidates:

- `restwell-whitstable-rainbow-coast.webp` — `1920x829`, about `41KB`
- `restwell-whitstable-coastline-panorama.webp` — `1920x701`, about `69KB`
- `restwell-whitstable-beach-huts.webp` — `1000x496`, about `40KB`
- `restwell-whitstable-public-beach-path.webp` — `1200x669`, about `80KB`

Good content image candidates:

- `accessible-bathroom.webp`
- `accessible-holiday-whitstable.webp`
- `bedroom.webp`
- `profiling-bed.webp`
- `restwell-whitstable-beach-relaxation.webp`
- `restwell-whitstable-drone-aerial-view.webp`
- `restwell-whitstable-sunset-pier.webp`

## Template Markup Fixes

### Homepage Hero

The image hero path in `front-page.php` already uses:

- `loading="eager"`
- `fetchpriority="high"`
- `decoding="async"`
- `sizes="100vw"`

Keep those for image heroes. Do not lazy-load the LCP hero image.

For video heroes, keep the video decorative and use a poster/fallback image. The video should never be the only meaningful content in the hero.

### Property Gallery

`template-property.php` gallery images should be updated to use WordPress image output rather than raw `<img>` tags where possible.

Add:

- `width` and `height` to prevent CLS.
- `loading="lazy"` for below-fold gallery images.
- `decoding="async"` for non-LCP images.
- `sizes` matching the gallery layout.
- Descriptive alt text between `10` and `125` characters.

Avoid serving the full `2400x3200` originals in gallery slots.

## Alt Text Rules

Use natural, specific alt text. Do not keyword-stuff.

Examples:

- `Accessible wet room with adjustable sink, shower chair, and level floor`
- `Profiling bed in a bright accessible bedroom at Restwell Whitstable`
- `Wide patio doors opening from the conservatory into the garden`
- `Tankerton beach and Whitstable coastline at sunset`
- `Front exterior of the accessible holiday bungalow in Whitstable`

Use `alt=""` only for decorative images where nearby text already provides the meaning.

## File Upload And Storage Rules

For any future upload/import workflow:

- Do not trust file extensions. Check magic bytes or WordPress MIME validation.
- Do not use user-provided filenames directly.
- Keep filenames lowercase, hyphenated, and descriptive.
- Strip path characters and avoid spaces/special characters.
- Set size limits before accepting uploads.
- Never buffer large files in PHP if adding custom upload handling; stream or use WordPress Media Library APIs.
- Store only allowed media types: WebP/JPEG/PNG/AVIF for images, MP4/WebM for video if intentionally supported.

Current filenames are mostly good, but long stock-style filenames can be shortened for maintainability:

- `cobbled-streets-in-rye-2026-03-09-09-20-18-utc.webp` -> `rye-cobbled-streets.webp`
- `row-of-colorful-beach-homes-2026-03-25-01-44-35-utc.webp` -> `colourful-whitstable-beach-huts.webp`
- `st-augustines-abbey-in-caterbury-city-england-2026-03-20-01-00-24-utc.webp` -> `st-augustines-abbey-canterbury.webp`
- `scenery-of-the-traditional-historical-village-of-l-2026-03-20-02-02-01-utc.webp` -> `historic-village-lane.webp`

## Cleanup Checklist

1. Remove `assets/images/media/.DS_Store`.
2. Create compressed hero and mobile derivatives for `restwell-whitstable-tankerton-beach-flyover.mp4`.
3. Add a poster/fallback image for the homepage hero video.
4. Compress or replace oversized `2400x3200` portrait images.
5. Replace raw property gallery `<img>` tags with responsive WordPress image output.
6. Add dimensions, lazy loading, async decoding, and sizes to non-hero images.
7. Confirm every meaningful image has useful alt text.
8. Re-run a Lighthouse or PageSpeed check after media changes, focusing on LCP, CLS, and total page weight.
