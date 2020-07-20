<?php
/**
 * Spellolite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spellolite
 */
if ( ! class_exists( 'Spellolite_Theme_Setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 1.0.0
	 */
	class Spellolite_Theme_Setup {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * A reference to an instance of cherry framework core class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private $core = null;

		/**
		 * Holder for CSS layout scheme.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		public $layout = array();

		/**
		 * Holder for current customizer module instance.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		public $customizer = null;

		/**
		 * Holder for current dynamic_css module instance.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		public $dynamic_css = null;

		/**
		 * Sets up needed actions/filters for the theme to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Set the constants needed by the theme.
			add_action( 'after_setup_theme', array( $this, 'constants' ), -1 );

			// Load the installer core.
			add_action( 'after_setup_theme', require( trailingslashit( get_template_directory() ) . 'cherry-framework/setup.php' ), 0 );

			// Load the core functions/classes required by the rest of the theme.
			add_action( 'after_setup_theme', array( $this, 'get_core' ), 1 );

			// Language functions and translations setup.
			add_action( 'after_setup_theme', array( $this, 'l10n' ), 2 );

			// Handle theme supported features.
			add_action( 'after_setup_theme', array( $this, 'theme_support' ), 3 );

			// Load the theme includes.
			add_action( 'after_setup_theme', array( $this, 'includes' ), 4 );

			// Initialization of modules.
			add_action( 'after_setup_theme', array( $this, 'init' ), 10 );

			// Load admin files.
			add_action( 'wp_loaded', array( $this, 'admin' ), 1 );

			// Enqueue admin assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 9 );

			// Enqueue public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 20 );

			// Overrides the load textdomain function for the 'cherry-framework' domain.
			add_filter( 'override_load_textdomain', array( $this, 'override_load_textdomain' ), 5, 3 );

		}

		/**
		 * Defines the constant paths for use within the core and theme.
		 *
		 * @since 1.0.0
		 */
		public function constants() {
			global $content_width;

			/**
			 * Fires before definitions the constants.
			 *
			 * @since 1.0.0
			 */
			do_action( 'spellolite_constants_before' );

			$template  = get_template();
			$theme_obj = wp_get_theme( $template );

			/** Sets the theme version number. */
			define( 'SPELLOLITE_THEME_VERSION', $theme_obj->get( 'Version' ) );

			/** Sets the theme directory path. */
			define( 'SPELLOLITE_THEME_DIR', get_template_directory() );

			/** Sets the theme directory URI. */
			define( 'SPELLOLITE_THEME_URI', get_template_directory_uri() );

			/** Sets the path to the core framework directory. */
			defined( 'CHERRY_DIR' ) or define( 'CHERRY_DIR', trailingslashit( SPELLOLITE_THEME_DIR ) . 'cherry-framework' );

			/** Sets the path to the core framework directory URI. */
			defined( 'CHERRY_URI' ) or define( 'CHERRY_URI', trailingslashit( SPELLOLITE_THEME_URI ) . 'cherry-framework' );

			/** Sets the theme includes paths. */
			define( 'SPELLOLITE_THEME_CLASSES', trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/classes' );
			define( 'SPELLOLITE_THEME_WIDGETS', trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/widgets' );
			define( 'SPELLOLITE_THEME_EXT', trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/extensions' );

			/** Sets the theme assets URIs. */
			define( 'SPELLOLITE_THEME_CSS', trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/css' );
			define( 'SPELLOLITE_THEME_JS', trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/js' );

			// Sets the content width in pixels, based on the theme's design and stylesheet.
			if ( ! isset( $content_width ) ) {
				$content_width = 885;
			}
		}

		/**
		 * Loads the core functions. These files are needed before loading anything else in the
		 * theme because they have required functions for use.
		 *
		 * @since  1.0.0
		 */
		public function get_core() {
			/**
			 * Fires before loads the core theme functions.
			 *
			 * @since 1.0.0
			 */
			do_action( 'spellolite_core_before' );

			global $chery_core_version;

			if ( null !== $this->core ) {
				return $this->core;
			}

			if ( 0 < sizeof( $chery_core_version ) ) {
				$core_paths = array_values( $chery_core_version );

				require_once( $core_paths[0] );
			} else {
				die( 'Class Cherry_Core not found' );
			}

			$this->core = new Cherry_Core( array(
				'base_dir' => CHERRY_DIR,
				'base_url' => CHERRY_URI,
				'modules'  => array(
					'cherry-js-core' => array(
						'autoload' => true,
					),
					'cherry-ui-elements' => array(
						'autoload' => false,
					),
					'cherry-interface-builder' => array(
						'autoload' => false,
					),
					'cherry-utility' => array(
						'autoload' => true,
						'args'     => array(
							'meta_key' => array(
								'term_thumb' => 'cherry_terms_thumbnails',
							),
						),
					),
					'cherry-widget-factory' => array(
						'autoload' => true,
					),
					'cherry-post-formats-api' => array(
						'autoload' => true,
						'args'     => array(
							'rewrite_default_gallery' => true,
							'gallery_args' => array(
								'size'          => 'spellolite-thumb-l',
								'base_class'    => 'post-gallery',
								'container'     => '<div class="%2$s swiper-container" id="%4$s" %3$s><div class="swiper-wrapper">%1$s</div><div class="swiper-button-prev"><i class="linearicon linearicon-chevron-left"></i></div><div class="swiper-button-next"><i class="linearicon linearicon-chevron-right"></i></div><div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"></div></div>',
								'slide'         => '<figure class="%2$s swiper-slide">%1$s</figure>',
								'img_class'     => 'swiper-image',
								'slider_handle' => 'jquery-swiper',
								'slider'        => 'swiper',
								'popup'         => 'magnificPopup',
								'popup_handle'  => 'magnific-popup',
								'popup_init'    => array(
									'type' => 'image',
								),
							),
							'image_args' => array(
								'size'         => 'spellolite-thumb-l',
								'popup'        => 'magnificPopup',
								'popup_handle' => 'magnific-popup',
								'popup_init'   => array(
									'type' => 'image',
								),
							),
						),
					),
					'cherry-customizer' => array(
						'autoload' => false,
					),
					'cherry-dynamic-css' => array(
						'autoload' => false,
					),
					'cherry-google-fonts-loader' => array(
						'autoload' => false,
					),
					'cherry-term-meta' => array(
						'autoload' => false,
					),
					'cherry-post-meta' => array(
						'autoload' => false,
					),
					'cherry-breadcrumbs' => array(
						'autoload' => false,
					),
				),
			) );

			return $this->core;
		}

		/**
		 * Loads the theme translation file.
		 *
		 * @since 1.0.0
		 */
		public function l10n() {
			/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 */
			load_theme_textdomain( 'spellolite', trailingslashit( SPELLOLITE_THEME_DIR ) . 'languages' );
		}

		/**
		 * Adds theme supported features.
		 *
		 * @since 1.0.0
		 */
		public function theme_support() {

			// Enable support for Post Thumbnails on posts and pages.
			add_theme_support( 'post-thumbnails' );

			// Enable HTML5 markup structure.
			add_theme_support( 'html5', array(
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
			) );

			// Enable default title tag.
			add_theme_support( 'title-tag' );

			// Enable post formats.
			add_theme_support( 'post-formats', array(
				'aside',
				'gallery',
				'image',
				'link',
				'quote',
				'video',
				'audio',
				'status',
			) );

			// Enable custom background.
			add_theme_support( 'custom-background', array( 'default-color' => 'ffffff' ) );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			// Add support for mobile menu
			add_theme_support( 'tm-custom-mobile-menu' );
		}

		/**
		 * Loads the theme files supported by themes and template-related functions/classes.
		 *
		 * @since 1.0.0
		 */
		public function includes() {
			/**
			 * Configurations.
			 */
			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'config/layout.php';
			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'config/menus.php';
			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'config/sidebars.php';
			require_if_theme_supports( 'post-thumbnails', trailingslashit( SPELLOLITE_THEME_DIR ) . 'config/thumbnails.php' );

			/**
			 * Functions.
			 */
			if ( ! is_admin() ) {
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/template-tags.php';
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/template-menu.php';
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/template-meta.php';
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/template-comment.php';
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/template-related-posts.php';
			}

			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/extras.php';
			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/context.php';
			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/customizer.php';
			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/hooks.php';
			require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/register-plugins.php';

			/**
			 * Third party plugins hooks.
			 */
			if ( class_exists( 'Cherry_Projects' ) ) {
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-projects.php';
			}

			if ( class_exists( 'Cherry_Services_List' ) ) {
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-services-list.php';
			}

			if ( class_exists( 'TM_Testimonials_Plugin' ) ) {
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-testi.php';
			}

			if ( class_exists( 'Tm_Builder_Plugin' ) ) {
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/plugins-hooks/power-builder.php';
			}

			if ( class_exists( 'tm_mega_menu' ) ) {
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/plugins-hooks/tm-mega-menu.php';
			}

			if ( class_exists( 'MP_Restaurant_Menu_Setup_Plugin' ) ) {
				require_once trailingslashit( SPELLOLITE_THEME_DIR ) . 'inc/plugins-hooks/mp-restaurant-menu.php';
			}

			/**
			 * Widgets.
			 */
			require_once trailingslashit( SPELLOLITE_THEME_WIDGETS ) . 'carousel/class-carousel-widget.php';
			require_once trailingslashit( SPELLOLITE_THEME_WIDGETS ) . 'subscribe-follow/class-subscribe-follow-widget.php';

			/**
			 * Classes.
			 */
			if ( ! is_admin() ) {
				require_once trailingslashit( SPELLOLITE_THEME_CLASSES ) . 'class-wrapping.php';
			}

			require_once trailingslashit( SPELLOLITE_THEME_CLASSES ) . 'class-widget-area.php';
			require_once trailingslashit( SPELLOLITE_THEME_CLASSES ) . 'class-tgm-plugin-activation.php';

			/**
			 * Extensions.
			 */
			require_once trailingslashit( SPELLOLITE_THEME_EXT ) . 'import.php';

		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			$this->customizer  = $this->get_core()->init_module( 'cherry-customizer', spellolite_get_customizer_options() );
			$this->dynamic_css = $this->get_core()->init_module( 'cherry-dynamic-css', spellolite_get_dynamic_css_options() );
			$this->get_core()->init_module( 'cherry-google-fonts-loader', spellolite_get_fonts_options() );
			$this->get_core()->init_module( 'cherry-term-meta', array(
				'tax'      => 'category',
				'priority' => 10,
				'fields'   => array(
					'cherry_terms_thumbnails' => array(
						'type'                => 'media',
						'value'               => '',
						'multi_upload'        => false,
						'library_type'        => 'image',
						'upload_button_text'  => esc_html__( 'Set thumbnail', 'spellolite' ),
						'label'               => esc_html__( 'Category thumbnail', 'spellolite' ),
					),
				),
			) );
			$this->get_core()->init_module( 'cherry-term-meta', array(
				'tax'      => 'post_tag',
				'priority' => 10,
				'fields'   => array(
					'cherry_terms_thumbnails' => array(
						'type'                => 'media',
						'value'               => '',
						'multi_upload'        => false,
						'library_type'        => 'image',
						'upload_button_text'  => esc_html__( 'Set thumbnail', 'spellolite' ),
						'label'               => esc_html__( 'Tag thumbnail', 'spellolite' ),
					),
				),
			) );
			$this->get_core()->init_module( 'cherry-post-meta', apply_filters( 'spellolite_page_settings_meta',  array(
				'id'            => 'page-settings',
				'title'         => esc_html__( 'Page settings', 'spellolite' ),
				'page'          => array( 'post', 'page' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'callback_args' => false,
				'fields'        => array(
					'tabs' => array(
						'element' => 'component',
						'type'    => 'component-tab-horizontal',
					),
					'layout_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Layout Options', 'spellolite' ),
					),
					'header_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Header Style', 'spellolite' ),
						'description' => esc_html__( 'Header style settings', 'spellolite' ),
					),
					'header_elements_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Header Elements', 'spellolite' ),
						'description' => esc_html__( 'Enable/Disable header elements', 'spellolite' ),
					),
					'breadcrumbs_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Breadcrumbs', 'spellolite' ),
						'description' => esc_html__( 'Breadcrumbs settings', 'spellolite' ),
					),
					'footer_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Footer Settings', 'spellolite' ),
						'description' => esc_html__( 'Footer settings', 'spellolite' ),
					),
					'spellolite_sidebar_position' => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Sidebar Layout', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit' => array(
								'label'   => esc_html__( 'Inherit', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'one-left-sidebar' => array(
								'label'   => esc_html__( 'Sidebar on left side', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/page-layout-left-sidebar.svg',
							),
							'one-right-sidebar' => array(
								'label'   => esc_html__( 'Sidebar on right side', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/page-layout-right-sidebar.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'No sidebar', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/page-layout-fullwidth.svg',
							),
						),
					),
					'spellolite_header_container_type' => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Header layout', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit'   => array(
								'label'   => esc_html__( 'Inherit', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'boxed'     => array(
								'label'   => esc_html__( 'Boxed', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/type-boxed.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'Fullwidth', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/type-fullwidth.svg',
							),
						),
					),
					'spellolite_content_container_type' => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Content layout', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit'   => array(
								'label'   => esc_html__( 'Inherit', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'boxed'     => array(
								'label'   => esc_html__( 'Boxed', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/type-boxed.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'Fullwidth', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/type-fullwidth.svg',
							),
						),
					),
					'spellolite_footer_container_type'  => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Footer layout', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit'   => array(
								'label'   => esc_html__( 'Inherit', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'boxed'     => array(
								'label'   => esc_html__( 'Boxed', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/type-boxed.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'Fullwidth', 'spellolite' ),
								'img_src' => trailingslashit( SPELLOLITE_THEME_URI ) . 'assets/images/admin/type-fullwidth.svg',
							),
						),
					),
					'spellolite_header_layout_type' => array(
						'type'    => 'select',
						'parent'  => 'header_tab',
						'title'   => esc_html__( 'Header Layout', 'spellolite' ),
						'value'   => 'inherit',
						'options' => spellolite_get_header_layout_pm_options(),
					),
					'spellolite_header_transparent_layout' => array(
						'type'          => 'radio',
						'parent'        => 'header_tab',
						'title'         => esc_html__( 'Header Overlay', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'spellolite' ),
							),
							'true'    => array(
								'label' => esc_html__( 'Enable', 'spellolite' ),
							),
							'false'   => array(
								'label' => esc_html__( 'Disable', 'spellolite' ),
							),
						),
					),
					'spellolite_header_invert_color_scheme' => array(
						'type'          => 'radio',
						'parent'        => 'header_tab',
						'title'         => esc_html__( 'Invert Color scheme', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'spellolite' ),
							),
							'true'    => array(
								'label' => esc_html__( 'Enable', 'spellolite' ),
							),
							'false'   => array(
								'label' => esc_html__( 'Disable', 'spellolite' ),
							),
						),
					),
					'spellolite_top_panel_visibility' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Top panel', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'spellolite' ),
							'true'    => esc_html__( 'Enable', 'spellolite' ),
							'false'   => esc_html__( 'Disable', 'spellolite' ),
						),
					),
					'spellolite_header_contact_block_visibility' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Header Contact Block', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'spellolite' ),
							'true'    => esc_html__( 'Enable', 'spellolite' ),
							'false'   => esc_html__( 'Disable', 'spellolite' ),
						),
					),
					'spellolite_header_search' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Header Search', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'spellolite' ),
							'true'    => esc_html__( 'Enable', 'spellolite' ),
							'false'   => esc_html__( 'Disable', 'spellolite' ),
						),
					),
					'spellolite_header_btn_visibility' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Header CTA button', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'spellolite' ),
							'true'    => esc_html__( 'Enable', 'spellolite' ),
							'false'   => esc_html__( 'Disable', 'spellolite' ),
						),
					),
					'spellolite_breadcrumbs_visibillity' => array(
						'type'          => 'radio',
						'parent'        => 'breadcrumbs_tab',
						'title'         => esc_html__( 'Breadcrumbs visibillity', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'spellolite' ),
							),
							'true'    => array(
								'label' => esc_html__( 'Enable', 'spellolite' ),
							),
							'false'   => array(
								'label' => esc_html__( 'Disable', 'spellolite' ),
							),
						),
					),
					'spellolite_footer_layout_type' => array(
						'type'    => 'select',
						'parent'  => 'footer_tab',
						'title'   => esc_html__( 'Footer Layout', 'spellolite' ),
						'value'   => 'inherit',
						'options' => spellolite_get_footer_layout_pm_options(),
					),
					'spellolite_footer_widget_area_visibility' => array(
						'type'          => 'select',
						'parent'        => 'footer_tab',
						'title'         => esc_html__( 'Footer Widgets Area', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'spellolite' ),
							'true'    => esc_html__( 'Enable', 'spellolite' ),
							'false'   => esc_html__( 'Disable', 'spellolite' ),
						),
					),
					'spellolite_footer_contact_block_visibility' => array(
						'type'          => 'select',
						'parent'        => 'footer_tab',
						'title'         => esc_html__( 'Footer Contact Block', 'spellolite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'spellolite' ),
							'true'    => esc_html__( 'Enable', 'spellolite' ),
							'false'   => esc_html__( 'Disable', 'spellolite' ),
						),
					),
				),
			) ) );
			$this->get_core()->init_module( 'cherry-post-meta', array(
				'id'            => 'post-single-type',
				'title'         => esc_html__( 'Single Post Style', 'spellolite' ),
				'page'          => array( 'post' ),
				'context'       => 'side',
				'priority'      => 'low',
				'callback_args' => false,
				'fields' => array(
					'spellolite_single_post_type' => array(
						'type'          => 'radio',
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'spellolite' ),
							),
							'default' => array(
								'label' => esc_html__( 'Default', 'spellolite' ),
							),
							'modern'  => array(
								'label' => esc_html__( 'Modern', 'spellolite' ),
							),
						),
					),
				),
			) );
		}

		/**
		 * Load admin files for the theme.
		 *
		 * @since 1.0.0
		 */
		public function admin() {

			// Check if in the WordPress admin.
			if ( ! is_admin() ) {
				return;
			}
			add_action( 'admin_notices',  array( $this, 'spellolite_premium_notice' ), 1 );
			add_action( 'admin_head', array( $this, 'spellolite_premium_notice_styles' ) );
			add_action( 'admin_menu', array( $this, 'spellolite_update_to_pro_appearance_menu_item' ) );
		}

		/**
		 * Enqueue admin-specific assets.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_admin_assets( $hook ) {
			// FIX admin style to `The Events Calendar` plugin
			if ( class_exists( 'Tribe__Events__Main' ) ) {
				wp_enqueue_style( 'spellolite-admin-fix-style', SPELLOLITE_THEME_CSS . '/admin-fix.min.css', array(), SPELLOLITE_THEME_VERSION );
			}

			$available_pages = array(
				'widgets.php',
			);

			if ( ! in_array( $hook, $available_pages ) ) {
				return;
			}

			wp_enqueue_style( 'spellolite-admin-style', SPELLOLITE_THEME_CSS . '/admin.min.css', array(), SPELLOLITE_THEME_VERSION );
		}

		/**
		 * Register assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {
			wp_register_script( 'jquery-slider-pro', SPELLOLITE_THEME_JS . '/min/jquery.slider-pro.min.js', array( 'jquery' ), '1.2.4', true );
			wp_register_script( 'jquery-swiper', SPELLOLITE_THEME_JS . '/min/swiper.jquery.min.js', array( 'jquery' ), '3.3.0', true );
			wp_register_script( 'magnific-popup', SPELLOLITE_THEME_JS . '/min/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
			wp_register_script( 'object-fit-images', SPELLOLITE_THEME_JS . '/min/ofi.min.js', array(), '3.0.1', true );

			wp_register_style( 'jquery-slider-pro', SPELLOLITE_THEME_CSS . '/slider-pro.min.css', array(), '1.2.4' );
			wp_register_style( 'jquery-swiper', SPELLOLITE_THEME_CSS . '/swiper.min.css', array(), '3.3.0' );
			wp_register_style( 'magnific-popup', SPELLOLITE_THEME_CSS . '/magnific-popup.min.css', array(), '1.1.0' );
			wp_register_style( 'font-awesome', SPELLOLITE_THEME_CSS . '/font-awesome.min.css', array(), '4.6.3' );
			wp_register_style( 'material-icons', SPELLOLITE_THEME_CSS . '/material-icons.min.css', array(), '2.2.0' );
			wp_register_style( 'linear-icons', SPELLOLITE_THEME_CSS . '/linearicons.css', array(), '1.0.0' );

			wp_dequeue_script( 'booked-font-awesome' );
			wp_dequeue_script( 'timeline-fontawesome-css' );
			wp_dequeue_script( 'bootstrap-grid' );
		}

		/**
		 * Enqueue assets.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_assets() {
			wp_enqueue_style( 'spellolite-theme-style', get_stylesheet_uri(),
				array( 'font-awesome', 'material-icons', 'magnific-popup', 'linear-icons' ),
				SPELLOLITE_THEME_VERSION
			);

			wp_add_inline_style( 'spellolite-theme-style', spellolite_header_footer_css() );

			if ( is_404() ) {
				wp_add_inline_style( 'spellolite-theme-style', spellolite_404_inline_css() );
			}

			/**
			 * Filter the depends on main theme script.
			 *
			 * @since 1.0.0
			 * @var   array
			 */
			$depends = apply_filters( 'spellolite_theme_script_depends', array( 'cherry-js-core', 'hoverIntent' ) );

			wp_enqueue_script( 'spellolite-theme-script', SPELLOLITE_THEME_JS . '/theme-script.js', $depends, SPELLOLITE_THEME_VERSION, true );

			/**
			 * Filter the strings that send to scripts.
			 *
			 * @since 1.0.0
			 * @var   array
			 */
			$labels = apply_filters( 'spellolite_theme_localize_labels', array(
				'totop_button'  => '',
				'header_layout' => get_theme_mod( 'header_layout_type', spellolite_theme()->customizer->get_default( 'header_layout_type' ) ),
			) );

			$more_button_options = apply_filters( 'spellolite_theme_more_button_options', array(
				'more_button_type'             => get_theme_mod( 'more_button_type', spellolite_theme()->customizer->get_default( 'more_button_type' ) ),
				'more_button_text'             => get_theme_mod( 'more_button_text', spellolite_theme()->customizer->get_default( 'more_button_text' ) ),
				'more_button_icon'             => get_theme_mod( 'more_button_icon', spellolite_theme()->customizer->get_default( 'more_button_icon' ) ),
				'more_button_image_url'        => get_theme_mod( 'more_button_image_url', spellolite_theme()->customizer->get_default( 'more_button_image_url' ) ),
				'retina_more_button_image_url' => get_theme_mod( 'retina_more_button_image_url', spellolite_theme()->customizer->get_default( 'retina_more_button_image_url' ) ),
			) );

			wp_localize_script( 'spellolite-theme-script', 'spellolite', apply_filters(
				'spellolite_theme_script_variables',
				array(
					'ajaxurl'             => esc_url( admin_url( 'admin-ajax.php' ) ),
					'labels'              => $labels,
					'more_button_options' => $more_button_options,
				) ) );

			// Threaded Comments.
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Overrides the load textdomain functionality when 'cherry-framework' is the domain in use.
		 *
		 * @since  1.0.0
		 * @link   https://gist.github.com/justintadlock/7a605c29ae26c80878d0
		 *
		 * @param  bool   $override
		 * @param  string $domain
		 * @param  string $mofile
		 *
		 * @return bool
		 */
		public function override_load_textdomain( $override, $domain, $mofile ) {

			// Check if the domain is our framework domain.
			if ( 'cherry-framework' === $domain ) {

				global $l10n;

				// If the theme's textdomain is loaded, assign the theme's translations
				// to the framework's textdomain.
				if ( isset( $l10n['spellolite'] ) ) {
					$l10n[ $domain ] = $l10n['spellolite'];
				}

				// Always override.  We only want the theme to handle translations.
				$override = true;
			}

			return $override;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function spellolite_premium_notice() {
			$id = 'spellolite_premium_notice';
			$class = 'notice';
			$message = __( 'Check out <a href="https://www.templatemonster.com/wordpress-themes/62354.html" target="_blank">Spello premium</a>! Get more features, widgets and 24/7 support.', 'spellolite' );

            printf( '<div id="%1$s" class="%2$s"><p>%3$s</p></div>', $id, $class, $message );
        }

		public function spellolite_premium_notice_styles() {
			?>
			<style type="text/css">
				#spellolite_premium_notice {
					color: #377900;
					border: 1px solid #74a739;
					border-radius: 3px;
					background-color: #f0f8e2;
					box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
				}
				#spellolite_premium_notice.notice p {
					margin: 1em 0;
				}
				#spellolite-update-to-pro-wrapper {
					max-width: 962px;
				}
				#spellolite-update-to-pro-wrapper p {
					margin: 2em 0;
				}
				.spellolite-btns-wrapper {
					max-width: 962px;
					text-align: center;
				}
				.spellolite-btn {
					margin: 0 10px;
					padding: 0 45px;
					display: inline-block;
					height: 60px;
					font-size: 14px;
					line-height: 60px;
					color: #fff;
					border-radius: 3px;
					text-decoration: none;
					text-align: center;
					outline: none;
					background: #000;
				}
				.spellolite-btn:hover, .spellolite-btn:focus {
					color: #fff;
				}
				.spellolite-btn:before {
					vertical-align: top;
					margin-right: 8px;
					font-family: 'dashicons';
					font-size: 20px;
				}
				.spellolite-btn.spellolite-btn-view {
					background: #309df4;
					background: linear-gradient(to bottom,#42a5f5 0,#2196f3 100%);
				}
				.spellolite-btn.spellolite-btn-view:before {
					content: "\f504";
				}
				.spellolite-btn.spellolite-btn-view:hover {
					background: #1b7bd8;
					background: linear-gradient(to bottom,#2196f3 0,#1976d2 100%);
				}
				.spellolite-btn.spellolite-btn-to-pro {
					background: #74a739;
					background: linear-gradient(to bottom,#83bd40 0,#6a9e2e 100%);
				}
				.spellolite-btn.spellolite-btn-to-pro:before {
					content: "\f174";
				}
				.spellolite-btn.spellolite-btn-to-pro:hover {
					background: #65972b;
					background: linear-gradient(to bottom,#72a536 0,#588821 100%);
				}
			</style>
			<?php
		}

		public function spellolite_update_to_pro_appearance_menu_item() {
			add_theme_page( 'Update to Pro', 'Update to Pro', 'edit_theme_options', 'spellolite-update-to-pro', array( $this, 'spellolite_update_to_pro_callback' ) );
		}


		public function spellolite_update_to_pro_callback() {
			?>
			<div class="wrap">
				<h2>Update to Pro</h2>
				<div id="spellolite-update-to-pro-wrapper">
					<img src="<?php echo SPELLOLITE_THEME_URI ?>/assets/images/admin/spello-premium.jpg">
					<p><strong>Spello Pro</strong> - Exclusively crafted for educational sites, it will engage visitor’s attention from the first click and make them curious to dig deeper into your site. Give your blog more power with premium tools like extended set of widgets, multiple headers, footers and Live Customizer options. The theme is available under GPL3 license and comes with 24/7 support.</p>
					<div class="spellolite-btns-wrapper">
						<a href="https://www.templatemonster.com/wordpress-themes/62354.html" class="spellolite-btn spellolite-btn-view" target="_blank">Spello Free Demo</a>
						<a href="#" class="spellolite-btn spellolite-btn-to-pro" target="_blank">Spello</a>
					</div>
				</div><!-- mnt-options -->
			</div><!-- wrap -->
			<?php
		}
	}
}


/**
 * Returns instanse of main theme configuration class.
 *
 * @since  1.0.0
 * @return object
 */
function spellolite_theme() {
	return Spellolite_Theme_Setup::get_instance();
}

spellolite_theme();

