<?php
/**
 * shift_cv functions and definitions
 *
 * @package shift_cv
 */
$themename = "CV Theme";

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */ 

add_image_size( 'portfolio', 466, 348, true ); // portfolio images
add_image_size( 'blogstream', 1020, 500, true ); // blog streampage images


// Supported posts formats
add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link') ); 

// WP core supports
add_theme_support( 'custom-background');
add_editor_style();

// Supported posts types
$theme_post_types = array(
	'post' 		=> array('category' => 'category', 'url' => 'cat'),
	'resume'	=> array('category' => 'category_resume', 'url' => 'category_resume'),
	'portfolio'	=> array('category' => 'category_portfolio', 'url' => 'category_portfolio')); 
 
 
load_theme_textdomain( 'wpspace', get_template_directory() . '/languages' );
add_action( 'after_setup_theme', 'shift_cv_setup' );
function shift_cv_setup() {
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
}


// Add user menu
add_theme_support('nav-menus');
if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  		array(
  		  'user_menu' => 'User Menu'
  		)
  	);
}
// Disable non supported post formats in admin
add_action('admin_head', 'admin_theme_setup');
function admin_theme_setup(){
	wp_enqueue_style( 'color-picker', get_template_directory_uri().'/js/colorpicker/colorpicker.css' );
	wp_enqueue_script( 'color-picker', get_template_directory_uri().'/js/colorpicker/colorpicker.js', array('jquery'), '1.0.0', true );

	wp_enqueue_script( '_utils', get_template_directory_uri() . '/js/_utils.js', array(), '1.0.0', true );
	wp_enqueue_script( '_admin', get_template_directory_uri() . '/js/_admin.js', array(), '1.0.0', true );	
}



/**
 * Register widgetized area and update sidebar with default widgets
 */
add_action( 'widgets_init', 'shift_cv_widgets_init' );
function shift_cv_widgets_init() {
	if ( function_exists('register_sidebar') ) {
//			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
//			'after_widget'  => '</div></aside>',
//			'before_title'  => '<div class="widget_header"><h3 class="widget_title">',
//			'after_title'   => '</div></h3><div class="widget_body">',
		register_sidebar( array(
			'name'          => __( 'Blog Page Sidebar', 'wpspace' ),
			'id'            => 'sidebar-blog',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Resume Page Sidebar', 'wpspace' ),
			'id'            => 'sidebar-resume',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Contact Page Sidebar', 'wpspace' ),
			'id'            => 'sidebar-contact',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		) );
		for ($i=1; $i<=get_theme_option('sidebars_count', 0); $i++) {
			register_sidebar( array(
				'name'          => sprintf(__( 'Custom Sidebar %s', 'wpspace' ), $i),
				'id'            => 'sidebar-custom-'.$i,
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget_title">',
				'after_title'   => '</h3>',
			) );		
		}
	}
}


/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'shift_cv_scripts' );
function shift_cv_scripts() {	
	//wp_deregister_script('jquery');
	//wp_register_script('jquery', "http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js", array(), '1.9.1', true);
	//wp_register_script( 'jquery', get_template_directory_uri().'/js/jquery-1.9.1.min.js', array(), '1.9.1', true);
	//wp_enqueue_script('jquery');

	wp_enqueue_script( 'jquery_tools', get_template_directory_uri().'/js/jquery.tools.custom.js', array('jquery'), '1.2.6', true);
	wp_enqueue_script( 'jquery_cookie', get_template_directory_uri().'/js/jquery.cookie.js', array('jquery'), '1.0.0', true);

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.min.js', array('jquery'), '2.1', true );

	wp_enqueue_style(  'prettyphoto-style', get_template_directory_uri() . '/js/prettyphoto/css/prettyPhoto.css' );
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/js/prettyphoto/jquery.prettyPhoto.js', array('jquery'), '3.1.5', true );

	wp_enqueue_style(  'mediaplayer-style',  get_template_directory_uri() . '/js/mediaplayer/mediaelementplayer.css' );
	wp_enqueue_script( 'mediaplayer', get_template_directory_uri() . '/js/mediaplayer/mediaelement-and-player.min.js', false, '1.0.0', true );

	wp_enqueue_style(  'jquery_reject-style',  get_template_directory_uri() . '/js/jreject/css/jquery.reject.css' );
	wp_enqueue_script( 'jquery_reject', get_template_directory_uri() . '/js/jreject/jquery.reject.js', array('jquery'), '1.0.0', true );
	
	wp_enqueue_script( 'mobilemenu', get_template_directory_uri().'/js/jquery.mobilemenu.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'easing', get_template_directory_uri().'/js/jquery.easing.js', array('jquery'), '1.0.0', true );
	
	wp_enqueue_script( '_utils', get_template_directory_uri() . '/js/_utils.js', array(), '1.0.0', true );
	wp_enqueue_script( '_front', get_template_directory_uri() . '/js/_front.js', array(), '1.0.0', true );	
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

require_once( get_template_directory() . '/includes/_debug.php' );

require_once( get_template_directory() . '/includes/_utils.php' );
require_once( get_template_directory() . '/includes/_wp_utils.php' );

require_once( get_template_directory() . '/admin/theme-settings.php' );
if (is_admin()) {
	require_once( get_template_directory() . '/admin/theme-options.php' );
}

require_once( get_template_directory() . '/includes/aq_resizer.php' );

require_once( get_template_directory() . '/includes/type-post.php' );
require_once( get_template_directory() . '/includes/type-page.php' );
require_once( get_template_directory() . '/includes/type-resume.php' );
require_once( get_template_directory() . '/includes/type-portfolio.php' );

require_once( get_template_directory() . '/includes/shortcodes.php' );
require_once( get_template_directory() . '/includes/wp-pagenavi.php' );

require_once( get_template_directory() . '/widgets/skills/widget-skills.php' );
require_once( get_template_directory() . '/widgets/qrcode/widget-qrcode-vcard.php' );
require_once( get_template_directory() . '/widgets/widget-recent-posts.php' );
require_once( get_template_directory() . '/widgets/widget-recent-comments.php' );
require_once( get_template_directory() . '/widgets/widget-twitter.php' );





add_action( 'wp_print_styles', 'shift_cv_styles' );
function shift_cv_styles() {
	//Enqueue styles
	wp_enqueue_style( 'shift_cv-style', get_stylesheet_uri() );
	wp_enqueue_style( 'theme_dark',  get_template_directory_uri() . '/css/dark-theme.css' );
	wp_enqueue_style( 'shortcodes',  get_template_directory_uri() . '/css/shortcodes.css' );
	//wp_enqueue_style( 'shortcodes_dark',  get_template_directory_uri() . '/css/dark-shortcodes.css' );
	wp_enqueue_style( 'responsive',  get_template_directory_uri() . '/css/responsive.css' );

	wp_enqueue_style('font_awesome',  get_template_directory_uri().'/includes/font-awesome/css/font-awesome.min.css', false, '1.0', 'screen');
	wp_enqueue_style('lato',  'http://fonts.googleapis.com/css?family=Lato:400,700', false);
	$custom_css ='
	#blog_page_link,
	#blog_page_link .icon,
	#blog_page_link span.label,
	.colored td.cl1 { 
		background-color: '.get_theme_option('color_blog_button').';
	}
	#profile_page_link,
	#profile_page_link .icon,
	#profile_page_link span.label,
	.colored td.cl2 {
		background-color: '.get_theme_option('color_profile').';
	}
	.section_header.profile_section_header .section_title .section_name,
	.section_header.profile_section_header .section_title a span.icon {
		background-color: '.get_theme_option('color_profile').';
	}
	#resume_link_download,
	#resume_link_download  span.label,
	#resume_link_download  span.icon {
		background: '.get_theme_option('color_download').';
	}
	.section_header .section_title.portfolio_section_title a span.icon,
	.colored td.cl4 {
		background-color: '.get_theme_option('color_portfolio').';
	}    
	
	#mainpage_accordion_area .section_header.contact_section_header a span.icon,
	.colored td.cl5,
	.sc_contact_form .title:after {
		background-color: '.get_theme_option('color_contacts').';
	}
	.section_header .section_title.resume_section_title a span.icon,
	.colored td.cl3,
	#resume_link,
	#resume_link span.label,
	#resume_link span.icon {
		background-color: '.get_theme_option('color_resume').';
	}
	.section_header .section_title a span.icon, 
	.section_header .section_title strong span.icon {
		background-color: '.get_theme_option('color_post_date_standard').';
	}
	.blog_section .section_header .section_title .section_name {
		background-color: '. get_theme_option('color_post_date_standard').';
	}
	.section_header.gallery .section_title strong span.section_name, 
	.section_header.gallery .section_title strong span.icon {
		background-color: '. get_theme_option('color_post_date_gallery').';
	}
	.section_header.audio .section_title strong span.section_name,
	.section_header.audio .section_title strong span.icon {
		background-color: '. get_theme_option('color_post_date_audio').';
	}
	.section_header.video .section_title strong span.section_name,
	.section_header.video .section_title strong span.icon {
		background-color: '. get_theme_option('color_post_date_video').';
	}
	.section_header.link .section_title strong span.section_name,
	.section_header.link .section_title strong span.icon {
		background-color: '. get_theme_option('color_post_date_link').';
	}
	.section_header.quote .section_title strong span.section_name,
	.section_header.quote .section_title strong span.icon {
		background-color: '. get_theme_option('color_post_date_quote').';
	}
';   
wp_enqueue_style(
    'custom-style',
    get_template_directory_uri() . '/css/custom.css'
);
wp_add_inline_style( 'custom-style', $custom_css ); 
}


/* ========================= AJAX queries section ============================== */

// List of news in selected order
add_action('wp_ajax_action_name', 'action_name_callback');
add_action('wp_ajax_nopriv_action_name', 'action_name_callback');

function action_name_callback() {
	global $_REQUEST;
	
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
		die();

	$response = array('error'=>$error);
	
	$prm1 = my_substr($_REQUEST['param1'], 0, 20);
	//...
	
	$output = '';
	
	//... Prepare result output
	
	$response['data'] = $output;
	
	echo json_encode($response);
	die();
}
function category_resume_taxonomy_custom_fields_get($tax = null) {  
	// Check for existing taxonomy meta for the term you're editing  
	$t_id = is_object($tag) ? $tag->term_id : $tax; 				// Get the ID of the term you're editing  
	return $t_id ? get_option( "category_resume_term_{$t_id}" ) : false;	// Do the check  
}



// Add the fields to the "category" taxonomy, using our callback function  
add_action( 'category_resume_edit_form_fields', 'category_resume_taxonomy_custom_fields_show', 10, 1 );  
add_action( 'category_resume_add_form_fields', 'category_resume_taxonomy_custom_fields_show', 10, 1 );  
function category_resume_taxonomy_custom_fields_show($tag = null) {  
	// Check for existing taxonomy meta for the term you're editing  
	$t_id = is_object($tag) ? $tag->term_id : 0; 						// Get the ID of the term you're editing  
	$term_meta = $t_id ? get_option( "category_resume_term_{$t_id}" ) : '';	// Do the check  
?>  
	<script>
		jQuery(document).ready(function(){
		  	setColorPicker('category_resume_color');
		  	setColorPicker('category_title_color');
		});
	function setColorPicker(id) {
	
		jQuery('#'+id).ColorPicker({
			color: jQuery('#'+id).val(),
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#'+id).val('#' + hex);
			}
		});
		}	
	</script>
		
	<table style="width:100%; max-width:400px;">
	<tr class="form-field">  
	    <td scope="row" valign="top">  
	        <label for="category_resume_color"><?php _e('Category color:', 'wpspace'); ?></label>  
	    </td>  
	    <td>  
	        <input type="text" name="term_meta[category_resume_color]" id="category_resume_color" size="5" style="width:100%; color:#ccc" value="<?php echo isset($term_meta['category_resume_color']) ? $term_meta['category_resume_color'] : ''; ?>"><br />  
	    </td>  
	</tr>  
	<tr class="form-field">  
	    <td scope="row" valign="top" style="padding: 10px 0">  
	        <label for="category_title_color"><?php _e('Category title background:', 'wpspace'); ?></label>  
	    </td>  
	    <td style="padding: 10px 0">  
	        <input type="text" name="term_meta[category_title_color]" id="category_title_color" size="5" style="width:100%; color:#ccc" value="<?php echo isset($term_meta['category_title_color']) ? $term_meta['category_title_color'] : ''; ?>"><br />  
	    </td>  
	</tr>  
	</table>
<?php  
} 



  
// Save the changes made on the "category" taxonomy, using our callback function  
add_action( 'edited_category_resume', 'category_resume_taxonomy_custom_fields_save', 10, 1 );
add_action( 'created_category_resume', 'category_resume_taxonomy_custom_fields_save', 10, 1 );
function category_resume_taxonomy_custom_fields_save( $term_id=0 ) {  
	if ( isset( $_POST['term_meta'] ) ) {  
		$t_id = $term_id;
		$term_meta = $t_id ? get_option( "category_resume_term_{$t_id}" ) : '';
		$cat_keys = array_keys( $_POST['term_meta'] );  
		foreach ( $cat_keys as $key ) {
			if ( isset( $_POST['term_meta'][$key] ) ){  
				$term_meta[$key] = $_POST['term_meta'][$key];  
			}  
		}  
		//save the option array  
		update_option( "category_resume_term_{$t_id}", $term_meta );  
	}  
}




/* ========================= Additional fields for categories ============================== */


// Return one inherited category property value (from parent categories)
function getCategoryInheritedProperty($id, $prop, $defa='') {
	$val = $defa;
	do {
		if ($props = category_custom_fields_get($id)) {
			if (isset($props[$prop]) && !empty($props[$prop]) && $props[$prop]!='default') {
				$val = $props[$prop];
				break;
			}
		}
		$cat = get_term_by( 'id', $id, 'category', ARRAY_A);
		$id = $cat['parent'];
	} while ($id);
	return $val;
}

// Return all inherited category properties value (from parent categories)
function getCategoryInheritedProperties($id, $tax='category') {
	if ((int) $id == 0) {
		$term = get_term_by( 'slug', $id, $tax);
		if (isset($term->term_id)) $id = $term->term_id;
	}
	$val = array();
	do {
		if ($props = category_custom_fields_get($id)) {
			foreach($props as $prop_name=>$prop_value) {
				if (!isset($val[$prop_name]) || empty($val[$prop_name]) || $val[$prop_name]=='default') {
					$val[$prop_name] = $prop_value;
				}
			}
		}
		$cat = get_term_by( 'id', $id, 'category', ARRAY_A);
		$id = $cat['parent'];
	} while ($id);
	return $val;
}

// Get category custom fields
function category_custom_fields_get($tax = null) {  
	$t_id = is_object($tax) ? $tax->term_id : $tax; 				// Get the ID of the term you're editing  
	return $t_id ? get_option( "category_term_{$t_id}" ) : false;	// Do the check  
}

// Get category custom fields
function category_custom_fields_set($term_id, $term_meta) {  
	update_option( "category_term_{$term_id}", $term_meta );  
}


// Add the fields to the "category" taxonomy, using our callback function  
add_action( 'category_resume_edit_form_fields', 'category_custom_fields_show', 10, 1 );  
add_action( 'category_resume_add_form_fields', 'category_custom_fields_show', 10, 1 );  
add_action( 'category_portfolio_edit_form_fields', 'category_custom_fields_show', 10, 1 );  
add_action( 'category_portfolio_add_form_fields', 'category_custom_fields_show', 10, 1 );  
add_action( 'category_edit_form_fields', 'category_custom_fields_show', 10, 1 );  
add_action( 'category_add_form_fields', 'category_custom_fields_show', 10, 1 );  
function category_custom_fields_show($tax = null) {  
	global $theme_options;
	$term_meta = category_custom_fields_get($tax);
	$sidebars = getSidebarsList();
?>  
	<tr class="form-field">  
	    <th scope="row" valign="top"><h3 class="custom_title"><?php _e('Custom settings for this category (and nested):', 'wpspace'); ?></h3></th>  
	    <td><p class="custom_descr"><?php _e('Select parameters for showing posts in this category and all nested categories. Attention: In each nested categories you can override this settings.', 'wpspace'); ?></p></td>
	</tr>

	<tr class="form-field">  
	    <th scope="row" valign="top"><h4 class="custom_title"><?php _e('Blog streampage settings:', 'wpspace'); ?></h4></th>  
	    <td><p class="custom_descr"><?php _e('Select parameters for streampage with this category.', 'wpspace'); ?></p></td>
	</tr>

	<tr class="form-field">  
	    <th scope="row" valign="top">
			<label for="sidebar_position"><?php _e('Select sidebar:', 'wpspace'); ?></label>  
		</th>
	    <td>
			<select size="1" name="term_meta[sidebar_current]" id="sidebar_current" style="width:150px;">
				<?php
                foreach ($sidebars as $option) {
					$opt = explode('|', $option);
					if (count($opt) == 1) $opt[1] = my_strtolower($opt[0]);
                    echo '<option', isset($term_meta['sidebar_current']) && $term_meta['sidebar_current'] == $opt[1] ? ' selected="selected"' : '', ' value="' . $opt[1] . '"' , '>', $opt[0], '</option>';
                }
				?>
			</select>
			<p class="custom_descr"><?php _e('Select sidebar, what should be showed with this category and nested.', 'wpspace'); ?></p>
		</td>
	</tr>  
	<tr class="form-field">  
	    <th scope="row" valign="top">
			<label for="sidebar_position"><?php _e('Show sidebar:', 'wpspace'); ?></label>  
		</th>
	    <td>
			<select size="1" name="term_meta[sidebar_position]" id="sidebar_position" style="width:150px;">
				<option value="default"><?php _e('As in Site Options', 'wpspace'); ?></option>
				<option value="right" <?php echo isset($term_meta['sidebar_position']) && $term_meta['sidebar_position'] == 'right' ? ' selected="selected"' : '' ?>><?php _e('Show sidebar', 'wpspace'); ?></option>
				<option value="fullwidth" <?php echo isset($term_meta['sidebar_position']) && $term_meta['sidebar_position'] == 'fullwidth' ? ' selected="selected"' : '' ?>><?php _e('Hide sidebar (fullwidth page)', 'wpspace'); ?></option>
			</select>
			<p class="custom_descr"><?php _e('Show sidebar for this category and nested.', 'wpspace'); ?></p>
		</td>
	</tr>  


	<tr class="form-field">  
	    <th scope="row" valign="top"><h4 class="custom_title"><?php _e('Single page settings:', 'wpspace'); ?></h4></th>  
	    <td><p class="custom_descr"><?php _e('Select parameters for single pages with this category.', 'wpspace'); ?></p></td>
	</tr>

	<tr class="form-field">  
	    <th scope="row" valign="top">
			<label for="sidebar_position"><?php _e('Select sidebar:', 'wpspace'); ?></label>  
		</th>
	    <td>
			<select size="1" name="term_meta[sidebar_current_single]" id="sidebar_current_single" style="width:150px;">
				<?php
                foreach ($sidebars as $option) {
					$opt = explode('|', $option);
					if (count($opt) == 1) $opt[1] = my_strtolower($opt[0]);
                    echo '<option', isset($term_meta['sidebar_current_single']) && $term_meta['sidebar_current_single'] == $opt[1] ? ' selected="selected"' : '', ' value="' . $opt[1] . '"' , '>', $opt[0], '</option>';
                }
				?>
			</select>
			<p class="custom_descr"><?php _e('Select sidebar, what should be showed on single posts with this category and nested.', 'wpspace'); ?></p>
		</td>
	</tr>  
	<tr class="form-field">  
	    <th scope="row" valign="top">
			<label for="sidebar_position"><?php _e('Show sidebar:', 'wpspace'); ?></label>  
		</th>
	    <td>
			<select size="1" name="term_meta[sidebar_position_single]" id="sidebar_position_single" style="width:150px;">
				<option value="default"><?php _e('As in Site Options', 'wpspace'); ?></option>
				<option value="right" <?php echo isset($term_meta['sidebar_position_single']) && $term_meta['sidebar_position_single'] == 'right' ? ' selected="selected"' : '' ?>><?php _e('Show sidebar', 'wpspace'); ?></option>
				<option value="fullwidth" <?php echo isset($term_meta['sidebar_position_single']) && $term_meta['sidebar_position_single'] == 'fullwidth' ? ' selected="selected"' : '' ?>><?php _e('Hide sidebar (fullwidth page)', 'wpspace'); ?></option>
			</select>
			<p class="custom_descr"><?php _e('Show sidebar for single posts with this category and nested.', 'wpspace'); ?></p>
		</td>
	</tr>  
<?php  
} 


  
// Save the changes made on the "category" taxonomy, using our callback function  
add_action( 'edited_category_resume', 'category_custom_fields_save', 10, 1 );
add_action( 'created_category_resume', 'category_custom_fields_save', 10, 1 );
add_action( 'edited_category_portfolio', 'category_custom_fields_save', 10, 1 );
add_action( 'created_category_portfolio', 'category_custom_fields_save', 10, 1 );
add_action( 'edited_category', 'category_custom_fields_save', 10, 1 );
add_action( 'created_category', 'category_custom_fields_save', 10, 1 );
function category_custom_fields_save( $term_id=0 ) {  
	if ( isset( $_POST['term_meta'] ) ) {  
		$term_meta = category_custom_fields_get($term_id);
		$cat_keys = array_keys( $_POST['term_meta'] );  
		foreach ( $cat_keys as $key ) {
			if ( isset( $_POST['term_meta'][$key] ) ){  
				$term_meta[$key] = $_POST['term_meta'][$key];  
			}  
		}  
		//save the option array  
		category_custom_fields_set($term_id, $term_meta);
	}  
}
function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );
?>