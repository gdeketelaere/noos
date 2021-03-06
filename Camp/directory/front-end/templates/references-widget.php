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
$post_type=(string)get_post_type( $post_id );
$sorting 		= 'ID';

$save_references_ids	= get_post_meta( $post_id, '_saved_references', true);

$empty_array[] = array('id'=>0, 'comment'=>'');
$array_ids=!empty($save_references_ids) ? $save_references_ids : $empty_array;
$post_array_ids=array();

foreach ($array_ids as $key => $value) {

	$post_array_ids[]=$value['id'];

}
$args1 = array(
	'posts_per_page' 	=> -1,
    'post_type' 		=> $post_type,
	'post__in' 		    => $post_array_ids,
    'suppress_filters' 	=> false
);

$loop1 = new WP_Query($args1);
$count_post = $loop1->found_posts;

if($count_post>2){
	$max_offset=$count_post - 2;
	$offset = rand(0, $max_offset);
}else {
	$offset = 0;
}

$args = array(
	'posts_per_page' 	=> 2,
	'offset' 	=> $offset,
    'post_type' 		=> $post_type,
	'post__in' 		    => $post_array_ids,
    'suppress_filters' 	=> false
);

$loop = new WP_Query($args);

?>

<div class="dc-dashboardbox dc-dashboardinvocies">
	<div class="dc-dashboardboxtitle dc-titlewithsearch">
		<div class="dc-title"><h4><?php echo $post->post_title ;?><?php esc_html_e(' recommends:','doctreat');?></h4></div>
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
						$comment = camp_get_comment_reference ($post_id, get_the_ID());
						$comment_resume = substr($comment, 0,100);
			?>
						<div class="dc-docpostholder">
							<div class="dc-docpostcontent" style="display: flex; flex-wrap: wrap; justify-content: space-between;">	
								<div class="" style="width: 100%; padding: 10px;">								
									<figure class="dc-docpostimg" style="width: 50px; margin-right: 5px;">
										<img class="dc-image-res" src="<?php the_post_thumbnail_url(); ?>" alt="Summer spring Hospital">
										<img class="dc-image-res-2x" src="<?php the_post_thumbnail_url(); ?>" alt="Summer spring Hospital">
									</figure>
									<div class="dc-title">
										<div class="dc-doc-specilities-tag">
											<?php do_action('camp_specilities_list',$post_ref_id);?>
											<?php do_action('camp_specilities_list',$post_ref_id,'symtomes');?>
										</div>
										<h3 style="width: 100%; color:black;">
											<a href="<?php the_permalink();?>" style="color:black;"><?php the_title();?></a>
											<?php if (!empty($_is_verified)) {?>
												<i class="far fa-check-circle dc-awardtooltip dc-tipso tipso_style" style="color:#1abc9c;" data-tipso="Verified user"></i><?php
											}
											?>												
										</h3>																	
									</div>
									<div class="dc-docinfo" style="color:black;">
										<?php echo $comment_resume.'...'; ?>
									</div>									
								</div>
								<div class="dc-actions">
									<i class="lnr lnr-location"></i><?php echo $address ;?>										
								</div>						
							</div>
						</div>	
						<!-- The Modal -->			
												
					<?php endwhile;

				else: do_action('doctreat_empty_records_html','dc-empty-saved-doctors',esc_html__( 'No Recommandations found!', 'doctreat' ));
				endif;
			?>
		</div>			
	</div>
</div>



