#!/usr/bin/env python3
"""Generate Restwell public-page HTML mockups from shared chrome + page bodies."""

from pathlib import Path

ROOT = Path(__file__).resolve().parent
IMG = "../assets/images"
B = f"{IMG}/bungalow"
S = f"{IMG}/stock"

PAGES = {
    "home": ("homepage-concept.html", "Home"),
    "property": ("property-concept.html", "The Property"),
    "hiw": ("how-it-works-concept.html", "How It Works"),
    "accessibility": ("accessibility-concept.html", "Accessibility"),
    "who": ("who-its-for-concept.html", "Who It’s For"),
    "pricing": ("pricing-concept.html", "Pricing"),
    "care": ("care-concept.html", "Optional care"),
    "whitstable": ("whitstable-guide-concept.html", "Whitstable"),
    "resources": ("resources-concept.html", "Funding & Support"),
    "faq": ("faq-concept.html", "FAQ"),
    "blog": ("blog-concept.html", "Blog"),
    "enquire": ("enquire-concept.html", "Enquire Now"),
    "guest": ("guest-guide-concept.html", "Guest Guide"),
    "blog_single": ("blog-single-concept.html", "Blog article"),
    "privacy": ("privacy-concept.html", "Privacy Policy"),
    "terms": ("terms-concept.html", "Terms & Conditions"),
    "a11y_policy": ("accessibility-policy-concept.html", "Website accessibility"),
    "404": ("404-concept.html", "404"),
    "page": ("page-concept.html", "Generic page"),
}

# Bungalow / booking facts — not audience or area pages
STAY = ["property", "hiw", "accessibility", "pricing"]
# Audience / area / funding / care — desktop "Plan your trip" dropdown
PLAN = ["who", "whitstable", "resources", "care"]


def cls(active, key):
    return ' class="is-active"' if active == key else ""


def aria_current(active, key):
    return ' aria-current="page"' if active == key else ""


def header(active=""):
    stay_current = " is-current" if active in STAY else ""
    plan_current = " is-current" if active in PLAN else ""
    return f'''  <a class="skip-link" href="#main-content">Skip to main content</a>

  <header class="site-header{' is-solid' if active and active != 'home' else ''}">
    <div class="container site-header__inner">
      <a class="logo" href="homepage-concept.html">Restwell</a>
      <nav aria-label="Primary">
        <ul class="nav">
          <li><a href="homepage-concept.html"{cls(active, 'home')}{aria_current(active, 'home')}>Home</a></li>
          <li class="nav__item nav__item--has-dropdown{stay_current}">
            <button type="button" class="nav__trigger" aria-expanded="false" aria-controls="nav-stay-menu" id="nav-stay-trigger">The Bungalow</button>
            <ul class="nav__dropdown" id="nav-stay-menu" role="list" aria-labelledby="nav-stay-trigger">
              <li><a href="property-concept.html"{cls(active, 'property')}{aria_current(active, 'property')}>The Property</a></li>
              <li><a href="accessibility-concept.html"{cls(active, 'accessibility')}{aria_current(active, 'accessibility')}>Accessibility</a></li>
              <li><a href="pricing-concept.html"{cls(active, 'pricing')}{aria_current(active, 'pricing')}>Pricing</a></li>
              <li><a href="how-it-works-concept.html"{cls(active, 'hiw')}{aria_current(active, 'hiw')}>How It Works</a></li>
            </ul>
          </li>
          <li class="nav__item nav__item--has-dropdown{plan_current}">
            <button type="button" class="nav__trigger" aria-expanded="false" aria-controls="nav-plan-menu" id="nav-plan-trigger">Plan your trip</button>
            <ul class="nav__dropdown" id="nav-plan-menu" role="list" aria-labelledby="nav-plan-trigger">
              <li><a href="who-its-for-concept.html"{cls(active, 'who')}{aria_current(active, 'who')}>Who It’s For</a></li>
              <li><a href="whitstable-guide-concept.html"{cls(active, 'whitstable')}{aria_current(active, 'whitstable')}>Whitstable</a></li>
              <li><a href="resources-concept.html"{cls(active, 'resources')}{aria_current(active, 'resources')}>Funding &amp; Support</a></li>
              <li><a href="care-concept.html"{cls(active, 'care')}{aria_current(active, 'care')}>Optional care</a></li>
            </ul>
          </li>
          <li><a href="faq-concept.html"{cls(active, 'faq')}{aria_current(active, 'faq')}>FAQ</a></li>
          <li><a href="blog-concept.html"{cls(active, 'blog')}{aria_current(active, 'blog')}>Blog</a></li>
        </ul>
      </nav>
      <div class="site-header__actions">
        <a class="btn btn-gold" href="enquire-concept.html">Enquire Now</a>
        <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu">
          <span class="nav-toggle__icon" aria-hidden="true"><span></span></span>
        </button>
      </div>
    </div>
    <nav class="mobile-nav" id="mobile-nav" aria-label="Mobile">
      <ul class="mobile-nav__list">
        <li><a href="homepage-concept.html"{cls(active, 'home')}>Home</a></li>
        <li><span class="mobile-nav__group-label">The Bungalow</span></li>
        <li><a href="property-concept.html"{cls(active, 'property')}>The Property</a></li>
        <li><a href="accessibility-concept.html"{cls(active, 'accessibility')}>Accessibility</a></li>
        <li><a href="pricing-concept.html"{cls(active, 'pricing')}>Pricing</a></li>
        <li><a href="how-it-works-concept.html"{cls(active, 'hiw')}>How It Works</a></li>
        <li class="mobile-nav__rule" aria-hidden="true"></li>
        <li><span class="mobile-nav__group-label">Plan your trip</span></li>
        <li><a href="who-its-for-concept.html"{cls(active, 'who')}>Who It’s For</a></li>
        <li><a href="whitstable-guide-concept.html"{cls(active, 'whitstable')}>Whitstable</a></li>
        <li><a href="resources-concept.html"{cls(active, 'resources')}>Funding &amp; Support</a></li>
        <li><a href="care-concept.html"{cls(active, 'care')}>Optional care</a></li>
        <li class="mobile-nav__rule" aria-hidden="true"></li>
        <li><span class="mobile-nav__group-label">Help</span></li>
        <li><a href="faq-concept.html"{cls(active, 'faq')}>FAQ</a></li>
        <li><a href="blog-concept.html"{cls(active, 'blog')}>Blog</a></li>
      </ul>
      <div class="mobile-nav__cta">
        <a class="btn btn-gold" href="enquire-concept.html">Enquire Now</a>
      </div>
    </nav>
  </header>
'''


def footer():
    return '''  <footer class="site-footer">
    <div class="container">
      <div class="site-footer__brand">
        <a class="logo" href="homepage-concept.html">Restwell</a>
        <p class="site-footer__partner-line">
          Care partner: <a href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer">Continuity of Care Services<span class="sr-only"> (opens in new tab)</span></a>
          <span class="site-footer__sep" aria-hidden="true">·</span>
          <a href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer">CQC inspection profile<span class="sr-only"> (opens in new tab)</span></a>
        </p>
        <p class="site-footer__partner-line">Accessible holidays, Whitstable, Kent</p>
      </div>
      <div class="site-footer__bottom">
        <nav class="site-footer__legal" aria-label="Legal">
          <a href="#" target="_blank" rel="noopener noreferrer">Access statement (PDF)<span class="sr-only"> (opens in new tab)</span></a>
          <span class="site-footer__legal-sep" aria-hidden="true">·</span>
          <a href="faq-concept.html">FAQ</a>
          <span class="site-footer__legal-sep" aria-hidden="true">·</span>
          <a href="privacy-concept.html">Privacy Policy</a>
          <span class="site-footer__legal-sep" aria-hidden="true">·</span>
          <a href="terms-concept.html">Terms &amp; Conditions</a>
          <span class="site-footer__legal-sep" aria-hidden="true">·</span>
          <a href="accessibility-policy-concept.html">Website accessibility</a>
        </nav>
        <p class="site-footer__copyright">&copy; 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.</p>
      </div>
    </div>
  </footer>
'''


def _asset_v(name):
    """Cache-bust query from file mtime so CSS/JS edits show without a hard refresh fight."""
    path = ROOT / name
    try:
        return str(int(path.stat().st_mtime))
    except OSError:
        return "0"


def shell(
    title,
    active,
    body,
    extra_css="",
    extra_js="",
    interior=True,
    after="",
    description="",
    document_title=None,
    extra_head="",
):
    body_attr = ' class="page--interior"' if interior else ""
    after_block = f"\n{after}" if after else ""
    css_v = _asset_v("shared.css")
    js_v = _asset_v("shared.js")
    doc_title = document_title if document_title else f"{title} · Restwell concept"
    desc_tag = (
        f'\n  <meta name="description" content="{description}" />' if description else ""
    )
    head_extra = f"\n{extra_head}" if extra_head else ""
    return f'''<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{doc_title}</title>{desc_tag}
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Lora:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="shared.css?v={css_v}" />
  {("<style>\n" + extra_css + "\n  </style>") if extra_css else ""}{head_extra}
</head>
<body{body_attr}>
{header(active)}
  <main id="main-content">
{body}
  </main>
{footer()}{after_block}
  <script src="shared.js?v={js_v}"></script>
  {("<script>\n" + extra_js + "\n  </script>") if extra_js else ""}
</body>
</html>
'''


def home_schema():
    """LodgingBusiness + FAQPage JSON-LD for the homepage SEO concept."""
    return '''  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "LodgingBusiness",
      "name": "Restwell",
      "description": "Wheelchair accessible holiday bungalow in Whitstable, Kent, with step-free access, accessible wet room, ceiling track hoist, off-street parking and clear access details before booking.",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Whitstable",
        "addressRegion": "Kent",
        "addressCountry": "GB"
      },
      "amenityFeature": [
        {
          "@type": "LocationFeatureSpecification",
          "name": "Step-free access",
          "value": true
        },
        {
          "@type": "LocationFeatureSpecification",
          "name": "Accessible wet room",
          "value": true
        },
        {
          "@type": "LocationFeatureSpecification",
          "name": "Ceiling track hoist",
          "value": true
        },
        {
          "@type": "LocationFeatureSpecification",
          "name": "Off-street parking",
          "value": true
        }
      ]
    },
    {
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Is Restwell suitable for wheelchair accessible holidays in the UK?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Restwell is a single-storey accessible bungalow in Whitstable, Kent, with step-free access, a wet room, ceiling track hoist, off-street parking and detailed access information available before you enquire."
          }
        },
        {
          "@type": "Question",
          "name": "Is this a disabled friendly holiday in Kent?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Restwell is designed for disabled guests, wheelchair users, carers and families who need reliable access information before booking. We avoid vague labels and publish practical details like door widths, equipment and step-free routes."
          }
        },
        {
          "@type": "Question",
          "name": "Do you offer holidays for disabled people with care support?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "You book the bungalow as a self-catering holiday stay. If you need personal care, visiting care or hoisting support, we can introduce you to a CQC-registered care partner to arrange separately."
          }
        }
      ]
    }
  ]
}
</script>'''


def hero(label, h1, lede, crumbs=None, ctas=None, h1_id="page-h", media=False):
    """Interior page intro — same .hero / .hero__content / .hero__text as homepage, no CTAs.

    media=True: show the coastal photo plane (hero--place). Default interiors stay
    solid teal — only place/area guides should opt in.
    """
    crumbs = crumbs or []
    # ctas ignored — interior heroes are copy-only; enquire lives in header / mid-cta
    crumb_html = ""
    if crumbs:
        items = []
        for i, (href, text) in enumerate(crumbs):
            if i:
                items.append('<li class="breadcrumb__sep" aria-hidden="true">/</li>')
            if href:
                items.append(f'<li><a href="{href}">{text}</a></li>')
            else:
                items.append(f'<li aria-current="page">{text}</li>')
        crumb_html = f'<ol class="breadcrumb">{"".join(items)}</ol>'
    place_cls = " hero--place" if media else ""
    media_html = '      <div class="hero__media" aria-hidden="true"></div>\n' if media else ""
    return f'''    <section class="hero hero--interior{place_cls}" aria-labelledby="{h1_id}">
{media_html}      <div class="container">
        <div class="hero__content">
          {crumb_html}
          <div class="hero__text">
            <h1 id="{h1_id}">{h1}</h1>
            <p>{lede}</p>
          </div>
        </div>
      </div>
    </section>
'''


def mid_cta(h2, p, primary=("enquire-concept.html", "Enquire Now"), secondary=None, section_id=""):
    sec = ""
    if secondary:
        sec = f'<a class="btn btn-outline-light" href="{secondary[0]}">{secondary[1]}</a>'
    id_attr = f' id="{section_id}"' if section_id else ""
    return f'''    <section class="mid-cta mid-cta--plain section-y--cta"{id_attr} aria-labelledby="mid-cta-h">
      <div class="mid-cta__media" aria-hidden="true"></div>
      <div class="mid-cta__inner">
        <h2 id="mid-cta-h">{h2}</h2>
        <p>{p}</p>
        <div class="mid-cta__btns">
          <a class="btn btn-gold" href="{primary[0]}">{primary[1]}</a>
          {sec}
        </div>
      </div>
    </section>
'''


def gallery_lightbox():
    """Dialog markup after footer — behaviour lives in shared.js."""
    return '''  <div class="lightbox" id="gallery-lightbox" hidden role="dialog" aria-modal="true" aria-label="Photo gallery">
    <button type="button" class="lightbox__close" data-lightbox-close>
      <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
        <path d="M3.2 3.2l9.6 9.6M12.8 3.2L3.2 12.8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      Close
    </button>
    <div class="lightbox__stage">
      <button type="button" class="lightbox__nav lightbox__nav--prev" data-lightbox-prev aria-label="Previous image">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M15 5L8 12l7 7" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      <figure class="lightbox__figure">
        <img class="lightbox__image" data-lightbox-image src="" alt="" decoding="async" />
      </figure>
      <button type="button" class="lightbox__nav lightbox__nav--next" data-lightbox-next aria-label="Next image">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>
    <div class="lightbox__meta">
      <p class="lightbox__status" data-lightbox-status aria-live="polite"></p>
      <p class="lightbox__caption" data-lightbox-caption></p>
    </div>
  </div>
'''


def gallery_items(images, item_class=""):
    """Build clickable gallery tiles for shared.js lightbox.

    images: iterable of (src, alt). Parent section must have data-gallery;
    page shell must include gallery_lightbox() via after=.
    item_class: optional class on each <li> (e.g. gallery__item for homepage grid).
    """
    cls = f' class="{item_class}"' if item_class else ""
    rows = []
    for i, (src, alt) in enumerate(images):
        rows.append(
            f'''          <li{cls}>
            <button type="button" class="gallery__open" data-gallery-open data-gallery-index="{i}" aria-label="View full size: {alt}">
              <img src="{src}" alt="{alt}" width="640" height="480" loading="lazy" decoding="async" />
            </button>
          </li>'''
        )
    return "\n".join(rows)


ICON_PATHS = {
    "bank": '<path d="M12 3L3 8h18L12 3zM4 21V10M20 21V10M8 10v7M12 10v7M16 10v7M3 21h18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
    "heartbeat": '<path d="M3 12h4l2-5 3 10 2-7 1.5 2H21" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
    "wallet": '<path d="M3 7.5A1.5 1.5 0 0 1 4.5 6h13A1.5 1.5 0 0 1 19 7.5V9h1.5A1.5 1.5 0 0 1 22 10.5v7A1.5 1.5 0 0 1 20.5 19h-15A2.5 2.5 0 0 1 3 16.5v-9Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="17.25" cy="14" r="1" fill="currentColor" stroke="none"/>',
    "home": '<path d="M4 11.5 12 5l8 6.5M6 10.5V19a1 1 0 0 0 1 1h3v-5h4v5h3a1 1 0 0 0 1-1v-8.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
    "people": '<circle cx="8.5" cy="8" r="2.5" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M3.5 19c0-3 2.2-5 5-5s5 2 5 5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="16.5" cy="9" r="2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M14 19c.2-2.6 1.9-4.5 4.3-4.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
    "clipboard": '<rect x="5" y="4.5" width="14" height="17" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M9 4.5V3.8A1.8 1.8 0 0 1 10.8 2h2.4A1.8 1.8 0 0 1 15 3.8v.7" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M8.5 12.2l2 2 4-4.5M8.5 17h7" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
    "building": '<path d="M4 21V6.5L12 3l8 3.5V21M9 21v-5h6v5M4 21h16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
}


def icon_circle(name, size="2.75rem"):
    """Small brand-tinted icon badge — see .icon-circle in shared.css.
    Inline SVG (not an icon font) since mockups have no font/icon dependency."""
    path = ICON_PATHS[name]
    style = f' style="--icon-circle-size: {size};"' if size != "2.75rem" else ""
    return f'<span class="icon-circle"{style} aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false">{path}</svg></span>'


def faq_item(qid, q, a, open_=False, cat=""):
    open_cls = " is-open" if open_ else ""
    exp = "true" if open_ else "false"
    hidden = "" if open_ else " hidden"
    cat_attr = f' data-cat="{cat}"' if cat else ""
    return f'''            <div class="faq-item{open_cls}"{cat_attr}>
              <button type="button" class="faq-item__trigger" aria-expanded="{exp}" id="{qid}" aria-controls="{qid}-a">
                <span>{q}</span>
                <span class="faq-item__icon" aria-hidden="true"></span>
              </button>
              <div class="faq-item__panel" id="{qid}-a" role="region" aria-labelledby="{qid}"{hidden}>
                <p>{a}</p>
              </div>
            </div>
'''


def faq_list_markup(items, *, measure=False):
    """Render FAQ items. 5+ → two real columns (desktop); 4 or fewer → single stack."""
    measure_cls = " faq-list--measure" if measure else ""
    if len(items) > 4:
        mid = (len(items) + 1) // 2
        left = "".join(faq_item(*i) for i in items[:mid])
        right = "".join(faq_item(*i) for i in items[mid:])
        return f'''          <div class="faq-list faq-list--split{measure_cls}" data-faq-accordion>
            <div class="faq-list__col">
{left}            </div>
            <div class="faq-list__col">
{right}            </div>
          </div>
'''
    faq_html = "".join(faq_item(*i) for i in items)
    return f'''          <div class="faq-list{measure_cls}" data-faq-accordion>
{faq_html}          </div>
'''


def faq_block(eyebrow, h2, items, *, h2_id="faq-h", lede="", band="band-white", layout=True, aside=""):
    """Page FAQ section. Each question must be owned by exactly one mockup page."""
    list_html = faq_list_markup(items, measure=not layout)
    lede_html = f'\n            <p class="lede">{lede}</p>' if lede else ""
    section_cls = "faq section-y" + (f" {band}" if band else "")
    if layout:
        return f'''    <section class="{section_cls}" id="faq" aria-labelledby="{h2_id}">
      <div class="container">
        <div class="faq__layout">
          <header class="faq__intro">
            <p class="eyebrow">{eyebrow}</p>
            <h2 id="{h2_id}">{h2}</h2>{lede_html}
          </header>
{list_html}{aside}        </div>
      </div>
    </section>
'''
    return f'''    <section class="{section_cls}" id="faq" aria-labelledby="{h2_id}">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">{eyebrow}</p>
          <h2 id="{h2_id}">{h2}</h2>{lede_html}
        </header>
{list_html}      </div>
    </section>
'''


# ---------------------------------------------------------------------------
# Page bodies
# ---------------------------------------------------------------------------
# FAQ ownership (no cannibalisation — one canonical page per question):
#   home         → category / Restwell fit (short)
#   how-it-works → booking process + arranging CQC care
#   pricing      → money, inclusions, guide rates
#   accessibility→ hoist, profiling bed, equipment, “wheelchair friendly”
#   who-its-for  → complex-care planning, cottage vs respite
#   resources    → CHC / direct payments / personal budget
#   whitstable   → local + Kent coast access
#   faq hub      → unique ops only + pointers (no full duplicate answers)
# ---------------------------------------------------------------------------

def body_home():
    return f'''    <section class="hero" aria-labelledby="hero-h">
      <div class="hero__media" aria-hidden="true"></div>
      <div class="container">
        <div class="hero__content">
          <div class="hero__text">
            <p class="eyebrow eyebrow--on-dark">Whitstable, Kent</p>
            <h1 id="hero-h">Wheelchair accessible holidays by the Kent coast</h1>
            <p>A private accessible bungalow in Whitstable, Kent, with clear access details — plan your wheelchair accessible holiday first, then enquire when you’re ready.</p>
          </div>
          <div class="hero__ctas">
            <a class="btn btn-gold" href="property-concept.html">View the property</a>
            <a class="btn btn-outline-light" href="enquire-concept.html">Enquire</a>
          </div>
          <p class="hero__note">We usually reply within 48 hours — no pressure to book</p>
        </div>
      </div>
    </section>

    <section class="property section-y" id="property" aria-labelledby="property-h">
      <div class="container">
        <div class="property__layout">
          <div class="property__media" role="img" aria-label="Restwell bungalow exterior on Russell Drive"></div>
          <div class="property__copy">
            <p class="eyebrow">The Bungalow</p>
            <h2 id="property-h">An accessible holiday bungalow with access described in plain English</h2>
            <p class="lede">Restwell is designed for wheelchair accessible holidays in the UK. The bungalow gives disabled guests, carers and families a private coastal base in Whitstable, Kent — with plain-English measurements published before you book.</p>
            <ul class="property__facts">
              <li>Ceiling track hoist in the bedroom</li>
              <li>Accessible wet room</li>
              <li>Step-free entry and off-street parking</li>
            </ul>
            <div class="property__cta-row">
              <a class="btn btn-gold" href="property-concept.html">View the property</a>
              <a class="btn btn-outline-teal" href="accessibility-concept.html">Read the access statement</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="gallery section-y" aria-labelledby="gallery-h" data-gallery>
      <div class="container">
        <header class="section-head section-head--center section-head--tight">
          <p class="eyebrow">Inside the property</p>
          <h2 id="gallery-h">A glimpse of the space</h2>
          <button type="button" class="text-link" data-gallery-open data-gallery-index="0">View photos</button>
        </header>
        <ul class="gallery__grid" role="list" aria-label="Property photo preview">
{gallery_items([
            (f"{B}/living-room-2.png", "Open-plan living room with wide, step-free walkways between furniture"),
            (f"{B}/BD2-3-LS.jpg", "Accessible bedroom with ceiling track and mobile hoist"),
            (f"{B}/wet-room-shower.png", "Level-access wet room shower with grab rails and fold-down seat"),
        ], item_class="gallery__item")}
        </ul>
      </div>
    </section>

    <section class="paths section-y" id="paths" aria-labelledby="paths-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Plan your trip</p>
          <h2 id="paths-h">Where you’ll be, and how stays are often funded</h2>
          <p class="lede">Two clear next steps. Care options stay separate, later on this page.</p>
        </header>
        <div class="paths__grid">
          <article class="path-card path-card--area">
            <h3>Whitstable &amp; the Kent coast</h3>
            <p>Harbour, promenade, and day trips with realistic access notes: routes and venues described clearly, not labelled vaguely “wheelchair friendly”.</p>
            <a class="text-link" href="whitstable-guide-concept.html">Explore the area</a>
          </article>
          <article class="path-card path-card--funding">
            <h3>Funding your stay</h3>
            <p>Personal budgets, direct payments, NHS Continuing Healthcare, or local authority funding: what to ask, and what paperwork helps.</p>
            <a class="text-link" href="resources-concept.html">Read funding guides</a>
          </article>
        </div>
      </div>
    </section>

    <section class="partners section-y" id="partners" aria-labelledby="partners-h">
      <div class="container">
        <header class="section-head partners__head">
          <p class="eyebrow">Trusted partners</p>
          <h2 id="partners-h">Specialist partners</h2>
          <p class="lede">The teams behind Restwell: adaptation, equipment, and specialist training that made the property what it is.</p>
        </header>
        <ul class="partners__grid" role="list">
          <li class="partners__item">
            <a class="partners__link" href="https://www.carespaces.co.uk/" target="_blank" rel="noopener noreferrer">
              <img src="../assets/images/partners/care-spaces.png" alt="Care Spaces" width="180" height="72" loading="lazy" decoding="async" />
              <span class="sr-only"> (opens in new tab)</span>
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://thorcarpenter.co.uk/" target="_blank" rel="noopener noreferrer">
              <img src="../assets/images/partners/thor-carpentry.png" alt="Thor Carpentry" width="180" height="72" loading="lazy" decoding="async" />
              <span class="sr-only"> (opens in new tab)</span>
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://www.wealdenrehab.com/" target="_blank" rel="noopener noreferrer">
              <img src="../assets/images/partners/wealden-rehab.png" alt="Wealden Rehab" width="180" height="72" loading="lazy" decoding="async" />
              <span class="sr-only"> (opens in new tab)</span>
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer">
              <img src="../assets/images/partners/continuity-of-care-services.png" alt="Continuity of Care Services" width="180" height="72" loading="lazy" decoding="async" />
              <span class="sr-only"> (opens in new tab)</span>
            </a>
          </li>
          <li class="partners__item">
            <a class="partners__link" href="https://www.continuitytrainingacademy.co.uk/" target="_blank" rel="noopener noreferrer">
              <img src="../assets/images/partners/continuity-training-academy.png" alt="Continuity Training Academy" width="180" height="72" loading="lazy" decoding="async" />
              <span class="sr-only"> (opens in new tab)</span>
            </a>
          </li>
        </ul>
      </div>
    </section>

    <section class="comparison section-y" id="comparison" aria-labelledby="comparison-h">
      <div class="container">
        <header class="section-head section-head--center">
          <p class="eyebrow">Compare options</p>
          <h2 id="comparison-h">How Restwell is different</h2>
          <p class="lede">The same three questions most guests ask us before booking anywhere.</p>
        </header>
        <dl class="comparison-list">
          <div class="comparison-list__item">
            <dt>Access information</dt>
            <dd>
              Door widths, hoist limits, and step-free routes are published before you book.
              <span class="comparison-list__contrast">Most hotels only confirm a room’s measurements once you arrive.</span>
            </dd>
          </div>
          <div class="comparison-list__item">
            <dt>Privacy</dt>
            <dd>
              A whole private bungalow, just your group, for the length of your stay.
              <span class="comparison-list__contrast">Hotels mean shared corridors, lifts, and public spaces with other guests.</span>
            </dd>
          </div>
          <div class="comparison-list__item">
            <dt>Care support</dt>
            <dd>
              Optional, CQC-regulated support, arranged only if you want it.
              <span class="comparison-list__contrast">Not offered elsewhere — you’d need to arrange everything yourself.</span>
            </dd>
          </div>
        </dl>
      </div>
    </section>

    <section class="testimonials section-y" aria-labelledby="testimonials-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow eyebrow--on-dark">What guests say</p>
          <h2 id="testimonials-h">Real stays, real access notes</h2>
        </header>
        <ul class="testimonials__grid" role="list">
          <li>
            <article class="testimonial-card">
              <blockquote class="testimonial-card__quote">Keelie was tremendously helpful in explaining all the facilities, equipment and care help they could provide. The bungalow is modern and spotless — fully equipped for both the person you are caring for, and for the carer. It was a home from home.</blockquote>
              <footer class="testimonial-card__name">M.H.<span class="testimonial-card__role">Family carer · Facebook review</span></footer>
            </article>
          </li>
          <li>
            <article class="testimonial-card">
              <blockquote class="testimonial-card__quote">From the minute I rolled my wheelchair out the car, I smiled. Widened hallways, ceiling track hoist, a wet room that should be in a gallery. With the complex care I need, this is worth its weight in gold.</blockquote>
              <footer class="testimonial-card__name">M.P.<span class="testimonial-card__role">Wheelchair user · Google review</span></footer>
            </article>
          </li>
        </ul>
      </div>
    </section>

    <section class="care section-y" id="care" aria-labelledby="care-h">
      <div class="container">
        <div class="care__panel">
          <div class="care__intro">
            <header class="section-head">
              <p class="eyebrow">If you need support while you stay</p>
              <h2 id="care-h">Optional care, close to your booking</h2>
            </header>
            <div class="care__intro-body">
              <p class="lede">You book the bungalow with Restwell. Professional care is not included in that price. Continuity of Care Services is our sister company on the same phone line, so if you need regulated support we can often talk it through on the same call.</p>
              <p class="lede">Continuity is registered with the CQC. Restwell itself is a holiday stay, not a CQC-registered care service.</p>
            </div>
          </div>
          <ul class="care__types" aria-label="What Continuity can arrange">
            <li>
              <span class="care__type-title">Personal care</span>
              <span class="care__type-text">Support with washing, dressing and daily routines.</span>
            </li>
            <li>
              <span class="care__type-title">Visiting care</span>
              <span class="care__type-text">Friendly check-ins, or support getting out into the community.</span>
            </li>
            <li>
              <span class="care__type-title">Mobility and hoisting</span>
              <span class="care__type-text">Safe transfers and moving support from trained carers.</span>
            </li>
          </ul>
          <div class="care__foot">
            <p class="care__note">Additional or complex care can be arranged subject to assessment. Nothing is added until you have agreed what support you want. <a class="text-link" href="care-concept.html">Learn more about optional care</a></p>
            <div class="care__brand" aria-label="Care partner and CQC rating">
              <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer">
                <img src="../assets/images/partners/continuity-of-care-services-long.png" alt="Continuity of Care Services" width="405" height="69" loading="lazy" decoding="async" />
                <span class="sr-only"> (opens in new tab)</span>
              </a>
              <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer">
                <img src="../assets/images/partners/cqc-rating-good.jpg" alt="CQC rating Good — Continuity of Care Services" width="710" height="399" loading="lazy" decoding="async" />
                <span class="sr-only"> (opens in new tab)</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

{faq_block(
        "Quick answers",
        "Common questions",
        [
            ("home-q1", "Is Restwell suitable for wheelchair accessible holidays in the UK?", "Yes. Restwell is a private step-free bungalow in Whitstable, Kent, with a ceiling track hoist, profiling bed, level-access wet room, driveway parking, and plain-English measurements published before you enquire.", True),
            ("home-q2", "What makes accessible self-catering work well?", "Independence, privacy, and specialist adaptations that match your equipment — stated in numbers, not vague “wheelchair friendly” labels. Restwell includes listed on-site access kit in the bungalow rate."),
            ("home-q3", "Is this disabled holiday accommodation in Kent?", "Yes — a specialist accessible bungalow for disabled guests, carers and families who need reliable access information before booking. Door widths, hoist and wet-room details live on the Accessibility page."),
        ],
        lede="Short answers about whether Restwell fits. Open a question, or browse the full FAQ for equipment, care and funding.",
        band="",
        aside='''          <aside class="faq-cta" aria-label="More questions">
            <div class="faq-cta__copy">
              <p class="faq-cta__title">More questions?</p>
              <p class="faq-cta__text">Browse by topic — each answer lives on one page only.</p>
            </div>
            <a class="text-link" href="faq-concept.html">Browse all FAQs</a>
          </aside>
''',
    )}
{mid_cta("Ready to check dates?", "Tell us your needs. We reply with measurements, equipment, and next steps. No pressure to book.", secondary=("accessibility-concept.html", "Read the access statement"), section_id="enquire")}
'''


def body_index():
    items = [
        ("homepage-concept.html", "Homepage", "Combined homepage concept (shared chrome)"),
        ("property-concept.html", "The Property", "Rooms, capacity, gallery, care, location"),
        ("how-it-works-concept.html", "How It Works", "Four steps, included, booking FAQ"),
        ("accessibility-concept.html", "Accessibility", "Room-by-room + equipment gallery"),
        ("who-its-for-concept.html", "Who It’s For", "Audiences, care options, funding"),
        ("pricing-concept.html", "Pricing", "Rates, included, funding, care guides, FAQ"),
        ("care-concept.html", "Optional care", "Continuity, what can be arranged, how it works"),
        ("whitstable-guide-concept.html", "Whitstable guide", "Travel, walks, parking, eat"),
        ("resources-concept.html", "Funding & Support", "Route cards, grants, contacts"),
        ("faq-concept.html", "FAQ", "Category filters + accordion"),
        ("enquire-concept.html", "Enquire", "Multi-step form + sidebar"),
        ("guest-guide-concept.html", "Guest Guide", "OTP gate + authenticated sections"),
        ("blog-concept.html", "Blog index", "Featured + grid + empty state"),
        ("blog-single-concept.html", "Blog single", "Article hero, prose, related"),
        ("privacy-concept.html", "Privacy Policy", "Legal prose"),
        ("terms-concept.html", "Terms & Conditions", "Legal prose"),
        ("accessibility-policy-concept.html", "Website accessibility", "Digital a11y policy"),
        ("404-concept.html", "404", "Helpful links"),
        ("page-concept.html", "Generic page", "Default page fallback"),
    ]
    lis = "\n".join(
        f'          <li><a href="{href}"><strong>{title}</strong><span>{desc}</span></a></li>'
        for href, title, desc in items
    )
    return f'''{hero("Mockup directory", "Public page concepts", "HTML-only reviews matching the homepage concept system. Open any page to browse with shared nav.")}
    <section class="section-y band-white">
      <div class="container">
        <ul class="index-list">
{lis}
        </ul>
      </div>
    </section>
'''


def body_property():
    return f'''{hero("The Property", "101 Russell Drive", "Yours alone for the stay — single-storey and step-free, with ceiling hoist, roll-in wet room, and published door widths already in place.", [("homepage-concept.html", "Home"), (None, "The Property")])}
    <nav class="subnav" aria-label="On this page">
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#bedroom">Bedroom</a></li>
          <li><a href="#wetroom">Wet room</a></li>
          <li><a href="#living">Living</a></li>
          <li><a href="#garden">Garden</a></li>
          <li><a href="#photos">Photos</a></li>
          <li><a href="#capacity">Kit</a></li>
          <li><a href="#care">Care</a></li>
          <li><a href="#location">Location</a></li>
        </ul>
      </div>
    </nav>
    <section class="section-y band-white" id="bedroom">
      <div class="container split">
        <div class="split__media">
          <img src="{B}/BD2-6-LS.jpg" alt="Amico ceiling track hoist in the accessible bedroom" width="900" height="675" loading="lazy" />
        </div>
        <div>
          <header class="section-head">
            <p class="eyebrow">Bedrooms</p>
            <h2>Ceiling hoist and profiling beds</h2>
            <p class="lede">The accessible bedroom has profiling beds with a full-room ceiling track hoist and TV. A mobile hoist and Sara Stedy are available. The second bedroom has a double bed. Conservatory sofa bed brings capacity to five.</p>
          </header>
        </div>
      </div>
    </section>
    <section class="section-y band-subtle" id="wetroom">
      <div class="container split split--flip">
        <div class="split__media">
          <img src="{B}/WR-1-LS.jpg" alt="Level-access wet room with grab rails" width="900" height="675" loading="lazy" />
        </div>
        <div>
          <header class="section-head">
            <p class="eyebrow">Wet room</p>
            <h2>Roll-in shower with adjustable basin</h2>
            <p class="lede">Step-free shower, grab rails, shower and commode chairs, tilt-in-space chair, and a height-adjustable wheel-under basin. Geberit AquaClean wash-dry WC. Please only flush toilet paper — plumbing is sensitive.</p>
          </header>
        </div>
      </div>
    </section>
    <section class="section-y band-white" id="living">
      <div class="container split">
        <div class="split__media">
          <img src="{B}/LR-1-LS.jpg" alt="Open-plan living area with wide walkways" width="900" height="675" loading="lazy" />
        </div>
        <div>
          <header class="section-head">
            <p class="eyebrow">Living &amp; kitchen</p>
            <h2>Wheel-under kitchen and open-plan living</h2>
            <p class="lede">Sofas, a rise-and-recline chair, dining table, TV and fireplace open into a kitchen with a lowered wheel-under worksurface. The conservatory has a sofa bed, laundry, and level routes to the patio.</p>
          </header>
          <p><a class="text-link" href="accessibility-concept.html">See access details</a></p>
        </div>
      </div>
    </section>
    <section class="section-y band-subtle" id="garden">
      <div class="container split split--flip">
        <div class="split__media">
          <img src="{B}/PT-1-LS.jpg" alt="Level patio and garden beyond French doors" width="900" height="675" loading="lazy" />
        </div>
        <div>
          <header class="section-head">
            <p class="eyebrow">Outside</p>
            <h2>Private drive, patio and step-free garden</h2>
            <p class="lede">French doors open onto a level patio via a non-slip threshold ramp. Enclosed lawn, BBQ area, and driveway parking for two. Portable fold-up ramps are available for the front door if you need them out and about.</p>
          </header>
        </div>
      </div>
    </section>
    <section class="section-y band-white" id="photos" data-gallery>
      <div class="container">
        <header class="section-head section-head--center">
          <p class="eyebrow">Photos</p>
          <h2>A look inside</h2>
        </header>
        <ul class="gallery-grid" role="list" aria-label="Property photos">
{gallery_items([
            (f"{B}/wet-room-shower.png", "Wet room shower"),
            (f"{B}/BD2-3-LS.jpg", "Accessible bedroom with ceiling track and mobile hoist"),
            (f"{B}/KT-1-LS.jpg", "Kitchen"),
            (f"{B}/living-room-2.png", "Living room"),
            (f"{B}/GRDEN-1-LS.jpg", "Garden"),
            (f"{B}/EX-1-LS.jpg", "Exterior of the Restwell bungalow on Russell Drive"),
        ])}
        </ul>
      </div>
    </section>
    <section class="section-y band-subtle" id="capacity" aria-labelledby="capacity-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Kit &amp; layout</p>
          <h2 id="capacity-h">Space to live — and the kit that travels with you</h2>
          <p class="lede">Access measurements and equipment notes published before you enquire.</p>
        </header>
        <dl class="comparison-list">
          <div class="comparison-list__item">
            <dt>Access</dt>
            <dd>Step-free throughout. Front doorway 965mm clear, internals 926mm. Ceiling track hoist over the profiling bed.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Sleeping</dt>
            <dd>Accessible bedroom with profiling bed and pressure-relieving mattress. Second double bedroom. Conservatory sofa bed for a fifth guest.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Practical</dt>
            <dd>Driveway parking for two cars. Reachable kitchen worktops. High-speed broadband throughout the bungalow.</dd>
          </div>
        </dl>
      </div>
    </section>
    <section class="care section-y" id="care" aria-labelledby="care-h">
      <div class="container">
        <div class="care__panel">
          <div class="care__intro">
            <header class="section-head">
              <p class="eyebrow">If you need support while you stay</p>
              <h2 id="care-h">Optional care, separate from your booking</h2>
            </header>
            <div class="care__intro-body">
              <p class="lede">You book the bungalow with Restwell. Professional care is not included. If you want regulated support on the Kent coast, we can introduce Continuity of Care Services. You agree that directly with them.</p>
              <p class="lede">Continuity is registered with the CQC. Restwell itself is a holiday stay, not a CQC-registered care service. Bring your own team if you prefer.</p>
              <p><a class="text-link" href="who-its-for-concept.html">Explore care options</a></p>
            </div>
          </div>

          <ul class="care__types" aria-label="What Continuity can arrange">
            <li>
              <span class="care__type-title">Personal care</span>
              <span class="care__type-text">Support with washing, dressing and daily routines.</span>
            </li>
            <li>
              <span class="care__type-title">Visiting care</span>
              <span class="care__type-text">Friendly check-ins, or support getting out into the community.</span>
            </li>
            <li>
              <span class="care__type-title">Mobility and hoisting</span>
              <span class="care__type-text">Safe transfers and moving support from trained carers.</span>
            </li>
          </ul>

          <div class="care__foot">
            <p class="care__note">Additional or complex care can be arranged subject to assessment. Nothing is added until you have agreed what support you want.</p>
            <div class="care__brand" aria-label="Care partner and CQC rating">
              <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer">
                <img
                  src="{IMG}/partners/continuity-of-care-services-long.png"
                  alt="Continuity of Care Services"
                  width="405"
                  height="69"
                  loading="lazy"
                  decoding="async"
                />
                <span class="sr-only"> (opens in new tab)</span>
              </a>
              <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer">
                <img
                  src="{IMG}/partners/cqc-rating-good.jpg"
                  alt="CQC rating Good — Continuity of Care Services"
                  width="710"
                  height="399"
                  loading="lazy"
                  decoding="async"
                />
                <span class="sr-only"> (opens in new tab)</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section-y band-white" id="location">
      <div class="container split">
        <div>
          <header class="section-head">
            <p class="eyebrow">Location</p>
            <h2>Quiet street, level coast nearby</h2>
            <p class="lede">About 15 minutes’ level walk to Tankerton promenade and Whitstable town centre; 20–30 minutes to the station. Canterbury, Faversham and Herne Bay are easy by car.</p>
          </header>
          <p><a class="text-link" href="whitstable-guide-concept.html">Read the Whitstable guide</a></p>
        </div>
        <div class="split__media">
          <img src="{B}/WHIT-SEAFRONT-1-LS.jpg" alt="Whitstable seafront" width="900" height="675" loading="lazy" />
        </div>
      </div>
    </section>
{mid_cta("Check dates for this bungalow", "Tell us who’s travelling and your dates. We reply with measurements, equipment notes, and next steps — usually within 48 hours.", secondary=("accessibility-concept.html", "Read accessibility details"))}
'''


def body_hiw():
    return f'''{hero("How it works", "How your accessible stay works", "A clear path from first question to arrival: share needs, confirm dates, optional care, then settle in.", [("homepage-concept.html", "Home"), (None, "How It Works")])}
    <section class="section-y band-white process" id="process" aria-labelledby="process-h">
      <div class="container">
        <div class="split">
          <div class="process-copy">
            <header class="section-head section-head--tight">
              <p class="eyebrow">The process</p>
              <h2 id="process-h">Straightforward from start to finish</h2>
              <p class="lede">Four steps from first question to arrival. No online checkout maze, and no pressure to commit before you’ve seen the access details in writing.</p>
            </header>
            <ol class="process-list">
              <li>
                <span class="process-list__index" aria-hidden="true">01</span>
                <div class="process-list__body">
                  <h3>Enquire</h3>
                  <p class="process-list__meta">Start here</p>
                  <p>Share dates and access needs. No pressure to book.</p>
                </div>
              </li>
              <li>
                <span class="process-list__index" aria-hidden="true">02</span>
                <div class="process-list__body">
                  <h3>Confirm</h3>
                  <p class="process-list__meta">We reply</p>
                  <p>We confirm what’s in the house and talk through care options if you want them.</p>
                </div>
              </li>
              <li>
                <span class="process-list__index" aria-hidden="true">03</span>
                <div class="process-list__body">
                  <h3>Book</h3>
                  <p class="process-list__meta">When you’re ready</p>
                  <p>A 50% deposit secures your dates. Balance due one week before arrival.</p>
                </div>
              </li>
              <li>
                <span class="process-list__index" aria-hidden="true">04</span>
                <div class="process-list__body">
                  <h3>Arrive</h3>
                  <p class="process-list__meta">Arrival day</p>
                  <p>Key-safe check-in from 3pm. Step-free house ready for your party.</p>
                </div>
              </li>
            </ol>
          </div>
          <div class="split__media" data-reveal>
            <img src="{B}/double-entrance-doors-open.png" alt="Open front door and step-free conservatory entrance at the Restwell bungalow" width="900" height="675" loading="lazy" />
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-teal" id="care" aria-labelledby="care-h">
      <div class="container">
        <div class="split">
          <div class="band-teal__stack">
            <p class="eyebrow eyebrow--on-dark">Optional care</p>
            <h2 id="care-h">Care fits around your routine</h2>
            <p class="lede">CQC-regulated support from Continuity of Care Services, our sister company on the same phone line. Morning check-ins through to overnight care. Only added if you want it. Bring your own team if you prefer.</p>
            <ul class="checklist">
              <li><strong>Personal care:</strong> daily routines on your schedule</li>
              <li><strong>Visiting care:</strong> check-ins and community outings</li>
              <li><strong>Mobility &amp; hoisting:</strong> safe transfers from trained carers</li>
            </ul>
            <div class="band-teal__actions">
              <a class="btn btn-gold" href="care-concept.html">Learn about optional care</a>
              <a class="btn btn-outline-light" href="enquire-concept.html">Ask about care options</a>
            </div>
          </div>
          <div class="split__media" data-reveal>
            <img src="{B}/H-1-LS.jpg" alt="Ceiling track hoist on site for mobility support during a stay" width="900" height="675" loading="lazy" />
          </div>
        </div>
      </div>
    </section>

{faq_block(
        "Booking &amp; care",
        "Before you enquire",
        [
            ("hiw-q1", "How do I book a stay?", "Send an enquiry with your dates and access needs. We’ll confirm availability and what the house offers, then send booking details. A 50% deposit secures the dates.", True, "booking"),
            ("hiw-q2", "How can I pay for the bungalow?", "Bank transfer (BACS) or debit/credit card. Balance is due no later than one week before arrival. Care, if arranged, is quoted and paid separately with Continuity.", False, "booking"),
            ("hiw-q3", "Can a local authority or NHS team book for me?", "Yes. We invoice the same rates regardless of funding route. Tell us who should receive the invoice when you enquire. Funding pathways are explained on Funding &amp; Support.", False, "funding"),
            ("hiw-q4", "Can I arrange CQC-regulated care while on holiday in the UK?", "Yes. Bring your usual team, or arrange cover with a local CQC-registered provider. At Restwell, optional care is with Continuity of Care Services after a free conversation — never bundled into the bungalow price. Restwell itself is a holiday let, not a CQC-registered care home.", False, "care"),
            ("hiw-q5", "How do I get professional care support during a self-catering holiday?", "Enquire with dates and needs on the usual Restwell number. Continuity is our sister company on the same phone line, so care can often start on the same call. Guide rates are on the Pricing page.", False, "care"),
            ("hiw-q6", "What does CQC care mean in a holiday context?", "Support from a provider registered and inspected by the Care Quality Commission — not informal or unregistered help. On holiday that still means assessment, agreed tasks, and accountability. Continuity is our regulated care partner.", False, "care"),
            ("hiw-q7", "How do I find a care provider for a UK holiday?", "Check CQC registration and rating, whether they cover the holiday postcode, assessment lead time, sleep-in vs waking night capacity, and how the care plan travels. Align care start dates with the property booking. We can introduce Continuity for Whitstable stays.", False, "care"),
            ("hiw-q8", "What is regulated care support on a holiday?", "A registered provider delivering assessed support in ordinary accommodation — a private bungalow rather than a care home. Done well it feels domestic: agreed visit times and familiar routines, with the house remaining yours.", False, "care"),
        ],
        lede="How booking works, and how optional CQC care can sit alongside a self-catering stay.",
    )}
{mid_cta("Ready to check dates?", "Tell us what you need. We reply with measurements, equipment notes, and next steps.", secondary=("property-concept.html", "View the property"))}
'''


def body_accessibility():
    return f'''{hero("Accessibility", "Wheelchair accessible holiday cottage", "Published access details: ceiling hoist, level-access wet room, 965mm front / 926mm internal doors, and driveway parking — so you can plan before you book.", [("homepage-concept.html", "Home"), (None, "Accessibility")])}
    <section class="section-y band-white">
      <div class="container">
        <div class="stat-row">
          <div class="stat"><p class="stat__value">965mm</p><p class="stat__label">Clear opening, front door</p></div>
          <div class="stat"><p class="stat__value">926mm</p><p class="stat__label">Clear width, internal doors</p></div>
          <div class="stat"><p class="stat__value">Full-room</p><p class="stat__label">Ceiling track hoist over the bed</p></div>
        </div>
      </div>
    </section>

    <section class="section-y band-white">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Room by room</p>
          <h2>What you’ll find</h2>
        </header>
        <div class="card-grid card-grid--3">
          <article class="media-card"><img src="{B}/FD-1-LS.jpg" alt="Front door with a wide, level threshold" width="640" height="480" loading="lazy" decoding="async" /><h3>Arrival &amp; entrance</h3><p>Private driveway for two; step-free path to front door; 965mm clear opening; level threshold. Portable ramps available for the front if needed.</p></article>
          <article class="media-card"><img src="{B}/LR-2-LS.jpg" alt="Open-plan living space with wide, clutter-free routes" width="640" height="480" loading="lazy" decoding="async" /><h3>Inside the property</h3><p>Single storey throughout. Internal doorways 926mm clear. Wide hall routes kept free of clutter.</p></article>
          <article class="media-card"><img src="{B}/BD1-1-LS.jpg" alt="Accessible bedroom with a profiling bed" width="640" height="480" loading="lazy" decoding="async" /><h3>Bedrooms &amp; sleeping</h3><p>Profiling beds, pressure-relieving mattress, full-room ceiling track hoist. Mobile hoist and Sara Stedy available. Second bedroom double; conservatory sofa bed.</p></article>
          <article class="media-card"><img src="{B}/WR-1-LS.jpg" alt="Level-access wet room with grab rails" width="640" height="480" loading="lazy" decoding="async" /><h3>Wet room</h3><p>Level-access shower, grab rails, shower chair, height-adjustable basin, wash-dry WC. Adapted with Care Spaces.</p></article>
          <article class="media-card"><img src="{B}/KT-1-LS.jpg" alt="Kitchen with a reachable, wheel-under worksurface" width="640" height="480" loading="lazy" decoding="async" /><h3>Kitchen</h3><p>Fully equipped with reachable and wheel-under worksurfaces. Gas hob (not induction) — tell us if that affects your plans.</p></article>
          <article class="media-card"><img src="{B}/GRDEN-1-LS.jpg" alt="Level garden and patio beyond the conservatory" width="640" height="480" loading="lazy" decoding="async" /><h3>Outdoor spaces</h3><p>Threshold ramp to level patio and enclosed garden; BBQ area; French doors from the conservatory.</p></article>
        </div>
        <div class="card-grid card-grid--2 u-mt-8">
          <article class="info-card info-card--sand"><h3>Specific requirement?</h3><p>Email what you need early. We can’t promise every aid on short notice, but we’d rather hear from you than have you worry.</p><a class="text-link" href="enquire-concept.html">Send details</a></article>
          <article class="info-card info-card--sand"><h3>Need precise measurements?</h3><p>Door widths and key specs are published here. If you need unpublished clearances, ask and we will measure.</p><a class="text-link" href="enquire-concept.html">Request measurements</a></article>
        </div>
      </div>
    </section>
    <section class="section-y band-subtle" data-gallery>
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Equipment</p>
          <h2>Installed and ready</h2>
          <p class="lede">Equipment is set up around the needs you share when you book. Tell us straight away if anything feels loose or wrong.</p>
        </header>
        <ul class="gallery-grid" role="list" aria-label="Access equipment photos">
{gallery_items([
            (f"{B}/H-1-LS.jpg", "Ceiling track hoist in situ"),
            (f"{B}/RAR-2-LS.jpg", "Rise and recline chair"),
            (f"{B}/WR-2-LS.jpg", "Wet room grab rails and shower"),
            (f"{B}/EQU-2-LS.jpg", "Access equipment in the bedroom"),
            (f"{B}/adjustable-sink.png", "Height-adjustable basin"),
            (f"{B}/exterior-ramp.png", "Exterior threshold ramp"),
        ])}
        </ul>
      </div>
    </section>
    <section class="section-y band-white">
      <div class="container split">
        <div class="split__media">
          <img src="{S}/restwell-whitstable-coastal-pathway.webp" alt="Flat, paved coastal pathway along Tankerton promenade" width="900" height="675" loading="lazy" decoding="async" />
        </div>
        <div>
          <header class="section-head">
            <p class="eyebrow">Whitstable honestly</p>
            <h2>What to expect locally</h2>
          </header>
          <ul class="checklist">
            <li><strong>The good:</strong> Tankerton promenade is flat and paved for miles. Marine Parade parking, harbour accessible WCs, and many flatter streets in town.</li>
            <li><strong>The challenge:</strong> Harbour Street pavements can be narrow; some shop entrances are stepped; harbour surfaces can be uneven.</li>
            <li><strong>The reality:</strong> The shingle beach itself is not wheelchair-friendly. The promenade above is the accessible coastal route.</li>
          </ul>
        </div>
      </div>
    </section>
    <section class="section-y band-subtle" id="statement">
      <div class="container split">
        <div>
          <header class="section-head section-head--tight">
            <p class="eyebrow">Document</p>
            <h2>Access statement</h2>
            <p class="lede">The fuller PDF for planners who need measurements and equipment notes beyond the page summary.</p>
          </header>
          <ul class="checklist">
            <li>Door widths and clearances</li>
            <li>Wet-room and hoist notes</li>
            <li>Parking and approach</li>
            <li>On-site equipment list</li>
          </ul>
        </div>
        <aside class="download-panel">
          <h3>Download the PDF</h3>
          <p>One printable document — share it with an OT, carer, or anyone helping you plan the trip.</p>
          <a class="btn btn-outline-teal" href="#" target="_blank" rel="noopener noreferrer">Access statement (PDF)<span class="sr-only"> (opens in new tab)</span></a>
        </aside>
      </div>
    </section>
{faq_block(
        "Equipment &amp; access",
        "Access FAQ",
        [
            ("a11y-q1", "Can I find a holiday cottage with a ceiling hoist in England?", "Yes — they are uncommon. Confirm fixed ceiling track vs mobile only, coverage, safe working load, sling policy, and bed position under the track. Restwell has a ceiling track hoist over the profiling bed; full specs are on this page.", True),
            ("a11y-q2", "What is a ceiling track hoist in holiday accommodation?", "A hoist permanently fitted to the ceiling that moves a person in a sling along a rail — often safer and less bulky than a mobile hoist. Guests usually bring their own slings. Ask about coverage and who may operate it before arrival."),
            ("a11y-q3", "What should I check before booking a hoist-equipped holiday let?", "Hoist type and SWL, bed under the track, same-level wet-room access, space for a second carer, parking, and what is included versus hire. Restwell includes listed on-site hoist and wet-room kit in the bungalow rate."),
            ("a11y-q4", "Can I find a holiday cottage with a profiling bed in the UK?", "Yes — confirm the bed is on site, not only “available to hire.” Ask about mattress type, dimensions, transfer height, and hoist clearance. Restwell’s accessible bedroom includes a profiling bed with a pressure-relieving mattress."),
            ("a11y-q5", "Can I find a holiday cottage with a hospital-style or profiling bed?", "People searching “hospital bed holiday cottage” usually need an adjustable profiling bed with safe transfer height — in a normal bedroom, not a clinical ward. That is what Restwell provides, with the ceiling track over the bed."),
            ("a11y-q6", "Why does an adjustable or profiling bed matter on an accessible holiday?", "For positioning, pressure care, safer transfers, and overnight care routines when a fixed divan is not safe. Check controls, side-rail policy, and carer space beside the bed."),
            ("a11y-q7", "What accessible equipment should I expect in a specialist holiday let?", "A published inventory: profiling or adjustable bed, ceiling or mobile hoist, level-access wet room with seat and grab rails, height-adjustable basin where fitted, threshold ramps, and parking notes. Never assume “accessible” means a hoist is fitted."),
            ("a11y-q8", "What should “wheelchair friendly holiday cottage” actually mean?", "Step-free routes, usable door widths for your chair, a bathroom you can use, and parking that works — in millimetres and photos. If a listing only says “wheelchair friendly,” ask for an access statement or walk away."),
            ("a11y-q9", "What do I need to check before booking an accessible holiday cottage?", "Clear door openings, step-free route from parking, wet room vs adapted bath, hoist type, bed type, turning space, recent entrance and bathroom photos, sling policy, and whether care can be arranged separately."),
            ("a11y-q10", "What makes an accessible bungalow in the UK suitable for complex needs?", "Single storey helps, but complex needs also need doorway widths, wet room, parking, and often a hoist and profiling bed. Restwell is step-free throughout with those published on this page."),
        ],
        lede="Ceiling hoist, profiling beds, wet room and what “wheelchair friendly” should mean before you book.",
        band="band-white",
    )}
{mid_cta("Still weighing suitability?", "Ask about your equipment, doorway clearances, or care needs — we’ll answer straight.", secondary=("property-concept.html", "Tour the property"))}
'''




def body_who():
    return f'''{hero("Who it’s for", "Is Restwell right for your stay?", "Built for guests and families, carers, OTs, and commissioners planning funded short breaks — with published access specs and optional care.", [("homepage-concept.html", "Home"), (None, "Who It’s For")])}
    <nav class="subnav" aria-label="On this page">
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#situations">Situations</a></li>
          <li><a href="#access">Access</a></li>
          <li><a href="#care">Care</a></li>
          <li><a href="#funding">Funding</a></li>
          <li><a href="#next">Next steps</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y band-white" id="situations" aria-labelledby="situations-h">
      <div class="container split">
        <div>
          <header class="section-head section-head--tight">
            <p class="eyebrow">Your situation</p>
            <h2 id="situations-h">Who Restwell is built for</h2>
            <p class="lede">Four kinds of visit, one house that already fits them — so you can plan with confidence before you travel.</p>
          </header>
          <ul class="persona-list" role="list">
            <li class="persona-list__item">
              {icon_circle("home")}
              <div>
                <h3>Guests and families</h3>
                <p>Hoist and wet room already fitted; measurements published; a private home, not a hotel room.</p>
              </div>
            </li>
            <li class="persona-list__item">
              {icon_circle("people")}
              <div>
                <h3>Carers and support workers</h3>
                <p>Practical layout with separate sleeping and room to work safely. A Carer’s Assessment under the Care Act 2014 may help fund a break.</p>
              </div>
            </li>
            <li class="persona-list__item">
              {icon_circle("clipboard")}
              <div>
                <h3>Occupational therapists</h3>
                <p>Published doorway widths, hoist and wet-room specs. Ask for unpublished clearances — we’ll measure.</p>
              </div>
            </li>
            <li class="persona-list__item">
              {icon_circle("building")}
              <div>
                <h3>Commissioners &amp; social care</h3>
                <p>Care Act short breaks; documentation for direct payments, PHB or CHC. Same rates regardless of who we invoice.</p>
              </div>
            </li>
          </ul>
        </div>
        <div class="split__media" data-reveal>
          <img src="{B}/LR-1-LS.jpg" alt="Open-plan living space in the accessible bungalow" width="900" height="675" loading="lazy" />
        </div>
      </div>
    </section>

    <section class="section-y band-subtle" id="access" aria-labelledby="access-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">See the access</p>
          <h2 id="access-h">Already in place</h2>
          <p class="lede">The kit most guests ask about first — fitted before you arrive, not arranged on the day.</p>
        </header>
        <div class="card-grid card-grid--3">
          <article class="media-card"><img src="{B}/WR-3-LS.jpg" alt="Level-access wet room with grab rails" width="640" height="480" loading="lazy" /><h3>Level-access wet room</h3><p>Roll-in shower, rails, adjustable basin.</p></article>
          <article class="media-card"><img src="{B}/BD2-6-LS.jpg" alt="Amico ceiling track hoist over the bed" width="640" height="480" loading="lazy" /><h3>Ceiling track hoist</h3><p>Over the profiling bed, full-room coverage.</p></article>
          <article class="media-card"><img src="{B}/kitchen.png" alt="Kitchen with wheel-under worksurface" width="640" height="480" loading="lazy" /><h3>Reachable kitchen</h3><p>Wheel-under worksurface and stocked basics.</p></article>
        </div>
        <p class="u-mt-8"><a class="text-link" href="accessibility-concept.html">Full accessibility details</a></p>
      </div>
    </section>

    <section class="section-y band-white" aria-labelledby="quote-h">
      <div class="container">
        <h2 id="quote-h" class="sr-only">What guests say</h2>
        <figure class="pull-quote">
          <span class="pull-quote__mark" aria-hidden="true">&ldquo;</span>
          <blockquote class="pull-quote__text">The house was well equipped with all the facilities we needed for my Dad&rsquo;s complex needs. Vicky and Keeley could not do enough for us. Our stay was comfortable and a home away from home.</blockquote>
          <figcaption class="pull-quote__cite">M.W.<span class="pull-quote__role">Visiting family &middot; Facebook review</span></figcaption>
        </figure>
      </div>
    </section>

    <section class="section-y band-teal" id="care" aria-labelledby="care-h">
      <div class="container">
        <div class="split">
          <div class="band-teal__stack">
            <p class="eyebrow eyebrow--on-dark">Add support</p>
            <h2 id="care-h">Optional care while you stay</h2>
            <p class="lede">Arranged with Continuity of Care Services, our sister company (CQC-rated Good, same phone line). Not part of your Restwell booking fee. Bring your own team if you prefer.</p>
            <ul class="checklist">
              <li><strong>Personal care:</strong> washing, dressing and daily routines on your schedule</li>
              <li><strong>Visiting care:</strong> friendly check-ins, or support getting out into the community</li>
              <li><strong>Mobility &amp; hoisting:</strong> safe transfers and moving support from trained carers</li>
            </ul>
            <div class="band-teal__actions">
              <a class="btn btn-gold" href="care-concept.html">Learn about optional care</a>
              <a class="btn btn-outline-light" href="enquire-concept.html">Ask about care options</a>
            </div>
          </div>
          <div class="split__media" data-reveal>
            <img src="{B}/RAR-1-LS.jpg" alt="Rise and recline chair providing extra support during a stay" width="900" height="675" loading="lazy" />
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-white" id="funding" aria-labelledby="funding-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Funding</p>
          <h2 id="funding-h">Three common routes</h2>
          <p class="lede">The same bungalow rates apply whatever route you use — funding only changes who receives the invoice.</p>
        </header>
        <dl class="comparison-list">
          <div class="comparison-list__item">
            <dt>Local authority &amp; direct payments</dt>
            <dd>Via a Care Needs or Carer’s Assessment. We invoice whoever you nominate.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Personal health budget</dt>
            <dd>NHS PHB or Continuing Healthcare pathways — same published rates.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Private / self-funded</dt>
            <dd>Pay Restwell directly. Add optional care if you want it.</dd>
          </div>
        </dl>
        <p class="u-mt-8"><a class="text-link" href="resources-concept.html">Funding &amp; support hub</a></p>
      </div>
    </section>

    <section class="section-y band-subtle process" id="next" aria-labelledby="next-h">
      <div class="container">
        <div class="split">
          <div class="process-copy">
            <header class="section-head section-head--tight">
              <p class="eyebrow">Next steps</p>
              <h2 id="next-h">From first question to arrival</h2>
              <p class="lede">No online checkout maze — share what you need, we’ll confirm suitability, then you book when you’re ready.</p>
            </header>
            <ol class="process-list">
              <li>
                <span class="process-list__index" aria-hidden="true">01</span>
                <div class="process-list__body">
                  <h3>Share requirements</h3>
                  <p class="process-list__meta">Start here</p>
                  <p>Dates, access needs, funding route, care questions.</p>
                </div>
              </li>
              <li>
                <span class="process-list__index" aria-hidden="true">02</span>
                <div class="process-list__body">
                  <h3>Confirm suitability</h3>
                  <p class="process-list__meta">We reply</p>
                  <p>We match the house and equipment to your party.</p>
                </div>
              </li>
              <li>
                <span class="process-list__index" aria-hidden="true">03</span>
                <div class="process-list__body">
                  <h3>Book and prepare</h3>
                  <p class="process-list__meta">When you’re ready</p>
                  <p>Deposit, welcome pack, and optional Continuity intro.</p>
                </div>
              </li>
            </ol>
          </div>
          <div class="split__media" data-reveal>
            <img src="{B}/entrance.png" alt="Step-free entrance to the Restwell bungalow" width="900" height="675" loading="lazy" />
          </div>
        </div>
      </div>
    </section>
{faq_block(
        "Suitability",
        "Planning &amp; respite FAQ",
        [
            ("wif-q1", "How do I plan a holiday when someone has complex care needs?", "Plan in this order: published access specs against the person’s equipment; staffing (daytime, sleep-in vs waking night, backup); who pays lodging vs care; written kit confirmation; medication for the trip; transport; emergency contacts. Only lock dates once those are clear.", True),
            ("wif-q2", "How do I plan a holiday if I have complex care needs?", "Choose accommodation that already matches transfers and overnight needs; coordinate carers or a local regulated provider; confirm equipment and slings; sort prescriptions; book accessible travel with buffer time; agree a backup if a carer is ill. Check Accessibility first, then enquire with dates and care needs."),
            ("wif-q3", "How should I prepare for an accessible holiday?", "Confirm access details in writing; pack slings, meds, chargers and comfort items the house won’t supply; share care plans with anyone covering the stay; note nearest accessible parking, toilets and pharmacy; keep Restwell and care-provider numbers to hand."),
            ("wif-q4", "What belongs on a disabled holiday checklist?", "Five lists: access needs; medical; care rota and backup; documents (funding letters, insurance, access statement); comfort and daily living. Tick each against the property’s published kit so you don’t pack what is already on site — or assume kit that isn’t."),
            ("wif-q5", "Is a holiday possible if someone has complex needs?", "Yes — when accommodation, equipment and care are planned properly. Start with measurements and overnight staffing, not brochure photos. This page and Accessibility help you judge fit before you enquire."),
            ("wif-q6", "Is a holiday cottage better than a respite care placement for disabled adults?", "Neither is universally better. A specialist cottage suits private, domestic stays with your own or visiting carers and enough kit for transfers. A respite placement suits higher on-site clinical oversight. Match setting to risk, staffing and what the person wants from the break."),
            ("wif-q7", "Can we take a disabled holiday instead of care-home respite?", "Often yes for the right risk profile — a private adapted let can feel more normal and family-friendly when equipment and care are planned. It is an alternative, not a replacement for registered care when that is clinically required."),
            ("wif-q8", "How does an accessible holiday let compare with respite care?", "Compare environment (private home vs care setting), independence, how care is delivered, cost lines, family involvement and clinical suitability. Restwell is a private adapted bungalow with optional Continuity care — not a care home."),
            ("wif-q9", "What is the difference between a respite break and an accessible holiday?", "Respite usually means planned carer relief or continued formal care under funding language. An accessible holiday describes a place a disabled traveller can use. They overlap often — many Restwell stays are both — but they answer different questions."),
        ],
        lede="Planning a break with complex care needs, and when a private cottage may suit better than care-home respite.",
        band="band-white",
    )}
{mid_cta("Not sure if it’s right?", "Describe the party and equipment — we’ll give a straight answer.", secondary=("accessibility-concept.html", "Read accessibility"))}
'''


def body_care():
    return f'''{hero("Optional care", "Optional CQC care for your accessible Whitstable stay", "Continuity of Care Services is our sister company. Same phone line as Restwell. If you need support during your break, we can often talk through care on the same call as your booking.", [("homepage-concept.html", "Home"), (None, "Optional care")])}
    <nav class="subnav" aria-label="On this page" data-toc>
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#sister-company">Sister company</a></li>
          <li><a href="#what-we-arrange">What we can arrange</a></li>
          <li><a href="#how-care-works">How it works</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y band-white" id="sister-company" aria-labelledby="sister-company-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Sister company</p>
          <h2 id="sister-company-h">Care without a separate scramble</h2>
          <p class="lede">Restwell is the holiday bungalow. Continuity of Care Services is our sister company: CQC-regulated, and on the same phone line. Care stays optional. It is never forced into the bungalow rate, and you do not have to chase another organisation to get started.</p>
        </header>
        <dl class="comparison-list">
          <div class="comparison-list__item">
            <dt>Same conversation</dt>
            <dd>Call or enquire about dates and access needs. If care would help, we can pick that up on the same call when it makes sense.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Optional, not automatic</dt>
            <dd>The bungalow rate is for the house and on-site access kit. Care is only added if you want it, after we understand what would help.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Your own team</dt>
            <dd>Prefer familiar carers? Bring them. The house works for real routines either way.</dd>
          </div>
        </dl>
      </div>
    </section>

    <section class="section-y band-subtle" id="what-we-arrange" aria-labelledby="what-we-arrange-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Support options</p>
          <h2 id="what-we-arrange-h">What Continuity can arrange</h2>
          <p class="lede">From a few hours of companionship to overnight cover. We work out the detail in conversation, not from a form alone.</p>
        </header>
        <dl class="comparison-list comparison-list--2">
          <div class="comparison-list__item">
            <dt>Personal care</dt>
            <dd>Support with washing, dressing and daily routines on your schedule.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Visiting care</dt>
            <dd>Friendly check-ins, or support getting out into the community.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Overnight cover</dt>
            <dd>Sleep-in or waking night support when daytime visits are not enough.</dd>
          </div>
          <div class="comparison-list__item">
            <dt>Mobility and hoisting</dt>
            <dd>Safe transfers and moving support from trained carers, using the kit already in the house.</dd>
          </div>
        </dl>
        <div class="care-page__trust">
          <p class="care__note">Additional or complex care can be arranged subject to assessment. Nothing is added until you have agreed what support you want.</p>
          <div class="care__brand" aria-label="Care partner and CQC rating">
            <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer">
              <img src="../assets/images/partners/continuity-of-care-services-long.png" alt="Continuity of Care Services" width="405" height="69" loading="lazy" decoding="async" />
              <span class="sr-only"> (opens in new tab)</span>
            </a>
            <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer">
              <img src="../assets/images/partners/cqc-rating-good.jpg" alt="CQC rating Good, Continuity of Care Services" width="710" height="399" loading="lazy" decoding="async" />
              <span class="sr-only"> (opens in new tab)</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-white" id="how-care-works" aria-labelledby="how-care-works-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Getting started</p>
          <h2 id="how-care-works-h">How arranging care works</h2>
          <p class="lede">Usually one phone number and one conversation to start, then a clear quote for the support you need.</p>
        </header>
        <ol class="payment-steps">
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">01</span>
            <div class="payment-steps__body">
              <h3>Call or enquire as usual</h3>
              <p>Share dates, access needs, and any care you think would help. Same Restwell line (01622 809881) whether you are booking the house, asking about care, or both.</p>
            </div>
          </li>
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">02</span>
            <div class="payment-steps__body">
              <h3>We shape the right support</h3>
              <p>If care is needed, Continuity confirms what is possible and quotes. That often starts on the same call. Sometimes a short follow-up finishes the detail.</p>
            </div>
          </li>
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">03</span>
            <div class="payment-steps__body">
              <h3>Guide rates, then your figure</h3>
              <p>Published starting points live on <a class="text-link" href="pricing-concept.html#care-rates">Pricing</a>. Your final care cost depends on what you actually need.</p>
            </div>
          </li>
        </ol>
      </div>
    </section>

{faq_block(
        "Care questions",
        "Before you ask about support",
        [
            ("care-q1", "Do I have to book care?", "No. Many guests book the house as a self-catering holiday and need no additional support. Care through Continuity is entirely optional.", True),
            ("care-q2", "Is Restwell a care home?", "No. Restwell is a private holiday bungalow. Continuity of Care Services (our sister company) is the CQC-regulated provider if you want professional care during your stay.", False),
            ("care-q3", "Do I need a separate phone number for care?", "No. Restwell and Continuity share the same phone line (01622 809881). If care would help, we can usually start that conversation on the same call as your booking enquiry.", False),
            ("care-q4", "Can I bring my own carers?", "Yes. The layout supports familiar routines, with separate sleeping and space to assist. Tell us your party layout when you enquire.", False),
            ("care-q5", "Where do I see guide rates?", "On the <a class=\"text-link\" href=\"pricing-concept.html#care-rates\">Pricing</a> page. They are starting points. We confirm your figure once we understand what would help.", False),
        ],
        lede="Optional care, Continuity, and how support works with your booking.",
    )}
{mid_cta("Ready to talk about care?", "Call or enquire with your dates and what support would help. Same number as Restwell. No obligation.", secondary=("pricing-concept.html#care-rates", "See guide rates"))}
'''


def body_pricing():
    return f'''{hero("Pricing", "Pricing for your accessible Whitstable break", "Bungalow rates, optional care guides, and the same tariff on every funding route.", [("homepage-concept.html", "Home"), (None, "Pricing")])}
    <nav class="subnav" aria-label="On this page" data-toc>
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#rates">Rates</a></li>
          <li><a href="#payment">Payment</a></li>
          <li><a href="#care-rates">Optional care</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y band-white" id="rates" aria-labelledby="rates-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Bungalow rates</p>
          <h2 id="rates-h">What a stay costs</h2>
          <p class="lede">Whole bungalow, sleeps five. Midweek (Mon–Thu) and weekend (Fri–Sun) nights are priced differently; optional care is separate.</p>
        </header>
        <div class="rates-block">
          <div class="rates-panel">
            <table class="data-table data-table--rates">
              <caption class="sr-only">Bungalow rates by stay type and season</caption>
              <thead>
                <tr>
                  <th scope="col">Stay type</th>
                  <th scope="col">Off-peak</th>
                  <th scope="col">Peak</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Full week <span class="data-table__hint">(7 nights)</span></th>
                  <td class="is-price" data-label="Off-peak">£1,300</td>
                  <td class="is-price" data-label="Peak">£1,400</td>
                </tr>
                <tr>
                  <th scope="row">Weekend night <span class="data-table__hint">(Fri–Sun)</span></th>
                  <td class="is-price" data-label="Off-peak">£235</td>
                  <td class="is-price" data-label="Peak">£255</td>
                </tr>
                <tr>
                  <th scope="row">Midweek night <span class="data-table__hint">(Mon–Thu)</span></th>
                  <td class="is-price" data-label="Off-peak">£185</td>
                  <td class="is-price" data-label="Peak">£200</td>
                </tr>
              </tbody>
            </table>
            <div class="rates-examples">
              <div class="rates-examples__head">
                <h3 class="rates-examples__title">Example stays</h3>
                <p class="rates-examples__cols" aria-hidden="true"><span>Off-peak</span><span>Peak</span></p>
              </div>
              <ul class="rates-examples__list">
                <li>
                  <div class="rates-examples__copy">
                    <span class="rates-examples__name">Weekend</span>
                    <span class="rates-examples__meta">(Fri–Sun, 3 nights)</span>
                  </div>
                  <span class="rates-examples__prices">
                    <span class="is-price" data-label="Off-peak">£705</span>
                    <span class="is-price" data-label="Peak">£765</span>
                  </span>
                </li>
                <li>
                  <div class="rates-examples__copy">
                    <span class="rates-examples__name">Midweek</span>
                    <span class="rates-examples__meta">(Mon–Thu, 4 nights)</span>
                  </div>
                  <span class="rates-examples__prices">
                    <span class="is-price" data-label="Off-peak">£740</span>
                    <span class="is-price" data-label="Peak">£800</span>
                  </span>
                </li>
                <li>
                  <div class="rates-examples__copy">
                    <span class="rates-examples__name">Long weekend</span>
                    <span class="rates-examples__meta">(Fri–Mon, 4 nights)</span>
                  </div>
                  <span class="rates-examples__prices">
                    <span class="is-price" data-label="Off-peak">£890</span>
                    <span class="is-price" data-label="Peak">£965</span>
                  </span>
                </li>
              </ul>
            </div>
          </div>
          <p class="rates-follow">Rooms and capacity on <a class="text-link" href="property-concept.html">the property</a> page; kit and measurements in the <a class="text-link" href="accessibility-concept.html">access details</a>.</p>
          <details class="peak-dates" data-peak-dates>
            <summary class="peak-dates__summary">
              <h3 id="peak-dates-h" class="peak-dates__summary-title">Peak season dates</h3>
              <span class="peak-dates__summary-hint">All other dates are off-peak</span>
            </summary>
            <ul class="peak-dates__list">
              <li><span class="peak-dates__label">Summer 2026</span><span class="peak-dates__range">22 Jul – 1 Sep 2026</span></li>
              <li><span class="peak-dates__label">Autumn half-term</span><span class="peak-dates__range">26 Oct – 1 Nov 2026</span></li>
              <li><span class="peak-dates__label">Christmas</span><span class="peak-dates__range">21 Dec 2026 – 3 Jan 2027</span></li>
              <li><span class="peak-dates__label">February half-term</span><span class="peak-dates__range">15 – 21 Feb 2027</span></li>
              <li><span class="peak-dates__label">Easter</span><span class="peak-dates__range">29 Mar – 11 Apr 2027</span></li>
              <li><span class="peak-dates__label">Spring bank holiday</span><span class="peak-dates__range">31 May – 6 Jun 2027</span></li>
              <li><span class="peak-dates__label">Summer 2027</span><span class="peak-dates__range">22 Jul – 1 Sep 2027</span></li>
            </ul>
          </details>
        </div>
      </div>
    </section>

    <section class="section-y band-subtle" id="payment" aria-labelledby="payment-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Deposits and balance</p>
          <h2 id="payment-h">How payment works</h2>
          <p class="lede">BACS or card. Same rates on every funding route — <a class="text-link" href="resources-concept.html">Funding &amp; Support</a> covers who we invoice.</p>
        </header>
        <ol class="payment-steps">
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">01</span>
            <div class="payment-steps__body">
              <h3>50% deposit</h3>
              <p>Secures your dates and takes the bungalow off the calendar.</p>
            </div>
          </li>
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">02</span>
            <div class="payment-steps__body">
              <h3>Balance before arrival</h3>
              <p>Due no later than one week before you arrive.</p>
            </div>
          </li>
          <li class="payment-steps__item">
            <span class="payment-steps__index" aria-hidden="true">03</span>
            <div class="payment-steps__body">
              <h3>No extras</h3>
              <p>No damage deposit and no end-of-stay cleaning fee.</p>
            </div>
          </li>
        </ol>
        <p class="payment-note">If plans change, the <a class="text-link" href="terms-concept.html">terms and cancellation policy</a> set out what happens next.</p>
      </div>
    </section>

    <section class="section-y band-white" id="care-rates" aria-labelledby="care-rates-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Guide rates</p>
          <h2 id="care-rates-h">Optional care while you stay</h2>
          <p class="lede">Never bundled into the bungalow price. The figures below are starting points, because the right support depends on what each guest needs. We confirm your cost after a free conversation. <a class="text-link" href="care-concept.html">Learn more about optional care</a></p>
        </header>
        <div class="care-rates">
          <div class="rates-panel">
            <table class="data-table data-table--rates data-table--care">
              <caption class="sr-only">Optional care guide rates by support type for weekday and weekend. Final cost confirmed after a free conversation.</caption>
              <thead>
                <tr>
                  <th scope="col">Support</th>
                  <th scope="col">From, weekday</th>
                  <th scope="col">From, weekend</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Daytime personal care <span class="data-table__hint">(per hour)</span></th>
                  <td class="is-price" data-label="Weekday">£34.65</td>
                  <td class="is-price" data-label="Weekend">£41.25</td>
                </tr>
                <tr>
                  <th scope="row">Overnight personal care <span class="data-table__hint">(per hour)</span></th>
                  <td class="is-price" data-label="Weekday">£40.15</td>
                  <td class="is-price" data-label="Weekend">£46.75</td>
                </tr>
                <tr>
                  <th scope="row">Sleep-in night <span class="data-table__hint">(per night)</span></th>
                  <td class="is-price" data-label="Weekday">£230.94</td>
                  <td class="is-price" data-label="Weekend">£230.94</td>
                </tr>
                <tr>
                  <th scope="row">Waking night <span class="data-table__hint">(per night)</span></th>
                  <td class="is-price" data-label="Weekday">£307.62</td>
                  <td class="is-price" data-label="Weekend">£307.62</td>
                </tr>
              </tbody>
            </table>
            <div class="care-rates__footer">
              <p class="care-rates__note">Bank holidays and more complex care may cost more. Next review: 1 September 2026.</p>
              <a class="btn btn-gold" href="enquire-concept.html">Arrange a care conversation</a>
              <div class="care-rates__brands care__brand" aria-label="Care partner and CQC rating">
                <a class="care__brand-link care__brand-link--ccs" href="https://www.continuitycareservices.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="../assets/images/partners/continuity-of-care-services-long.png" alt="Continuity of Care Services" width="405" height="69" loading="lazy" decoding="async" />
                  <span class="sr-only"> (opens in new tab)</span>
                </a>
                <a class="care__brand-link care__brand-link--cqc" href="https://www.cqc.org.uk/location/1-2624556588" target="_blank" rel="noopener noreferrer">
                  <img src="../assets/images/partners/cqc-rating-good.jpg" alt="CQC rating Good — Continuity of Care Services" width="710" height="399" loading="lazy" decoding="async" />
                  <span class="sr-only"> (opens in new tab)</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

{faq_block(
        "Money questions",
        "Pricing FAQ",
        [
            ("pr-q1", "Is care included in the bungalow price?", "No. The bungalow rate covers the house and on-site access equipment. Care is optional through Continuity of Care Services. See guide rates above.", True),
            ("pr-q2", "Are there extra charges for equipment?", "On-site hoists, profiling beds and wet-room kit are included. Hired-in specialist kit is charged separately — tell us when you enquire. Bring your own slings."),
            ("pr-q3", "Do prices change with funding?", "No. Same rates for every guest. Funding only changes who we invoice — see <a class=\"text-link\" href=\"resources-concept.html\">Funding &amp; Support</a>."),
            ("pr-q4", "When do care guide rates go up?", "Weekends, bank holidays and complex care cost more. Continuity reviews rates periodically — the next review date is shown with the guide rates above. Final cost is confirmed after a free conversation."),
        ],
        lede="What the bungalow rate includes, optional care costs, and whether funding changes the price.",
        band="band-subtle",
    )}
{mid_cta("Ready to plan your accessible break?", "A conversation about dates, access needs and optional care — no booking commitment.", primary=("enquire-concept.html", "Enquire Now"), secondary=("how-it-works-concept.html", "How booking works"))}
'''


def ext_a(href, label, css_class=""):
    """Outbound link with new-tab disclosure for screen readers."""
    cls = f' class="{css_class}"' if css_class else ""
    return (
        f'<a href="{href}"{cls} target="_blank" rel="noopener noreferrer">'
        f'{label}<span class="sr-only"> (opens in new tab)</span></a>'
    )


def place_item(title, body, href=None, tel=None, maps=None, meta="", img=None, img_alt=""):
    """Linked local listing — title + actions carry the outbound SEO value.

    Optional img: thumb above the copy (used for route stops on the area guide).
    """
    title_href = href or maps
    title_html = ext_a(title_href, title) if title_href else title
    meta_html = f'<p class="place-list__meta">{meta}</p>' if meta else ""
    media_html = ""
    if img:
        alt = img_alt or title
        media_html = (
            f'<img class="place-list__thumb" src="{img}" alt="{alt}" '
            f'width="640" height="400" loading="lazy" decoding="async" />'
        )
    bits = []
    if href:
        bits.append(ext_a(href, "Website", "text-link"))
    if tel:
        tel_href = "tel:" + "".join(ch for ch in tel if ch.isdigit() or ch == "+")
        bits.append(f'<a class="text-link" href="{tel_href}">Call {tel}</a>')
    if maps and maps != href:
        bits.append(ext_a(maps, "Map", "text-link"))
    actions = ""
    if bits:
        sep = '<span class="place-list__sep" aria-hidden="true">·</span>'
        actions = f'<p class="place-list__actions">{sep.join(bits)}</p>'
    return f'''          <article class="place-list__item">
            {media_html}
            <h3 class="place-list__title">{title_html}</h3>
            {meta_html}
            <p>{body}</p>
            {actions}
          </article>'''


def body_whitstable():
    castle = place_item(
        "Whitstable Castle &amp; Gardens",
        "Paved grounds and Orangery Tearooms with an accessible loo. Natural pause halfway along the promenade.",
        href="https://whitstablecastle.co.uk/",
        tel="01227 281726",
        meta="Promenade stop",
        img=f"{S}/restwell-whitstable-beach-huts.webp",
        img_alt="Colourful beach huts along the Whitstable seafront",
    )
    harbour = place_item(
        "Whitstable Harbour",
        "Working oyster port. South Quay Shed has a lift to a quieter upper floor. Surfaces can be uneven — take it steady at peak times.",
        href="https://www.canterbury.co.uk/whitstable-harbour/",
        maps="https://maps.google.com/?q=Whitstable+Harbour",
        meta="Town &amp; seafood",
        img=f"{S}/restwell-whitstable-sunset-pier.webp",
        img_alt="Whitstable harbour area at sunset",
    )
    neptune = place_item(
        "The Old Neptune",
        "Iconic pub on the shingle. Terrace on firm ground is the realistic option — sloping floors inside, no step-free entrance.",
        href="https://www.thepubonthebeach.co.uk/",
        maps="https://maps.google.com/?q=The+Old+Neptune+Whitstable",
        meta="Beach pub",
        img=f"{S}/restwell-whitstable-coastal-walk.webp",
        img_alt="Coastal walk near the Whitstable beach pubs",
    )
    plough = place_item(
        "The Plough Inn, Swalecliffe",
        "Around the corner via the footpath between 71 and 73 Russell Drive. Step-free entry; no accessible toilet — confirm on the day if that matters.",
        tel="01227 794636",
        maps="https://maps.google.com/?q=The+Plough+St+Johns+Road+Whitstable",
        meta="Nearest pub · CT5 2RN",
    )
    jojos = place_item(
        "JoJo’s, Tankerton",
        "Clifftop Mediterranean favourite. Wheelchair access and accessible toilet. Book ahead — it fills quickly.",
        href="https://jojosrestaurant.co.uk/",
        tel="01227 274591",
        meta="2 Herne Bay Road · CT5 2LQ",
    )
    marine = place_item(
        "Marine Hotel, Tankerton",
        "Ground-floor lounge and restaurant, step-free, accessible loo by reception. Sea views from Marine Parade.",
        href="https://www.marinewhitstable.co.uk/",
        tel="01227 272672",
        meta="32–33 Marine Parade · CT5 2BE",
    )

    return f'''{hero("Whitstable &amp; Kent coast", "A practical local guide for your stay", "Seafront routes, parking, eating out and quieter times — described honestly for wheelchair users and carers.", [("homepage-concept.html", "Home"), (None, "Whitstable")], media=True)}
    <nav class="subnav" aria-label="On this page">
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#promenade">Promenade</a></li>
          <li><a href="#parking">Parking</a></li>
          <li><a href="#eat">Eat</a></li>
          <li><a href="#toilets">Toilets</a></li>
          <li><a href="#days-out">Days out</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y section-y--compact band-white" aria-label="Journey times">
      <div class="container">
        <div class="stat-row">
          <div class="stat"><p class="stat__value">~90 min</p><p class="stat__label">Drive from London (M2 / A299)</p></div>
          <div class="stat"><p class="stat__value">75–90 min</p><p class="stat__label">Direct train — check National Rail</p></div>
          <div class="stat"><p class="stat__value">15 min</p><p class="stat__label">Walk to Tankerton promenade</p></div>
        </div>
      </div>
    </section>

    <section class="section-y band-subtle" id="promenade" aria-labelledby="promenade-h">
      <div class="container split">
        <div>
          <header class="section-head section-head--tight">
            <p class="eyebrow">Coastal walk</p>
            <h2 id="promenade-h">Tankerton promenade</h2>
            <p class="lede">About two miles of paved route from Tankerton Slopes toward the castle and harbour. Beach slopes to the shingle are steep — stick to the promenade for level sea air.</p>
          </header>
          <ul class="checklist">
            <li>Wide, surfaced path with weather shelters and benches</li>
            <li>At low tide you can watch The Street spit — loose shingle, not a wheelchair route</li>
            <li>Level route from Restwell — no steps on the approach</li>
          </ul>
        </div>
        <div class="split__media">
          <img src="{S}/restwell-whitstable-coastal-pathway.webp" alt="Level coastal pathway at Whitstable" width="900" height="675" loading="lazy" />
        </div>
      </div>
    </section>

    <section class="section-y band-white" id="parking" aria-labelledby="parking-h">
      <div class="container split split--flip split--media-first">
        <div class="split__media">
          <img src="{S}/russell-drive-whitstable.webp" alt="Russell Drive neighbourhood near Tankerton" width="900" height="675" loading="lazy" />
        </div>
        <div>
          <header class="section-head section-head--tight">
            <p class="eyebrow">Parking, plainly</p>
            <h2 id="parking-h">At the house and in town</h2>
            <p class="lede">Start from the driveway when you can. Harbour ANPR is the one that catches people out.</p>
          </header>
          <dl class="comparison-list">
            <div class="comparison-list__item">
              <dt>At Restwell</dt>
              <dd>Two off-road spaces on the private driveway — level, step-free to the front door. Street parking outside usually works for overflow; check signs on arrival.</dd>
            </div>
            <div class="comparison-list__item">
              <dt>Marine Parade &amp; Tankerton</dt>
              <dd>Free Blue Badge bays along Marine Parade (display badge, no app). Tankerton Road Car Park gives three hours free with a physical badge.</dd>
            </div>
          </dl>
          <aside class="download-panel u-mt-6">
            <h3>Harbour ANPR</h3>
            <p>Gorrell Tank and Keam’s Yard need your vehicle and Blue Badge pre-registered online. Parking at Tankerton Road and rolling the promenade is usually easier.</p>
            <p class="place-list__actions">{ext_a("https://www.canterbury.gov.uk/parking-and-roads/automatic-car-park-payments/register-your-blue-badge-park", "Register Blue Badge for ANPR", "text-link")}<span class="place-list__sep" aria-hidden="true">·</span>{ext_a("https://www.canterbury.gov.uk/parking-and-roads/blue-badge-parking", "Blue Badge parking (CCC)", "text-link")}</p>
          </aside>
        </div>
      </div>
    </section>

    <section class="section-y band-subtle" id="stops" aria-labelledby="stops-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Along the route</p>
          <h2 id="stops-h">Worth a wander</h2>
          <p class="lede">Three stops on or just off the promenade, with honest access notes and links so you can check opening times before you set out.</p>
        </header>
        <div class="place-list place-list--3">
{castle}
{harbour}
{neptune}
        </div>
      </div>
    </section>

    <section class="section-y band-white" id="eat" aria-labelledby="eat-h">
      <div class="container split split--media-first">
        <div>
          <header class="section-head section-head--tight">
            <p class="eyebrow">Places to eat</p>
            <h2 id="eat-h">Local favourites</h2>
            <p class="lede">Nearby options with access notes. Most Whitstable venues sit in older buildings — call ahead if access is critical.</p>
          </header>
          <div class="place-list place-list--stack">
{plough}
{jojos}
{marine}
          </div>
        </div>
        <div class="split__media">
          <img src="{S}/restwell-whitstable-marina-sunset.webp" alt="Whitstable seafront at golden hour — Tankerton dining is along this stretch" width="900" height="675" loading="lazy" />
        </div>
      </div>
    </section>

    <section class="section-y section-y--compact band-subtle" id="toilets" aria-labelledby="toilets-h">
      <div class="container">
        <header class="section-head section-head--tight">
          <p class="eyebrow">Loos along the way</p>
          <h2 id="toilets-h">Accessible toilets</h2>
          <p class="lede">Public and venue loos on the promenade route. Changing Places at the harbour needs a RADAR key.</p>
        </header>
        <ul class="checklist checklist--2">
          <li>Behind the sailing club at the foot of the slopes</li>
          <li>By the Marine Parade cafe at the top</li>
          <li>Under the promenade cafe near the castle</li>
          <li>Changing Places — Whitstable Harbour WC, Harbour Road</li>
          <li>JoJo’s Tankerton and Marine Hotel (venue accessible loos)</li>
        </ul>
        <p class="u-mt-6">{ext_a("https://www.changing-places.org/find", "Changing Places map", "text-link")}</p>
      </div>
    </section>

    <section class="section-y band-white" id="travel" aria-labelledby="travel-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Once you’re here</p>
          <h2 id="travel-h">Station, buses and taxis</h2>
          <p class="lede">Journey times are above. This is the practical bit for moving around once you’ve arrived.</p>
        </header>
        <dl class="fact-dl">
          <div>
            <dt>Station</dt>
            <dd>Whitstable station access varies by platform — check {ext_a("https://www.nationalrail.co.uk/", "National Rail")} before you travel. About 20–30 minutes’ walk from the bungalow on paved routes, or a short taxi.</dd>
          </div>
          <div>
            <dt>Buses</dt>
            <dd>{ext_a("https://www.stagecoachbus.com/", "Stagecoach South East")} route 400 links The Plough area toward the beach, harbour and Canterbury. Low-floor space can vary — same-day check.</dd>
          </div>
          <div>
            <dt>Accessible taxis</dt>
            <dd>Pre-book on busy days. Abacus Cars: <a class="text-link" href="tel:01227277745">01227 277745</a>.</dd>
          </div>
        </dl>
      </div>
    </section>

    <section class="section-y band-subtle" id="days-out" aria-labelledby="days-out-h">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Further afield</p>
          <h2 id="days-out-h">Day trips worth the drive</h2>
          <p class="lede">Official sites first — then confirm scooter hire, companion tickets and parking for your dates.</p>
        </header>
        <div class="card-grid card-grid--3">
          <article class="media-card">
            <img src="{S}/whitstable-days-out.webp" alt="Woodland day out near the Kent coast" width="640" height="480" loading="lazy" />
            <h3>{ext_a("https://kent.wildwoodtrust.org/", "Wildwood, Herne Bay", "media-card__title-link")}</h3>
            <p>~30 minutes. Mostly accessible woodland paths; scooters bookable ahead on 01227 209621.</p>
            <p class="place-list__actions">{ext_a("https://kent.wildwoodtrust.org/plan-your-visit/", "Plan your visit", "text-link")}</p>
          </article>
          <article class="media-card">
            <img src="{S}/row-of-colorful-beach-homes-2026-03-25-01-44-35-utc.webp" alt="Colourful seaside buildings on the Kent coast" width="640" height="480" loading="lazy" />
            <h3>{ext_a("https://www.dreamland.co.uk/", "Dreamland, Margate", "media-card__title-link")}</h3>
            <p>Wheelchair accessible park; Nimbus Access Card and Essential Companion scheme. Accessible parking nearby.</p>
            <p class="place-list__actions">{ext_a("https://www.dreamland.co.uk/", "Dreamland website", "text-link")}</p>
          </article>
          <article class="media-card">
            <img src="{S}/st-augustines-abbey-in-caterbury-city-england-2026-03-20-01-00-24-utc.webp" alt="Historic stone ruins in Canterbury" width="640" height="480" loading="lazy" />
            <h3>{ext_a("https://www.canterbury-cathedral.org/", "Canterbury", "media-card__title-link")}</h3>
            <p>~20 minutes by car. Cathedral Welcome Centre lends wheelchairs; riverside and Westgate Gardens are smoother than the cobbles.</p>
            <p class="place-list__actions">{ext_a("https://www.canterbury-cathedral.org/visit/", "Cathedral visit info", "text-link")}</p>
          </article>
        </div>
      </div>
    </section>
{faq_block(
        "Local access",
        "Whitstable &amp; coast FAQ",
        [
            ("whit-q1", "Is Whitstable accessible for disabled visitors?", "Partly — yes with planning. Paved routes and Tankerton’s level promenade help; loose shingle and some older streets limit others. Use accessible parking notes, the harbour RADAR toilet, and a step-free base like Restwell.", True),
            ("whit-q2", "What is Whitstable like for wheelchair users?", "Compact seaside town with harbour and independents; surfaces vary. From Restwell, town centre is roughly 15 minutes on a flat paved route; Tankerton promenade about 15 minutes — wide, level and fully surfaced. Use the paved path; grassy slopes above are steep."),
            ("whit-q3", "Is Whitstable suitable for wheelchair users?", "It can work if you plan parking, toilets and seafront routes. Tankerton promenade is the main long level coastal stretch. A private step-free bungalow with driveway parking removes the hardest accommodation barrier."),
            ("whit-q4", "Where can I find step-free experiences on the Kent coast?", "Favour paved promenades over shingle or steep slips. Tankerton’s promenade near Restwell is a strong local example. Pair coastal days with an adapted base so the day is about the route, not stairs at the house."),
            ("whit-q5", "How do I plan a wheelchair coastal holiday near Whitstable?", "Book step-free accommodation first; use Tankerton promenade for sea air; check accessible toilets and parking; allow fatigue-friendly days. This guide covers the practical local detail."),
            ("whit-q6", "What makes an accessible beach day work here?", "Level promenade, nearby parking and toilets, and honest limits. The shingle beach itself is not wheelchair-friendly — the promenade above is the accessible coastal route. Beach wheelchairs are not assumed; ask locally if you need one."),
            ("whit-q7", "What should I look for in an accessible seaside holiday in Kent?", "A private adapted base, known level routes, quieter timing if crowds are hard, and a backup indoor plan for weather. Restwell is built as that base on the Kent coast with optional care if needed."),
        ],
        lede="Whitstable, Tankerton promenade, and step-free coastal days near the bungalow.",
        band="band-white",
    )}
{mid_cta("Planning your days?", "Ask us for route notes that match your party’s access needs — then see the bungalow that anchors the trip.", secondary=("property-concept.html", "See the bungalow"))}
'''


def body_resources():
    return f'''{hero("Funding &amp; Support", "How to fund an accessible holiday in the UK", "Same bungalow rates on every funding route. Who we invoice can change — the price does not.", [("homepage-concept.html", "Home"), (None, "Funding & Support")])}
    <nav class="subnav" aria-label="On this page">
      <div class="container">
        <ul class="subnav__list">
          <li><a href="#routes">Routes</a></li>
          <li><a href="#directory">Grants &amp; contacts</a></li>
          <li><a href="#help">Paperwork</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <section class="section-y section-y--compact band-white" id="routes" aria-labelledby="routes-h">
      <div class="container">
        <header class="section-head section-head--tight">
          <p class="eyebrow">Start here</p>
          <h2 id="routes-h">Three common ways to fund a stay</h2>
          <p class="lede">Pick your pathway. Restwell’s price stays the same — only who we invoice changes.</p>
        </header>
        <div class="card-grid card-grid--3" data-reveal>
          <article class="info-card info-card--route" id="local-authority">
            <div class="info-card__head">{icon_circle("bank")}<h3>Local authority</h3></div>
            <p>Ask Kent County Council for a <strong>Carer’s Assessment</strong> and, where relevant, a <strong>Care Needs Assessment</strong>. Direct payments can cover a short break that meets assessed needs.</p>
            <div class="info-card__steps">
              <h4>Next steps</h4>
              <ul class="checklist">
                <li>Call KCC on <a href="tel:03000416161">03000 41 61 61</a></li>
                <li>Ask about direct payments for a short break</li>
                <li>Nominate who Restwell should invoice</li>
              </ul>
            </div>
          </article>
          <article class="info-card info-card--route" id="nhs">
            <div class="info-card__head">{icon_circle("heartbeat")}<h3>NHS / CHC</h3></div>
            <p>Contact Kent &amp; Medway ICB about Continuing Healthcare or a personal health budget. We confirm cover with your funding contact, then invoice the funder before the stay.</p>
            <div class="info-card__steps">
              <h4>Next steps</h4>
              <ul class="checklist">
                <li>Ask whether respite is in the budget</li>
                <li>Share your funding contact when you enquire</li>
                <li>Request Restwell details for the pack</li>
              </ul>
            </div>
          </article>
          <article class="info-card info-card--route" id="private">
            <div class="info-card__head">{icon_circle("wallet")}<h3>Grants &amp; private</h3></div>
            <p>Book and pay Restwell directly, or combine with a charity award. Eligibility varies — apply early and keep award letters with your enquiry.</p>
            <div class="info-card__steps">
              <h4>Next steps</h4>
              <ul class="checklist">
                <li>Search grants via the links below</li>
                <li>Keep award letters with your enquiry</li>
                <li>Pay deposit to secure dates</li>
              </ul>
            </div>
          </article>
        </div>
        <p class="fund-appeals">If a decision says no: local authority → KCC complaints, then the Local Government Ombudsman. NHS → ICB process, then the Parliamentary and Health Service Ombudsman. Scope and Beacon can advise on appeals.</p>
      </div>
    </section>

    <section class="section-y section-y--compact band-subtle" id="directory" aria-labelledby="directory-h">
      <div class="container">
        <header class="section-head section-head--tight">
          <p class="eyebrow">Quick reference</p>
          <h2 id="directory-h">Grants &amp; key contacts</h2>
        </header>
        <div class="fund-directory">
          <div>
            <p class="fund-directory__label">Useful starting points</p>
            <ul class="link-list">
              <li><a href="https://carers.org/" target="_blank" rel="noopener noreferrer">Carers Trust<span class="sr-only"> (opens in new tab)</span></a><span>Grants and local carer support</span></li>
              <li><a href="https://www.turn2us.org.uk/" target="_blank" rel="noopener noreferrer">Turn2us<span class="sr-only"> (opens in new tab)</span></a><span>Benefits and grants search</span></li>
              <li><a href="https://www.respiteassociation.org/" target="_blank" rel="noopener noreferrer">Respite Association<span class="sr-only"> (opens in new tab)</span></a><span>Help toward short breaks</span></li>
              <li><a href="https://www.ageuk.org.uk/kent/" target="_blank" rel="noopener noreferrer">Age UK Kent<span class="sr-only"> (opens in new tab)</span></a><span>Local advice in Kent</span></li>
            </ul>
          </div>
          <div>
            <p class="fund-directory__label">Who to call</p>
            <ul class="contact-list">
              <li class="contact-list__item">
                <div class="contact-list__org">
                  <h3>Kent County Council</h3>
                  <p>Social care assessments</p>
                </div>
                <p class="contact-list__action"><a href="tel:03000416161">03000 41 61 61</a></p>
              </li>
              <li class="contact-list__item">
                <div class="contact-list__org">
                  <h3>Kent &amp; Medway ICB</h3>
                  <p>Continuing Healthcare</p>
                </div>
                <p class="contact-list__action"><a href="mailto:chc@kmicb.nhs.uk">chc@kmicb.nhs.uk</a></p>
              </li>
              <li class="contact-list__item">
                <div class="contact-list__org">
                  <h3>Restwell</h3>
                  <p>Quotes, access packs, invoicing</p>
                </div>
                <p class="contact-list__action"><a href="tel:01622809881">01622 809881</a><span class="contact-list__sep" aria-hidden="true">·</span><a href="mailto:hello@restwellretreats.co.uk">hello@restwellretreats.co.uk</a></p>
              </li>
            </ul>
            <p class="fund-directory__follow"><a class="text-link" href="pricing-concept.html#funding">How invoicing works on pricing</a></p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-y band-teal" id="help" aria-labelledby="help-h">
      <div class="container">
        <div class="split">
          <div class="band-teal__stack">
            <p class="eyebrow eyebrow--on-dark">What we can send</p>
            <h2 id="help-h">Need a funding conversation?</h2>
            <p class="lede">Tell us your route and paperwork stage — we’ll help with quotes, access packs and who to invoice.</p>
            <ul class="checklist">
              <li>Written quote at published rates</li>
              <li>Access statement and equipment list</li>
              <li>Invoice setup for a nominated funder</li>
            </ul>
            <div class="band-teal__actions">
              <a class="btn btn-gold" href="enquire-concept.html">Enquire Now</a>
              <a class="btn btn-outline-light" href="who-its-for-concept.html">Who it’s for</a>
            </div>
          </div>
          <div class="split__media" data-reveal>
            <img src="{B}/living-room-2.png" alt="Restwell bungalow living room" width="900" height="675" loading="lazy" />
          </div>
        </div>
      </div>
    </section>
{faq_block(
        "Funding pathways",
        "Funding FAQ",
        [
            ("res-q1", "Can NHS Continuing Healthcare funding be used for a holiday?", "Often for eligible care hours away from home if your CHC team agrees in writing — rarely for the cottage rent itself. Ask which invoice lines they will pay before anyone pays a deposit. Restwell can supply access evidence; funding decisions sit with the commissioner.", True),
            ("res-q2", "How does NHS CHC holiday funding work?", "CHC may cover assessed health and care needs during a short break. Accommodation is usually personal funds, direct payments or LA rules unless a panel explicitly agrees. Contact your CHC coordinator early with property specs and care-provider details."),
            ("res-q3", "Can I get an NHS-funded holiday in the UK?", "There is no general “NHS pays for holidays” scheme. What exists is funding for assessed care (and sometimes respite frameworks) that may continue during a break. Treat lodging, travel and care as separate lines and get each clarified in writing."),
            ("res-q4", "How do I use NHS CHC funding for a short break?", "Speak to your CHC coordinator; ask which care tasks they will fund away from the usual address; share risk assessments and provider details; book the property separately with an access pack ready; align invoice contacts so care and lodging don’t get mixed."),
            ("res-q5", "How does Continuing Healthcare relate to a respite break?", "CHC-related respite is about continuing eligible care and carer relief under health funding rules. An accessible holiday describes the place. They can overlap — but “respite” and “holiday rent” are not the same budget line. Clarify locally before booking."),
            ("res-q6", "Can I use direct payments for a short break?", "Many people can, when it fits their support plan. Ask your local authority what the payment can buy, what evidence they need, and how to record care vs lodging. Rules vary by council."),
            ("res-q7", "How can direct payments help fund a holiday?", "They can sometimes support care during a holiday-related package; the cottage rent may or may not be allowed. Get written clarity before booking. Restwell keeps the same bungalow tariff on every funding route and can invoice as agreed."),
            ("res-q8", "Can a personal budget support a holiday or short break?", "A Care Act personal budget (or personal health budget) may support assessed care needs during a break. Separate care costs from general holiday spending. Discuss wording with your social worker; we can supply property and access evidence."),
            ("res-q9", "How do I fund an accessible holiday with a personal budget?", "Talk to your social worker or care coordinator; explain outcomes the break supports; bring access specs and draft care hours; ask what the budget can and cannot pay; keep invoices clean."),
            ("res-q10", "Can I use my direct payments to pay for a holiday in England?", "Sometimes — if the break meets assessed outcomes and your local authority’s direct payment rules allow it. Check your individual care plan; do not assume rent is covered. Ask in writing before you pay a deposit."),
        ],
        lede="CHC, direct payments and personal budgets. Always confirm with your coordinator or local authority before you book.",
        band="band-subtle",
    )}
'''


def body_faq():
    items = [
        ("faq-q1", "Is Restwell open for bookings?", "Yes — we take bookings for 2026 and 2027. Send dates and access needs via the enquire form.", True, "booking"),
        ("faq-q2", "Do you allow assistance dogs?", "Yes. The bungalow is dog-friendly and welcomes assistance dogs. Please tell us in advance so we can complete a risk assessment. Water bowls and a toileting area are provided.", False, "property"),
        ("faq-q3", "Is parking available at the bungalow?", "Yes — driveway parking for two cars on a level surface, suitable for many adapted vehicles. Overflow usually works on the street outside; check signs on arrival.", False, "property"),
        ("faq-q4", "Where are hoist, wet-room and door-width details?", "On the <a class=\"text-link\" href=\"accessibility-concept.html\">Accessibility</a> page, with a fuller access statement PDF. We keep those answers there so they aren’t copied across the site.", False, "property"),
        ("faq-q5", "How do I arrange optional CQC care?", "See <a class=\"text-link\" href=\"how-it-works-concept.html#faq\">How It Works</a> for arranging Continuity of Care Services. Pricing covers whether care is in the bungalow rate.", False, "care"),
        ("faq-q6", "Is there a step-free train to Whitstable?", "Whitstable station has step-free access to both platforms via separate street-level entrances. It’s a short taxi ride from the bungalow — there’s a taxi office by the station exit. Ask us about accessible taxi notice periods.", False, "area"),
        ("faq-q7", "Is there a Changing Places or RADAR toilet nearby?", "Yes — at Whitstable Harbour on Harbour Road. A RADAR key is required. More local routes are on the <a class=\"text-link\" href=\"whitstable-guide-concept.html#faq\">Whitstable guide</a>.", False, "area"),
        ("faq-q8", "Can funding change the bungalow price?", "No. Same published rates for every guest — only who we invoice changes. Pathway questions (CHC, direct payments, personal budgets) are answered on <a class=\"text-link\" href=\"resources-concept.html#faq\">Funding &amp; Support</a>.", False, "funding"),
        ("faq-q9", "How does bungalow payment work?", "50% deposit to secure dates; balance due one week before arrival. BACS or card. See <a class=\"text-link\" href=\"pricing-concept.html#payment\">Pricing</a> for the full payment steps.", False, "funding"),
        ("faq-q10", "Cottage stay or care-home respite — which is right?", "That suitability comparison lives on <a class=\"text-link\" href=\"who-its-for-concept.html#faq\">Who It’s For</a>, with complex-care planning checklists there too.", False, "care"),
    ]
    list_html = faq_list_markup(items, measure=True)
    return f'''{hero("FAQ", "Questions before you enquire", "Accessibility, suitability, care and funding. Expand any question for detail.", [("homepage-concept.html", "Home"), (None, "FAQ")])}
    <section class="faq section-y band-white">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Common questions</p>
          <h2>Browse by topic</h2>
        </header>
        <ul class="pill-tabs" data-faq-filters role="tablist" aria-label="FAQ categories">
          <li><button type="button" data-filter="all" class="is-active" aria-selected="true">All</button></li>
          <li><button type="button" data-filter="property" aria-selected="false">About the property</button></li>
          <li><button type="button" data-filter="booking" aria-selected="false">Booking &amp; dates</button></li>
          <li><button type="button" data-filter="care" aria-selected="false">Care &amp; support</button></li>
          <li><button type="button" data-filter="area" aria-selected="false">The local area</button></li>
          <li><button type="button" data-filter="funding" aria-selected="false">Funding &amp; payments</button></li>
        </ul>
{list_html}      </div>
    </section>
    <section class="section-y band-subtle">
      <div class="container container--md">
        <header class="section-head">
          <p class="eyebrow">Still have a question?</p>
          <h2>Ask us directly</h2>
        </header>
        <form class="form-stack" action="#" method="get">
          <div class="field"><label for="ask-name">Name</label><input id="ask-name" name="name" autocomplete="name" /></div>
          <div class="field"><label for="ask-email">Email</label><input id="ask-email" name="email" type="email" autocomplete="email" required /></div>
          <div class="field"><label for="ask-q">Your question</label><textarea id="ask-q" name="question" required></textarea></div>
          <div class="form-actions"><button class="btn btn-gold" type="submit">Send question</button></div>
        </form>
      </div>
    </section>
{mid_cta("Prefer a conversation?", "Send dates and access needs — we usually reply within 48 hours.", secondary=("enquire-concept.html", "Go to enquire form"))}
'''


def body_enquire():
    return f'''{hero("Get in touch", "Let’s talk about your stay", "Dates, access needs, funding route — no commitment until you’re ready. We usually reply within 48 hours.", [("homepage-concept.html", "Home"), (None, "Enquire")])}
    <section class="section-y band-white">
      <div class="container layout-sidebar">
        <div>
          <div class="form-progress" aria-label="Form progress">
            <span class="is-current">1 · About you</span>
            <span>2 · Your stay</span>
            <span>3 · Your needs</span>
          </div>
          <form class="form-stack" action="enquire-concept.html" method="get">
            <input type="hidden" name="step" value="1" />
            <fieldset class="form-stack">
              <legend class="sr-only">About you</legend>
              <div class="form-grid form-grid--2">
                <div class="field"><label for="enq-name">Full name *</label><input id="enq-name" name="name" required autocomplete="name" /></div>
                <div class="field"><label for="enq-email">Email *</label><input id="enq-email" name="email" type="email" required autocomplete="email" /></div>
                <div class="field"><label for="enq-phone">Phone *</label><input id="enq-phone" name="phone" type="tel" required autocomplete="tel" /></div>
                <div class="field"><label for="enq-pref">Contact preference</label>
                  <select id="enq-pref" name="pref"><option>Email</option><option>Phone</option><option>Either</option></select>
                </div>
              </div>
              <div class="field"><label for="enq-time">Best time to call</label><input id="enq-time" name="best_time" placeholder="e.g. weekday mornings" /></div>
            </fieldset>
            <fieldset class="form-stack">
              <legend class="form-legend">Your stay</legend>
              <div class="form-grid form-grid--2">
                <div class="field"><label for="enq-from">Arrival (optional)</label><input id="enq-from" name="arrive" type="date" /></div>
                <div class="field"><label for="enq-to">Departure (optional)</label><input id="enq-to" name="depart" type="date" /></div>
                <div class="field"><label for="enq-guests">Guests</label><input id="enq-guests" name="guests" type="number" min="1" max="5" value="2" /></div>
                <div class="field"><label for="enq-fund">Funding type</label>
                  <select id="enq-fund" name="funding">
                    <option>Self-funded</option>
                    <option>Local authority / KCC</option>
                    <option>NHS Continuing Healthcare</option>
                    <option>Direct payment / PHB</option>
                    <option>Not sure yet</option>
                  </select>
                </div>
              </div>
              <div class="field"><label><input type="checkbox" name="urgent" /> This enquiry is time-sensitive</label></div>
            </fieldset>
            <fieldset class="form-stack">
              <legend class="form-legend">Your needs</legend>
              <div class="field"><label for="enq-care">Care requirements</label><textarea id="enq-care" name="care" placeholder="Optional — e.g. morning personal care, overnight support"></textarea></div>
              <div class="field"><label for="enq-access">Accessibility needs</label><textarea id="enq-access" name="access" placeholder="Equipment, doorway clearances, vehicle access…"></textarea></div>
              <div class="field"><label for="enq-msg">Message *</label><textarea id="enq-msg" name="message" required></textarea></div>
              <div class="field"><label><input type="checkbox" name="marketing" /> Keep me updated about Restwell (optional)</label></div>
            </fieldset>
            <div class="form-actions">
              <button class="btn btn-gold" type="submit">Send enquiry</button>
              <p class="hint">Mockup only — does not submit. Live success uses ?sent=1 on this same page.</p>
            </div>
          </form>
        </div>
        <aside class="sidebar-card" aria-label="Contact details">
          <h2>Talk to us</h2>
          <p><strong>Phone</strong><br /><a href="tel:01622809881">01622 809881</a></p>
          <p><strong>Email</strong><br /><a href="mailto:hello@restwellretreats.co.uk">hello@restwellretreats.co.uk</a></p>
          <p><strong>Property</strong><br />101 Russell Drive<br />Whitstable, CT5 2RQ</p>
          <p><a class="text-link" href="resources-concept.html">Funding &amp; support</a></p>
          <p><a class="text-link" href="who-its-for-concept.html">Who it’s for</a></p>
          <p><a class="text-link" href="property-concept.html">See the adapted bungalow</a></p>
        </aside>
      </div>
    </section>
'''


def body_guest():
    return f'''{hero("Guest information", "Your arrival guide", "Everything for a comfortable stay — verified guests only. Use the email on your booking confirmation.", [("homepage-concept.html", "Home"), (None, "Guest Guide")])}
    <section class="section-y band-white" id="gate">
      <div class="container container--sm">
        <header class="section-head">
          <p class="eyebrow">Step 1</p>
          <h2>Verify your email</h2>
          <p class="lede">Enter the email address used for your booking. We’ll send a one-time code.</p>
        </header>
        <form class="form-stack" action="#otp" method="get">
          <div class="field"><label for="gg-email">Booking email</label><input id="gg-email" name="email" type="email" required autocomplete="email" /></div>
          <div class="form-actions"><button class="btn btn-gold" type="submit">Send code</button></div>
        </form>
      </div>
    </section>
    <section class="section-y band-subtle" id="otp">
      <div class="container container--sm">
        <header class="section-head">
          <p class="eyebrow">Step 2</p>
          <h2>Enter your 6-digit code</h2>
          <p class="lede">Mockup state — paste any digits to preview the authenticated guide below.</p>
        </header>
        <form class="form-stack" action="#guide" method="get">
          <div class="field">
            <label for="otp-1">One-time code</label>
            <div class="otp-box" role="group" aria-label="Six digit code">
              <input id="otp-1" maxlength="1" inputmode="numeric" aria-label="Digit 1" />
              <input maxlength="1" inputmode="numeric" aria-label="Digit 2" />
              <input maxlength="1" inputmode="numeric" aria-label="Digit 3" />
              <input maxlength="1" inputmode="numeric" aria-label="Digit 4" />
              <input maxlength="1" inputmode="numeric" aria-label="Digit 5" />
              <input maxlength="1" inputmode="numeric" aria-label="Digit 6" />
            </div>
          </div>
          <div class="form-actions"><button class="btn btn-gold" type="submit">Unlock guide</button></div>
        </form>
      </div>
    </section>
    <section class="section-y band-white" id="guide">
      <div class="container">
        <header class="section-head">
          <p class="eyebrow">Authenticated</p>
          <h2>About your stay</h2>
          <p class="lede">Arrival-day voice — orientation, not sales. If anything in the house disagrees with your booking confirmation, call the number on that confirmation first.</p>
        </header>
        <div class="card-grid card-grid--2">
          <article class="info-card"><h3>Welcome</h3><p>The whole property is yours: your party only. 101 Russell Drive is a self-catering bungalow on a quiet street, about ten minutes from the seafront.</p></article>
          <article class="info-card"><h3>Arrival details</h3><p><strong>Address:</strong> 101 Russell Drive, Whitstable CT5 2RQ<br /><strong>what3words:</strong> ///taker.paints.called<br /><strong>Check-in:</strong> from 15:00 · <strong>Check-out:</strong> by 11:00</p></article>
          <article class="info-card"><h3>Getting in</h3><p>Access via key safe — code shared on your confirmation before arrival. Level driveway to the front door. Portable front-door ramps available if needed.</p></article>
          <article class="info-card"><h3>Wi‑Fi</h3><p><strong>Network:</strong> Russell Drive<br /><strong>Password:</strong> shared on confirmation / welcome pack<br />If it still fails after two careful tries, call 01622 809881.</p></article>
          <article class="info-card"><h3>Parking</h3><p>Two off-road spaces on the driveway. Overflow on the street outside — no residents’ permit scheme; still check signs on arrival.</p></article>
          <article class="info-card"><h3>House rules</h3><p>Dogs welcome with prior notice. No smoking or vaping inside. Keep noise low 10pm–8am. Maximum five guests. Keep walkways clear. Report damage straight away.</p></article>
          <article class="info-card"><h3>Bathroom note</h3><p>Please only flush toilet paper. Wipes, continence products and nappies go in the bathroom bin — plumbing blocks easily.</p></article>
          <article class="info-card"><h3>Before you leave</h3><p>No deep clean needed. Switch off lights/heating/appliances, close windows, leave used towels in the bathroom, pop bins out if it’s a collection day, lock up and return the key to the safe.</p></article>
          <article class="info-card"><h3>Local area</h3><p>Town centre ~15 minutes on foot. Tankerton promenade ~15 minutes for level coast. Tesco Extra ~7 minutes’ drive. Ask us for equipment hire contacts.</p></article>
          <article class="info-card"><h3>Emergencies</h3><p>999 first in an emergency, then tell us. Non-emergency medical: 111. Closest A&amp;E options include QEQM Margate and Kent &amp; Canterbury. Host line: 01622 809881 · hello@restwellretreats.co.uk</p></article>
          <article class="info-card"><h3>Your host</h3><p>Victoria Walker — Restwell Retreats. We’re here if heating, keys, Wi‑Fi or equipment need a hand during your stay.</p></article>
          <article class="info-card info-card--sand"><h3>Print / confirm</h3><p>Print this guide for the fridge if you like.</p>
            <label><input type="checkbox" /> I’ve read the guide</label>
          </article>
        </div>
      </div>
    </section>
'''


def body_blog():
    return f'''{hero("Guides &amp; articles", "Guides &amp; articles", "Practical accessible travel notes for Whitstable and the Kent coast — for wheelchair users, carers and planners.", [("homepage-concept.html", "Home"), (None, "Blog")])}
    <section class="section-y band-white">
      <div class="container">
        <article class="blog-featured">
          <img src="{S}/restwell-whitstable-coastline-panorama.webp" alt="Whitstable coastline" width="1000" height="625" loading="lazy" />
          <div>
            <p class="blog-meta"><span class="tag">Area guide</span><span>8 min read</span></p>
            <h2><a href="blog-single-concept.html">Accessible beaches and promenades near Whitstable</a></h2>
            <p class="lede">Where the paved coast actually works for chairs, and where shingle means choosing the promenade instead.</p>
            <a class="text-link" href="blog-single-concept.html">Read article</a>
          </div>
        </article>
        <div class="card-grid card-grid--2 u-mt-10">
          <article class="media-card">
            <img src="{S}/restwell-whitstable-marina-sunset.webp" alt="Marina at sunset" width="640" height="480" loading="lazy" />
            <p class="blog-meta"><span class="tag">Planning</span><span>5 min</span></p>
            <h3><a href="blog-single-concept.html">What to pack for an accessible coastal stay</a></h3>
            <p>A short list that assumes the hoist and wet room are already waiting.</p>
          </article>
          <article class="media-card">
            <img src="{S}/restwell-whitstable-drone-aerial-view.webp" alt="Aerial view of Whitstable" width="640" height="480" loading="lazy" />
            <p class="blog-meta"><span class="tag">Funding</span><span>6 min</span></p>
            <h3><a href="blog-single-concept.html">Direct payments and short breaks: a plain overview</a></h3>
            <p>How families and carers often start the conversation with their local authority.</p>
          </article>
        </div>
      </div>
    </section>
    <section class="section-y band-subtle">
      <div class="container">
        <header class="section-head section-head--center">
          <p class="eyebrow">Empty state</p>
          <h2>When there’s nothing published yet</h2>
        </header>
        <div class="empty-state">
          <h2>Guides coming soon</h2>
          <p>We’re writing practical notes on access, funding and the Kent coast. Meanwhile, the property and Whitstable pages cover the essentials.</p>
          <a class="btn btn-gold" href="whitstable-guide-concept.html">Read the Whitstable guide</a>
        </div>
      </div>
    </section>
'''


def body_blog_single():
    return f'''{hero("Area guide", "Accessible beaches and promenades near Whitstable", "A practical read on Tankerton’s level promenade, harbour realities, and why the shingle beach isn’t the whole story.", [("blog-concept.html", "Blog"), (None, "Article")])}
    <article class="section-y band-white">
      <div class="container">
        <p class="blog-meta"><span class="tag">Area guide</span><span>8 min read</span><span>Restwell team</span></p>
        <div class="prose prose--wide u-mt-6">
          <p>If you use a wheelchair or mobility scooter, Whitstable’s coast is more usable than many UK seaside towns — as long as you aim for the paved promenade, not the shingle.</p>
          <h2>Start at Tankerton</h2>
          <p>From Restwell, Tankerton promenade is about a 15-minute walk. The path is wide, level and surfaced for several miles. The grassy slopes above are steep; stay on the paved seafront route. Free parking is often available along Marine Parade at the top.</p>
          <h2>Harbour and town</h2>
          <p>Harbour Street can be narrow, and some shop entrances are stepped. The harbour has a Changing Places toilet (RADAR key) and uneven surfaces in places. Take it steady, and call venues ahead if you need a table with step-free access.</p>
          <h2>The honest beach note</h2>
          <p>The beach itself is shingle. Chairs don’t roll well on it. Guests who want sea air without fighting the stones use the promenade above — that’s the accessible coastal experience we describe on the area guide.</p>
          <p><a href="whitstable-guide-concept.html">Full Whitstable guide</a> · <a href="accessibility-concept.html">Property accessibility</a></p>
        </div>
        <p class="blog-meta u-mt-8"><span class="tag">Whitstable</span><span class="tag">Access</span><span class="tag">Promenade</span></p>
      </div>
    </article>
    <section class="section-y band-subtle">
      <div class="container">
        <header class="section-head"><h2>You might also like</h2></header>
        <div class="card-grid card-grid--3">
          <article class="media-card"><img src="{S}/restwell-whitstable-beach-relaxation.webp" alt="" width="640" height="480" loading="lazy" /><h3><a href="blog-single-concept.html">What to pack</a></h3></article>
          <article class="media-card"><img src="{B}/WHIT-SEAFRONT-2-LS.jpg" alt="" width="640" height="480" loading="lazy" /><h3><a href="whitstable-guide-concept.html">Whitstable guide</a></h3></article>
          <article class="media-card"><img src="{B}/entrance.png" alt="" width="640" height="480" loading="lazy" /><h3><a href="property-concept.html">The property</a></h3></article>
        </div>
      </div>
    </section>
'''


def body_privacy():
    return f'''{hero("Your information", "Privacy Policy", "How Homely Housing Investments Ltd t/a Restwell Retreats collects, uses and looks after personal data.", [("homepage-concept.html", "Home"), (None, "Privacy Policy")])}
    <section class="section-y band-white">
      <div class="container prose prose--wide">
        <p>This policy explains what we collect when you enquire, book, or browse the website, how long we keep it, and your rights under UK GDPR.</p>
        <h2>Who we are</h2>
        <p>Homely Housing Investments Ltd trading as Restwell Retreats is the data controller for booking and enquiry data. Care arranged with Continuity of Care Services is handled under their own privacy terms.</p>
        <h2>What we collect</h2>
        <p>Name, contact details, stay dates, access and care notes you choose to share, payment references, and basic website analytics/cookies as described below.</p>
        <h2>Cookies</h2>
        <p>We use essential cookies to run the site and optional analytics if you consent. You can change cookie preferences in your browser.</p>
        <h2>Retention</h2>
        <p>Enquiry records are kept only as long as needed to respond and, where a booking follows, for accounting and legal requirements.</p>
        <h2>Your rights</h2>
        <p>You can ask for access, correction, deletion, or restriction where applicable. Email hello@restwellretreats.co.uk. You may also complain to the ICO.</p>
        <h2>Changes</h2>
        <p>We may update this page; the version published here is current for this mockup.</p>
      </div>
    </section>
'''


def body_terms():
    return f'''{hero("Bookings", "Terms &amp; Conditions", "Booking, payment, cancellation, accessibility, house rules, optional care and liability for Restwell stays.", [("homepage-concept.html", "Home"), (None, "Terms & Conditions")])}
    <section class="section-y band-white">
      <div class="container prose prose--wide">
        <p>These terms apply when you book 101 Russell Drive through Restwell Retreats (Homely Housing Investments Ltd).</p>
        <h2>The booking</h2>
        <p>A booking is confirmed when we accept your deposit. Maximum occupancy is five guests unless agreed in writing.</p>
        <h2>Accessibility requirements</h2>
        <p>Published access information is provided in good faith. Tell us about equipment and access needs when you enquire so we can confirm suitability.</p>
        <h2>Payment</h2>
        <p>A 50% deposit secures your dates. The balance is due no later than one week before arrival unless we agree otherwise in writing. We accept bank transfer (BACS) and debit or credit card.</p>
        <h2>Cancellation</h2>
        <p>More than 30 days before arrival: deposit refundable minus an admin fee as stated on your confirmation. 14–30 days: partial forfeiture. Under 14 days: balance typically due. Exceptional circumstances are considered case by case.</p>
        <h2>Date changes</h2>
        <p>Subject to availability; we will help where we can.</p>
        <h2>Check-in and check-out</h2>
        <p>Check-in from 15:00; check-out by 11:00. Flexible times for accessibility or care reasons may be possible with notice.</p>
        <h2>Equipment</h2>
        <p>Use accessibility equipment as intended. Report faults immediately. Do not remove installed kit from the property.</p>
        <h2>Dogs</h2>
        <p>Allowed with prior notice and risk assessment. Assistance dogs welcome. Keep dogs off furniture; tidy the garden before departure.</p>
        <h2>Smoking</h2>
        <p>No smoking or vaping inside. Outside only, with windows closed so smoke does not drift indoors.</p>
        <h2>Care support</h2>
        <p>Optional care is contracted with Continuity of Care Services, not included in the accommodation fee.</p>
        <h2>Liability</h2>
        <p>We maintain public liability insurance. You are responsible for sensible use of the property and for guests in your party.</p>
        <h2>Contact</h2>
        <p>01622 809881 · hello@restwellretreats.co.uk</p>
      </div>
    </section>
'''


def body_a11y_policy():
    return f'''{hero("Digital access", "Website accessibility statement", "How we aim to make restwellretreats.co.uk usable, how we test, and how to get content in another format.", [("homepage-concept.html", "Home"), (None, "Website accessibility")])}
    <section class="section-y band-white">
      <div class="container prose prose--wide">
        <p>This statement covers the Restwell Retreats website. It is separate from the <a href="accessibility-concept.html">property Accessibility page</a>, which describes the bungalow.</p>
        <h2>Our aim</h2>
        <p>We aim to meet WCAG 2.2 Level AA. We test key journeys including enquire, property information and funding content.</p>
        <h2>How we test</h2>
        <p>Manual keyboard checks, screen-reader spot checks, and automated audits on major templates. Known issues are prioritised by impact.</p>
        <h2>Property access information</h2>
        <p>Door widths, equipment and room-by-room notes live on the <a href="accessibility-concept.html">Accessibility</a> page and in the access statement PDF.</p>
        <h2>Third-party content</h2>
        <p>Embedded maps, payment or partner tools may not fully meet our standard. We choose alternatives where practical.</p>
        <h2>Feedback</h2>
        <p>Email hello@restwellretreats.co.uk or call 01622 809881 if you find a barrier or need information in another format.</p>
        <h2>Formal complaints</h2>
        <p>If you are not satisfied with our response, you can contact the Equality and Human Rights Commission (EHRC) for further advice.</p>
      </div>
    </section>
'''


def body_404():
    return f'''{hero("404", "We couldn’t find that page", "The link may be out of date. These destinations usually help.", [])}
    <section class="section-y band-white">
      <div class="container">
        <div class="help-links">
          <article class="info-card"><h3>The Property</h3><p>101 Russell Drive — rooms, equipment and photos.</p><a class="text-link" href="property-concept.html">View the bungalow</a></article>
          <article class="info-card"><h3>Enquire</h3><p>Dates, access needs, funding questions.</p><a class="text-link" href="enquire-concept.html">Send an enquiry</a></article>
          <article class="info-card"><h3>How it works</h3><p>From first question to key-safe arrival.</p><a class="text-link" href="how-it-works-concept.html">See the process</a></article>
        </div>
      </div>
    </section>
'''


def body_page():
    return f'''{hero("Page", "Generic content page", "Fallback template for simple WordPress pages — title, optional excerpt, then prose.", [("homepage-concept.html", "Home"), (None, "Sample page")])}
    <section class="section-y band-white">
      <div class="container prose prose--wide">
        <p>This mockup shows the default page layout: compact interior hero, readable measure, and calm typography matching the concept system.</p>
        <h2>Section heading</h2>
        <p>Editors can paste long-form content here. Links, lists and headings should inherit the shared prose styles without custom cards unless the content truly needs interaction.</p>
        <ul>
          <li>One job per section</li>
          <li>Generous vertical rhythm</li>
          <li>Shared header, footer and enquire CTA</li>
        </ul>
      </div>
    </section>
'''


def write_page(filename, title, active, body, **kwargs):
    path = ROOT / filename
    path.write_text(shell(title, active, body, **kwargs), encoding="utf-8")
    print("wrote", filename)


def main():
    write_page(
        "homepage-concept.html",
        "Homepage",
        "home",
        body_home(),
        interior=False,
        after=gallery_lightbox(),
        document_title="Wheelchair Accessible Holidays UK | Restwell Kent",
        description="Plan wheelchair accessible holidays in the UK at Restwell, a private Kent coast bungalow with step-free access, wet room, ceiling track hoist and clear access details.",
        extra_head=home_schema(),
    )
    write_page("index.html", "Mockup directory", "", body_index())
    write_page(
        "property-concept.html",
        "The Property",
        "property",
        body_property(),
        after=gallery_lightbox(),
    )
    write_page("how-it-works-concept.html", "How It Works", "hiw", body_hiw())
    write_page(
        "accessibility-concept.html",
        "Accessibility",
        "accessibility",
        body_accessibility(),
        after=gallery_lightbox(),
    )
    write_page("who-its-for-concept.html", "Who It’s For", "who", body_who())
    write_page("pricing-concept.html", "Pricing", "pricing", body_pricing())
    write_page(
        "care-concept.html",
        "Optional care",
        "care",
        body_care(),
        document_title="Optional CQC Care for Accessible Whitstable Holidays | Restwell",
        description="Arrange optional CQC-regulated care with Continuity of Care Services, Restwell’s sister company, on the same phone line as your accessible Whitstable bungalow booking.",
    )
    write_page("whitstable-guide-concept.html", "Whitstable guide", "whitstable", body_whitstable())
    write_page("resources-concept.html", "Funding & Support", "resources", body_resources())
    write_page("faq-concept.html", "FAQ", "faq", body_faq())
    write_page("enquire-concept.html", "Enquire", "enquire", body_enquire())
    write_page("guest-guide-concept.html", "Guest Guide", "guest", body_guest())
    write_page("blog-concept.html", "Blog", "blog", body_blog())
    write_page("blog-single-concept.html", "Blog article", "blog", body_blog_single())
    write_page("privacy-concept.html", "Privacy Policy", "privacy", body_privacy())
    write_page("terms-concept.html", "Terms & Conditions", "terms", body_terms())
    write_page("accessibility-policy-concept.html", "Website accessibility", "a11y_policy", body_a11y_policy())
    write_page("404-concept.html", "Page not found", "404", body_404())
    write_page("page-concept.html", "Sample page", "page", body_page())
    print("done")


if __name__ == "__main__":
    main()
