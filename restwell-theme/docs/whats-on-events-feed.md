# What’s on feed (Whitstable guide)

The “What’s on in Whitstable” section on `/whitstable-area-guide/` (`#whats-on`) lists the next six events within four miles of the bungalow. They come from the Data Thistle API, fetched by the server, so guests’ browsers never contact Data Thistle and no cookies are set. Under the events, four “Plan further ahead” links always show. With no key, or no events, only those links show.

Code: `inc/services/class-restwell-events-feed.php` (the feed), the `#whats-on` section in `template-whitstable-guide.php`, and the “Whitstable events” card in `inc/seo-sitewide-render.php`.

## Where the API key lives

- **In wp-admin:** SEO → Site-wide → Whitstable events → **Data Thistle API key**. Paste the access token from your Data Thistle API account (sign in at api.datathistle.com, then Get Access Token) and save. The key is stored privately and only its last four characters are shown. Tick “Clear stored API key on save” to remove it.
- **For a developer:** `define( 'RESTWELL_DATATHISTLE_KEY', '…' );` in `wp-config.php` wins over the admin field, which is then greyed out.

The same card shows whether the feed is working, how many events it holds and when it last updated, or why the last update failed.

## How to clear the cache

- **In wp-admin:** save SEO → Site-wide. Nothing needs to change on the page: every save clears the cached events, and the guide fetches a fresh list on its next visit.
- **If LiteSpeed’s page cache is on:** purge the Whitstable guide as well (LiteSpeed Cache → Toolbox → Purge, or “Purge this page” in the admin bar). While events show, the page asks LiteSpeed to keep its copy for 12 hours at most.
- **With WP-CLI:** `wp transient delete restwell_events_feed_v1`. The last good copy is the `restwell_events_feed_last_good` option; delete that too to start from nothing.

## How it refreshes

- A good fetch is cached for 12 hours. While that copy is fresh, a page view makes no API call.
- If a fetch fails or comes back empty, the guide keeps the last good list and tries again after an hour. A copy more than 24 hours old is never shown: Data Thistle’s API terms limit caching to 24 hours. After that, only the links show until a fetch works.
- The query covers 14 days from today, sorted by date. Events tagged “film” are left out, because cinema listings carry a performance most days and would take all six places.
- Failed fetches are written to the PHP error log only while `WP_DEBUG` is on.

## Data Thistle’s terms

The API terms (api.datathistle.com/terms) ask sites to credit Data Thistle with its logo and a link, and to link to its Add an Event and Update an Event pages. The section currently has a text credit, “Event listings © [year] Data Thistle”, linked to datathistle.com. Check the logo and the two extra links with Data Thistle before going live.
