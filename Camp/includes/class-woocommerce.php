<?php

/**
 * @Woocommerce Customization
 * return {}
 */
if (!class_exists('doctreat_woocommerace')) {

    class doctreat_woocommerace {

        function __construct() {
            add_action('woocommerce_process_product_meta', array(&$this, 'doctreat_save_package_meta'));
			add_action( 'doctreat_woocommerce_add_to_cart_button', array(&$this,'doctreat_woocommerce_add_to_cart_button'), 10 );
			add_action( 'woocommerce_checkout_fields', array( &$this, 'doctreat_custom_checkout_update_customer' ), 10); 
        }
		
		
		/**
		 * @remove packages from shop
		 * @return {}
		 */
		function doctreat_pre_get_product_query( $q ) {
			$meta_query = $q->get( 'meta_query' );
			
			$meta_query['relation'] = 'AND';
			$meta_query[] = array(
				   'key' 			=> 'package_type',
				   'value' 			=> array('doctors','trail_doctors'),
				   'compare' 		=> 'NOT IN'
			);
			
			$meta_query[] = array(
				'key' 			=> '_doctreat_booking',
				'compare' 		=> 'NOT EXISTS',
			);
			
			$q->set( 'meta_query', $meta_query );
		}

		/**
		 * @Checkout First and last name 
		 * @return {}
		 */
		public function doctreat_custom_checkout_update_customer( $fields ){
			$user = wp_get_current_user();
			$first_name = $user ? $user->user_firstname : '';
			$last_name = $user ? $user->user_lastname : '';
			$fields['billing']['billing_first_name']['default'] = $first_name;
			$fields['billing']['billing_last_name']['default']  = $last_name;
			return $fields;
		}

		/**
		 * @Add to cart button
		 * @return {}
		 */
		public function doctreat_woocommerce_add_to_cart_button(){
			global $product;
			echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s ajax_add_to_cart  dc-btnaddtocart"><i class="lnr lnr-cart"></i><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></a>',
					esc_url( $product->add_to_cart_url() ),
					esc_html( $product->get_id() ),
					esc_html( $product->get_sku() ),
					esc_html( isset( $quantity ) ? $quantity : 1 ),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					esc_html( $product->get_type() ),
					esc_html( $product->add_to_cart_text() )
				),
			$product );
		}

        /**
         * @Package Meta save
         * return {}
         */
        public function doctreat_save_package_meta($post_id) {
			update_post_meta($post_id, 'package_type', sanitize_text_field($_POST['package_type']));
			$pakeges_features = doctreat_get_pakages_features();
			if ( !empty ( $pakeges_features )) {
				foreach( $pakeges_features as $key => $vals ) {
					update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
				}
			}        
		}

    }

    new doctreat_woocommerace();
}