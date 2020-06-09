<?php

/**
 *
 * General Theme Functions
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */
if (!function_exists('doctreat_scripts')) {

    function doctreat_scripts() {
		global $theme_settings;
        $theme_version 	= wp_get_theme('doctreat');
        $google_key 	= '';
		$google_key		= !empty( $theme_settings['google_map'] ) ? $theme_settings['google_map'] : '';
        $protocol 		= is_ssl() ? 'https' : 'http';

        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('fontawesome-all', get_template_directory_uri() . '/css/fontawesome/fontawesome-all.min.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('basictable', get_template_directory_uri() . '/css/basictable.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('scrollbar', get_template_directory_uri() . '/css/scrollbar.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('linearicons', get_template_directory_uri() . '/css/linearicons.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('fullcalendar', get_template_directory_uri() . '/css/fullcalendar.min.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('pogoslider', get_template_directory_uri() . '/css/pogoslider.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('chosen', get_template_directory_uri() . '/css/chosen.css', array(), $theme_version->get('Version'));  
		wp_register_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('doctreat-typo', get_template_directory_uri() . '/css/typo.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('datetimepicker', get_template_directory_uri() . '/css/datetimepicker.css', array(), $theme_version->get('Version'));
		
		if (is_page_template('directory/dashboard.php')) { 
			wp_enqueue_style('doctreat-select2', get_template_directory_uri() . '/css/select2.min.css', array(), $theme_version->get('Version'));
		}
		
		//dashboard and doctors single style
		if (is_singular('doctors') || is_page_template('directory/dashboard.php') ) {
			wp_enqueue_style('doctreat-elements', get_template_directory_uri() . '/css/elements.css', array(), $theme_version->get('Version'));
		}
		wp_enqueue_style('doctreat-style', get_template_directory_uri() . '/style.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('slick', get_template_directory_uri() . '/css/slick.css', array(), $theme_version->get('Version'));
		wp_enqueue_style('doctreat-transitions', get_template_directory_uri() . '/css/transitions.css', array(), $theme_version->get('Version'));
		
		if( is_rtl() ){
			wp_enqueue_style('doctreat-rtl', get_template_directory_uri() . '/css/rtl.css', array(), $theme_version->get('Version'));
			wp_enqueue_style('doctreat-responsive', get_template_directory_uri() . '/css/responsive.css', array(), $theme_version->get('Version'));
		} else {
			wp_enqueue_style('doctreat-responsive', get_template_directory_uri() . '/css/responsive.css', array(), $theme_version->get('Version'));
		}
		
		
		if ( is_singular('doctors') || is_singular( 'hospitals') ) {
			wp_enqueue_style('prettyPhoto');
		}
		//dashboard styles
		if (is_page_template('directory/dashboard.php')) { 
			
			wp_enqueue_style('doctreat-dashboard', get_template_directory_uri() . '/css/dashboard.css', array(), $theme_version->get('Version'));
			
			if( is_rtl() ){
				wp_enqueue_style('doctreat-rtl-dashboard', get_template_directory_uri() . '/css/rtl-dashboard.css', array(), $theme_version->get('Version'));
			}
			
			wp_enqueue_style('doctreat-dbresponsive', get_template_directory_uri() . '/css/dbresponsive.css', array(), $theme_version->get('Version'));
			
		}
		
		//chat emoji
		if ( ( is_page_template('directory/dashboard.php') && isset($_GET['ref']) && $_GET['ref'] === 'chat') || is_singular('doctors') ) {
			wp_enqueue_style('emojionearea', get_template_directory_uri() . '/css/emoji/emojionearea.min.css', array(), $theme_version->get('Version')); 
		}
		
		//inline styles
        $custom_css = doctreat_add_dynamic_styles();   
        wp_add_inline_style('doctreat-style', $custom_css);

        //script
		wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), $theme_version->get('Version'), true);
        wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/vendor/modernizr.min.js', array(), $theme_version->get('Version'), false);
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array(), $theme_version->get('Version'), true);
		wp_register_script('socket.io', get_template_directory_uri() . '/node_modules/socket.io-client/dist/socket.io.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('chosen', get_template_directory_uri() . '/js/chosen.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('pogoslider', get_template_directory_uri() . '/js/pogoslider.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('datetimepicker', get_template_directory_uri() . '/js/datetimepicker.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('doctreat-callback', get_template_directory_uri() . '/js/doctreat_callback.js', array('jquery'), $theme_version->get('Version'), true);
		wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.min.js', array(), $theme_version->get('Version'), true);
		wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/prettyPhoto.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('fullcalendar', get_template_directory_uri() . '/js/fullcalendar.min.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('fullcalendar-lang', get_template_directory_uri() . '/js/lang-all.js', array(), $theme_version->get('Version'), true);
		wp_enqueue_script('wp-util');

		if (!empty($google_key)) {
            wp_register_script('googleapis', $protocol . '://maps.googleapis.com/maps/api/js?key=' . trim($google_key) . '&libraries=places', '', '', true);
        } else {
            wp_register_script('googleapis', $protocol . '://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', '', '', true);
		} 
		wp_register_script('gmap3', get_template_directory_uri() . '/js/gmap3.js', array(), $theme_version->get('Version'), true);
		wp_register_script('doctreat-maps', get_template_directory_uri() . '/js/doctreat_maps.js', array(), $theme_version->get('Version'), true);
		
		
		//Dashboard scripts
		if (is_page_template('directory/dashboard.php')) { 
			wp_enqueue_script('plupload');
			wp_enqueue_script('basictable', get_template_directory_uri() . '/js/basictable.min.js', array(), $theme_version->get('Version'), true);
			wp_enqueue_script('doctreat-select2', get_template_directory_uri() . '/js/select2.min.js', array(), $theme_version->get('Version'), true);
			wp_enqueue_script('googleapis');
			wp_enqueue_script('gmap3');
			wp_enqueue_script('doctreat-maps');
			
			wp_enqueue_script('doctreat-dashboard', get_template_directory_uri() . '/js/dashboard.js', array('jquery'), $theme_version->get('Ve
			rsion'), true);
			
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );

		}
		
		wp_enqueue_script('scrollbar', get_template_directory_uri() . '/js/scrollbar.min.js', array('jquery'), $theme_version->get('Version'), true);
		wp_enqueue_script('tipso', get_template_directory_uri() . '/js/tipso.js', '', '', true);
		
		//Dashboard and doctors chat scripts
		if ( ( is_page_template('directory/dashboard.php') && isset($_GET['ref']) && $_GET['ref'] === 'chat') || is_singular('doctors') ) {
			wp_enqueue_script('emojionearea', get_template_directory_uri() . '/js/emoji/emojionearea.min.js', array(), '', true);
			wp_enqueue_script('linkify', get_template_directory_uri() . '/js/linkify/linkify.min.js', array(), '', true);
			wp_enqueue_script('linkify-string', get_template_directory_uri() . '/js/linkify/linkify-string.min.js', array(), '', true);
			wp_enqueue_script('linkify-jquery', get_template_directory_uri() . '/js/linkify/linkify-jquery.min.js', array(), '', true);
		}
		
		if (is_singular('doctors') || is_singular( 'hospitals') ) {
			wp_enqueue_script('prettyPhoto');
			wp_enqueue_script('googleapis');
			wp_enqueue_script('gmap3');
			wp_enqueue_script('doctreat-maps');
		}

		//Doctor Single Scripts
		if (is_singular('doctors')) {
			wp_enqueue_script('jrate', get_template_directory_uri() . '/js/jrate.js', array(), $theme_version->get('Version'), true);
			wp_enqueue_script('jquery-ui-slider');
		}

		wp_localize_script('doctreat-callback', 'scripts_vars', array(
			'is_admin'		=> 'no',
            'ajaxurl' 		=> admin_url('admin-ajax.php'),
        ));
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
			wp_enqueue_script( 'comment-reply' );
		}
    }

    add_action('wp_enqueue_scripts', 'doctreat_scripts', 88);
}


/**
 * @Enqueue admin scripts and styles.
 * @return{}
 */
if (!function_exists('doctreat_admin_enqueue')) {

    function doctreat_admin_enqueue($hook) {
        global $post;
        $protolcol = is_ssl() ? "https" : "http";
        $theme_version = wp_get_theme('doctreat');
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), $theme_version->get('Version'));
        wp_enqueue_style( 'doctreat-admin-style', get_template_directory_uri() . '/admin/css/admin-style.css', array(), $theme_version->get('Version'));
        wp_enqueue_script('doctreat-admin-functions', get_template_directory_uri() . '/admin/js/admin_functions.js', array('wp-color-picker','jquery'), $theme_version->get('Version'), false);

        		
        $is_author_edit = '';
        if (isset($hook) && $hook == 'user-edit.php') {
            $is_author_edit = 'yes';
        }
		
		$dir_spinner = get_template_directory_uri() . '/images/spinner.gif';

        wp_localize_script('doctreat-admin-functions', 'scripts_vars', array(
            'yes' 			=> esc_html__('Yes', 'doctreat'),
            'no' 			=> esc_html__('No', 'doctreat'),
			'import' 		=> esc_html__('Import Users', 'doctreat'),
			'spinner'   	=> '<img class="sp-spin" src="'.esc_url($dir_spinner).'">',
            'import_message'	=> esc_html__('Are you sure, you want to import users?', 'doctreat'),
			'repeater_message' 	=> esc_html__('Are you sure, you want to remove?', 'doctreat'),
			'repeater_title' 	=> esc_html__('Alert', 'doctreat'),
            'is_author_edit' 	=> $is_author_edit
        ));
		
		wp_enqueue_media();
    }

    add_action('admin_enqueue_scripts', 'doctreat_admin_enqueue', 10, 1);
}

/**
 * @Theme Editor/guttenberg Style
 * 
 */
if (!function_exists('doctreat_add_editor_styles')) {

    function doctreat_add_editor_styles() {
		global $theme_settings;
		$protocol = is_ssl() ? 'https' : 'http';
        $theme_version = wp_get_theme('doctreat');
		$editor_css  = '';
		
		if (function_exists('fw_get_db_settings_option')) {
            $color_base = fw_get_db_settings_option('color_settings');
        }
		
		$site_colors 	= !empty( $theme_settings['site_colors'] ) ? $theme_settings['site_colors'] : '';
		
		if ( !empty($site_colors) ) {
			$theme_primary_color 	= !empty( $theme_settings['theme_primary_color'] ) ? $theme_settings['theme_primary_color'] : '';
			$theme_secondary_color 	= !empty( $theme_settings['theme_secondary_color'] ) ? $theme_settings['theme_secondary_color'] : '';
			$theme_tertiary_color 	= !empty( $theme_settings['theme_tertiary_color'] ) ? $theme_settings['theme_tertiary_color'] : '';
			
			if (!empty($theme_primary_color)) {
				$editor_css  .= 'body.block-editor-page .editor-styles-wrapper a,
				body.block-editor-page .editor-styles-wrapper p a,
				body.block-editor-page .editor-styles-wrapper p a:hover,
				body.block-editor-page .editor-styles-wrapper a:hover,
				body.block-editor-page .editor-styles-wrapper a:focus,
				body.block-editor-page .editor-styles-wrapper a:active{color: '.$theme_primary_color.';}';
				
				$editor_css  .= 'body.block-editor-page .editor-styles-wrapper blockquote:not(.blockquote-link),
								 body.block-editor-page .editor-styles-wrapper .wp-block-quote.is-style-large,
								 body.block-editor-page .editor-styles-wrapper .wp-block-quote:not(.is-large):not(.is-style-large),
								 body.block-editor-page .editor-styles-wrapper .wp-block-quote.is-style-large,
								 body.block-editor-page .editor-styles-wrapper .wp-block-pullquote, 
								 body.block-editor-page .editor-styles-wrapper .wp-block-quote, 
								 body.block-editor-page .editor-styles-wrapper .wp-block-quote:not(.is-large):not(.is-style-large),
								 body.block-editor-page .wp-block-pullquote, 
								 body.block-editor-page .wp-block-quote, 
								 body.block-editor-page .wp-block-verse, 
								 body.block-editor-page .wp-block-quote:not(.is-large):not(.is-style-large){border-color:'.$theme_primary_color.';}';
			}
		}
		
		$font_families	= array();
		$font_families[] = 'Open+Sans:400,600';
		$font_families[] = 'Poppins:300,400,500,600,700';
		
		 $query_args = array (
			 'family' => implode('%7C' , $font_families) ,
			 'subset' => 'latin,latin-ext' ,
        );

        $theme_fonts = add_query_arg($query_args , $protocol.'://fonts.googleapis.com/css');
		add_editor_style(esc_url_raw($theme_fonts));
		wp_enqueue_style('doctreat-admin-google-fonts' , esc_url_raw($theme_fonts), array () , null);
		
		$editor_css .= "
		body.block-editor-page editor-post-title__input,
		body.block-editor-page .editor-post-title__block .editor-post-title__input
		{font: 400 24px/34px'Poppins', sans-serif;color: #3d4461;}";
		
		$editor_css .= "body.block-editor-page .editor-styles-wrapper{font: 400 14px/26px 'Open Sans', Arial, Helvetica, sans-serif;}";
		
		$editor_css .= "body.block-editor-page .editor-styles-wrapper{color: #3d4461;}";
		$editor_css .= "body.block-editor-page editor-post-title__input,
		body.block-editor-page .editor-post-title__block .editor-post-title__input,
		body.block-editor-page .editor-styles-wrapper h1, 
				body.block-editor-page .editor-styles-wrapper h2, 
				body.block-editor-page .editor-styles-wrapper h3, 
				body.block-editor-page .editor-styles-wrapper h4, 
				body.block-editor-page .editor-styles-wrapper h5, 
				body.block-editor-page .editor-styles-wrapper h6 {font-family: 'Poppins', Arial, Helvetica, sans-serif;}";
							   
		wp_enqueue_style( 'doctreat-editor-style', get_template_directory_uri() . '/admin/css/doctreat-editor-style.css', array(), $theme_version->get('Version'));
		wp_add_inline_style( 'doctreat-editor-style', $editor_css );
		
    }

    add_action('enqueue_block_editor_assets', 'doctreat_add_editor_styles');
}