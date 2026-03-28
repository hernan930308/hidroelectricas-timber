<?php

/**
 * Render callback to prepare and display a registered block using Timber.
 *
 * @param    array    $attributes The block attributes.
 * @param    string   $content The block content.
 * @param    bool     $is_preview Whether or not the block is being rendered for editing preview.
 * @param    int      $post_id The current post being edited or viewed.
 * @param    WP_Block $wp_block The block instance (since WP 5.5).
 * @return   void
 */
function my_acf_block_render_callback($attributes, $content = '', $is_preview = false, $post_id = 0, $wp_block = null) {
    // Create the slug of the block using the name property in the block.json.
    $slug = str_replace( 'acf/', '', $attributes['name'] );

    $context = Timber::context();

    // Store block attributes.
    $context['attributes'] = $attributes;

    // Store field values. These are the fields from your ACF field group for the block.
    $context['fields'] = get_fields();

    // Store whether the block is being rendered in the editor or on the frontend.
    $context['is_preview'] = $is_preview;

    // Render the block.
    Timber::render(
        'blocks/' . $slug . '/' . $slug . '.twig',
        $context
    );
}