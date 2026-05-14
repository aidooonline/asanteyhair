<?php
/**
 * Check all WordPress pages and fix missing ones
 * Copy to /public_html/ then visit https://asanteyhair.com/check-pages.php
 * DELETE after use.
 */
require_once dirname(__FILE__) . '/wp-load.php';
if (!current_user_can('manage_options')) die('Not authorised.');

echo '<style>body{font-family:monospace;padding:20px;background:#111;color:#fff;} .ok{color:#4caf50} .miss{color:#f44336} .fix{color:#ff9800} a{color:#c9a47e}</style>';
echo '<h2 style="color:#c9a47e;">WordPress Pages Check</h2>';

// All pages that should exist
$required = [
    'home'              => ['title'=>'Home',                'tpl'=>''],
    'shop'              => ['title'=>'Shop',                'tpl'=>'page-templates/page-shop.php'],
    'raw-hair'          => ['title'=>'Raw Hair',            'tpl'=>'page-templates/page-raw-hair.php'],
    'virgin-hair'       => ['title'=>'Virgin Hair',         'tpl'=>'page-templates/page-virgin-hair.php'],
    'closures-frontals' => ['title'=>'Closures & Frontals', 'tpl'=>'page-templates/page-closures.php'],
    'salon-services'    => ['title'=>'Salon Services',      'tpl'=>'page-templates/page-salon.php'],
    'gallery'           => ['title'=>'Gallery',             'tpl'=>'page-templates/page-gallery.php'],
    'about'             => ['title'=>'About',               'tpl'=>'page-templates/page-about.php'],
    'contact'           => ['title'=>'Contact',             'tpl'=>'page-templates/page-contact.php'],
    'faq'               => ['title'=>'FAQ',                 'tpl'=>'page-templates/page-faq.php'],
    'hair-care-guide'   => ['title'=>'Hair Care Guide',     'tpl'=>'page-templates/page-care-guide.php'],
    'order'             => ['title'=>'Order',               'tpl'=>'page-templates/page-order.php'],
    'shipping-returns'  => ['title'=>'Shipping',            'tpl'=>'page-templates/page-shipping.php'],
    'privacy-policy'    => ['title'=>'Privacy Policy',      'tpl'=>'page-templates/page-privacy.php'],
    'terms-conditions'  => ['title'=>'Terms & Conditions',  'tpl'=>'page-templates/page-terms.php'],
];

$fixed = 0;
foreach ($required as $slug => $data) {
    $page = get_page_by_path($slug);
    if ($page) {
        $current_tpl = get_post_meta($page->ID, '_wp_page_template', true);
        if ($data['tpl'] && $current_tpl !== $data['tpl']) {
            update_post_meta($page->ID, '_wp_page_template', $data['tpl']);
            echo '<p class="fix">⚙ Fixed template: <strong>'.$data['title'].'</strong> (ID:'.$page->ID.') was:'.$current_tpl.' → '.$data['tpl'].'</p>';
            $fixed++;
        } else {
            echo '<p class="ok">✓ '.$data['title'].' (ID:'.$page->ID.') — <a href="'.admin_url('post.php?post='.$page->ID.'&action=edit').'">Edit</a></p>';
        }
    } else {
        // Create missing page
        $id = wp_insert_post([
            'post_title'   => $data['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ]);
        if ($data['tpl']) update_post_meta($id, '_wp_page_template', $data['tpl']);
        echo '<p class="fix">✚ Created missing page: <strong>'.$data['title'].'</strong> (ID:'.$id.') — <a href="'.admin_url('post.php?post='.$id.'&action=edit').'">Edit</a></p>';
        $fixed++;
    }
}

// Show all existing pages
echo '<hr style="border-color:#333;margin:20px 0;">';
echo '<h3 style="color:#c9a47e;">All pages in database:</h3>';
$all = get_pages(['post_status'=>['publish','draft','private'],'sort_column'=>'post_title']);
foreach ($all as $p) {
    $tpl = get_post_meta($p->ID, '_wp_page_template', true) ?: 'default';
    echo '<p class="ok">ID:'.$p->ID.' | '.$p->post_title.' | slug:'.$p->post_name.' | tpl:'.$tpl.' — <a href="'.admin_url('post.php?post='.$p->ID.'&action=edit').'">Edit</a></p>';
}

flush_rewrite_rules();
echo '<hr style="border-color:#333;margin:20px 0;">';
echo '<p class="ok">Permalinks flushed. Fixed '.$fixed.' issues.</p>';
echo '<p style="color:#f44336;font-weight:bold;">⚠ DELETE THIS FILE: rm /home/asannmly/public_html/check-pages.php</p>';
