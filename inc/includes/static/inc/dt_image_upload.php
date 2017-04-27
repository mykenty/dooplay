<?php

if (!function_exists('acera_ajax_image_upload') || !function_exists('acera_ajax_image_remove')) {
    add_action('wp_ajax_acera_ajax_upload', 'acera_ajax_image_upload'); 
    function acera_ajax_image_upload() {
        global $wpdb; 
        $image_id = $_POST['data'];
        $image_filename = $_FILES[$image_id];
        $override['test_form'] = false; 
        $override['action'] = 'wp_handle_upload';

        $uploaded_image = wp_handle_upload($image_filename, $override);

        if (!empty($uploaded_image['error'])) {
            echo 'Error: ' . $uploaded_image['error'];
        } else {
            update_option($image_id, $uploaded_image['url']);
            echo $uploaded_image['url'];
        }

        die();
    }
    add_action('wp_ajax_acera_ajax_remove', 'acera_ajax_image_remove'); 
    function acera_ajax_image_remove() {
        global $wpdb;
        $image_id = $_POST['data'];
        $query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$image_id'";
        $wpdb->query($query);
        die();
    }
}
