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

$days=array('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche');
$checked	= '';

$notification_add_location='';

//$meta=get_post_meta( $post_id , '_camp_custom_locations', true );
//print_r($_SESSION); die();

if(isset($_SESSION['camp_location']) && !empty($_SESSION['camp_location']) && isset($_SESSION['camp_location_add']) && $_SESSION['camp_location_add']=="yes") {
	
	$location_tab=$_SESSION['camp_location'];

	
			
			
	if(!term_exists( $location_tab['city'], 'locations' )) {
			$term_id= wp_insert_term(
			$location_tab["city"],
			'locations'
		);
	}
	
		
	if (get_post_meta( $post_id , '_camp_custom_locations', false )) {
	
		$locations=get_post_meta( $post_id , '_camp_custom_locations',true );
		$locations[]=$location_tab;
		//print_r($locations); die();
		update_post_meta( $post_id , '_camp_custom_locations', $locations );
		$notification_add_location='<div id="message" class="alert-success">
		<p>Votre location a été ajoutée avec succes</p></div>';
		

	} else {
		$locations=array();
		$locations[]=$location_tab;
		add_post_meta( $post_id , '_camp_custom_locations', $locations );
		$notification_add_location='<div id="message" class="alert-success">
		<p>Votre location a été ajoutée avec succes</p></div>';
	}	
	
	$_SESSION['camp_location']=array();
	$_SESSION['camp_location_add']="no";

}elseif (isset($_SESSION['camp_location_add']) && $_SESSION['camp_location_add']=="yes" && empty($_SESSION['camp_location']) )  {
	$notification_add_location='<div id="message" class="alert-error">
		<p>Ajout échoué! Une erreur est survenue...</p></div>';
}

//print_r($m); die();
echo $notification_add_location;
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right">
	<div class="dc-dashboardbox dc-dashboardinvocies">
		<div class="dc-dashboardboxtitle dc-titlewithsearch">
			<h2><?php esc_html_e( 'Add Location', 'doctreat' ); ?></h2>
		</div>
		<div class="dc-dashboardboxcontent dc-categoriescontentholder dc-categoriesholder">
			<form action="" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field( "action_camp_add_location", "camp_add_location", true, true );?>
				<div class="dc-working-time dc-tabsinfo">
					<div class="dc-tabscontenttitle">
						<h3><?php esc_html_e('Location Details', 'doctreat'); ?></h3>
					</div>
					<div class="dc-formtheme dc-userform">
						<fieldset>
							<div class="form-group form-group-half loc-icon">
								<input type="text" name="city" class="form-control" placeholder="<?php esc_attr_e('Your City', 'doctreat'); ?>">
								<a href="javascript:;" class="geolocate"><i class="fa fa-crosshairs"></i></a>
							</div>
							<div class="form-group form-group-half loc-icon">
								<input type="text" id="location-address-0" name="address" class="form-control"  placeholder="<?php esc_attr_e('Your Address', 'doctreat'); ?>">
								<a href="javascript:;" class="geolocate"><i class="fa fa-crosshairs"></i></a>
							</div>							
							<div class="form-group form-group-half toolip-wrapo">
								<input type="text" id="location-longitude-0" name="longitude" class="form-control"  placeholder="<?php esc_attr_e('Enter Longitude', 'doctreat'); ?>">
								<?php do_action('doctreat_get_tooltip','element','longitude');?>
							</div>
							<div class="form-group form-group-half toolip-wrapo">
								<input type="text" id="location-latitude-0" name="latitude" class="form-control"  placeholder="<?php esc_attr_e('Enter Latitude', 'doctreat'); ?>">
								<?php do_action('doctreat_get_tooltip','element','latitude');?>
							</div>
							<div class="file-upload">
								<button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><?php esc_attr_e('Add Image of Location','doctreat');?></button>
								<div class="image-upload-wrap">
								    <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/png, image/jpeg" name="image_location" />
								    <div class="drag-text">
								      <h3><?php esc_attr_e('Drag and drop a file or select add Image','doctreat');?></h3>
								    </div>
								</div>
								<div class="file-upload-content">
								    <img class="file-upload-image" src="#" alt="your image" />
								    <div class="image-title-wrap">
								        <button type="button" onclick="removeUpload()" class="remove-image"><?php esc_attr_e('Remove','doctreat');?><span class="image-title"><?php esc_attr_e('Uploaded Image','doctreat');?></span></button>
								    </div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="dc-working-days dc-tabsinfo">
					<div class="dc-tabscontenttitle">
						<h3><?php esc_html_e('Days I Offer My Services','doctreat'); ?></h3>
					</div>
					<div class="dc-formtheme dc-userform">
						<fieldset class="dc-offer-holder">						
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<?php 
									foreach ($days as  $key => $day) :?>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="<?php echo 'heading_'.$day ;?>">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="<?php echo '#collapse_'.$day;?>" aria-expanded="true" aria-controls="<?php echo 'collapse_'.$day;?>">
														<?php echo ucfirst($day);?>
													</a>
												</h4>
											</div>
											<div id="<?php echo 'collapse_'.$day;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="<?php echo 'heading_'.$day ;?>">
												<div class="panel-body">
													<div class="form-group  dc-radio-holder">
														<span class="dc-radio">
															<input id="<?php echo 'dc-spaces_'.$day ;?>" class="dc-spaces" type="radio" name="<?php echo 'time_'.$day ;?>" value="24_24">
															<label for="<?php echo 'dc-spaces_'.$day ;?>"><?php esc_html_e('24h/24 working time','doctreat');?></label>
														</span>
														<span class="dc-radio">
															<input id="<?php echo 'dc-others_'.$day ;?>" class="dc-spaces" type="radio" name="<?php echo 'time_'.$day ;?>" value="others">
															<label for="<?php echo 'dc-others_'.$day ;?>"><?php esc_html_e('Others','doctreat');?></label>
														</span>
													</div>
													<div class="form-group  dc-others">
														<input type="text" name="<?php echo 'start_time_'.$day ;?>" class="form-control" placeholder="<?php esc_attr_e('Start Time','doctreat');?>">
													</div>
													<div class="form-group  dc-others ">
														<input type="text" name="<?php echo 'end_time_'.$day ;?>" class="form-control" placeholder="<?php esc_attr_e('End Time','doctreat');?>">
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							
						</fieldset>
					</div>					
				</div>
				<input type= "submit" class="add-repeater-services dc-btn" value="<?php esc_attr_e('Add Location','doctreat');?>">
			</form>	
		</div>
	</div>
</div>
<script>
	function readURL(input) {
	  if (input.files && input.files[0]) {

	    var reader = new FileReader();

	    reader.onload = function(e) {
	      $('.image-upload-wrap').hide();

	      $('.file-upload-image').attr('src', e.target.result);
	      $('.file-upload-content').show();

	      $('.image-title').html(input.files[0].name);
	    };

	    reader.readAsDataURL(input.files[0]);

	  } else {
	    removeUpload();
	  }
	}

	function removeUpload() {
	  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
	  $('.file-upload-content').hide();
	  $('.image-upload-wrap').show();
	}
	$('.image-upload-wrap').bind('dragover', function () {
	        $('.image-upload-wrap').addClass('image-dropping');
	    });
	    $('.image-upload-wrap').bind('dragleave', function () {
	        $('.image-upload-wrap').removeClass('image-dropping');
	});
</script>