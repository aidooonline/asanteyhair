# Asantey Hair & Beauty — WordPress Theme

**Version:** 1.0.0  
**Author:** Captivo Digital Ltd  
**Requires:** WordPress 6.0+, PHP 8.0+

---

## Theme Overview

Custom editorial luxury WordPress theme for Asantey Hair & Beauty. Features:

- 14 fully content-ready page templates
- Full Elementor Pro compatibility
- ACF Flexible Content blocks on every page
- Customizer for all site-wide settings and pricing
- AJAX forms with spam protection (Contact, Order Enquiry, Newsletter)
- SEO schema markup on all pages (LocalBusiness, Product, FAQPage, Article, BreadcrumbList)
- UK GEO signals, Google Maps embed, NAP consistency
- Self-hosted fonts (Cormorant Garamond + Jost)
- Mobile-first, fully responsive (640 / 768 / 1024px breakpoints)

---

## Required Plugins

| Plugin | Why |
|--------|-----|
| **ACF Pro** | Page builder flexible content blocks |
| **Elementor** or **Elementor Pro** | Page editing (full-width, canvas templates) |

---

## Installation

1. Zip the `asantey-theme/` directory
2. Go to **WP Admin → Appearance → Themes → Add New → Upload Theme**
3. Upload and activate the theme
4. On activation, all 14 pages are auto-created and products are seeded

---

## Customizer Guide

Go to **WP Admin → Appearance → Customize → Asantey Hair & Beauty**

### Hero Section
Set the homepage hero label, title, subtitle, CTA button text and URLs, and background image.

### Contact Details
- **Business Name** — Used in SEO schema and footer
- **Phone Number** — Displayed in footer and contact page
- **Email Address** — Used for form notifications and display
- **WhatsApp Number** — Enter in international format, e.g. `447911123456`
- **Full Address** — Displayed in footer and contact page
- **Business Hours** — e.g. `Mon–Sat: 9am–7pm`
- **Google Maps Embed URL** — The `src` value from the Google Maps iframe embed code. Get it from Google Maps → Share → Embed a map → copy only the URL inside `src="..."`

### Social Media
Enter the full URLs for Instagram, Facebook, TikTok, and YouTube.

### Footer
Set the brand tagline and copyright text.

### Brand Color Overrides
Override any of the 7 brand colours using the colour pickers. Changes apply site-wide via CSS custom properties.

### Pricing Tables (8 sections)
Each pricing section (Raw Hair, Virgin Hair, 2x6, 4x4, 5x5, 6x6, 13x4, 13x6) contains individual price fields per length. Update prices here and they automatically update all pricing tables across the site and the WhatsApp order links.

---

## How to Update Content

### Update Pricing
Go to **Customizer → Asantey Hair & Beauty → Pricing: [Product Type]** and update the price for each length. Changes reflect immediately across all pages.

### Update Contact Details
Go to **Customizer → Asantey Hair & Beauty → Contact Details**. Update any field. The Google Maps embed URL must be the full iframe `src` URL from Google Maps.

### Update the Hero Image
Go to **Customizer → Asantey Hair & Beauty → Hero Section → Background Image**. Upload a new image (recommended: 1920×1080px minimum).

### Update Gallery Images
Go to **WP Admin → Pages → Client Gallery → Edit with ACF** (or use Elementor if the page uses an Elementor template). The gallery section uses an ACF image repeater — add, remove, or reorder images without touching code.

### Add or Edit Page Sections
Every page has ACF Flexible Content blocks. In the page editor:
1. Open the page in WP Admin → Pages
2. Scroll to **Page Content Builder**
3. Add, remove, reorder, or edit any section
4. Available blocks: Hero, Text+Image Split, Feature Grid, Pricing Table, Product Grid, Gallery, CTA Band, Testimonials, FAQ Accordion, Text Block, Contact Info

These blocks are structured — the design container does not change when you update content fields.

### Add or Edit Products
Go to **WP Admin → Hair Products → Add New**. Fill in:
- Title
- Excerpt (short description shown on cards)
- Featured Image
- Product Details meta box: price from/to, lengths, image file, badge, featured status
- Hair Category taxonomy (raw-hair / virgin-hair / closures-frontals)
- Hair Texture taxonomy

Mark products as Featured to show them on the homepage spotlight.

### Update the Google Maps Pin
1. Go to [Google Maps](https://maps.google.com)
2. Search for the business address
3. Click **Share → Embed a map**
4. Copy only the URL inside `src="..."` from the iframe code
5. Paste this URL in **Customizer → Contact Details → Google Maps Embed URL**

---

## Form Email Configuration

Forms send to the email address set in **Customizer → Contact Details → Email Address**.

If this is not set, forms fall back to the WordPress admin email (Settings → General → Admin Email).

To connect to a third-party email marketing platform (Mailchimp, ConvertKit, etc.) for the newsletter form, edit `inc/forms.php` → `ah_handle_newsletter()` and replace the `wp_options` storage with the platform's API call.

---

## File Structure

```
asantey-theme/
├── style.css                          Theme metadata + design system
├── functions.php                      Core setup, enqueue, includes
├── header.php                         Global header + floating WhatsApp
├── footer.php                         4-col footer + newsletter strip
├── front-page.php                     Homepage (10 sections)
├── page.php                           Default page template
├── single.php                         Blog post template
├── archive.php                        Archive/CPT archive
├── search.php                         Search results
├── 404.php                            404 error page
│
├── page-templates/
│   ├── page-about.php                 About Us
│   ├── page-shop.php                  Shop — All Products
│   ├── page-raw-hair.php              Cambodian Raw Hair
│   ├── page-virgin-hair.php           Cambodian Virgin Hair
│   ├── page-closures.php              Closures & Frontals
│   ├── page-gallery.php               Client Gallery
│   ├── page-care-guide.php            Hair Care Guide (SEO)
│   ├── page-faq.php                   FAQ (24 Q&As + schema)
│   ├── page-contact.php               Contact + Google Map + Form
│   ├── page-order.php                 Order Enquiry Form
│   ├── page-shipping.php              Shipping & Returns
│   ├── page-privacy.php               Privacy Policy (GDPR)
│   ├── page-terms.php                 Terms & Conditions
│   ├── elementor-full-width.php       Elementor Full Width
│   └── elementor-canvas.php           Elementor Canvas
│
├── template-parts/
│   └── nav-mobile.php                 Mobile navigation overlay
│
├── inc/
│   ├── customizer.php                 All Customizer settings + helpers
│   ├── custom-post-types.php          hair_product CPT + taxonomies
│   ├── acf-fields.php                 ACF flexible content field groups
│   ├── seo.php                        Meta tags, OG, Twitter, schema
│   ├── forms.php                      AJAX form handlers + renderers
│   ├── template-tags.php              SVG icons, breadcrumb, card, pricing
│   └── meta-boxes.php                 Product custom fields meta box
│
├── assets/
│   ├── css/main.css                   Font-face + additional components
│   ├── js/main.js                     All JS interactions
│   ├── fonts/                         Self-hosted woff2 font files (14 files)
│   └── images/                        All product + client photos
│
└── README.md                          This file
```

---

## Deployment Checklist

- [ ] Set business name, phone, email, WhatsApp in Customizer
- [ ] Set UK address in Customizer → Contact Details
- [ ] Add Google Maps embed URL in Customizer → Contact Details
- [ ] Add Instagram, Facebook, TikTok, YouTube URLs in Customizer → Social Media
- [ ] Set homepage in **Settings → Reading → A static page → Front page: Home**
- [ ] Upload logo via **Appearance → Customize → Site Identity → Logo**
- [ ] Add custom logo (200×80px recommended) — until set, text logo renders
- [ ] Update hero background image via Customizer → Hero Section
- [ ] Mark featured products in Hair Products (Featured = Yes) for homepage grid
- [ ] Test contact form → confirm email arrives at admin inbox
- [ ] Test order form → confirm email arrives with order details
- [ ] Test newsletter form → confirm subscriber stored + email sent
- [ ] Verify Google Maps loads on Contact page
- [ ] Install ACF Pro and create field groups (or they register via code automatically)
- [ ] Install Elementor if client wants drag-and-drop editing
- [ ] Run Lighthouse / PageSpeed check
- [ ] Submit sitemap to Google Search Console

---

## CSS Naming Convention

All classes use the `ah-` prefix (Asantey Hair).  
All Customizer settings use the `ah_` prefix.  
All meta keys use the `_ah_` prefix.

---

## No Em Dashes

Per project conventions, no em dashes anywhere in this codebase or content. Middle dot (·), en dash (–), or comma used instead.

---

*Built by Captivo Digital Ltd*
