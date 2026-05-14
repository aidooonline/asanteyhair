<?php
/**
 * Creates the Virgin Hair page in WordPress with correct template
 * Visit: https://asanteyhair.com/create-virgin-page.php
 * DELETE after running.
 */
require_once dirname(__FILE__) . '/wp-load.php';
if (!current_user_can('manage_options')) die('Not authorised.');

// Check if page already exists
$existing = get_page_by_path('virgin-hair');

if ($existing) {
    // Update template if page exists but template is wrong
    update_post_meta($existing->ID, '_wp_page_template', 'page-templates/page-virgin-hair.php');
    echo '<p>Page already exists (ID: '.$existing->ID.'). Template updated.</p>';
    $page_id = $existing->ID;
} else {
    // Create the page
    $page_id = wp_insert_post([
        'post_title'   => 'Virgin Hair',
        'post_name'    => 'virgin-hair',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ]);
    update_post_meta($page_id, '_wp_page_template', 'page-templates/page-virgin-hair.php');
    echo '<p>✅ Virgin Hair page created (ID: '.$page_id.')</p>';
}

echo '<p>✅ Template set to: page-templates/page-virgin-hair.php</p>';
echo '<p><a href="'.admin_url('post.php?post='.$page_id.'&action=edit').'">→ Edit page in WP Admin</a></p>';
echo '<p><a href="'.home_url('/virgin-hair/').'">→ View page on site</a></p>';
echo '<p style="color:red;font-weight:bold;">DELETE this file now: /public_html/create-virgin-page.php</p>';
