<?php
/**
 * Asantey Hair & Beauty — ACF Flexible Content Field Groups
 * Registers all ACF field groups used across every page template.
 * Only loaded when ACF Pro is active.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', function () {

    /* ========================================================
       FLEXIBLE CONTENT — PAGE BUILDER
       Used on: all page templates (except legal pages)
       ======================================================== */
    acf_add_local_field_group( [
        'key'      => 'group_ah_page_builder',
        'title'    => 'Page Content Builder',
        'fields'   => [
            [
                'key'          => 'field_ah_flexible_content',
                'label'        => 'Page Sections',
                'name'         => 'ah_sections',
                'type'         => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts'      => [

                    /* ---- HERO ---- */
                    'hero' => [
                        'key'        => 'layout_ah_hero',
                        'name'       => 'hero',
                        'label'      => 'Hero Section',
                        'sub_fields' => [
                            [ 'key' => 'field_hero_label',    'label' => 'Label (above title)',  'name' => 'label',    'type' => 'text'  ],
                            [ 'key' => 'field_hero_title',    'label' => 'Title',                'name' => 'title',    'type' => 'text'  ],
                            [ 'key' => 'field_hero_subtitle', 'label' => 'Subtitle',             'name' => 'subtitle', 'type' => 'textarea' ],
                            [ 'key' => 'field_hero_image',    'label' => 'Background Image',     'name' => 'image',    'type' => 'image', 'return_format' => 'url' ],
                            [ 'key' => 'field_hero_cta1',     'label' => 'CTA Button 1',         'name' => 'cta1',     'type' => 'link'  ],
                            [ 'key' => 'field_hero_cta2',     'label' => 'CTA Button 2',         'name' => 'cta2',     'type' => 'link'  ],
                        ],
                    ],

                    /* ---- TEXT + IMAGE SPLIT ---- */
                    'split' => [
                        'key'        => 'layout_ah_split',
                        'name'       => 'split',
                        'label'      => 'Text + Image Split',
                        'sub_fields' => [
                            [ 'key' => 'field_split_label',   'label' => 'Label',               'name' => 'label',   'type' => 'text' ],
                            [ 'key' => 'field_split_title',   'label' => 'Heading',             'name' => 'title',   'type' => 'text' ],
                            [ 'key' => 'field_split_body',    'label' => 'Body Text',           'name' => 'body',    'type' => 'wysiwyg', 'toolbar' => 'basic' ],
                            [ 'key' => 'field_split_image',   'label' => 'Image',               'name' => 'image',   'type' => 'image', 'return_format' => 'url' ],
                            [ 'key' => 'field_split_cta',     'label' => 'CTA Button',          'name' => 'cta',     'type' => 'link' ],
                            [ 'key' => 'field_split_reverse', 'label' => 'Reverse (image left)', 'name' => 'reverse', 'type' => 'true_false', 'ui' => 1 ],
                            [ 'key' => 'field_split_bg',      'label' => 'Background',          'name' => 'bg',
                              'type' => 'select', 'choices' => [ 'white' => 'White', 'cream' => 'Cream', 'dark' => 'Dark' ] ],
                        ],
                    ],

                    /* ---- FEATURE GRID ---- */
                    'features' => [
                        'key'        => 'layout_ah_features',
                        'name'       => 'features',
                        'label'      => 'Feature Grid',
                        'sub_fields' => [
                            [ 'key' => 'field_feat_label',   'label' => 'Section Label',  'name' => 'label',   'type' => 'text' ],
                            [ 'key' => 'field_feat_title',   'label' => 'Section Title',  'name' => 'title',   'type' => 'text' ],
                            [ 'key' => 'field_feat_columns', 'label' => 'Columns',        'name' => 'columns',
                              'type' => 'select', 'choices' => [ '2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns' ], 'default_value' => '3' ],
                            [ 'key' => 'field_feat_items',   'label' => 'Features',       'name' => 'items',   'type' => 'repeater',
                              'button_label' => 'Add Feature',
                              'sub_fields' => [
                                  [ 'key' => 'field_feat_icon',  'label' => 'Icon Name',   'name' => 'icon',  'type' => 'text', 'placeholder' => 'gem, shield, heart, sparkle, check' ],
                                  [ 'key' => 'field_feat_ftitle','label' => 'Title',       'name' => 'title', 'type' => 'text' ],
                                  [ 'key' => 'field_feat_fbody', 'label' => 'Description', 'name' => 'body',  'type' => 'textarea' ],
                              ],
                            ],
                        ],
                    ],

                    /* ---- PRICING TABLE ---- */
                    'pricing' => [
                        'key'        => 'layout_ah_pricing',
                        'name'       => 'pricing',
                        'label'      => 'Pricing Table',
                        'sub_fields' => [
                            [ 'key' => 'field_price_label',   'label' => 'Section Label',    'name' => 'label',   'type' => 'text' ],
                            [ 'key' => 'field_price_title',   'label' => 'Section Title',    'name' => 'title',   'type' => 'text' ],
                            [ 'key' => 'field_price_type',    'label' => 'Pricing Type',     'name' => 'type',
                              'type' => 'select', 'choices' => [
                                  'raw'    => 'Raw Hair',
                                  'virgin' => 'Virgin Hair',
                                  '2x6'   => '2x6 Closure',
                                  '4x4'   => '4x4 Closure',
                                  '5x5'   => '5x5 Closure',
                                  '6x6'   => '6x6 Closure',
                                  '13x4'  => '13x4 Frontal',
                                  '13x6'  => '13x6 Frontal',
                              ],
                            ],
                            [ 'key' => 'field_price_note', 'label' => 'Footer Note', 'name' => 'note', 'type' => 'text' ],
                        ],
                    ],

                    /* ---- GALLERY BLOCK ---- */
                    'gallery' => [
                        'key'        => 'layout_ah_gallery',
                        'name'       => 'gallery',
                        'label'      => 'Gallery',
                        'sub_fields' => [
                            [ 'key' => 'field_gal_label',  'label' => 'Label',    'name' => 'label',  'type' => 'text' ],
                            [ 'key' => 'field_gal_title',  'label' => 'Title',    'name' => 'title',  'type' => 'text' ],
                            [ 'key' => 'field_gal_images', 'label' => 'Images',   'name' => 'images', 'type' => 'repeater',
                              'button_label' => 'Add Image',
                              'sub_fields' => [
                                  [ 'key' => 'field_gal_img',     'label' => 'Image',   'name' => 'image',   'type' => 'image', 'return_format' => 'array' ],
                                  [ 'key' => 'field_gal_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text' ],
                              ],
                            ],
                        ],
                    ],

                    /* ---- CTA BAND ---- */
                    'cta_band' => [
                        'key'        => 'layout_ah_cta',
                        'name'       => 'cta_band',
                        'label'      => 'CTA Band',
                        'sub_fields' => [
                            [ 'key' => 'field_cta_label', 'label' => 'Label',      'name' => 'label', 'type' => 'text' ],
                            [ 'key' => 'field_cta_title', 'label' => 'Heading',    'name' => 'title', 'type' => 'text' ],
                            [ 'key' => 'field_cta_body',  'label' => 'Body',       'name' => 'body',  'type' => 'textarea' ],
                            [ 'key' => 'field_cta_btn1',  'label' => 'Button 1',   'name' => 'btn1',  'type' => 'link' ],
                            [ 'key' => 'field_cta_btn2',  'label' => 'Button 2',   'name' => 'btn2',  'type' => 'link' ],
                            [ 'key' => 'field_cta_style', 'label' => 'Background', 'name' => 'style',
                              'type' => 'select', 'choices' => [ 'dark' => 'Dark (Black)', 'gold' => 'Gold' ], 'default_value' => 'dark' ],
                        ],
                    ],

                    /* ---- TESTIMONIALS ---- */
                    'testimonials' => [
                        'key'        => 'layout_ah_testimonials',
                        'name'       => 'testimonials',
                        'label'      => 'Testimonials',
                        'sub_fields' => [
                            [ 'key' => 'field_test_label', 'label' => 'Section Label', 'name' => 'label', 'type' => 'text' ],
                            [ 'key' => 'field_test_title', 'label' => 'Section Title', 'name' => 'title', 'type' => 'text' ],
                            [ 'key' => 'field_test_items', 'label' => 'Testimonials',  'name' => 'items', 'type' => 'repeater',
                              'button_label' => 'Add Testimonial',
                              'sub_fields' => [
                                  [ 'key' => 'field_test_quote',  'label' => 'Quote',       'name' => 'quote',  'type' => 'textarea' ],
                                  [ 'key' => 'field_test_author', 'label' => 'Author Name', 'name' => 'author', 'type' => 'text' ],
                                  [ 'key' => 'field_test_rating', 'label' => 'Stars (1-5)', 'name' => 'rating', 'type' => 'number', 'default_value' => 5, 'min' => 1, 'max' => 5 ],
                              ],
                            ],
                        ],
                    ],

                    /* ---- FAQ ACCORDION ---- */
                    'faqs' => [
                        'key'        => 'layout_ah_faqs',
                        'name'       => 'faqs',
                        'label'      => 'FAQ Accordion',
                        'sub_fields' => [
                            [ 'key' => 'field_faq_label', 'label' => 'Section Label', 'name' => 'label', 'type' => 'text' ],
                            [ 'key' => 'field_faq_title', 'label' => 'Section Title', 'name' => 'title', 'type' => 'text' ],
                            [ 'key' => 'field_faq_items', 'label' => 'FAQs',          'name' => 'items', 'type' => 'repeater',
                              'button_label' => 'Add FAQ',
                              'sub_fields' => [
                                  [ 'key' => 'field_faq_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text' ],
                                  [ 'key' => 'field_faq_a', 'label' => 'Answer',   'name' => 'answer',   'type' => 'wysiwyg', 'toolbar' => 'basic' ],
                              ],
                            ],
                        ],
                    ],

                    /* ---- TEXT BLOCK ---- */
                    'text' => [
                        'key'        => 'layout_ah_text',
                        'name'       => 'text',
                        'label'      => 'Text Block (WYSIWYG)',
                        'sub_fields' => [
                            [ 'key' => 'field_txt_content', 'label' => 'Content', 'name' => 'content', 'type' => 'wysiwyg' ],
                            [ 'key' => 'field_txt_bg',      'label' => 'Background', 'name' => 'bg',
                              'type' => 'select', 'choices' => [ 'white' => 'White', 'cream' => 'Cream', 'dark' => 'Dark' ], 'default_value' => 'white' ],
                        ],
                    ],

                    /* ---- CONTACT INFO ---- */
                    'contact_info' => [
                        'key'        => 'layout_ah_contact_info',
                        'name'       => 'contact_info',
                        'label'      => 'Contact Info + Map',
                        'sub_fields' => [
                            [ 'key' => 'field_ci_label',   'label' => 'Label',          'name' => 'label',   'type' => 'text' ],
                            [ 'key' => 'field_ci_title',   'label' => 'Title',          'name' => 'title',   'type' => 'text' ],
                            [ 'key' => 'field_ci_showmap', 'label' => 'Show Map',       'name' => 'showmap', 'type' => 'true_false', 'ui' => 1 ],
                            [ 'key' => 'field_ci_showform','label' => 'Show Form',      'name' => 'showform','type' => 'true_false', 'ui' => 1, 'default_value' => 1 ],
                        ],
                    ],

                ],
            ],
        ],
        'location' => [
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ] ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => [ 'the_content' ],
    ] );

    /* ========================================================
       PRODUCT EXTRA FIELDS (supplement meta boxes)
       ======================================================== */
    acf_add_local_field_group( [
        'key'    => 'group_ah_product',
        'title'  => 'Product Extra Info',
        'fields' => [
            [ 'key' => 'field_prod_full_desc', 'label' => 'Full Description (frontend)', 'name' => 'ah_full_desc', 'type' => 'wysiwyg' ],
            [ 'key' => 'field_prod_quality',   'label' => 'Quality Note',                'name' => 'ah_quality',   'type' => 'text', 'placeholder' => 'e.g. 3-5 year lifespan, minimal shedding' ],
            [ 'key' => 'field_prod_gallery',   'label' => 'Product Gallery',             'name' => 'ah_gallery',   'type' => 'gallery', 'return_format' => 'array' ],
        ],
        'location' => [
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'hair_product' ] ],
        ],
    ] );

} );
