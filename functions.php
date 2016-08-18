<?php

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once __DIR__ . '/vendor/autoload.php';
}
use ParentTheme\Theme;
use Timber\Timber;

Theme::init();

$template_locations = array('twigs', 'twigs/templates', 'twigs/components', 'twigs/widgets');
if ( is_array( Timber::$dirname ) ) {
	Timber::$dirname = array_merge( Timber::$dirname, $template_locations );
} elseif ( !empty( Timber::$dirname ) ) {
	Timber::$dirname = array_unshift( $template_locations, Timber::$dirname );
} else {
	Timber::$dirname = $template_locations;
}

/*
 * Add some details about our pages to body class
 */
function parent_theme_body_classes( $classes ) {
	global $post;
	if ( !empty( $post ) ) {
		$classes[] = $post->post_type . '-' . str_replace( '_', '-', $post->post_name );
	}
	return $classes;
}
add_filter( 'body_class', 'parent_theme_body_classes' );

function parent_theme_widgets_init() {
	register_sidebar(array(
		'name' => 'Footer Widgets',
		'id'            => 'footer_widgets',
		'before_widget' => '<div class="footer__widget">',
		'after_widget'  => '</div>',
	));
}
add_action( 'widgets_init', 'parent_theme_widgets_init' );

// Execute shortcodes within widgets
\add_filter( 'widget_text', 'do_shortcode' );

