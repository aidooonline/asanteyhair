# Asantey Hair & Beauty — Complete Project Handover
**Date:** April 2026  
**Repo:** https://github.com/aidooonline/asanteyhair.git  
**Live site:** https://asanteyhair.com  
**Server:** cPanel hosting — Namecheap  
**Server path:** `/home/asannmly/public_html/wp-content/themes/asanteyhair/`  
**Deploy command:** `cd /home/asannmly/public_html/wp-content/themes/asanteyhair && git pull origin main`

---

## 1. BUSINESS DETAILS

| Field | Value |
|-------|-------|
| Brand | Asantey Hair & Beauty |
| Address | 358 Radford Road, Nottingham NG7 5GQ |
| Phone / WhatsApp | 07827 129797 (intl: 447827129797) |
| Booking URL | https://asanteyhair.as.me/ |
| Instagram | @ahb_salon |
| TikTok | @ahbsalon |
| Owner | Stephen (Captivo Digital Ltd) |

---

## 2. WHAT HAS BEEN BUILT

A fully custom WordPress theme (no page builders, no WooCommerce). Built from scratch by this agent over a long session. Covers:

- Complete design system (CSS tokens, typography, components)
- Homepage with hero slider, category cards, product grid, split section, gallery, testimonials, CTA
- 14 inner page templates (shop, raw hair, virgin hair, closures, gallery, about, contact, FAQ, salon, order, care guide, shipping, privacy, terms)
- Full WordPress Customizer integration (all content editable without touching code)
- Custom Post Type: `hair_product` with ACF meta fields
- AJAX forms (contact, order enquiry, newsletter)
- Schema markup (FAQ, Article, BreadcrumbList, LocalBusiness)
- SEO meta tags, Open Graph
- Hero slider with image + YouTube video + MP4 video support
- Lightbox gallery
- Accordion FAQ
- Pricing tables (8 product types, all lengths)
- WhatsApp floating button + order URLs
- Mobile nav (full-screen black takeover)
- Scroll reveal animations
- Self-hosted fonts (Cormorant Garamond + Jost, 14 woff2 files)

---

## 3. DESIGN SYSTEM

### Colors (CSS tokens in style.css :root)
```css
--ink:   #000000   /* primary black — text, buttons, borders */
--dim:   #0c0c0c   /* body background — near-black */
--mid:   #1a1a1a   /* card backgrounds on dark sections */
--paper: #ffffff   /* white */
--off:   #f8f8f8   /* light grey sections */
--gold:  #c9a47e   /* ONLY used on price figures and 1 accent rule */
--g3:    #333333
--g5:    #555555
--g9:    #999999
```

### Fonts
- **Display/headings:** Cormorant Garamond (300, 400, 500, 600, 700 — normal + italic)
- **Body/UI:** Jost (300, 400, 500, 600)
- Self-hosted woff2 in `assets/fonts/`, declared in `assets/css/main.css`

### Section Modifiers
```
.s           dark background (var(--dim) = #0c0c0c)
.s--sm       smaller padding, dark
.s--white    white background, all child text switches to black
.s--off      #f8f8f8 grey background
.s--mid      #1a1a1a background
```
**Rule:** Homepage uses dark `.s` sections. Inner pages content sections use `.s--white` or `.s--off`.

### Header
- Always white, `position:fixed`, height `88px` (`--hh`)
- Logo left → Nav centre (space-evenly) → Order Now button right (margin-left:auto)
- Hides on scroll down, reappears on scroll up
- Admin bar: `padding-top:32px` on `.hdr` when `.admin-bar` class present

### Button Classes
```
.btn--w      white filled, black text (hover: transparent)
.btn--ow     outline white (for use on dark backgrounds)
.btn--ob     outline black (for use on white backgrounds)
.btn--bk     black filled, white text
.btn--wa     WhatsApp green
.btn--sm     smaller padding variant
.btns        flex container for button groups
```
**Aliases:** `.btn--black`, `.btn--outline`, `.btn--outline-white`, `.btn-group` also defined

---

## 4. FILE STRUCTURE

```
asantey-theme/
├── style.css                    # Full design system (~1176 lines)
├── functions.php                # Theme setup, CPT, menus, image sizes
├── header.php                   # Site header — logo, nav, Order Now button
├── footer.php                   # Footer — newsletter, columns, legal bar
├── front-page.php               # Homepage (all content via Customizer)
├── page.php                     # Default page template
├── index.php                    # Archive fallback
├── single.php                   # Single product post
├── 404.php                      # 404 page
├── search.php                   # Search results
│
├── inc/
│   ├── customizer.php           # All Customizer settings + live preview
│   ├── custom-post-types.php    # hair_product CPT + hair_category/texture taxonomies
│   ├── acf-fields.php           # ACF field registration (requires ACF Pro plugin)
│   ├── seo.php                  # Schema JSON-LD, OG meta, breadcrumbs
│   ├── forms.php                # AJAX handlers: contact, order, newsletter
│   ├── template-tags.php        # ah_svg(), ah_product_card(), ah_pricing_table(),
│   │                            # ah_stars(), ah_breadcrumb(), ah_whatsapp_url(),
│   │                            # ah_get_pricing(), ah_newsletter_form(),
│   │                            # ah_contact_form(), ah_order_form()
│   └── meta-boxes.php           # Product custom fields meta boxes
│
├── assets/
│   ├── css/main.css             # @font-face declarations only
│   ├── js/main.js               # All JS: slider, header, hamburger, lightbox,
│   │                            # accordion, forms, reveal, filter, dropdowns
│   ├── fonts/                   # 14 × woff2 (Cormorant Garamond + Jost)
│   └── images/
│       ├── client-result-1~7.jpg    # Real salon client photos (portrait 3:4)
│       ├── raw-*.jpg                # Product shots (1000x1000)
│       ├── virgin-body-wave.png     # Product shot
│       ├── closures-frontals-pricelist.jpg
│       ├── hd-lace-sizes.png
│       ├── hero-main/about/shop/gallery/product.jpg  # 1920x900 hero crops
│       └── logo.jpg
│
├── page-templates/
│   ├── page-shop.php            # /shop/ — filter bar + product grid
│   ├── page-raw-hair.php        # /raw-hair/ — texture grid + pricing
│   ├── page-virgin-hair.php     # /virgin-hair/ — texture grid + pricing
│   ├── page-closures.php        # /closures-frontals/ — size guide + 6 pricing tables
│   ├── page-gallery.php         # /gallery/ — masonry gallery + lightbox
│   ├── page-about.php           # /about/ — story + values + stats
│   ├── page-contact.php         # /contact/ — form + map + social
│   ├── page-faq.php             # /faq/ — categorised accordion
│   ├── page-salon.php           # /salon-services/ — service image cards + booking
│   ├── page-order.php           # /order/ — order form + how it works
│   ├── page-care-guide.php      # /hair-care-guide/ — long-form guide
│   ├── page-shipping.php        # /shipping-returns/
│   ├── page-privacy.php         # /privacy-policy/
│   ├── page-terms.php           # /terms-conditions/
│   └── elementor-*.php          # Elementor compatibility stubs
│
└── template-parts/
    └── nav-mobile.php           # Full-screen black mobile nav
```

---

## 5. CUSTOMIZER SETTINGS

All content is editable via **WP Admin → Appearance → Customize → Asantey Hair & Beauty**.

### Panel: Asantey Hair & Beauty
- **Hero Slides** — 3 slides max. Each slide has:
  - Type: `image` / `video` (YouTube URL or MP4 URL) / `disabled`
  - Image upload
  - Video URL
  - Label (eyebrow text)
  - Title (line 1)
  - Italic line (line 2, renders in italic)
  - Subtitle paragraph
  - CTA Button 1: text + URL
  - CTA Button 2: text (links to WhatsApp)

- **Homepage Content** — labels and titles for every section: categories, why, products, gallery, story (title + 2 paragraphs + image), testimonials (3 quotes + authors), CTA band

- **Pricing** — 8 product types × multiple lengths:
  - `raw` — Raw Hair (per bundle)
  - `virgin` — Virgin Hair (per bundle)
  - `2x6`, `4x4`, `5x5`, `6x6` — Closure sizes
  - `13x4`, `13x6` — Frontal sizes
  - Accessed in PHP via `ah_get_pricing($type)` → returns array of length → price

- **Contact Details** — phone, email, WhatsApp number, address, hours, Google Maps embed URL, booking URL

- **Social Media** — Instagram, Facebook, TikTok, YouTube URLs

- **Footer** — tagline, copyright text

- **Brand Colors** — override any of the 7 CSS tokens

---

## 6. KEY PHP FUNCTIONS (inc/template-tags.php)

```php
ah_svg( $icon, $class = '' )
// Returns inline SVG with width=20 height=20
// Icons: whatsapp, instagram, facebook, tiktok, youtube, phone, mail,
//        location, clock, star, check, arrow-right, arrow-down, plus,
//        gem, shield, heart, sparkle, close, zoom, truck

ah_whatsapp_url( $message = '' )
// Returns WhatsApp click-to-chat URL with pre-filled message
// Uses ah_whatsapp_number from Customizer (default: 447827129797)
// IMPORTANT: Never use contractions in $message strings (no apostrophes)
// WRONG: 'I'd like to order' → CORRECT: 'I would like to order'

ah_get_pricing( $type )
// Returns array of [ '10"' => '60', '12"' => '60', ... ] for given product type
// Types: raw, virgin, 2x6, 4x4, 5x5, 6x6, 13x4, 13x6

ah_pricing_table( $type, $caption = '', $note = '' )
// Outputs complete HTML pricing table for given type
// Uses .price-table CSS class

ah_product_card( WP_Post $post )
// Outputs complete product card HTML from CPT post
// Falls back gracefully if ACF fields not filled

ah_breadcrumb()
// Outputs breadcrumb nav using .bc CSS class

ah_stars( $count = 5 )
// Returns star SVG icons wrapped in .tcard__stars div

ah_schema_faq( $faqs )    // JSON-LD FAQ schema
ah_schema_breadcrumb( $items )   // JSON-LD BreadcrumbList schema
ah_schema_article( $title, $desc, $date )  // JSON-LD Article schema

ah_contact_form()    // AJAX contact form HTML
ah_order_form()      // AJAX order enquiry form HTML
ah_newsletter_form() // AJAX newsletter signup HTML
```

---

## 7. KNOWN BUGS & ISSUES (as of April 2026)

### HIGH PRIORITY -- Visual bugs currently on site

**1. Salon page -- service card images** -- PARTIALLY FIXED
- Code paths now correctly reference `AH_URI.'/assets/images/braids.jpg'` etc. (double-path bug fixed)
- IMPORTANT: All images MUST feature Black women/models -- this is a Black hair and beauty brand
- Images still need to be downloaded to the server. Find appropriate photos on Pexels:
  - braids.jpg: Search "black woman box braids" -- e.g. pexels.com/search/black%20woman%20box%20braids/
  - cornrows.jpg: Search "black woman cornrows" -- confirmed ID 5672900 (Samson Okeniyi, Lagos)
  - hair-treatment.jpg: Search "black woman hair salon treatment"
  - sew-in.jpg: Search "black woman sew in weave hair"
  - closure.jpg: Search "black woman lace closure frontal hair"
  - natural-hair.jpg: Search "black woman natural curly hair beauty"
  - lash-extensions.jpg: Search "black woman eyelash extensions beauty"
  - eyebrow-wax.jpg: Search "black woman eyebrow beauty close up"
  - eyebrow-thread.jpg: Search "black woman eyebrow threading"
- Download format (replace {ID} with the Pexels photo ID you choose):
  ```bash
  cd /home/asannmly/public_html/wp-content/themes/asanteyhair/assets/images
  curl -Lo braids.jpg "https://images.pexels.com/photos/{ID}/pexels-photo-{ID}.jpeg?w=600"
  curl -Lo cornrows.jpg "https://images.pexels.com/photos/5672900/pexels-photo-5672900.jpeg?w=600"
  # ... repeat for each image with your chosen Pexels photo ID
  ```

**2. Dark sections on inner pages** -- FIXED (commit 280076f)
- raw-hair, virgin-hair, closures: all content sections changed to `.s.s--white`

**3. Hero images -- all pages** -- OPEN (server-side task)
- All page heroes still use square product images as landscape backgrounds
- Fix: Download proper landscape hero images from Pexels on the server

**4. Favicon** -- FIXED (commit 280076f)
- SVG favicon added (`assets/images/favicon.svg`) with wp_head fallback
- Client can override via WP Admin Site Identity

### MEDIUM PRIORITY

**5. Contact page -- no Google Maps** -- OPEN (client task)
- Fix: Client needs to add Google Maps embed URL in Customizer

**6. Gallery overlay missing class** -- FIXED (was already correct in codebase)

**7. Contact page inline style** -- FIXED (commit 280076f)
- Inline `<style>` removed; `.s--white .contact-socials` overrides added to style.css

**8. Salon page -- contact item icon wrappers** -- FIXED (was already correct)

### LOW PRIORITY

**9. Product cards use fallback data** -- OPEN (client task)
- No `hair_product` CPT posts created yet
- Fix: Create products in WP Admin with ACF fields

**10. Booking URL hardcoded** -- FIXED (commit 280076f)
- footer.php, front-page.php, nav-mobile.php all now use `get_theme_mod('ah_booking_url')`

**11. Newsletter form has no backend** -- OPEN
- AJAX handler exists but no email service integration
- Fix: Connect to Mailchimp API or similar

---

## 8. WHAT STILL NEEDS TO BE DONE

### Content (client's responsibility)
- [ ] Upload real hero images for each page via Customizer
- [ ] Add Google Maps embed URL in Customizer
- [ ] Set up a WordPress nav menu via WP Admin
- [ ] Create hair_product CPT posts via WP Admin
- [ ] Fill in Customizer Contact Details and Social Media URLs
- [ ] Connect newsletter form to Mailchimp or email service

### Server-side (SSH required)
- [ ] Download salon service images (curl commands in section 7, issue #1)
- [ ] Download proper landscape hero images from Pexels
- [ ] Deploy: `cd /home/asannmly/public_html/wp-content/themes/asanteyhair && git pull origin main`

### Code (developer's responsibility)
- [x] Fix dark `.s` sections on raw-hair, virgin-hair, closures pages
- [x] Fix salon page double-path img src bug
- [x] Fix gallery overlay span class
- [x] Fix contact page inline style block
- [x] Replace hardcoded booking URLs with Customizer setting
- [x] Add responsive fixes for texture-grid (4-col > 3-col > 2-col)
- [x] Add SVG favicon with wp_head fallback
- [x] Verify accordion works on raw-hair and virgin-hair pages
- [ ] Add lazy loading + proper srcset for hero images (blocked on proper hero images)
- [ ] Implement newsletter form backend (Mailchimp integration)
- [ ] Test on mobile thoroughly

---

## 9. CRITICAL RULES — MUST FOLLOW

1. **NO em dashes (`—`) anywhere in PHP strings** — use regular hyphens or `&mdash;` in HTML only
2. **NO apostrophes/contractions in PHP single-quoted strings** — they break the parser
   - WRONG: `ah_whatsapp_url("I'd like to order")` 
   - RIGHT: `ah_whatsapp_url("I would like to order")`
3. **Always use `--transpile-only`** is NOT relevant here (that's WebsitesGH project)
4. **Deploy is via git** — `git pull origin main` in server theme directory
5. **PHP check before committing:** `php -l filename.php && echo "OK"`
6. **Version:** Always bump `AH_VERSION` in functions.php when deploying major changes
7. **Images:** All images in `assets/images/` — referenced via `AH_URI.'/assets/images/filename.jpg'`
8. **Fonts:** Self-hosted only — never load from Google Fonts CDN

---

## 10. CSS CLASS REFERENCE — BOTH OLD AND NEW NAMES WORK

The CSS has aliases so both naming conventions work:

| Old name | New name | Notes |
|----------|----------|-------|
| `.btn--black` | `.btn--bk` | Both defined |
| `.btn--outline` | `.btn--ob` | Both defined |
| `.btn--outline-white` | `.btn--ow` | Both defined |
| `.btn-group` | `.btns` | Both defined |
| `.accordion__*` | `.acc__*` | Both defined |
| `.texture-item__*` | `.tx-item__*` | Both defined |
| `.trust-bar` | `.marquee-strip--dark` | Both defined |
| `.feature-card__*` | `.feat-card__*` | Both defined |
| `.ah-reveal` | `.reveal` | Both defined |
| `.section` | `.s` | `.section` NOT defined — use `.s` |
| `.ah-accordion` | `.acc` | Both defined |

---

## 11. HOW DEPLOYMENT WORKS

```bash
# On local machine (Claude environment or developer's machine):
git add -A
git commit -m "Description of changes"
git push origin main

# On server (SSH into cPanel terminal):
cd /home/asannmly/public_html/wp-content/themes/asanteyhair
git pull origin main

# If git pull doesn't update:
git fetch --all
git reset --hard origin/main

# PHP syntax check on server:
php -l front-page.php && echo "OK"
php -l page-templates/page-salon.php && echo "OK"

# WordPress debug log:
# Enable: set define('WP_DEBUG', true); define('WP_DEBUG_LOG', true); in wp-config.php
# View: tail -50 /home/asannmly/public_html/wp-content/debug.log
```

---

## 12. NEXT AGENT — RECOMMENDED APPROACH

1. **First:** Run `git log --oneline -5` on the server to confirm you have the latest code
2. **Second:** Read this document fully before making any changes
3. **Third:** Fix issues in this order:
   - Download salon service images (curl commands in section 7, issue #1)
   - Fix dark sections on raw-hair, virgin-hair, closures pages
   - Fix gallery span class
   - Fix contact page inline style
4. **For any new page/section:** Always check the CSS token reference in section 3
5. **Test PHP** before every push: `php -l filename.php`
6. **Never change** colors, backgrounds, or the global design system unless explicitly asked
7. **Screenshot workflow:** If visual bugs are reported, ask for screenshots first — do not guess what's wrong

---

## 13. REPO STRUCTURE SUMMARY

```
github.com/aidooonline/asanteyhair
Branch: main
Latest commit: 280076f
Git user: Aidoo Stephen <aidooonline@gmail.com>
```

