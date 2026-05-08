<?php
/**
 * Asantey Hair & Beauty — Meta Boxes
 */
defined( 'ABSPATH' ) || exit;

/* ============================================================
   HAIR PRODUCT — PRODUCT DETAILS META BOX
   ============================================================ */
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'ah_product_details',
        '💇 Hair Product Details',
        'ah_product_details_callback',
        'hair_product',
        'normal',
        'high'
    );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( ! in_array( $hook, ['post.php','post-new.php'] ) ) return;
    wp_enqueue_media();
    echo '<style>
    .ahm-wrap { font-family: -apple-system,sans-serif; }
    .ahm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .ahm-grid-3 { grid-template-columns: 1fr 1fr 1fr; }
    .ahm-full { grid-column: 1 / -1; }
    .ahm-field { display: flex; flex-direction: column; gap: 5px; }
    .ahm-field label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #1d2327; }
    .ahm-field input[type=text], .ahm-field input[type=number], .ahm-field textarea, .ahm-field select { width: 100%; padding: 7px 10px; border: 1px solid #8c8f94; border-radius: 3px; font-size: 13px; box-sizing: border-box; }
    .ahm-field textarea { min-height: 80px; resize: vertical; }
    .ahm-field input[type=number] { width: 130px; }
    .ahm-hint { font-size: 11px; color: #8c8f94; }
    .ahm-section { background: #f6f7f7; border: 1px solid #e2e4e7; border-radius: 4px; padding: 14px 16px; margin-bottom: 14px; }
    .ahm-section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #50575e; margin: 0 0 12px; padding-bottom: 8px; border-bottom: 1px solid #ddd; }
    /* Image picker */
    .ahm-img-row { display: flex; align-items: flex-start; gap: 12px; }
    .ahm-img-preview { width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 3px; background: #f0f0f1; display: block; }
    .ahm-img-preview.blank { opacity: .25; }
    .ahm-img-btns { display: flex; flex-direction: column; gap: 6px; padding-top: 2px; }
    /* Gallery picker */
    .ahm-gallery-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
    .ahm-gal-thumb { position: relative; width: 72px; height: 72px; }
    .ahm-gal-thumb img { width: 72px; height: 72px; object-fit: cover; border: 1px solid #ddd; display: block; }
    .ahm-gal-thumb .ahm-gal-remove { position: absolute; top: -5px; right: -5px; width: 18px; height: 18px; background: #cc1818; color: #fff; border: none; border-radius: 50%; font-size: 11px; cursor: pointer; padding: 0; line-height: 18px; text-align: center; }
    </style>';
    echo '<script>
    function ahmPickFeatured(prevId, inpId) {
        var frame = wp.media({ title: "Set Product Image", button: { text: "Set image" }, multiple: false, library: { type: "image" } });
        frame.on("select", function() {
            var att = frame.state().get("selection").first().toJSON();
            var src = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
            document.getElementById(prevId).src = src;
            document.getElementById(prevId).classList.remove("blank");
            document.getElementById(inpId).value = att.id;
        });
        frame.open();
    }
    function ahmRemoveFeatured(prevId, inpId) {
        document.getElementById(prevId).src = "";
        document.getElementById(prevId).classList.add("blank");
        document.getElementById(inpId).value = "";
    }
    function ahmPickGallery() {
        var frame = wp.media({ title: "Add Gallery Images", button: { text: "Add to gallery" }, multiple: true, library: { type: "image" } });
        frame.on("select", function() {
            var attachments = frame.state().get("selection").toJSON();
            attachments.forEach(function(att) {
                var src = (att.sizes && att.sizes.thumbnail) ? att.sizes.thumbnail.url : att.url;
                var div = document.createElement("div");
                div.className = "ahm-gal-thumb";
                div.dataset.id = att.id;
                div.innerHTML = "<img src=\""+src+"\"><button type=\"button\" class=\"ahm-gal-remove\" onclick=\"this.parentNode.remove(); ahmSyncGallery()\">&times;</button>";
                document.getElementById("ahm-gallery-row").appendChild(div);
            });
            ahmSyncGallery();
        });
        frame.open();
    }
    function ahmSyncGallery() {
        var ids = [];
        document.querySelectorAll("#ahm-gallery-row .ahm-gal-thumb").forEach(function(el) { ids.push(el.dataset.id); });
        document.getElementById("ahm-gallery-ids").value = ids.join(",");
    }
    </script>';
} );

