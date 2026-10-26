# Mill posts (supporting URLs)

**Layer:** WordPress posts + sitemap. Not guest landing copy.

Twelve guides are indexable: the five keep-guides, the three Batch D rewrites and the four Batch E rewrites (26 Oct 2026). Two guides were folded into Optional Care. The rest stay noindex until their own rewrite (Batches E and F).

**Enforced in code (2 Oct 2026, audit I01):** the noindex slugs below are listed in `restwell_get_noindex_post_slugs()` (`inc/seo/canonical.php`). They print `noindex, follow` and are excluded from the sitemap whatever the post meta says, so a re-seed cannot make them indexable. Change that list and this file together. Until a guide is published, links to it point at its hub page (`restwell_get_guide_hub_fallbacks()` in `inc/internal-links.php`), so no page links to a 404.

## Keep indexable

- `/accessible-beaches-coastal-walks-kent/`
- `/direct-payment-holiday-accommodation/`
- `/revitalise-alternatives-accessible-holidays/`
- `/how-to-choose-accessible-self-catering-holiday/`
- `/how-to-read-holiday-cottage-access-statement/`
- `/carers-respite-holiday-guide/` (respite for carers)
- `/chc-respite-holiday-accommodation-uk/` (CHC respite care)
- `/personal-budget-short-break-care-act/` (Care Act 2014 respite; the slug is kept)
- `/accessible-parking-whitstable-tankerton/` (Blue Badge parking Whitstable)
- `/accessible-train-travel-whitstable-kent/` (is Whitstable station step-free)
- `/hire-mobility-scooter-equipment-uk-holiday/` (mobility scooter hire Whitstable; names First Choice Mobility's Whitstable branch and its October 2026 prices, so recheck them)
- `/travel-insurance-disability-uk-self-catering/` (travel insurance for disabled travellers, UK; quotes Restwell's cancellation terms)

## Folded into Optional Care (26 Oct 2026)

- `/commissioner-checklist-accessible-respite-stay/` → the professionals card (`#for-professionals`)
- `/holiday-backup-plan-care-worker-change/` → the question “What if my own carer can’t come?” (`#faq`)

Both addresses 301 there while no published post holds them (`restwell_folded_guide_redirects()` in `inc/redirects.php`).

## Noindex, follow

Eating out, Changing Places, quieter times, fatigue day and packing, plus the two folded guides should they ever be republished.

No HowTo schema. No FAQ rich-result plan.
