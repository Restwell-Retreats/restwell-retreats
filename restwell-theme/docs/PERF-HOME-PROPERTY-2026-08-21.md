# Performance notes — home + property (21 Aug 2026)

## Before (concept port)

| Surface | LCP candidate | Issue |
|---------|---------------|--------|
| Home | CSS `background-image` coastline webp (~69KB) | No `<img>`, so preload/`fetchpriority` missed real paint |
| Home below-fold | `EX-1-LS.jpg` ~883KB, PNGs ~750–950KB | Heavy transfer if scrolled early |
| Property | Text interior hero | LCP mostly text; gallery JPGs/PNGs up to ~950KB each |

## After

1. Home hero is a real `<img class="hero__media-img">` with `fetchpriority="high"` + matching `wp_head` preload of the coastline webp ([`inc/performance.php`](../inc/performance.php)).
2. `restwell_theme_image_url()` serves `assets/images/bungalow/opt/*.webp` when present (resized ≤1400px) for home + property templates.
3. Masters under `bungalow/` remain for editors; templates no longer reference multi‑MB paths for those rooms.

### Sample weight deltas (referenced assets)

| Asset | Before | After (opt webp) |
|-------|--------|------------------|
| EX-1-LS | 883KB | ~106KB |
| wet-room-shower | 948KB | ~216KB |
| living-room-2 | 839KB | ~133KB |
| entrance | 767KB | ~174KB |
| GRDEN-2-LS | 597KB | ~275KB |
| WHIT-SEAFRONT-1-LS | 355KB | ~138KB |

## Measure

Playground (21 Aug 2026): home LCP element = `.hero__media-img` (~736ms unthrottled local), preload href matches coastline webp. Below-fold imgs resolve to `bungalow/opt/*.webp`.

Live DevTools: Slow 3G + 4× CPU on `/` and `/the-property/` after deploy for production CDN parity.
