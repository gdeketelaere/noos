<?php
/**
 * Get Earnigs Status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'doctreat_get_earning_status_list' ) ) {
	function doctreat_get_earning_status_list(){
		$list	= array(
			'pending' 	=> esc_html__('Pending','doctreat'),
			'completed' => esc_html__('Completed','doctreat'),
			'cancelled' => esc_html__('Cancelled','doctreat'),
			'processed' => esc_html__('Processed','doctreat')
		);
		
		return $list;
	}
}

/**
 * Upload temp files to WordPress media
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_temp_upload_to_media')) {
    function doctreat_temp_upload_to_media($image_url, $post_id) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}
		
        $json   =  array();
        $upload_dir = wp_upload_dir();
		$folderRalativePath = $upload_dir['baseurl']."/doctreat-temp";
		$folderAbsolutePath = $upload_dir['basedir']."/doctreat-temp";

		$image_data 	= $wp_filesystem->get_contents( $image_url );
        $filename 		= basename($image_url);
		
        if (wp_mkdir_p($upload_dir['path'])){
			 $file = $upload_dir['path'] . '/' . $filename;
		}  else {
            $file = $upload_dir['basedir'] . '/' . $filename;
		}

		$wp_filesystem->put_contents( $file, $image_data, 0755);
			
        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' 	=> $wp_filetype['type'],
            'post_title' 		=> sanitize_file_name($filename),
            'post_content' 		=> '',
            'post_status' 		=> 'inherit'
        );
        
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        
        $json['attachment_id']  = $attach_id;
        $json['url']            = $upload_dir['url'] . '/' . basename( $filename );
		$target_path = $folderAbsolutePath . "/" . $filename;
        unlink($target_path); //delete file after upload
        return $json;
    }
}

/**
 * Prepare social sharing links for job
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists( 'doctreat_get_term_name') ){
    function doctreat_get_term_name($term_id = '', $taxonomy = ''){
        if( !empty( $term_id ) && !empty( $taxonomy ) ){
            $term = get_term_by( 'id', $term_id, $taxonomy);  
            if( !empty( $term ) ){
                return $term->name;
            }
        }
        return '';
    }
}

/**
 * Get waiting time
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'doctreat_get_waiting_time' ) ) {
	function doctreat_get_waiting_time(){
		$list	= array(
			'1' 	=> esc_html__('0 < 15 min','doctreat'),
			'2' 	=> esc_html__('15 to 30 min','doctreat'),
			'3' 	=> esc_html__('30 to 1 hr','doctreat'),
			'4' 	=> esc_html__('More then hr','doctreat')
		);
		
		return $list;
	}
}

/**
 * Get user review meta data
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_review_data')) {

    function doctreat_get_review_data($user_id, $review_key = '', $type = '') {
        $review_meta = get_user_meta($user_id, 'review_data', true);
        if ($type === 'value') {
            return !empty($review_meta[$review_key]) ? $review_meta[$review_key] : '';
        }
        return !empty($review_meta) ? $review_meta : array();
    }

}

/**
 * Get Average Ratings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_everage_rating')) {

    function doctreat_get_everage_rating($user_id = '') {
		$data = array();
        $meta_query_args = array('relation' => 'AND');
        $meta_query_args[] = array(
            'key' 		=> 'user_to',
            'value' 	=> $user_id,
            'compare' 	=> '=',
            'type' 		=> 'NUMERIC'
        );

        $args = array('posts_per_page' => -1,
            'post_type' 		=> 'reviews',
            'post_status' 		=> 'publish',
            'order' 			=> 'ASC',
        );

        $args['meta_query'] = $meta_query_args;

        $average_rating = 0;
        $total_rating   = 0;
		
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) : $query->the_post();
                global $post;
                $user_rating = get_post_meta($post->ID, 'user_rating', true);
			
                $average_rating = $average_rating + $user_rating;
                $total_rating++;

            endwhile;
            wp_reset_postdata();
        }

        $data['wt_average_rating'] 			= 0;
        $data['wt_total_rating'] 			= 0;
        $data['wt_total_percentage'] 		= 0;
		
        if (isset($average_rating) && $average_rating > 0) {
            $data['wt_average_rating'] 			= $average_rating / $total_rating;
            $data['wt_total_rating'] 			= $total_rating;
            $data['wt_total_percentage'] 		= ( $average_rating / $total_rating) * 5;
        }

        return $data;
    }

}

/**
 * Count items in array
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_count_items')) {
    function doctreat_count_items($items) {
        if( is_array($items) ){
			return count($items);
		} else{
			return 0;
		}
    }
}

/**
 * Get doctor Ratings Headings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_doctor_ratings' ) ) {
	function doctreat_doctor_ratings(){
		global $theme_settings;
		if ( $theme_settings ) {
			$ratings_headings	= !empty( $theme_settings['feedback_questions'] ) ? $theme_settings['feedback_questions'] : array();
			
			if( !empty( $ratings_headings ) ){
				$ratings_headings = array_filter($ratings_headings);
				$ratings_headings = array_combine(array_map('sanitize_title', $ratings_headings), $ratings_headings);
				return $ratings_headings;
			} else{
				return array();
			}
			
		} else {
			return array();
		}
	}
}

/**
 * Get search page uri
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_search_page_uri' ) ) {
    function doctreat_get_search_page_uri( $type = '' ) {
		global $theme_settings;
		$tpl_dashboard 	= !empty( $theme_settings['dashboard_tpl'] ) ? get_permalink( (int) $theme_settings['dashboard_tpl']) : '';
		$tpl_search 	= !empty( $theme_settings['search_result_page'] ) ? get_permalink( (int) $theme_settings['search_result_page']) : '';
               
        $search_page = '';
		
        if ( !empty( $type ) && ( $type === 'doctors' || $type === 'hospitals' ) ) {
            $search_page = esc_url( $tpl_search );
        }  elseif ( !empty( $type ) && $type === 'dashboard' ) {
            $search_page = esc_url( $tpl_dashboard ) ;           
        }
        
        return $search_page;
    }
}

/**
 * Match Cart items
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_matched_cart_items')) {

    function doctreat_matched_cart_items($product_id) {
        // Initialise the count
        $count = 0;

        if (!WC()->cart->is_empty()) {
            foreach (WC()->cart->get_cart() as $cart_item):
                $items_id = $cart_item['product_id'];

                // for a unique product ID (integer or string value)
                if ($product_id == $items_id) {
                    $count++; // incrementing the counted items
                }
            endforeach;
            // returning counted items 
            return $count;
        }

        return $count;
    }

}

/**
 * Get package type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_package_type')) {

	 function doctreat_get_package_type($key, $value) {
		global $wpdb;
		$meta_query_args = array();
		$args = array(
			'post_type' 			=> 'product',
			'posts_per_page' 		=> 1,
			'order' 				=> 'DESC',
			'orderby' 				=> 'ID',
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1
		);
		 
		$meta_query_args[] = array(
			'key' 			=> $key,
			'value' 		=> $value,
			'compare' 		=> '=',
		);	
		 
		$query_relation 		= array('relation' => 'AND',);
		$meta_query_args 		= array_merge($query_relation, $meta_query_args);
		$args['meta_query'] 	= $meta_query_args;
		
		$trial_product = get_posts($args);
		
		if (!empty($trial_product)) {
            return (int) $trial_product[0]->ID;
        } else{
			 return 0;
		}
	}
	
}

/**
 * Get subscription metadata
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_subscription_metadata')) {

    function doctreat_get_subscription_metadata($key = '', $user_id) {
        $dc_subscription 	= get_user_meta($user_id, 'dc_subscription', true);
		$current_date 		= current_time('mysql');
        if ( is_array( $dc_subscription ) && !empty( $dc_subscription[$key] ) ) {			
			if (!empty($dc_subscription['subscription_package_string']) && $dc_subscription['subscription_package_string'] > strtotime($current_date)) {
				return $dc_subscription[$key];
			} else{
				return '';
			}
        } else {
			return '';	
		}
    }

}

/**
 * Update Package vaule
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'doctreat_update_package_attribute_value' ) ) {

	function doctreat_update_package_attribute_value( $user_id, $attribute,$min_val=1) {
		$dc_subscription 	= get_user_meta($user_id, 'dc_subscription', true);
		$attribut_val		= !empty($dc_subscription) ? intval($dc_subscription[$attribute]) : 0;
		if(!empty($attribute) && !empty($dc_subscription)){
			$dc_subscription[$attribute]	= $attribut_val - $min_val;
			update_user_meta( $user_id, 'dc_subscription',$dc_subscription );
		}
	}
}

/**
 * Get Packages Type 
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'doctreat_packages_types' ) ) {

	function doctreat_packages_types( $post = '') {
		if ( !empty( $post ) ) {
			$package_type	= get_post_meta( $post->ID , 'package_type', true);
		}
		
		$packages						= array();
		$packages[0]					= esc_html__('Package Type', 'doctreat');
		$packages['doctors']			= esc_html__('Default', 'doctreat');
		$trail_doctors_package_id		= doctreat_get_package_type( 'package_type','trail_doctors');
		
		if( empty($trail_doctors_package_id ) || ($trail_doctors_package_id == $post->ID) ) {
			$packages['trail_doctors']		= esc_html__('Trial', 'doctreat');
		}
		
		return $packages;
	}
}

/**
 * Get Pakages Featured attribute
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_pakages_features_attributes')) {

    function doctreat_get_pakages_features_attributes( $key ='' , $attr = 'title' ) {
		$features		= doctreat_get_pakages_features();
		if( !empty ( $key ) && !empty ( $attr )) {
			$attribute	= $features[$key][$attr];
		} else {
			$attribute ='';
		}
		
		return $attribute;
	}
}

/**
 * Get user profile ID
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_linked_profile_id')) {

    function doctreat_get_linked_profile_id($user_identity, $type='users') {
		if( $type === 'post') {
			$linked_profile   	= get_post_meta($user_identity, '_linked_profile', true);
		}else {
			$linked_profile   	= get_user_meta($user_identity, '_linked_profile', true);
		}
		
        $linked_profile	= !empty( $linked_profile ) ? $linked_profile : '';
		
        return intval( $linked_profile );
    }
}

/**
 * Filter dashboard menu
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_dashboard_menu' ) ) {
	function doctreat_get_dashboard_menu() {
		global $current_user;
		
		$menu_settings = get_option( 'dc_dashboard_menu_settings' );
		
		$list	= array(		
			'insights'	=> array(
				'title' => esc_html__('Dashboard','doctreat'),
				'type'	=> 'none'
			),
			'chat'	=> array(
				'title' => esc_html__('Inbox','doctreat'),
				'type'	=> 'none'
			),
			'profile-settings'	=> array(
				'title' => esc_html__('Edit my profile','doctreat'),
				'type'	=> 'none'
			),
			'camp-locations'	=> array(
				'title' => esc_html__('My Customs Locations','doctreat'),
				'type'	=> 'doctors'
			),
			
			'specialities'	=> array(
				'title' => esc_html__('Specialities &amp; Services','doctreat'),
				'type'	=> 'none'
			),
			'account-settings'	=> array(
				'title' => esc_html__('Account Settings','doctreat'),
				'type'	=> 'none'
			),
			'appointments-listing'	=> array(
				'title' => esc_html__('Appointment Listing','doctreat'),
				'type'	=> 'doctors'
			),
			'appointments-listings'	=> array(
				'title' => esc_html__('Appointment Listing','doctreat'),
				'type'	=> 'regular_users'
			),
			'appointments-settings'	=> array(
				'title' => esc_html__('Appointment Settings','doctreat'),
				'type'	=> 'doctors'
			),
			'manage-article'	=> array(
				'title' => esc_html__('Manage Articles','doctreat'),
				'type'	=> 'doctors'
			),
			'lastposts'	=> array(
				'title' => esc_html__('My last posts','doctreat'),
				'type'	=> 'doctors'
			),
			'payouts-settings'	=> array(
				'title' => esc_html__('Payouts Settings','doctreat'),
				'type'	=> 'doctors'
			),
			'manage-team'	=> array(
				'title' => esc_html__('Manage Team','doctreat'),
				'type'	=> 'hospitals'
			),
			
			'saved'	=> array(
				'title' => esc_html__('My Saved Items','doctreat'),
				'type'	=> 'none'
			),
			'references'	=> array(
				'title' => esc_html__('My Network','doctreat'),
				'type'	=> 'none'
			),
			'packages'	=> array(
				'title' => esc_html__('Packages','doctreat'),
				'type'	=> 'doctors'
			),
			'invoices'	=> array(
				'title' => esc_html__('Invoices','doctreat'),
				'type'	=> 'doctors'
			),
			'invoices-regular-users'	=> array(
				'title' => esc_html__('Invoices','doctreat'),
				'type'	=> 'regular_users'
			),

			'logout'	=> array(
				'title' => esc_html__('Logout','doctreat'),
				'type'	=> 'none'
			)
		);
		
		$payment_type	= doctreat_theme_option('payment_type');
		if( !empty($payment_type) && $payment_type ==='offline' ){
			unset($list['payouts-settings']);
		}

		$final_list	= !empty( $menu_settings ) ? $menu_settings : $list;
		$menu_list 	= apply_filters('doctreat_filter_dashboard_menu',$final_list);
		return $menu_list;
	}
}

/**
 * Get doctor avatar
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'doctreat_get_doctor_avatar' ) ) {
	function doctreat_get_doctor_avatar( $sizes = array(), $user_identity = '' ) {
		extract( shortcode_atts( array(
			"width" => '100',
			"height" => '100',
		), $sizes ) );
		
		global $theme_settings;
		
		$default_avatar = !empty($theme_settings['default_doctor_avatar'])  ? $theme_settings['default_doctor_avatar'] : array();
		
		$thumb_id 		= get_post_thumbnail_id( $user_identity );
		
		if ( !empty( $thumb_id ) ) {
			$thumb_url = wp_get_attachment_image_src( $thumb_id, array( $width, $height ), true );
			if ( $thumb_url[1] == $width and $thumb_url[2] == $height ) {
				return !empty( $thumb_url[0] ) ? $thumb_url[0] : '';
			} else {
				$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
				if (strpos($thumb_url[0],'media/default.png') !== false) {
					return '';
				} else{
					return !empty( $thumb_url[0] ) ? $thumb_url[0] : '';
				}
			}
		} else {
			if ( !empty( $default_avatar['id'] ) ) {
				$thumb_url = wp_get_attachment_image_src( $default_avatar['id'], array( $width, $height ), true );

				if ( $thumb_url[1] == $width and $thumb_url[2] == $height ) {
					return $thumb_url[0];
				} else {
					$thumb_url = wp_get_attachment_image_src( $default_avatar['id'], "full", true );
					if (strpos($thumb_url[0],'media/default.png') !== false) {
						return '';
					} else{
						if ( !empty( $thumb_url[0] ) ) {
							return $thumb_url[0];
						} else {
							return false;
						}
					}
				}
			} else {
				return false;
			}
		}
	}
}

/**
 * User verification check
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'doctreat_get_username' ) ) {
	function doctreat_get_username( $user_id = '' , $linked_profile = '' ){
		
		if( !empty( $linked_profile ) ){
			return get_the_title($linked_profile);
		} 
		
		if ( empty($user_id) ) {
            return esc_html__('unnamed', 'doctreat');
        }
		
        $userdata = get_userdata($user_id);
        $user_role = '';
        if (!empty($userdata->roles[0])) {
            $user_role = $userdata->roles[0];
        }

        if (!empty($user_role) && $user_role === 'doctors' || $user_role === 'hospitals' || $user_role === 'regular_users' ) {
			$linked_profile   	= doctreat_get_linked_profile_id($user_id);
			if( !empty( $linked_profile ) ){
				return doctreat_full_name($linked_profile);
			} else{
				if (!empty($userdata->first_name) && !empty($userdata->last_name)) {
					return $userdata->first_name . ' ' . $userdata->last_name;
				} else if (!empty($userdata->first_name) && empty($userdata->last_name)) {
					return $userdata->first_name;
				} else if (empty($userdata->first_name) && !empty($userdata->last_name)) {
					return $userdata->last_name;
				} else {
					return esc_html__('No Name', 'doctreat');
				}
			}
			
		} else{
			if (!empty($userdata->first_name) && !empty($userdata->last_name)) {
                return $userdata->first_name . ' ' . $userdata->last_name;
            } else if (!empty($userdata->first_name) && empty($userdata->last_name)) {
                return $userdata->first_name;
            } else if (empty($userdata->first_name) && !empty($userdata->last_name)) {
                return $userdata->last_name;
            } else {
                return esc_html__('No Name', 'doctreat');
            }
		}
	}
}

/**
 * Report reasons
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'doctreat_get_report_reasons' ) ) {
	function doctreat_get_report_reasons(){
		$list	= array(
			'fake' 		=> esc_html__('This is the fake', 'doctreat'),
			'bahavior' 	=> esc_html__('Their behavior is inappropriate or abusive', 'doctreat'),
			'Other' 	=> esc_html__('Other', 'doctreat'),
		);
		
		$list	= apply_filters('doctreat_filter_reasons',$list);
		return $list;
	}
}

/**
 * Get user avatar
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'doctreat_get_hospital_avatar' ) ) {
	function doctreat_get_hospital_avatar( $sizes = array(), $user_identity = '' ) {
		global $theme_settings;
		extract( shortcode_atts( array(
			"width" => '100',
			"height" => '100',
		), $sizes ) );

		$default_avatar = !empty( $theme_settings['default_hospital_image'] ) ? $theme_settings['default_hospital_image'] : '';

		$thumb_id = get_post_thumbnail_id( $user_identity );
		
		if ( !empty( $thumb_id ) ) {
			$thumb_url = wp_get_attachment_image_src( $thumb_id, array( $width, $height ), true );
			if ( $thumb_url[1] == $width and $thumb_url[2] == $height ) {
				return !empty( $thumb_url[0] ) ? $thumb_url[0] : '';
			} else {
				$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
				if (strpos($thumb_url[0],'media/default.png') !== false) {
					return '';
				} else{
					return !empty( $thumb_url[0] ) ? $thumb_url[0] : '';
				}
			}
		} else {
			if ( !empty( $default_avatar['attachment_id'] ) ) {
				$thumb_url = wp_get_attachment_image_src( $default_avatar['attachment_id'], array( $width, $height ), true );

				if ( $thumb_url[1] == $width and $thumb_url[2] == $height ) {
					return $thumb_url[0];
				} else {
					$thumb_url = wp_get_attachment_image_src( $default_avatar['attachment_id'], "full", true );
					if (strpos($thumb_url[0],'media/default.png') !== false) {
						return '';
					} else{
						if ( !empty( $thumb_url[0] ) ) {
							return $thumb_url[0];
						} else {
							return false;
						}
					}
				}
			} else {
				return false;
			}
		}
	}
}

/**
 * Add http from URL
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_add_http')) {

    function doctreat_add_http($url) {
        $protolcol = is_ssl() ? "https" : "http";
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = $protolcol . ':' . $url;
        }
        return $url;
    }

}

/**
 * Get page id by slug
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_page_by_slug')) {

    function doctreat_get_page_by_slug($slug = '', $post_type = 'post', $return = 'id') {
        $args = array(
            'name' => $slug,
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => 1
        );

        $post_data = get_posts($args);

        if (!empty($post_data)) {
            return (int) $post_data[0]->ID;
        }

        return false;
    }

}

/**
 * Add http from URL
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_matched_cart_items')) {

    function doctreat_matched_cart_items($product_id) {
        // Initialise the count
        $count = 0;

        if (!WC()->cart->is_empty()) {
            foreach (WC()->cart->get_cart() as $cart_item):
                $items_id = $cart_item['product_id'];

                // for a unique product ID (integer or string value)
                if ($product_id == $items_id) {
                    $count++; // incrementing the counted items
                }
            endforeach;
            // returning counted items 
            return $count;
        }

        return $count;
    }

}

/**
 * Get the terms
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_taxonomy_options')) {

    function doctreat_get_taxonomy_options($current = '', $taxonomyName = '', $parent = '') {
		
		if( taxonomy_exists($taxonomyName) ){
			//This gets top layer terms only.  This is done by setting parent to 0.  
			$parent_terms = get_terms($taxonomyName, array('parent' => 0, 'orderby' => 'slug', 'hide_empty' => false));


			$options = '';
			if (!empty($parent_terms)) {
				foreach ($parent_terms as $pterm) {
					$selected = '';
					if (!empty($current) && is_array($current) && in_array($pterm->slug, $current)) {
						$selected = 'selected';
					} else if (!empty($current) && !is_array($current) && $pterm->slug == $current) {
						$selected = 'selected';
					}

					$options .= '<option ' . $selected . ' value="' . $pterm->slug . '">' . $pterm->name . '</option>';
				}
			}

			echo do_shortcode($options);
		}else{
			echo '';
		}
    }

}

/**
 * Get taxonomy array
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_taxonomy_array')) {

    function doctreat_get_taxonomy_array($taxonomyName = '',$parent='') {
		
		if( taxonomy_exists($taxonomyName) ){
			if(!empty( $parent )){
				return get_terms($taxonomyName, array('parent' => $parent, 'orderby' => 'slug', 'hide_empty' => false));
			} else{
				return get_terms($taxonomyName, array('orderby' => 'slug', 'hide_empty' => false));
			}
			
		} else{
			return array();
		}  
	}
}

/**
 * List user specilities and services
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

if( !function_exists(  'doctreat_list_services_with_specility' ) ) {
	
	function doctreat_list_services_with_specility( $profile_id = ''){
		$specialities_array	= array();
		
		if( !empty($profile_id) ){
			$am_specialities 		= doctreat_get_post_meta( $profile_id,'am_specialities');
			
			if( !empty( $am_specialities ) ) {
				foreach( $am_specialities as $key => $values ){ 
					$specialities_title	= doctreat_get_term_name($key ,'specialities');

					$logo 			= get_term_meta( $key, 'logo', true );
					$current_logo	= !empty( $logo['url'] ) ? esc_url($logo['url']) : '';
					$specialities_array[$key]['id']			= $key;
					$specialities_array[$key]['title']		= $specialities_title;
					$specialities_array[$key]['logo']		= $current_logo;

					$services_array		= array();
					if( !empty( $values ) ) {
						$service_index	= 0;
						foreach( $values as $index => $val ) {
							$service_index	++;
							$service_title							= doctreat_get_term_name($index ,'services');
							$services_array[$service_index]['title']		= $service_title;
							$services_array[$service_index]['service_id']	= $index;
							$services_array[$service_index]['price']		= !empty($val['price']) ? $val['price'] : '';
							$services_array[$service_index]['description']	= !empty($val['description']) ? $val['description'] : '';
						}
					}
					$specialities_array[$key]['services']	= array_values($services_array);
				}
			}
		}
		return $specialities_array;
	}
}


/**
 * Get the list hospital
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_list_hospital')) {
    function doctreat_get_list_hospital( $type = '', $author = '') {
        $args = array(
				'posts_per_page' 	=> '-1',
				'post_type' 		=> $type,
				'post_status' 		=> 'publish',
				'suppress_filters' 	=> false,
				'author'			=> $author
			);
		
        $options = '';
        $cust_query = get_posts($args);

        if (!empty($cust_query)) {
            foreach ($cust_query as $key => $dir) {
				$hospital_id	= get_post_meta( $dir->ID, 'hospital_id',true);
                $options .= '<option value="' . $dir->ID . '">' . get_the_title($hospital_id) . '</option>';
            }
        }

        echo do_shortcode($options);
    }

}

/**
 * Get time slots for booking app
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_time_slots_slots')) {
    function doctreat_get_time_slots_slots( $post_id = '', $day = '',$date ='') {
		$time_format 	= get_option('time_format');
		$slots			= get_post_meta($post_id,'am_slots_data',true);
		$slot_list		= array();
		if( !empty( $slots ) ){
			$slot_array	= $slots[$day]['slots'];
			
			if( !empty( $slot_array ) ) {
				$slots_array	= array();
				foreach( $slot_array as $key	=> $val ) {
					$post_meta		= array(
											'_appointment_date'		=> $date,
											'_booking_slot' 		=> $key ,
											'_booking_hospitals' 	=> $post_id ,
										   );
					$count_posts	= doctreat_get_total_posts_by_multiple_meta('booking',array('publish','pending'),$post_meta);
					
					$spaces			= $val['spaces'];
					if( $count_posts >= $spaces ) { 
						$disabled	= 'disabled'; 
						$spaces		= 0;
					} else { 
						$spaces		= $spaces - $count_posts;
						$disabled 	= ''; 
					}
					$slot_key_val 	= explode('-', $key);
					$slots_array['start_time']		= !empty($slot_key_val[0]) ? date($time_format, strtotime('2016-01-01' . $slot_key_val[0])) : '';
					$slots_array['end_time']		= !empty($slot_key_val[1]) ? date($time_format, strtotime('2016-01-01' . $slot_key_val[1])) : '';
					$slots_array['key']				= $key;
					$slots_array['status']			= $disabled;
					$slots_array['spaces']			= $spaces;
					$slot_list[]					= $slots_array;	
				}
			}
		} 	

        return $slot_list;
    }

}

/**
 * Get time slots for booking
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_time_slots_spaces')) {
    function doctreat_get_time_slots_spaces( $post_id = '', $day = '',$date ='') {
		$time_format 	= get_option('time_format');
		$slots			= get_post_meta($post_id,'am_slots_data',true);
		$slots_html		= '';
		if( !empty( $slots ) ){
			$slot_array	= $slots[$day]['slots'];
			if( !empty( $slot_array ) ) {
				foreach( $slot_array as $key	=> $val ) {
					$post_meta		= array(
											'_appointment_date'		=> $date,
											'_booking_slot' 		=> $key ,
											'_booking_hospitals' 	=> $post_id ,
										   );
					$count_posts	= doctreat_get_total_posts_by_multiple_meta('booking',array('publish','pending'),$post_meta);
					
					$spaces			= $val['spaces'];
					if( $count_posts >= $spaces ) { 
						$disabled	= 'disabled'; 
						$spaces		= 0;
					} else { 
						$spaces		= $spaces - $count_posts;
						$disabled 	= ''; 
					}
					$slot_key_val 	= explode('-', $key);
					$slots_html	.= '<span class="dc-radio next-step">';
						$slots_html	.= '<input type="radio" id="firstavailableslot'.$key.'" name="booking_slot" value="'.$key.'" '.$disabled.'>';
						$slots_html	.= '<label for="firstavailableslot'.$key.'"><span>'.date($time_format, strtotime('2016-01-01' . $slot_key_val[0])).'</span><em>Spaces:'.$spaces.'</em></label>';
					$slots_html	.= '</span>';
				}
			}
		} 	

        return do_shortcode($slots_html);
    }

}

/**
 * Get total post by multiple meta
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_total_posts_by_multiple_meta')) {

    function doctreat_get_total_posts_by_multiple_meta($type='booking',$status,$metas='',$post_author='' ) {
		if( !empty( $metas ) ) {
			foreach( $metas as $key => $val ) {
				$meta_query_args[] = array(
					'key' 			=> $key,
					'value' 		=> $val,
					'compare' 		=> '='
				);
			}
		}
		
		$query_args = array(
			'posts_per_page'      => -1,
			'post_type' 	      => $type,
			'post_status'	 	  => $status,
			'ignore_sticky_posts' => 1
		);
		
		if(!empty ( $post_author ) ){
			$query_args['author']	= $post_author;
		}
		
		if (!empty($meta_query_args)) {
			$query_relation = array('relation' => 'AND',);
			$meta_query_args = array_merge($query_relation, $meta_query_args);
			$query_args['meta_query'] = $meta_query_args;
		}
		
        $query = new WP_Query($query_args);
        return $query->post_count;
    }
}

/**
 * Prepare Business Hours Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_prepare_business_hours_settings')) {

    function doctreat_prepare_business_hours_settings() {
        return array(
            'monday' 	=> esc_html__('Monday', 'doctreat'),
            'tuesday' 	=> esc_html__('Tuesday', 'doctreat'),
            'wednesday' => esc_html__('Wednesday', 'doctreat'),
            'thursday' 	=> esc_html__('Thursday', 'doctreat'),
            'friday' 	=> esc_html__('Friday', 'doctreat'),
            'saturday' 	=> esc_html__('Saturday', 'doctreat'),
            'sunday' 	=> esc_html__('Sunday', 'doctreat')
        );
    }

}

/**
 * Get Week Array
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_week_array')) {

    function doctreat_get_week_array() {
        return array(
          	'mon' => esc_html__('Monday', 'doctreat'),
            'tue' => esc_html__('Tuesday', 'doctreat'),
            'wed' => esc_html__('Wednesday', 'doctreat'),
            'thu' => esc_html__('Thursday', 'doctreat'),
            'fri' => esc_html__('Friday', 'doctreat'),
            'sat' => esc_html__('Saturday', 'doctreat'),
            'sun' => esc_html__('Sunday', 'doctreat'),
        );
    }

}

/**
 * Get Week keys translation
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_week_keys_translation')) {

    function doctreat_get_week_keys_translation($key='') {
        $list	= array(
					'mon' => esc_html__('Mon', 'doctreat'),
					'tue' => esc_html__('Tue', 'doctreat'),
					'wed' => esc_html__('Wed', 'doctreat'),
					'thu' => esc_html__('Thu', 'doctreat'),
					'fri' => esc_html__('Fri', 'doctreat'),
					'sat' => esc_html__('Sat', 'doctreat'),
					'sun' => esc_html__('Sun', 'doctreat'),
				);
		
		return !empty($list[$key]) ? $list[$key] : '';
    }

}
/**
 * Time formate
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_date_24midnight')) {

    function doctreat_date_24midnight($format, $ts) {
        if (date("Hi", $ts) == "0000") {
            $replace = array(
                "H" => "24",
                "G" => "24",
                "i" => "00",
            );

            return date(
                    str_replace(
                            array_keys($replace), $replace, $format
                    ), $ts - 60 // take a full minute off, not just 1 second
            );
        } else {
            return date($format, $ts);
        }
    }

}

/**
 * Get distance between two points
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_GetDistanceBetweenPoints')) {
	function doctreat_GetDistanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
		$unit	= doctreat_get_distance_scale();
		
		$theta = $longitude1 - $longitude2;
		$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
		$distance = acos($distance);
		$distance = rad2deg($distance);
		$distance = $distance * 60 * 1.1515; switch($unit) {
		  case 'Mi': break;
		  case 'Km' : $distance = $distance * 1.60934;
		}
		return (round($distance,2)).'&nbsp;'. strtolower( $unit );
	}
}

/**
 * Get distance between two points
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_distance_scale')) {
	function doctreat_get_distance_scale() {
		global $theme_settings;
		$dir_distance_type = !empty( $theme_settings['dir_distance_type'] ) ? $theme_settings['dir_distance_type']: 'km';
		$unit = !empty( $dir_distance_type ) && $dir_distance_type === 'mi' ? 'Mi' : 'Km';
		
		return $unit;
	}
}

/**
 * Get min/max lat/long
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_min_max_lat_lon')) {
	function doctreat_get_min_max_lat_lon(){
		global $theme_settings;
		$radius		= !empty( $_GET['geo_distance'] ) ? esc_html( $_GET['geo_distance'] ) : 10;
		$dir_distance_type = !empty( $theme_settings['dir_distance_type'] ) ? $theme_settings['dir_distance_type']: 'km';
		
		if ($dir_distance_type === 'km') {
			$radius = $radius * 0.621371;
		}

		$Latitude	= !empty( $_GET['lat'] ) ? esc_html( $_GET['lat'] ) : '';
		$Longitude	= !empty( $_GET['long'] ) ?  esc_html( $_GET['long'] ) : '';

		$minLat = $maxLat = $minLong = $maxLong = 0;
		if( !empty( $Latitude ) && !empty( $Longitude ) ){
			$zcdRadius = new RadiusCheck($Latitude, $Longitude, $radius);
			$minLat = $zcdRadius->MinLatitude();
			$maxLat = $zcdRadius->MaxLatitude();
			$minLong = $zcdRadius->MinLongitude();
			$maxLong = $zcdRadius->MaxLongitude();
		}
		
		$data	= array(
			'default_lat'   => $Latitude,
			'default_long'  => $Longitude,
			'minLat'  => $minLat,
			'maxLat'  => $maxLat,
			'minLong' => $minLong,
			'maxLong' => $maxLong,
		);
		
		return $data;
	}
}

/**
 * Get atitude and longitude for search
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_location_lat_long' ) ) {
	function doctreat_get_location_lat_long() {
		global $theme_settings;
		$protocol 		= is_ssl() ? 'https' : 'http';
		$dir_longitude = !empty( $theme_settings['dir_longitude'] ) ? $theme_settings['dir_longitude']: '-0.1262362';
		$dir_latitude = !empty( $theme_settings['dir_latitude'] ) ? $theme_settings['dir_latitude']: '51.5001524';
		
		$current_latitude	= $dir_latitude;
		$current_longitude	= $dir_longitude;

		if( !empty( $_GET['lat'] ) && !empty( $_GET['long'] ) ){
			$current_latitude	= esc_html( $_GET['lat'] );
			$current_longitude	= esc_html( $_GET['long'] );
		} else{
			
			$args = array(
				'timeout'     => 15,
				'headers' => array('Accept-Encoding' => ''),
				'sslverify' => false
			);
			
			$address	= !empty($_GET['geo']) ?  $_GET['geo'] : '';
			$prepAddr	= str_replace(' ','+',$address);
			
			$url	    = $protocol.'://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false';
			$response   = wp_remote_get( $url, $args );
			$geocode	= wp_remote_retrieve_body($response);

			$output	  = json_decode($geocode);

			if( isset( $output->results ) && !empty( $output->results ) ) {
				$Latitude	 = $output->results[0]->geometry->location->lat;
				$Longitude   = $output->results[0]->geometry->location->lng;
			}
			
			if( !empty( $Latitude ) && !empty( $Longitude ) ){
				$current_latitude	= $Latitude;
				$current_longitude	= $Longitude;
			} else{
				$current_latitude	= $dir_latitude;
				$current_longitude	= $dir_longitude;
			}
		}
		
		$location	= array();
		
		$location['lat']	= $current_latitude;
		$location['long']	= $current_longitude;
		
		return $location;
	}
}

/**
 * Get woocommmerce currency settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_current_currency' ) ) {
	function doctreat_get_current_currency() {
		$currency	= array();
		
		if (class_exists('WooCommerce')) {
			$currency['code']	= get_woocommerce_currency();
			$currency['symbol']	= get_woocommerce_currency_symbol();
		} else{
			$currency['code']	= 'USD';
			$currency['symbol']	= '$';
		}
		
		return $currency;
	}
}

/**
 * Get calendar date format
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_calendar_format' ) ) {
	function doctreat_get_calendar_format() {
		global $theme_settings;
		$calendar_format = !empty( $theme_settings['calendar_locale'] ) ? $theme_settings['calendar_locale']: 'Y-m-d';
		
		return $calendar_format;
	}
}


/**
 * Get term by slug
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_term_by_type')) {

    function doctreat_get_term_by_type($from = 'slug', $value = "", $taxonomy = 'sub_category', $return = 'id') {

        $term = get_term_by($from, $value, $taxonomy);
        if (!empty($term)) {
            if ($from === 'slug' && $return === 'id') {
                return $term->term_id;
            } elseif ($from === 'id' && $return === 'slug') {
                return $term->slug;
            } elseif ($from === 'name' && $return === 'id') {
                return $term->term_id;
            } elseif ($from === 'id' && $return === 'name') {
                return $term->name;
            } elseif ($from === 'name' && $return === 'slug') {
                return $term->slug;
            } elseif ($from === 'slug' && $return === 'name') {
                return $term->name;
            }elseif ($from === 'id' && $return === 'all') {
                return $term;
            } else {
                return $term->term_id;
            }
        }

        return false;
    }
}

/**
 * Get total post by user id
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_total_posts_by_user')) {

    function doctreat_get_total_posts_by_user($user_id = '',$type='sp_ads',$status='publish') {
        if (empty($user_id)) {
            return 0;
        }

        $args = array(
			'posts_per_page'	=> '-1',
            'post_type' 		=> $type,
            'post_status' 		=> $status,
            'author' 			=> $user_id,
            'suppress_filters' 	=> false
        );
        $query = new WP_Query($args);
        return $query->post_count;
    }
}

/**
 * Get total post by met key and value
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_total_posts_by_meta')) {

    function doctreat_get_total_posts_by_meta($type='doctors',$meta_key='',$meta_val,$status,$post_author ) {
		$meta_query_args	= array();
		
        //default
		$meta_query_args[] = array(
				'key' 			=> $meta_key,
				'value' 		=> $meta_val,
				'compare' 		=> '='
			); 

		$query_args = array(
			'posts_per_page'      => -1,
			'post_type' 	      => $type,
			'post_status'	 	  => $status,
			'ignore_sticky_posts' => 1
		);
		
		if(!empty ( $post_author ) ){
			$query_args['author']	= $post_author;
		}

		//Meta Query
		if (!empty($meta_query_args)) {
			$query_relation = array('relation' => 'AND',);
			$meta_query_args = array_merge($query_relation, $meta_query_args);
			$query_args['meta_query'] = $meta_query_args;
		}
		
        $query = new WP_Query($query_args);
        return $query->post_count;
    }
}

/**
 * Payouts
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'doctreat_get_payouts_lists' ) ) {
	function doctreat_get_payouts_lists(){
		
		$list	= array(
					'paypal' => array(
									'id'		=> 'paypal',
									'title'		=> esc_html__('Paypal', 'doctreat'),
									'img_url'	=> esc_url(get_template_directory_uri().'/images/payouts/paypal.png'),
									'status'	=> 'enable',
									'desc'		=> wp_kses( __( 'You need to add your PayPal ID below in the text field. For more about <a target="_blank" href="https://www.paypal.com/"> PayPal </a> | <a target="_blank" href="https://www.paypal.com/signup/">Create an account</a>', 'doctreat' ),array(
																'a' => array(
																	'href' => array(),
																	'target' => array(),
																	'title' => array()
																),
																'br' => array(),
																'em' => array(),
																'strong' => array(),
															)),
									'fields'	=> array(
										'paypal_email' => array(
											'type'			=> 'text',
											'classes'		=> '',
											'required'		=> true,
											'placeholder'	=> esc_html__('Add PayPal Email Address','doctreat'),
											'message'	=> esc_html__('PayPal Email Address is required','doctreat'),
										)
									)
								),
					'bacs' => array(
									'id'		=> 'bacs',
									'title'		=> esc_html__('Direct Bank Transfer (BACS)', 'doctreat'),
									'img_url'	=> esc_url(get_template_directory_uri().'/images/payouts/bank.png'),
									'status'	=> 'enable',
									'desc'		=> wp_kses( __( 'Please add all required settings for the bank transfer.', 'doctreat' ),array(
																'a' => array(
																	'href' => array(),
																	'target' => array(),
																	'title' => array()
																),
																'br' => array(),
																'em' => array(),
																'strong' => array(),
															)),
									'fields'	=> array(
										'bank_account_name' => array(
											'type'			=> 'text',
											'classes'		=> '',
											'required'		=> true,
											'placeholder'	=> esc_html__('Bank Account Name','doctreat'),
											'message'		=> esc_html__('Bank Account Name is required','doctreat'),
										),
										'bank_account_number' => array(
											'type'			=> 'text',
											'classes'		=> '',
											'required'		=> true,
											'placeholder'	=> esc_html__('Bank Account Number','doctreat'),
											'message'		=> esc_html__('Bank Account Number is required','doctreat'),
										),
										'bank_name' => array(
											'type'			=> 'text',
											'classes'		=> '',
											'required'		=> true,
											'placeholder'	=> esc_html__('Bank Name','doctreat'),
											'message'		=> esc_html__('Bank Name is required','doctreat'),
										),
										'bank_routing_number' => array(
											'type'			=> 'text',
											'classes'		=> '',
											'required'		=> false,
											'placeholder'	=> esc_html__('Bank Routing Number','doctreat'),
											'message'		=> esc_html__('Bank Routing Number is required','doctreat'),
										),
										'bank_iban' => array(
											'type'			=> 'text',
											'classes'		=> '',
											'required'		=> false,
											'placeholder'	=> esc_html__('Bank IBAN','doctreat'),
											'message'		=> esc_html__('Bank IBAN is required','doctreat'),
										),
										'bank_bic_swift' => array(
											'type'			=> 'text',
											'classes'		=> '',
											'required'		=> false,
											'placeholder'	=> esc_html__('Bank BIC/SWIFT','doctreat'),
											'message'		=> esc_html__('Bank BIC/SWIFT is required','doctreat'),
										)
									)
								),
			);
		
		$list	= apply_filters('doctreat_filter_payouts_lists',$list);
		return $list;
	}
}

/**
 * Get Tag Line
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if(!function_exists('doctreat_get_tagline') ) {
	function doctreat_get_tagline($post_id ='') {
		$shoert_des		= doctreat_get_post_meta( $post_id, 'am_short_description');
		$shoert_des		= !empty( $shoert_des ) ? esc_html( $shoert_des ) : '';
		return $shoert_des;
	} 
}

/**
 * Get Location
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if(!function_exists('doctreat_get_location') ) {
	function doctreat_get_location($post_id ='') {
		$args	= array();
		$terms 				= apply_filters('doctreat_get_tax_query',array(),$post_id,'locations',$args);
		$countries			= !empty( $terms[0]->term_id ) ? intval( $terms[0]->term_id ) : '';
		$locations_name		= !empty( $terms[0]->name ) ?  $terms[0]->name  : '';
		
		if(!empty($locations_name) ) {
			$item['_country']	= $locations_name;
		} else {
			$item['_country']	= '';
		}
		
		return $item;
	} 
}

/**
 * Get doctors days
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if(!function_exists('doctreat_get_booking_days') ) {
	function doctreat_get_booking_days( $user_identity ='' ) {
		$days		= array();
		$sloats		= array();
		
		$args 	= array(
					'fields'          	=> 'ids',
					'post_type'      	=> 'hospitals_team',
					'author' 			=>	$user_identity,
					'post_status'    	=> 'publish',
					'posts_per_page' 	=> -1
				);
		
		$team_hospitals = get_posts( $args );
		
		if( !empty( $team_hospitals ) ){
			
			foreach( $team_hospitals as $item ){
				$sloats	= get_post_meta( $item,'am_slots_data',true);
				if( !empty( $days ) ){
					$days	= array_merge($days, array_keys( $sloats ));
				} else {
					$days	=  array_keys( $sloats );
				}
				
			}
			
		}
		
		if( !empty( $days ) ){
			$days	= array_unique( $days );
		}
		
		return $days;
		
	} 
}

/**
 * Get signup uri
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists( 'doctreat_get_signup_page_url' ) ) {    

    function doctreat_get_signup_page_url($key = 'step', $slug = '1') {
		global $theme_settings;
        $login_register		= !empty( $theme_settings['registration_form'] ) && !empty( $theme_settings['login_page'] ) ? $theme_settings['login_page'] : '';

        if(!empty( $login_register )){
            $signup_page_slug = esc_url(get_permalink((int) $login_register));            
        }

        if( !empty( $signup_page_slug ) ){
            $signup_page_slug = add_query_arg( $key, $slug, $signup_page_slug );    
            return $signup_page_slug;
        }

        return '';
    }
}


/**
 * List Months
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_list_month' ) ) {
    function doctreat_list_month( ) {
		$month_names = array(
						'01'	=> esc_html__("January",'doctreat'),
						'02'	=> esc_html__("February",'doctreat'),
						'03' 	=> esc_html__("March",'doctreat'),
						'04'	=> esc_html__("April",'doctreat'),
						'05'	=> esc_html__("May",'doctreat'),
						'06'	=> esc_html__("June",'doctreat'),
						'07'	=> esc_html__("July",'doctreat'),
						'08'	=> esc_html__("August",'doctreat'),
						'09'	=> esc_html__("September",'doctreat'),
						'10'	=> esc_html__("October",'doctreat'),
						'11'	=> esc_html__("November",'doctreat'),
						'12'	=> esc_html__("December",'doctreat'),
					);
		
		return $month_names;
		
	}
}

/**
 * List Users Types
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_list_user_types' ) ) {
    function doctreat_list_user_types( ) {
		global $theme_settings;
		$system_access		= !empty( $theme_settings['system_access'] ) ? $theme_settings['system_access'] : '';
		$user_types_names = array(
						'hospitals'		=> esc_html__("Hospitals",'doctreat'),
						'doctors'		=> esc_html__("Doctor",'doctreat'),
						'regular_users' => esc_html__("Patients",'doctreat')
					);
		if( !empty($system_access) ){
			unset($user_types_names['hospitals']);
		}
		return $user_types_names;
		
	}
}

/**
 * List services by specialities
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_list_service_by_specialities' ) ) {
    function doctreat_list_service_by_specialities($speciality_id ) {
		$args = array(
			'hide_empty' => false, // also retrieve terms which are not used yet
			'meta_query' => array(
				array(
				   'key'       => 'speciality',
				   'value'     => $speciality_id,
				   'compare'   => '='
				)
			)
		);
		
		$services_array	 = array();
		if( taxonomy_exists('services') ){
			$services = get_terms( 'services', $args );
			if( !empty( $services ) ){
				foreach( $services as $service ) {
					$services_array[$service->term_id] = $service;
				}
			}
		}
		
		return $services_array;
	}
}

/**
 * Get full Dr name
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_full_name' ) ) {
    function doctreat_full_name( $post_id ) {
		$dr_name	= doctreat_get_post_meta($post_id,'am_name_base');
		$title 		= get_the_title($post_id);
		$title		= !empty( $title ) ? $title : '';
		$user_identity	= doctreat_get_linked_profile_id($post_id,'post');
		$user_type		= apply_filters('doctreat_get_user_type', $user_identity );
		
		if( !empty( $dr_name ) && $user_type === 'doctors' ){
			$name_bases			= array();
			if( function_exists( 'doctreat_get_name_bases' ) ) {
				$name_bases	= doctreat_get_name_bases($dr_name);
				$dr_name	= $name_bases;
			}
			
			$full_name	= $dr_name.' '.$title;
		} else {
			$full_name	= $title;
		}
		
		return ucfirst( $full_name );
	}
}

/**
 * Get user post meta
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_post_meta' ) ) {
    function doctreat_get_post_meta( $post_id ='' , $meta_key = '') {
		$post_meta = array();
		
		if( !empty( $post_id )) {
			$post_type		= get_post_type($post_id);
			$post_meta		= get_post_meta($post_id, 'am_' . $post_type . '_data',true);	
			$post_meta		= !empty( $post_meta) ? $post_meta : array();
		}
		
		if( !empty( $meta_key ) ){
			$post_meta		= !empty( $post_meta[$meta_key] ) ? $post_meta[$meta_key] : array();
		}
		
		return $post_meta;
	}
}

/**
 * Check wishlist
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_check_wishlist' ) ) {
    function doctreat_check_wishlist( $post_id,$key = '' ) {
		global $current_user;
		$return = false;
		$linked_profile   	= doctreat_get_linked_profile_id($current_user->ID);
		$saved_doctors 		= get_post_meta($linked_profile, $key, true);
		$wishlist   		= !empty( $saved_doctors ) && is_array( $saved_doctors ) ? $saved_doctors : array();
		
		if( !empty( $post_id ) ) {
			if( in_array( $post_id, $wishlist ) ){ 
				$return = true;
			} else {
				$return = false;
			}
		}
		
		return $return;
	}
}

/**
 * Get account settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_account_settings' ) ) {
	function doctreat_get_account_settings($key='') {
		global $current_user;
		$settings = array(
			'doctors' => array(
				'_profile_blocked' 		=> esc_html__('Disable my account temporarily','doctreat'),
			),
			'hospitals' => array(
				'_profile_blocked' 		=> esc_html__('Disable my account temporarily','doctreat'),
			),
		);

		$settings	= apply_filters('doctreat_filters_account_settings',$settings);
		
		return !empty( $settings[$key] ) ? $settings[$key] : array();
	}
}

/**
 * Get leave reasons list
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_account_delete_reasons' ) ) {
	function doctreat_get_account_delete_reasons($key='') {
		global $current_user;
		$list = array(
			'not_satisfied' => esc_html__('No satisfied with the system','doctreat'),
			'support' 		=> esc_html__('Support is not good','doctreat'),
			'other' 		=> esc_html__('Others','doctreat'),
		);

		$reasons	= apply_filters('doctreat_filters_account_delete_reasons',$list);
		
		if( !empty( $key ) ){
			return !empty( $list[$key] ) ? $list[$key] : '';
		}
		
		return $reasons;
	}
}

/**
 * Get Search page
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_search_page' ) ) {
	function doctreat_get_search_page( $type='') {
		global $theme_settings;
		$search_settings	= !empty( $theme_settings['search_form'] ) ? $theme_settings['search_form'] : '';
		$search_page		= !empty( $theme_settings[$type] ) && !empty( $search_settings )  ? get_the_permalink($theme_settings[$type]) : '';
		
		return $search_page;
	}
}

/**
 * Get profile ID by post ID
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_pofile_ID_by_post' ) ) {
	function doctreat_get_pofile_ID_by_post( $post_id='') {
		$profile_id	= '';
		if( !empty( $post_id ) ){
			$author_id = get_post_field( 'post_author', $post_id );
			if( !empty( $author_id ) ){
				$profile_id	= doctreat_get_linked_profile_id($author_id);
			}
		}
		
		return $profile_id;
	}
}

/**
 * Get time
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_time' ) ) {
	function doctreat_get_time() {
		$time_settings = get_option( 'dc_time_settings' );
		
		$list	= array(		
					'0000'	=> esc_html__('12:00 am','doctreat'),
					'0100'	=> esc_html__('1:00 am','doctreat'),
					'0200'	=> esc_html__('2:00 am','doctreat'),
					'0300'	=> esc_html__('3:00 am','doctreat'),
					'0400'	=> esc_html__('4:00 am','doctreat'),
					'0500'	=> esc_html__('5:00 am','doctreat'),
					'0600'	=> esc_html__('6:00 am','doctreat'),
					'0700'	=> esc_html__('7:00 am','doctreat'),
					'0800'	=> esc_html__('8:00 am','doctreat'),
					'0900'	=> esc_html__('9:00 am','doctreat'),
					'1000'	=> esc_html__('10:00 am','doctreat'),
					'1100'	=> esc_html__('11:00 am','doctreat'),
					'1200'	=> esc_html__('12:00 am','doctreat'),
					'1300'	=> esc_html__('1:00 pm','doctreat'),
					'1400'	=> esc_html__('2:00 pm','doctreat'),
					'1500'	=> esc_html__('3:00 pm','doctreat'),
					'1600'	=> esc_html__('4:00 pm','doctreat'),
					'1700'	=> esc_html__('5:00 pm','doctreat'),
					'1800'	=> esc_html__('6:00 pm','doctreat'),
					'1900'	=> esc_html__('7:00 pm','doctreat'),
					'2000'	=> esc_html__('8:00 pm','doctreat'),
					'2100'	=> esc_html__('9:00 pm','doctreat'),
					'2200'	=> esc_html__('10:00 pm','doctreat'),
					'2300'	=> esc_html__('11:00 pm','doctreat'),
					'2400'	=> esc_html__('12:00 pm (night)','doctreat')			
				);
		
		$final_list	= !empty( $time_settings ) ? $time_settings : $list;
		$time_list 	= apply_filters('doctreat_filter_time',$final_list);
		return $time_list;
	}
}

/**
 * Get time slots
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_time_slots' ) ) {
	function doctreat_get_time_slots() {
		$slots_settings = get_option( 'dc_time_slots_settings' );
		
		$list	= array(		
					'1'	=> esc_html__('1 time slots','doctreat'),
					'2'	=> esc_html__('2 time slots','doctreat'),
					'3'	=> esc_html__('3 time slots','doctreat'),
					'4'	=> esc_html__('4 time slots','doctreat'),
					'5'	=> esc_html__('5 time slots','doctreat'),
					'6'	=> esc_html__('6 time slots','doctreat'),
					'7'	=> esc_html__('7 time slots','doctreat'),
					'8'	=> esc_html__('8 time slots','doctreat'),
					'9'	=> esc_html__('9 time slots','doctreat'),
					'10'	=> esc_html__('10 time slots','doctreat'),
					'11'	=> esc_html__('11 time slots','doctreat'),
					'12'	=> esc_html__('12 time slots','doctreat'),
					'13'	=> esc_html__('13 time slots','doctreat'),
					'14'	=> esc_html__('14 time slots','doctreat'),
					'15'	=> esc_html__('15 time slots','doctreat'),
					'16'	=> esc_html__('16 time slots','doctreat'),
					'17'	=> esc_html__('17 time slots','doctreat'),
					'18'	=> esc_html__('18 time slots','doctreat'),
					'19'	=> esc_html__('19 time slots','doctreat'),
					'20'	=> esc_html__('20 time slots','doctreat')
			
				);
		
		$final_list		= !empty( $slots_settings ) ? $slots_settings : $list;
		$slots_list 	= apply_filters('doctreat_filter_time_slots',$final_list);
		return $slots_list;
	}
}

/**
 * Get time slots
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_meeting_time' ) ) {
	function doctreat_get_meeting_time() {
		$slots_settings = get_option( 'dc_meeting_time_settings' );
		
		$list	= array(		
					''	=> esc_html__('Appointment Durations','doctreat'),
					'5'	=> esc_html__('5 minutes','doctreat'),
					'10'	=> esc_html__('10 minutes','doctreat'),
					'15'	=> esc_html__('15 minutes','doctreat'),
					'20'	=> esc_html__('20 minutes','doctreat'),
					'30'	=> esc_html__('30 minutes','doctreat'),
					'45'	=> esc_html__('45 minutes','doctreat'),
					'60'	=> esc_html__('1 hours','doctreat'),
					'90'	=> esc_html__('1 hours, 30 minutes','doctreat'),
					'120'	=> esc_html__('2 hours','doctreat'),
					'180'	=> esc_html__('3 hours','doctreat'),
					'240'	=> esc_html__('4 hours','doctreat'),
					'300'	=> esc_html__('5 hours','doctreat'),
					'360'	=> esc_html__('6 hours','doctreat'),
					'420'	=> esc_html__('7 hours','doctreat'),
					'480'	=> esc_html__('8 hours','doctreat')
				);
		
		$final_list		= !empty( $slots_settings ) ? $slots_settings : $list;
		$slots_list 	= apply_filters('doctreat_filter_meeting_time',$final_list);
		return $slots_list;
	}
}

/**
 * Get time padding
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_padding_time' ) ) {
	function doctreat_get_padding_time() {
		$slots_settings = get_option( 'dc_padding_time_settings' );
		
		$list	= array(		
					''	=> esc_html__('Appointment Intervals','doctreat'),
					'5'	=> esc_html__('5 minutes','doctreat'),
					'10'	=> esc_html__('10 minutes','doctreat'),
					'15'	=> esc_html__('15 minutes','doctreat'),
					'20'	=> esc_html__('20 minutes','doctreat'),
					'30'	=> esc_html__('30 minutes','doctreat'),
					'45'	=> esc_html__('45 minutes','doctreat'),
					'60'	=> esc_html__('1 hours','doctreat'),
					'90'	=> esc_html__('1 hours, 30 minutes','doctreat'),
					'120'	=> esc_html__('2 hours','doctreat'),
				);
		
		$final_list		= !empty( $slots_settings ) ? $slots_settings : $list;
		$slots_list 	= apply_filters('doctreat_filter_padding_time',$final_list);
		return $slots_list;
	}
}

/**
 * Get slots by day and post id
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_day_spaces' ) ) {
	function doctreat_get_day_spaces( $day = '', $post_id = '') {
		
		$li_data	= '';
		if( !empty( $day ) && !empty( $post_id ) ) {
			$time_format 		= get_option('time_format');
			$am_slots_data 		= get_post_meta( $post_id,'am_slots_data',true);
			$am_slots_data		= !empty( $am_slots_data ) ? $am_slots_data : array();
			$slots				= $am_slots_data[$day]['slots'];
			if( !empty( $slots ) ){
				foreach( $slots as $slot_key => $slot_val ) { 
					$slot_key_val = explode('-', $slot_key);
					$li_data .='<li>
					<a href="javascript:;" class="dc-spaces">
						<span>'.date($time_format, strtotime('2016-01-01' . $slot_key_val[0])).'</span>
						<span>'.esc_html('Spaces','doctreat').': '. esc_html( $slot_val["spaces"] ).'</span>
						<i class="lnr lnr-cross" data-id="'.intval( $post_id ).'" data-day="'.esc_attr( $day ).'" data-key="'.esc_attr( $slot_key ).'"></i>
					</a>
				</li>';
				}
			} 
		} 
		
		return $li_data;
	}
}

/**
 * Generate google link
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'doctreat_generate_GoogleLink' ) ) {
	function doctreat_generate_GoogleLink ($title,$from,$to,$description,$address){
		$start  = new DateTime($from);
		$end 	= new DateTime($to);
		$from	= $start->format('Ymd\THis');
		$to		= $end->format('Ymd\THis');
		$protolcol  = is_ssl() ? "https" : "http";
		$url 		= $protolcol.'://calendar.google.com/calendar/render?action=TEMPLATE';


		$url .= '&text='.urlencode($title);
		$url .= '&dates='.$from.'/'.$to;

		if ($description) {
			$url .= '&details='.urlencode($description);
		}

		if ($address) {
			$url .= '&location='.urlencode($address);
		}

		$url .= '&sprop=&sprop=name:';

		return $url;
	}
}

/**
 * Generate google link
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'doctreat_generate_YahooLink' ) ) {
	function doctreat_generate_YahooLink ($title,$from,$to,$description,$address){
		$start  = new DateTime($from);
		$end 	= new DateTime($to);
		$protolcol  = is_ssl() ? "https" : "http";
		$url 		= $protolcol.'://calendar.yahoo.com/?v=60&view=d&type=20';

		$url .= '&title='.urlencode($title);
		$url .= '&st='.$start->format('Ymd\THis\Z');
		$url .= '&dur='.date_diff($start, $end)->format('%H%I');

		if ($description) {
			$url .= '&desc='.urlencode($description);
		}

		if ($address) {
			$url .= '&in_loc='.urlencode($address);
		}

		return $url;
	}
}
/*
**
 * Get total earning for doctor
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_total_earning_doctor' ) ) {
    function doctreat_get_total_earning_doctor( $user_id='',$status='',$colum_name='') {
		global $wpdb;
		$table_name = $wpdb->prefix . "dc_earnings";
		
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {
			if( !empty($user_id) && !empty($status) && !empty($colum_name) ) {
				$e_query	= $wpdb->prepare("SELECT sum(".$colum_name.") FROM ".$table_name." WHERE user_id = %d and ( status = %s || status = %s )",$user_id,$status[0],$status[1]);
				$total_earning	= $wpdb->get_var( $e_query );
			} else {
				$total_earning	= 0;
			}
		} else{
			$total_earning	= 0;
		}
		
		return $total_earning;
		
	}
}

/**
 * Get earning for doctreat
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_payments_doctreat' ) ) {
    function doctreat_get_payments_doctreat( $user_identity,$limit=6  ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "dc_payouts_history";
		$month		= date('m');
		
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {
			if( !empty($user_identity) ) {
				$e_query	= $wpdb->prepare("SELECT * FROM $table_name where ( user_id =%d and status= 'completed' And month=%d) ORDER BY id DESC LIMIT %d",$user_identity,$month,$limit);
				$payments = $wpdb->get_results( $e_query );
			} else {
				$payments	= 0;
			}
		} else{
			$payments	= 0;
		}
		
		return $payments;
		
	}
}

/**
 * Get sum payments for doctor
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_sum_payments_doctor' ) ) {
    function doctreat_get_sum_payments_doctor( $user_id='',$status='',$colum_name='') {
		global $wpdb;

		return $current_balance	= doctreat_get_total_earning_doctor($user_id,array('completed','processed'),'doctor_amount');
	}
}

/**
 * Get total earning for doctor
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_total_earning_doctor' ) ) {
    function doctreat_get_total_earning_doctor( $user_id='',$status='',$colum_name='') {
		global $wpdb;
		$table_name = $wpdb->prefix . "dc_earnings";
		
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {
			if( !empty($user_id) && !empty($status) && !empty($colum_name) ) {
				$e_query	= $wpdb->prepare("SELECT sum(".$colum_name.") FROM ".$table_name." WHERE user_id = %d and ( status = %s || status = %s )",$user_id,$status[0],$status[1]);
				$total_earning	= $wpdb->get_var( $e_query );
			} else {
				$total_earning	= 0;
			}
		} else{
			$total_earning	= 0;
		}
		
		return $total_earning;
		
	}
}

/**
 * Get sum earning for doctor
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_get_sum_earning_doctor' ) ) {
    function doctreat_get_sum_earning_doctor( $user_id='',$status='',$colum_name='') {
		global $wpdb;
		$table_name = $wpdb->prefix . "dc_earnings";
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {
			if( !empty($user_id) && !empty($status) && !empty($colum_name) ) {
				$e_query	= $wpdb->prepare("SELECT sum(".$colum_name.") FROM ".$table_name." WHERE user_id = %d and status = %s",$user_id,$status);
				$total_earning	= $wpdb->get_var( $e_query );
			} else {
				$total_earning	= 0;
			}
		} else{
			$total_earning	= 0;
		}
		
		return $total_earning;
		
	}
}

/**
 * Get prefix
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('dc_unique_increment')) {

    function dc_unique_increment($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

/**
 * Get sum earning for payouts
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( ! function_exists( 'doctreat_sum_earning_doctor_payouts' ) ) {
    function doctreat_sum_earning_doctor_payouts( $status='',$colum_name='') {
		global $wpdb;
		$table_name = $wpdb->prefix . "dc_earnings";
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {
			if( !empty($status) && !empty($colum_name) ) {
				$e_query	= $wpdb->prepare("SELECT user_id, sum(".$colum_name.") as total_amount FROM ".$table_name." WHERE status = %s GROUP BY user_id",$status);
				$total_earning	= $wpdb->get_results( $e_query );
			} else {
				$total_earning	= 0;
			}
		} else{
			$total_earning	= 0;
		}
		
		return $total_earning;
		
	}
}

/**
 * Update doctor earning
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'doctreat_update_earning' ) ) {

	function doctreat_update_earning( $where, $update, $table_name ) {
		global $wpdb;
		if( !empty($where) && !empty($update) && !empty($table_name) ) {
			$wpdb->update($wpdb->prefix.$table_name, $update, $where);
		} else {
			return false;
		}
	}
}

/**
 * theme setting options
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_theme_option')) {

    function doctreat_theme_option($option_type='system_booking_oncall') {
		global $theme_settings;
		$theme_option	= !empty($theme_settings[$option_type]) ? $theme_settings[$option_type] : '';
		return $theme_option;
    }
}

/**
 * System booking on call option
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_booking_oncall_option')) {

    function doctreat_get_booking_oncall_option($is_active='') {

		$payment_type				= doctreat_theme_option('payment_type');
		$system_booking_oncall		= doctreat_theme_option('system_booking_oncall');
		$booking_option				= (!empty($payment_type) && $payment_type === 'offline') && !empty($system_booking_oncall) ? $system_booking_oncall : '';
		
		if(!empty($booking_option) && empty($is_active)){
			$booking_option			= doctreat_theme_option('booking_system_contact');
		}

		return $booking_option;
    }
}

/**
 * System booking on call doctors option
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('doctreat_get_booking_oncall_doctors_option')) {

    function doctreat_get_booking_oncall_doctors_option() {

		$payment_type				= doctreat_theme_option('payment_type');
		$booking_option				= 1;
		if( (!empty($payment_type) && $payment_type ==='offline') ){
			$system_booking_oncall		= doctreat_theme_option('system_booking_oncall');
			if( !empty($system_booking_oncall) ){
				$booking_option			= doctreat_theme_option('booking_system_contact');
			}
		}

		return $booking_option;
    }
}

