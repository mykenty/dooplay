<?php

add_action('admin_enqueue_scripts', 'dt_framework_scripts');
function dt_framework_scripts( $hook ) {
    if( is_admin() ) { if ( isset($_GET['page']) && $_GET['page'] == DT_THEME_SLUG ) {
       
			wp_enqueue_style('wp-color-picker'); 
			wp_enqueue_style('dt_framework_css', DT_DIR_URI .'/assets/admin/assets/css/acera_css.css' , array(), DT_VERSION, 'all');
			wp_enqueue_script('dt_ajax_upload_js',  DT_DIR_URI .'/assets/admin/assets/js/ajaxupload.js' , array('jquery'), DT_VERSION, false );
			wp_enqueue_script('dt_main_js',  DT_DIR_URI .'/assets/admin/assets/js/mainJs.js' , array('jquery'), DT_VERSION, false );
			wp_enqueue_script('dt_color_picker', DT_DIR_URI. '/assets/admin/assets/js/colorpicker.js', array('wp-color-picker'), false, true ); 

		}
    }
}
if (!function_exists('dt_upload_image_editor')) {
    function dt_upload_image_editor() { ?>
			<script type="text/javascript" src="<?php echo DT_DIR_URI ."/assets/js/upload_images.js"; ?>"></script>
        <?php
    }
}
function myPlugin_admin_scripts() {
   if ( is_admin() ){ 
      if ( isset($_GET['page']) && $_GET['page'] == DT_THEME_SLUG ) {
         wp_enqueue_script('jquery');
         wp_enqueue_script('jquery-form');
      }
   }
}
add_action('admin_init', 'myPlugin_admin_scripts');
