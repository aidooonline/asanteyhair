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
    <div class="meta-box-grid">
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

/* ============================================================
   GALLERY PAGE — IMAGE PICKER META BOX
   Stores a comma-separated list of attachment IDs in
   post meta key: _ah_gallery_ids
   ============================================================ */
add_action( 'add_meta_boxes', function () {
    // Only show on pages that use the Gallery template
    add_meta_box(
        'ah_gallery_images',
        '📷 Gallery Images — Select from Media Library',
        'ah_gallery_meta_box_cb',
        'page',
        'normal',
        'high'
    );
} );

function ah_gallery_meta_box_cb( WP_Post $post ): void {
    // Only render on the Gallery page template
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ( $template !== 'page-templates/page-gallery.php' ) {
        echo '<p style="color:#888;font-size:13px;">This meta box only applies to pages using the <strong>Gallery</strong> template.</p>';
        return;
    }

    wp_nonce_field( 'ah_gallery_save', 'ah_gallery_nonce' );
    $saved_ids = get_post_meta( $post->ID, '_ah_gallery_ids', true );
    $ids_array = $saved_ids ? array_filter( explode( ',', $saved_ids ) ) : [];
    ?>
    <style>
    #ah-gallery-wrap { margin: 8px 0; }
    #ah-gallery-preview { display: flex; flex-wrap: wrap; gap: 8px; min-height: 80px; padding: 10px; border: 2px dashed #ddd; background: #fafafa; margin-bottom: 12px; }
    #ah-gallery-preview .ah-gal-thumb { position: relative; width: 90px; height: 90px; cursor: grab; }
    #ah-gallery-preview .ah-gal-thumb img { width: 90px; height: 90px; object-fit: cover; display: block; border: 2px solid transparent; }
    #ah-gallery-preview .ah-gal-thumb:hover img { border-color: #2271b1; }
    #ah-gallery-preview .ah-gal-remove { position: absolute; top: -6px; right: -6px; width: 20px; height: 20px; background: #cc1818; color: #fff; border: none; border-radius: 50%; font-size: 13px; line-height: 20px; text-align: center; cursor: pointer; padding: 0; }
    #ah-gallery-preview .ah-gal-thumb.sortable-placeholder { background: #e0e0e0; border: 2px dashed #aaa; }
    #ah-add-gallery-imgs { margin-top: 4px; }
    .ah-gal-hint { font-size: 12px; color: #888; margin-top: 6px; }
    </style>

    <div id="ah-gallery-wrap">
        <p style="margin-bottom:8px;font-size:13px;"><strong>Current gallery images:</strong> Drag to reorder. Click &times; to remove.</p>
        <div id="ah-gallery-preview">
            <?php foreach ( $ids_array as $att_id ) :
                $att_id = (int) trim( $att_id );
                if ( ! $att_id ) continue;
                $thumb = wp_get_attachment_image_url( $att_id, 'thumbnail' );
                if ( ! $thumb ) continue;
            ?>
            <div class="ah-gal-thumb" data-id="<?php echo $att_id; ?>">
                <img src="<?php echo esc_url( $thumb ); ?>" alt="">
                <button type="button" class="ah-gal-remove" aria-label="Remove">&times;</button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-primary" id="ah-add-gallery-imgs">
            + Add / Select Images
        </button>
        <p class="ah-gal-hint">Select multiple images at once from the Media Library. Drag thumbnails above to reorder.</p>
        <input type="hidden" name="ah_gallery_ids" id="ah-gallery-ids-input"
               value="<?php echo esc_attr( $saved_ids ); ?>">
    </div>

    <script>
    jQuery(function($){
        // Make thumbs sortable for reordering
        if($.fn.sortable){
            $('#ah-gallery-preview').sortable({
                items: '.ah-gal-thumb',
                placeholder: 'ah-gal-thumb sortable-placeholder',
                tolerance: 'pointer',
                update: function(){ syncIds(); }
            });
        }

        // Remove image
        $('#ah-gallery-preview').on('click', '.ah-gal-remove', function(){
            $(this).closest('.ah-gal-thumb').remove();
            syncIds();
        });

        // Open media library
        $('#ah-add-gallery-imgs').on('click', function(e){
            e.preventDefault();
            var frame = wp.media({
                title: 'Select Gallery Images',
                button: { text: 'Add to Gallery' },
                multiple: true,
                library: { type: 'image' }
            });

            // Pre-select already chosen images
            frame.on('open', function(){
                var selection = frame.state().get('selection');
                var existing = $('#ah-gallery-ids-input').val().split(',').filter(Boolean);
                existing.forEach(function(id){
                    var attachment = wp.media.attachment(parseInt(id));
                    attachment.fetch();
                    selection.add(attachment);
                });
            });

            frame.on('select', function(){
                var attachments = frame.state().get('selection').toJSON();
                // Clear existing and rebuild
                $('#ah-gallery-preview').empty();
                attachments.forEach(function(att){
                    var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                    $('#ah-gallery-preview').append(
                        '<div class="ah-gal-thumb" data-id="'+att.id+'">'
                        + '<img src="'+thumb+'" alt="">'
                        + '<button type="button" class="ah-gal-remove" aria-label="Remove">&times;</button>'
                        + '</div>'
                    );
                });
                syncIds();
            });

            frame.open();
        });

        function syncIds(){
            var ids = [];
            $('#ah-gallery-preview .ah-gal-thumb').each(function(){
                ids.push($(this).data('id'));
            });
            $('#ah-gallery-ids-input').val(ids.join(','));
        }
    });
    </script>
    <?php
}

add_action( 'save_post_page', function ( int $post_id ): void {
    if ( ! isset( $_POST['ah_gallery_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['ah_gallery_nonce'], 'ah_gallery_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['ah_gallery_ids'] ) ) {
        // Sanitize: only allow comma-separated integers
        $raw  = sanitize_text_field( $_POST['ah_gallery_ids'] );
        $ids  = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
        update_post_meta( $post_id, '_ah_gallery_ids', implode( ',', $ids ) );
    }
} );
