# Page-by-page QA — blog index was non-functional (24 Aug 2026)

## What was found

`index.php` (the blog listing template) was a static concept port: three
hardcoded post cards with fixed titles, excerpts, tags and images, and —
critically — **every link on the page pointed to `/blog/` itself**, including
the post title links (`href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"`
repeated for all three "posts"). There was no `WP_Query`/loop reading real
posts at all.

The site actually has **19 real, fully-written published posts** with rich
content, FAQs, and internal links (confirmed via `/wp-admin/edit.php`), none
of which were reachable from the blog index — clicking any post title just
reloaded the blog listing page. This was found by testing the blog listing
in the browser and inspecting link `href`s directly, since the visual
snapshot looked plausible (real card layout, real-looking copy) but the
underlying anchors were dead.

## Fix

Rewrote `index.php` to use the main WordPress loop (`have_posts()` /
`the_post()`) instead of static markup:

- First post in the loop renders as the large `.blog-featured` card; the
  rest render as `.media-card` items in the existing `.card-grid--2` grid —
  same markup/CSS classes as before, now populated from real post data.
- Real `get_permalink()`, `get_the_title()`, `get_the_excerpt()` (falling
  back to a trimmed `get_the_content()` when no excerpt is set).
- Real featured image via a new shared helper,
  `restwell_get_post_card_thumb()` (added to `inc/post-helpers.php`,
  modelled on the equivalent inline logic already in `single.php`'s related
  -posts loop), falling back to the theme's default blog image + alt text
  when a post has no thumbnail.
- Real primary category tag (`restwell_get_primary_category()`) and reading
  time (`restwell_estimate_read_time()`) — both pre-existing helpers already
  used by `single.php`, just not wired into the index.
- Added `the_posts_pagination()` so post 4+ are reachable ("Older posts" /
  "Newer posts"), since there are far more than 3 posts.

## Verified

- `/blog/` now lists real posts with correct titles/excerpts and unique
  permalinks (spot-checked via `document.querySelectorAll('h2 a, h3 a')`).
- Clicking through to `/quieter-times-whitstable-low-crowd-access/` (and
  others) loads the full article via `single.php`, including its own
  "Related reading" block.
- `/blog/page/2/` pagination works and shows the next 9 posts with a link
  back to page 1.
- `php -l index.php` and `php -l inc/post-helpers.php` — no syntax errors.

## Follow-up: repeated fallback image

Once real posts were showing, every card used the same fallback photo —
confirmed via the REST API (`/?rest_route=/wp/v2/posts&_fields=id,featured_media`)
that all 19 posts have `featured_media: 0` (no featured image assigned in
the media library). Rather than leave every card looking identical, added
`restwell_get_blog_fallback_pool()` and updated `restwell_get_post_card_thumb()`
in `inc/post-helpers.php` to deterministically rotate through 9 already-
optimised, already-alt-mapped Whitstable stock photos (`assets/images/stock/*.webp`,
all under 140KB, all already used elsewhere on the site) keyed by post ID
modulo the pool size, instead of a single fixed fallback image. `single.php`'s
related-posts loop was also switched to call the same shared helper (removing
duplicated inline fallback logic there). Verified via
`document.querySelectorAll('.blog-featured img, .media-card img')` that the
10 cards on the first blog index page now show 9 distinct images.

This doesn't fix the underlying content gap — editors should still add real
featured images per post — but it removes the "why do all the posts have the
same photo" visual bug until they do.

## Impact

This was a full-site content-discovery bug: the blog was invisible/unusable
in the browser, but 19 posts' worth of SEO content and internal linking
(FAQ answers reference several of these posts by name, e.g. "fatigue pacing
ideas", "parking notes") existed and was completely orphaned from
navigation. This is likely the single highest-impact functional fix made
during this pass.
