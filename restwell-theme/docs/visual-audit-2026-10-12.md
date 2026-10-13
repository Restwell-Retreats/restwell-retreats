# Section-by-section visual audit, 12 October 2026

Every section of every page was rendered in headless Chrome at 375, 768, 1024 and 1440px. A script also checked each section at 320 and 1920 for heading orphans, line length, unbalanced columns, edge-hugging text, wrapped buttons, tiny text, oversized phone images and empty gaps. Pages covered: Home, The Property, Accessibility, Our Story, How it works, Who it's for, Optional care, Pricing, Whitstable, Funding & Support, FAQ, Enquire, Blog, one article, the three legal pages and the 404.

Status: **Fixed** (in this pass), **Kept** (judged and left, with the reason), **Open** (needs a decision or content, not CSS).

## Site-wide

| Finding | Where | Status |
|---|---|---|
| The breadcrumb sat anywhere from 140px to 230px down the hero, depending on how many lines the title took, so it jumped from page to page. | All interior heroes, all widths | **Fixed.** The breadcrumb is pinned at the top and the title block at the foot of the photo: 140px on all 16 photo heroes at 1440, 138px at 375. |
| Headings inside articles and legal text were the full 44px section size, outweighing a 38rem reading column and running to three or four lines on phones. | Blog posts, Terms, Privacy, Website accessibility | **Fixed.** Running-text h2 is now 24px on phones and 32px on desktop; h3 is 24px. |
| Section heads at desktop squeezed the 44px title into the narrow column, giving three-line titles beside two-line intros. | Every split section head at 1024+ | **Fixed.** The title and intro now take equal halves. At 1440, titles are 1–2 lines with 2–5-line intros beside them; Funding's 11-word title is the one exception, at 3. |
| The closing call-to-action title broke into three lines in a 34rem column. | Mid-CTA on every page | **Fixed.** The column is now 46rem, so titles take one or two lines. |
| The optional-care pointer was a grey box adrift in a full-height (104px + 104px) band. | Property, How it works, Who it's for | **Fixed.** It's an open row in a new slim band (`.section-y--slim`, 32/48/64px). |
| Bleeding photos that don't fill the copy height grew to 700px tall at 1920, beside a few lines of text. | Whitstable promenade and similar splits | **Fixed.** Capped at `min(34rem, 75vh)`. |
| FAQ questions were balanced into three short lines with a wide gap before the plus sign. | All FAQ accordions, phones | **Fixed.** They now wrap with `text-wrap: pretty`. |

## Page by page

| Page / section | Finding | Status |
|---|---|---|
| Home, facts strip | At 960–1099px the four facts broke into three-line labels ("Driveway / parking / for two"). | **Fixed.** They show 2×2 until 1100px. |
| Home, guest reviews | Three cards at 1024 ran about 25 characters a line. | **Fixed.** Three across from 1200px; 2 + 1 below that. |
| Home, property | At 320 the "Have a proper look round the rooms" button wraps onto two centred lines. | **Kept.** It's centred, and the label is the copy. |
| Accessibility, equipment | The specifications accordion was a third white box under the slings note. | **Fixed.** It's an open accordion row between rules, like the FAQs. The download stays a box because it's a single action. |
| Accessibility, "What we can't promise" | It had no eyebrow (every other section has one) and full section padding for three lines. | **Fixed.** Added an "Honest limits" eyebrow and a slim band. |
| Accessibility, fit check | Boxes inside a panel. | **Kept.** It's an interactive tool; the boxes are the controls. |
| Optional care, sister company | Three ~210px columns at 768: "Optional, not automatic" broke onto two lines. | **Fixed.** Side by side from 1024px, stacked below. |
| Pricing, Continuity terms | White tiles inside a grey panel (boxes within a box). | **Fixed.** Open notes under rules. |
| Pricing, rates table and calendar | Boxed. | **Kept.** They're data and an interactive control. |
| Pricing, calendar | Past dates (#b0bdc1 on white, 1.9:1) fail axe contrast. | **Open.** They're non-interactive and de-emphasised on purpose. Darkening them makes them read as bookable. Your call. |
| Funding, routes | The source line under each route ran 114 characters across the full rail. | **Fixed.** Capped to the reading measure. |
| Funding, routes heading | "A starting point for the conversation with your coordinator" takes four lines at 320 and 1024. | **Open.** It's a copy length issue; a shorter title would fix it. |
| Blog article | The "how others read it" cards and the do / avoid panels were boxes in running text. | **Fixed.** Open under a rule; the "In short" summary stays as the one tinted callout. |
| Enquire / FAQ, phones | "Continue" sat at the right edge while "Send question" sat at the left. | **Fixed.** The single primary action spans the column on phones. |
| Legal pages | The 1440 "column void" was the sticky contents rail beside the text. | **Kept.** It's intended. |
| Website accessibility, H1 | "Website accessibility / statement" ends on one word at desktop. | **Kept.** At 56px it can't fit on one line, and the balanced break is the best available. |
| Our Story, closing statement | "Nothing very / complicated" ends on one word. | **Kept.** It's a two-line display statement, balanced. |

## Checks after the pass

- Horizontal overflow: none on 17 pages at 320, 375, 768, 1024, 1440 and 1920.
- axe-core (WCAG 2.2 AA plus best practice) at 1440 and 375: the only finding is the Pricing past-date contrast listed above.
- PHPUnit 99/99, phpcs clean, spacing governance clean, critical CSS rebuilt.

## Not testable here

Safari, Firefox and real devices.
