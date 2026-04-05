# Asantey Hair & Beauty — Agent Handover Document
**Last updated:** April 2026  
**Repo:** https://github.com/aidooonline/asanteyhair.git  
**Live site:** https://asanteyhair.com  
**Server path:** /home/asannmly/public_html/wp-content/themes/asanteyhair/  
**Deploy:** `git pull origin main` inside server path

---

## Business Details
- **Brand:** Asantey Hair & Beauty
- **Address:** 358 Radford Road, Nottingham NG7 5GQ
- **Phone/WhatsApp:** 07827 129797 (international: 447827129797)
- **Booking:** https://asanteyhair.as.me/
- **Instagram:** @ahb_salon | **TikTok:** @ahbsalon

---

## Theme Architecture
- **Theme version:** 3.0.0 (custom WordPress theme, no plugins required)
- **Fonts:** Cormorant Garamond (serif) + Jost (sans) — self-hosted woff2 in assets/fonts/
- **Design:** Pure black (#000) dominant, white sections for contrast, gold (#c9a47e) for prices only
- **JS:** assets/js/main.js (vanilla JS, no jQuery)
- **CSS:** style.css (all-in-one, ~1200 lines)
- **Font-face:** assets/css/main.css

## CSS Token Reference
```
--ink: #000000    --paper: #ffffff
--dim: #0c0c0c    --mid: #1a1a1a  
--off: #f8f8f8    --gold: #c9a47e
--serif: Cormorant Garamond
--sans: Jost
--hh: 88px (header height)
--max: 1600px (container width)
```

## Key CSS Classes
- Sections: `.s` `.s--sm` `.s--white` `.s--off` `.s--mid`
- Layout: `.wrap` `.wrap--mid` `.wrap--narrow` `.grid-2/3/4`
- Typography: `.t-display` `.t-h1/2/3/4` `.t-label` `.t-body` `.t-body--lg`
- Buttons: `.btn--w` `.btn--ow` `.btn--ob` `.btn--bk` `.btn--wa` `.btn--sm`
- Hero slider: `.hero-slider` `.hs-slide` `.hs-slide--active`
- Cards: `.product-card` `.cat-card` `.service-card` `.feat-card` `.tcard`
- Accordion: `.accordion` `.accordion__item` `.accordion__trigger` `.acc__q` `.acc__body` `.acc__ans`
- NOTE: Both `.acc__*` and `.accordion__*` class names work (aliases in CSS)

## File Structure
```
asantey-theme/
├── style.css              # Full design system
├── functions.php          # Theme setup, AH_VERSION: 3.0.0
├── header.php             # White header, logo left, nav centre, Order Now right
├── footer.php             # White bg, black text columns
├── front-page.php         # Homepage — all content from Customizer
├── inc/
│   ├── customizer.php     # ALL settings (hero slides, homepage content, pricing, contact)
│   ├── template-tags.php  # ah_svg(), ah_product_card(), ah_pricing_table(), ah_stars()
│   ├── custom-post-types.php
│   ├── forms.php          # AJAX contact/order/newsletter
│   ├── seo.php
│   └── meta-boxes.php
├── assets/
│   ├── css/main.css       # Font-face only
│   ├── js/main.js         # Slider, header, lightbox, accordion, reveal, forms
│   ├── fonts/             # 14 woff2 files
│   └── images/            # Product + client photos
└── page-templates/        # All inner page templates
```

## Customizer Sections (WP Admin → Appearance → Customize)
- **Hero Slides** — 3 slides, each: type (image/video/YouTube), image, video URL, label, title, italic, subtitle, CTA buttons
- **Homepage Content** — all section labels, titles, testimonials, story text/image, CTA
- **Pricing** — all 8 product types (raw, virgin, 2x6, 4x4, 5x5, 6x6, 13x4, 13x6)
- **Contact Details** — phone, email, WhatsApp, address, hours, Google Maps URL
- **Social Media** — Instagram, Facebook, TikTok, YouTube
- **Footer** — tagline, copyright
- **Brand Colors** — override tokens

## Known Issues / Things Still To Do
- Inner page icons: SVG size fix applied globally (width/height=20 on all ah_svg() output)
  but some pages may still show large icons if SVGs are placed without .contact-item__icon wrapper
- Gallery page: overlay icon span needs `.gallery-item__icon` class
- Contact page: inline `<style>` block for social icons should be moved to style.css
- FAQ page and other pages with black `.s` sections: add `.s--white` for readability
- Hero images: currently using Unsplash CDN URLs — owner should upload own photos via Customizer
- No favicon uploaded yet

## Critical Rules
- NO em dashes anywhere in code or content
- All WhatsApp URL strings use full words (no contractions — PHP apostrophe bug)
- `git pull origin main` to deploy on server
- PHP check: `php -l front-page.php && echo "ALL CLEAR"`
- Debug log: enable WP_DEBUG in wp-config.php if needed

## Page Templates
| Template | URL | Notes |
|----------|-----|-------|
| page-shop.php | /shop/ | Product grid + filter bar |
| page-raw-hair.php | /raw-hair/ | Texture grid + pricing table |
| page-virgin-hair.php | /virgin-hair/ | Texture grid + pricing table |
| page-closures.php | /closures-frontals/ | Size guide + 6 pricing tables |
| page-gallery.php | /gallery/ | Masonry gallery + lightbox |
| page-about.php | /about/ | Brand story + values + stats |
| page-contact.php | /contact/ | Form + map + social |
| page-faq.php | /faq/ | Categorised accordion FAQ |
| page-salon.php | /salon-services/ | Service image cards + booking |
| page-order.php | /order/ | Order form + how it works |
| page-care-guide.php | /hair-care-guide/ | Long-form guide + do/dont |
| page-shipping.php | /shipping-returns/ | Legal |
| page-privacy.php | /privacy-policy/ | Legal |
| page-terms.php | /terms-conditions/ | Legal |
