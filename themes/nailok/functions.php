<?php
//wp setup
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );
show_admin_bar( false );
function remove_menus() {

	//remove_menu_page( 'index.php' );                  //Dashboard
	//remove_menu_page( 'jetpack' );                    //Jetpack*
	//remove_menu_page( 'edit.php' );                   //Posts
	//remove_menu_page( 'upload.php' );                 //Media
	//remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	//remove_menu_page( 'themes.php' );                 //Appearance
	//remove_menu_page( 'plugins.php' );                //Plugins
	remove_menu_page( 'users.php' );                  //Users
	//remove_menu_page( 'tools.php' );                  //Tools
	//remove_menu_page( 'options-general.php' );        //Settings

}

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
	unset( $fields['billing']['billing_email'] );
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

function create_school() {
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
		'supports'           => array( 'title', 'thumbnail', 'custom-fields' ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-welcome-learn-more',
		'rewrite'            => array( 'slug' => 'school' ),
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

require_once 'bootstrap_menu.php';