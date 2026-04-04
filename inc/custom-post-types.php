<?php
/**
 * Asantey Hair & Beauty — Custom Post Types & Taxonomies
 */

defined( 'ABSPATH' ) || exit;

/* ============================================================
   CPT: hair_product
   ============================================================ */
add_action( 'init', function () {

    register_post_type( 'hair_product', [
        'labels' => [
            'name'               => 'Hair Products',
            'singular_name'      => 'Hair Product',
            'add_new'            => 'Add New Product',
            'add_new_item'       => 'Add New Hair Product',
            'edit_item'          => 'Edit Hair Product',
            'new_item'           => 'New Hair Product',
            'view_item'          => 'View Hair Product',
            'search_items'       => 'Search Hair Products',
            'not_found'          => 'No products found',
            'not_found_in_trash' => 'No products found in Trash',
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'hair-collection' ],
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ],
        'menu_icon'          => 'dashicons-store',
        'show_in_rest'       => true,
        'menu_position'      => 5,
        'capability_type'    => 'post',
    ] );

    /* --------------------------------------------------------
       TAXONOMY: hair_category
       -------------------------------------------------------- */
    register_taxonomy( 'hair_category', 'hair_product', [
        'labels' => [
            'name'          => 'Hair Categories',
            'singular_name' => 'Hair Category',
            'search_items'  => 'Search Categories',
            'all_items'     => 'All Categories',
            'edit_item'     => 'Edit Category',
            'update_item'   => 'Update Category',
            'add_new_item'  => 'Add New Category',
            'new_item_name' => 'New Category Name',
            'menu_name'     => 'Categories',
        ],
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'hair-type' ],
        'show_admin_column' => true,
    ] );

    /* --------------------------------------------------------
       TAXONOMY: hair_texture
       -------------------------------------------------------- */
    register_taxonomy( 'hair_texture', 'hair_product', [
        'labels' => [
            'name'          => 'Textures',
            'singular_name' => 'Texture',
            'search_items'  => 'Search Textures',
            'all_items'     => 'All Textures',
            'edit_item'     => 'Edit Texture',
            'update_item'   => 'Update Texture',
            'add_new_item'  => 'Add New Texture',
            'new_item_name' => 'New Texture Name',
            'menu_name'     => 'Textures',
        ],
        'hierarchical'      => false,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'texture' ],
        'show_admin_column' => true,
    ] );

} );

/* ============================================================
   SEED DEFAULT PRODUCTS ON ACTIVATION
   ============================================================ */
function ah_seed_products() {

    // Only run once
    if ( get_option( 'ah_products_seeded' ) ) return;

    $products = [
        // Raw Hair
        [
            'title'    => 'Cambodian Raw Hair — Body Wave',
            'category' => 'raw-hair',
            'texture'  => 'body-wave',
            'excerpt'  => 'Unprocessed Cambodian raw hair with a natural body wave pattern. Lightweight, bouncy, and full of life. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-body-wave.jpg',
        ],
        [
            'title'    => 'Cambodian Raw Hair — Burmese Curls',
            'category' => 'raw-hair',
            'texture'  => 'burmese-curls',
            'excerpt'  => 'Tight, defined Burmese curl pattern. Single donor, zero chemical treatment. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-burmese-curls.jpg',
        ],
        [
            'title'    => 'Cambodian Raw Hair — Deep Wave',
            'category' => 'raw-hair',
            'texture'  => 'deep-wave',
            'excerpt'  => 'Deep, S-shaped wave pattern that holds curl definition even after washing. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-deep-wave.jpg',
        ],
        [
            'title'    => 'Cambodian Raw Hair — Kinky Straight',
            'category' => 'raw-hair',
            'texture'  => 'kinky-straight',
            'excerpt'  => 'Silky kinky straight texture that blends seamlessly with natural hair. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-kinky-straight.jpg',
        ],
        [
            'title'    => 'Cambodian Raw Hair — Loose Deep',
            'category' => 'raw-hair',
            'texture'  => 'loose-deep',
            'excerpt'  => 'Loose, relaxed deep wave with incredible movement and volume. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-loose-deep.jpg',
        ],
        [
            'title'    => 'Cambodian Raw Hair — Loose Wave',
            'category' => 'raw-hair',
            'texture'  => 'loose-wave',
            'excerpt'  => 'Soft, effortless loose wave — the most versatile texture in our collection. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-loose-wave.jpg',
        ],
        [
            'title'    => 'Cambodian Raw Hair — Straight',
            'category' => 'raw-hair',
            'texture'  => 'straight',
            'excerpt'  => 'Ultra-sleek, naturally straight Cambodian raw hair. Can be curled, coloured, and bleached. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-straight.jpg',
        ],
        [
            'title'    => 'Cambodian Raw Hair — Waver Wave',
            'category' => 'raw-hair',
            'texture'  => 'waver-wave',
            'excerpt'  => 'Gentle waver wave pattern — between a loose wave and a body wave. Lengths 10"–30".',
            'price_from' => '60',
            'image_file' => 'raw-waver-wave.jpg',
        ],
        // Virgin Hair
        [
            'title'    => 'Cambodian Virgin Hair — Body Wave',
            'category' => 'virgin-hair',
            'texture'  => 'body-wave',
            'excerpt'  => 'Premium Cambodian virgin body wave bundles. Minimal shedding, 3-5 year lifespan. Lengths 10"–30".',
            'price_from' => '50',
            'image_file' => 'virgin-body-wave.png',
        ],
        // Closures
        [
            'title'    => 'HD Lace Closure — 4x4',
            'category' => 'closures-frontals',
            'texture'  => 'straight',
            'excerpt'  => 'Invisible HD lace 4x4 closure. Available in all textures, 12"–22". Melts seamlessly into any skin tone.',
            'price_from' => '51',
            'image_file' => 'hd-lace-sizes.png',
        ],
        [
            'title'    => 'HD Lace Frontal — 13x4',
            'category' => 'closures-frontals',
            'texture'  => 'straight',
            'excerpt'  => 'Full 13x4 HD lace frontal — ear to ear coverage for a completely natural hairline. 12"–22".',
            'price_from' => '80',
            'image_file' => 'hd-lace-sizes.png',
        ],
    ];

    foreach ( $products as $product ) {
        $post_id = wp_insert_post( [
            'post_title'   => $product['title'],
            'post_excerpt' => $product['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'hair_product',
        ] );

        if ( is_wp_error( $post_id ) ) continue;

        // Assign taxonomies
        wp_set_object_terms( $post_id, $product['category'], 'hair_category' );
        wp_set_object_terms( $post_id, $product['texture'],  'hair_texture' );

        // Set custom fields
        update_post_meta( $post_id, '_ah_price_from', $product['price_from'] );
        update_post_meta( $post_id, '_ah_image_file', $product['image_file'] );

        // Set featured image from theme assets
        $image_path = AH_DIR . '/assets/images/' . $product['image_file'];
        if ( file_exists( $image_path ) ) {
            ah_set_product_thumbnail( $post_id, $image_path, $product['title'] );
        }
    }

    update_option( 'ah_products_seeded', true );
}
add_action( 'after_switch_theme', 'ah_seed_products' );

/* ============================================================
   HELPER — SET PRODUCT THUMBNAIL FROM FILE
   ============================================================ */
function ah_set_product_thumbnail( int $post_id, string $file_path, string $title ): void {
    $upload_dir = wp_upload_dir();
    $filename   = basename( $file_path );
    $dest       = $upload_dir['path'] . '/' . $filename;

    if ( ! copy( $file_path, $dest ) ) return;

    $filetype   = wp_check_filetype( $filename );
    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $filename,
        'post_mime_type' => $filetype['type'],
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment( $attachment, $dest, $post_id );
    if ( ! is_wp_error( $attach_id ) ) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attach_data = wp_generate_attachment_metadata( $attach_id, $dest );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        set_post_thumbnail( $post_id, $attach_id );
    }
}
