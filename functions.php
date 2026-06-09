<?php
/**
 * Divonex functions and definitions
 */

// Adds theme support for post formats.
if ( ! function_exists( 'divonex_post_format_setup' ) ) :
	function divonex_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
		add_theme_support( 'menus' );
	}
endif;
add_action( 'after_setup_theme', 'divonex_post_format_setup' );


// Enqueues style.css on the front.
if ( ! function_exists( 'divonex_enqueue_styles' ) ) :
	function divonex_enqueue_styles() {
		wp_enqueue_style(
			'divonex-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'divonex_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'divonex_block_styles' ) ) :
	function divonex_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'divonex' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'divonex_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'divonex_pattern_categories' ) ) :
	function divonex_pattern_categories() {
		register_block_pattern_category(
			'divonex',
			array(
				'label'       => __( 'Divonex', 'divonex' ),
				'description' => __( 'A collection of patterns for the Divonex theme.', 'divonex' ),
			)
		);
		register_block_pattern_category(
			'divonex_page',
			array(
				'label'       => __( 'Divonex Pages', 'divonex' ),
				'description' => __( 'A collection of full page layouts.', 'divonex' ),
			)
		);
	}
endif;
add_action( 'init', 'divonex_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'divonex_register_block_bindings' ) ) :
	function divonex_register_block_bindings() {
		register_block_bindings_source(
			'divonex/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'divonex' ),
				'get_value_callback' => 'divonex_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'divonex_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'divonex_format_binding' ) ) :
	function divonex_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

/**
 * Register Block Types
 *
 */

function divonex_register_blocks() {
	// Register from build directory if it exists
	if ( is_dir( __DIR__ . '/build/blocks' ) ) {
		if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) && file_exists( __DIR__ . '/build/blocks-manifest.php' ) ) {
			wp_register_block_types_from_metadata_collection( __DIR__ . '/build/blocks', __DIR__ . '/build/blocks-manifest.php' );
		} elseif ( function_exists( 'wp_register_block_metadata_collection' ) && file_exists( __DIR__ . '/build/blocks-manifest.php' ) ) {
			wp_register_block_metadata_collection( __DIR__ . '/build/blocks', __DIR__ . '/build/blocks-manifest.php' );
		} elseif ( file_exists( __DIR__ . '/build/blocks-manifest.php' ) ) {
			$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
			foreach ( array_keys( $manifest_data ) as $block_type ) {
				register_block_type( __DIR__ . "/build/blocks/{$block_type}" );
			}
		}
	}

	// Also register from src directory if it exists (for development)
	if ( is_dir( __DIR__ . '/src/blocks' ) ) {
		$blocks = glob( __DIR__ . '/src/blocks/*', GLOB_ONLYDIR );
		foreach ( $blocks as $block_path ) {
			if ( file_exists( $block_path . '/block.json' ) ) {
				register_block_type( $block_path );
			}
		}
	}
}
add_action( 'init', 'divonex_register_blocks' );

function divonex_localize_scripts() {
	wp_localize_script(
		'divonex-navigation-editor-script',
		'divonex',
		array(
			'menus' => divonex_get_menus(),
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'divonex_localize_scripts' );

/**
 * Register Divonex Category
 *
 */
function divonex_register_category( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug'  => 'divonex',
				'title' => __( 'Divonex', 'divonex' ),
				'icon'  => 'wordpress-alt',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'divonex_register_category', 10, 2 );

// Get All Menus
function divonex_get_menus() {
	$menus = wp_get_nav_menus();

	// check if menus exist
	if ( empty( $menus ) ) {
		return array();
	}

	$menu_items = array();
	foreach ( $menus as $menu ) {
		$menu_items[] = array(
			'label' => $menu->name,
			'value'  => $menu->slug,
		);
	}
	return $menu_items;
}

