<?php
/**
 *
 * Class used as base to create theme header
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */
if (!class_exists('Doctreat_Prepare_Headers')) {

    class Doctreat_Prepare_Headers {

        function __construct() {
            add_action('doctreat_do_process_headers', array(&$this, 'doctreat_do_process_headers'));
			add_action('doctreat_prepare_search', array(&$this, 'doctreat_prepare_search'));
			add_action('doctreat_breadcrumbs_section', array(&$this, 'doctreat_breadcrumbs_section'));
			add_action('doctreat_systemloader', array(&$this, 'doctreat_systemloader'));
			add_action('wp_head', array(&$this, 'doctreat_update_metatags'));
		}
		
		/**
         * @system Update metadata
         * @return {}
         * @author amentotech
         */

		public function doctreat_update_metatags() {
			global  $theme_settings;
			$post_types	= array('page','post');
			$seo_option	= !empty($theme_settings['enable_seo']) ? $theme_settings['enable_seo'] : '';

			if ( is_singular( $post_types ) && !empty($seo_option) ) {
				$post_id	= get_the_ID();
				$post_meta	= doctreat_get_post_meta( $post_id );

				$am_seo_title		= !empty($post_meta['am_seo_title']) ? esc_attr($post_meta['am_seo_title']) : get_the_title($post_id);
				$am_seo_description	= !empty($post_meta['am_seo_description']) ? esc_attr($post_meta['am_seo_description']) : '';
				$am_seo_keywords	= !empty($post_meta['am_seo_keywords']) ? esc_attr($post_meta['am_seo_keywords']) : '';
				ob_start(); ?>
					<?php if(!empty($am_seo_title)) {?>
						<meta name="title" content="<?php echo esc_attr($am_seo_title);?>" />
					<?php } ?>
					<?php if(!empty($am_seo_description)) {?>
						<meta name="description" content="<?php echo esc_attr($am_seo_description);?>" />
					<?php } ?>
					<?php if(!empty($am_seo_keywords)) {?>
						<meta name="keywords" content="<?php echo esc_attr($am_seo_keywords);?>" />
					<?php } ?>
				<?php
					echo ob_get_clean(); 
			}
		}

        /**
         * @system loader
         * @return {}
         * @author amentotech
         */
        public function doctreat_systemloader() {
			global $theme_settings;
			$maintenance 	= !empty( $theme_settings['maintenance'] ) ? $theme_settings['maintenance'] : false;
			$preloader 		= !empty( $theme_settings['site_loader'] ) ? $theme_settings['site_loader'] : false;
			$loader_type	= !empty( $theme_settings['loader_type'] ) ? $theme_settings['loader_type'] : 'default';
			$loader_image	= !empty( $theme_settings['loader_image']['url'] ) ? $theme_settings['loader_image']['url'] : '';
			
            if ( empty( $maintenance ) || $maintenance === false) {
                if ( !empty( $preloader )) {
                    if ( !empty( $preloader ) && $loader_type === 'default' ) { ?>
                        <div class="preloader-outer">
                            <div class="dc-preloader-holder">
                                <div class="dc-loader"></div>
                            </div>
                        </div>
                        <?php
                    } elseif ( !empty( $preloader ) && $loader_type === 'custom' && !empty( $loader_image ) ) { ?>
                        <div class="preloader-outer">
							<div class="dc-preloader-holder">
								<div class="dc-loader">
									<img width="100" src="<?php echo esc_url($loader_image); ?>" alt="<?php esc_attr_e('loader', 'doctreat'); ?>" />
								</div>
							</div>
                       </div>
                        <?php
                    }
                }
            }
        }
		
		/**
         * @Prepare headers
         * @return {}
         * @author amentotech
         */
        public function doctreat_prepare_search() { 
			
			global $theme_settings,$post;
			
			$search_result_page	= !empty( $theme_settings['search_result_page'] ) ? $theme_settings['search_result_page'] : '';
			$search_settings	= !empty( $theme_settings['search_form'] ) ? $theme_settings['search_form'] : '';
			$search_page		= doctreat_get_search_page('search_result_page');
			$show_home			= !empty( $theme_settings['hide_home_page'] ) ? $theme_settings['hide_home_page'] : '';
			$orderby 			= !empty( $_GET['orderby']) ? $_GET['orderby'] : '';
			$order 				= !empty( $_GET['order']) ? $_GET['order'] : 'ASC';
			$searchby			= !empty($theme_settings['search_type']) ? $theme_settings['search_type'] : '';
			$system_access		= !empty( $theme_settings['system_access'] ) ? $theme_settings['system_access'] : '';
			$is_search_page		= 'none';
			
			if(!empty($search_result_page) && !empty($post->ID) && ($search_result_page == $post->ID) ){
				$is_search_page = 'block';
			}
			
			$display			= 'none';
			if(empty($searchby) || $searchby === 'both' && empty($system_access) ){
				$display	='block';
			}
						
			$post_name 			= doctreat_get_post_name();
			if ( apply_filters('doctreat_get_domain',false) === true && $post_name === 'home-page-2' ) {
				return;
			}
			
			if( !empty($search_settings) ){ 
				if( !is_front_page() || ( is_front_page() && !empty( $show_home ))) {?>
				<div class="dc-innerbanner-holder dc-haslayout dc-open dc-opensearchs">
					<form action="<?php echo esc_url( $search_page );?>" method="get" id="search_form">
						<div class="container">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12">
									<div class="dc-innerbanner">
										<div class="dc-formtheme dc-form-advancedsearch dc-innerbannerform">
											<fieldset>
												<div class="form-group">
													<?php do_action('doctreat_get_search_text_field');?>
												</div>
												<div class="form-group">
													<div class="dc-select">
														<?php do_action('doctreat_get_search_locations');?>
													</div>
												</div>
												<div class="dc-btnarea">
													<input type="submit" class="dc-btn" value="<?php esc_attr_e('Search','doctreat');?>">
												</div>
											</fieldset>
										</div>
										<a href="javascript:;" class="dc-docsearch"><span class="dc-advanceicon"><i></i> <i></i> <i></i></span><span><?php esc_html_e('Advanced','doctreat');?> <br><?php esc_html_e('Search','doctreat');?></span></a>
									</div>
								</div>
							</div>
						</div>
						<div class="dc-advancedsearch-holder" style="display: <?php echo esc_attr($is_search_page);?>;">
							<div class="container">
								<div class="row">
									<div class="col-12 col-sm-12 col-md-12 col-lg-12">
										<div class="dc-advancedsearchs">
											<div class="dc-formtheme dc-form-advancedsearchs">
												<fieldset>
													<div class="form-group" style="display: <?php echo esc_attr($display);?>;">
														<div class="dc-select">
															<?php do_action('doctreat_get_search_type');?>
														</div>
													</div>
													<div class="form-group">
														<div class="dc-select">
															<?php do_action('doctreat_get_search_speciality');?>
														</div>
													</div>
													<div class="form-group">
														<div class="dc-select" id="search_services">
															<?php do_action('doctreat_get_search_services');?>
														</div>
													</div>
													<div class="form-group">
														<div class="dc-select" id="search_services">
															<?php 
											                    $args = array(
											                        'show_option_all'   => __( 'Select a Language' ), 
											                        'orderby'           => 'name', 
											                        'order'             => 'ASC',
											                        'show_count'        => 1,
											                        'hide_empty'        => 1, 
											                        'echo'              => 0,
											                        'name'              => 'camp_languages', 
											                        'id'                => '',
											                        'class'                => '',
											                        'hierarchical'      => true,
											                        'depth'             => 1,
											                        'taxonomy'          => 'languages',
											                        'hide_if_empty'     => true, 
											                        'value_field'       => 'slug',
											                    );

											                    // Y-a-t'il un Lieu actuellement sélectionnée ?
											                    if ( $_GET['camp_languages'] 
											                        && (term_exists( $_GET['camp_languages'] , 'languages' ) ) )  {
											                        $args['selected'] = $_GET['camp_languages'] ;
											                    }

											                    $list = wp_dropdown_categories( $args );

											                    // Afficher la liste s'il existe des villes associées à des contenus
											                    if ( $list ) {
											                        echo $list;
											                } ?>
														</div>
													</div>
													<div class="form-group">
														<div class="dc-select" id="search_services">
															<select name="camp_kids_f" id="" class="">
											                    <option value=""><?php _e( 'Kids Friendly','camp' ); ?></option>
											                            <?php
											                            // Valeur antiérieure ?
											                            $kids = $_GET['camp_kids_f'];

											                            echo '<option value=1 '. selected( 1, $kids, false ) . '>YES</option>
											                                <option value=0'. selected( 0, $prix, false ) . '>NO</option>            

											                            ';
											                                  
											                             ?>
											                </select>
														</div>
													</div>
													<input type="hidden" name="orderby" class="search_orderby" value="<?php echo esc_attr( $orderby );?>">
													<input type="hidden" name="order" class="search_order" value="<?php echo esc_attr( $order );?>">
													<div class="dc-btnarea">
														<a href="<?php echo esc_url( $search_page );?>" class="dc-btn dc-resetbtn"><?php esc_html_e('Reset Filters','doctreat');?></a>
													</div>
												</fieldset>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<?php
				}
			}
         }

        /**
         * @Prepare headers
         * @return {}
         * @author amentotech
         */
        public function doctreat_do_process_headers() {
            global $current_user,$theme_settings;
            $loaderDisbale = '';
			$maintenance 	= !empty( $theme_settings['maintenance'] ) ? $theme_settings['maintenance'] : false;
            $post_name 		= doctreat_get_post_name();
			
            if (( isset($maintenance) && $maintenance == true && !is_user_logged_in() ) || $post_name === "coming-soon"
            ) {
                $loaderDisbale = 'elm-display-none';
            }
			
            get_template_part('template-parts/template', 'comingsoon');

            //demo ready
			if ( apply_filters('doctreat_get_domain',false) === true ) {
				//do stuff here
			}
            $this->doctreat_do_process_header_v1();
			
        }

        /**
         * @Prepare header v1
         * @return {}
         * @author amentotech
         */
        public function doctreat_do_process_header_v1() {
            global $theme_settings;
			$header_type 		= !empty( $theme_settings['header_type'] ) ? $theme_settings['header_type'] : '';
			$dashboard_search 	= !empty( $theme_settings['dashboard_search'] ) ? $theme_settings['dashboard_search'] : '';


			if( !empty( $header_type )  && $header_type === 'header_1' ) {
				$topbar_h1	= !empty( $theme_settings['topbar_h1'] ) ? $theme_settings['topbar_h1'] : '';
				if( !empty( $topbar_h1 ) ) {
					$em_title	= !empty( $theme_settings['em_text'] ) ? $theme_settings['em_text'] : '';
					$em_phone	= !empty( $theme_settings['em_phone'] ) ? $theme_settings['em_phone'] : '';
					$socials	= !empty( $theme_settings['social_icons'] ) ? $theme_settings['social_icons'] : array();
				} else {
					$em_title	= '';
					$em_phone	= '';
					$socials	= array();
				}
			}
			
			$lists 			= array();
			if( function_exists( 'doctreat_list_socila_media') ) {
				$lists 			= doctreat_list_socila_media();
			}
			
			$classe 		= is_page_template('directory/dashboard.php') ? 'dc-header-dashboard' : '';
			$classe_header	= is_page_template('directory/dashboard.php') ? 'container-fluid' : 'container';
			$logo	= !empty( $theme_settings['main_logo'] ) ? $theme_settings['main_logo'] : array();
			$logo	= !empty( $logo['url'] ) ? $logo['url'] : get_template_directory_uri() . '/images/logo_header.svg';

			ob_start();
            ?>
            <header id="dc-header" class="dc-header dc-haslayout <?php echo esc_attr( $classe );?>">
            	<?php if( !empty( $topbar_h1 ) && !is_page_template('directory/dashboard.php') ) { ?>
					<div class="dc-topbar">
						<div class="container">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12">
									<?php if( !empty( $em_title ) || !empty( $em_phone ) ) { ?>
										<div class="dc-helpnum">
											<?php if( !empty( $em_title ) ) { ?>
												<span><?php echo esc_html( $em_title );?></span>
											<?php } ?>
											<?php if( !empty( $em_phone ) ) { ?>
												<a href="tel:<?php echo esc_attr($em_phone);?>">+<?php echo esc_html( $em_phone );?></a>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if( !empty( $socials ) ) { ?>
										<div class="dc-rightarea">
											<ul class="dc-simplesocialicons dc-socialiconsborder">
												<?php
													foreach ($socials as $key => $value) {
														$social_class		= $lists[$key]['icon'];
														$social_name		= $lists[$key]['lable'];
														$social_link 		= !empty($value) ? $value : '';
														$social_main_class	= $lists[$key]['class'];
														
														if (!empty($social_link)) {?>
															<li class="<?php echo esc_attr($social_main_class); ?>"><a href="<?php echo esc_attr($social_link); ?>"><i class="<?php echo esc_attr($social_class); ?>"></i></a></li>
													<?php
														}
													}
												?>
											</ul>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="dc-navigationarea">
					<div class="<?php echo esc_attr( $classe_header );?>">
						<div class="row">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12">
								<div class="hidpi-logowrap">
									<?php $this->doctreat_prepare_logo($logo); ?>
									<?php
										if( !empty($dashboard_search) && is_page_template('directory/dashboard.php') ){
											$this->doctreat_header_search_form();
										}
									?>
									<div class="dc-rightarea">
										<nav id="dc-nav" class="dc-nav navbar-expand-lg">
											<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation','doctreat');?>">
												<i class="lnr lnr-menu"></i>
											</button>
											<div class="collapse navbar-collapse dc-navigation" id="navbarNav">
												<?php Doctreat_Prepare_Headers::doctreat_prepare_navigation('primary-menu', '', 'navbar-nav', '0'); ?>
											</div>
										</nav>
										<?php $this->doctreat_prepare_registration(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
           	
            <?php
			echo ob_get_clean();
		}
		
		 /**
         * @Prepare header search form
         * @return {}
         * @author amentotech
         */
        public function doctreat_header_search_form() {
			$search_page		= doctreat_get_search_page('search_result_page');
			ob_start();
		?>
		<div class="dc-headerform-holder">
			<div class="dc-search-headerform">
				<div class="closeform-holder">
					<a href="javascript:;" class="dc-removeform"><?php esc_html_e('Cancel','doctreat');?></a>
					<a href="javascript:;" class="dc-removeform"> <i class="ti-close"></i></a>
				</div>
				<form class="dc-formtheme dc-form-advancedsearch dc-headerform" action="<?php echo esc_url($search_page);?>" method="GET">
					<fieldset>
						<div class="form-group">
							<?php do_action('doctreat_get_search_text_field');?>
						</div>
						<div class="form-group">
							<div class="dc-select">
								<?php do_action('doctreat_get_search_locations');?>
							</div>
						</div>
						<div class="dc-formbtn">
							<a href="javascript:;" class="dc-header-serach-form"><i class="ti-arrow-right"></i></a>
						</div>
					</fieldset>
				</form>
			</div>
			<a href="javascript:;" class="dc-searchbtn"><i class="fa fa-search"></i></a>
		</div>	
		<?php
		echo ob_get_clean();
		}
		
        /**
         * @Prepare Logo
         * @return {}
         * @author amentotech
         */
        public function doctreat_prepare_logo($logo = '') {
            global $post, $woocommerce;
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			
            ob_start();
            ?>
            <strong class="dc-logo"> 
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php 
						if (!empty($logo)) {?>
							<img class="amsvglogo" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($blogname); ?>">
							<?php
						} else {
							echo esc_html($blogname);
						}
                    ?>
                </a> 
            </strong>
            <?php
            echo ob_get_clean();
        }

        /**
         * @Registration and Login
         * @return {}
         */
        public function doctreat_prepare_registration() {             
            do_action('doctreat_print_login_form');                
        }

        /**
         * @Main Navigation
         * @return {}
         */
        public static function doctreat_prepare_navigation($location = '', $id = 'menus', $class = '', $depth = '0') {

            if (has_nav_menu($location)) {
                $defaults = array(
                    'theme_location' 	=> $location,
                    'menu' 				=> '',
                    'container' 		=> 'ul',
                    'container_class' 	=> '',
                    'container_id' 		=> '',
                    'menu_class' 		=> $class,
                    'menu_id' 			=> $id,
                    'echo' 				=> false,
                    'fallback_cb' 		=> 'wp_page_menu',
                    'before' 			=> '',
                    'after' 			=> '',
                    'link_before' 		=> '',
                    'link_after' 		=> '',
                    'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth' 			=> $depth,
                );
                echo do_shortcode(wp_nav_menu($defaults));
            } else {
                $defaults = array(
                    'theme_location' 	=> $location,
                    'menu' 				=> '',
                    'container' 		=> 'ul',
                    'container_class' 	=> '',
                    'container_id' 		=> '',
                    'menu_class' 		=> $class,
                    'menu_id' 			=> $id,
                    'echo' 				=> false,
                    'fallback_cb' 		=> 'wp_page_menu',
                    'before' 			=> '',
                    'after' 			=> '',
                    'link_before' 		=> '',
                    'link_after' 		=> '',
                    'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth' 			=> $depth,
                );
                echo do_shortcode(wp_nav_menu($defaults));
            }
        }

    }

    new Doctreat_Prepare_Headers();
}