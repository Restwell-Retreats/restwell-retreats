# SEO seed `inc/seo-content-seed-meta.php`

**Layer:** seed and admin scoring only. Guest titles and metas come from the page overwrite files, never from this table. Do not paste a write-toward string into a title field. Seed PHP shipped 28 Aug 2026.

The write-toward column is what a page should be *about*. It is not the title, and after the 28 Aug rewrite most titles deliberately no longer contain the phrase word-for-word. That is the point: nine directories on the same SERP all use the phrase verbatim, and a human-shaped line is what gets clicked. If the admin scoring penalises a title for not containing its exact phrase, the scoring is wrong, not the title.

| slug | write toward | shipped title (28 Aug) |
| --- | --- | --- |
| home | accessible holiday cottages by the sea | Accessible holiday cottage in Whitstable, sleeps five |
| the-property | accessible holiday bungalow | Look inside the accessible holiday bungalow |
| accessibility | disabled holiday cottages with wet room | A disabled holiday cottage with a wet room and hoist |
| how-it-works | how a restwell stay is booked | Booking a stay, from first email to front door |
| who-its-for | holidays for disabled adults and carers | Holidays for disabled adults and their carers |
| pricing | accessible holiday prices | Prices for the bungalow, and what’s included |
| whitstable-area-guide | whitstable accessible days out | Accessible days out in Whitstable and Tankerton |
| enquire | contact restwell | Ask us anything about a stay at Restwell |
| faq | restwell faq | The questions guests ask us before booking |
| resources | funding an accessible holiday | Funding an accessible holiday, and who we invoice |
| blog | accessible travel | Accessible travel notes from one bungalow |
| optional-care | adding home care during a self-catering stay | Home care in the bungalow, if you’d like it |
| guest-guide | restwell guest guide (noindex) | Restwell guest guide for confirmed stays |
| our-story | restwell our story | Why we built Restwell, and who Continuity are |

Every shipped title sits in the 40–60 character band. None of them uses the `keyphrase: item, item, item` formula that the previous set shared. That shape is what Google rewrites, because it looks like every directory listing on the page.

Admin checkbox label must match output: `noindex, follow`.
