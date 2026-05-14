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
