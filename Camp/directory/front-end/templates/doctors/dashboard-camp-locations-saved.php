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
$notification_delete_location='';

if(isset($_SESSION['data_location']) && !empty($_SESSION['data_location'])) {
	
	$location_tab=$_SESSION['data_location'];

	if(!empty($location_tab)) {		
		
		$exist_locations=get_post_meta( $post_id , '_camp_custom_locations',true );
		$key=$location_tab['key'];
		unset($exist_locations[$key]);
		update_post_meta( $post_id , '_camp_custom_locations', $exist_locations );
		$notification_delete_location='<div id="message" class="alert-success">
		<p>Votre location a été supprimée avec succes</p></div>';

		
		
	}
	else{
		$notification_delete_location='<div id="message" class="alert-error">
		<p>Suppression échouée! Une erreur est survenue...</p></div>';
	}
	$_SESSION['data_location']=array();
}
echo $notification_delete_location;
//$locations1 = get_post_meta( $post_id , '_camp_custom_locations', true );
//print_r($locations1);
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right">
	<div class="dc-dashboardbox dc-dashboardinvocies">
		<div class="dc-dashboardboxtitle dc-titlewithsearch">
			<h2><?php esc_html_e( 'Custom Locations Saved', 'doctreat' ); ?></h2>
		</div>

		<div class="dc-dashboardboxcontent dc-categoriescontentholder dc-categoriesholder">		
			<div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo">
				<?php
					if(get_post_meta( $post_id , '_camp_custom_locations', true )):
						$locations = get_post_meta( $post_id , '_camp_custom_locations', true );
						
						foreach ($locations as $key => $location) :
						
							$city=$location['city'];
							$address=$location['address'];
							$logitude=$location['longitude'];
							$latitude=$location['latitude'];
							$image_url=$location['image'];
							$days_offer=!empty($location['days_offer'])? $location['days_offer'] : array();
							
					?>
							<div class="dc-docpostholder">
								<div class="dc-docpostcontent" style="display: flex; flex-wrap: wrap; justify-content: space-around;">	
									<div class="dc-searchvtwo" style="width: 80%; padding: 10px;">								
										<figure class="dc-docpostimg" style="width: 200px;">
											<img class="dc-image-res" src="<?php echo $image_url ;?>" alt="<?php echo $address ;?>">
											<img class="dc-image-res-2x" src="<?php echo $image_url ;?>" alt="<?php echo $address ;?>">
										</figure>
										<div class="dc-title" style="display: flex; flex-wrap: wrap;">											
											<h3 style="width: 70%;">
												<a href=""><i class="ti-direction-alt"></i><?php echo $city.' : '.$address ;?></a>																								
											</h3>
											<ul class="dc-docinfo">
												<?php if (!empty($days_offer)):
														foreach( $days_offer as $key2 => $day_offer) :?>
															<li style="display: flex; flex-wrap: wrap;"><i class="lnr lnr-clock"></i><?php echo ucfirst ($key2).'  :  ';?><em><?php if($day_offer["start_time"]!== $day_offer["end_time"]){ echo $day_offer["start_time"].' - '.$day_offer["end_time"];} else { echo "24h/24";}?></em></li>
														<?php endforeach;?>
												<?php endif;?>
											</ul>							
										</div>
									</div>
									<div class="dc-actions" style="width: 20%;">
										<a data-toggle="collapse" class="camp-delete-reference" href="<?php echo '#collapse'.$key;?>" aria-expanded="false" aria-controls="<?php echo '#collapse'.$key;?>">
											<span class="lnr lnr-trash"></span>
										</a>										
									</div>						
								</div>
							</div>
							<!-- Open The Modal -->
							<div class="collapse" id="<?php echo 'collapse'.$key;?>">
								<div class="container">
									<div class="dc-tabscontenttitle dc-addnew camp-delete-reference-confirm">
										<h3><?php esc_html_e('Voulez-vous supprimer cette location?','doctreat');?></h3>
									</div>					
									<div class="dc-collapseexp" style="background-color: transparent;">
										<div class="dc-formtheme dc-userform">
											<fieldset>
												<form action="" method="post">		
													<div class="form-group">
														<input type= "hidden" name="camp_location_nonce" value="yes">
														<input type= "hidden" name="camp_location_key" value="<?php echo $key ;?>">				
														
														<input type= "submit" class="camp-delete-reference-confirm-btn dc-btn" value="<?php esc_attr_e('delete location','doctreat');?>">
													</div>
												</form>								
											</fieldset>
										</div> 						  
									</div>
								</div>
							</div>	
							<!-- The Modal -->			
														
							<?php 				
						endforeach;
					else:
						do_action('doctreat_empty_records_html','dc-empty-articls dc-emptyholder-sm',esc_html__( 'No Locations saved yet.', 'doctreat' ));
					endif;
					?>
			</div>			
		</div>
	</div>
</div>