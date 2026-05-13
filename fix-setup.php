<?php
/**
 * Emergency fix — run once then delete
 * https://asanteyhair.com/wp-content/themes/asanteyhair/fix-setup.php
 */
require_once dirname(__FILE__) . '/../../../wp-load.php';
if (!current_user_can('manage_options')) die('Not authorised.');

$log = [];

// 1. Fix site title and tagline
update_option('blogname', 'Asantey Hair & Beauty');
update_option('blogdescription', 'Premium Cambodian Hair Extensions');
$log[] = 'Site title set';

// 2. Fix siteurl and home URL
update_option('siteurl', 'https://asanteyhair.com');
update_option('home',    'https://asanteyhair.com');
$log[] = 'Site URL fixed';

// 3. Create homepage and set it as front page
$home_id = get_page_by_path('home');
if (!$home_id) {
    $home_id = wp_insert_post(['post_title'=>'Home','post_name'=>'home','post_status'=>'publish','post_type'=>'page','post_content'=>'']);
    $log[] = 'Home page created ID: '.$home_id;
} else {
    $home_id = $home_id->ID;
    $log[] = 'Home page exists ID: '.$home_id;
}
update_option('show_on_front', 'page');
update_option('page_on_front',  $home_id);
$log[] = 'Homepage set';

// 4. Create all pages with templates
$pages = [
    ['title'=>'Shop',                'slug'=>'shop',               'tpl'=>'page-templates/page-shop.php'],
    ['title'=>'Raw Hair',            'slug'=>'raw-hair',           'tpl'=>'page-templates/page-raw-hair.php'],
    ['title'=>'Virgin Hair',         'slug'=>'virgin-hair',        'tpl'=>'page-templates/page-virgin-hair.php'],
    ['title'=>'Closures & Frontals', 'slug'=>'closures-frontals',  'tpl'=>'page-templates/page-closures.php'],
    ['title'=>'Salon Services',      'slug'=>'salon-services',     'tpl'=>'page-templates/page-salon.php'],
    ['title'=>'Gallery',             'slug'=>'gallery',            'tpl'=>'page-templates/page-gallery.php'],
    ['title'=>'About',               'slug'=>'about',              'tpl'=>'page-templates/page-about.php'],
    ['title'=>'Contact',             'slug'=>'contact',            'tpl'=>'page-templates/page-contact.php'],
    ['title'=>'FAQ',                 'slug'=>'faq',                'tpl'=>'page-templates/page-faq.php'],
    ['title'=>'Hair Care Guide',     'slug'=>'hair-care-guide',    'tpl'=>'page-templates/page-care-guide.php'],
    ['title'=>'Order',               'slug'=>'order',              'tpl'=>'page-templates/page-order.php'],
    ['title'=>'Shipping',            'slug'=>'shipping-returns',   'tpl'=>'page-templates/page-shipping.php'],
    ['title'=>'Privacy Policy',      'slug'=>'privacy-policy',     'tpl'=>'page-templates/page-privacy.php'],
    ['title'=>'Terms & Conditions',  'slug'=>'terms-conditions',   'tpl'=>'page-templates/page-terms.php'],
];
foreach ($pages as $p) {
    $existing = get_page_by_path($p['slug']);
    if (!$existing) {
        $id = wp_insert_post(['post_title'=>$p['title'],'post_name'=>$p['slug'],'post_status'=>'publish','post_type'=>'page','post_content'=>'']);
        update_post_meta($id, '_wp_page_template', $p['tpl']);
        $log[] = 'Created: '.$p['title'].' (ID '.$id.')';
    } else {
        update_post_meta($existing->ID, '_wp_page_template', $p['tpl']);
        $log[] = 'Updated template: '.$p['title'];
    }
}

// 5. Fix permalinks
update_option('permalink_structure', '/%postname%/');
flush_rewrite_rules(true);
$log[] = 'Permalinks flushed';

// 6. Create navigation menu
$menu_exists = wp_get_nav_menu_object('Main Navigation');
if (!$menu_exists) {
    $menu_id = wp_create_nav_menu('Main Navigation');
} else {
    $menu_id = $menu_exists->term_id;
    // Clear existing items
    foreach (wp_get_nav_menu_items($menu_id) ?: [] as $item) {
        wp_delete_post($item->ID, true);
    }
}
$nav_pages = ['shop'=>'Shop','raw-hair'=>'Raw Hair','virgin-hair'=>'Virgin Hair','closures-frontals'=>'HD Lace','salon-services'=>'Salon','gallery'=>'Gallery','faq'=>'FAQ','contact'=>'Contact'];
foreach ($nav_pages as $slug => $title) {
    $pg = get_page_by_path($slug);
    if ($pg) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'     => $title,
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $pg->ID,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ]);
    }
}
set_theme_mod('nav_menu_locations', ['primary' => $menu_id]);
$log[] = 'Navigation menu created';

// 7. Disable WooCommerce reCAPTCHA
update_option('woocommerce_enable_recaptcha', 'no');
if (class_exists('WooCommerce')) {
    update_option('woocommerce_permalinks', ['product_base'=>'hair-collection']);
}
$log[] = 'WooCommerce configured';

// 8. Disable maintenance mode
update_option('mm_coming_soon', '0');
update_option('maintenance_mode', '0');
delete_option('maintenance_mode_active');
$log[] = 'Maintenance mode disabled';

// 9. Activate theme properly  
switch_theme('asanteyhair');
$log[] = 'Theme activated: asanteyhair';

?><!DOCTYPE html>
<html>
<head>
<title>Asantey Fix</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{background:#0c0c0c;color:#fff;font-family:monospace;padding:40px;max-width:700px}
h1{color:#c9a47e;font-size:22px;margin-bottom:24px}
.item{padding:8px 0;border-bottom:1px solid #222;color:#4caf50;font-size:14px}
.item::before{content:'✓ ';color:#c9a47e}
.warn{background:#c9a47e;color:#000;padding:14px 20px;margin-top:30px;font-weight:bold;font-size:14px}
.btns{margin-top:24px;display:flex;gap:12px}
a.btn{background:#c9a47e;color:#000;padding:10px 20px;text-decoration:none;font-weight:bold;font-size:13px}
</style>
</head>
<body>
<h1>✅ Asantey Hair & Beauty — Setup Complete</h1>
<?php foreach ($log as $l): ?>
<div class="item"><?php echo esc_html($l); ?></div>
<?php endforeach; ?>
<div class="warn">⚠️ DELETE THIS FILE NOW — SSH: rm /home/asannmly/public_html/wp-content/themes/asanteyhair/fix-setup.php</div>
<div class="btns">
    <a href="<?php echo home_url('/'); ?>" class="btn">→ View Site</a>
    <a href="<?php echo admin_url(); ?>" class="btn">→ WP Admin</a>
</div>
</body>
</html>
