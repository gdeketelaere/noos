<?php
/**
 *Template Name: Page blog
 */
$width 		= 1140;
$height 	= 400;
get_header();
?>
<div class="dc-tabscontenttitle camp-title-blog">	
	<h2><?php esc_html_e('LATESTS POST','doctreat');?></h2>
</div>
<div class="container">
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12">
		<div class="dc-innerbanner">
			<div class="dc-formtheme dc-form-advancedsearch dc-innerbannerform">
				<fieldset>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_specialities_1 = array(
			                        'show_option_all'   => __( 'Select a speciality' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_specialities_search_blog_1', 
			                        'id'                => 'camp_specialities_search_blog_1',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'category',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    // Y-a-t'il un Lieu actuellement sélectionnée ?
			                    if ( $_GET['camp_specialities_search_blog_1'] 
			                        && (term_exists( $_GET['camp_specialities_search_blog_1'] , 'specialities' ) ) )  {
			                        $args_specialities_1['selected'] = $_GET['camp_specialities_search_blog_1'] ;
			                    }

			                    $list_specialities_1 = wp_dropdown_categories( $args_specialities_1 );

			                    // Afficher la liste s'il existe des villes associées à des contenus
			                    if ( $list_specialities_1 ) {
			                        echo $list_specialities_1;
			                } ?>
						</div>
					</div>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_symtome_1 = array(
			                        'show_option_all'   => __( 'Select Symtome' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_symtome_search_blog_1', 
			                        'id'                => 'camp_symtome_search_blog_1',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'symtomes',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    // Y-a-t'il un Lieu actuellement sélectionnée ?
			                    if ( $_GET['camp_symtome_search_blog_1'] 
			                        && (term_exists( $_GET['camp_symtome_search_blog_1'] , 'symtomes' ) ) )  {
			                        $args_symtome_1['selected'] = $_GET['camp_symtome_search_blog_1'] ;
			                    }

			                    $list_symtome_1 = wp_dropdown_categories( $args_symtome_1 );

			                    // Afficher la liste s'il existe des villes associées à des contenus
			                    if ( $list_symtome_1 ) {
			                        echo $list_symtome_1;
			                } ?>
						</div>
					</div>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_language_1 = array(
			                        'show_option_all'   => __( 'Select a Language' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_language_search_blog_1', 
			                        'id'                => 'camp_language_search_blog_1',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'languages',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    
			                    if ( $_GET['camp_language_search_blog_1'] 
			                        && (term_exists( $_GET['camp_language_search_blog_1'] , 'languages' ) ) )  {
			                        $args_language_1['selected'] = $_GET['camp_language_search_blog_1'] ;
			                    }

			                    $list_language_1 = wp_dropdown_categories( $args_language_1 );
			                   
			                    if ( $list_language_1 ) {
			                        echo $list_language_1;
			                } ?>
						</div>
					</div>
					<div class="dc-btnarea">
						<input type="submit" class="dc-btn search-blog-1" value="<?php esc_attr_e('Search','doctreat');?>">
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
</div>
<div id="camp_response_sb_1"></div>
<div class="blog-list-view-template" id="camp-blog-1" style="display: flex; flex-wrap: wrap; justify-content: center;">
	
	<?php
	$args = array('post_type' => 'post', 'post_status' => 'publish'				      
	 );
	$loop = new WP_Query($args);
	$count=0; 
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
			$symtomes		=  get_the_term_list( get_the_ID(), 'symtomes', '', '', '' );
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
							<?php if(!empty( $symtomes )){?>
								<?php echo do_shortcode($symtomes);?>
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
	$max_page_1=camp_nb_pages($loop);?>
	<input type="hidden" id="hidden_page_1" value="1">
	<input type="hidden"  id="max_page_1" value=<?php echo $max_page_1;?>>
	<?php	
	if ($count>=6):?>
		<div class="theme-nav camp_loadmore1"><?php esc_html_e('Voir plus d\'articles','doctreat');?></div><?php
	endif;
	?>
</div>
<div class="dc-tabscontenttitle camp-title-blog">	
		<h2><?php esc_html_e('TOP READS','doctreat');?></h2>
</div>
<div class="container">
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12">
		<div class="dc-innerbanner">
			<div class="dc-formtheme dc-form-advancedsearch dc-innerbannerform">
				<fieldset>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_specialities_2 = array(
			                        'show_option_all'   => __( 'Select a speciality' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_specialities_search_blog_2', 
			                        'id'                => 'camp_specialities_search_blog_2',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'category',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    
			                    if ( $_GET['camp_specialities_search_blog_2'] 
			                        && (term_exists( $_GET['camp_specialities_search_blog_2'] , 'specialities' ) ) )  {
			                        $args_specialities_2['selected'] = $_GET['camp_specialities_search_blog_2'] ;
			                    }

			                    $list_specialities_2 = wp_dropdown_categories( $args_specialities_2 );

			                    
			                    if ( $list_specialities_2 ) {
			                        echo $list_specialities_2;
			                } ?>
						</div>
					</div>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_symtome_2 = array(
			                        'show_option_all'   => __( 'Select Symtome' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_symtome_search_blog_2', 
			                        'id'                => 'camp_symtome_search_blog_2',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'symtomes',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    // Y-a-t'il un Lieu actuellement sélectionnée ?
			                    if ( $_GET['camp_symtome_search_blog_2'] 
			                        && (term_exists( $_GET['camp_symtome_search_blog_2'] , 'symtomes' ) ) )  {
			                        $args_symtome_2['selected'] = $_GET['camp_symtome_search_blog_2'] ;
			                    }

			                    $list_symtome_2 = wp_dropdown_categories( $args_symtome_2 );

			                    // Afficher la liste s'il existe des villes associées à des contenus
			                    if ( $list_symtome_2 ) {
			                        echo $list_symtome_2;
			                } ?>
						</div>
					</div>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_language_2 = array(
			                        'show_option_all'   => __( 'Select a Language' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_language_search_blog_2', 
			                        'id'                => 'camp_language_search_blog_2',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'languages',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    
			                    if ( $_GET['camp_language_search_blog_2'] 
			                        && (term_exists( $_GET['camp_language_search_blog_2'] , 'languages' ) ) )  {
			                        $args_language_2['selected'] = $_GET['camp_language_search_blog_2'] ;
			                    }

			                    $list_language_2 = wp_dropdown_categories( $args_language_2 );
			                   
			                    if ( $list_language_2 ) {
			                        echo $list_language_2;
			                } ?>
						</div>
					</div>
					<div class="dc-btnarea">
						<input type="submit" class="dc-btn search-blog-2" value="<?php esc_attr_e('Search','doctreat');?>">
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
</div>
<div id="camp_response_sb_2"></div>
<div class="blog-list-view-template" id="camp-blog-2" style="display: flex; flex-wrap: wrap; justify-content: center;">
	<?php
	$args2 = array('post_type' => 'post', 'post_status' => 'publish', 'meta_key' => 'set_blog_view', 'orderby' => 'meta_value_num', 'order' => 'DESC'				      
	 );
	$loop2 = new WP_Query($args2);
	$count2=0; 
	while ($loop2->have_posts()) : $loop2->the_post();
		$count2++;
		if ($count2<=6) :	
		
			global $post;
			$width 		= 1140;
			$height 	= 400;
			$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
			$stickyClass = '';

			$post_views			= get_post_meta($post->ID,'set_blog_view',true);
			$post_views			= !empty( $post_views ) ? $post_views : 0;
			$post_likes			= get_post_meta($post->ID,'post_likes',true);
			$post_likes			= !empty( $post_likes ) ? $post_likes : 0;

			$post_comments		= get_comments_number($post->ID);
			$post_comments		= !empty( $post_comments ) ? $post_comments : 0 ;

		
			if (is_sticky()) {
				$stickyClass = 'sticky';
			}
		
			$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
			$symtomes		=  get_the_term_list( get_the_ID(), 'symtomes', '', '', '' );
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
							<?php if(!empty( $symtomes )){?>
								<?php echo do_shortcode($symtomes);?>
							<?php }?>
																			
							<h3><a href="<?php the_permalink();?>"><?php doctreat_get_post_title(get_the_ID()); ?></a></h3>
							<span class="dc-datetime"><?php doctreat_get_post_date($post->ID); ?></span>
						</div>
						
						<ul class="dc-moreoptions">
							<li class="dcget-likes" data-key="642"><a href="javascript:;"><i class="ti-heart"></i><?php echo sprintf( _n( '%s Like', '%s Likes', $post_likes, 'doctreat' ), $post_likes );?></a></li>
							<li><a href="javascript:;"><i class="ti-eye"></i><?php echo sprintf( _n( '%s View', '%s Views', $post_views, 'doctreat' ), $post_views );?></a></li>
							<li><a href="javascript:;"><i class="ti-comment"></i><?php echo sprintf( _n( '%s Comment', '%s Comments', get_comments_number($post->ID), 'doctreat' ), get_comments_number($post->ID) );?></a></li>
						</ul>						
					</div>
				</div>
			</div>
	<?php endif;
	endwhile;
	$max_page_2=camp_nb_pages($loop2);?>
	<input type="hidden" id="hidden_page_2" value="1">
	<input type="hidden"  id="max_page_2" value=<?php echo $max_page_2;?>><?php
	if ($count2>=6):?>
		<div class="theme-nav camp_loadmore2"><?php esc_html_e('Voir plus d\'articles','doctreat');?></div><?php
	endif;
	?>
</div>
<div class="dc-tabscontenttitle camp-title-blog">	
		<h2><?php esc_html_e('MORE STORIES','doctreat');?></h2>
</div>
<div class="container">
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12">
		<div class="dc-innerbanner">
			<div class="dc-formtheme dc-form-advancedsearch dc-innerbannerform">
				<fieldset>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_specialities_3 = array(
			                        'show_option_all'   => __( 'Select a speciality' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_specialities_search_blog_3', 
			                        'id'                => 'camp_specialities_search_blog_3',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'category',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    // Y-a-t'il un Lieu actuellement sélectionnée ?
			                    if ( $_GET['camp_specialities_search_blog_3'] 
			                        && (term_exists( $_GET['camp_specialities_search_blog_3'] , 'specialities' ) ) )  {
			                        $args_specialities_3['selected'] = $_GET['camp_specialities_search_blog_3'] ;
			                    }

			                    $list_specialities_3 = wp_dropdown_categories( $args_specialities_3 );

			                    
			                    if ( $list_specialities_3 ) {
			                        echo $list_specialities_3;
			                } ?>
						</div>
					</div>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_symtome_3 = array(
			                        'show_option_all'   => __( 'Select Symtome' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_symtome_search_blog_3', 
			                        'id'                => 'camp_symtome_search_blog_3',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'symtomes',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    
			                    if ( $_GET['camp_symtome_search_blog_3'] 
			                        && (term_exists( $_GET['camp_symtome_search_blog_1'] , 'symtomes' ) ) )  {
			                        $args_symtome_3['selected'] = $_GET['camp_symtome_search_blog_3'] ;
			                    }

			                    $list_symtome_3 = wp_dropdown_categories( $args_symtome_3 );

			                    
			                    if ( $list_symtome_3 ) {
			                        echo $list_symtome_3;
			                } ?>
						</div>
					</div>
					<div class="form-group">
						<div class="dc-select">
							<?php 
			                    $args_language_3 = array(
			                        'show_option_all'   => __( 'Select a Language' ), 
			                        'orderby'           => 'name', 
			                        'order'             => 'ASC',
			                        'show_count'        => 0,
			                        'hide_empty'        => 0, 
			                        'echo'              => 0,
			                        'name'              => 'camp_language_search_blog_3', 
			                        'id'                => 'camp_language_search_blog_3',
			                        'class'                => '',
			                        'hierarchical'      => true,
			                        'depth'             => 1,
			                        'taxonomy'          => 'languages',
			                        'hide_if_empty'     => false, 
			                        'value_field'       => 'slug',
			                    );

			                    
			                    if ( $_GET['camp_language_search_blog_3'] 
			                        && (term_exists( $_GET['camp_language_search_blog_3'] , 'languages' ) ) )  {
			                        $args_language_3['selected'] = $_GET['camp_language_search_blog_3'] ;
			                    }

			                    $list_language_3 = wp_dropdown_categories( $args_language_3 );
			                   
			                    if ( $list_language_3 ) {
			                        echo $list_language_3;
			                } ?>
						</div>
					</div>
					<div class="dc-btnarea">
						<input type="submit" class="dc-btn search-blog-3" value="<?php esc_attr_e('Search','doctreat');?>">
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
</div>
<div id="camp_response_sb_3"></div>
<div class="blog-list-view-template" id="camp-blog-3" style="display: flex; flex-wrap: wrap; justify-content: center;">
	<?php
	$args3 = array('post_type' => 'post', 'post_status' => 'publish', 'order' => 'ASC'				      
	 );
	$loop3 = new WP_Query($args3);
	$count3=0; 
	while ($loop3->have_posts()) : $loop3->the_post();
		$count3++;
		if ($count3<=6) :	
		
			global $post;
			$width 		= 1140;
			$height 	= 400;
			$thumbnail  = doctreat_prepare_thumbnail( get_the_ID() , $width , $height);
			$stickyClass = '';

			$post_views			= get_post_meta($post->ID,'set_blog_view',true);
			$post_views			= !empty( $post_views ) ? $post_views : 0;
			$post_likes			= get_post_meta($post->ID,'post_likes',true);
			$post_likes			= !empty( $post_likes ) ? $post_likes : 0;

			$post_comments		= get_comments_number($post->ID);
			$post_comments		= !empty( $post_comments ) ? $post_comments : 0 ;

		
			if (is_sticky()) {
				$stickyClass = 'sticky';
			}
		
			$categries		=  get_the_term_list( get_the_ID(), 'category', '', '', '' );
			$symtomes		=  get_the_term_list( get_the_ID(), 'symtomes', '', '', '' );
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
							<?php if(!empty( $symtomes )){?>
								<?php echo do_shortcode($symtomes);?>
							<?php }?>
																			
							<h3><a href="<?php the_permalink();?>"><?php doctreat_get_post_title(get_the_ID()); ?></a></h3>
							<span class="dc-datetime"><?php doctreat_get_post_date($post->ID); ?></span>
						</div>
						
						<ul class="dc-moreoptions">
							<li class="dcget-likes" data-key="642"><a href="javascript:;"><i class="ti-heart"></i><?php echo sprintf( _n( '%s Like', '%s Likes', $post_likes, 'doctreat' ), $post_likes );?></a></li>
							<li><a href="javascript:;"><i class="ti-eye"></i><?php echo sprintf( _n( '%s View', '%s Views', $post_views, 'doctreat' ), $post_views );?></a></li>
							<li><a href="javascript:;"><i class="ti-comment"></i><?php echo sprintf( _n( '%s Comment', '%s Comments', get_comments_number($post->ID), 'doctreat' ), get_comments_number($post->ID) );?></a></li>
						</ul>						
					</div>
				</div>
			</div>
	<?php endif;
	endwhile;
	$max_page_3=camp_nb_pages($loop3);?>
	<input type="hidden" id="hidden_page_3" value="1">
	<input type="hidden"  id="max_page_3" value=<?php echo $max_page_3;?>><?php
	if ($count3>=6):?>
		<div class="theme-nav camp_loadmore3"><?php esc_html_e('Voir plus d\'articles','doctreat');?></div><?php
	endif;
	?>
</div>

<?php
get_footer(); 