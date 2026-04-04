<?php
/**
 * Asantey Hair & Beauty — Meta Boxes (Product custom fields)
 */

defined( 'ABSPATH' ) || exit;

add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'ah_product_details',
        'Product Details',
        'ah_product_details_callback',
        'hair_product',
        'normal',
        'high'
    );
} );

function ah_product_details_callback( WP_Post $post ): void {
    wp_nonce_field( 'ah_product_meta', 'ah_product_meta_nonce' );

    $price_from  = get_post_meta( $post->ID, '_ah_price_from',  true );
    $price_to    = get_post_meta( $post->ID, '_ah_price_to',    true );
    $lengths     = get_post_meta( $post->ID, '_ah_lengths',     true );
    $image_file  = get_post_meta( $post->ID, '_ah_image_file',  true );
    $featured    = get_post_meta( $post->ID, '_ah_is_featured', true );
    $badge       = get_post_meta( $post->ID, '_ah_badge',       true );
    ?>
    <style>
    .ah-mb { display:grid; grid-template-columns:1fr 1fr; gap:16px; padding:12px 0; }
    .ah-mb label { display:block; font-weight:600; margin-bottom:4px; font-size:12px; text-transform:uppercase; letter-spacing:.05em; }
    .ah-mb input, .ah-mb select { width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:3px; }
    .ah-mb .full { grid-column: 1/-1; }
    </style>
    <div class="ah-mb">
        <div>
            <label>Price From (£)</label>
            <input type="number" name="ah_price_from" value="<?php echo esc_attr( $price_from ); ?>" placeholder="e.g. 60" min="0" step="0.01">
        </div>
        <div>
            <label>Price To (£) — optional</label>
            <input type="number" name="ah_price_to" value="<?php echo esc_attr( $price_to ); ?>" placeholder="e.g. 120" min="0" step="0.01">
        </div>
        <div>
            <label>Available Lengths</label>
            <input type="text" name="ah_lengths" value="<?php echo esc_attr( $lengths ); ?>" placeholder='e.g. 10",12",14",16"'>
        </div>
        <div>
            <label>Image File (from assets/images/)</label>
            <input type="text" name="ah_image_file" value="<?php echo esc_attr( $image_file ); ?>" placeholder="raw-body-wave.jpg">
        </div>
        <div>
            <label>Badge Label (optional)</label>
            <input type="text" name="ah_badge" value="<?php echo esc_attr( $badge ); ?>" placeholder="e.g. Best Seller">
        </div>
        <div>
            <label>Featured Product?</label>
            <select name="ah_is_featured">
                <option value="" <?php selected( $featured, '' ); ?>>No</option>
                <option value="1" <?php selected( $featured, '1' ); ?>>Yes — show on homepage</option>
            </select>
        </div>
    </div>
    <?php
}

add_action( 'save_post_hair_product', function ( int $post_id ): void {
    if ( ! isset( $_POST['ah_product_meta_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['ah_product_meta_nonce'], 'ah_product_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [
        '_ah_price_from'  => 'sanitize_text_field',
        '_ah_price_to'    => 'sanitize_text_field',
        '_ah_lengths'     => 'sanitize_text_field',
        '_ah_image_file'  => 'sanitize_text_field',
        '_ah_badge'       => 'sanitize_text_field',
        '_ah_is_featured' => 'sanitize_text_field',
    ];

    $post_keys = [
        '_ah_price_from'  => 'ah_price_from',
        '_ah_price_to'    => 'ah_price_to',
        '_ah_lengths'     => 'ah_lengths',
        '_ah_image_file'  => 'ah_image_file',
        '_ah_badge'       => 'ah_badge',
        '_ah_is_featured' => 'ah_is_featured',
    ];

    foreach ( $fields as $meta_key => $sanitizer ) {
        $post_key = $post_keys[ $meta_key ];
        if ( isset( $_POST[ $post_key ] ) ) {
            update_post_meta( $post_id, $meta_key, $sanitizer( $_POST[ $post_key ] ) );
        }
    }
} );
