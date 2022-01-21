<?php
/**
 * Namespace
 */
namespace Wc1c\Admin;

/**
 * Only WordPress
 */
defined('ABSPATH') || exit;

/**
 * Dependencies
 */
use Wc1c\Traits\SingletonTrait;
use Wc1c\Admin\Configurations\Create;
use Wc1c\Admin\Configurations\Update;
use Wc1c\Admin\Configurations\Delete;
use Wc1c\Admin\Configurations\All;

/**
 * Configurations
 *
 * @package Wc1c\Admin
 */
class Configurations
{
	use SingletonTrait;

	/**
	 * @var array Available actions
	 */
	private $actions =
	[
		'all',
		'create',
		'update',
		'delete',
	];

	/**
	 * Current action
	 *
	 * @var string
	 */
	private $current_action = 'all';

	/**
	 * Configurations constructor.
	 */
	public function __construct()
	{
		$actions = apply_filters(WC1C_ADMIN_PREFIX . 'configurations_init_actions', $this->actions);

		$this->set_actions($actions);

		$current_action = $this->init_current_action();

		switch($current_action)
		{
			case 'create':
				Create::instance();
				break;
			case 'update':
				Update::instance();
				break;
			case 'delete':
				Delete::instance();
				break;
			default:
				All::instance();
		}
	}

	/**
	 * Current action
	 *
	 * @return string
	 */
	public function init_current_action()
	{
		$do_action = wc1c()->getVar($_GET['do_action'], 'all');

		if(in_array($do_action, $this->get_actions(), true))
		{
			$this->set_current_action($do_action);
		}

		return $this->get_current_action();
	}

	/**
	 * Get actions
	 *
	 * @return array
	 */
	public function get_actions()
	{
		return apply_filters(WC1C_ADMIN_PREFIX . 'configurations_get_actions', $this->actions);
	}

	/**
	 * Set actions
	 *
	 * @param array $actions
	 */
	public function set_actions($actions)
	{
		// hook
		$actions = apply_filters(WC1C_ADMIN_PREFIX . 'configurations_set_actions', $actions);

		$this->actions = $actions;
	}

	/**
	 * Get current action
	 *
	 * @return string
	 */
	public function get_current_action()
	{
		return apply_filters(WC1C_ADMIN_PREFIX . 'configurations_get_current_action', $this->current_action);
	}

	/**
	 * Set current action
	 *
	 * @param string $current_action
	 */
	public function set_current_action($current_action)
	{
		// hook
		$current_action = apply_filters(WC1C_ADMIN_PREFIX . 'configurations_set_current_action', $current_action);

		$this->current_action = $current_action;
	}
}