<?php


add_action('after_setup_theme', 'woz0ha');

$dtstyle = get_option('dt_color_style');
if($dtstyle == 'default'){
	$color1 = "#408BEA";
	$color2 = "#F5F7FA";
} elseif($dtstyle == 'dark') {
	$color1 = "#408BEA";
	$color2 = "#32353a";
} elseif($dtstyle == 'fusion'){
	$color1 = "#408BEA";
	$color2 = "#9facc1";
}

$options = array(
// Sections
array("type" => "section","icon" => "dashicons-admin-settings","title" => __d("Configuration"),"id" => "general","expanded" => "true"),
array("type" => "section","icon" => "dashicons-welcome-widgets-menus","title" => __d("Home page"),"id" => "home","expanded" => "false"),
array("type" => "section","icon" => "dashicons-chart-bar","title" => __d("SEO"),"id" => "seo","expanded" => "false"),
array("type" => "section","icon" => "dashicons-admin-tools","title" => __d("Tools"),"id" => "tools","expanded" => "false"),
array("type" => "section","icon" => "dashicons-analytics","title" => __d("Advertising"),"id" => "ads","expanded" => "false"),
// sub sections
array("section" => "general", "type" => "heading","title" => __d("General Settings"),"id" => "general"),
array("section" => "general", "type" => "heading","title" => __d("Customize"),"id" => "custom"),
array("section" => "general", "type" => "heading","title" => __d("Main Slider"),"id" => "dtslider"),
array("section" => "general", "type" => "heading","title" => __d("TMDb API"),"id" => "api-config"),
array("section" => "general", "type" => "heading","title" => __d("Video Player"),"id" => "player"),
array("section" => "general", "type" => "heading","title" => __d("Comments"),"id" => "comments"),
array("section" => "custom", "type" => "heading","title" => __d("Default style"),"id" => "default-style"),
array("section" => "custom", "type" => "heading","title" => __d("Dark Style"),"id" => "dark-style"),
array("section" => "home", "type" => "heading","title" => __d("Home modules"),"id" => "h-config"),
array("section" => "home", "type" => "heading","title" => __d("Module blog"),"id" => "m-blog"),
array("section" => "home", "type" => "heading","title" => __d("Module slider"),"id" => "m-slider"),
array("section" => "home", "type" => "heading","title" => __d("Module movies"),"id" => "m-movies"),
array("section" => "home", "type" => "heading","title" => __d("Module tvshows"),"id" => "m-tvshows"),
array("section" => "home", "type" => "heading","title" => __d("Module seasons"),"id" => "m-seasons"),
array("section" => "home", "type" => "heading","title" => __d("Module episodes"),"id" => "m-episodes"),
array("section" => "home", "type" => "heading","title" => __d("Module TOP IMDb"),"id" => "m-imdb-top"),
array("section" => "tools", "type" => "heading","title" => __d("Post links"),"id" => "post-links"),
array("section" => "tools", "type" => "heading","title" => __d("Minify HTML"),"id" => "minifyhtml"),
array("section" => "tools", "type" => "heading","title" => __d("User register"),"id" => "dt_register_user_ptr"),
array("section" => "seo", "type" => "heading","title" => __d("Basic info"),"id" => "seo-general"),
array("section" => "seo", "type" => "heading","title" => __d("Site verification"),"id" => "site-veri"),
array("section" => "ads", "type" => "heading","title" => __d("Ad spot / home module"),"id" => "ads-1"),
array("section" => "ads", "type" => "heading","title" => __d("Ad spot / redirecting links"),"id" => "ads-2"),
array("section" => "ads", "type" => "heading","title" => __d("Ad spot / single"),"id" => "ads-3"),


##################  Main Slider #######################
array(
	// Field multi chekbox
    "under_section" => "dtslider",
    "type" => "checkbox",
    "name" => __d('Slider controls'),
    "id" => array("dt_main_slider","dt_main_slider_radom","dt_main_slider_autoplay"), 
    "options" => array( __d('Enable Slider'), __d('Enable random content'), __d('Autoplay Slider')), 
    "desc" => __d('Check to enable ads'),
    "display_checkbox_id" => "toggle_checkbox_id",
),

array(
	// minify_html_active
    "under_section" => "dtslider",
    "type" => "radio",
    "name" => __d("Order"),
    "id" => "dt_main_slider_order",
    "display_checkbox_id" => "toggle_checkbox_id",
    "options" => array(
		"desc" => __d('Descending'),
		"asc" => __d('Ascending'),
	),
    "desc" => __d('Enable or disable Minify HTML'),
    "default" => "desc"
),

array(
	// dt_main_slider_speed
	"under_section" => "dtslider", 
    "type" => "select", 
    "name" => __d('Speed Slider'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_main_slider_speed", 
    "options" => array(
			"500" => __d('0.5 seconds'),
			"1000" => __d('1 second'),
			"1500" => __d('1.5 seconds'),
			"2000" => __d('2 seconds'),
			"2500" => __d('2.5 seconds'),
			"3000" => __d('3 seconds'),
			"3500" => __d('3.5 seconds'),
			"4000" => __d('4 seconds')
		), 
    "desc" => __d('Select speed slider in secons'),
    "default" => "2000"
),

array(
	// posts_per_page
    "under_section" => "dtslider", 
    "type" => "number",
    "name" => __d('Items numbers'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_main_slider_items", 
	"min" => "3",
	"step" => "3",
    "desc" => __d('Number items shown'),
    "default" => "12"
),




##################  Customize #######################
array(
	// dt_color_style
	"under_section" => "custom", 
    "type" => "select", 
    "name" => __d('Font family'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_font_style", 
    "options" => array(
			"Roboto" => "Roboto",
			"Open Sans" => "Open Sans",
			"Raleway" => "Raleway",
			"Source Sans Pro" => "Source Sans Pro",
			"Noto Sans" => "Noto Sans",
			"Quicksand" => "Quicksand",
			"Questrial" => "Questrial",
			"Rubik" => "Rubik",
			"Archivo Narrow" => "Archivo Narrow",
			"Work Sans" => "Work Sans",
			"Signika" => "Signika",
			"Nunito Sans" => "Nunito Sans",
			"Alegreya Sans" => "Alegreya Sans",
			"BenchNine" => "BenchNine",
			"Yantramanav" => "Yantramanav",
			"Pontano Sans" => "Pontano Sans",
			"Gudea" => "Gudea",
			"Cabin Condensed" => "Cabin Condensed",
			"Khand" => "Khand",
			"Ruda" => "Ruda"
		), 
    "desc" => __d('Select font-family by Google Fonts'),
    "default" => "Roboto"
),

array(
	// dt_color_style
	"under_section" => "custom", 
    "type" => "select", 
    "name" => __d('Color Scheme'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_color_style", 
    "options" => array(
			"default" => __d('Default style'),
			#"dark" => __d('Dark stye'),
			"fusion" => __d('Fusion stye')
		), 
    "desc" => __d('Select the default color scheme'),
    "default" => "default"
),


array(
	"under_section" => "custom", //Required
	"type" => "color", //Required
	"name" => __d("Primary color"), //Required
	"id" => "color1", //Required
	"desc" => __d("Choose a color"),
	"default" => $color1
),


array(
	"under_section" => "custom", //Required
	"type" => "color", //Required
	"name" => __d("Background container"), //Required
	"id" => "color2", //Required
	"desc" => __d("Choose a color"),
	"default" => $color2
),

array(
	// Small heading
    "under_section" => "custom", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Custom CSS'),
),

array(
	// dt_header_code
    "under_section" => "custom",
    "type" => "textarea", 
    "name" => __d('CSS code'),  
    "id" => "dt_custom_css", 
    "display_checkbox_id" => "toggle_checkbox_id",
	"rows" => "10",
	"placeholder" => ".YourClass { }",
    "desc" => __d('Add only CSS code')
),


array(
	// Small heading
    "under_section" => "custom", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Customize logos'),
),


array(
	// dt_logo
    "under_section" => "custom", 
    "type" => "image", 
	"display_checkbox_id" => "toggle_checkbox_id",
    "name" => __d('Logo Image'),
    "id" => "dt_logo", 
    "desc" => __d('Upload your logo using the Upload Button or insert image URL')
),
array(
	// dt_favicon
    "under_section" => "custom", 
    "type" => "image", 
	"display_checkbox_id" => "toggle_checkbox_id",
    "name" => __d('Favicon'),
    "id" => "dt_favicon", 
    "desc" => __d('Upload a 16 x 16 px image that will represent your website\'s favicon')
), 
array(
	// dt_touch_icon
    "under_section" => "custom", 
    "type" => "image", 
	"display_checkbox_id" => "toggle_checkbox_id",
    "name" => __d('Touch icon APP'),
    "id" => "dt_touch_icon", 
    "desc" => __d('Upload a 152 x 152 px image that will represent your Web APP')
), 
array(
	// dt_logo_admin
    "under_section" => "custom", 
    "type" => "image", 
	"display_checkbox_id" => "toggle_checkbox_id",
    "name" => __d('Admin logo'),
    "id" => "dt_logo_admin", 
    "desc" => __d('Upload your logo for wp-admin login, using the Upload Button or insert image URL')
), 


##################  Minify HTML #######################


array(
	// minify_html_active
    "under_section" => "minifyhtml",
    "type" => "radio",
    "name" => __d("Minify HTML"),
    "id" => "minify_html_active",
    "display_checkbox_id" => "toggle_checkbox_id",
    "options" => array(
		"yes" => __d('Enable'),
		"no" => __d('Disable'),
	),
    "desc" => __d('Enable or disable Minify HTML'),
    "default" => "no"
),

array(
	// minify_html_comments
    "under_section" => "minifyhtml",
    "type" => "radio",
    "name" => __d("Code comments"),
    "id" => "minify_html_comments",
    "display_checkbox_id" => "toggle_checkbox_id",
    "options" => array(
		"yes" => __d('Yes'),
		"no" => __d('No'),
	),
    "desc" => __d('Remove HTML, JavaScript and CSS comments, this option is typically safe to set to (Yes)'),
    "default" => "yes"
),


#========================================================================

####################  Video Player  #####################
#########################################################

array(
	// dt_layout_player
    "under_section" => "player",
    "type" => "radio",
    "name" => __d("Movie layout player"),
    "id" => "dt_layout_player",
    "display_checkbox_id" => "toggle_checkbox_id",
    "options" => array(
		"big" => __d('Big player'),
		"small" => __d('Small Player'),
	),
    "desc" => __d('Select layout player movie'),
    "default" => "big"
),
array(
	// Field multi chekbox
    "under_section" => "player",
    "type" => "checkbox",
    "name" => __d('Player control'),
    "id" => array(
		"dt_player_luces", 
		"dt_player_report", 
		"dt_player_quality", 
		"dt_player_views",
	), 
    "options" => array(
		__d('Turn off the lights'),
		__d('Report error'),
		__d('Show quality'),
		__d('Show views')
	), 
    "desc" => __d('Check options you want to display.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("checked", "checked", "checked", "checked")
),

array(
	// Small heading
    "under_section" => "player", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Block Ad in player'),
), 

array(
	// Field multi chekbox
    "under_section" => "player",
    "type" => "checkbox",
    "name" => __d('Ad control'),
    "id" => array(
		"dt_player_ads",
		"dt_player_ads_hide_clic"
	), 
    "options" => array(
		__d('Ad in player'),
		__d('Hide ad after clicking')
	), 
    "desc" => __d('Check options you want to display.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("not", "checked")
),
array(
	// dt_player_ads_time
    "under_section" => "player", 
    "type" => "number",
    "name" => __d('Hide ad'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_player_ads_time", 
	"min" => "0",
	"max" => "1000",
	"step" => "1",
    "desc" => __d(' Time in seconds for show ad '),
    "default" => "20"
),
array(
	// dt_player_ads_300
    "under_section" => "player",
    "type" => "textarea", 
    "name" => __d('Ad of 300*250 px'),  
    "id" => "dt_player_ads_300", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "desc" => __d('Use HTML code'),
	"rows" => '5',
    "default" => ""
),

####################  ADS - Spots  ######################
#########################################################

array(
	// dt_topimdb_layout
    "under_section" => "m-imdb-top",
    "type" => "radio",
    "name" => __d("Select Layout"),
    "id" => "dt_topimdb_layout",
    "display_checkbox_id" => "toggle_checkbox_id",
    "options" => array(
		"top_movies_tv" => __d('Movies and TV Shows'),
		"top_movies" => __d('Only Movies'),
		"top_tv" => __d('Only TV Shows')
	),
    "desc" => __d('Select the type of module to display'),
    "default" => "top_movies_tv"
),
array(
	// dt_topimdb_title
    "under_section" => "m-imdb-top", 
    "type" => "text",
    "name" => __d('Module Title'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_topimdb_title", 
    "placeholder" => __d('TOP IMDb'),
    "desc" => __d('Add title to show'),
    "default" => __d('TOP IMDb')
),
array(
	// dt_topimdb_number_items
    "under_section" => "m-imdb-top", 
    "type" => "number",
    "name" => __d('Items number'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_topimdb_number_items", 
	"min" => "5",
	"max" => "50",
	"step" => "1",
    "placeholder" => __d('5'),
    "desc" => __d('Number of items to show'),
    "default" => "5"
),
array(
	// Tip [module-movies]
    "under_section" => "m-imdb-top",
    "type" => "tips",
	"text" => __d('<code>[module-top-imdb]</code> Usage shortcode.')
),
array(
	// dt_blo_title
    "under_section" => "m-blog", 
    "type" => "text",
    "name" => __d('Module Title'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_blo_title", 
    "placeholder" => __d('Last entries'),
    "desc" => __d('Add title to show'),
    "default" => __d('Last entries')
),
array(
	// dt_blog_number_items
    "under_section" => "m-blog", 
    "type" => "number",
    "name" => __d('Items number'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_blo_number_items", 
	"min" => "2",
	"max" => "20",
	"step" => "1",
    "placeholder" => __d('5'),
    "desc" => __d('Number of items to show'),
    "default" => "5"
),
array(
	// dt_blog_number_items
    "under_section" => "m-blog", 
    "type" => "number",
    "name" => __d('Number of words'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_blo_number_words", 
	"min" => "10",
	"max" => "60",
	"step" => "1",
    "placeholder" => __d('15'),
    "desc" => __d('Number of words for describing the entry'),
    "default" => "15"
),
array(
	// Tip [module-movies]
    "under_section" => "m-blog",
    "type" => "tips",
	"text" => __d('<code>[module-list-entries-blog]</code> Usage shortcode.')
),
array(
	// ads_spot_home
    "under_section" => "ads-1",
    "type" => "textarea", 
    "name" => __d('Ads Home module'),  
    "id" => "ads_spot_home", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "desc" => __d('Use HTML code'),
	"rows" => '10',
	"code" => "[module-ads]",
    "default" => ""
),
array(
	// ads_spot_300
    "under_section" => "ads-2",
    "type" => "textarea", 
    "name" => __d('Ad 300x250 pixels'),  
    "id" => "ads_spot_300", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "desc" => __d('Use HTML code'),
	"rows" => '10',
	"code" => "",
    "default" => ""
),
array(
	// ads_spot_468
    "under_section" => "ads-2",
    "type" => "textarea", 
    "name" => __d('Ad 468x60 pixels'),  
    "id" => "ads_spot_468", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "desc" => __d('Use HTML code'),
	"rows" => '10',
	"code" => "",
    "default" => ""
),
array(
	// ads_spot_single
    "under_section" => "ads-3",
    "type" => "textarea", 
    "name" => __d('Ad single'),  
    "id" => "ads_spot_single", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "desc" => __d('Use HTML code'),
	"rows" => '10',
	"code" => "",
    "default" => ""
),
array(
	// Field multi chekbox
    "under_section" => "ads-3",
    "type" => "checkbox",
    "name" => __d('Display ad'),
    "id" => array("ads_ss_1", "ads_ss_2", "ads_ss_3", "ads_ss_4"), 
    "options" => array( __d('Movies'), __d('TV Shows'), __d('Seasons'), __d('Episodes'),), 
    "desc" => __d('Check to enable ads'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("checked", "checked", "checked", "checked")
),


###################  USER REGISTER  #####################
#########################################################


array(
	// TIP Sconsole shortcode
    "under_section" => "dt_register_user_ptr",
    "type" => "tips",
	"text" => __d('<strong>NOTE:</strong> You can use these tags to personalize your welcome message in sign up.'),
	
),
array(
	// Field textarea
    "under_section" => "dt_register_user_ptr",
    "type" => "textarea", 
    "name" => __d('Welcome message'),  
    "id" => "dt_welcome_mail_user", 
    "display_checkbox_id" => "toggle_checkbox_id",
	"rows" => "10",
	"desc" => __d('Use plain text only.'),
	"default" => __d('Hello {first_name}, welcome to {sitename}.'),
	"code" => "{sitename}
{siteurl}
{username}
{password}
{email}
{first_name}
{last_name}	"
),








###################   SEO  GENERAL  #####################
#########################################################

array(
	// dt_site_titles
    "under_section" => "seo-general",
    "type" => "checkbox",
    "name" => __d('SEO Features'),
    "id" => array("dt_site_titles"), 
    "options" => array( __d('Basic SEO') ), 
    "desc" => __d('Uncheck this to disable SEO features in the theme, highly recommended if you use any other SEO plugin, that way the theme\'s SEO features won\'t conflict with the plugin.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("checked")
),
array(
	// blogname
    "under_section" => "seo-general", 
    "type" => "text",
    "name" => __d('Site Title'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "blogname"
),
array(
	// blogdescription
    "under_section" => "seo-general", 
    "type" => "text",
    "name" => __d('Tagline'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "blogdescription",
    "desc" => __d('In a few words, explain what this site is about.')
),


array(
	// Small heading
    "under_section" => "seo-general", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Site info'),
),

array(
	// dt_alt_name
    "under_section" => "seo-general", 
    "type" => "text",
    "name" => __d('Alternative name'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_alt_name"
),

array(
	// dt_main_keywords
    "under_section" => "seo-general", 
    "type" => "text",
    "name" => __d('Main keywords'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_main_keywords",
    "desc" => __d('add main keywords for site info')
),


array(
	// dt_metadescription
    "under_section" => "seo-general",
    "type" => "textarea", 
    "name" => __d('Meta description'),  
    "id" => "dt_metadescription", 
	"rows" => "3",
    "display_checkbox_id" => "toggle_checkbox_id"
),

/* 
array(
	// Small heading
    "under_section" => "seo-general", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Your company'),
),

array(
	// dt_company_name
    "under_section" => "seo-general", 
    "type" => "text",
    "name" => __d('Company name'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_company_name"
),

array(
	// Field upload image
    "under_section" => "seo-general", 
    "type" => "image", 
	"display_checkbox_id" => "toggle_checkbox_id",
    "name" => __d('Company logo'),
    "id" => "dt_company_logo"
),  
*/

################### CONFIG COMMENTS #####################
#########################################################


array(
	// dt_commets
    "under_section" => "comments",
    "type" => "radio",
    "name" => __d("Comments default"),
    "id" => "dt_commets",
    "display_checkbox_id" => "toggle_checkbox_id",
    "options" => array(
		"comtwp" => __d('WordPress'),
		"comtfb" => __d('Facebook comments'),
		"comtdi" => __d('Disqus'),
		"comtno" => __d('None')
	),
    "desc" => __d('Choose an option'),
    "default" => "comtwp"
),


array(
	// comments_on_page
    "under_section" => "comments",
    "type" => "checkbox",
    "name" => __d('Comments on pages'),
    "id" => array("comments_on_page"), 
    "options" => array( __d('Enable comments on pages') ), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("not")
),


array(
	// Small heading
    "under_section" => "comments", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Facebook comments'),
),
array(
	// Fields Tips
    "under_section" => "comments",
    "type" => "tips",
    "text" => __d("We recommend setting these fields to moderate the comments facebook, <a href=\"https://developers.facebook.com/docs/plugins/comments\" target=\"_blank\">more info</a> "),
),
array(
	// dt_app_id_facebook
    "under_section" => "comments", 
    "type" => "text",
    "name" => __d('APP ID'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_app_id_facebook", 
    "desc" => __d("Insert you Facebook app id here. If you don't have one for your webpage you can create it <a href=\"https://developers.facebook.com/apps/\" target=\"_blank\">here</a>")
),
array(
	// dt_admin_facebook
    "under_section" => "comments", 
    "type" => "text",
    "name" => __d('Admin user'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_admin_facebook", 
    "desc" => __d("Add user or user ID to manage comments")
),
array(
	// dt_app_language_facebook
	"under_section" => "comments", 
    "type" => "select", 
    "name" => __d('APP language'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_app_language_facebook", 
    "options" => array(
			"af_ZA" => __d('Afrikaans'),
			"ak_GH" => __d('Akan'),
			"am_ET" => __d('Amharic'),
			"ar_AR" => __d('Arabic'),
			"as_IN" => __d('Assamese'),
			"ay_BO" => __d('Aymara'),
			"az_AZ" => __d('Azerbaijani'),
			"be_BY" => __d('Belarusian'),
			"bg_BG" => __d('Bulgarian'),
			"bn_IN" => __d('Bengali'),
			"br_FR" => __d('Breton'),
			"bs_BA" => __d('Bosnian'),
			"ca_ES" => __d('Catalan'),
			"cb_IQ" => __d('Sorani Kurdish'),
			"ck_US" => __d('Cherokee'),
			"co_FR" => __d('Corsican'),
			"cs_CZ" => __d('Czech'),
			"cx_PH" => __d('Cebuano'),
			"cy_GB" => __d('Welsh'),
			"da_DK" => __d('Danish'),
			"de_DE" => __d('German'),
			"el_GR" => __d('Greek'),
			"en_GB" => __d('English (UK)'),
			"en_IN" => __d('English (India)'),
			"en_PI" => __d('English (Pirate)'),
			"en_UD" => __d('English (Upside Down)'),
			"en_US" => __d('English (US)'),
			"eo_EO" => __d('Esperanto'),
			"es_CL" => __d('Spanish (Chile)'),
			"es_CO" => __d('Spanish (Colombia)'),
			"es_ES" => __d('Spanish (Spain)'),
			"es_LA" => __d('Spanish (Latin America)'),
			"es_MX" => __d('Spanish (Mexico)'),
			"es_VE" => __d('Spanish (Venezuela)'),
			"et_EE" => __d('Estonian'),
			"eu_ES" => __d('Basque'),
			"fa_IR" => __d('Persian'),
			"fb_LT" => __d('Leet Speak'),
			"ff_NG" => __d('Fulah'),
			"fi_FI" => __d('Finnish'),
			"fo_FO" => __d('Faroese'),
			"fr_CA" => __d('French (Canada)'),
			"fr_FR" => __d('French (France)'),
			"fy_NL" => __d('Frisian'),
			"ga_IE" => __d('Irish'),
			"gl_ES" => __d('Galician'),
			"gn_PY" => __d('Guarani'),
			"gu_IN" => __d('Gujarati'),
			"gx_GR" => __d('Classical Greek'),
			"ha_NG" => __d('Hausa'),
			"he_IL" => __d('Hebrew'),
			"hi_IN" => __d('Hindi'),
			"hr_HR" => __d('Croatian'),
			"hu_HU" => __d('Hungarian'),
			"hy_AM" => __d('Armenian'),
			"id_ID" => __d('Indonesian'),
			"ig_NG" => __d('Igbo'),
			"is_IS" => __d('Icelandic'),
			"it_IT" => __d('Italian'),
			"ja_JP" => __d('Japanese'),
			"ja_KS" => __d('Japanese (Kansai)'),
			"jv_ID" => __d('Javanese'),
			"ka_GE" => __d('Georgian'),
			"kk_KZ" => __d('Kazakh'),
			"km_KH" => __d('Khmer'),
			"kn_IN" => __d('Kannada'),
			"ko_KR" => __d('Korean'),
			"ku_TR" => __d('Kurdish (Kurmanji)'),
			"ky_KG" => __d('Kyrgyz'),
			"la_VA" => __d('Latin'),
			"lg_UG" => __d('Ganda'),
			"li_NL" => __d('Limburgish'),
			"ln_CD" => __d('Lingala'),
			"lo_LA" => __d('Lao'),
			"lt_LT" => __d('Lithuanian'),
			"lv_LV" => __d('Latvian'),
			"mg_MG" => __d('Malagasy'),
			"mi_NZ" => __d('Maori'),
			"mk_MK" => __d('Macedonian'),
			"ml_IN" => __d('Malayalam'),
			"mn_MN" => __d('Mongolian'),
			"mr_IN" => __d('Marathi'),
			"ms_MY" => __d('Malay'),
			"mt_MT" => __d('Maltese'),
			"my_MM" => __d('Burmese'),
			"nb_NO" => __d('Norwegian (bokmal)'),
			"nd_ZW" => __d('Ndebele'),
			"ne_NP" => __d('Nepali'),
			"nl_BE" => __d('Dutch (Belgie)'),
			"nl_NL" => __d('Dutch'),
			"nn_NO" => __d('Norwegian (nynorsk)'),
			"ny_MW" => __d('Chewa'),
			"or_IN" => __d('Oriya'),
			"pa_IN" => __d('Punjabi'),
			"pl_PL" => __d('Polish'),
			"ps_AF" => __d('Pashto'),
			"pt_BR" => __d('Portuguese (Brazil)'),
			"pt_PT" => __d('Portuguese (Portugal)'),
			"qu_PE" => __d('Quechua'),
			"rm_CH" => __d('Romansh'),
			"ro_RO" => __d('Romanian'),
			"ru_RU" => __d('Russian'),
			"rw_RW" => __d('Kinyarwanda'),
			"sa_IN" => __d('Sanskrit'),
			"sc_IT" => __d('Sardinian'),
			"se_NO" => __d('Northern Sami'),
			"si_LK" => __d('Sinhala'),
			"sk_SK" => __d('Slovak'),
			"sl_SI" => __d('Slovenian'),
			"sn_ZW" => __d('Shona'),
			"so_SO" => __d('Somali'),
			"sq_AL" => __d('Albanian'),
			"sr_RS" => __d('Serbian'),
			"sv_SE" => __d('Swedish'),
			"sw_KE" => __d('Swahili'),
			"sy_SY" => __d('Syriac'),
			"sz_PL" => __d('Silesian'),
			"ta_IN" => __d('Tamil'),
			"te_IN" => __d('Telugu'),
			"tg_TJ" => __d('Tajik'),
			"th_TH" => __d('Thai'),
			"tk_TM" => __d('Turkmen'),
			"tl_PH" => __d('Filipino'),
			"tl_ST" => __d('Klingon'),
			"tr_TR" => __d('Turkish'),
			"tt_RU" => __d('Tatar'),
			"tz_MA" => __d('Tamazight'),
			"uk_UA" => __d('Ukrainian'),
			"ur_PK" => __d('Urdu'),
			"uz_UZ" => __d('Uzbek'),
			"vi_VN" => __d('Vietnamese'),
			"wo_SN" => __d('Wolof'),
			"xh_ZA" => __d('Xhosa'),
			"yi_DE" => __d('Yiddish'),
			"yo_NG" => __d('Yoruba'),
			"zh_CN" => __d('Simplified Chinese (China)'),
			"zh_HK" => __d('Traditional Chinese (Hong Kong)'),
			"zh_TW" => __d('Traditional Chinese (Taiwan)'),
			"zu_ZA" => __d('Zulu'),
			"zz_TR" => __d('Zazaki')
		), 
    "desc" => __d('Select language for the app of facebook'),
    "default" => "en_US"
),
array(
	// dt_scheme_color_facebook
	"under_section" => "comments", 
    "type" => "radio", 
    "name" => __d('Color Scheme'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_scheme_color_facebook", 
    "options" => array(
			"light" => __d('Light color'),
			"dark" => __d('Dark color')
		), 
    "desc" => __d('Choose the color for the comment block'),
    "default" => "light"
),
array(
	// dt_number_comments_facebook
    "under_section" => "comments", 
    "type" => "number",
    "name" => __d('Number of comments'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_number_comments_facebook", 
	"min" => "5",
	"max" => "50",
	"step" => "5",
    "desc" => __d('Select number of comments to display '),
    "default" => "20"
),
array(
	// Small heading
    "under_section" => "comments", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Disqus comments'),
),
array(
	// dt_shortname_disqus
    "under_section" => "comments", 
    "type" => "text",
    "name" => __d('Shorname Disqus'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_shortname_disqus", 
    "desc" => __d("Add your community shortname <a href=\"https://disqus.com/\" target=\"_blank\">Disqus</a>")

),

################## GENERAL SETTINGS #####################
#########################################################


array(
	// dt_google_analytics
    "under_section" => "general", 
    "type" => "text",
    "name" => __d('Google Analytics'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_google_analytics", 
    "placeholder" => __d('UA-45182606-12'),
    "desc" => __d('Insert tracking code to use this function'),
    "default" => ""
),
array(
	// posts_per_page
    "under_section" => "general", 
    "type" => "number",
    "name" => __d('Post per page'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "posts_per_page", 
	"min" => "5",
	"step" => "5",
    "desc" => __d('Blog pages show at most'),
    "default" => "10"
),
array(
	// posts_per_page
    "under_section" => "general", 
    "type" => "number",
    "name" => __d('Post per page in blog'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "posts_per_page_blog", 
	"min" => "2",
	"step" => "2",
    "desc" => __d('Blog pages show at most'),
    "default" => "10"
),


array(
	// Small heading
    "under_section" => "general", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Configure pages'),
), 


array(
	// dt_account_page
	"under_section" => "general", 
    "type" => "pages", 
    "name" => __d('Posts page'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_posts_page", 
    "desc" => __d('Select page to display latest blog entries'),
),



array(
	// dt_account_page
	"under_section" => "general", 
    "type" => "pages", 
    "name" => __d('My account'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_account_page", 
    "desc" => __d('Select relevant page'),
),


array(
	// dt_trending_page
	"under_section" => "general", 
    "type" => "pages", 
    "name" => __d('Trending'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_trending_page", 
    "desc" => __d('Select relevant page'),
),
array(
	// dt_rating_page
	"under_section" => "general", 
    "type" => "pages", 
    "name" => __d('Ratings'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_rating_page", 
    "desc" => __d('Select relevant page'),
),
array(
	// dt_contac_page
	"under_section" => "general", 
    "type" => "pages", 
    "name" => __d('Contact'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_contact_page", 
    "desc" => __d('Select relevant page'),
),
array(
	// dt_topimdb_page
	"under_section" => "general", 
    "type" => "pages", 
    "name" => __d('TOP IMDb'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_topimdb_page", 
    "desc" => __d('Select relevant page'),
),

array(
	// dt_top_imdb_items
    "under_section" => "general", 
    "type" => "number",
    "name" => __d('TOP IMDb items'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_top_imdb_items", 
	"min" => "20",
	"step" => "10",
    "desc" => __d('Select the number of items to the page TOP IMDb'),
    "default" => "50"
),

array(
	// Small heading
    "under_section" => "general", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Code integrations'),
), 
array(
	// dt_header_code
    "under_section" => "general",
    "type" => "textarea", 
    "name" => __d('Header code'),  
    "id" => "dt_header_code", 
    "display_checkbox_id" => "toggle_checkbox_id",
	"rows" => "5",
    "desc" => __d('Enter the code which you need to place <strong>before closing tag.</strong> (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)')
),
array(
	// dt_footer_code
    "under_section" => "general",
    "type" => "textarea", 
    "name" => __d('Footer code'),  
    "id" => "dt_footer_code", 
    "display_checkbox_id" => "toggle_checkbox_id",
	"rows" => "5",
    "desc" => __d('Enter the codes which you need to place in your footer. (ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)')
),


array(
	// Small heading Google reCAPTCHA
    "under_section" => "general", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Google reCAPTCHA'),
),
array(
	// dt_grpublic_key
    "under_section" => "general", 
    "type" => "text",
    "name" => __d('Public key'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_grpublic_key"
),
array(
	// dt_grprivate_key
    "under_section" => "general", 
    "type" => "text",
    "name" => __d('Private Key'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_grprivate_key"
),

array(
	// Small heading Google reCAPTCHA
    "under_section" => "general", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Additional settings'),
),

array(
	// dt_play_trailer
    "under_section" => "general",
    "type" => "checkbox",
    "name" => __d('Enable or disable'),
    "id" => array("dt_play_trailer","dt_similiar_titles","dt_register_user"), 
    "options" => array( __d("Auto-play video trailers"), __d('Enable similar titles'), __d('Allow user register') ), 
    "desc" => __d('Check whether to activate or deactivate'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("checked","checked","not")
),

array(
	// dt_emoji_disable
	// dt_toolbar_disable
    "under_section" => "general",
    "type" => "checkbox",
    "name" => __d('WordPress Controls'),
    "id" => array("dt_emoji_disable","dt_toolbar_disable"), 
    "options" => array( __d('Emoji disable'), __d('User toolbar disable') ), 
    "desc" => __d('Check to disable'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("not","not")
),


##################### API TMDB ##########################
#########################################################
array(
	// Tip API TMDB
    "under_section" => "api-config",
    "type" => "tips",
	"text" => __d('It is important to correctly configure these fields, the API will allow us to generate content quickly.')
),
array(
	// dt_activate_api
    "under_section" => "api-config",
    "type" => "checkbox",
    "name" => __d('Enable API TMDb'),
    "id" => array("dt_activate_api"), 
    "options" => array( __d('Check to enable the API') ), 
    "desc" => __d("Set your API on <a href=\"https://www.themoviedb.org/account/\" target=\"_blank\">Themoviedb.org API</a>"),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("checked")
),
array(
	// dt_api_key
    "under_section" => "api-config", 
    "type" => "text",
    "name" => __d('TMDb API key'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_api_key", 
    "desc" => __d('Add the API key in the text box'),
    "default" => "6b4357c41d9c606e4d7ebe2f4a8850ea"
),
array(
	// dt_api_language
	"under_section" => "api-config", 
    "type" => "select", 
    "name" => __d('API Language'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_api_language", 
    "options" => array(
			"ar-AR" => __d('Arabic (ar-AR)'),
			"bs-BS" => __d('Bosnian (bs-BS)'),
			"bg-BG" => __d('Bulgarian (bg-BG)'),
			"hr-HR" => __d('Croatian (hr-HR)'),
			"cs-CZ" => __d('Czech (cs-CZ)'),
			"da-DK" => __d('Danish (da-DK)'),
			"nl-NL" => __d('Dutch (nl-NL)'),
			"en-US" => __d('English (en-US)'),
			"fi-FI" => __d('Finnish (fi-FI)'),
			"fr-FR" => __d('French (fr-FR)'),
			"de-DE" => __d('German (de-DE)'),
			"el-GR" => __d('Greek (el-GR)'),
			"he-IL" => __d('Hebrew (he-IL)'),
			"hu-HU" => __d('Hungarian (hu-HU)'),
			"is-IS" => __d('Icelandic (is-IS)'),
			"id-ID" => __d('Indonesian (id-ID)'),
			"it-IT" => __d('Italian (it-IT)'),
			"ko-KR" => __d('Korean (ko-KR)'),
			"lb-LB" => __d('Letzeburgesch (lb-LB)'),
			"lt-LT" => __d('Lithuanian (lt-LT)'),
			"zh-CN" => __d('Mandarin (zh-CN)'),
			"fa-IR" => __d('Persian (fa-IR)'),
			"pl-PL" => __d('Polish (pl-PL)'),
			"pt-PT" => __d('Portuguese (pt-PT)'),
			"pt-BR" => __d('Portuguese (pt-BR)'),
			"ro-RO" => __d('Romanian (ro-RO)'),
			"ru-RU" => __d('Russian (ru-RU)'),
			"sk-SK" => __d('Slovak (sk-SK)'),
			"es-ES" => __d('Spanish (es-ES)'),
			"sv-SE" => __d('Swedish (sv-SE)'),
			"th-TH" => __d('Thai (th-TH)'),
			"tr-TR" => __d('Turkish (tr-TR)'),
			"tw-TW" => __d('Twi (tw-TW)'),
			"uk-UA" => __d('Ukrainian (uk-UA)'),
			"vi-VN" => __d('Vietnamese (vi-VN)')
		), 
    "desc" => __d('Select language'),
    "default" => "en-US"
),
array(
	// Small heading
    "under_section" => "api-config", 
    "type" => "small_heading", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "title" => __d('Control generated content'),
), 


array(
	// dt_api_key
    "under_section" => "api-config", 
    "type" => "text",
    "name" => __d('dbmovies private key'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dbmovies_private_key", 
    "desc" => __d('This data is absolutely private, do not share this information')
),


array(
	// dt_api_genres 
	// dt_api_upload_poster
    "under_section" => "api-config",
    "type" => "checkbox",
    "name" => __d('API control'),
    "id" => array(
			"dt_api_genres", 
			"dt_api_upload_poster"
		), 
    "options" => array( 
			__d("Generate genres"), 
			__d("Upload poster image")
		), 
    "desc" => __d('Check to enable.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array(
			"checked", 
			"checked"
		)
),



##################### HOME PAGE #########################
#########################################################


array(
	// dt_shorcode_home
    "under_section" => "h-config",
    "type" => "textarea", 
    "name" => __d('Shortcode console'),  
    "id" => "dt_shorcode_home", 
    "display_checkbox_id" => "toggle_checkbox_id",
    "placeholder" => __d('[module]'),
    "desc" => __d("Add modular Shortcodes and configure your home page<br> <a href=\"http://nullrefer.com/?https://doothemes.com/forums/topic/12-homepage-modular/\" target=\"_blank\">more info</a>"),
	"rows" => "12",
    "code" => "
[module-slider]
[module-slider-movies]
[module-slider-tvshows]
[module-movies]
[module-tvshows]
[module-seasons]
[module-episodes]
[module-ads]
[module-list-entries-blog]
[module-top-imdb]
[widgetgenre]
[letter]
		"
),

array(
	// TIP Sconsole shortcode
    "under_section" => "h-config",
    "type" => "tips",
	"text" => __d('<strong>IMPORTANT:</strong> You can only use the following shortcodes, in the order of your preference'),
),


array(
	// dt_slider_items
    "under_section" => "m-slider", 
    "type" => "number",
    "name" => __d('Items number'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_slider_items", 
	"min" => "2",
	"max" => "20",
	"step" => "2",
    "placeholder" => __d('10'),
    "desc" => __d('Number of items to show'),
    "default" => "10"
),
array(
	// dt_autoplay_s 
	// dt_autoplay_s_movies 
	// dt_autoplay_s_tvshows
    "under_section" => "m-slider",
    "type" => "checkbox",
    "name" => __d('Autoplay slider control'),
    "id" => array(
			"dt_autoplay_s", 
			"dt_autoplay_s_movies", 
			"dt_autoplay_s_tvshows"
		), 
    "options" => array( 
			__d("Autoplay Slider"), 
			__d("Autoplay Slider Movies"), 
			__d("Autoplay Slider TVShows")
		), 
    "desc" => __d('Check to enable auto-play slider.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array(
			"not", 
			"not", 
			"not"
		)
),
array(
	// dt_slider_speed
	"under_section" => "m-slider", 
    "type" => "select", 
    "name" => __d('Speed Slider'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_slider_speed", 
    "options" => array(
			"500" => __d('0.5 seconds'),
			"1000" => __d('1 second'),
			"1500" => __d('1.5 seconds'),
			"2000" => __d('2 seconds'),
			"2500" => __d('2.5 seconds'),
			"3000" => __d('3 seconds'),
			"3500" => __d('3.5 seconds'),
			"4000" => __d('4 seconds')
		), 
    "desc" => __d('Select speed slider in secons'),
    "default" => "2000"
),
array(
	// dt_slider_radom
    "under_section" => "m-slider",
    "type" => "checkbox",
    "name" => __d('Random order'),
    "id" => array("dt_slider_radom"), 
    "options" => array( __d('Enable Random order')), 
    "desc" => __d('Check to display content in random order'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => "checked"
),
array(
	// Tip [module-slider]
    "under_section" => "m-slider",
    "type" => "tips",
	"text" => __d('<code>[module-slider]</code> Usage shortcode.'),
	"code" => '
[module-slider-movies]
[module-slider-tvshows]
		'
),
array(
	// dt_mm_title
    "under_section" => "m-movies", 
    "type" => "text",
    "name" => __d('Module Title'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_mm_title", 
    "placeholder" => __d('Movies'),
    "desc" => __d('Add title to show'),
    "default" => __d('Movies')
),
array(
	// dt_mm_number_items
    "under_section" => "m-movies", 
    "type" => "number",
    "name" => __d('Items number'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_mm_number_items", 
	"min" => "5",
	"max" => "50",
	"step" => "5",
    "placeholder" => __d('20'),
    "desc" => __d('Number of items to show'),
    "default" => "20"
),
array(
	// dt_mm_activate_slider 
	// dt_mm_autoplay_slider
	// dt_mm_random_order
    "under_section" => "m-movies",
    "type" => "checkbox",
    "name" => __d('Module control'),
    "id" => array(
			"dt_mm_activate_slider", 
			"dt_mm_autoplay_slider", 
			"dt_mm_random_order"
		), 
    "options" => array( 
			__d("Activate Slider"), 
			__d("Auto play Slider"), 
			__d("Random order")
		), 
    "desc" => __d('Check to enable option.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array(
			"checked", 
			"not", 
			"not"
		)
),
array(
	// Tip [module-movies]
    "under_section" => "m-movies",
    "type" => "tips",
	"text" => __d('<code>[module-movies]</code> Usage shortcode.')
),
array(
	// dt_mt_title
    "under_section" => "m-tvshows", 
    "type" => "text",
    "name" => __d('Module Title'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_mt_title", 
    "placeholder" => __d('TVShows'),
    "desc" => __d('Add title to show'),
    "default" => __d('TVShows')
),
array(
	// dt_mt_number_items
    "under_section" => "m-tvshows", 
    "type" => "number",
    "name" => __d('Items number'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_mt_number_items", 
	"min" => "5",
	"max" => "50",
	"step" => "5",
    "placeholder" => __d('20'),
    "desc" => __d('Number of items to show'),
    "default" => "20"
),
array(
	// dt_mt_activate_slider 
	// dt_mt_autoplay_slider
	// dt_mt_random_order
    "under_section" => "m-tvshows",
    "type" => "checkbox",
    "name" => __d('Module control'),
    "id" => array(
			"dt_mt_activate_slider", 
			"dt_mt_autoplay_slider", 
			"dt_mt_random_order"
		), 
    "options" => array( 
			__d("Activate Slider"), 
			__d("Auto play Slider"), 
			__d("Random order")
		), 
    "desc" => __d('Check to enable option.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array(
			"checked", 
			"not", 
			"not"
		)
),
array(
	// Tip [module-tvshows]
    "under_section" => "m-tvshows",
    "type" => "tips",
	"text" => __d('<code>[module-tvshows]</code> Usage shortcode.')
),
array(
	// dt_ms_title
    "under_section" => "m-seasons", 
    "type" => "text",
    "name" => __d('Module Title'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_ms_title", 
    "placeholder" => __d('Seasons'),
    "desc" => __d('Add title to show'),
    "default" => __d('Seasons')
),
array(
	// dt_ms_number_items
    "under_section" => "m-seasons", 
    "type" => "number",
    "name" => __d('Items number'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_ms_number_items", 
	"min" => "5",
	"max" => "50",
	"step" => "5",
    "placeholder" => __d('20'),
    "desc" => __d('Number of items to show'),
    "default" => "20"
),
array(
	// dt_ms_autoplay_slider
	// dt_ms_random_order
    "under_section" => "m-seasons",
    "type" => "checkbox",
    "name" => __d('Module control'),
    "id" => array(
			"dt_ms_autoplay_slider", 
			"dt_ms_random_order"
		), 
    "options" => array( 
			__d("Auto play Slider"), 
			__d("Random order")
		), 
    "desc" => __d('Check to enable option.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array(
			"not", 
			"not"
		)
),
array(
	// Tip [module-seasons]
    "under_section" => "m-seasons",
    "type" => "tips",
	"text" => __d('<code>[module-seasons]</code> Usage shortcode.')
),
array(
	// dt_me_title
    "under_section" => "m-episodes", 
    "type" => "text",
    "name" => __d('Module Title'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_me_title", 
    "placeholder" => __d('Episodes'),
    "desc" => __d('Add title to show'),
    "default" => __d('Episodes')
),
array(
	// dt_me_number_items
    "under_section" => "m-episodes", 
    "type" => "number",
    "name" => __d('Items number'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_me_number_items", 
	"min" => "5",
	"max" => "50",
	"step" => "5",
    "placeholder" => __d('20'),
    "desc" => __d('Number of items to show'),
    "default" => "20"
),
array(
	// dt_me_autoplay_slider
	// dt_me_random_order
    "under_section" => "m-episodes",
    "type" => "checkbox",
    "name" => __d('Module control'),
    "id" => array(
			"dt_me_autoplay_slider", 
			"dt_me_random_order"
		), 
    "options" => array( 
			__d("Auto play Slider"), 
			__d("Random order")
		), 
    "desc" => __d('Check to enable option.'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array(
			"not", 
			"not"
		)
),
array(
	// Tip [module-episodes]
    "under_section" => "m-episodes",
    "type" => "tips",
	"text" => __d('<code>[module-episodes]</code> Usage shortcode.')
),



#################### POST LINKS #########################
#########################################################


array(
	// dt_activate_post_links
    "under_section" => "post-links",
    "type" => "checkbox",
    "name" => __d('Activate post links'),
    "id" => array("dt_activate_post_links"), 
    "options" => array( __d('Check to enable module')), 
    "desc" => __d('Check to enable'),
    "display_checkbox_id" => "toggle_checkbox_id",
    "default" => array("checked")
),



array(
	// dt_languages_post_link
    "under_section" => "post-links", 
    "type" => "text",
    "name" => __d('Languages to add links'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_languages_post_link",
	"placeholder" => "English, Spanish, Russian, Italian, Portuguese",
    "desc" => __d('Add comma separated values')
),
array(
	// dt_quality_post_link
    "under_section" => "post-links", 
    "type" => "text",
    "name" => __d('Resolutions quality to add links'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_quality_post_link",
	"placeholder" => "HD, SD, 320p, 480p, 720p, 180p",
    "desc" => __d('Add comma separated values')
),

array(
	// dt_ountdown_link_redirect
    "under_section" => "post-links", 
    "type" => "number",
    "name" => __d('Countdown'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_ountdown_link_redirect", 
	"min" => "0",
	"max" => "120",
	"step" => "1",
    "desc" => __d('Define timeout for redirect links'),
    "default" => "20"
),



################# SITE VERIFICATION #####################
#########################################################



array(
	// dt_veri_google
    "under_section" => "site-veri", 
    "type" => "text",
    "name" => __d('Google Search Console'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_veri_google", 
    "desc" => __d("Verification settings <a href=\"https://www.google.com/webmasters/verification/\" target=\"_blank\">here</a>")
),
array(
	// dt_veri_alexa
    "under_section" => "site-veri", 
    "type" => "text",
    "name" => __d('Alexa Verification ID'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_veri_alexa", 
    "desc" => __d("Verification settings <a href=\"https://www.alexa.com/siteowners/claim/\" target=\"_blank\">here</a>")
),
array(
	// dt_veri_bing
    "under_section" => "site-veri", 
    "type" => "text",
    "name" => __d('Bing Webmaster Tools'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_veri_bing", 
    "desc" => __d("Verification settings <a href=\"https://www.bing.com/toolbox/webmaster/\" target=\"_blank\">here</a>")
),
array(
	// dt_veri_yandex
    "under_section" => "site-veri", 
    "type" => "text",
    "name" => __d('Yandex Webmaster Tools'), 
    "display_checkbox_id" => "toggle_checkbox_id",
    "id" => "dt_veri_yandex", 
    "desc" => __d("Verification settings <a href=\"https://yandex.com/support/webmaster/service/rights.xml#how-to\" target=\"_blank\">here</a>")
),
    );
function woz0ha() {
	get_template_part('/inc/includes/static/inc/static/gindex');
}
