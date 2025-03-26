<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add settings menu
add_action('admin_menu', 'ai_alt_text_caption_settings_menu');
function ai_alt_text_caption_settings_menu() {
    add_options_page(
        'AI Alt Text and Caption Settings',
        'AI Alt Text and Caption',
        'manage_options',
        'ai-alt-text-caption-settings',
        'ai_alt_text_caption_settings_page'
    );
}

// Settings page content
function ai_alt_text_caption_settings_page() {
    ?>
    <div class="wrap">
        <h1>AI Alt Text and Caption Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ai_alt_text_caption_settings_group');
            do_settings_sections('ai-alt-text-caption-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'ai_alt_text_caption_register_settings');
function ai_alt_text_caption_register_settings() {
    register_setting('ai_alt_text_caption_settings_group', 'ai_alt_text_caption_api_key');

    add_settings_section(
        'ai_alt_text_caption_settings_section',
        'API Settings',
        null,
        'ai-alt-text-caption-settings'
    );

    add_settings_field(
        'ai_alt_text_caption_api_key',
        'API Key',
        'ai_alt_text_caption_api_key_callback',
        'ai-alt-text-caption-settings',
        'ai_alt_text_caption_settings_section'
    );
}

function ai_alt_text_caption_api_key_callback() {
    $api_key = get_option('ai_alt_text_caption_api_key');
    echo '<input type="text" name="ai_alt_text_caption_api_key" value="' . esc_attr($api_key) . '" />';
}
?>