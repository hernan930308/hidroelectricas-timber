<?php

use Timber\Integrations\WooCommerce\WooCommerceIntegration;

class WooCommerceTheme
{
    /**
     * Inits all hooks.
     */
    public function init()
    {
        add_filter('timber/integrations', function (array $integrations): array {
            $integrations[] = new WooCommerceIntegration();

            return $integrations;
        });

        // Optional: Disable default WooCommerce image functionality.
        // Timber\Integrations\WooCommerce\WooCommerce::disable_woocommerce_images();

        add_action('after_setup_theme', [$this, 'hooks']);
        add_action('after_setup_theme', [$this, 'theme_support']);
    }

    /**
     * Customize WooCommerce.
     *
     * Add your hooks to customize WooCommerce here.
     *
     * Everything here is hooked to `after_setup_theme`, because child theme functionality runs
     * before parent theme functionality. By hooking it, we make sure it runs after all hooks in
     * the parent theme were registered.
     *
     * @see plugins/woocommerce/includes/wc-template-hooks.php for a list of available actions.
     */
    public function hooks()
    {

        // Force woocommerce.php for WooCommerce pages in block themes (FSE bypasses PHP template hierarchy)
        add_filter('template_include', [$this, 'hidroelectricas_check_woo']);

        // Disable WooCommerce styles
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        // Disable price and data_tabs
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

        add_filter('woocommerce_product_add_to_cart_text', [$this, 'hidroelectricas_change_add_to_cart_text']);
        add_filter('woocommerce_product_single_add_to_cart_text', [$this, 'hidroelectricas_change_add_to_cart_text']);

        // remove SKU, taxonomy and tabas for single product
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

        add_filter('woocommerce_add_to_cart_fragments', [$this, 'cart_link_fragment']);

        add_filter('woocommerce_checkout_fields', [$this, 'hidro_remove_checkout_fields']);

        remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
        
        add_filter('woocommerce_get_privacy_policy_text', [$this, 'hidro_custom_policy_text'], 10, 2);
    }

    /**
     * Theme support.
     */
    public function theme_support()
    {
        /**
         * Add theme support for WooCommerce.
         *
         * @link https://docs.woocommerce.com/document/woocommerce-theme-developer-handbook/#section-5
         */
        add_theme_support('woocommerce');

        // Optional.
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }

    // Change "Add to Cart" text to "Agregar para cotizar"
    public function hidroelectricas_change_add_to_cart_text()
    {
        return __('Agregar', 'hidroelectricas');
    }

    public function hidroelectricas_check_woo($template)
    {
        if (function_exists('is_woocommerce') && is_woocommerce()) {
            return get_template_directory() . '/woocommerce.php';
        }
        return $template;
    }

    /**
     * Cart Fragments.
     *
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     * @return array            Fragments to refresh via AJAX.
     */
    function cart_link_fragment($fragments)
    {
        $fragments['a.cart-mini-contents'] = Timber::compile(
            'woocommerce/cart/fragment-link.twig',
            ['cart' => WC()->cart]
        );

        return $fragments;
    }

    public function hidro_remove_checkout_fields($fields)
    {
        $fields_to_remove = [
            'billing_country',
            'billing_address_1',
            'billing_address_2',
            'billing_postcode',
            'billing_city',
            'billing_company',
            'billing_state',
        ];

        foreach ($fields_to_remove as $field) {
            unset($fields['billing'][$field]);
        }

        $fields['billing']['billing_phone']['required'] = true;

        return $fields;
    }

    public function hidro_custom_policy_text(string $text, string $type): string
    {
        if ($type === 'checkout') {
            $url = get_permalink(get_page_by_path('politica-de-tratamiento-de-datos-personales'));

            return 'Todos tus datos serán procesados de acuerdo a nuestra <a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">Política de tratamiento de datos personales</a>.';
        }

        return $text;
    }
}
