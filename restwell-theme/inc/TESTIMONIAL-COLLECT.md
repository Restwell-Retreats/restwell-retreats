# Collecting guest quotes later (operations)

## Owner

Assign one person (host or admin) to own this.

## Banked reviews

Full guest reviews live in [`docs/guest-reviews-bank.md`](../docs/guest-reviews-bank.md). Use that file when rotating quotes.

**Always paste consecutive words from the review.** Do not rewrite, paraphrase, stitch distant sentences, or sanitise banned phrases. If the guest wrote “fully accessible”, the cite keeps it.

## After each stay (within one week)

1. Send a short message asking for **one sentence** about whether the property fit their access needs, and **permission to use it on the website** with first name or initials only.
2. File replies in a single place (email folder, Notion, or spreadsheet): quote text, name as used, date, **written permission yes/no**.
3. Append new full reviews to `docs/guest-reviews-bank.md`.

## In WordPress

Live homepage reviews come from the Google Places API when a key is set, otherwise from Home → Page content → Testimonials (verbatim guest words). Hardcoded fallbacks in `inc/homepage-content.php` apply only when that tab is empty.

When rotating a static pull-quote in a template, paste consecutive text from `docs/guest-reviews-bank.md` (or the live Google listing). Do not house-style the guest’s words.

## Do not

Publish full names, NHS numbers, or medical detail. Keep quotes specific to the stay and access fit.
