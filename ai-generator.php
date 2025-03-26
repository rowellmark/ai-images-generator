<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register the REST API route
add_action('rest_api_init', function () {
    register_rest_route('ai-alt-caption/v1', '/generate', array(
        'methods' => 'POST',
        'callback' => 'generate_alt_caption_endpoint',
        'permission_callback' => '__return_true',
    ));
});

function generate_alt_caption_endpoint(WP_REST_Request $request) {
    $params = $request->get_json_params();
    
    if (!isset($params['image_url'])) {
        return new WP_Error('missing_image_url', 'The image_url parameter is missing', array('status' => 400));
    }
    
    $imageUrl = $params['image_url'];
    $result = generateAltTextAndCaption($imageUrl);

    return rest_ensure_response(array(
        "alt_text" => $result['alt_text'],
        "caption" => $result['caption']
    ));
}

function generateAltTextAndCaption($imageUrl) {
    // Simulate AI generation (replace with actual AI integration code)
    $altText = "Generated Alt Text for " . basename($imageUrl);
    $caption = "Generated Caption for " . basename($imageUrl);

    return array(
        "alt_text" => $altText,
        "caption" => $caption
    );
}

// Hook into the media upload process to generate Alt text and caption
add_action('add_attachment', 'ai_alt_text_caption_generate_ai_data');
function ai_alt_text_caption_generate_ai_data($post_id) {
    $api_key = get_option('ai_alt_text_caption_api_key');
    if (!$api_key) {
        return;
    }

    $attachment = get_post($post_id);
    $image_url = wp_get_attachment_url($post_id);

    $response = wp_remote_post(rest_url('ai-alt-caption/v1/generate'), array(
        'body' => json_encode(array(
            'image_url' => $image_url
        )),
        'headers' => array(
            'Content-Type' => 'application/json'
        )
    ));

    if (is_wp_error($response)) {
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['alt_text']) && isset($data['caption'])) {
        update_post_meta($post_id, '_ai_alt_text', sanitize_text_field($data['alt_text']));
        update_post_meta($post_id, '_ai_caption', sanitize_text_field($data['caption']));
    }
}
?>