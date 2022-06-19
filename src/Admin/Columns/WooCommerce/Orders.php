<?php namespace Wc1c\Admin\Columns\WooCommerce;

defined('ABSPATH') || exit;

use Wc1c\Traits\SingletonTrait;

/**
 * Orders
 *
 * @package Wc1c\Admin
 */
final class Orders
{
	use SingletonTrait;

	/**
	 * Orders constructor.
	 */
	public function __construct()
	{
		add_filter('manage_edit-shop_order_columns',  [$this, 'manage_edit_order_columns']);
		add_action('manage_shop_order_posts_custom_column', [$this, 'manage_order_posts_custom_column'], 10, 2);
	}

	/**
	 * Adding a column to the list of orders for displaying 1C information
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function manage_edit_order_columns($columns)
	{
		$columns_after =
		[
			'wc1c' => __('1C information', 'wc1c'),
		];

		return array_merge($columns, $columns_after);
	}

	/**
	 * Information from 1C in orders list
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function manage_order_posts_custom_column($column, $post_id)
	{
		if('wc1c' === $column)
		{
			$content = '';

			if(has_filter('wc1c_admin_interface_orders_lists_column'))
			{
				$content = apply_filters('wc1c_admin_interface_orders_lists_column', $content, $post_id);
			}
			else
			{
				$schema_id = get_post_meta($post_id, '_wc1c_schema_id', true);
				$config_id = get_post_meta($post_id, '_wc1c_configuration_id', true);

				if($schema_id)
				{
					$content .= '<span class="na">' . __('Schema ID: ', 'wc1c') . $schema_id . '</span>';
				}

				if($config_id)
				{
					$content .= '<br/><span class="na">' . __('Configuration ID: ', 'wc1c')  . $config_id . '</span>';
				}
			}

			if('' === $content)
			{
				$content .= '<span class="na">' . __('Not found', 'wc1c') . '</span>';
			}

			echo $content;
		}
	}
}