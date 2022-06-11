<?php namespace Wc1c;

defined('ABSPATH') || exit;

use Digiom\WordPress\Notices\Interfaces\ManagerInterface;
use Digiom\WordPress\Notices\Manager;
use Wc1c\Admin\Configurations;
use Wc1c\Admin\Extensions;
use Wc1c\Admin\Settings;
use Wc1c\Admin\Tools;
use Wc1c\Traits\SectionsTrait;
use Wc1c\Traits\SingletonTrait;
use Wc1c\Traits\UtilityTrait;

/**
 * Admin
 *
 * @package Wc1c
 */
final class Admin
{
	use SingletonTrait;
	use SectionsTrait;
	use UtilityTrait;

	/**
	 * @var ManagerInterface Admin notices
	 */
	private $notices;

	/**
	 * Admin constructor.
	 */
	public function __construct()
	{
		// hook
		do_action('wc1c_admin_before_loading');

		$this->notices();

		if('yes' === wc1c()->settings('interface')->get('admin_interface', 'yes'))
		{
			Admin\Columns\Init::instance();
		}

		add_action('admin_menu', [$this, 'addMenu'], 30);

		if(wc1c()->context()->isAdmin())
		{
			add_action('init', [$this, 'init'], 10);
			add_action('admin_enqueue_scripts', [$this, 'initStyles']);
			add_action('admin_enqueue_scripts', [$this, 'initScripts']);

			Admin\Helps\Init::instance();
			Admin\Wizards\Init::instance();
		}

		add_filter('plugin_action_links_' . wc1c()->environment()->get('plugin_basename'), [$this, 'linksLeft']);

		// hook
		do_action('wc1c_admin_after_loading');
	}

	/**
	 * Admin notices
	 *
	 * @return ManagerInterface
	 */
	public function notices()
	{
		if(empty($this->notices))
		{
			$args =
			[
				'auto_save' => true,
				'admin_notices' => false,
				'user_admin_notices' => false,
				'network_admin_notices' => false
			];

			$this->notices = new Manager('wc1c_admin_notices', $args);
		}

		return $this->notices;
	}

	/**
	 * Init menu
	 */
	public function addMenu()
	{
		add_submenu_page
		(
			'woocommerce',
			__('Integration with 1C', 'wc1c'),
			__('Integration with 1C', 'wc1c'),
			'manage_woocommerce',
			'wc1c',
			[$this, 'route']
		);
	}

	/**
	 * Initialization
	 */
	public function init()
	{
		// hook
		do_action('wc1c_admin_before_init');

		$default_sections['configurations'] =
		[
			'title' => __('Configurations', 'wc1c'),
			'visible' => true,
			'callback' => [Configurations::class, 'instance']
		];

		$default_sections['tools'] =
		[
			'title' => __('Tools', 'wc1c'),
			'visible' => true,
			'callback' => [Tools::class, 'instance']
		];

		$default_sections['settings'] =
		[
			'title' => __('Settings', 'wc1c'),
			'visible' => true,
			'callback' => [Settings::class, 'instance']
		];

		$default_sections['extensions'] =
		[
			'title' => __('Extensions', 'wc1c'),
			'visible' => true,
			'callback' => [Extensions::class, 'instance']
		];

		$this->initSections($default_sections);
		$this->setCurrentSection('configurations');

		// hook
		do_action('wc1c_admin_after_init');
	}

	/**
	 * Styles
	 */
	public function initStyles()
	{
		wp_enqueue_style('wc1c_admin_main', wc1c()->environment()->get('plugin_directory_url') . 'assets/css/main.min.css');
	}

	/**
	 * Scripts
	 */
	public function initScripts()
	{
		wp_enqueue_script('wc1c_admin_tocbot', wc1c()->environment()->get('plugin_directory_url') . 'assets/js/tocbot/tocbot.min.js');
		wp_enqueue_script('wc1c_admin_main', wc1c()->environment()->get('plugin_directory_url') . 'assets/js/admin.js');
	}

	/**
	 * Route sections
	 */
	public function route()
	{
		$sections = $this->getSections();
		$current_section = $this->initCurrentSection();

		if(!array_key_exists($current_section, $sections) || !isset($sections[$current_section]['callback']))
		{
			add_action('wc1c_admin_show', [$this, 'wrapError']);
		}
		else
		{
			if(false === get_option('wc1c_wizard', false))
			{
				add_action('wc1c_admin_show', [$this, 'wrapHeader'], 3);
			}

			add_action('wc1c_admin_show', [$this, 'wrapSections'], 7);

			$callback = $sections[$current_section]['callback'];

			if(is_callable($callback, false, $callback_name))
			{
				$callback_name();
			}
		}

		wc1c()->views()->getView('wrap.php');
	}

	/**
	 * Error
	 */
	public function wrapError()
	{
		wc1c()->views()->getView('error.php');
	}

	/**
	 * Header
	 */
	public function wrapHeader()
	{
		$args['url_create'] = $this->utilityAdminConfigurationsGetUrl('create');

		wc1c()->views()->getView('header.php', $args);
	}

	/**
	 * Sections
	 */
	public function wrapSections()
	{
		wc1c()->views()->getView('sections.php');
	}

	/**
	 * Setup left links
	 *
	 * @param $links
	 *
	 * @return array
	 */
	public function linksLeft($links)
	{
		return array_merge(['site' => '<a href="' . admin_url('admin.php?page=wc1c') . '">' . __('Settings', 'wc1c') . '</a>'], $links);
	}

	/**
	 * Connect box
	 *
	 * @param string $text Button text
	 * @param false $status
	 */
	public function connectBox($text, $status = false)
	{
		$class = 'nav-connect rounded-top';
		if($status === false)
		{
			$class .= ' status-0';
			$class .= ' nav-tab';
		}
		else
		{
			$class .= ' status-1';
			$class .= ' nav-tab';
		}

		if(wc1c()->tecodes()->is_valid() && $status)
		{
			$local = wc1c()->tecodes()->get_local_code();
			$local_data = wc1c()->tecodes()->get_local_code_data($local);

			if($local_data['code_date_expires'] === 'never')
			{
				$local_data['code_date_expires'] = __('never', 'wc1c');
				$text .= ' (' . __('no deadline', 'wc1c') . ')';
			}
			else
			{
				$local_data['code_date_expires'] = date_i18n(get_option('date_format'), $local_data['code_date_expires']);
				$text .= ' (' . __('to:', 'wc1c') . ' ' . $local_data['code_date_expires'] . ')';
			}

			$class .= ' status-3';
		}
		elseif($status)
		{
			$text .= ' (' . __('no support', 'wc1c') . ')';
			$class .= ' status-2';
		}

		echo '<a href="' . admin_url('admin.php?page=wc1c&section=settings&do_settings=connection') . '" class="' . $class . '"> ' . $text . ' </a>';
	}
}