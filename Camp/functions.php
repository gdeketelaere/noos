<?php

/***************************************************************************************
  PARTIE CUSTOMIZE : Quelques Options du Thèmes camp
*/

function camp_customize($wp_customize){

    $wp_customize->add_panel( 'camp_panel_id', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'title'          => __('Options du Thème Camp', 'camp'),
        'description'    => __('Personnaliser quelques options du theme Camp', 'camp'),
    ) );



    $wp_customize->add_section( 'camp_options',
        array(
            'title'       => __( 'Les options du Thème', 'camp' ), //Visible title of section
            'priority'    => 35, //Determines what order this appears in
            'capability'  => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Les options du Thème', 'camp'), //Descriptive tooltip
            'panel'  => 'camp_panel_id',
        )
    );

    
    
    $wp_customize->add_setting('camp_api_google_map'); 
   
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'camp_api_google_map', array(
            'label'      => __('Clé API Google Map', 'camp'),
            'section'    => 'camp_options',
            'settings'   => 'camp_api_google_map')
        )
    );
    

    

}


add_action( 'customize_register' , 'camp_customize');

/***************************************************************************************
  PARTIE ENQUEU SCRIPTS ET STYLES : CHARGEMENT DES SCRIPTS ET STYLES PERSO
*/



function camp_enqueue_scripts() {

	$googleapi_key=esc_attr(get_theme_mod('camp_api_google_map'));

//CSS	
	
	wp_enqueue_style('camp-custom-style', get_stylesheet_directory_uri() . '/assets/css/camp.css','doctreat-style-css');

//JS
	wp_enqueue_script( 'camp-googleapi-js', 'https://maps.googleapis.com/maps/api/js?key='.$googleapi_key);


	wp_enqueue_script( 'camp-map-js', get_stylesheet_directory_uri().'/assets/js/camp-map.js', 'camp-googleapi-js');


	//ajax member - save video and kids friendly dashboard

	wp_register_script( 'camp_save_video', get_stylesheet_directory_uri() . '/assets/js/camp-save-video.js', array('jquery') );
	wp_register_script( 'camp_save_kids', get_stylesheet_directory_uri() . '/assets/js/camp-save-kids.js', array('jquery') );
	wp_register_script( 'camp_hospital_search', get_stylesheet_directory_uri() . '/assets/js/camp-hospital-search.js', array('jquery') );


	wp_localize_script( 'camp_save_video', 'camp_save_video_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'// WordPress AJAX
	) );
	wp_localize_script( 'camp_save_kids', 'camp_save_kids_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'// WordPress AJAX
	) );

	wp_enqueue_script( 'camp_save_video' );
 	wp_enqueue_script( 'camp_save_kids' );
 	wp_enqueue_script( 'camp_hospital_search' );


 	//ajax blog - load more button


	
	wp_register_script( 'camp_loadmore1', get_stylesheet_directory_uri() . '/assets/js/blog-load-more/camp-load-more1.js', array('jquery') );
	wp_register_script( 'camp_loadmore2', get_stylesheet_directory_uri() . '/assets/js/blog-load-more/camp-load-more2.js', array('jquery') );
	wp_register_script( 'camp_loadmore3', get_stylesheet_directory_uri() . '/assets/js/blog-load-more/camp-load-more3.js', array('jquery') );
	
	wp_localize_script( 'camp_loadmore1', 'camp_loadmore_params1', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
	) );
	wp_localize_script( 'camp_loadmore2', 'camp_loadmore_params2', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
	) );
	wp_localize_script( 'camp_loadmore3', 'camp_loadmore_params3', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
	) );
 
 	wp_enqueue_script( 'camp_loadmore1' );
 	wp_enqueue_script( 'camp_loadmore2' );
 	wp_enqueue_script( 'camp_loadmore3' );
 	


 	// ajax blog - search

	wp_register_script( 'camp_search_last_posts', get_stylesheet_directory_uri() . '/assets/js/blog-search/camp-search-last-post.js', array('jquery') );
	wp_register_script( 'camp_search_top_read', get_stylesheet_directory_uri() . '/assets/js/blog-search/camp-search-top-read.js', array('jquery') );
	wp_register_script( 'camp_search_more_posts', get_stylesheet_directory_uri() . '/assets/js/blog-search/camp-search-more.js', array('jquery') );
 
 
	wp_localize_script( 'camp_search_last_posts', 'camp_search_last_posts_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'	
	) );
	wp_localize_script( 'camp_search_top_read', 'camp_search_top_read_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'// WordPress AJAX
	) );
	wp_localize_script( 'camp_search_more_posts', 'camp_search_more_posts_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'// WordPress AJAX
	) );
 
 	wp_enqueue_script( 'camp_search_last_posts' );
 	wp_enqueue_script( 'camp_search_top_read' );
 	wp_enqueue_script( 'camp_search_more_posts' );


 	wp_register_script( 'camp-see-more', get_stylesheet_directory_uri() . '/assets/js/camp-see-more.js', array('jquery') );
	
	wp_localize_script( 'camp-see-more', 'camp_see_more_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
	) );
	
	wp_enqueue_script( 'camp-see-more' );
}

add_action( 'wp_enqueue_scripts', 'camp_enqueue_scripts' );

/***************************************************************************************
  PARTIE CPT : TYPE DE POSTS PERSO
*/

function camp_register_programme() {

	register_taxonomy(
	  'symtomes',
	  array('doctors','hospitals'),
	  array(
		'label' => 'Symtômes',
		'labels' => array(
		'name' => 'Symtômes',
		'singular_name' => 'Symtôme',
		'all_items' => 'Symtômes',
		'edit_item' => 'Éditer le Symtôme',
		'view_item' => 'Voir le Symtôme',
		'update_item' => 'Mettre à jour le Symtômes',
		'add_new_item' => 'Ajouter un Symtôme',
		'new_item_name' => 'Nouveau Symtôme',
		'search_items' => 'Rechercher parmi les Symtômes',
		'popular_items' => 'Symtômes les plus utilises'
	  ),
	  'show_admin_column' => true,
	  'show_in_rest' => true,
	  'hierarchical' => true
	  )
	);

	/**
	 * Post Type: Troubles.
	 
	*/
	$labels = array(
		"name" => __( "Camp Member", "camp" ),
		"singular_name" => __( "Camp Member", "camp" ),
	);

	$args = array(
		"label" => __( "Camp Member", "camp" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "camp_member", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail",'excerpt','comments' ),
	);

	/**
	 * Post Type: Troubles.
	 
	*/
	$labels2 = array(
		"name" => __( "Centers", "camp" ),
		"singular_name" => __( "Centers", "camp" ),
	);

	$args2 = array(
		"label" => __( "Centers", "camp" ),
		"labels" => $labels2,		
	);

	register_taxonomy_for_object_type('symtomes', 'post');
	register_taxonomy_for_object_type('languages', 'post');
	register_taxonomy_for_object_type('languages', 'hospitals');

	register_post_type( "camp_member", $args );
	//register_post_type( "hospitals", $args2 );
	



	
	
}
add_action( 'init', 'camp_register_programme' );

add_filter('register_post_type_args', 'camp_rewrite_hospitals', 10, 2);
function camp_rewrite_hospitals($args, $post_type){
 
    if ($post_type == 'hospitals'){
        
    }
 
    return $args;
}

/***************************************************************************************
  PARTIE Profil Praticien
*/

// Engitrer l'api keys ACF google Map

function camp_acf_google_map_api( $api ){
    $api['key'] = esc_attr(get_theme_mod('camp_api_google_map'));
    return $api;
}
add_filter('acf/fields/google_map/api', 'camp_acf_google_map_api');

$location = get_field('camp_localisation_google_map_doctors');
if( $location ): ?>
    <div class="acf-map" data-zoom="16">
        <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
    </div>
<?php endif;

function camp_display_location_address ($location) {

	if( $location ) {

	    // Loop over segments and construct HTML.
	    $address = '';
	    foreach( array('street_number', 'street_name', 'city', 'state', 'post_code', 'country') as $i => $k ) {
	        if( isset( $location[ $k ] ) ) {
	            $address .= sprintf( '<span class="segment-%s">%s</span>, ', $k, $location[ $k ] );
	        }
	    }

	    // Trim trailing comma.
	    $address = trim( $address, ', ' );	    

	    // Display HTML.
	    return $address ;
	}

}

//Spécialités et symtomes du profil praticien

function camp_get_terms_doctors($post_id='', $taxonomy='specialities', $show_number=1){
		
	if( !empty($post_id) ) {
		$terms	= wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'all' ) );
		ob_start();
		
		if(!empty($terms) && !is_wp_error($terms)){
			
			$sp_count		= 0;
			$tipsco_html	= '';
			$total_sp_count	= !empty($terms) ? count($terms) : 0;
			$remining_count	= $total_sp_count - $show_number;
			?>
			<div class="dc-doc-specilities-tag">
				<?php foreach( $terms as $term ){

					$term_url	= get_term_link($term);
				
					if( $sp_count<$show_number ){ ?>
						<a href="<?php echo esc_url($term_url);?>"><?php echo esc_html($term->name);?></a>
					<?php } else { 
						$tipsco_html	.="<a href='".esc_url($term_url)."' >".esc_html($term->name)."</a>";
					}
				
					$sp_count++;
				}

				if($total_sp_count>$show_number){
				?>
					<a href="javascript:;" class="dc-specilites-tipso dc-tipso" data-tipso="<?php echo do_shortcode( $tipsco_html );?>" data-id="<?php echo intval($post_id);?>">+<?php echo intval($remining_count);?><i class="fa fa-caret-down"></i></a>
				<?php }?>
			</div>
			<?php
		}
		
		echo ob_get_clean();
			
	}
}
add_action( 'camp_specilities_list', 'camp_get_terms_doctors',10,2 );

function camp_get_terms_post($post_id='', $taxonomy='category', $show_number=5){
		
	if( !empty($post_id) ) {
		$terms	= wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'all' ) );
		ob_start();
		
		if(!empty($terms) && !is_wp_error($terms)){
			
			$sp_count		= 0;
			$tipsco_html	= '';
			$total_sp_count	= !empty($terms) ? count($terms) : 0;
			$remining_count	= $total_sp_count - $show_number;
			?>
			<div class="dc-doc-specilities-tag">
				<?php foreach( $terms as $term ){

					$term_url	= get_term_link($term);
				
					if( $sp_count<$show_number ){ ?>
						<a href="<?php echo esc_url($term_url);?>"><?php echo esc_html($term->name);?></a>
					<?php } else { 
						$tipsco_html.="<a href='".esc_url($term_url)."' >".esc_html($term->name)."</a>";
					}
				
					$sp_count++;
				}

				if($total_sp_count>$show_number){
				?>
					<a href="javascript:;" class="dc-specilites-tipso dc-tipso" data-tipso="<?php echo do_shortcode( $tipsco_html );?>" data-id="<?php echo intval($post_id);?>">+<?php echo intval($remining_count);?><i class="fa fa-caret-down"></i></a>
				<?php }?>
			</div>
			<?php
		}
		
		echo ob_get_clean();
			
	}
}
add_action( 'camp_terms_post_list', 'camp_get_terms_post',10,2 );

// créer un service dashboard
function camp_create_services () {

	if ( !is_admin() ) { 
		if (
        isset( $_POST['camp_create_service'] )
        && wp_verify_nonce( $_POST['camp_create_service'], 'action_camp_create_service' )
		) {

			
			$post_id = htmlspecialchars($_POST['camp_post_id_service']);

			$speciality=(!empty($_POST['camp_speciality_service'])) ? htmlspecialchars($_POST['camp_speciality_service']) : "" ;

			$speciality_object=get_term_by('slug', $speciality, 'specialities');			
			
			$title=htmlspecialchars($_POST['camp_title_service']);			
			

			if ($speciality_object!==false) {				

				$create_spec=wp_insert_term(
			    $title,   // the term 
			    'services'
				);
				if (!is_wp_error($create_spec)) {

					$create_spec=(array)$create_spec;
				
				

					//wp_set_object_terms( $post_id, $create_spec['term_id'], 'services' );

					$speciality_id=(int)$speciality_object->term_id;

					add_term_meta( $create_spec['term_id'], "speciality" , $speciality_id );

					$att = camp_update_attachment('camp_image_service',$create_spec['term_id']);
					update_field('camp_photo_service',$att['attach_id'],'services_'.$create_spec["term_id"]);
					//update_field('camp_temps_service',$time,'services_'.$create_spec["term_id"]);

					$url = add_query_arg('create_service', 'success', wp_get_referer());
					wp_safe_redirect($url);
					exit();
					# code...
				}		
				else
				{
					$url = add_query_arg('create_service', 'error', wp_get_referer());
					wp_safe_redirect($url);
					exit();
				}
			}
			else
			{

				$url = add_query_arg('create_service', 'error', wp_get_referer());
				wp_safe_redirect($url);
				exit();
			}			

		}
	}	

}

add_action('template_redirect', 'camp_create_services');

// Update attachment file
function camp_update_attachment( $f, $pid){

	wp_update_attachment_metadata( $pid, $f );

	if( !empty( $_FILES[$f]['name'] )) {

		if ( !function_exists('wp_handle_upload') ) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}

			// Move file to media library
			$movefile = wp_handle_upload( $_FILES[$f], array('test_form' => false) );
		
		if( !$movefile || isset( $movefile['error'] ) ) {
			return false;
		}

		else

		{

			$wp_upload_dir = wp_upload_dir();
			$filetype = wp_check_filetype( $_FILES[$f]['name'], array(
		      'jpg|jpeg' => 'image/jpeg',	  
		      'png' => 'image/png',
		    ) );

			if ($filetype['type']) {
			
				$attachment = array(
					'guid'           => $movefile['url'], 					
					'post_parent' 	 => $pid,
					'post_title'     => $movefile['filename'],
					'post_type' 	 => 'attachment',
					'post_content'   => '',
					'post_status'    => 'inherit',
					'post_mime_type' => $filetype['type'],
				);

			  	$attach_id = wp_insert_attachment( $attachment, $movefile['file'] );	

				return array(
				  'pid' =>$pid,
				  'url' =>$movefile['url'],
				  'file'=>$movefile,
				  'attach_id'=>$attach_id
				);
			}		

		}	 


	}
		
	

}

function camp_get_terms_slug($post_id, $taxonomy) {

	$terms = get_the_terms( $post_id, $taxonomy );
	
	$tab_slug=[];


	if ( !empty( $terms ) && !is_wp_error( $terms ) ){
	    foreach ( $terms as $term ) {	    	
	    	
	    	$tab_slug[]=$term->slug;
	    	

	    }
	}
	return $tab_slug;   
	
}

/*function camp_get_tags_slug($post_id) {

	$tags = get_the_tags( $post_id );
	
	$tab_slug=[];


	if ( !empty( $tags ) && !is_wp_error( $tags ) ){
	    foreach ( $tags as $tag ) {	    	
	    	
	    	$tab_slug[]=$tag->slug;
	    	

	    }
	}
	return $tab_slug;   
	
}

function camp_get_intersect_tags_terms($post_id, $taxonomy='specialities') {

	$terms=camp_get_terms_slug($taxonomy);
	$tags=camp_get_tags_slug($post_id);
	$result=array();

	if (!empty($terms) && !empty($tags) ) {

		$result = array_intersect($terms, $tags);

	}

	return $result;	 
	
}*/

function camp_nb_pages ($query){
	$numberposts = $query->found_posts;
	$nb_pages_total=1;

	if ($numberposts>6) {
		$numberp=$numberposts-6;
	 	$mod=($numberposts-6)%9;
	 	$nbpages_temp=intdiv($numberposts, 9);

	 	if ($nbpages_temp>0 && $mod>=1) {
	 		$nb_pages_total+=$nbpages_temp;
	 	}
	 	elseif ($nbpages_temp==0 && $mod>=1) {
	 		$nb_pages_total=2;
	 	}

	}
	return $nb_pages_total;
}

function camp_save_video_ajax_handler(){
 
	
	$url_video = $_POST['url_video'] ;
	$id_user_video = $_POST['id_user_video'] ;
	$type_user = $_POST['type_user_video'] ;
	$v=array();
	$v['verdict']='';

	if (!empty($type_user) && !empty($url_video) && !empty($id_user_video)) {

		update_field('camp_video_youtube_'.$type_user, $url_video, $id_user_video);
		$v['verdict']=1;

	}

	echo json_encode($v);
	
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_campsavevideo', 'camp_save_video_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_campsavevideo', 'camp_save_video_ajax_handler'); // wp_ajax_nopriv_{action}


function camp_save_kids_ajax_handler(){
 
	
	$kids = (!empty($_POST['kids'])) ? $_POST['kids'] : false ;
	$id_user_kids = $_POST['id_user_kids'] ;
	$type_user = $_POST['type_user_kids'] ;
	$v=array();
	$v['verdict']='';

	if (!empty($type_user) && !empty($id_user_kids)) {

		if ($type_user=='doctors') {
			update_field('camp_kids_f', $kids, $id_user_kids);
			$v['verdict']=1;
		}else{
			update_field('camp_kids_f_hospitals', $kids, $id_user_kids);
			$v['verdict']=1;
		}

	}

	echo json_encode($v);
	
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_campsavekids', 'camp_save_kids_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_campsavekids', 'camp_save_kids_ajax_handler'); // wp_ajax_nopriv_{action}



/***************************************************************************************
  PARTIE BLOG - Load More
*/

function camp_loadmore_ajax_handler_1(){
 
	// prepare our arguments for the query	
 
	$args = array('post_type' => 'post', 'post_status' => 'publish');
	
	if( isset( $_POST['speciality'] ) || isset( $_POST['symtome'] )  || isset($_POST['language'])  ) :
		
		$args['tax_query'] = array( 'relation'=>'AND' );

		if (isset( $_POST['speciality'] ) && !empty($_POST['speciality'])) {
		
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $_POST['speciality']
				)
			);
		}

		if (isset( $_POST['symtome'] ) && !empty($_POST['symtome'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'symtomes',
					'field' => 'slug',
					'terms' => $_POST['symtome']
				)
			);
		}

		if (isset( $_POST['language'] ) && !empty($_POST['language'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'languages',
					'field' => 'slug',
					'terms' => $_POST['language']
				)
			);
		}

	endif;

	$hidden_page_1 = $_POST['hidden_page_1'] + 1; 
	$offset=(6+($hidden_page_1-2)*9)+1;
	$args['offset']=$offset;
	$loop = new WP_Query($args);
	$count=0; 
 
	if( $loop->have_posts() ) :
 
		// run the loop
		while( $loop->have_posts() ): $loop->the_post();
 
			$count++;
			if ($count<=9) :			
				
				$width 		= 1140;
				$height 	= 400;
				$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
				$stickyClass = '';
				
			
				if (is_sticky()) {
					$stickyClass = 'sticky';
				}
			
				$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
				?>                         
				<article class="dc-article <?php echo esc_attr($stickyClass);?> col-12 col-sm-12 col-md-4 col-xl-4 col-xl-4">
					<div class="dc-articlecontent">
						<?php if( !empty( $thumbnail ) ){?>
							<figure class="dc-classimg">
								<?php doctreat_get_post_thumbnail($thumbnail,get_the_ID(),'linked');?>
							</figure>
						<?php }?>
						
						<div class="dc-title">
							<h3><?php doctreat_get_post_title(get_the_ID()); ?></h3>
						</div>
					    <div class="dc-description">
							<p><?php echo doctreat_prepare_excerpt(350); ?></p>
							<?php if(!empty( $categries )){?>
								<div class="dc-tagslist tagcloud d-flex dc-tags1 flex-wrap"><span><?php esc_html_e('Categories','doctreat');?>:&nbsp;</span><?php echo do_shortcode($categries);?></div>
							<?php }?>
							<?php
								if( function_exists('doctreat_get_article_meta') ){
									do_action('doctreat_get_article_meta',get_the_ID());
								}
							?>
						</div>
						<?php if (is_sticky()) {?>
							<span class="sticky-wrap dc-themetag dc-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Featured','doctreat');?></span>
						<?php }?>
					</div>
				</article>
			<?php endif; 
		endwhile;
		$max_page_1=camp_nb_pages($loop);?>
		<input type="hidden" id="hidden_page_1" value=<?php echo $hidden_page_1;?>>
		<input type="hidden"  id="max_page_1" value=<?php echo $max_page_1;?>>
		<?php 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_loadmore1', 'camp_loadmore_ajax_handler_1'); 
add_action('wp_ajax_nopriv_loadmore1', 'camp_loadmore_ajax_handler_1');

function camp_loadmore_ajax_handler_2(){
 
	// prepare our arguments for the query	
 
	$args = array('post_type' => 'post', 'post_status' => 'publish', 'meta_key' => 'set_blog_view', 'orderby' => 'meta_value_num', 'order' => 'DESC');
	
	if( isset( $_POST['speciality'] ) || isset( $_POST['symtome'] )  || isset($_POST['language'])  ) :
		
		$args['tax_query'] = array( 'relation'=>'AND' );

		if (isset( $_POST['speciality'] ) && !empty($_POST['speciality'])) {
		
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $_POST['speciality']
				)
			);
		}

		if (isset( $_POST['symtome'] ) && !empty($_POST['symtome'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'symtomes',
					'field' => 'slug',
					'terms' => $_POST['symtome']
				)
			);
		}

		if (isset( $_POST['language'] ) && !empty($_POST['language'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'languages',
					'field' => 'slug',
					'terms' => $_POST['language']
				)
			);
		}

	endif;

	$hidden_page_2 = $_POST['hidden_page_2'] + 1; 
	$offset=(6+($hidden_page_2-2)*9)+1;
	$args['offset']=$offset;
	$loop = new WP_Query($args);
	$count=0; 
 
	if( $loop->have_posts() ) :
 
		// run the loop
		while( $loop->have_posts() ): $loop->the_post();
 
			$count++;
			if ($count<=9) :			
				
				$width 		= 1140;
				$height 	= 400;
				$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
				$stickyClass = '';
				
			
				if (is_sticky()) {
					$stickyClass = 'sticky';
				}
			
				$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
				?>                         
				<article class="dc-article <?php echo esc_attr($stickyClass);?> col-12 col-sm-12 col-md-4 col-xl-4 col-xl-4">
					<div class="dc-articlecontent">
						<?php if( !empty( $thumbnail ) ){?>
							<figure class="dc-classimg">
								<?php doctreat_get_post_thumbnail($thumbnail,get_the_ID(),'linked');?>
							</figure>
						<?php }?>
						
						<div class="dc-title">
							<h3><?php doctreat_get_post_title(get_the_ID()); ?></h3>
						</div>
					    <div class="dc-description">
							<p><?php echo doctreat_prepare_excerpt(350); ?></p>
							<?php if(!empty( $categries )){?>
								<div class="dc-tagslist tagcloud d-flex dc-tags1 flex-wrap"><span><?php esc_html_e('Categories','doctreat');?>:&nbsp;</span><?php echo do_shortcode($categries);?></div>
							<?php }?>
							<?php
								if( function_exists('doctreat_get_article_meta') ){
									do_action('doctreat_get_article_meta',get_the_ID());
								}
							?>
						</div>
						<?php if (is_sticky()) {?>
							<span class="sticky-wrap dc-themetag dc-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Featured','doctreat');?></span>
						<?php }?>
					</div>
				</article>
			<?php endif; 
		endwhile;
		$max_page_2=camp_nb_pages($loop);?>
		<input type="hidden" id="hidden_page_2" value=<?php echo $hidden_page_2;?>>
		<input type="hidden"  id="max_page_2" value=<?php echo $max_page_2;?>>
		<?php 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_loadmore2', 'camp_loadmore_ajax_handler_2'); 
add_action('wp_ajax_nopriv_loadmore2', 'camp_loadmore_ajax_handler_2');

function camp_loadmore_ajax_handler_3(){
 
	// prepare our arguments for the query	
 
	$args = array('post_type' => 'post', 'post_status' => 'publish', 'order' => 'ASC');
	
	if( isset( $_POST['speciality'] ) || isset( $_POST['symtome'] )  || isset($_POST['language'])  ) :
		
		$args['tax_query'] = array( 'relation'=>'AND' );

		if (isset( $_POST['speciality'] ) && !empty($_POST['speciality'])) {
		
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $_POST['speciality']
				)
			);
		}

		if (isset( $_POST['symtome'] ) && !empty($_POST['symtome'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'symtomes',
					'field' => 'slug',
					'terms' => $_POST['symtome']
				)
			);
		}

		if (isset( $_POST['language'] ) && !empty($_POST['language'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'languages',
					'field' => 'slug',
					'terms' => $_POST['language']
				)
			);
		}

	endif;

	$hidden_page_3 = $_POST['hidden_page_3'] + 1; 
	$offset=(6+($hidden_page_3-2)*9)+1;
	$args['offset']=$offset;
	$loop = new WP_Query($args);
	$count=0; 
 
	if( $loop->have_posts() ) :
 
		// run the loop
		while( $loop->have_posts() ): $loop->the_post();
 
			$count++;
			if ($count<=9) :			
				
				$width 		= 1140;
				$height 	= 400;
				$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
				$stickyClass = '';
				
			
				if (is_sticky()) {
					$stickyClass = 'sticky';
				}
			
				$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
				?>                         
				<article class="dc-article <?php echo esc_attr($stickyClass);?> col-12 col-sm-12 col-md-4 col-xl-4 col-xl-4">
					<div class="dc-articlecontent">
						<?php if( !empty( $thumbnail ) ){?>
							<figure class="dc-classimg">
								<?php doctreat_get_post_thumbnail($thumbnail,get_the_ID(),'linked');?>
							</figure>
						<?php }?>
						
						<div class="dc-title">
							<h3><?php doctreat_get_post_title(get_the_ID()); ?></h3>
						</div>
					    <div class="dc-description">
							<p><?php echo doctreat_prepare_excerpt(350); ?></p>
							<?php if(!empty( $categries )){?>
								<div class="dc-tagslist tagcloud d-flex dc-tags1 flex-wrap"><span><?php esc_html_e('Categories','doctreat');?>:&nbsp;</span><?php echo do_shortcode($categries);?></div>
							<?php }?>
							<?php
								if( function_exists('doctreat_get_article_meta') ){
									do_action('doctreat_get_article_meta',get_the_ID());
								}
							?>
						</div>
						<?php if (is_sticky()) {?>
							<span class="sticky-wrap dc-themetag dc-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Featured','doctreat');?></span>
						<?php }?>
					</div>
				</article>
			<?php endif; 
		endwhile;
		$max_page_3=camp_nb_pages($loop);?>
		<input type="hidden" id="hidden_page_3" value=<?php echo $hidden_page_3;?>>
		<input type="hidden"  id="max_page_3" value=<?php echo $max_page_3;?>>
		<?php 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_loadmore3', 'camp_loadmore_ajax_handler_3'); 
add_action('wp_ajax_nopriv_loadmore3', 'camp_loadmore_ajax_handler_3');


/***************************************************************************************
  PARTIE BLOG - Search Filters
*/  


function camp_search_last_posts_ajax_handler(){?>

	<div class="blog-list-view-template" id="camp-blog-1" style="display: flex; flex-wrap: wrap; justify-content: center;"><?php

		$args = array('post_type' => 'post', 'post_status' => 'publish');
	 
		if( isset( $_POST['speciality'] ) || isset( $_POST['symtome'] )  || isset($_POST['language'])  ) :
			
			$args['tax_query'] = array( 'relation'=>'AND' );

			if (isset( $_POST['speciality'] ) && !empty($_POST['speciality'])) {
			
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $_POST['speciality']
					)
				);
			}

			if (isset( $_POST['symtome'] ) && !empty($_POST['symtome'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'symtomes',
						'field' => 'slug',
						'terms' => $_POST['symtome']
					)
				);
			}

			if (isset( $_POST['language'] ) && !empty($_POST['language'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'languages',
						'field' => 'slug',
						'terms' => $_POST['language']
					)
				);
			}

		endif;

		$loop = new WP_Query($args);
		$count=0;

	 
		if( $loop->have_posts() ) :
	 
			// run the loop
			while ($loop->have_posts()) : $loop->the_post();
				$count++;
				if ($count<=6) :				
					
					$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
					$stickyClass = '';

					$post_views			= get_post_meta(get_the_ID(),'set_blog_view',true);
					$post_views			= !empty( $post_views ) ? $post_views : 0;
					$post_likes			= get_post_meta(get_the_ID(),'post_likes',true);
					$post_likes			= !empty( $post_likes ) ? $post_likes : 0;

					$post_comments		= get_comments_number(get_the_ID());
					$post_comments		= !empty( $post_comments ) ? $post_comments : 0 ;

				
					if (is_sticky()) {
						$stickyClass = 'sticky';
					}
				
					$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
					?>                         
					<div class="col-12 col-sm-12 col-md-4 col-xl-4 col-xl-4">
						<div class="dc-article">
							<figure class="dc-articleimg">
								<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
								<figcaption>
									<div class="dc-articlesdocinfo">
										<?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
										<span><?php echo get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) );?></span>				
									</div>
								</figcaption>
							</figure>
							<div class="dc-articlecontent">
								<div class="dc-title dc-ellipsis dc-titlep">
									<?php if(!empty( $categries )){?>
										<?php echo do_shortcode($categries);?>
									<?php }?>
																					
									<h3><a href="<?php the_permalink();?>"><?php doctreat_get_post_title(get_the_ID()); ?></a></h3>
									<span class="dc-datetime"><?php doctreat_get_post_date($post->ID); ?></span>
								</div>
								
								<ul class="dc-moreoptions">
									<li class="dcget-likes" data-key="642"><a href="javascript:;"><i class="ti-heart"></i><?php echo sprintf( _n( '%s Like', '%s Likes', $post_likes, 'doctreat' ), $post_likes );?></a></li>
									<li><a href="javascript:;"><i class="ti-eye"></i><?php echo sprintf( _n( '%s View', '%s Views', $post_views, 'doctreat' ), $post_views );?></a></li>
									<li><a href="javascript:;"><i class="ti-comment"></i><?php echo sprintf( _n( '%s Comment', '%s Comments', get_comments_number(get_the_ID()), 'doctreat' ), get_comments_number(get_the_ID()) );?></a></li>
								</ul>						
							</div>
						</div>
					</div>
			<?php endif;
			endwhile;
			$max_page_1=camp_nb_pages($query);?>
			<input type="hidden" id="hidden_page_1" value="1">
			<input type="hidden"  id="max_page_1" value=<?php echo $max_page_1;?>>
			<?php
			if ($count>=6):?>				
				<div class="theme-nav camp_loadmore1"><?php esc_html_e('Voir plus d\'articles','doctreat');?></div><?php
			endif;
			
		else :
			echo '<div id="notif_sb_1" style="text-align:center;" ><p style="color:red; font-size:1.3em;">No posts found !</p></div>';
		endif;
		?>
	</div><?php
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_camplastposts', 'camp_search_last_posts_ajax_handler'); 
add_action('wp_ajax_nopriv_camplastposts', 'camp_search_last_posts_ajax_handler');


function camp_search_top_read_ajax_handler(){?>

	<div class="blog-list-view-template" id="camp-blog-2" style="display: flex; flex-wrap: wrap; justify-content: center;"><?php

		$args = array('post_type' => 'post', 'post_status' => 'publish','meta_key' => 'set_blog_view', 'orderby' => 'meta_value_num', 'order' => 'DESC');
	 
		if( isset( $_POST['speciality'] ) || isset( $_POST['symtome'] )  || isset($_POST['language'])  ) :
			
			$args['tax_query'] = array( 'relation'=>'AND' );

			if (isset( $_POST['speciality'] ) && !empty($_POST['speciality'])) {
			
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $_POST['speciality']
					)
				);
			}

			if (isset( $_POST['symtome'] ) && !empty($_POST['symtome'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'symtomes',
						'field' => 'slug',
						'terms' => $_POST['symtome']
					)
				);
			}

			if (isset( $_POST['language'] ) && !empty($_POST['language'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'languages',
						'field' => 'slug',
						'terms' => $_POST['language']
					)
				);
			}

		endif;

		$loop = new WP_Query($args);
		$count=0;

	 
		if( $loop->have_posts() ) :
	 
			// run the loop
			while ($loop->have_posts()) : $loop->the_post();
				$count++;
				if ($count<=6) :				
					
					$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
					$stickyClass = '';

					$post_views			= get_post_meta(get_the_ID(),'set_blog_view',true);
					$post_views			= !empty( $post_views ) ? $post_views : 0;
					$post_likes			= get_post_meta(get_the_ID(),'post_likes',true);
					$post_likes			= !empty( $post_likes ) ? $post_likes : 0;

					$post_comments		= get_comments_number(get_the_ID());
					$post_comments		= !empty( $post_comments ) ? $post_comments : 0 ;

				
					if (is_sticky()) {
						$stickyClass = 'sticky';
					}
				
					$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
					?>                         
					<div class="col-12 col-sm-12 col-md-4 col-xl-4 col-xl-4">
						<div class="dc-article">
							<figure class="dc-articleimg">
								<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
								<figcaption>
									<div class="dc-articlesdocinfo">
										<?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
										<span><?php echo get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) );?></span>				
									</div>
								</figcaption>
							</figure>
							<div class="dc-articlecontent">
								<div class="dc-title dc-ellipsis dc-titlep">
									<?php if(!empty( $categries )){?>
										<?php echo do_shortcode($categries);?>
									<?php }?>
																					
									<h3><a href="<?php the_permalink();?>"><?php doctreat_get_post_title(get_the_ID()); ?></a></h3>
									<span class="dc-datetime"><?php doctreat_get_post_date($post->ID); ?></span>
								</div>
								
								<ul class="dc-moreoptions">
									<li class="dcget-likes" data-key="642"><a href="javascript:;"><i class="ti-heart"></i><?php echo sprintf( _n( '%s Like', '%s Likes', $post_likes, 'doctreat' ), $post_likes );?></a></li>
									<li><a href="javascript:;"><i class="ti-eye"></i><?php echo sprintf( _n( '%s View', '%s Views', $post_views, 'doctreat' ), $post_views );?></a></li>
									<li><a href="javascript:;"><i class="ti-comment"></i><?php echo sprintf( _n( '%s Comment', '%s Comments', get_comments_number(get_the_ID()), 'doctreat' ), get_comments_number(get_the_ID()) );?></a></li>
								</ul>						
							</div>
						</div>
					</div>
			<?php endif;
			endwhile;
			$max_page_2=camp_nb_pages($query);?>
			<input type="hidden" id="hidden_page_2" value="1">
			<input type="hidden"  id="max_page_2" value=<?php echo $max_page_2;?>>
			<?php
			if ($count>=6):?>				
				<div class="theme-nav camp_loadmore2"><?php esc_html_e('Voir plus d\'articles','doctreat');?></div><?php
			endif;
			
		else :
			echo '<div id="notif_sb_2" style="text-align:center;" ><p style="color:red; font-size:1.3em;">No posts found !</p></div>';
		endif;
		?>
	</div><?php
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_camptopread', 'camp_search_top_read_ajax_handler'); 
add_action('wp_ajax_nopriv_camptopread', 'camp_search_top_read_ajax_handler');

function camp_search_more_posts_ajax_handler(){?>

	<div class="blog-list-view-template" id="camp-blog-2" style="display: flex; flex-wrap: wrap; justify-content: center;"><?php

		$args = array('post_type' => 'post', 'post_status' => 'publish', 'order' => 'ASC');
	 
		if( isset( $_POST['speciality'] ) || isset( $_POST['symtome'] )  || isset($_POST['language'])  ) :
			
			$args['tax_query'] = array( 'relation'=>'AND' );

			if (isset( $_POST['speciality'] ) && !empty($_POST['speciality'])) {
			
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $_POST['speciality']
					)
				);
			}

			if (isset( $_POST['symtome'] ) && !empty($_POST['symtome'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'symtomes',
						'field' => 'slug',
						'terms' => $_POST['symtome']
					)
				);
			}

			if (isset( $_POST['language'] ) && !empty($_POST['language'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'languages',
						'field' => 'slug',
						'terms' => $_POST['language']
					)
				);
			}

		endif;

		$loop = new WP_Query($args);
		$count=0;

	 
		if( $loop->have_posts() ) :
	 
			// run the loop
			while ($loop->have_posts()) : $loop->the_post();
				$count++;
				if ($count<=6) :				
					
					$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
					$stickyClass = '';

					$post_views			= get_post_meta(get_the_ID(),'set_blog_view',true);
					$post_views			= !empty( $post_views ) ? $post_views : 0;
					$post_likes			= get_post_meta(get_the_ID(),'post_likes',true);
					$post_likes			= !empty( $post_likes ) ? $post_likes : 0;

					$post_comments		= get_comments_number(get_the_ID());
					$post_comments		= !empty( $post_comments ) ? $post_comments : 0 ;

				
					if (is_sticky()) {
						$stickyClass = 'sticky';
					}
				
					$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
					?>                         
					<div class="col-12 col-sm-12 col-md-4 col-xl-4 col-xl-4">
						<div class="dc-article">
							<figure class="dc-articleimg">
								<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
								<figcaption>
									<div class="dc-articlesdocinfo">
										<?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
										<span><?php echo get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) );?></span>				
									</div>
								</figcaption>
							</figure>
							<div class="dc-articlecontent">
								<div class="dc-title dc-ellipsis dc-titlep">
									<?php if(!empty( $categries )){?>
										<?php echo do_shortcode($categries);?>
									<?php }?>
																					
									<h3><a href="<?php the_permalink();?>"><?php doctreat_get_post_title(get_the_ID()); ?></a></h3>
									<span class="dc-datetime"><?php doctreat_get_post_date($post->ID); ?></span>
								</div>
								
								<ul class="dc-moreoptions">
									<li class="dcget-likes" data-key="642"><a href="javascript:;"><i class="ti-heart"></i><?php echo sprintf( _n( '%s Like', '%s Likes', $post_likes, 'doctreat' ), $post_likes );?></a></li>
									<li><a href="javascript:;"><i class="ti-eye"></i><?php echo sprintf( _n( '%s View', '%s Views', $post_views, 'doctreat' ), $post_views );?></a></li>
									<li><a href="javascript:;"><i class="ti-comment"></i><?php echo sprintf( _n( '%s Comment', '%s Comments', get_comments_number(get_the_ID()), 'doctreat' ), get_comments_number(get_the_ID()) );?></a></li>
								</ul>						
							</div>
						</div>
					</div>
			<?php endif;
			endwhile;
			$max_page_3=camp_nb_pages($query);?>
			<input type="hidden" id="hidden_page_3" value="1">
			<input type="hidden"  id="max_page_3" value=<?php echo $max_page_3;?>>
			<?php
			if ($count>=6):?>				
				<div class="theme-nav camp_loadmore3"><?php esc_html_e('Voir plus d\'articles','doctreat');?></div><?php
			endif;
			
		else :
			echo '<div id="notif_sb_3" style="text-align:center;" ><p style="color:red; font-size:1.3em;">No posts found !</p></div>';
		endif;
		?>
	</div><?php
	die; // here we exit the script and even no wp_reset_query() required!
} 
 
add_action('wp_ajax_campmoreposts', 'camp_search_more_posts_ajax_handler'); 
add_action('wp_ajax_nopriv_campmoreposts', 'camp_search_more_posts_ajax_handler'); 



/***************************************************************************************
  PARTIE Profil Member
*/


function camp_add_members () {
	/* Create Staff Member User Role */
	add_role(
	    'camp_member', //  System name of the role.
	    __( 'Camp Member'  ), // Display name of the role.
	    array(
	        'read'  => true,
	        'delete_posts'  => false,
	        'delete_published_posts' => false,
	        'edit_posts'   => false,
	        'publish_posts' => false,
	        'upload_files'  => true,
	        'edit_pages'  => false,
	        'edit_published_pages'  =>  false,
	        'publish_pages'  => false,
	        'delete_published_pages' => false, // This user will NOT be able to  delete published pages.
	    )
	);
}
add_action( 'admin_init', 'camp_add_members');

function camp_add_hospitals () {
	/* Create Staff Member User Role */
	add_role(
	    'hospitals', //  System name of the role.
	    __( 'Hopital'  ), // Display name of the role.
	    array(
	        'read'  => true,
	        'delete_posts'  => false,
	        'delete_published_posts' => false,
	        'edit_posts'   => false,
	        'publish_posts' => false,
	        'upload_files'  => true,
	        'edit_pages'  => false,
	        'edit_published_pages'  =>  false,
	        'publish_pages'  => false,
	        'delete_published_pages' => false, // This user will NOT be able to  delete published pages.
	    )
	);
}
add_action( 'admin_init', 'camp_add_hospitals');

add_action( 'user_register', 'camp_member_add_cpt', 10, 1 );

function camp_member_add_cpt( $user_id )
{
    // Get user info
    $user_info = get_userdata( $user_id );
    $user_roles = $user_info->roles;
	$first_name = $user_info->first_name;
	$last_name = $user_info->last_name;

    // New code added 
    $this_user_role = implode(', ', $user_roles );

    if ($this_user_role == 'camp_member') {

        // Create a new post
        $user_post = array(
            'post_title'   => $first_name.' '.$last_name,
            'post_status'  => 'publish', // <- here is to publish
            'post_type'    => 'camp_member', // <- change to your cpt
        );
        // Insert the post into the database
        $post_id = wp_insert_post( $user_post );
        add_post_meta( $post_id, '_linked_profile', $user_id);
        add_user_meta( $user_id, '_linked_profile', $post_id);
    }
}

function camp_add_reference () {

	if ( !is_admin() ) {

		global $wp, $current_user;

		$user_identity 	 = $current_user->ID;

		$current_url=home_url( $wp->request );	
		
			
		$ref_id  = (isset($_POST['camp_post_id_ref']) && !empty($_POST['camp_post_id_ref'])) ? $_POST['camp_post_id_ref'] : '' ;

		$post_id = (isset($_POST['camp_post_id_user_ref']) && !empty($_POST['camp_post_id_user_ref'])) ? $_POST['camp_post_id_user_ref'] : '' ;

		$action = (isset($_POST['camp_action_ref']) && !empty($_POST['camp_action_ref'])) ? $_POST['camp_action_ref'] : '' ;

		$comment  = (isset($_POST['camp_desc_reference']) && !empty($_POST['camp_desc_reference'])) ? $_POST['camp_desc_reference'] : '' ;
		

		if (!empty($ref_id) && !empty($post_id) && !empty($action) && $action ==="add") {
			

			if (get_post_meta( $post_id, '_saved_references', true)) {

			$save_ref_ids	= get_post_meta( $post_id, '_saved_references', true);
			
			$save_ref_ids[$ref_id] = array('id'=>$ref_id, 'comment'=>$comment);

			update_post_meta($post_id, '_saved_references', $save_ref_ids);						
			

			}

			else

			{					

				$new_ref_ids[$ref_id] = array('id'=>$ref_id, 'comment'=>$comment);

				add_post_meta($post_id, '_saved_references', $new_ref_ids);	

			
			}

			$_SESSION['reference_notice_add']="yes";

			$query_arg['ref'] = 'references';			

			$query_arg['identity'] = $user_identity;

			$permalink = add_query_arg(
	        $query_arg, esc_url( $current_url  )
	        );

			wp_safe_redirect( $permalink );

			exit;			
						
			
		}
			
		
	}	

}

add_action('template_redirect', 'camp_add_reference');


function camp_delete_reference () {

	if ( !is_admin() ) {

		global $wp, $current_user;

		$user_identity 	 = $current_user->ID;

		$current_url=home_url( $wp->request );	
		
			
		$ref_id  = (isset($_POST['camp_post_id_ref2']) && !empty($_POST['camp_post_id_ref2'])) ? $_POST['camp_post_id_ref2'] : '' ;

		$post_id = (isset($_POST['camp_post_id_user_ref2']) && !empty($_POST['camp_post_id_user_ref2'])) ? $_POST['camp_post_id_user_ref2'] : '' ;

		$action = (isset($_POST['camp_action_ref2']) && !empty($_POST['camp_action_ref2'])) ? $_POST['camp_action_ref2'] : '' ;

		

		if (!empty($ref_id) && !empty($post_id) && !empty($action) && $action === "delete") {

			//delete_post_meta( $post_id, '_saved_references');

			$ref=$ref_id;

			$_SESSION['camp_reference_delete'] = (int)$ref_id;
			$_SESSION['camp_reference_delete_notice'] = 'yes';

						

			$query_arg['ref'] = 'references';

			$query_arg['mode'] = 'saved';

			$query_arg['identity'] = $user_identity;

			$permalink = add_query_arg(
	        $query_arg, esc_url( $current_url  )
	        );

			wp_safe_redirect( $permalink );

			exit;			
								
			
		}
			
		
	}	

}

add_action('template_redirect', 'camp_delete_reference');

function camp_get_comment_reference ($post_id, $id_ref) {

	$save_ref	= get_post_meta( $post_id, '_saved_references', true);

	$save_ref = !empty($save_ref) ? $save_ref : '' ;

	$comment='No comment found !';

	if (!empty($save_ref)) {
		$array_ref = $save_ref [$id_ref];
		$comment=$array_ref['comment'];
	} 

	if (empty($save_ref) || empty($comment)) {
		$comment='No comment found !';
	}
	
	return $comment;

}

/*function camp_disable_new_posts() {
    // Hide sidebar link
    global $submenu;
    unset($submenu['edit.php?post_type=camp_member'][10]);

    // Hide link on listing page
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'camp_member') {
        echo '<style type="text/css">
        #favorite-actions, .add-new-h2, .tablenav, .page-title-action { display:none; }
        </style>';
    }
    // Hide link add new on top
    echo '<style type="text/css">
        #wp-admin-bar-new-camp_member { display:none; }
        </style>';
}

add_action('admin_menu', 'camp_disable_new_posts');*/



function camp_update_see_more_meta()

{	
	
	
	$_SESSION['_href_see_more']=1;

	

	/*
	$linked_profile  = $_POST['_linked_profile'];

	if (get_post_meta($linked_profile, '_href_see_more', true))

	{
		
		update_post_meta($linked_profile, '_href_see_more', 1);			

	}

	else{

		add_post_meta($linked_profile, '_href_see_more', 1);

		
	}*/			

}
add_action('wp_ajax_campseemore', 'camp_update_see_more_meta'); 
add_action('wp_ajax_nopriv_campseemore', 'camp_update_see_more_meta');


function camp_send_email_doctors (){


	if ( !is_admin()) { 
		if (
        isset( $_POST['camp_contact_doctors'] )
        && wp_verify_nonce( $_POST['camp_contact_doctors'], 'action_camp_contact_doctors' )
		) {
			
			if (!empty($_POST["camp_contact_email_doctors"])) {

				global $post;
				$post_id=$post->ID;
				$user_id = doctreat_get_linked_profile_id( $post_id );
				$user_info = get_userdata($user_id);
				$to = $user_info->user_email;

				$email=$_POST["camp_contact_email_doctors"];
				$nom=$_POST["camp_contact_nom_doctors"];
				$prenom=$_POST["camp_contact_prenom_doctors"];
				$tel=$_POST["camp_contact_tel_doctors"];
				$message=$_POST["camp_contact_message_doctors"];

				$subject = 'contact'.$prenom.' '.$nom;
				$body = 'Nom:'.$nom.'<br> prenom:'.$prenom.'<br> Téléphone:'.$tel.'<br> message:'.$message.'<br>';
				$headers = 'From: '. $email . "\r\n" .'Reply-To: ' . $email . "\r\n";

				$send_mail=wp_mail( $to, $subject, strip_tags($body), $headers );

				if ($send_mail) {
			    
			    	$url = add_query_arg('alert', 'success', wp_get_referer());

					wp_safe_redirect($url);

					exit();

			    } else {
			    	//return '<div id="message" class="alert-error"><p>Une erreur est survenue... veuillez reéssayer !</p></div>';
			    	$url = add_query_arg('alert', 'erreur', wp_get_referer());

					wp_safe_redirect($url);
					
					exit();
			    }
			}
			
		}
    }
    
}

add_action('template_redirect', 'camp_send_email_doctors');

function camp_send_email_hospitals (){


	if ( !is_admin()) { 
		if (
        isset( $_POST['camp_send_email_hospitals'] )
        && wp_verify_nonce( $_POST['camp_contact_hospitals'], 'action_camp_contact_hospitals' )
		) {
			
			if (!empty($_POST["camp_contact_email_hospitals"])) {

				global $post;
				$post_id=$post->ID;
				$user_id = doctreat_get_linked_profile_id( $post_id );
				$user_info = get_userdata($user_id);
				$to = $user_info->user_email;

				$email=$_POST["camp_contact_email_hospitals"];
				$nom=$_POST["camp_contact_nom_hospitals"];
				$prenom=$_POST["camp_contact_prenom_hospitals"];
				$tel=$_POST["camp_contact_tel_hospitals"];
				$message=$_POST["camp_contact_message_hospitals"];

				$subject = 'contact'.$prenom.' '.$nom;
				$body = 'Nom:'.$nom.'<br> prenom:'.$prenom.'<br> Téléphone:'.$tel.'<br> message:'.$message.'<br>';
				$headers = 'From: '. $email . "\r\n" .'Reply-To: ' . $email . "\r\n";

				$send_mail=wp_mail( $to, $subject, strip_tags($body), $headers );

				if ($send_mail) {
			    
			    	$url = add_query_arg('alert', 'success', wp_get_referer());

					wp_safe_redirect($url);

					exit();

			    } else {
			    	//return '<div id="message" class="alert-error"><p>Une erreur est survenue... veuillez reéssayer !</p></div>';
			    	$url = add_query_arg('alert', 'erreur', wp_get_referer());

					wp_safe_redirect($url);
					
					exit();
			    }
			}
			
		}
    }
    
}

add_action('template_redirect', 'camp_send_email_hospitals');

function camp_send_email_camp_member (){


	if ( !is_admin()) { 
		if (
        isset( $_POST['camp_send_email_camp_member'] )
        && wp_verify_nonce( $_POST['camp_contact_camp_member'], 'action_camp_contact_camp_member' )
		) {
			
			if (!empty($_POST["camp_contact_email_camp_member"])) {

				global $post;
				$post_id=$post->ID;
				$user_id = doctreat_get_linked_profile_id( $post_id );
				$user_info = get_userdata($user_id);
				$to = $user_info->user_email;

				$email=$_POST["camp_contact_email_camp_member"];
				$nom=$_POST["camp_contact_nom_camp_member"];
				$prenom=$_POST["camp_contact_prenom_camp_member"];
				$tel=$_POST["camp_contact_tel_camp_member"];
				$message=$_POST["camp_contact_message_camp_member"];

				$subject = 'contact'.$prenom.' '.$nom;
				$body = 'Nom:'.$nom.'<br> prenom:'.$prenom.'<br> Téléphone:'.$tel.'<br> message:'.$message.'<br>';
				$headers = 'From: '. $email . "\r\n" .'Reply-To: ' . $email . "\r\n";

				$send_mail=wp_mail( $to, $subject, strip_tags($body), $headers );

				if ($send_mail) {
			    
			    	$url = add_query_arg('alert', 'success', wp_get_referer());

					wp_safe_redirect($url);

					exit();

			    } else {
			    	//return '<div id="message" class="alert-error"><p>Une erreur est survenue... veuillez reéssayer !</p></div>';
			    	$url = add_query_arg('alert', 'erreur', wp_get_referer());

					wp_safe_redirect($url);
					
					exit();
			    }
			}
			
		}
    }
    
}

add_action('template_redirect', 'camp_send_email_camp_member');

function camp_add_location (){


	if ( !is_admin()) {
		//print_r($_POST); die();
		if (
        isset( $_POST['camp_add_location'] )
        && wp_verify_nonce( $_POST['camp_add_location'], 'action_camp_add_location' )
		) {

			global $wp, $current_user;
			$user_identity 	 = $current_user->ID;
			$current_url=home_url( $wp->request );

			$linked_profile  = doctreat_get_linked_profile_id($user_identity);
			$post_id 		 = $linked_profile;
			$current_url=home_url( $wp->request );

			if ( !empty($_POST["city"]) && !empty($_POST["address"])) {

				$city=$_POST["city"];
				$address=$_POST["address"];
				$longitude=!empty($_POST["longitude"]) ? $_POST["longitude"] : '-0.1262362';
				$latitude=!empty($_POST["latitude"]) ? $_POST["latitude"] : '51.5001524';
				$days=array('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche');
				$days_offer=array();
				$image_location='';

				if (isset($_FILES["image_location"]) && !empty($_FILES["image_location"])) {				
					$file_data=camp_update_attachment( "image_location", $post_id);
					$image_location=$file_data['url'];

				}

				

				foreach ($days as $key => $day) {

					$key_time='time_'.$day ;
					$key_start='start_time_'.$day ;
					$key_end='end_time_'.$day ;

					if (isset($_POST[$key_time]) && $_POST[$key_time] === "others" ) {
						$start_time=$_POST[$key_start];
						$end_time=$_POST[$key_end];
						$days_offer[$day]['day']=$day;
						$days_offer[$day]['start_time']=$start_time;
						$days_offer[$day]['end_time']=$end_time;

					} elseif (isset($_POST[$key_time]) && $_POST[$key_time] === "24_24" ) {
						$days_offer[$day]['day']=$day;
						$days_offer[$day]['start_time']='00h';
						$days_offer[$day]['end_time']='00h';
					}
					
				}
				/*if (get_post_meta( $post_id , '_camp_custom_locations', true )) {
					$locations=get_post_meta( $post_id , '_camp_custom_locations',true );
					$locations[]=array('address' => $address, 'longitude' => $longitude, 'latitude' => $latitude, 'days_offer' => $days_offer);
					update_post_meta( $user_identity , '_camp_custom_locations', $locations );

				} else {
					
					$locations[]=array('address' => $address, 'longitude' => $longitude, 'latitude' => $latitude, 'days_offer' => $days_offer);
					add_post_meta( $post_id , '_camp_custom_locations', $locations );
				}*/				
				
			}

			$locations=array('city' => $city, 'address' => $address, 'longitude' => $longitude, 'latitude' => $latitude, 'image' => $image_location,'days_offer' => $days_offer);

			$_SESSION['camp_location'] = $locations;
			$_SESSION['camp_location_add'] = 'yes';
			
			$query_arg['ref'] = 'camp-locations';			

			$query_arg['identity'] = $user_identity;

			$permalink = add_query_arg(
	        $query_arg, esc_url( $current_url  )
	        );

			wp_safe_redirect( $permalink );

			exit;				
			
		}
    }
    
}

add_action('template_redirect', 'camp_add_location');

function camp_delete_location (){


	if ( !is_admin()) { 
		if (isset( $_POST['camp_location_nonce']) && 
			$_POST['camp_location_nonce'] === "yes" )
        {
			global $wp, $current_user;
			$user_identity = $current_user->ID;
			$current_url=home_url( $wp->request );
			
			$key=(int)$_POST["camp_location_key"];
			$data_location=array('key' => $key);
			$_SESSION['data_location'] = $data_location;
			
			$query_arg['ref'] = 'camp-locations';
			$query_arg['mode'] = 'saved';
			$query_arg['identity'] = $user_identity;
			$permalink = add_query_arg($query_arg, esc_url( $current_url.'/dashboard/'  ));
			wp_safe_redirect( $permalink );
			exit;	
			
		}
    }
    
}

add_action('template_redirect', 'camp_delete_location');

function camp_article_sidebar() {
	if ( function_exists('register_sidebar') ) {

		register_sidebar(
	        array (
	            'name' => __( 'Camp Post Sidebar', 'camp' ),
	            'id' => 'camp-post-side-bar',
	            'description' => __( 'Cette barre latérale s\'affichera sur toutes les pages article du thème à droite', 'letellier' ),
	            'before_widget' => '<div class="sidebar-box clr ld-side-bar">',
	            'after_widget' => "</div>",
	            'before_title' => '<h3 class="widget-title title-ld-side-bar">',
	            'after_title' => '</h3>',
	        )
	    );

	}
    
}
add_action( 'widgets_init', 'camp_article_sidebar' );


/***************************************************************************************
  PARTIE FORMULAIRE MULTICRITERES
*/

add_filter( 'query_vars', 'camp_add_query_vars' );
function camp_add_query_vars( $vars ){
	$vars[] = "c_see_more_type";
	$vars[] = "c_see_more_filter_key";
	$vars[] = "c_see_more_filter_value";
	return $vars;
}

add_filter( 'pre_get_posts', 'camp_pre_get_posts' );

function camp_pre_get_posts( $q ) {
	if ($q->get( 'c_see_more_type' ) && $q->get( 'c_see_more_filter_key' ) && $q->get( 'c_see_more_filter_value' )) 
	{
		$type=$q->get( 'c_see_more_type' );
		$filter_key=$q->get( 'c_see_more_filter_key' );
		$filter_value=$q->get( 'c_see_more_filter_value' );
		
		if ($type === 'post' || $type === 'doctors' ){
			$q->set( 'post_type', $type );
			$tax_queries = $q->get( 'tax_query', array() );	
			if (!empty($filter_key)){
				$tax_queries[] = array(
					'taxonomy' => $filter_key,
					'terms'    => $filter_value,
					'field'    => 'slug',
				);
				if ( ! empty( $tax_queries ) ) {
					if ( isset( $tax_queries[1] ) ) {
						$tax_queries['relation'] = 'AND';
					}
					$q->set( 'tax_query', $tax_queries );
				}
			}
				
			
		}	
		
	}
	return $q;
}

add_action( 'template_include', 'camp_see_more_template' );
function camp_see_more_template( $template ) {
	if( get_query_var( 'c_see_more_type' ) 
		&& get_query_var( 'c_see_more_filter_value' )
		&& get_query_var( 'c_see_more_filter_key' ) ) {
			$new_template = locate_template( array( 'search-terms.php' ) );
			if ( '' != $new_template ) {
				return $new_template ;
			}
	}
	return $template;
}

function camp_add_term_meta ($type_taxo, $term_id, $slug) {
	if ($type_taxo === 'specialities'):		
		if( have_rows('camp_symptomes_specialities', 'term_'.$term_id) ):
			while ( have_rows('camp_symptomes_specialities', 'term_'.$term_id) ) : the_row();
				$symtome=get_sub_field('symtome');						
				if (!get_term_meta( $symtome->term_id, '_key_speciality'.$term_id, true)){
					add_term_meta( $symtome->term_id, '_key_speciality'.$term_id, $slug );
				}				
			endwhile;		
		endif;
		
	else :
		if( have_rows('camp_specialities_symptomes', 'term_'.$term_id) ):
			while ( have_rows('camp_specialities_symptomes', 'term_'.$term_id) ) : the_row();
				$speciality=get_sub_field('specialite');						
				if (!get_term_meta( $speciality->term_id, '_key_symtome'.$term_id, true)){
					add_term_meta( $speciality->term_id, '_key_symtome'.$term_id, $slug );
				}				
			endwhile;		
		endif;
	endif;
	
}

add_shortcode( 'camp_map', 'camp_google_map' );
function camp_google_map() {
	global $post;
	$address		= get_post_meta( $post->ID , '_address',true );
	$address		= !empty( $address ) ? $address : 'Paris';
	$latitude		= get_post_meta( $post->ID , '_latitude',true );
	$latitude		= !empty( $latitude ) ? $latitude : '48.866667';
	$longitude		= get_post_meta( $post->ID , '_longitude',true );
	$longitude		= !empty( $longitude ) ? $longitude : '2.333333';
	
	$map='<div class="form-group dc-formmap">
				<div id="camp-location-pickr-map" style="height:200px;" class="dc-locationmap location-pickr-map" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'"></div>
			</div>
			<small><a style="color: #0000ff; text-align: left;" href="https://maps.google.fr/maps?q='.$address.'&num=1&t=v&ie=UTF8&z=14&ll='.$latitude.','.$longitude.'&source=embed">Agrandir le plan</a></small>';
	$script = "jQuery(document).ready(function (e) {
				jQuery.doctreat_init_profile_map(0,'camp-location-pickr-map', ". esc_js($latitude) . "," . esc_js($longitude) . ");
			});";
	wp_add_inline_script('doctreat-maps', $script, 'after');
	
	return $map;
}

function camp_get_favorit_check($post_id='',$size=''){
		
	if( !empty($post_id) ) {
		$post_type		= get_post_type($post_id);
		$post_key		= '_saved_'.$post_type;
		
		$check_wishlist	= doctreat_check_wishlist($post_id,$post_key);
		$class			= !empty( $check_wishlist ) ? 'dc-liked' : 'dc-add-wishlist';
		ob_start();
		if( !empty( $size ) && $size === 'large' ){ ?>
			<a href="javascript:;" class="<?php echo esc_attr( $class );?> dc-btn" data-id="<?php echo intval($post_id);?>"><?php _e('Enrégistrer','doctreat');?></a> 
		<?php } 
			echo ob_get_clean();
		}
}
add_action( 'camp_get_favorit_check', 'camp_get_favorit_check',10,2 );





//Initialisation
add_action('add_meta_boxes','mes_metaboxes');
function mes_metaboxes(){
  add_meta_box('things', 'Manage Services', 'camp_services_admin', 'doctors', 'normal', 'default');
}
// Fonction de construction de la metabox
function camp_services_admin($post){
  global $wpdb;
  
  $am_specialities = doctreat_get_post_meta( $post->ID,'am_specialities');
  $user_identity=doctreat_get_linked_profile_id( $post->ID, 'post' );
  $specialities	= doctreat_get_taxonomy_array('specialities');
  $specialities_json	= array();

	if( !empty( $specialities ) ){
		foreach( $specialities as $speciality ) {
			$services_array				= doctreat_list_service_by_specialities($speciality->term_id);
			$json[$speciality->term_id] = $services_array;
		}
		
		$specialities_json['categories'] = $json;
	}
 ?>
  

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-8">
	<div class="dc-dashboardbox dc-offered-holder">
		<div class="dc-dashboardboxcontent">
			<div class="dc-tabscontenttitle dc-addnew">
				<h3><?php esc_html_e('Offered Services','doctreat');?></h3>
				<a href="javascript:;" class="dc-admin-add_service"><?php esc_html_e('Add New','doctreat');?>
				<a href="javascript:;" class="dc-admin-create_service"><?php esc_html_e('Create New','doctreat');?>
				</a>
			</div>							
			<div class="dc-specilities-items">
				<?php
					if( !empty( $am_specialities ) ){
						foreach( $am_specialities as $keys => $item ) {?>
							<div class="repeater-wrap-inner specialities_parents dc-specility-<?php echo intval($keys);?>" id="<?php echo intval($keys);?>">
								<div class="remove-repeater"><span class="dashicons dashicons-trash"></span></div>
								<div class="am_field">
									<div class="am_field dropdown-style">
										<span class="dc-select">
											<?php echo apply_filters('doctreat_get_specialities_list','am_specialities['.$keys.'][speciality_id]',$keys,0);?>
										</span>
									</div>
								</div>
								<ul class="dc-experienceaccordion accordion services-wrap dc-addnew">										
									<?php
										if( !empty( $item )) {												
											foreach ( $item as $service_key => $service ){ 
												$service_title	= doctreat_get_term_name($service_key ,'services');
												$service_title	= !empty( $service_title ) ? $service_title : '';
												$service_price	= !empty( $service['price'] ) ? $service['price'] : '';
												$service_time	= !empty( $service['time'] ) ? $service['time'] : '';
											?>
											<li class="repeater-wrap-inner services-item" id="<?php echo intval($service_key);?>">
												<div class="dc-accordioninnertitle dc-subpaneltitle dc-subpaneltitlevtwo">
													<span id="accordioninnertitle<?php echo intval( $service_key);?>" data-toggle="collapse" data-target="#innertitle<?php echo intval( $service_key);?>">
														<?php echo esc_html( $service_title );?>
													</span>
													<div class="dc-rightarea">
														<?php if( !empty( $service_price ) ) { ?>
															<em><?php doctreat_price_format($service_price); ?></em>
														<?php } ?>
														<?php if( !empty( $service_time ) ) { ?>
															<em><?php echo $service_time.'min' ; ?></em>
														<?php } ?>
														<div class="dc-btnaction">
															<a href="javascript:;" class="dc-deleteinfo"><span class="dashicons dashicons-trash"></span></a>
														</div>
													</div>
												</div>													
											</li>
										<?php }?>
									<?php }?>
								</ul>
							</div>
						<?php
						}
					}
				?>
			</div>
		</div>
	</div>
</div>
<div id="myModal_add" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<div class="modal-header">
			<span class="_add_close_">×</span>
		  
			<div class="container">
				<div class="dc-tabscontenttitle dc-addnew">
					<h3><?php esc_html_e('Add Service','doctreat');?></h3>
				</div>								
				<div class="dc-collapseexp" style="background-color: transparent;">
					<div class="dc-formtheme dc-userform">
						<fieldset>
							<form class="form-camp-admin-add-services" method="post">
								<?php wp_nonce_field('camp_admin_add_services', 'admin_add_services'); ?>
								<div class="am_field">
									<div class="am_field dropdown-style">
										
										<?php 
											$args = array(
												'show_option_all'   => __( 'Select a speciality' ), 
												'orderby'           => 'name', 
												'order'             => 'ASC',
												'show_count'        => 0,
												'hide_empty'        => 0, 
												'echo'              => 0, 
												'id'                => 'specialities',
												'class'                => 'dc-select specialities',
												'hierarchical'      => true,
												'depth'             => 1,
												'taxonomy'          => 'specialities',
												'hide_if_empty'     => false, 
												'value_field'       => 'term_id',
											);

											// Y-a-t'il un Lieu actuellement sélectionnée ?
											if ( $_POST['camp_speciality_service'] 
												&& (term_exists( $_POST['camp_speciality_service'] , 'specialities' ) ) )  {
												$args['selected'] = $_POST['camp_speciality_service'] ;
											}

											$list = wp_dropdown_categories( $args );

											// Afficher la liste s'il existe des villes associées à des contenus
											if ( $list ) {
												echo $list;
										} ?>							
										
									</div>
								</div>	
								<div class="form-group">
									<select class="dc-select services" id="camp_title_service_add">
										<option></option>
									</select>
								</div>	
								<div class="form-group form-group-half">
									<input type="text" class="form-control" id="camp_price_service_add" placeholder="<?php esc_attr_e('Price','doctreat');?>">
								</div>
								<div class="form-group form-group-half">
									<input type="number" class="form-control" id="camp_time_service_add" placeholder="<?php esc_attr_e('Time','doctreat');?>">
								</div>
								<div class="form-group">
									<textarea id="camp_desc_service_add" class="form-control" placeholder="<?php esc_attr_e('Description','doctreat');?>"></textarea>
								</div>								
								<div class="dc-updatall">
									<input type="hidden" name="camp_id_post" id="camp_id_post" value="<?php echo $post->ID ; ?>">						
									<input type="hidden" name="add_ajax_url" id="add_ajax_url" value="<?php echo site_url() . '/wp-admin/admin-ajax.php' ; ?>">									 
									<a class="dc-btn dc-admin-update-services" href="javascript:;"><?php esc_html_e('Add Service','doctreat');?></a>
								</div>
							</form>								
						</fieldset>
					</div> 	
				</div>							
			</div>
		</div>
	</div>
</div>	
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<div class="modal-header">
			<span class="camp_admin_modal_close_">×</span>
		  
			<div class="container">
				<div class="dc-tabscontenttitle dc-addnew">
					<h3><?php esc_html_e('Create Service','doctreat');?></h3>
				</div>					
				<div class="dc-collapseexp" style="background-color: transparent;">
					<div class="dc-formtheme dc-userform">
						<fieldset>
							<form action="" method="post" enctype="multipart/form-data" class="form-camp-admin-create-services">
								<?php wp_nonce_field( "action_admin_camp_create_service", "admin_camp_create_service", true, true );?>
								<div class="am_field">
									<div class="am_field dropdown-style">
										
										<?php 
											$args = array(
												'show_option_all'   => __( 'Select a speciality' ), 
												'orderby'           => 'name', 
												'order'             => 'ASC',
												'show_count'        => 0,
												'hide_empty'        => 0, 
												'echo'              => 0,
												'name'              => 'camp_speciality_service', 
												'id'                => '',
												'class'                => 'dc-select',
												'hierarchical'      => true,
												'depth'             => 1,
												'taxonomy'          => 'specialities',
												'hide_if_empty'     => false, 
												'value_field'       => 'slug',
											);

											// Y-a-t'il un Lieu actuellement sélectionnée ?
											if ( $_POST['camp_speciality_service'] 
												&& (term_exists( $_POST['camp_speciality_service'] , 'specialities' ) ) )  {
												$args['selected'] = $_POST['camp_speciality_service'] ;
											}

											$list = wp_dropdown_categories( $args );

											// Afficher la liste s'il existe des villes associées à des contenus
											if ( $list ) {
												echo $list;
										} ?>							
										
									</div>
								</div>	
								<div class="form-group">
									<input type="text" class="form-control" name="camp_title_service" class="" placeholder="<?php esc_attr_e('Title','doctreat');?>" value="<?php echo($_POST['camp_title_service']);?>">
								</div>								
								<div class="file-upload">
								  <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><?php esc_attr_e('Add Image of service','doctreat');?></button>

								  <div class="image-upload-wrap">
									<input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/png, image/jpeg" name="camp_image_service" />
									<div class="drag-text">
									  <h3>Drag and drop a file or select add Image</h3>
									</div>
								  </div>
								  <div class="file-upload-content">
									<img class="file-upload-image" src="#" alt="your image" />
									<div class="image-title-wrap">
									  <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
									</div>
								  </div>
								</div>
								<div class="dc-updatall">
									<input type="hidden" name="camp_post_id_service" id="camp_post_id_service" value="<?php echo $post->ID ; ?>">						
									<input type="hidden" name="create_ajax_url" id="create_ajax_url" value="<?php echo site_url() . '/wp-admin/admin-ajax.php' ; ?>">									 
									<a class="dc-btn dc-admin-create-services" href="javascript:;"><?php esc_html_e('Create Service','doctreat');?></a>
								</div>
							</form>								
						</fieldset>
					</div> 						  
				</div>
			</div>
		</div>
	</div>
</div>
 <?php
 ?>
   <style> 
   [class*="dc-specility"] .dc-experienceaccordion {
		padding: 0;
	}
	.dc-experienceaccordion {
		float: left;
		width: 100%;
		list-style: none;
		padding: 0 20px;
	}
   .dc-experienceaccordion li {
		float: left;
		width: 100%;
		list-style-type: none;
	}
	.dc-system-btn-holder {
		margin-bottom: 10px;
	}
	[class*="dc-specility"] .dc-experienceaccordion li.services-item:nth-child(2) .dc-accordioninnertitle {
		border-top: 1px solid #eee;
	}
	.dc-awardaccordion li + li .dc-accordioninnertitle, .dc-experienceaccordion li + li .dc-accordioninnertitle, ul.dc-educationaccordion li + li .dc-accordioninnertitle {
		border-top: 0;
	}
	.dc-subpaneltitlevtwo {
		padding: 10px 20px;
	}
	.dc-accordioninnertitle {
		float: left;
		width: 50%;
		background: #fff;
		line-height: inherit;
		list-style-type: none;
		border: 1px solid #eee;
			border-top-color: rgb(238, 238, 238);
			border-top-style: solid;
			border-top-width: 1px;
	}
	.dc-btnaction a:focus, .dc-btnaction a:hover {
		color: #fff;
	}
	.dc-accordioninnertitle .dc-rightarea a {
		width: 30px;
		float: left;
		color: #fff;
		height: 30px;
		font-size: 14px;
		line-height: 30px;
		border-radius: 4px;
		text-align: center;
	}
	.dc-subpaneltitlevtwo > span {
		padding: 0;
		float: left;
		line-height: 30px;
	}
	.dc-rightarea {
		float: right;
	}
	.dc-subpaneltitlevtwo .dc-rightarea em {
		color: #3d4461;
		font-size: 14px;
		font-style: normal;
		line-height: 30px;
		display: inline-block;
		font-family: 'Open Sans',sans-serif;
	}
	.dc-subpaneltitlevtwo .dc-btnaction {
		float: right;
		margin-left: 30px;
	}
	class*="dc-specility"] .dc-experienceaccordion li.services-item:last-child .dc-collapseexp.show {
		border-bottom: 1px solid #ddd;
	}
	
	.dc-select {
		color: #999;
		float: left;
		width: 100%;
		position: relative;
	}
	.dc-select select {
		z-index: 1;
		width: 100%;
		position: relative;
		appearance: none;
		-moz-appearance: none;
		-webkit-appearance: none;
		
	}	
	.dc-addnew a {
		text-decoration: none;
		margin-right: 5px;
		color: #55acee;
		line-height: 20px;
	}
	
	/* The Modal (background) */
	.modal {
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	}

	/* Modal Content */
	.modal-content {
	  position: relative;	  
	  margin: auto;
	  padding: 0;
	  max-width: 400px;
	  width: 100%;
	  height: auto;
	  -webkit-animation-name: animatetop;
	  -webkit-animation-duration: 0.4s;
	  animation-name: animatetop;
	  animation-duration: 0.5s
	}


	/* Add Animation */
	@-webkit-keyframes animatetop {
	  from {top:-300px; opacity:0} 
	  to {top:0; opacity:1}
	}

	@keyframes animatetop {
	  from {top:-300px; opacity:0}
	  to {top:0; opacity:1}
	}

	/* The Close Button */
	.camp_admin_modal_close_ {
	  color: white;
	  float: right;
	  font-size: 28px;
	  font-weight: bold;
	}

	.camp_admin_modal_close_:hover,
	.camp_admin_modal_close_:focus, 
	{
	  color: #000;
	  text-decoration: none;
	  cursor: pointer;
	}
	._add_close_:hover,
	._add_close_:focus
	{
	  color: #000;
	  text-decoration: none;
	  cursor: pointer;
	}
	.modal-header {
	  padding: 2px 16px;
	  background-color: #fff;
	  color: white;
	}

	.modal-body {padding: 2px 16px;}

	.modal-footer {
	  padding: 2px 16px;
	  background-color: #5cb85c;
	  color: white;
	}

	.file-upload {
	  margin: 0 auto;
	  padding: 20px;
	}

	.file-upload-btn {
	  width: 100%;
	  margin: 0;
	  color: #fff;
	  background: #1FB264;
	  border: none;
	  padding: 10px;
	  border-radius: 4px;
	  border-bottom: 4px solid #15824B;
	  transition: all .2s ease;
	  outline: none;
	  text-transform: uppercase;
	  font-weight: 700;
	}

	.file-upload-btn:hover {
	  background: #1AA059;
	  color: #ffffff;
	  transition: all .2s ease;
	  cursor: pointer;
	}

	.file-upload-btn:active {
	  border: 0;
	  transition: all .2s ease;
	}

	.file-upload-content {
	  display: none;
	  text-align: center;
	}

	.file-upload-input {
	  position: absolute;
	  margin: 0;
	  padding: 0;
	  width: 100%;
	  height: 100%;
	  outline: none;
	  opacity: 0;
	  cursor: pointer;
	}

	.image-upload-wrap {
	  margin-top: 20px;
	  border: 4px dashed #1FB264;
	  position: relative;
	}

	.image-dropping,
	.image-upload-wrap:hover {
	  background-color: #1FB264;
	  border: 4px dashed #ffffff;
	}

	.image-title-wrap {
	  padding: 0 15px 15px 15px;
	  color: #222;
	}

	.drag-text {
	  text-align: center;
	}

	.drag-text h3 {
	  font-weight: 100;
	  text-transform: uppercase;
	  color: #15824B;
	  padding: 60px 0;
	}

	.file-upload-image {
	  max-height: 200px;
	  max-width: 200px;
	  margin: auto;
	  padding: 20px;
	}

	.remove-image {
	  width: 200px;
	  margin: 0;
	  color: #fff;
	  background: #cd4535;
	  border: none;
	  padding: 10px;
	  border-radius: 4px;
	  border-bottom: 4px solid #b02818;
	  transition: all .2s ease;
	  outline: none;
	  text-transform: uppercase;
	  font-weight: 700;
	}

	.remove-image:hover {
	  background: #c13b2a;
	  color: #ffffff;
	  transition: all .2s ease;
	  cursor: pointer;
	}

	.remove-image:active {
	  border: 0;
	  transition: all .2s ease;
	}
	.services-item{
		
	}
	.related-services select {
		width: 90%;
		margin-bottom: 5px;
	}
	.dc-deleteinfo .dashicons-trash, .remove-repeater .dashicons-trash {
		color:red;
	}	
   </style>
  <!-- script-->
   <script type="text/javascript">
		 
   </script>
  
  
  <script>// <![CDATA[
  jQuery(document).ready(function($){
	  $('#myModal').hide();
	  $('#myModal_add').hide();
      
      $('.dc-admin-add_service').on('click',function(){
		$('#myModal').hide();
        $('#myModal_add').show();
      });
	  $('.dc-admin-create_service').on('click',function(){
        $('#myModal_add').hide();
		$('#myModal').show();
      });
	  // Get the <span> element that closes the modal
		var span_add = $("._add_close_");
		span_add.on('click',function(){
			$('#myModal_add').hide();
		  });
		var span = $(".camp_admin_modal_close_");
		span.on('click',function(){
			$('#myModal').hide();
		  });
		
    })///Add Services
	
	jQuery(document).ready(function($) {
		var specialitiesJson = <?php echo json_encode($specialities_json['categories']) ?>;
		var $specialities = $('select.specialities');
		var $services = $('select.services');
		$specialities.change(function() {
			$services.empty().append(function() {
				var output = '';
				$.each(specialitiesJson[$specialities.val()], function(key, value) {
					output += '<option value="'+ key +'">' + value['name'] + '</option>';
				});
				return output;
			});
		}).change();
	});
	
	jQuery(document).on('click', '.dc-deleteinfo', function() {
		var _this 		= jQuery(this);
		var check_class	= _this.hasClass('dc-deleteinfo dc-delete-info')
		if(check_class == false) {
			_this.parents('li').remove();
		}
		
	});
	//Update services
    jQuery(document).on('click', '.dc-admin-update-services', function (e) {
		e.preventDefault(); 
		var ajax_url = jQuery('#add_ajax_url').val();
		var id = jQuery('#camp_id_post').val();
		var speciality = jQuery('#specialities').val();
		var service = jQuery('#camp_title_service_add').val();
		var price = jQuery('#camp_price_service_add').val();
		var time = jQuery('#camp_time_service_add').val();
		var desc = jQuery('#camp_desc_service_add').val();
        var _this    = jQuery(this);                    
        //var _serialized   = jQuery('.form-camp-admin-add-services').serialize();
        var dataString 	  ='camp_id_post='+id+'&camp_speciality_service='+speciality+'&camp_title_service='+service+'&camp_price_service='+price+'&camp_time_service='+time+'&camp_desc_service='+desc+'&action=camp_admin_update_specialities';
        jQuery.ajax({
            type: "POST",
            url: ajax_url,
            data: dataString,
            dataType: "json",
            success: function (response) {                
                alert(response.message);                
            }
        });
    });
	jQuery(document).on('click', '.dc-admin-create-services', function (e) {
		e.preventDefault(); 
		var ajax_url = jQuery('#create_ajax_url').val();
        var _this    = jQuery(this);                    
        var _serialized   = jQuery('.form-camp-admin-create-services').serialize();
        var dataString 	  = _serialized+'&action=camp_admin_create_services';
        jQuery.ajax({
            type: "POST",
            url: ajax_url,
            data: dataString,
            dataType: "json",
            success: function (response) {
				 alert(response.message);                
            }
        });
    });
  // ]]></script>
  <?php
  }
 
function camp_admin_update_specialities(){       
	
	$post_id  	= !empty( $_POST['camp_id_post'] ) ? $_POST['camp_id_post'] : '';
	//Verify Nonce
	/*$do_check 	= wp_verify_nonce('camp_admin_add_services', 'admin_add_services');
	if (!$do_check) {
		
		$json['type'] 		= 'error';
		$json['message'] 	= esc_html__('No kiddies please!', 'doctreat');
		wp_send_json($json);
	}*/
	if (empty($post_id)) {
		
		$json['type'] 		= 'error';
		$json['message'] 	= esc_html__('No ID Post Found', 'doctreat');
		wp_send_json($json);
	}
	if (empty($_POST['camp_speciality_service'])) {
		
		$json['type'] 		= 'error';
		$json['message'] 	= esc_html__('Select Speciality', 'doctreat');
		wp_send_json($json);
	}
	$meta_data		= doctreat_get_post_meta( $post_id );
	$post_type		= get_post_type($post_id);
	$meta_data		= !empty( $meta_data ) ? $meta_data : array();
	$post_meta		= doctreat_get_post_meta( $post_id,'am_specialities');
	$post_meta		= !empty( $post_meta ) ? $post_meta : array();
	
	$speciality	= $_POST['camp_speciality_service'];
	$service	= !empty( $_POST['camp_title_service'] ) ? $_POST['camp_title_service'] : '';
	$price	= !empty( $_POST['camp_price_service'] ) ? $_POST['camp_price_service'] : '';
	$time	= !empty( $_POST['camp_time_service'] ) ? $_POST['camp_time_service'] : '';
	$description	= !empty( $_POST['camp_desc_service'] ) ? $_POST['camp_desc_service'] : '';

	$service_array		= array('service'=>$service,'price'=>$price,'time'=>$time,'description'=>$description );
	$speciality_array	= array();
	
	if( !empty( $speciality ) ){
		if (array_key_exists($speciality, $post_meta)){
			$post_meta[$speciality][$service]=$service_array;
		}
		else{
			$speciality_array[$service]=$service_array;
			$post_meta[$speciality]=$speciality_array;
		}
	}
	
	$meta_data['am_specialities']	= $post_meta;
	update_post_meta($post_id, 'am_' . $post_type . '_data', $meta_data);
	
	
	if( !empty( $service ) ){
		wp_set_object_terms( $post_id, $service, 'services' );
	}
	
	if( !empty( $specialities_array ) ){
		wp_set_object_terms( $post_id, $speciality, 'specialities' );
	}
	
	$json['type']    = 'success';
	$json['message'] = esc_html__('Services are Updated. Please update post to see modifications', 'doctreat');
	
	wp_send_json($json);
	
}
add_action('wp_ajax_camp_admin_update_specialities', 'camp_admin_update_specialities');
add_action('wp_ajax_nopriv_camp_admin_update_specialities', 'camp_admin_update_specialities');

function camp_admin_create_services () {	
	if (
	isset( $_POST['admin_camp_create_service'] )
	&& wp_verify_nonce( $_POST['admin_camp_create_service'], 'action_admin_camp_create_service' )
	) {

		
		$post_id = htmlspecialchars($_POST['camp_post_id_service']);

		$speciality=(!empty($_POST['camp_speciality_service'])) ? htmlspecialchars($_POST['camp_speciality_service']) : "" ;

		$speciality_object=get_term_by('slug', $speciality, 'specialities');			
		
		$title=htmlspecialchars($_POST['camp_title_service']);			
		

		if ($speciality_object!==false) {				

			$create_spec=wp_insert_term(
			$title,   // the term 
			'services'
			);
			if (!is_wp_error($create_spec)) {

				$create_spec=(array)$create_spec;
			
			

				//wp_set_object_terms( $post_id, $create_spec['term_id'], 'services' );

				$speciality_id=(int)$speciality_object->term_id;

				add_term_meta( $create_spec['term_id'], "speciality" , $speciality_id );

				$att = camp_update_attachment('camp_image_service',$create_spec['term_id']);
				update_field('camp_photo_service',$att['attach_id'],'services_'.$create_spec["term_id"]);			

				$json['type']    = 'success';
				$json['message'] = esc_html__('Service is Created. Please update post to see modifications', 'doctreat');				
				wp_send_json($json);
			}		
			else
			{
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Error during service creation', 'doctreat');
				wp_send_json($json);
			}
		}
		else
		{

			$json['type'] 		= 'error';
			$json['message'] 	= esc_html__('Speciality not found', 'doctreat');
			wp_send_json($json);
		}			

	}
		

}

add_action('wp_ajax_camp_admin_create_services', 'camp_admin_create_services');
add_action('wp_ajax_nopriv_camp_admin_create_services', 'camp_admin_create_services');


function camp_get_references() {
  ob_start();
  get_template_part('directory/front-end/templates/references-widget');
  return ob_get_clean();
}
add_shortcode('camp_references', 'camp_get_references');

function camp_manager_author_editor () {
	$users = get_users([ 'role__in' => [ 'doctors' ], 'role__not_in' => [ 'editor' ], 'blog_id' => get_current_blog_id() ]);
	foreach ($users as $user) {
		$user->add_role('editor'); 
	}
}
add_action('admin_init','camp_manager_author_editor');

function camp_send_invit () {

	if ( !is_admin() && isset($_POST['camp_action_']) && $_POST['camp_action_']=="add_invit") {

		global $wp, $current_user;

		$_SESSION['camp_send_invit']="no";
		$email	= !empty($_POST['doctor_email_invit']) ? $_POST['doctor_email_invit'] : '';	
		
		$content	= !empty($_POST['camp_desc_invit']) ? $_POST['camp_desc_invit'] : '';

		$user_name			= doctreat_get_username($current_user->ID);
		$user_detail		= get_userdata($current_user->ID);
		$user_type			= doctreat_get_user_type( $current_user->ID );
		$linked_profile   	= doctreat_get_linked_profile_id($current_user->ID);
		$profile_url		= get_the_permalink( $linked_profile );
		
		if (class_exists('Doctreat_Email_helper')) {
            if (class_exists('DoctreatInvitationsNotify')) {
				$email_helper = new DoctreatInvitationsNotify();
				if(!empty($email)){
					
					if( is_email($email) ){
						$emailData = array();
						
						$emailData['email']     				= $email;
						$emailData['invitation_content']     	= $content;
						if(!empty($user_type) && $user_type ==='doctors'){
							$emailData['doctor_name']				= $user_name;
							$emailData['doctor_profile_url']		= $profile_url;
							$emailData['doctor_email']				= $user_detail->user_email;
							$emailData['invited_hospital_email']	= $email;
							$email_helper->send_hospitals_email($emailData);
							$_SESSION['camp_send_invit']="yes";
						} else if(!empty($user_type) && $user_type ==='hospitals'){
							$emailData['hospital_name']				= $user_name;
							$emailData['hospital_profile_url']		= $profile_url;
							$emailData['hospital_email']			= $user_detail->user_email;
							$emailData['invited_docor_email']		= $email;
							$email_helper->send_doctors_email($emailData);
							$_SESSION['camp_send_invit']="yes";
						}
					}
					
				}
				
                $current_url=home_url( $wp->request );
                $user_identity 	 = $current_user->ID;
	
				$query_arg['ref'] = 'team';	
				$query_arg['identity'] = $user_identity;
				$query_arg['mode'] = 'manage';
				
				$permalink = add_query_arg(
		        $query_arg, esc_url( $current_url  )
		        );

				wp_safe_redirect( $permalink );

				exit;
            } 
        }			
		
	}	

}

add_action('template_redirect', 'camp_send_invit');

// add the ajax fetch js
add_action( 'wp_footer', 'camp_ajax_fetch' );
function camp_ajax_fetch() {
?>
	<script type="text/javascript">
		function camp_ajax_fetch(){
		    jQuery.ajax({
		        url: '<?php echo admin_url('admin-ajax.php'); ?>',
		        type: 'post',
		        data: { action: 'camp_data_fetch', keyword_search_doctors: jQuery('#contact-list-search').val() },
		        success: function(data) {
		            jQuery('#contact-list').html( data );
		        }
		    });

		}
	</script>
<?php
}

// the ajax function
add_action('wp_ajax_camp_data_fetch' , 'camp_data_fetch');
add_action('wp_ajax_nopriv_camp_data_fetch','camp_data_fetch');

function camp_data_fetch(){
	global $current_user;
	$user_identity  = $current_user->ID;
	$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
	$pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
	$pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
	$paged 			= max($pg_page, $pg_paged);
	$order 			= 'DESC';
	$sorting 		= 'ID';

	$args_doctors_search = array(
		'posts_per_page' 	=> $show_posts,
		'post_type' 		=> 'doctors',
		'orderby' 			=> $sorting,
		'order' 			=> $order,
		'post_status' 		=> array('publish'),
		'paged' 			=> $paged,
		's' 			    => esc_attr( $_POST['keyword_search_doctors'] ),
		'suppress_filters' 	=> false
	);
	$query_2 				= new WP_Query($args_doctors_search);
	$count_post_2 		= $query_2->found_posts;
    
    if( $query_2->have_posts() ){
			$user_detail= get_userdata($user_identity);
			$current_profile=doctreat_get_linked_profile_id( $user_identity);
			while ($query_2->have_posts()) : $query_2->the_post();				
				global $post;				
				if ($post->ID !== $current_profile) :
					$doctor_id	= doctreat_get_linked_profile_id( $post->ID,'post' );
					$doctor_info = get_userdata($doctor_id);
					$doctor_email = $doctor_info->user_email;				
					$address		= get_post_meta( $post->ID , '_address',true );
					$address		= !empty( $address ) ? $address : 'No adress found!';
					?>
                    <li class="list-group-item" style="display: flex;">
                        <div class="col-xs-12 col-sm-3">
                            <img src="<?php the_post_thumbnail_url();?>" alt="<?php the_title();?>" style="border-radius: 50%;" class="img-responsive img-circle" />
                        </div>
                        <div class="col-xs-12 col-sm-9">
                        	<span class="name"><?php the_title();?></span><br/>

                            <span class="lnr lnr-map-marker text-muted c-info" data-toggle="tooltip" title="<?php echo $address;?>"></span>	                            
                            
                            <span class="lnr lnr-bubble text-muted c-info" data-toggle="tooltip" title="<?php echo $doctor_email;?>"></span>                                      
                             	

                            <a data-toggle="collapse" href="<?php echo '#collapse'.$post->ID;?>" aria-expanded="false" aria-controls="<?php echo '#collapse'.$post->ID;?>" ><span class="lnr lnr-select"></span></a>

                            <div class="collapse" id="<?php echo 'collapse'.$post->ID; ?>">	                            	
							    <div class="container">						
									<div class="dc-collapseexp" style="background-color: transparent;">
										<div class="dc-formtheme dc-userform">
											<fieldset>
												<form action="" method="post">		
													<div class="form-group">
														<textarea class="form-control" name="_desc_invit" placeholder="<?php esc_html_e('Laissez un message','doctreat');?>"></textarea>
													</div>
													<div class="form-group">				
													<input type= "hidden" name="doctor_email_invit" value="<?php echo $doctor_info->user_email ;?>">		
														
													<input type= "hidden" name="camp_action_" value="add_invit">			
													<input type= "submit" class="add-repeater-services dc-btn" value="<?php esc_attr_e('Send invit','doctreat');?>">
													</div>
												</form>								
											</fieldset>
										</div> 						  
									</div>
								</div>										
							 </div>	
							<!-- The Modal -->	
                        </div>                        
                        <div class="clearfix"></div>
                    </li><?php 
				endif;								
            
			endwhile;
			wp_reset_postdata();

			if (!empty( $count_post_2 ) && $count_post_2 > $show_posts) {
				doctreat_prepare_pagination( $count_post_2, $show_posts );
			}
		?>
	<?php } else { 
		do_action('doctreat_empty_records_html','dc-empty-saved-doctors dc-emptyholder-sm',esc_html__( 'Empty Doctor list.', 'doctreat' ));
	}

    die();
}