<?php

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site
{
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
		add_action('init', [$this, 'register_acf_blocks']);
		// add styles to admin wordpress
		add_action('admin_init', [$this, 'hidro_editor_styles'], 1000);

		add_filter('timber/context', array($this, 'add_to_context'));

		parent::__construct();
	}

	/**
	 * This enqueues theme styles.
	 */
	public function enqueue_styles()
	{
		$main_stylesheet = '/dist/styles/app.css';
		$main_scripsheet = '/dist/js/app.js';
		$swiper_style    = '/dist/js/app.css';

		wp_enqueue_style(
			'app-css',
			get_template_directory_uri() . $main_stylesheet,
			[],
			filemtime(get_template_directory() . $main_stylesheet)
		);

		wp_enqueue_style(
			'swiper-css',
			get_template_directory_uri() . $swiper_style,
			[],
			filemtime(get_template_directory() . $swiper_style)
		);

		wp_enqueue_script(
			'app-js',
			get_template_directory_uri() . $main_scripsheet,
			[],
			filemtime(get_template_directory() . $main_scripsheet)
		);

		wp_enqueue_script('font-awesome', "https://kit.fontawesome.com/8c58cb6971.js");
	}

	public function register_acf_blocks()
	{
		foreach ($blocks = new DirectoryIterator(get_template_directory() . '/blocks') as $item) {
			// Check if block.json file exists in each subfolder.
			if (
				$item->isDir() && !$item->isDot()
				&& file_exists($item->getPathname() . '/block.json')
			) {
				// Register the block given the directory name within the blocks
				// directory.
				register_block_type($item->getPathname());
			}
		}
	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context)
	{
		$context['product_categories'] = Timber::get_terms([
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'parent'     => 0,
		]);
		$context['menu']      = Timber::get_menu();
		$context['site']      = $this;
		$context['telefono']  = get_field('telefono', 'option');
		$context['direccion'] = get_field('direccion', 'option');
		$context['enlaces']   = get_field('enlaces', 'option');

		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');

		add_theme_support('editor-styles');
	}

	function hidro_editor_styles()
	{
		add_editor_style(get_template_directory_uri() .  '/dist/styles/app.css');
	}

}
