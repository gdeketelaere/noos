<?php

/**

 *

 * The template part for displaying the dashboard menu

 *

 * @package   Doctreat

 * @author    Amentotech

 * @link      http://amentotech.com/

 * @since 1.0

 */





global $post;

$post_id 		 = $post->ID;

$save_references_ids	= get_post_meta( $post_id, '_saved_references', true);

$empty_array[] = array('id'=>0, 'comment'=>'');

$array_ids=!empty($save_references_ids) ? $save_references_ids : $empty_array;

$post_array_ids=array();



foreach ($array_ids as $key => $value) {



	$post_array_ids[]=$value['id'];



}

$show_posts 		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;

$pg_page 			= get_query_var('page') ? get_query_var('page') : 1; 

$pg_paged 			= get_query_var('paged') ? get_query_var('paged') : 1;

$paged 				= max($pg_page, $pg_paged);

$order 	 			= 'DESC';

$sorting 			= 'ID';

$post_type=(string)get_post_type( $post_id );



$args = array(

	'posts_per_page' 	=> $show_posts,

	'post_type' 		=> $post_type,

	'orderby' 			=> $sorting,

	'order' 			=> $order,

	'post_status' 		=> $post_status,

	'author' 			=> $user_identity,

	'paged' 			=> $paged,

	'post__in' 		    => $post_array_ids,

    'suppress_filters' 	=> false

);



$loop = new WP_Query($args);

$count_post = $loop->found_posts;

?>



<div class="tab-pane dc-references"  id="community">

	<div class="dc-dashboardboxtitle dc-titlewithsearch">

		<div class="dc-title"><h3><?php esc_html_e('My Community','doctreat');?></h3></div>

	</div>



	<div class="dc-dashboardboxcontent dc-categoriescontentholder dc-categoriesholder">		

		<div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo">

			<?php



				if($loop->have_posts()) :



					while($loop->have_posts()) : $loop->the_post();

					

						



						global $post;

						$post_ref_id=$post->ID;

						$featured	= get_post_meta(get_the_ID(),'is_featured',true);

						$verified	= get_post_meta($post_ref_id, '_is_verified', true);

						$verified	= !empty( $verified ) ? $verified	: '';

						$address	= get_post_meta( get_the_ID() , '_address',true );

						$address	= !empty( $address ) ? $address : 'Paris';

				

			?>

						<div class="dc-docpostholder dc-card-holder">

							<div class="dc-docpostcontent">	

								<div class="dc-searchvtwo">								

									<figure class="dc-docpostimg">
										<?php the_post_thumbnail( array( 100, 100, 'class' => 'post-thumb dc-image-res') );?>
										<?php the_post_thumbnail( array( 200, 200, 'class' => 'post-thumb dc-image-res-2x') );?>
									</figure>
<div>
									<div class="dc-title">
										<h3>

											<a href="<?php the_permalink();?>"><?php the_title();?></a>

											<?php if (!empty($_is_verified)) {?>

												<i class="far fa-check-circle dc-awardtooltip dc-tipso tipso_style" data-tipso="Verified user"></i><?php

											}

											?>												

										</h3>

							

									</div>
									<div class="dc-docinfo-specialities">
										<?php do_action('camp_specilities_list',$post_ref_id);?>
									</div>
									<div class="dc-docinfo-specialities">
										<?php do_action('camp_specilities_list',$post_ref_id,'symtomes');?>
									</div>

								</div>

								</div>

								<div class="dc-docinfo">

								<p><?php echo camp_get_comment_reference ($post_id, get_the_ID()); ?></p>

								</div>
								<div class="dc-actions">

									<p>

										<img class="dc-icon--small" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/map-pointer.svg'; ?> "/><?php echo $address ;?>

										</p>									

								</div>						

							</div>

						</div>	
	

												

					<?php endwhile;

					wp_reset_postdata();

					if (!empty($count_post) && $count_post > $show_posts) :

						doctreat_prepare_pagination($count_post, $show_posts);

					endif;

				else: do_action('doctreat_empty_records_html','dc-empty-saved-doctors',esc_html__( 'No Recommandations found!', 'doctreat' ));

				endif;

			?>

		</div>			

	</div>

</div>







