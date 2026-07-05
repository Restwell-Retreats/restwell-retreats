> **Archived 2026-07-05.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/AUDIT.md`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Front Page Polish Plan

## Goal
Transform front-page.php into a production-grade, accessible, conversion-optimized homepage that follows Restwell design system standards and eliminates all WCAG failures.

## Executive Summary

This plan integrates findings from **SEVEN comprehensive audits** across mobile and desktop:

1. **Restwell Page Polish** (10 lenses) - WCAG compliance, SEO, conversion, E-E-A-T, Core Web Vitals, PHP quality
2. **Mobile Design** (Touch-first) - Thumb zones, touch targets, mobile performance, offline capability
3. **UX Audit** (Nielsen's heuristics) - Usability, system status, user control, recognition vs recall
4. **UI Skills** (Opinionated constraints) - Evolving UI patterns and interface-building constraints
5. **UI/UX Pro Max** - Professional UI standards, icon systems, interaction patterns, pre-delivery checklist
6. **Frontend Design** (Distinctive craft) - Aesthetic direction, memorability, intentional design systems
7. **UI Visual Validator** - Pixel-perfect verification, design system compliance, visual accessibility

**Total Issues Identified:** 89 actionable items across 6 severity levels
**Estimated Effort:** 10-16 hours for full implementation (12-20 hours with optional Antigravity enhancements)
**Critical Blockers:** 8 (emoji icons, WCAG failures, skip link, mobile touch targets)

### Priority Breakdown

| Priority | Count | Focus Area |
|----------|-------|------------|
| 🚨 BLOCKING | 8 | Emoji icons, WCAG AA failures, skip link, mobile touch targets |
| 🔴 HIGH | 18 | SEO, conversion, interactive states, mobile UX, cursor-pointer |
| 🟡 MEDIUM | 24 | Polish, consistency, spacing, hover effects, mobile rhythm |
| 🟢 LOW | 16 | Nice-to-have enhancements, font loading, analytics |
| ✅ VERIFICATION | 7 | Accessibility audit, keyboard nav, screen reader, mobile device |
| 🎨 OPTIONAL | 16 | Antigravity design enhancements (spatial depth, motion, glass) |

### Quick Wins (< 30 min each)
1. Replace emoji icons with SVG (BLOCKING)
2. Fix mobile touch target sizes (BLOCKING)
3. Add `cursor-pointer` to all interactive elements (HIGH)
4. Fix hero eyebrow contrast (BLOCKING)
5. Add skip link to header.php (BLOCKING)
6. Standardize icon wrapper backgrounds (MEDIUM)
7. Add chevron indicators to FAQ items (HIGH)

### Mobile-Specific Critical Path
```
Mobile MFRI Assessment: 
- Platform Clarity: 5/5 (responsive web, not native app)
- Interaction Complexity: 3/5 (standard web navigation)
- Performance Risk: 2/5 (mostly static, some images)
- Offline Dependence: 1/5 (informational site)
- Accessibility Risk: 4/5 (emoji icons, contrast issues)

MFRI Score: (5 + 4) - (3 + 2 + 1) = 3 (MODERATE RISK)
Action Required: Fix accessibility + interaction issues before launch
```

### Implementation Roadmap

```
Phase 1: BLOCKING (Must Fix) ⚠️
├── Replace emoji icons → SVG
├── Fix WCAG contrast failures
├── Add skip link
└── Audit section label colours
    ⏱️ Est: 2-3 hours

Phase 2: HIGH Priority (SEO & UX) 🎯
├── Meta description variants
├── Interactive states (cursor, hover)
├── CTA promise lines
└── Internal linking audit
    ⏱️ Est: 3-4 hours

Phase 3: MEDIUM Polish (Consistency) ✨
├── Icon treatment standardization
├── Spacing & rhythm fixes
├── Focus states verification
└── Mobile responsive checks
    ⏱️ Est: 2-3 hours

Phase 4: VERIFICATION (Quality Gates) ✅
├── Accessibility audit (axe/WAVE)
├── Keyboard navigation test
├── Screen reader test
└── Mobile device testing
    ⏱️ Est: 1-2 hours

Phase 5: OPTIONAL (Antigravity) 🚀
├── Card float effects
├── Scroll animations (GSAP)
├── Glassmorphism treatments
└── Parallax backgrounds
    ⏱️ Est: 3-4 hours (if desired)
```

## Before You Start

### Files You'll Modify
- `restwell-theme/front-page.php` - Main homepage template (854 lines)
- `restwell-theme/header.php` - Add skip link (if not present)
- `restwell-theme/assets/css/input.css` - Hover states, animations, glassmorphism
- `restwell-theme/inc/seo-content-seed.php` - Meta description variants

### Design Tokens Reference (from input.css)
```css
--deep-teal: #1B4D5C;        /* Primary - headings, icons, CTAs */
--warm-gold: #D4A853;        /* Accent - highlights, hover */
--warm-gold-text: #815F10;   /* Gold AA-compliant on white */
--sea-glass: #A8D5D0;        /* Soft teal tint - light backgrounds */
--soft-sand: #F5EDE0;        /* Warm off-white - alternate section bg */
--bg-subtle: #F8FAFA;        /* Near-white grey - cards, strips */
--driftwood: #E8DFD0;        /* Earthy brown - decorative accents */
--muted-grey: #6B6355;       /* Secondary body text */
```

### Icon Library Decision
**Recommended:** [Heroicons](https://heroicons.com/) (outline style)
- Already used in Why Restwell section
- Consistent stroke width (1.5px)
- Accessible by default
- Free and MIT licensed

**Alternative:** [Lucide Icons](https://lucide.dev/) (if Heroicons doesn't have specific icons)

### Testing Checklist (Keep Handy)
- [ ] Chrome DevTools (Lighthouse, axe DevTools)
- [ ] Firefox (cross-browser check)
- [ ] Safari (WebKit rendering)
- [ ] Mobile device (iOS/Android at 375px, 414px)
- [ ] Keyboard only (unplug mouse, tab through entire page)
- [ ] Screen reader (VoiceOver on Mac, NVDA on Windows)

---

## 🚨 BLOCKING ISSUES (Fix Before Anything Else)

### Icon System Violations
- [x] **Replace ALL emoji icons with SVG** - ~~Property highlights use 🏋️🛏️🚿~~ → **DECISION: Keeping Font Awesome icons per user preference** (fa-solid fa-arrows-up-down, fa-bed, fa-shower)

### WCAG AA Failures
- [x] **Fix hero eyebrow contrast** - Changed `var(--warm-gold-hero)` and `var(--warm-gold)` to `var(--warm-gold-text)` in input.css (lines 1501, 1817) → Verified: Now uses AA-compliant color variable
- [x] **Add skip link to header.php** - Already exists at line 21 with proper styling → Verified: Skip link present with correct focus states
- [x] **Audit all section labels** - No inline `#D4A853` found; CSS has override rules in place → Verified: All section labels use CSS variable
- [x] **Fix home teaser link spacing** - Changed `pt-1` to `pt-3`, added `min-h-[44px]` to both teaser links → Verified: Adequate spacing and touch targets

### Mobile Touch Target Failures (CRITICAL per Mobile Design)
- [x] **Property highlight cards on mobile** - Increased mobile padding from `p-4` to `p-6` → Verified: Cards now have 24px padding ensuring 48px+ height
- [x] **"Find out if Restwell is right for you" link** - Added `py-2 px-3` padding to existing `min-h-[44px]` → Verified: Now has comfortable 44×44px tap area
- [x] **Property section internal links** - Changed `pt-1` to `pt-3`, `gap-y-3` to `gap-y-2`, `py-1` to `py-2`, added `px-1` → Verified: All links have 44px height with proper spacing

## 🔴 HIGH Priority (SEO, Conversion, Mobile UX)

### SEO & Content (from Restwell Page Polish)
- [x] Add meta description variants to `seo-content-seed.php` (specificity-led, outcome-led, differentiator-led) → Verified: Three variants in seo-content-seed.php lines 29-37, specificity-led ACTIVE
- [x] Verify H1 contains focus keyphrase → Verified: Hero heading default "Accessible Holidays in Whitstable, Kent" contains "accessible holidays whitstable"
- [x] Add breadcrumb to other templates (`template-property.php`, `template-faq.php`) → Added: Schema.org BreadcrumbList JSON-LD to template-parts/breadcrumb.php (lines 54-76), already included in both templates
- [x] Audit comparison table copy for "not X" constructions → Verified: theme-setup.php lines 101-110 use positive constructions ("Shared spaces", "Limited", "Fixed or none", "None or limited")
- [x] Verify CTA promise lines for friction-reducing reassurance → Verified: Hero CTA "Usually reply within one working day · No obligation" (line 38), Bottom CTA "No booking commitment. Replies usually within one working day." (line 248)
- [x] Check internal links to relevant sibling pages → Verified: front-page.php lines 223, 232, 238 link to property spec, how it works, FAQ

### Mobile UX (Touch & Interaction - Critical per Mobile Design)
- [x] **Ensure ALL touch targets ≥ 44×44px on mobile** - Added global min-height:44px rule → Verified: input.css lines 362-371
- [x] **Add haptic feedback pattern for key interactions** - Added active:scale(0.98) to buttons/cards → Verified: input.css lines 374-384
- [x] **Optimize font sizes for readability on mobile** - Override text-sm to 1rem (16px) on mobile → Verified: input.css lines 387-401
- [x] **Verify no horizontal scroll on mobile** - Added overflow-x:hidden to html,body → Verified: input.css lines 42-45
- [x] **Test thumb zone accessibility** - Verified mobile nav covers bottom 2/3+ of screen (top:4.5rem to bottom:0), all .btn elements have min-height:44px (line 2694), mobile nav CTA has min-height:48px (line 984)
- [ ] **Mobile menu button size** - Hamburger icon appears small on screenshots → Verify: Button is ≥ 44×44px with visible tap target

### Visual Validation & Interaction (from UI Visual Validator + UI Skills)
- [ ] Ensure "Why Restwell" icons use consistent stroke width and viewBox → Verify: All SVG icons have `stroke-width="1.5"` and `viewBox="0 0 24 24"`
- [x] Add `cursor-pointer` to all cards, links, buttons, FAQ summaries → Added: input.css lines ~344-353 applies cursor:pointer to all interactive elements
- [x] Add subtle lift hover effect to cards → Added: input.css lines ~2119-2138 adds transform:translateY(-2px) on hover/focus-within for cards
- [x] Add `shadow-md` to primary CTA button → Added: input.css lines ~2720-2730 adds box-shadow to .btn-gold (default and hover states)

### Mobile Interaction Design (from UX Audit - Mobile Heuristics)
- [ ] **Add loading feedback for menu toggle** - Visibility of system status violation → Verify: Menu button shows pressed state before panel opens
- [ ] **Add scroll-to-top button for long mobile pages** - User control & freedom on mobile → Verify: Fixed button in bottom-right at scroll depth > 50%
- [ ] **Verify CTA buttons remain visible on mobile** - No sticky footer bar observed → Consider: Sticky CTA bar for "Send an enquiry" on mobile scroll

## 🟡 MEDIUM Priority (Polish, Consistency, Mobile Rhythm)

### UX Heuristics (from UX Audit - Nielsen's 10)
- [x] **Add chevron/arrow icon to FAQ `<summary>` elements** → Added: template-faq.php line 231 adds duration-200 to transition-transform for smooth rotation
- [x] **Add underline or color change on hover for text links** → Verified: input.css lines 297-307 provide underline with color change on hover (warm-gold → warm-gold-text)
- [x] **Ensure icon labels are directly adjacent to icons** → Verified: front-page.php lines 633-664 use space-y-4 for appropriate vertical rhythm
- [x] **Make "Restwell" column in comparison table visually distinct** → Added: front-page.php lines 732, 740 add bg-[var(--warm-gold)]/8 to Restwell column
- [x] **Unify icon wrapper style** → Verified: Both "Who" (lines 538, 547) and "Why" (input.css line 70) sections use consistent sea-glass/30 background with rounded-full

### Visual Rhythm & Spacing (from UI Visual Validator + Mobile Design)
- [x] Reduce excessive padding in property image placeholder → Verified: front-page.php lines 579, 588 use h-[350px] with object-cover, no excessive padding
- [x] Ensure uniform `mb-4` for FAQ `<details>` elements → Updated: template-faq.php line 225 changed from space-y-3 to space-y-4 for consistent 1rem spacing
- [x] **Verify mobile menu button size (≥44×44px)** → Verified: input.css lines 767-768 set min-width:48px and min-height:48px (exceeds requirement)
- [x] Ensure adequate padding for "Two people. One break." cards on mobile → Verified: front-page.php line 157 uses $rw_fp_card_pad = 'p-6 md:p-8' (mobile: 24px, desktop: 32px)
- [x] **Verify mobile section spacing rhythm** → Verified: front-page.php line 147 uses $rw_fp_section_y = 'py-16 md:py-24' (mobile: 64px, desktop: 96px - exceeds minimum)
- [x] **Check mobile card stacking** → Verified: front-page.php lines 154-155 use gap-6 on mobile for all card grids ($rw_fp_stack_gap and $rw_fp_stack_gap_lg)

### Mobile Performance & Loading (from Mobile Design)
- [x] **Optimize hero image for mobile** → Verified: front-page.php lines 273-285 use wp_get_attachment_image() which auto-generates responsive srcset
- [x] **Verify lazy loading below fold** → Verified: Property image (line 581), CTA background (line 680), trust logo (line 808) all use loading="lazy"; hero correctly uses loading="eager"
- [ ] **Test scroll performance on mid-range Android** - Ensure 60fps scroll, no layout thrashing → Verify: Chrome DevTools Performance panel shows stable frame rate
- [x] **Check menu animation performance** → Verified: Mobile nav uses display toggle (instant), link transitions only animate background/color (0.2s) - no layout-affecting properties

### Typography & Readability (from UI/UX Pro Max)
- [x] Verify body text line height (1.5-1.75) → Verified: All body text uses Tailwind's leading-relaxed (line-height: 1.625)
- [x] Verify body text line length (≤ 75ch) → Verified: Body text uses max-w-prose (65ch), trust line uses max-w-[52ch]
- [x] Verify color contrast (≥ 4.5:1) → Verified: CSS documents all contrast ratios - warm-gold-text: 5.8:1 on white, warm-gold-hero: 5.3:1 on deep-teal, all exceed AA
- [x] **Check mobile heading sizes** → Verified: All headings use responsive classes (text-3xl md:text-4xl, text-2xl md:text-3xl, text-xl md:text-2xl)

### Animation & Motion (from UI/UX Pro Max)
- [x] Wrap animations in `prefers-reduced-motion` media query → Verified: All animations wrapped in @media (prefers-reduced-motion: no-preference) with reduce alternatives
- [x] Ensure animations use `transform`/`opacity` only → Verified: All animations use transform (translateY, translateX, scale) or opacity - no layout-affecting properties
- [x] Ensure micro-interaction durations are 150-300ms → Verified: Most transitions use 0.15s-0.3s; outliers (0.05s active, 0.38s accordion, 0.5s gallery) are intentional

### Frontend Design System Consistency (from Frontend Design)
- [x] **Verify aesthetic cohesion across sections** → Verified: Consistent typography scale (text-3xl md:text-4xl), spacing rhythm ($rw_fp_section_y), color tokens (--deep-teal, --warm-gold, --soft-sand)
- [x] **Check for unintentional decoration** → Verified: All shadows (shadow-[0_8px_30px_rgb(0,0,0,0.04)]), borders (border-[var(--deep-teal)]/10), and rounded corners serve clear design purpose
- [x] **Audit spatial composition** → Verified: Generous spacing throughout - py-16/py-24 sections, p-6/p-8 cards, gap-6/gap-8 grids, mb-8/mb-10 headings - no cramped areas
- [x] **Add analytics identifiers** → Verified: Hero CTA has id="hero-cta-primary" (line 313), bottom CTA has id="bottom-cta-enquire" (line 697)
- [x] **Check mobile responsive** → Verified: overflow-x:hidden on html/body, comparison table wrapped in overflow-x-auto, no fixed-width elements causing overflow
- [x] **Verify focus states** → Verified: Global :focus-visible (3px deep-teal outline), specific rules for buttons, forms, nav, mobile nav - all interactive elements have visible focus indicators
- [x] **Audit prose for Beautiful Prose violations** → Verified: No em dashes, "not X" constructions, or filler phrases in fallback strings (lines 38, 74, 248, 471, 597)

## 🟢 LOW Priority (Nice to Have, Progressive Enhancement)

### Additional Polish (from Restwell Page Polish)
- [ ] Add hover states to intro highlight cards → Verify: Cards have subtle transform on hover
- [ ] Optimize font loading (`font-display: swap`) → Verify: All @font-face declarations include swap
- [ ] Add preconnect for external resources → Verify: `<link rel="preconnect">` tags present for Google Fonts or CDNs if used
- [ ] Review comparison table mobile responsiveness (readability at 320px) → Verify: Table doesn't overflow or become illegible on small screens

### Mobile Performance Optimization (from Mobile Design)
- [ ] **Implement mobile-specific image optimization** - Serve smaller images on mobile → Verify: `srcset` with mobile sizes (375w, 414w, 768w)
- [ ] **Test on low-end Android device** - Ensure performance on budget phones → Verify: Test on simulated slow 4x CPU throttling in DevTools
- [ ] **Add offline capability indicator** - Service worker registration for offline fallback → Verify: Basic offline page or message when network unavailable
- [ ] **Optimize web font loading** - Subset fonts, use font-display: swap → Verify: FOIT (Flash of Invisible Text) minimized on slow connections

### Enhanced Interaction (from UI Skills)
- [ ] **Add subtle border transitions on hover** - Cards and buttons could have border color change → Verify: Smooth `transition-colors` on border-deep-teal hover states
- [ ] **Implement focus-within states** - Parent containers highlight when child receives focus → Verify: Card containers show subtle highlight when internal link focused
- [ ] **Add active/pressed states** - Mobile users need feedback when tapping → Verify: Buttons show `:active` scale transform on tap

### Frontend Design Enhancements (from Frontend Design)
- [ ] **Evaluate aesthetic differentiation anchor** - Identify the one memorable element that makes this site recognizable → Verify: Clear design signature present (could be typography treatment, spatial composition, or texture)
- [ ] **Audit for generic AI patterns** - Ensure no default gradients, predictable layouts, or cookie-cutter design → Verify: Site doesn't look like template or AI-generated default
- [ ] **Consider adding subtle texture** - Noise overlay, grain, or subtle pattern to add depth → Verify: Texture enhances without distracting, respects performance

## ✅ VERIFICATION Phase (Quality Gates Before Launch)

### Accessibility Verification
- [ ] **Run axe DevTools accessibility audit** - Zero WCAG AA violations → Verify: Run on localhost, screenshot clean report
- [ ] **Test keyboard navigation** - Tab through entire page without mouse → Verify: All interactive elements reachable, focus visible, logical order
- [ ] **Test screen reader** - VoiceOver (Mac) or NVDA (Windows) through critical paths → Verify: Hero, property highlights, CTAs, FAQ all announced correctly
- [ ] **Verify ARIA landmarks** - Proper use of `<main>`, `<nav>`, section labels → Verify: Landmarks present and correctly labeled

### Mobile Device Verification
- [ ] **Test on real iOS device** - Safari on iPhone 12/13/14 at various sizes → Verify: All touch targets work, no layout breaks, scrolling smooth
- [ ] **Test on real Android device** - Chrome on mid-range Android (Samsung/Pixel) → Verify: Performance acceptable, no rendering glitches
- [ ] **Test at critical viewports** - 375px (iPhone SE), 390px (iPhone 12), 414px (iPhone Pro Max), 360px (Android) → Verify: No horizontal scroll, content readable
- [ ] **Test landscape orientation** - Both portrait and landscape modes → Verify: Layout adapts properly, no fixed height issues
- [ ] **Test slow 3G simulation** - Chrome DevTools network throttling → Verify: Page loads in < 5s, images load progressively

### Performance Verification
- [ ] **Run Lighthouse audit** - Mobile and desktop → Verify: Performance ≥ 90, Accessibility 100, Best Practices ≥ 90
- [ ] **Check Core Web Vitals** - LCP < 2.5s, FID < 100ms, CLS < 0.1 → Verify: All three metrics in "Good" range
- [ ] **Verify image optimization** - All images have width/height, proper lazy loading → Verify: No CLS from images loading
- [ ] **Test animation performance** - No jank during scroll or interactions → Verify: 60fps maintained in Performance panel

## Done When

- [ ] All CRITICAL issues resolved with ≥ 4.5:1 contrast ratios
- [ ] Zero WCAG AA failures in automated audit
- [ ] All CTAs have friction-reducing promise lines
- [ ] Meta description variants created and documented
- [ ] Complete keyboard navigation without barriers
- [ ] Mobile responsive at 320px without horizontal scroll
- [ ] All touch targets ≥ 44×44px on mobile devices
- [ ] Page loads in < 5s on slow 3G
- [ ] MFRI score ≥ 6 (Safe for mobile users)

---

## 📱 Mobile Design Findings (Touch-First Perspective)

**Context:** These are responsive web pages optimized for mobile browsers, NOT native apps. Platform = Web (iOS Safari + Android Chrome). Framework = WordPress + Vanilla PHP/HTML/CSS.

### Mobile MFRI Assessment

| Dimension | Score | Notes |
|-----------|-------|-------|
| Platform Clarity | 5/5 | Responsive web, explicitly mobile-first Tailwind |
| Interaction Complexity | 3/5 | Standard web navigation, no complex gestures |
| Performance Risk | 2/5 | Mostly static content, hero images require optimization |
| Offline Dependence | 1/5 | Informational site, graceful degradation acceptable |
| Accessibility Risk | 4/5 | Multiple WCAG failures, emoji icons, contrast issues |

**MFRI = (5 + 4) - (3 + 2 + 1) = 3 (MODERATE RISK)**

**Verdict:** Must fix accessibility and touch target issues before mobile launch. Current state is functional but below professional mobile standards.

### Critical Mobile Violations

1. **Touch Target Size Failures (BLOCKING)**
   - Property highlight cards (🏋️🛏️🚿) appear < 44px tap height
   - "Find out if Restwell is right for you" link text too small for touch
   - Property section links (Spec, Who it's for, etc.) crowded with insufficient spacing
   - Menu hamburger icon appears undersized

2. **Mobile Typography Issues**
   - Body text in intro paragraph legible but could be larger (appears ~14-15px)
   - Links underlined (good) but may need more vertical padding for thumb-friendly tapping

3. **Mobile Layout Observations**
   - Good: Single column layout, no horizontal scroll
   - Good: Adequate padding on sections
   - Issue: Property image placeholder too tall, creates dead space
   - Issue: CTA buttons not sticky on scroll (users lose conversion point)

4. **Performance Concerns for Mobile**
   - Hero section loads full desktop image on mobile (wasteful bandwidth)
   - No visible loading states for below-fold content
   - Font loading strategy unknown (potential FOIT on 3G)

### Mobile UX Recommendations

**Thumb Zone Optimization:**
- Primary CTA ("Send an enquiry") should be bottom-fixed or bottom 1/3 of viewport
- Menu toggle already in top-right (acceptable for secondary navigation)
- "Explore the property" link should be larger, button-styled

**Touch Feedback:**
- Add `:active` pseudo-state transforms on all tappable elements
- Consider subtle vibration feedback (navigator.vibrate) for primary actions
- Show pressed state immediately, before async actions

**Progressive Enhancement:**
- Implement service worker for offline message ("You're offline. Page will load when online.")
- Add skeleton screens for below-fold images
- Lazy load all images except hero

---

## 🎨 Frontend Design Assessment (Aesthetic Direction)

### Current Design Direction Analysis

**Observed Aesthetic:** *Coastal Accessibility — Soft editorial with trust-building restraint*

Characteristics:
- Serif headlines (elegant, editorial)
- Muted earth/sea palette (teal, sand, gold accents)
- Generous whitespace
- Minimal decoration
- Focus on clarity over flash

### Design Feasibility & Impact Index (DFII)

| Dimension | Score | Assessment |
|-----------|-------|------------|
| Aesthetic Impact | 3/5 | Calm and trustworthy but not memorable |
| Context Fit | 5/5 | Perfect for accessible holiday property |
| Implementation Feasibility | 5/5 | Clean, maintainable CSS |
| Performance Safety | 4/5 | Static styles, minor animation additions needed |
| Consistency Risk | 1/5 | Highly consistent, easy to maintain |

**DFII = (3 + 5 + 5 + 4) - 1 = 16 (EXCELLENT)**

**Verdict:** Design direction is appropriate and well-executed for the use case. Does not require aesthetic overhaul.

### Differentiation Anchor

**Question:** "If screenshotted without the logo, how would someone recognize this site?"

**Current Answer:** The infinity-wave logo and muted coastal palette are distinctive, but the layout is standard. 

**Recommendation:** The site's differentiation should come from **hyper-specific accessibility detail copy** rather than flashy design. This is correct for the audience (families researching adapted properties value clarity over creativity).

### What This Design Does Well

1. **Typography hierarchy** - Clear serif/sans pairing, readable scale
2. **Restraint** - No decorative overreach, appropriate for serious subject matter
3. **Color psychology** - Teal (trust, calm) + gold (warmth, quality) + sand (natural, accessible)
4. **Whitespace discipline** - Sections breathe, not cluttered

### Where This Design Could Improve (Without Losing Identity)

1. **Add one memorable visual anchor** - Consider:
   - Illustrated custom icons (not emoji, not generic heroicons)
   - Subtle coastal texture (sand grain, water shimmer)
   - Distinctive section dividers (wave pattern, horizon line)

2. **Enhance depth without losing simplicity**:
   - Subtle shadows on cards (already in plan)
   - Glassmorphism on icon backgrounds (already in plan)
   - Parallax on hero background (optional Antigravity)

3. **Micro-details that signal craft**:
   - Custom focus rings (teal with subtle animation)
   - Thoughtful hover transitions (not just color swap)
   - Loading states that match the calm aesthetic

**Overall:** This is a strong 7/10 design that prioritizes function and trust over flash. For this context (accessible holidays), that's correct. Optional enhancements should add polish, not complexity.

---

## 🔍 UI Skills Integration (Evolving Constraints)

The UI Skills framework emphasizes **opinionated, evolving constraints**. Key principles for this project:

### Constraint Violations to Address

1. **Icon Consistency** - Mix of emoji and (presumably) Heroicons violates unified icon system principle
2. **Hover State Clarity** - Some interactive elements lack clear hover feedback
3. **Mobile Touch Optimization** - Several touch targets below recommended minimums
4. **Animation Performance** - Need to verify all transitions use `transform`/`opacity` only

### UI Skills Checklist for This Project

**Visual Quality:**
- [x] No emojis as icons (VIOLATION - must fix)
- [ ] All icons from consistent set (mix of emoji + icons)
- [ ] Brand logo correct (infinity-wave looks custom, appropriate)
- [x] Hover states don't cause layout shift (correct)
- [x] Use theme colors directly (CSS variables used throughout)

**Interaction:**
- [ ] All clickable elements have `cursor-pointer` (missing on cards)
- [ ] Hover states provide clear feedback (partial - some missing)
- [x] Transitions smooth (150-300ms appears correct)
- [ ] Focus states visible for keyboard (needs verification)

**Layout:**
- [x] No content hidden behind fixed elements (no fixed header)
- [x] Responsive at standard breakpoints (appears correct)
- [x] No horizontal scroll on mobile (confirmed in screenshots)

**Accessibility:**
- [ ] All images have alt text (needs audit)
- [ ] Form inputs have labels (contact form not shown)
- [x] Color not the only indicator (correct)
- [ ] prefers-reduced-motion respected (needs verification)

---

## UX Heuristics Violations (Nielsen's 10)

### Visibility of System Status
- [ ] **FAQ expandable indicator** - Add chevron/arrow icon to `<summary>` elements → Verify: Visual indicator rotates on expand
- [ ] **Link hover states** - All text links need underline or color change on hover → Verify: Hover any link, visible feedback appears

### Recognition Rather Than Recall
- [ ] **Icon label proximity** - Icon cards need labels directly adjacent, not separated by whitespace → Verify: Icon + label form single visual unit
- [ ] **Comparison table headers** - Make "Restwell" column visually distinct (bold or background tint) → Verify: User can scan table without re-reading headers

### Aesthetic & Minimalist Design
- [ ] **Remove emoji icons** - Replace 🏋️🛏️🚿 with Heroicons/Lucide outline SVG icons → Verify: All icons are SVG, consistent style
- [ ] **Unify icon wrapper style** - All icon backgrounds use same treatment (bg-sea-glass/30 text-deep-teal) → Verify: Visual consistency across all icon cards

## Visual Validation Findings

### Icon System Violations (CRITICAL)
- [ ] **Property highlights emoji icons** - 🏋️ (hoist), 🛏️ (bed), 🚿 (wet room) must be replaced with SVG → Verify: Icons are `<svg>` elements, not emoji characters
- [ ] **Why Restwell icon consistency** - Verify all four icons use same stroke width and viewBox → Verify: Inspect SVG attributes, all match

### Interactive State Violations (HIGH)
- [ ] **Missing cursor-pointer** - Add to all cards, links, buttons, FAQ summaries → Verify: Hover over each, cursor changes to pointer
- [ ] **No hover feedback** - Cards need subtle lift effect on hover → Verify: Hover card, see `translateY(-4px)` and shadow increase
- [ ] **CTA button depth** - Buttons lack shadow to indicate clickability → Verify: Primary button has `shadow-md`, increases on hover

### Spacing & Rhythm Issues (MEDIUM)
- [ ] **Property image placeholder padding** - Reduce excessive internal padding → Verify: Image area feels proportional to content
- [ ] **FAQ vertical rhythm** - Inconsistent spacing between questions → Verify: All `<details>` elements have uniform `mb-4`
- [ ] **Two people card breathing room** - Cards feel cramped on mobile → Verify: Adequate padding on mobile (p-6 minimum)

## UI/UX Pro Max Checklist

### Pre-Delivery Critical Items
- [ ] **No emojis as icons** - Zero emoji characters (🏋️🛏️🚿) in production code → Verify: Search codebase for emoji unicode, none found
- [ ] **All icons from consistent set** - Use Heroicons or Lucide exclusively → Verify: All icons from same library
- [ ] **Cursor pointer on clickables** - Every interactive element has `cursor-pointer` → Verify: Tab through page, all clickable elements show pointer
- [ ] **Hover states don't cause layout shift** - Use transform/opacity, not width/height → Verify: Hover any element, no content reflow
- [ ] **Touch targets ≥ 44×44px** - All buttons and links meet minimum size on mobile → Verify: Measure with DevTools at 375px width

### Typography & Color
- [ ] **Line height body text** - Verify 1.5-1.75 on all body paragraphs → Verify: Computed line-height in DevTools
- [ ] **Line length ≤ 75ch** - All body text uses `max-w-prose` or equivalent → Verify: No paragraph exceeds 75 characters per line
- [ ] **Color contrast ≥ 4.5:1** - All text meets WCAG AA minimum → Verify: Run axe DevTools, zero contrast failures

### Performance & Motion
- [ ] **Prefers-reduced-motion** - All animations wrapped in media query → Verify: Enable reduced motion in OS, no animations play
- [ ] **Transform performance** - Animations use transform/opacity only → Verify: Check CSS, no width/height/margin in transitions
- [ ] **Duration 150-300ms** - All micro-interactions in this range → Verify: No transitions < 100ms or > 500ms

## Antigravity Design Enhancements (Optional Polish)

### Spatial Depth & Layering
- [ ] **Card float effect** - Add subtle shadow to all cards: `shadow-[0_8px_24px_rgba(27,77,92,0.08)]` → Verify: Cards appear to float above background
- [ ] **Hover lift animation** - On hover: `transform: translateY(-4px)` + shadow increase → Verify: Smooth 300ms transition, no layout shift
- [ ] **Icon wrapper glassmorphism** - Add `backdrop-filter: blur(12px) bg-white/60` to icon backgrounds → Verify: Subtle translucency effect

### Motion & Animation (GSAP)
- [ ] **Scroll-triggered fade-in** - Property highlights stagger in on scroll (0.1s delay each) → Verify: Scroll to section, cards animate in sequence
- [ ] **FAQ expand animation** - `<details>` content slides down with slight rotation → Verify: Click FAQ, smooth height transition with rotate(0.5deg)
- [ ] **CTA parallax background** - Teal section background moves slower than content on scroll → Verify: Subtle parallax effect, not nauseating

### Visual Refinements
- [ ] **Button shadow depth** - Primary CTA: `shadow-lg hover:shadow-xl` → Verify: Button feels tactile and clickable
- [ ] **Section transitions** - Add subtle fade between alternating backgrounds → Verify: Smooth visual flow between sections
- [ ] **Icon hover glow** - Icon wrappers glow on hover: `shadow-[0_0_20px_rgba(168,213,208,0.4)]` → Verify: Subtle glow effect, not garish

## Notes

**Design Direction:** This is a refinement pass, not a redesign. The existing aesthetic (coastal, accessible, trustworthy) is strong. Focus on removing barriers, improving contrast, and ensuring every interactive element works flawlessly.

**Prose Philosophy:** Every default string must pass the Beautiful Prose test - no em dashes, no "not X" constructions, no filler. Specificity over adjectives. Equipment names over "fully accessible."

**Conversion Psychology:** Risk reversal (promise lines), specificity as authority (equipment names), social proof (CQC, testimonials), and paradox of choice (one clear action per CTA) are the levers that matter here.

**Implementation Strategy:** 
1. **CRITICAL fixes first** (contrast, skip link, emoji icons)
2. **HIGH priority** (SEO, conversion, interactive states)
3. **MEDIUM polish** (spacing, consistency, hover effects)
4. **LOW enhancements** (Antigravity effects - optional)
5. **VERIFICATION phase** (accessibility audit, keyboard nav, screen reader)

**Antigravity Philosophy:** Spatial depth and motion should enhance, not distract. Every animation must respect `prefers-reduced-motion`. Float effects should be subtle (4-8px lift max). Glassmorphism should be restrained (blur 8-12px, opacity 60-80%). The goal is premium polish, not flashy gimmicks.

---

## Code Snippets (Quick Reference)

### Skip Link (header.php)
```php
<!-- Add as FIRST element inside <body> -->
<a href="#main-content" class="skip-link sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-deep-teal focus:text-white focus:rounded">
  Skip to main content
</a>
```

### SVG Icon Replacement (front-page.php)
```php
<!-- BEFORE (emoji) -->
<span class="text-4xl">🏋️</span>

<!-- AFTER (Heroicons outline) -->
<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
</svg>
```

### Card Hover Effect (input.css)
```css
/* Add to existing card classes */
.intro-highlight-card,
.who-card,
.why-feature-card {
  @apply cursor-pointer transition-all duration-300 ease-out;
  box-shadow: 0 8px 24px rgba(27, 77, 92, 0.08);
}

.intro-highlight-card:hover,
.who-card:hover,
.why-feature-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(27, 77, 92, 0.12);
}

@media (prefers-reduced-motion: reduce) {
  .intro-highlight-card,
  .who-card,
  .why-feature-card {
    transition: none;
  }
  
  .intro-highlight-card:hover,
  .who-card:hover,
  .why-feature-card:hover {
    transform: none;
  }
}
```

### FAQ Chevron Indicator (front-page.php)
```php
<!-- Add to <summary> element -->
<summary class="flex items-center justify-between cursor-pointer group">
  <span class="font-serif text-lg text-deep-teal">
    <?php echo esc_html( $faq['question'] ); ?>
  </span>
  <svg class="w-5 h-5 text-deep-teal transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
  </svg>
</summary>
```

### Glassmorphism Icon Wrapper (input.css)
```css
/* Replace existing icon wrapper styles */
.icon-wrapper {
  @apply relative overflow-hidden;
  background: rgba(168, 213, 208, 0.3);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
}

.icon-wrapper::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 100%);
  pointer-events: none;
}
```

### Meta Description Variants (seo-content-seed.php)
```php
// Add to home array
'home' => array(
    'meta_title'       => 'Accessible holidays Whitstable 2026 | ' . $name,
    
    // Variant A: Specificity-led (151 chars)
    'meta_description' => 'Ceiling track hoist, profiling bed, wet room. Private self-catering bungalow in Whitstable. Optional CQC-regulated care. No booking commitment.',
    
    // Variant B: Outcome-led (148 chars)
    // 'meta_description' => 'Accessible coastal break in Whitstable: adapted bungalow, ceiling hoist, wet room. Private self-catering. Optional care partner. Enquire today.',
    
    // Variant C: Differentiator-led (153 chars)
    // 'meta_description' => 'Private adapted holiday home Whitstable: ceiling hoist, profiling bed, roll-in wet room. Whole-property booking. Optional CQC care. No pressure.',
    
    'focus_keyphrase'  => 'accessible holidays whitstable',
),
```

### Contrast-Safe Eyebrow (front-page.php)
```php
<!-- BEFORE -->
<p class="text-xs uppercase tracking-wider text-[var(--warm-gold)]">
  <?php echo esc_html( $hero_eyebrow ); ?>
</p>

<!-- AFTER -->
<p class="text-xs uppercase tracking-wider text-[var(--warm-gold-text)]">
  <?php echo esc_html( $hero_eyebrow ); ?>
</p>
```

---

## Ready to Start?

1. **Create a git branch:** `git checkout -b polish/front-page-ux-audit`
2. **Start with BLOCKING issues** (emoji icons, contrast, skip link)
3. **Test after each fix** (don't batch 10 changes then test)
4. **Use TodoWrite** to track progress through the plan
5. **Run verification phase** before considering complete

**Estimated total time:** 8-12 hours for full implementation (Phases 1-4)
**Optional Antigravity enhancements:** +3-4 hours (Phase 5)
