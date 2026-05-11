<?php
/**
 * Asantey Hair & Beauty — Meta Boxes
 * Hair Product CPT: images, pricing, currency, details.
 * Currency symbol stored globally in Options > Asantey Settings.
 */
defined( 'ABSPATH' ) || exit;

/* ============================================================
   GLOBAL: CURRENCY SYMBOL HELPER
   Returns the symbol set in Asantey Settings, defaults to £
   ============================================================ */
function ah_currency_symbol(): string {
    $sym = get_option( 'ah_currency_symbol', '£' );
    return $sym ?: '£';
}

/* ============================================================
   SETTINGS PAGE — Asantey > Settings
   Registers a top-level admin page for global site settings.
   ============================================================ */
add_action( 'admin_menu', function (): void {
    add_menu_page(
        'Asantey Settings',
        'Asantey Settings',
        'manage_options',
        'asantey-settings',
        'ah_settings_page_cb',
        'dashicons-admin-settings',
        59
    );
} );

add_action( 'admin_init', function (): void {
    register_setting( 'ah_settings_group', 'ah_currency_symbol', [
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '£',
    ] );
} );

function ah_settings_page_cb(): void {
    $current = get_option( 'ah_currency_symbol', '£' );
    $presets = [
        '£' => '£  British Pound',
        '$' => '$  US Dollar',
        '€' => '€  Euro',
        '₵' => '₵  Ghanaian Cedi',
        '₦' => '₦  Nigerian Naira',
        '₨' => '₨  Indian Rupee',
        'R' => 'R  South African Rand',
    ];
    ?>
    <div class="wrap">
        <h1>Asantey Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'ah_settings_group' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="ah_currency_symbol">Currency Symbol</label></th>
                    <td>
                        <select name="ah_currency_symbol" id="ah_currency_symbol" style="width:240px;font-size:15px;padding:6px;">
                            <?php foreach ( $presets as $sym => $label ) : ?>
                            <option value="<?php echo esc_attr($sym); ?>"<?php selected($current,$sym); ?>>
                                <?php echo esc_html($label); ?>
                            </option>
                            <?php endforeach; ?>
                            <option value="custom"<?php selected( !array_key_exists($current,$presets) && $current!=='custom', true ); ?>>
                                Custom…
                            </option>
                        </select>
                        <br><br>
                        <label for="ah_currency_custom" style="font-weight:600;font-size:13px;">
                            Custom symbol (leave blank unless you chose Custom above):
                        </label><br>
                        <input type="text"
                               name="ah_currency_symbol"
                               id="ah_currency_custom"
                               value="<?php echo !array_key_exists($current,$presets) ? esc_attr($current) : ''; ?>"
                               placeholder="e.g. kr or ¥"
                               style="width:120px;margin-top:6px;"
                               <?php echo array_key_exists($current,$presets) ? 'disabled' : ''; ?>>
                        <p class="description">
                            This symbol appears next to all prices across the site.<br>
                            Current: <strong style="font-size:18px;"><?php echo esc_html($current); ?></strong>
                        </p>
                        <script>
                        document.getElementById('ah_currency_symbol').addEventListener('change',function(){
                            var custom=document.getElementById('ah_currency_custom');
                            custom.disabled=this.value!=='custom';
                            if(this.value!=='custom'){custom.value='';}
                        });
                        </script>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <?php
}

/* ============================================================
   HAIR PRODUCT — META BOX
   ============================================================ */
add_action( 'add_meta_boxes', function (): void {
    add_meta_box(
        'ah_product_details',
        '💇 Hair Product Details',
        'ah_product_details_callback',
        'hair_product',
        'normal',
        'high'
    );
} );

add_action( 'admin_enqueue_scripts', function ( string $hook ): void {
    if ( ! in_array( $hook, ['post.php','post-new.php'] ) ) return;
    wp_enqueue_media();
    $sym = esc_js( ah_currency_symbol() );
    echo '<style>
    .ahm-wrap{font-family:-apple-system,sans-serif;}
    .ahm-section{background:#f6f7f7;border:1px solid #e2e4e7;border-radius:4px;padding:14px 16px;margin-bottom:14px;}
    .ahm-section-title{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#50575e;margin:0 0 12px;padding-bottom:8px;border-bottom:1px solid #ddd;}
    .ahm-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
    .ahm-grid-3{grid-template-columns:1fr 1fr 1fr;}
    .ahm-full{grid-column:1/-1;}
    .ahm-field{display:flex;flex-direction:column;gap:5px;}
    .ahm-field label{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#1d2327;}
    .ahm-field input[type=text],.ahm-field input[type=number],.ahm-field textarea,.ahm-field select{width:100%;padding:7px 10px;border:1px solid #8c8f94;border-radius:3px;font-size:13px;box-sizing:border-box;}
    .ahm-field textarea{min-height:70px;resize:vertical;}
    .ahm-price-wrap{display:flex;align-items:center;gap:6px;}
    .ahm-price-sym{font-size:18px;font-weight:700;color:#1d2327;flex-shrink:0;min-width:20px;}
    .ahm-price-wrap input[type=number]{width:120px!important;}
    .ahm-hint{font-size:11px;color:#8c8f94;margin-top:2px;}
    .ahm-img-row{display:flex;align-items:flex-start;gap:12px;}
    .ahm-img-preview{width:96px;height:96px;object-fit:cover;border:1px solid #ddd;border-radius:3px;background:#f0f0f1;display:block;}
    .ahm-img-preview.blank{opacity:.25;}
    .ahm-img-btns{display:flex;flex-direction:column;gap:5px;padding-top:2px;}
    .ahm-img-btns .button{font-size:12px;padding:4px 10px;height:auto;line-height:1.5;}
    .ahm-gallery-row{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;}
    .ahm-gal-thumb{position:relative;width:72px;height:72px;}
    .ahm-gal-thumb img{width:72px;height:72px;object-fit:cover;border:1px solid #ddd;display:block;border-radius:3px;}
    .ahm-gal-remove{position:absolute;top:-5px;right:-5px;width:18px;height:18px;background:#cc1818;color:#fff;border:none;border-radius:50%;font-size:11px;cursor:pointer;padding:0;line-height:18px;text-align:center;}
    </style>';
    echo '<script>
    var ahCurrencySymbol = "' . $sym . '";
    function ahmPickFeatured(pId,iId){
        var f=wp.media({title:"Set Product Image",button:{text:"Set image"},multiple:false,library:{type:"image"}});
        f.on("select",function(){
            var a=f.state().get("selection").first().toJSON();
            var s=(a.sizes&&a.sizes.medium)?a.sizes.medium.url:a.url;
            document.getElementById(pId).src=s;document.getElementById(pId).classList.remove("blank");
            document.getElementById(iId).value=a.id;
        });f.open();
    }
    function ahmRemoveFeatured(pId,iId){
        document.getElementById(pId).src="";document.getElementById(pId).classList.add("blank");
        document.getElementById(iId).value="";
    }
    function ahmPickGallery(){
        var f=wp.media({title:"Add Gallery Images",button:{text:"Add to gallery"},multiple:true,library:{type:"image"}});
        f.on("select",function(){
            var atts=f.state().get("selection").toJSON();
            atts.forEach(function(a){
                var s=(a.sizes&&a.sizes.thumbnail)?a.sizes.thumbnail.url:a.url;
                var d=document.createElement("div");d.className="ahm-gal-thumb";d.dataset.id=a.id;
                d.innerHTML="<img src=\'"+s+"\'><button type=\'button\' class=\'ahm-gal-remove\' onclick=\'this.parentNode.remove();ahmSyncGallery()\'>&times;</button>";
                document.getElementById("ahm-gallery-row").appendChild(d);
            });
            ahmSyncGallery();
        });f.open();
    }
    function ahmSyncGallery(){
        var ids=[];
        document.querySelectorAll("#ahm-gallery-row .ahm-gal-thumb").forEach(function(el){ids.push(el.dataset.id);});
        document.getElementById("ahm-gallery-ids").value=ids.join(",");
    }
    </script>';
} );

function ah_product_details_callback( WP_Post $post ): void {
    wp_nonce_field( 'ah_product_meta_v2', 'ah_product_meta_nonce' );

    $price_from  = get_post_meta( $post->ID, '_ah_price_from',      true );
    $price_to    = get_post_meta( $post->ID, '_ah_price_to',        true );
    $lengths     = get_post_meta( $post->ID, '_ah_lengths',         true );
    $badge       = get_post_meta( $post->ID, '_ah_badge',           true );
    $featured    = get_post_meta( $post->ID, '_ah_is_featured',     true );
    $feat_img_id = (int) get_post_meta( $post->ID, '_ah_feat_img_id', true );
    if ( ! $feat_img_id ) $feat_img_id = (int) get_post_thumbnail_id( $post->ID );
    $gallery_ids = get_post_meta( $post->ID, '_ah_gallery_img_ids', true ) ?: '';
    $feat_src    = $feat_img_id ? wp_get_attachment_image_url( $feat_img_id, 'medium' ) : '';

    $gallery_items = [];
    foreach ( array_filter( array_map( 'absint', explode( ',', $gallery_ids ) ) ) as $gid ) {
        $t = wp_get_attachment_image_url( $gid, 'thumbnail' );
        if ( $t ) $gallery_items[] = ['id' => $gid, 'thumb' => $t];
    }

    $sym = esc_html( ah_currency_symbol() );
    ?>
    <div class="ahm-wrap">

        <!-- ── PRICING ── -->
        <div class="ahm-section">
            <p class="ahm-section-title">💷 Pricing</p>
            <div class="ahm-grid ahm-grid-3">
                <div class="ahm-field">
                    <label>Price From</label>
                    <div class="ahm-price-wrap">
                        <span class="ahm-price-sym"><?php echo $sym; ?></span>
                        <input type="number" name="ah_price_from" value="<?php echo esc_attr($price_from); ?>"
                               placeholder="e.g. 60" min="0" step="0.01">
                    </div>
                    <span class="ahm-hint">The lowest / starting price</span>
                </div>
                <div class="ahm-field">
                    <label>Price To <span style="font-weight:400;text-transform:none;">(optional)</span></label>
                    <div class="ahm-price-wrap">
                        <span class="ahm-price-sym"><?php echo $sym; ?></span>
                        <input type="number" name="ah_price_to" value="<?php echo esc_attr($price_to); ?>"
                               placeholder="e.g. 120" min="0" step="0.01">
                    </div>
                    <span class="ahm-hint">Leave blank for a single price</span>
                </div>
                <div class="ahm-field">
                    <label>Currency Symbol</label>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:22px;font-weight:700;color:#1d2327;"><?php echo $sym; ?></span>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=asantey-settings')); ?>"
                           class="button" style="font-size:12px;">
                            Change Symbol
                        </a>
                    </div>
                    <span class="ahm-hint">Set globally in Asantey Settings</span>
                </div>
            </div>
        </div>

        <!-- ── PRODUCT DETAILS ── -->
        <div class="ahm-section">
            <p class="ahm-section-title">📋 Product Details</p>
            <div class="ahm-grid">
                <div class="ahm-field">
                    <label>Available Lengths</label>
                    <input type="text" name="ah_lengths" value="<?php echo esc_attr($lengths); ?>"
                           placeholder='e.g. 10",12",14",16",18",20"'>
                    <span class="ahm-hint">Comma-separated</span>
                </div>
                <div class="ahm-field">
                    <label>Badge <span style="font-weight:400;text-transform:none;">(optional)</span></label>
                    <input type="text" name="ah_badge" value="<?php echo esc_attr($badge); ?>"
                           placeholder="e.g. Best Seller">
                </div>
                <div class="ahm-field">
                    <label>Show on Homepage?</label>
                    <select name="ah_is_featured">
                        <option value=""  <?php selected($featured,'');  ?>>No</option>
                        <option value="1" <?php selected($featured,'1'); ?>>Yes — Featured</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- ── IMAGES ── -->
        <div class="ahm-section">
            <p class="ahm-section-title">🖼 Images</p>
            <div class="ahm-grid">
                <div class="ahm-field">
                    <label>Main Product Image</label>
                    <div class="ahm-img-row">
                        <img id="ahm-feat-prev" src="<?php echo esc_url($feat_src); ?>"
                             class="ahm-img-preview<?php echo $feat_src?'':' blank'; ?>" alt="">
                        <div class="ahm-img-btns">
                            <button type="button" class="button button-primary"
                                    onclick="ahmPickFeatured('ahm-feat-prev','ahm-feat-id')">
                                📁 Choose Image
                            </button>
                            <?php if ($feat_src): ?>
                            <button type="button" class="button"
                                    onclick="ahmRemoveFeatured('ahm-feat-prev','ahm-feat-id')">
                                ✕ Remove
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <input type="hidden" name="ah_feat_img_id" id="ahm-feat-id"
                           value="<?php echo esc_attr($feat_img_id); ?>">
                </div>

                <div class="ahm-field">
                    <label>Additional Gallery Images</label>
                    <div id="ahm-gallery-row" class="ahm-gallery-row">
                        <?php foreach ($gallery_items as $g): ?>
                        <div class="ahm-gal-thumb" data-id="<?php echo $g['id']; ?>">
                            <img src="<?php echo esc_url($g['thumb']); ?>">
                            <button type="button" class="ahm-gal-remove"
                                    onclick="this.parentNode.remove();ahmSyncGallery()">&times;</button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button" onclick="ahmPickGallery()">
                        + Add Gallery Images
                    </button>
                    <input type="hidden" name="ah_gallery_img_ids" id="ahm-gallery-ids"
                           value="<?php echo esc_attr($gallery_ids); ?>">
                    <span class="ahm-hint">Appear as thumbnail strip on product page</span>
                </div>
            </div>
        </div>

        <p class="ahm-hint">
            💡 <strong>Title</strong> and <strong>Description</strong> are in the main editor above.
            <strong>Excerpt</strong> = short description shown on cards.
        </p>
    </div>
    <?php
}

/* ============================================================
   SAVE HAIR PRODUCT META
   ============================================================ */
add_action( 'save_post_hair_product', function ( int $post_id ): void {
    if ( ! isset( $_POST['ah_product_meta_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['ah_product_meta_nonce'], 'ah_product_meta_v2' ) ) return;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    // Featured image
    if ( isset($_POST['ah_feat_img_id']) ) {
        $img_id = absint($_POST['ah_feat_img_id']);
        update_post_meta( $post_id, '_ah_feat_img_id', $img_id );
        if ($img_id) set_post_thumbnail($post_id,$img_id);
        else delete_post_thumbnail($post_id);
    }
    // Gallery
    if ( isset($_POST['ah_gallery_img_ids']) ) {
        $ids = implode(',',array_filter(array_map('absint',explode(',',$_POST['ah_gallery_img_ids']))));
        update_post_meta($post_id,'_ah_gallery_img_ids',$ids);
    }
    // Text + number fields
    $fields = [
        '_ah_price_from'  => 'ah_price_from',
        '_ah_price_to'    => 'ah_price_to',
        '_ah_lengths'     => 'ah_lengths',
        '_ah_badge'       => 'ah_badge',
        '_ah_is_featured' => 'ah_is_featured',
    ];
    foreach ($fields as $meta_key => $post_key) {
        if (isset($_POST[$post_key])) {
            update_post_meta($post_id,$meta_key,sanitize_text_field($_POST[$post_key]));
        }
    }
} );

/* ============================================================
   GALLERY PAGE META BOX
   ============================================================ */
add_action( 'add_meta_boxes', function (): void {
    add_meta_box(
        'ah_gallery_images',
        '📷 Gallery Images — Select from Media Library',
        'ah_gallery_meta_box_cb',
        'page', 'normal', 'high'
    );
} );

function ah_gallery_meta_box_cb( WP_Post $post ): void {
    $template = get_post_meta($post->ID,'_wp_page_template',true);
    if ($template !== 'page-templates/page-gallery.php') {
        echo '<p style="color:#888;font-size:13px;">Only applies to the <strong>Gallery</strong> page template.</p>';
        return;
    }
    wp_nonce_field('ah_gallery_save','ah_gallery_nonce');
    $saved  = get_post_meta($post->ID,'_ah_gallery_ids',true) ?: '';
    $ids    = array_filter(array_map('absint',explode(',',$saved)));
    ?>
    <p style="font-size:13px;margin-bottom:10px;">
        Click <strong>+ Add / Select Images</strong> to choose from your Media Library. Drag to reorder.
    </p>
    <div id="ah-gallery-preview" style="display:flex;flex-wrap:wrap;gap:8px;padding:10px;border:2px dashed #ddd;background:#fafafa;min-height:80px;margin-bottom:12px;">
        <?php foreach ($ids as $id):
            $t=wp_get_attachment_image_url($id,'thumbnail'); if(!$t) continue; ?>
        <div data-id="<?php echo $id; ?>" style="position:relative;width:80px;height:80px;cursor:grab;">
            <img src="<?php echo esc_url($t); ?>" style="width:80px;height:80px;object-fit:cover;display:block;">
            <button type="button" style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#cc1818;color:#fff;border:none;border-radius:50%;font-size:13px;cursor:pointer;padding:0;line-height:20px;text-align:center;" onclick="this.parentNode.remove();ahSyncGal()">&times;</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button button-primary" onclick="ahGalPick()">+ Add / Select Images</button>
    <input type="hidden" name="ah_gallery_ids" id="ah-gallery-ids-input" value="<?php echo esc_attr($saved); ?>">
    <script>
    jQuery(function($){
        if($.fn.sortable){$('#ah-gallery-preview').sortable({items:'[data-id]',update:function(){ahSyncGal();}});}
        window.ahGalPick=function(){
            var f=wp.media({title:'Select Gallery Images',button:{text:'Add to Gallery'},multiple:true,library:{type:'image'}});
            f.on('open',function(){var s=f.state().get('selection');($('#ah-gallery-ids-input').val()||'').split(',').filter(Boolean).forEach(function(id){var a=wp.media.attachment(parseInt(id));a.fetch();s.add(a);});});
            f.on('select',function(){
                var atts=f.state().get('selection').toJSON();
                $('#ah-gallery-preview').empty();
                atts.forEach(function(a){var t=(a.sizes&&a.sizes.thumbnail)?a.sizes.thumbnail.url:a.url;$('#ah-gallery-preview').append('<div data-id="'+a.id+'" style="position:relative;width:80px;height:80px;cursor:grab;"><img src="'+t+'" style="width:80px;height:80px;object-fit:cover;display:block;"><button type="button" style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#cc1818;color:#fff;border:none;border-radius:50%;font-size:13px;cursor:pointer;padding:0;line-height:20px;text-align:center;" onclick="this.parentNode.remove();ahSyncGal()">&times;</button></div>');});
                ahSyncGal();
            });f.open();
        };
        window.ahSyncGal=function(){var ids=[];$('#ah-gallery-preview [data-id]').each(function(){ids.push($(this).data('id'));});$('#ah-gallery-ids-input').val(ids.join(','));};
    });
    </script>
    <?php
}

add_action('save_post_page', function(int $post_id): void {
    if (!isset($_POST['ah_gallery_nonce'])) return;
    if (!wp_verify_nonce($_POST['ah_gallery_nonce'],'ah_gallery_save')) return;
    if (defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post',$post_id)) return;
    if (isset($_POST['ah_gallery_ids'])) {
        $ids=implode(',',array_filter(array_map('absint',explode(',',sanitize_text_field($_POST['ah_gallery_ids'])))));
        update_post_meta($post_id,'_ah_gallery_ids',$ids);
    }
});
