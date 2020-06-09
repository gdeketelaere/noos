<?php
/**
 *
 * The template used for displaying default specialities result
 *
 * @package   doctreat
 * @author    Amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */
global $wp_query;
get_header();
$archive_show_posts    = get_option('posts_per_page');
$current_term_id=get_queried_object()->term_id;
$current_term_slug=get_queried_object()->slug;
$key='_key_speciality'.$current_term_id;
camp_add_term_meta ('specialities', $current_term_id, $current_term_slug);
$current_lang=get_locale();
global $TRP_LANGUAGE;
$current_lang=strtolower ( $TRP_LANGUAGE );
//print_r($current_lang);
$found_desc=0;
$found_bf=0;
$found_cf=0;
?>

<div class="container" style="margin-bottom: 50px;">

	<div class="row">

		<div class="col col-sm-4">

			<figure class="dc-docsingleimg">
				<img class="dc-ava-detail" src="<?php the_field('camp_photo_specialities','term_'.$current_term_id); ?>" alt="<?php echo esc_attr( get_queried_object()->name );?>">			
			</figure>
		</div>
		<div class="col col-sm-8 spec-desc">
			<div class="">
				<h1>
					<?php echo esc_attr( get_queried_object()->name );?>
				</h1>		
				<div class="">
					<?php			
					if( have_rows('camp_text_specialities', 'term_'.$current_term_id) ):
						while ( have_rows('camp_text_specialities', 'term_'.$current_term_id) ) : the_row();
							$langue_desc=get_sub_field('langue')->slug;
							if ($langue_desc===$current_lang && get_sub_field('description')) {
								echo get_sub_field('description');
								$found_desc=1;
							}
						endwhile;
					endif;
					if( $found_desc===0):
						echo esc_html( get_queried_object()->description );
					endif;?>
				</div>
				<br>
				<a href="#bloc_biencontre" class="dc-btn"><?php esc_html_e('Voir plus');?></a>	
			</div>
		</div>
	</div>
</div>

<div class="container" style="text-align: center;margin-bottom: 50px;">
	<form action="<?php echo home_url( '/' ); ?>">
		<div class="row">

			<div class="service-heading-block col-md-12">
				<h2 class="text-center text-primary title"><?php _e( 'Quelques spécialistes en ','camp' ); echo ucfirst(get_queried_object()->name) ; ?>            	
				</h2>           
			</div>

			<?php	

			$args = array('post_type' => 'doctors',
						'tax_query' => array(
							array(
								'taxonomy' => 'specialities',
								'field' => 'term_id',
								'terms' => $current_term_id,
							),
						),           
									
					);
			$loop = new WP_Query($args);

			if($loop->have_posts()) {

				$count=1;

				while($loop->have_posts()) : $loop->the_post();

					if ($count<=3) :

						$doctor_avatar = apply_filters(
						'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar( array( 'width' => 255, 'height' => 250 ), get_the_ID() ), array( 'width' => 255, 'height' => 250 )
						);

						$doctor_avatar_2x = apply_filters(
											'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar( array( 'width' => 545, 'height' => 428 ), get_the_ID() ), array( 'width' => 545, 'height' => 428 )
										);
						$featured	= get_post_meta(get_the_ID(),'is_featured',true);
						
				?>
						<div class="col col-sm-4">
							<div class="CustomCard hoverCustomCard">
								<div class="CustomCardheader text-white btn-primary">
									<h5 class="col pt-2"><strong><?php the_title(); ?></strong></h5>              
								</div>
								<div class="avatar">
									<?php if( !empty( $doctor_avatar ) ){?>
										
											<img class="dc-ava-detail" src="<?php echo esc_url( $doctor_avatar );?>" alt="<?php echo esc_attr( get_the_title() );?>">
											<img class="dc-ava-detail-2x" src="<?php echo esc_url( $doctor_avatar_2x );?>" alt="<?php echo esc_attr( get_the_title() );?>">
											<?php if( !empty( $featured ) && intval($featured) > 0 ){ ?>
												<figcaption>
													<span class="dc-featuredtag"><i class="fa fa-bolt"></i></span>
												</figcaption>
											<?php } ?>
										
									<?php }?>
									
								</div>
								<div class="info">
									<div class="desc">

										<?php
										$symtomes	= get_the_term_list( get_the_ID(), 'specialities', '<ul class="dc-specializationslist"><li><span>', '</span></li><li><span>', '</span></li></ul>' );
										echo do_shortcode($symtomes);?>

									</div>		            	
								
									<div class="desc"> <?php
										$content = get_the_content();
										$content = strip_tags($content);
										echo substr($content, 0, 200).'...';
										?>                            	
									</div>
									<footer class="blockquote-footer float-right">     		
										
										<span><i class="ti-direction-alt"></i>
										<?php
										$locations	= get_the_term_list( get_the_ID(), 'locations');
										echo do_shortcode($locations);?>
										</span>		            		
									
									</footer>
								</div>
								<div class="bottom mx-auto">			                
									<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm mx-2" rel="publisher">
										<img draggable="false" role="img" class="emoji" alt="▶" src="https://s.w.org/images/core/emoji/12.0.0-1/svg/25b6.svg">
									</a>		                
									
								</div>
							</div>
						</div>				

					<?php endif;

					$count++;

				endwhile; 
			} 
		?>
		</div>
		<div class="form-group submit_field">
			<input type="hidden" name="s" value="<?php the_search_query(); ?>" id="s">
			<input type="hidden" name="c_see_more_type" value="doctors">
			<input type="hidden" name="c_see_more_filter_key" value="specialities">
			<input type="hidden" name="c_see_more_filter_value" value="<?php echo $current_term_slug ;?>">			
			<input type="submit" name="" value="<?php _e( 'Découvrir plus de praticiens','camp' );?>" class="dc-btn">
		</div>
	</form>
</div>

<div class="container text-center" style="margin-bottom: 50px;">
	<form action="<?php echo home_url( '/' ); ?>">
		<div class="row">
			<div class="service-heading-block col-lg-12 col-md-12 col-sm-12">
				<h2 class="text-center text-primary title"><?php _e( 'Troubles Liés','camp' );?>           	
				</h2>
			</div> 
			
			<?php
			
			if( have_rows('camp_symptomes_specialities', 'term_'.$current_term_id) ):

				$count2=1; 

				while ( have_rows('camp_symptomes_specialities', 'term_'.$current_term_id) ) : the_row();

					if ($count2<=8) {

						$symtome=get_sub_field('symtome');						
						if (!get_term_meta( $symtome->term_id, $key, true)){
							add_term_meta( $symtome->term_id, $key, $current_term_slug );
						}
						
					?>
						<div class="col-lg-3 col-md-6 col-sm-6">
						  <div class="text-center feature-block">
							<span class="fb-icon color-info">
							  <img alt="" src="<?php the_field('camp_logo_symtomes','term_'.$symtome->term_id); ?>">
							</span>
							<h4 class="color-info"><?php echo ucfirst($symtome->name) ; ?></h4>
							<a href="<?php echo get_term_link($symtome, 'symtomes'); ?>" class="dc-btn" data-no-translation=""><?php _e( 'Lire la suite','camp' );?></a>
						  </div>
						</div>		    
					<?php

					$count2++;

					}

				endwhile; ?>		
			<?php endif;
			?>
			
			
		</div>
		<div class="form-group submit_field">
			<input type="hidden" name="s" value="<?php the_search_query(); ?>" id="s">
			<input type="hidden" name="c_see_more_type" value="symtomes">
			<input type="hidden" name="c_see_more_filter_key" value="<?php echo $key ;?>">
			<input type="hidden" name="c_see_more_filter_value" value="<?php echo $current_term_slug ;?>">			
			<input type="submit" name="" value="<?php _e( 'Autres troubles associés','camp' );?>" class="dc-btn">
		</div>
	</form>
  
</div>

<div class="container text-center" style="margin-bottom: 50px;">
	<form action="<?php echo home_url( '/' ); ?>">
		<div class="row">
			<div class="service-heading-block col-lg-12 col-md-12 col-sm-12">
				<h2 class="text-center text-primary title"><?php _e( 'Consultez les articles de notre blog','camp' );?>           	
				</h2>
			</div> 

			<?php
			
			$args3=array('post_type' => 'post','posts_per_page'=>4, 'post_status' => 'publish', 'cat' => $current_term_slug);

			$loop3 = new WP_Query($args3);

			if( have_posts() ) :
				while($loop3->have_posts()) : $loop3->the_post();					
			?>       
			  
				<div class="col-lg-3 col-md-6 col-sm-6">
				  <div class="text-center feature-block">
					<span class="fb-icon color-info">
					  <img alt="" src="<?php the_post_thumbnail_url(); ?>">
					</span>
					<p class="color-info"><?php echo strtoupper(get_queried_object()->name) ; ?></p>
					<a href="<?php the_permalink(); ?>"><h4 class="color-info"><?php the_title(); ?></h4></a>
					<div class="custom-articlesdocinfo">
						<?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
						<span><?php echo get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) );?></span>				
					</div>
				  </div>
				</div>

			<?php endwhile; 
			endif; 

			wp_reset_postdata();?>
			
			
		</div> 
		<div class="form-group submit_field">
			<input type="hidden" name="s" value="<?php the_search_query(); ?>" id="s">
			<input type="hidden" name="c_see_more_type" value="post">
			<input type="hidden" name="c_see_more_filter_key" value="category">
			<input type="hidden" name="c_see_more_filter_value" value="<?php echo $current_term_slug ;?>">			
			<input type="submit" name="" value="<?php _e( 'Découvrir plus d’articles ','camp' );?>" class="dc-btn">
		</div>
	</form>
  
</div>

<div class="container" id="bloc_biencontre" style="margin-bottom: 50px;">

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 spec-desc">
			<h2 class="dc-title">
				<?php  _e('Les bienfaits de cette spécialité','camp');?>
			</h2>		
			<div class="">
				<?php			
					if( have_rows('camp_text_specialities', 'term_'.$current_term_id) ):
						while ( have_rows('camp_text_specialities', 'term_'.$current_term_id) ) : the_row();
							$langue_desc=get_sub_field('langue')->slug;
							if ($langue_desc===$current_lang && get_sub_field('bienfaits')) {
								echo get_sub_field('bienfaits');
								$found_bf=1;
							}
						endwhile;
					endif;
					if( $found_bf===0):
						the_field('camp_bienfaits_specialities','term_'.$current_term_id);
					endif;
				?>
			</div>		
			
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 spec-desc">
			<h2 class="">
				<?php  _e('Les contre-indications de cette spécialité','camp');?>
			</h2>		
			<div class="">
				<?php			
					if( have_rows('camp_text_specialities', 'term_'.$current_term_id) ):
						while ( have_rows('camp_text_specialities', 'term_'.$current_term_id) ) : the_row();
							$langue_desc=get_sub_field('langue')->slug;
							if ($langue_desc===$current_lang && get_sub_field('contrefaits')) {
								echo get_sub_field('contrefaits');
								$found_cf=1;
							}
						endwhile;
					endif;
					if( $found_cf===0):
						the_field('camp_contre_specialities','term_'.$current_term_id);
					endif;
				?>
			</div>		
			
		</div>
	</div>
</div>

<?php
get_footer();