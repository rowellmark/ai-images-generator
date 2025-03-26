<?php
/*
Plugin Name: AI Alt Text and Caption Generator
Description: A plugin that generates Alt text and captions for media using AI.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-fields.php';
require_once plugin_dir_path(__FILE__) . 'includes/ai-generator.php';

// Register activation hook
register_activation_hook(__FILE__, 'ai_alt_text_caption_activate');
function ai_alt_text_caption_activate() {
    // Activation code here
}

// Register deactivation hook
register_deactivation_hook(__FILE__, 'ai_alt_text_caption_deactivate');
function ai_alt_text_caption_deactivate() {
    // Deactivation code here
}
?>