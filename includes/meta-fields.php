<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add meta fields to media post type
add_action('add_meta_boxes', 'ai_alt_text_caption_add_meta_boxes');
function ai_alt_text_caption_add_meta_boxes() {
    add_meta_box(
        'ai-alt-text-caption-meta-box',
        'AI Alt Text and Caption',
        'ai_alt_text_caption_meta_box_callback',
        'attachment',
        'side',
        'default'
    );
}

function ai_alt_text_caption_meta_box_callback($post) {
    wp_nonce_field('ai_alt_text_caption_save_meta_box_data', 'ai_alt_text_caption_meta_box_nonce');

    $alt_text = get_post_meta($post->ID, '_ai_alt_text', true);
    $caption = get_post_meta($post->ID, '_ai_caption', true);

    echo '<p><label for="ai_alt_text">Alt Text:</label>';
    echo '<textarea id="ai_alt_text" name="ai_alt_text" rows="2" cols="25">' . esc_textarea($alt_text) . '</textarea></p>';

    echo '<p><label for="ai_caption">Caption:</label>';
    echo '<textarea id="ai_caption" name="ai_caption" rows="2" cols="25">' . esc_textarea($caption) . '</textarea></p>';
}

// Save meta fields data
add_action('save_post', 'ai_alt_text_caption_save_meta_box_data');
function ai_alt_text_caption_save_meta_box_data($post_id) {
    if (!isset($_POST['ai_alt_text_caption_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['ai_alt_text_caption_meta_box_nonce'], 'ai_alt_text_caption_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'attachment' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (!isset($_POST['ai_alt_text']) || !isset($_POST['ai_caption'])) {
        return;
    }

    $alt_text = sanitize_text_field($_POST['ai_alt_text']);
    $caption = sanitize_text_field($_POST['ai_caption']);

    update_post_meta($post_id, '_ai_alt_text', $alt_text);
    update_post_meta($post_id, '_ai_caption', $caption);
}
?>