<?php namespace ParentTheme;

/**
 * Class Asset
 * @package Parent
 */
class Asset {
	public $type;
	private $uri;
	private $path;
	private $checksum;

	public function __construct( $type = '', $path = '' ) {
		$this->type = $type;
		$subpath = "/assets/{$type}/{$path}";
		$parent = array(
			'uri' => Theme::$uri,
			'path' => Theme::$dir,
		);
		$child = array(
			'uri' => \get_stylesheet_directory_uri(),
			'path' => \get_stylesheet_directory(),
		);

		foreach ( array($parent, $child) as $theme ) {
			if ( file_exists( $theme['path'] . $subpath ) ) {
				$this->uri = $theme['uri'] . $subpath;
				$this->path = $theme['path'] . $subpath;
			}
		}
	}

	public function url() {
		return isset( $this->uri )? $this->uri : '';
	}

	public function checksum() {
		if ( !isset( $this->checksum )) {
			$this->checksum = md5_file( $this->path );
		}
		return $this->checksum;
	}
}
