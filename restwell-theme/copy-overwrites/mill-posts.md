# Mill posts (supporting URLs)

**Layer:** WordPress posts + sitemap. Not guest landing copy.

Five keep-guides stay indexable. The other fourteen stay noindex. No new mill.

**Enforced in code (2 Oct 2026, audit I01):** the fourteen slugs below are listed in `restwell_get_noindex_post_slugs()` (`inc/seo/canonical.php`). They print `noindex, follow` and are excluded from the sitemap whatever the post meta says, so a re-seed cannot make them indexable. Change that list and this file together. Until a guide is published, links to it point at its hub page (`restwell_get_guide_hub_fallbacks()` in `inc/internal-links.php`), so no page links to a 404.

## Keep indexable

- `/accessible-beaches-coastal-walks-kent/`
- `/direct-payment-holiday-accommodation/`
- `/revitalise-alternatives-accessible-holidays/`
- `/how-to-choose-accessible-self-catering-holiday/`
- `/how-to-read-holiday-cottage-access-statement/`

## Noindex, follow (fourteen)

Parking, trains, eating out, Changing Places, quieter times, fatigue day, CHC explainer, personal-budget Care Act, commissioner checklist, packing, mobility hire, insurance, care-worker backup, carers-respite guide.

Do not chase `respite holiday by the sea` on the carers-respite post. No HowTo schema. No FAQ rich-result plan.
