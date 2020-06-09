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
global $current_user;
$user_identity 	 = $current_user->ID;
$linked_profile  = doctreat_get_linked_profile_id($user_identity);
$post_id 		 = $linked_profile;


$user_info = get_userdata($user_identity);
//$user_roles= implode(',', $user_info->roles);
$user_roles= $user_info->roles;
$user_type=(string)$user_roles[0];

//print_r($user_type); die();

if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
$paged 			= max($pg_page, $pg_paged);
$order 			= 'DESC';
$sorting 		= 'ID';

$save_references_ids	= get_post_meta( $post_id, '_saved_references', true);

$empty_array[] = array('id'=>0, 'comment'=>'');
$array_ids=!empty($save_references_ids) ? $save_references_ids : $empty_array;

$post_array_ids=array();

foreach ($array_ids as $key => $value) {

	$post_array_ids[]=$value['id'];

}

$args = array(
	'posts_per_page' 	=> $show_posts,
    'post_type' 		=> $user_type,
    'orderby' 			=> $sorting,
    'order' 			=> $order,
    'paged' 			=> $paged,
	'post__not_in' 		=> $post_array_ids,
    'suppress_filters' 	=> false
);

$loop = new WP_Query($args);
$count_post = $loop->found_posts;
//print_r($count_post); die();

if (isset($_SESSION['reference_notice_add']) && $_SESSION['reference_notice_add']=="yes" ) {
	echo '<div id="message" class="alert-success">
		<p>Votre référence a été ajoutée avec succes</p></div>';
	$_SESSION['reference_notice_add']="";
}

?>

</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right">
	<div class="dc-dashboardbox dc-dashboardinvocies">
		<div class="dc-dashboardboxtitle dc-titlewithsearch">
			<h2><?php esc_html_e( 'Add References', 'doctreat' ); ?></h2>
		</div>
		<div><input type="text" name="ref-list-search" id="ref-list-search" placeholder="search here..." onkeyup="camp_ajax_fetch_ref_new()"></input></div>

		<div class="dc-dashboardboxcontent dc-categoriescontentholder dc-categoriesholder">		
			<div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo" id="references-list">
				<?php

					if($loop->have_posts()) :

					    while($loop->have_posts()) : $loop->the_post();

					    	global $post;
					    	$post_ref_id=$post->ID;
					    	$featured	= get_post_meta(get_the_ID(),'is_featured',true);
					    	$verified	= get_post_meta($post_ref_id, '_is_verified', true);
							$verified	= !empty( $verified ) ? $verified	: '';
			    	
				?>
							<div class="dc-docpostholder">
								<div class="dc-docpostcontent" style="display: flex; flex-wrap: wrap; justify-content: space-around;">	
									<div class="dc-searchvtwo" style="width: 80%; padding: 10px;">								
										<figure class="dc-docpostimg" style="width: 100px;">
											<img class="dc-image-res" src="<?php the_post_thumbnail_url(); ?>" alt="Summer spring Hospital">
											<img class="dc-image-res-2x" src="<?php the_post_thumbnail_url(); ?>" alt="Summer spring Hospital">
										</figure>
										<div class="dc-title">
											<div class="dc-doc-specilities-tag">
												<?php do_action('camp_specilities_list',$post_ref_id);?>
												<?php do_action('camp_specilities_list',$post_ref_id,'symtomes');?>
											</div>
											<h3 style="width: 100%;">
												<a href="<?php the_permalink();?>"><?php the_title();?></a>
												<?php if (!empty($_is_verified)) {?>
													<i class="far fa-check-circle dc-awardtooltip dc-tipso tipso_style" style="color:#1abc9c;" data-tipso="Verified user"></i><?php
												}
												?>												
											</h3>
											<ul class="dc-docinfo">
												<li><em>All our best </em></li>
											</ul>							
										</div>
									</div>
									<div class="dc-actions" style="width: 20%;">
										<a data-toggle="collapse" class="camp-add-reference" href="<?php echo '#collapse'.$post_ref_id;?>" aria-expanded="false" aria-controls="<?php echo '#collapse'.$post_ref_id;?>">
											<span class="lnr lnr-plus-circle"></span>
										</a>										
									</div>						
								</div>
							</div>
							<!-- Open The Modal -->
							<div class="collapse" id="<?php echo 'collapse'.$post_ref_id;?>">
							    <div class="container">
									<div class="dc-tabscontenttitle dc-addnew">
										<h3><?php esc_html_e('Pourquoi cette recommandation ?','doctreat');?></h3>
									</div>					
									<div class="dc-collapseexp" style="background-color: transparent;">
										<div class="dc-formtheme dc-userform">
											<fieldset>
												<form action="" method="post">					    					
													<div class="form-group">
														<textarea class="form-control" name="camp_desc_reference" placeholder="<?php esc_html_e('Laissez un commentaire','doctreat');?>"><?php //echo($_POST['camp_desc_service']);?></textarea>
													</div>
													<div class="form-group">
														<input type= "hidden" name="camp_post_id_ref" value="<?php echo $post_ref_id ;?>">
														<input type= "hidden" name="camp_post_id_user_ref" value="<?php echo $post_id ;?>">
														<input type= "hidden" name="camp_action_ref" value="add">			
														<input type= "submit" class="add-repeater-services dc-btn" value="<?php esc_attr_e('Add recommandation','doctreat');?>">
													</div>
												</form>								
											</fieldset>
										</div> 						  
									</div>
								</div>
							 </div>	
							<!-- The Modal -->
													
						<?php endwhile;
						if ( !empty($count_post) && $count_post > $show_posts ) :
							doctreat_prepare_pagination($count_post, $show_posts );
						endif; 
						

					else: do_action('doctreat_empty_records_html','dc-empty-saved-doctors',esc_html__( 'No item found!', 'doctreat' ));
					
					endif;
				?>
			</div>			
		</div>
	</div>
</div>
<script type="text/javascript">
	function camp_ajax_fetch_ref_new(){
	    jQuery.ajax({
	        url: '<?php echo admin_url('admin-ajax.php'); ?>',
	        type: 'post',
	        data: { action: 'camp_data_fetch_ref_new', keyword_search_ref_new : jQuery('#ref-list-search').val() },
	        success: function(data) {
	            jQuery('#references-list').html( data );
	        }
	    });

	}
</script>