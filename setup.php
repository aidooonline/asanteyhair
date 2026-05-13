<?php
/**
 * Asantey Hair & Beauty — One-click setup
 * Run once after a fresh WordPress install.
 * Access: https://asanteyhair.com/wp-content/themes/asanteyhair/setup.php
 * DELETE THIS FILE after running it.
 */

// Bootstrap WordPress
$wp_load = dirname(__FILE__) . '/../../../wp-load.php';
if ( ! file_exists($wp_load) ) die('Cannot find wp-load.php');
require_once $wp_load;

if ( ! current_user_can('manage_options') ) die('Not authorised.');

$log = [];

// ── 1. Create pages ──────────────────────────────────────────────
$pages = [
    'home'             => ['title'=>'Home',                'template'=>''],
    'shop'             => ['title'=>'Shop',                'template'=>'page-templates/page-shop.php'],
    'raw-hair'         => ['title'=>'Raw Hair',            'template'=>'page-templates/page-raw-hair.php'],
    'virgin-hair'      => ['title'=>'Virgin Hair',         'template'=>'page-templates/page-virgin-hair.php'],
    'closures-frontals'=> ['title'=>'Closures & Frontals', 'template'=>'page-templates/page-closures.php'],
    'salon-services'   => ['title'=>'Salon Services',      'template'=>'page-templates/page-salon.php'],
    'gallery'          => ['title'=>'Gallery',             'template'=>'page-templates/page-gallery.php'],
    'about'            => ['title'=>'About Us',            'template'=>'page-templates/page-about.php'],
    'contact'          => ['title'=>'Contact',             'template'=>'page-templates/page-contact.php'],
    'faq'              => ['title'=>'FAQ',                 'template'=>'page-templates/page-faq.php'],
    'hair-care-guide'  => ['title'=>'Hair Care Guide',     'template'=>'page-templates/page-care-guide.php'],
    'order'            => ['title'=>'Order',               'template'=>'page-templates/page-order.php'],
    'shipping'         => ['title'=>'Shipping',            'template'=>'page-templates/page-shipping.php'],
    'privacy-policy'   => ['title'=>'Privacy Policy',     'template'=>'page-templates/page-privacy.php'],
    'terms'            => ['title'=>'Terms & Conditions',  'template'=>'page-templates/page-terms.php'],
];

$page_ids = [];
foreach ( $pages as $slug => $data ) {
    $existing = get_page_by_path($slug);
    if ( $existing ) {
        $page_ids[$slug] = $existing->ID;
        $log[] = "Page exists: {$data['title']} (ID {$existing->ID})";
        // Update template if needed
        if ( $data['template'] ) update_post_meta($existing->ID, '_wp_page_template', $data['template']);
    } else {
        $id = wp_insert_post([
            'post_title'   => $data['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ]);
        if ( $data['template'] ) update_post_meta($id, '_wp_page_template', $data['template']);
        $page_ids[$slug] = $id;
        $log[] = "Created page: {$data['title']} (ID $id)";
    }
}

// ── 2. Set homepage ──────────────────────────────────────────────
update_option('show_on_front', 'page');
update_option('page_on_front',  $page_ids['home']);
$log[] = "Homepage set to: Home (ID {$page_ids['home']})";

// ── 3. Set permalink structure ───────────────────────────────────
update_option('permalink_structure', '/%postname%/');
flush_rewrite_rules();
$log[] = "Permalinks set to /%postname%/ and flushed";

// ── 4. Create main navigation menu ──────────────────────────────
$menu_name = 'Main Navigation';
$menu_id   = wp_get_nav_menu_object($menu_name);
if ( ! $menu_id ) {
    $menu_id = wp_create_nav_menu($menu_name);
    $log[] = "Created menu: $menu_name";
} else {
    $menu_id = $menu_id->term_id;
    $log[] = "Menu exists: $menu_name";
}

$menu_items = ['shop','raw-hair','virgin-hair','closures-frontals','salon-services','gallery','about','contact'];
// Clear existing items
$existing_items = wp_get_nav_menu_items($menu_id);
if ($existing_items) {
    foreach ($existing_items as $item) wp_delete_post($item->ID, true);
}
foreach ( $menu_items as $slug ) {
    if ( isset($page_ids[$slug]) ) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'     => $pages[$slug]['title'],
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $page_ids[$slug],
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ]);
    }
}
$log[] = "Menu items created";

// ── 5. Assign menu to location ───────────────────────────────────
set_theme_mod('nav_menu_locations', ['primary' => $menu_id]);
$log[] = "Menu assigned to primary location";

// ── 6. WooCommerce permalink base ────────────────────────────────
if ( class_exists('WooCommerce') ) {
    update_option('woocommerce_permalinks', ['product_base' => 'hair-collection']);
    $log[] = "WooCommerce permalink base set to /hair-collection/";
}

// ── 7. Disable WooCommerce reCAPTCHA ─────────────────────────────
update_option('woocommerce_enable_recaptcha', 'no');
$log[] = "WooCommerce reCAPTCHA disabled";

?>
<!DOCTYPE html>
<html>
<head><title>Asantey Setup</title>
<style>body{font-family:monospace;padding:40px;background:#0c0c0c;color:#fff;} .ok{color:#4caf50;} .title{font-size:24px;margin-bottom:20px;color:#c9a47e;} .warn{background:#c9a47e;color:#000;padding:10px 20px;display:inline-block;margin-top:20px;font-weight:bold;}</style>
</head>
<body>
<p class="title">✅ Asantey Hair & Beauty — Setup Complete</p>
<?php foreach ($log as $l) echo '<p class="ok">✓ ' . esc_html($l) . '</p>'; ?>
<p class="warn">⚠️ DELETE THIS FILE NOW: /wp-content/themes/asanteyhair/setup.php</p>
<p style="margin-top:20px;"><a href="<?php echo home_url('/'); ?>" style="color:#c9a47e;">→ View Site</a> &nbsp; <a href="<?php echo admin_url(); ?>" style="color:#c9a47e;">→ WP Admin</a></p>
</body>
</html>
