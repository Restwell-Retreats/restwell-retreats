# Performance audit — sitewide image weight (24 Aug 2026)

## What was found

The 21 Aug pass optimised Home + Property via `restwell_theme_image_url()`, which
serves `assets/images/bungalow/opt/*.webp` when a pre-generated optimised copy
exists, falling back to the raw master otherwise. Four other templates
(`template-how-it-works.php`, `template-who-its-for.php`,
`template-accessibility.php`, `template-our-story.php`) were still building
`<img src>` directly from `get_template_directory_uri() . '/assets/images/bungalow/...'`,
bypassing that helper entirely — so their `opt/` copies (where they existed)
were never used, and images with no `opt/` copy shipped the raw master
regardless of display size.

The worst cases were camera-resolution masters (6000×3750, 8–14MB) displayed
at 640–900px CSS width:

| File | Displayed at | Raw size |
|---|---|---|
| `bungalow/SB-3-LS.jpg` | fallback hero/OG pool | 14.4MB |
| `bungalow/WHIT-SEAFRONT-2-LS.jpg` | fallback hero/OG pool | 12.6MB |
| `bungalow/LR-RNR-LS.jpg` | fallback hero/OG pool | 10.9MB |
| `bungalow/SB-1-LS.jpg` | fallback hero/OG pool | 10.8MB |
| `bungalow/BD1-2-LS.jpg` | **live default hero/OG image for `/how-it-works/`** | 9.2MB |
| `bungalow/WR-3-LS.jpg` | 640px card, `/who-its-for/` | 8.3MB |

`BD1-2-LS.jpg` is the default hero background *and* Open Graph image for the
How It Works page whenever no featured image/ACF hero is set
(`restwell_get_default_og_stock_filename_map()` in `inc/seo-social-meta.php`).
That means a 9.2MB JPEG could be the LCP element and the social-share image
for that page — confirmed live by loading `/how-it-works/` and reading
`document.querySelectorAll('img')`, which resolved to the raw
`bungalow/BD1-2-LS.jpg` before this fix.

Several bungalow photos were also stored as PNG (`patio-1.png`, `kitchen.png`,
`adjustable-sink.png`, `exterior-ramp.png`) — an inefficient format for
photographic content versus WebP.

## Fix

1. Generated resized, compressed WebP copies (`cwebp -q 78`, `sips -Z` for
   resize) into `assets/images/bungalow/opt/` for every file that was being
   referenced directly but had no optimised copy yet. Hero-pool images
   (used at full-bleed width) were resized to 1600px wide; card images
   (displayed ≤640–900px) to 1280px wide.
2. Replaced the four templates' hardcoded
   `get_template_directory_uri() . '/assets/images/bungalow/X'` calls with
   `restwell_theme_image_url( 'bungalow/X' )` (22 replacements total), so
   they resolve through the same opt-or-fallback helper Home/Property
   already use. Raw masters are left in place under `bungalow/` for editors,
   per the existing convention.
3. Verified via CDP in the browser that `/who-its-for/`, `/accessibility/`
   and `/how-it-works/` now request `bungalow/opt/*.webp` — including
   confirming `/how-it-works/` no longer loads the raw `BD1-2-LS.jpg` hero.

## Result

| Metric | Before | After |
|---|---|---|
| Combined size of the 16 files fixed | 59.2MB | 2.0MB (−96%) |
| `/how-it-works/` hero/OG fallback image | 9.2MB JPEG | 217KB WebP |
| `/who-its-for/` `WR-3-LS` card image | 8.3MB JPEG | 57KB WebP |

## Not changed (and why)

- `assets/images/stock/*.webp` references in `index.php` and
  `template-whitstable-guide.php` were left as-is — they're already WebP at
  reasonable weight, so routing them through `restwell_theme_image_url()`
  would look up a non-existent `stock/opt/*.webp` and fall through to the
  same file. No behaviour change, so skipped to keep the diff focused.
- Five oversized bungalow masters remain unreferenced by the OG/hero map for
  their own slugs but now have `opt/` companions anyway
  (`LR-RNR-LS`, `SB-3-LS`, `SB-1-LS`, `WHIT-SEAFRONT-2-LS`) — generated
  defensively since they sit in the same fallback pool and could become live
  if a slug mapping changes.
- Raw masters are kept on disk (not deleted) so editors can still access
  full-resolution originals; only templates were changed to prefer the
  optimised copy.

## Follow-up pass — Open Graph / hero stock JPGs (same day)

The first pass fixed `bungalow/*` references but missed a second, worse gap:
every `stock/*.jpg` file in `restwell_get_default_og_stock_filename_map()`
(`inc/seo-social-meta.php`) had **no WebP `opt/` companion at all**, and the
resolver built the URL by hand instead of calling `restwell_theme_image_url()`.
This map is also read by `inc/page-hero.php` as the **on-page hero fallback**
for any page without a custom ACF hero image — so it isn't just an OG-tag
problem, it's a live LCP problem.

Confirmed by loading `/our-story/` (no ACF hero set) and reading
`document.images`: the visible hero requested
`stock/restwell-kent-riverside-brick-house.jpg` raw, at **2.5MB**.

| File (stock/) | Used by | Raw size |
|---|---|---|
| `restwell-kent-woodland-paved-path.jpg` | `resources` hero/OG | 3.1MB |
| `restwell-canterbury-riverside-walk.jpg` | `faq` hero/OG | 2.8MB |
| `restwell-kent-riverside-brick-house.jpg` | `our-story` hero/OG | 2.5MB |
| `restwell-whitstable-painted-beach-huts.jpg` | `whitstable-area-guide` | 1.9MB |
| `restwell-whitstable-beach-huts-pier-view.jpg` | `enquire` | 1.9MB |
| `restwell-whitstable-pebble-beach-groynes.jpg` | `privacy-policy` | 1.9MB |
| `restwell-kent-nursery-hedgerow-path.jpg` | `accessibility-policy` | 1.9MB |
| `restwell-whitstable-shingle-beach-sunset.jpg` | `terms-and-conditions` | 1.5MB |
| `restwell-whitstable-promenade-golden-hour.jpg` | `home` / `accessibility` | 1.5MB |
| `restwell-whitstable-beach-huts-sunset-slope.jpg` | `who-its-for` | 1.5MB |
| `restwell-whitstable-beach-sailboats-sunset.jpg` | `blog` | 1.4MB |
| `restwell-whitstable-beach-hut-gallery.jpg` | `guest-guide` | 1.8MB |

**Fix:**

1. Generated `assets/images/stock/opt/*.webp` for all 12 files (`cwebp -q
   70–78`, resized to 1400–1600px wide with `sips -Z`).
2. Rewrote `restwell_get_default_og_image_url_for_request()` in
   `inc/seo-social-meta.php` to return `restwell_theme_image_url( $rel )`
   instead of hand-building the raw-file URL, so both the OG meta tag and
   (via `inc/page-hero.php`, which already called the same helper) the
   on-page hero automatically pick up the new `opt/` copies.

**Result:** combined size of the 12 files, 22.7MB → 3.4MB raw source
(unreferenced-by-template masters kept on disk for editors), with the
delivered `opt/*.webp` copies totalling **~3.4MB across 12 files** (108KB–620KB
each) versus the 1.4–3.1MB raw JPGs they replace — an 80–92% reduction per
file. Verified via CDP that `/our-story/`'s hero now requests
`stock/opt/restwell-kent-riverside-brick-house.webp` (368KB, down from
2.5MB), and via `curl` that `og:image` on `our-story`, `resources`, `faq`,
`terms-and-conditions`, `whitstable-area-guide`, `who-its-for`, `enquire`,
`pricing`, `how-it-works`, `optional-care`, `accessibility` and `home` all
now resolve to `opt/*.webp` paths.

**Known remaining gap (documented, not fixed):** `privacy-policy` and
`accessibility-policy` have a WordPress **featured image** set (uploaded via
the media library during theme setup seeding), which takes priority over the
default OG map. Those two uploads are the original ~2MB JPGs sourced from
`stock/restwell-whitstable-pebble-beach-groynes.jpg` and
`stock/restwell-kent-nursery-hedgerow-path.jpg`. This only affects the
`og:image` social-preview tag on those two pages — both templates are
text-only legal pages with no on-page photo hero, so no real visitor ever
downloads it. Optimising uploaded media-library attachments is outside
`restwell-theme/`'s scope (it's site content, not a theme asset) and lower
priority than the on-page LCP fixes above, so it was left as-is.
