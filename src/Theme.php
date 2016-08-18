<?php namespace ParentTheme;

use Timber\Timber;
use Timber\Menu;
use Timber\Site;
/**
 * Class Theme
 * @package Parent
 *
 * Utility class for common theme functions
 */
class Theme {
	public static $init = false;
	public static $uri;
	public static $dir;
	public static $types;
	public static $taxonomies;
	private static $timber;

	static function init() {
		if ( self::$init ) {
			return;
		}
		if ( self::$timber === null ) {
			self::$timber = new Site();
		}
		self::$uri = \get_template_directory_uri();
		self::$dir = dirname(__DIR__);

		\add_action( 'after_setup_theme', array( __CLASS__, 'setup' ));
		\add_filter( 'timber_context', array( __CLASS__, 'timber_context' ));
		\add_filter( 'get_twig', array( __CLASS__, 'twig' ) );

		self::$init = true;
	}

	static function setup() {
		\add_theme_support( 'automatic-feed-links' );
		\add_theme_support( 'title-tag' );
		\add_theme_support( 'post-thumbnails' );
		\add_theme_support( 'menus' );
		\register_nav_menus( array(
			'primary' => 'Primary Menu',
			'footer' => 'Footer Menu'
		) );
		\add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'post-formats', array('link') );
	}

	/**
	 * Convenience function for adding an asset
	 *
	 * TODO either build this out to have strict types or use a package for asset management
	 * @param string $type
	 *  Type of Asset to return. Type should match the Asset's subdirectory in assets/
	 * @param string $path
	 *  Name of the Asset file
	 * @return string
	 *  Full URL to Asset
	 */
	static function asset( $type = '', $path = '' ) {
		$asset = new Asset($type, $path);
		return $asset->url();
	}

	/**
	 * Add or modify context variables
	 *
	 * This will be called every time Timber::get_context is called
	 */
	static function timber_context( $context ) {
		$logo = new Asset('img', 'logo.png');
		$context['site']->logo = $logo->url();
		$context['menu']['primary'] = new Menu('primary');
		$context['menu']['primary']->name = 'primary';
		$context['menu']['footer'] = new Menu('footer');
		$context['menu']['footer']->name = 'footer';
		$context['footer_widgets'] = Timber::get_widgets('footer_widgets');
		return $context;
	}

	/**
	 * Modify twig configuration
	 */
	static function twig( $twig ) {
		return $twig;
	}
}
Theme::init();
