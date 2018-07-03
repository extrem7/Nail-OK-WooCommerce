<?php
//wp setup
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );

//show_admin_bar( false );
function remove_menus() {

	//remove_menu_page( 'index.php' );                  //Dashboard
	//remove_menu_page( 'jetpack' );                    //Jetpack*
	//remove_menu_page( 'edit.php' );                   //Posts
	//remove_menu_page( 'upload.php' );                 //Media
	//remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	//remove_menu_page( 'themes.php' );                 //Appearance
	//remove_menu_page( 'plugins.php' );                //Plugins
	//remove_menu_page( 'users.php' );                  //Users
	//remove_menu_page( 'tools.php' );                  //Tools
	//remove_menu_page( 'options-general.php' );        //Settings

}

if ( isset( $_GET['s'] ) && $_GET['s'] == '' && ! is_admin() ) {
	wp_redirect( site_url() );
	exit;
}
if ( ! function_exists( 'post_count_on_archive' ) ):
	function post_count_on_archive( $query ) {
		if ( $query->is_search() ) {
			$query->set( 'posts_per_page', '100' ); /*set this your preferred count*/
		}
	}

	add_action( 'pre_get_posts', 'post_count_on_archive' );
endif;

add_action( 'admin_menu', 'remove_menus' );

// woocommerce support
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_filter( 'woocommerce_checkout_fields', 'custom_wc_checkout_fields' );
function custom_wc_checkout_fields( $fields ) {
	$fields['billing']['billing_address_1']['required'] = false;
	$fields['billing']['billing_country']['required']   = false;
	$fields['billing']['billing_city']['required']      = false;
	$fields['billing']['billing_postcode']['required']  = false;
	$fields['billing']['billing_address_2']['required'] = false;
	$fields['billing']['billing_state']['required']     = false;
	$fields['billing']['billing_email']['required']     = false;

	$fields['order']['order_comments']['type']      = 'text';
	$fields['billing']['billing_postcode']['label'] = 'Квартира';
	$fields['billing']['billing_state']['label']    = 'Корпус';

	unset( $fields['billing']['billing_last_name'] );
	//unset( $fields['billing']['billing_company'] );
	//unset( $fields['billing']['billing_postcode'] );
	//unset( $fields['billing']['billing_state'] );
	//unset( $fields['billing']['billing_email'] );
	//unset($fields['billing']['billing_country']);
	//unset($fields['billing']['billing_address_2']);
	//unset($fields['billing']['billing_state']);
	return $fields;
}


add_action( 'woocommerce_after_order_notes', 'customise_checkout_field' );
function customise_checkout_field( $checkout ) {
	echo '<div class="d-none">';
	woocommerce_form_field( 'politics', array(
		'type'     => 'checkbox',
		'label'    => __( 'Политика согласен' ),
		'required' => true,
	), $checkout->get_value( 'politics' ) );
	echo '</div>';
}

add_action( 'woocommerce_checkout_process', 'customise_checkout_field_process' );
function customise_checkout_field_process() {
	// if the field is set, if not then show an error message.
	if ( ! $_POST['politics'] ) {
		wc_add_notice( __( 'Вы должны быть согласны с политикой конфиденциальности' ), 'error' );
	}
}


function bamboo_request( $query_string ) {
	if ( isset( $query_string['page'] ) ) {
		if ( '' != $query_string['page'] ) {
			if ( isset( $query_string['name'] ) ) {
				unset( $query_string['name'] );
			}
		}
	}

	return $query_string;
}

add_filter( 'request', 'bamboo_request' );
add_action( 'pre_get_posts', 'bamboo_pre_get_posts' );
function bamboo_pre_get_posts( $query ) {
	if ( $query->is_main_query() && ! $query->is_feed() && ! is_admin() ) {
		global $page_cat;
		$page_cat = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$query->set( 'paged', str_replace( '/', '', get_query_var( 'page' ) ) );
	}
}

//usefull functions for development
function footer_enqueue_scripts() {
	remove_action( 'wp_head', 'wp_print_scripts' );
	remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
}

add_action( 'after_setup_theme', 'footer_enqueue_scripts' );
function cubiq_setup() {
	remove_action( 'wp_head', 'wp_generator' );                // #1
	remove_action( 'wp_head', 'wlwmanifest_link' );            // #2
	remove_action( 'wp_head', 'rsd_link' );                    // #3
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );        // #4
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );    // #5
	add_filter( 'the_generator', '__return_false' );            // #6
	add_filter( 'show_admin_bar', '__return_false' );            // #7
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );  // #8
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

wp_deregister_script( 'jquery' );
wp_register_script( 'jquery', '', '', '', true );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_action( 'wp_print_styles', 'registerThemeStyles' );
// add_action('wp_print_styles', 'theme_name_scripts'); // можно использовать этот хук он более поздний
function registerThemeStyles() {
	wp_register_style( 'myStyleSheets', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style( 'myStyleSheets' );
}

function registerThemeJs() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js' );
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'jquery.inputmask', get_template_directory_uri() . '/js/jquery.inputmask.bundle.min.js' );
	wp_enqueue_script( 'jquery.inputmask' );
	if ( is_cart() ) {
		wp_register_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js' );
		wp_enqueue_script( 'recaptcha' );
	}
	wp_register_script( 'main', get_template_directory_uri() . '/js/main.js' );
	wp_enqueue_script( 'main' );
}

add_action( 'wp_enqueue_scripts', 'registerThemeJs' );

function path() {
	echo get_template_directory_uri() . '/';
}

function the_image( $name, $id ) {
	echo 'src="' . get_field( $name, $id )['url'] . '" ';
	echo 'alt="' . get_field( $name, $id )['alt'] . '" ';
}

function repeater_image( $name ) {
	echo 'src="' . get_sub_field( $name )['url'] . '" ';
	echo 'alt="' . get_sub_field( $name )['alt'] . '" ';
}

function pre( $array ) {
	echo "<pre>";
	print_r( $array );
	echo "</pre>";
}

function get_term_top_most_parent( $term_id, $taxonomy ) {
	// start from the current term
	$parent = get_term_by( 'id', $term_id, $taxonomy );
	// climb up the hierarchy until we reach a term with parent = '0'
	while ( $parent->parent != '0' ) {
		$term_id = $parent->parent;

		$parent = get_term_by( 'id', $term_id, $taxonomy );
	}

	return $parent;
}

function create_school() {
	$slug = get_post( '160' )->post_name;
	register_post_type( 'coach', array(
		'labels'             => array(
			'name'          => __( 'Тренеры' ),
			'singular_name' => __( 'Тренеры' ),
			'add_new'       => __( 'Добавить тренера' ),
			'add_new_item'  => __( 'Добавить нового тренера' ),
			'edit'          => __( 'Редактировать тренера' ),
			'edit_item'     => __( 'Редактировать тренера' ),
			'new_item'      => __( 'Новый тренер' ),
			'all_items'     => __( 'Все тренеры' ),
			'view'          => __( 'Посмотреть тренера' ),
			'view_item'     => __( 'Посмотреть тренера' ),
			'search_items'  => __( 'Искать тренера' ),
			'not_found'     => __( 'Не найдены Тренеры' ),
		),
		'public'             => true,
		'publicly_queryable' => false,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'custom-fields' ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-universal-access',
		'has_archive'        => false,
	) );
	register_post_type( 'school', array(
		'labels'             => array(
			'name'          => __( 'Курсы' ),
			'singular_name' => __( 'Курсы' ),
			'add_new'       => __( 'Добавить Курс' ),
			'add_new_item'  => __( 'Добавить новый Курс' ),
			'edit'          => __( 'Редактировать Курс' ),
			'edit_item'     => __( 'Редактировать Курс' ),
			'new_item'      => __( 'Новый Курс' ),
			'all_items'     => __( 'Все Курсы' ),
			'view'          => __( 'Посмотреть Курс' ),
			'view_item'     => __( 'Посмотреть Курс' ),
			'search_items'  => __( 'Искать Курс' ),
			'not_found'     => __( 'Не найдены Курсы' ),
		),
		'public'             => true,
		'publicly_queryable' => true,
		'menu_position'      => 5,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-welcome-learn-more',
		'rewrite'            => array( 'slug' => $slug ),
		'has_archive'        => false,
	) );
}

add_action( 'init', 'create_school' );
//options page
if ( function_exists( 'acf_add_options_page' ) ) {
	$main = acf_add_options_page( array(
		'page_title' => 'Настройки темы',
		'menu_title' => 'Настройки темы',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
		'position'   => 2,
		'icon_url'   => 'dashicons-admin-customizer',
	) );
	acf_add_options_sub_page( array(
		'page_title'  => 'Хедер',
		'menu_title'  => 'Хедер',
		'parent_slug' => $main['menu_slug'],
		'menu_slug'   => 'header'
	) );
	acf_add_options_sub_page( array(
		'page_title'  => 'Футер',
		'menu_title'  => 'Футер',
		'parent_slug' => $main['menu_slug'],
		'menu_slug'   => 'footer'
	) );
}

//shortcodes
function banner( $atts ) {
	global $banner;
	$banner = $atts;
	ob_start();
	get_template_part( 'template-parts/banner-long' );

	return ob_get_clean();
}

function banner_map( $atts ) {
	ob_start();
	get_template_part( 'template-parts/banner-address' );

	return ob_get_clean();
}

function banner_certificate( $atts ) {
	ob_start();
	get_template_part( 'template-parts/banner-certificate' );

	return ob_get_clean();
}

function banner_course( $atts ) {
	ob_start();
	get_template_part( 'template-parts/banner-course' );

	return ob_get_clean();
}

function banner_study( $atts ) {
	ob_start();
	get_template_part( 'template-parts/advantage-study-min' );

	return ob_get_clean();
}

function banner_delivery( $atts ) {
	ob_start();
	if ( ! empty( $atts ) && in_array( 'min', $atts ) ) {
		get_template_part( 'template-parts/advantage-delivery-min' );
	} else {
		get_template_part( 'template-parts/advantage-delivery' );
	}

	return ob_get_clean();
}

function banner_service( $atts ) {
	ob_start();
	if ( ! empty( $atts ) && in_array( 'min', $atts ) ) {
		get_template_part( 'template-parts/advantage-service-min' );
	} else {
		get_template_part( 'template-parts/advantage-service' );
	}

	return ob_get_clean();
}

add_shortcode( 'banner', 'banner' );

add_shortcode( 'banner_map', 'banner_map' );
add_shortcode( 'banner_certificate', 'banner_certificate' );
add_shortcode( 'banner_study', 'banner_study' );
add_shortcode( 'banner_course', 'banner_course' );
add_shortcode( 'banner_delivery', 'banner_delivery' );
add_shortcode( 'banner_service', 'banner_service' );


require_once 'bootstrap_menu.php';