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
global $current_user, $wp_roles, $userdata, $post;
$user_identity 	 = $current_user->ID;
$linked_profile  = doctreat_get_linked_profile_id($user_identity);
$post_id 		 = $linked_profile;
$am_specialities = doctreat_get_post_meta( $post_id,'am_specialities');

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
<?php 

if (isset($_GET['create_service'])) {
	
	if ($_GET['create_service']=="success") {

		$notification_create_service='<div id="message" class="alert-success"><p>Votre service a été créé avec succes. vous pouvez desormais l\'ajouter dans la liste</p></div>';
	}

	if ($_GET['create_service']=="error") {

		$notification_create_service='<div id="message" class="alert-error"><p>Une erreur est survenue... veuillez reéssayer !</p></div>';
	}

} 

else 

{

	$notification_create_service='';

}
//echo json_encode($specialities_json['categories']);
//print_r($am_specialities);
echo $notification_create_service;

?>
<form class="dc-user-profile-specialities" method="post">	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-8">
		<div class="dc-dashboardbox dc-offered-holder">
			<div class="dc-dashboardboxtitle">
				<h2><?php esc_html_e('Manage Services','doctreat');?></h2>
			</div>
			<div class="dc-dashboardboxcontent">
				<div class="dc-tabscontenttitle dc-addnew" style="display: flex; justify-content: space-between;">
					<h3><?php esc_html_e('Offered Services','doctreat');?></h3>
					<a href="javascript:;" class="dc-add_service"><?php esc_html_e('Add New','doctreat');?>
					<a href="javascript:;" class="dc-add_service" id="myBtn"><?php esc_html_e('Create New','doctreat');?>
					</a>
				</div>
				<div class="dc-specilities-items">
					<?php
						if( !empty( $am_specialities ) ){
							foreach( $am_specialities as $keys => $item ) {?>
								<div class="repeater-wrap-inner specialities_parents dc-specility-<?php echo intval($keys);?>" id="<?php echo intval($keys);?>">
									<div class="remove-repeater"><i class="lnr lnr-trash"></i></div>
									<div class="am_field">
										<div class="am_field dropdown-style">
											<span class="dc-select">
												<?php echo apply_filters('doctreat_get_specialities_list','am_specialities['.$keys.'][speciality_id]',$keys,0);?>
											</span>
										</div>
									</div>
									<ul class="dc-experienceaccordion accordion services-wrap dc-addnew">
										<li class="dc-system-btn-holder">
											<div class="system-buttons">
												<a href="javascript:;" id="add-service-<?php echo intval($keys);?>" data-id="<?php echo intval($keys);?>" class="add-repeater-services dc-btn"><?php echo esc_html__('Add Services','doctreat');?></a>
											</div>
										</li>
										<?php

											if( !empty( $item )) {
												$sp_services	= doctreat_list_service_by_specialities($keys);
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
																<a href="javascript:;" class="dc-addinfo dc-skillsaddinfo" id="accordioninnertitle<?php echo intval( $service_key);?>" data-toggle="collapse" data-target="#innertitle<?php echo intval( $service_key);?>" aria-expanded="true"><i class="lnr lnr-pencil"></i></a>
																<a href="javascript:;" class="dc-deleteinfo"><i class="lnr lnr-trash"></i></a>
															</div>
														</div>
													</div>
													<div class="dc-collapseexp collapse" id="innertitle<?php echo intval( $service_key);?>" aria-labelledby="accordioninnertitle<?php echo intval( $service_key);?>" data-parent="#accordion">
														<?php if( !empty( $sp_services ) ) { ?>
															<div class="dc-formtheme dc-userform">
																<fieldset>
																	<div class="form-group form-group-half">
																		<div class="am_field dropdown-style related-services">
																			<span class="dc-select">
																				<select name="am_specialities[<?php echo intval( $keys );?>][services][<?php echo intval( $service_key );?>][service]" class="sp_services">
																					<?php 
																					foreach ( $sp_services as $sp_service ){ 
																						if (isset($service['service']) and $service['service'] <> '') { 
																							$selected_value = $service['service']; 
																						}else{
																							$selected_value = '';
																						}
																						
																						if( $selected_value == $sp_service->term_id ) {
																							$selected = 'selected="selected"';
																						} else {
																							$selected = '';
																						}?>
																						<option <?php echo esc_attr($selected);?> value="<?php echo esc_attr( $sp_service->term_id );?>"><?php echo esc_html( $sp_service->name);?></option>
																					<?php }?>
																				</select>
																			</span>
																		</div>
																	</div>
																	<div class="form-group form-group-half">
																		<input type="text" name="am_specialities[<?php echo intval( $keys );?>][services][<?php echo intval( $service_key );?>][price]" class="form-control" placeholder="<?php esc_attr_e('Price','doctreat');?>" value="<?php echo esc_attr( $service_price );?>">
																	</div>
																	<div class="form-group form-group-half">
																		<input type="number" name="am_specialities[<?php echo intval( $keys );?>][services][<?php echo intval( $service_key );?>][time]" class="form-control" placeholder="<?php esc_attr_e('Time','doctreat');?>" value="<?php echo esc_attr( $service_time );?>">
																	</div>
																	<div class="form-group">
																		<textarea name="am_specialities[<?php echo intval( $keys );?>][services][<?php echo intval( $service_key );?>][description]" placeholder="<?php esc_attr_e('Description','doctreat');?>" class="form-control"><?php echo esc_html( $service['description'] );?></textarea>
																	</div>
																</fieldset>
															</div>
													<?php } ?>
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
		<div class="dc-updatall">
			<i class="ti-announcement"></i>
			<span><?php esc_html_e('Post services, by just clicking on “Update Services” button.','doctreat');?></span>
			<a class="dc-btn dc-update-services" data-id="<?php echo esc_attr( $user_identity ); ?>" data-post="<?php echo esc_attr( $post_id ); ?>" href="javascript:;"><?php esc_html_e('Update Services','doctreat');?></a>
		</div>		

	</div>
	
	<?php wp_nonce_field('dc_doctors_specialities_data_nonce', 'profile_submit'); ?>
</form>          
<?php
	wp_add_inline_script('doctreat-callback', "
			var DT_Editor = {};
			DT_Editor.elements = {};
			window.DT_Editor = DT_Editor;
			DT_Editor.elements = jQuery.parseJSON( '" . addslashes(json_encode($specialities_json['categories'])) . "' );
		", 'after');
	?>

<!-- Open The Modal -->
<!-- The Modal -->

<div id="myModal" class="modal">
    <!-- Modal content -->
	<div class="modal-content">
	    <div class="modal-header">
	        <span class="close">×</span>
	      
			<div class="container">
				<div class="dc-tabscontenttitle dc-addnew">
					<h3><?php esc_html_e('Create Service','doctreat');?></h3>
				</div>					
				<div class="dc-collapseexp" style="background-color: transparent;">
					<div class="dc-formtheme dc-userform">
						<fieldset>
							<form action="" method="post" enctype="multipart/form-data">
		    					<?php wp_nonce_field( "action_camp_create_service", "camp_create_service", true, true );?>
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

								<!--div class="form-group">
									<textarea name="" class="form-control" name="camp_desc_service" placeholder="<?php// esc_attr_e('Description','doctreat');?>"><?php //echo($_POST['camp_desc_service']);?></textarea>
								</div-->
								<div class="form-group">
									<input type= "hidden" name="camp_post_id_service" value="<?php echo $post_id ;?>">			
									<input type= "submit" class="add-repeater-services dc-btn" style="border" value="<?php esc_attr_e('Create','doctreat');?>">
								</div>
							</form>								
						</fieldset>
					</div> 						  
				</div>
			</div>
		</div>
	</div>
</div>

<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
            
<script type="text/template" id="tmpl-load-specialities">
	<div class="repeater-wrap-inner specialities_parents dc-specility-{{data.counter}}" id="{{data.counter}}">
		<div class="remove-repeater"><i class="lnr lnr-trash"></i></div>
		<div class="am_field">
			<div class="am_field dropdown-style">
				<span class="dc-select">
					<?php doctreat_get_specialities_list('am_specialities[{{data.counter}}][speciality_id]');?>
				<span>
			</div>
		</div>
		<ul class="dc-experienceaccordion accordion services-wrap dc-addnew">
			<li class="dc-system-btn-holder">
				<div class="system-buttons">
					<a href="javascript:;" id="add-service-{{data.counter}}" data-id="{{data.counter}}" class="add-repeater-services dc-btn"><?php echo esc_html__('Add Services','doctreat');?></a>
				</div>
			</li>
		</ul>
	</div>
</script>

<script type="text/template" id="tmpl-camp-load-services">
	<li class="repeater-wrap-inner services-item" id="{{data.counter}}">
		<div class="dc-accordioninnertitle dc-subpaneltitle dc-subpaneltitlevtwo">
			<span id="accordioninnertitle{{data.counter}}" data-toggle="collapse" data-target="#innertitle{{data.counter}}"><?php esc_html_e('Service title', 'doctreat'); ?>
			</span>
			<div class="dc-rightarea">
				<em><?php esc_html_e('Price', 'doctreat'); ?></em>
				<div class="dc-btnaction">
					<a href="javascript:;" class="dc-addinfo dc-skillsaddinfo" id="accordioninnertitle{{data.counter}}" data-toggle="collapse" data-target="#innertitle{{data.counter}}" aria-expanded="true"><i class="lnr lnr-pencil"></i></a>
					<a href="javascript:;" class="dc-deleteinfo"><i class="lnr lnr-trash"></i></a>
				</div>
			</div>
		</div>
		<div class="dc-collapseexp collapse show" id="innertitle{{data.counter}}" aria-labelledby="accordioninnertitle{{data.counter}}" data-parent="#accordion">
			<div class="dc-formtheme dc-userform">
				<fieldset>
					<div class="form-group form-group-half">
						<div class="am_field dropdown-style related-services">
							<span class="dc-select">
								<select name="am_specialities[{{data.id}}][services][{{data.counter}}][service]" class="sp_services">
									<#if( !_.isEmpty(data['options']) ) {#>
										<#
											var _option	= '';
											_.each( data['options'] , function(element, index, attr) {
												var _checked	= '';

											#>
												<option value="{{index}}" data-id="{{index}}">{{element["name"]}}</option>
											<#	
											});
										#>
									<# } #>
								</select>
							</span>
						</div>
					</div>
					<div class="form-group form-group-half">
						<input type="text" class="form-control" name="am_specialities[{{data.id}}][services][{{data.counter}}][price]" class="" placeholder="<?php esc_attr_e('Price','doctreat');?>">
					</div>
					<div class="form-group form-group-half">
						<input type="number" class="form-control" name="am_specialities[{{data.id}}][services][{{data.counter}}][time]" class="" placeholder="<?php esc_attr_e('Time','doctreat');?>">
					</div>
					<div class="form-group">
						<textarea name="am_specialities[{{data.id}}][services][{{data.counter}}][description]" class="form-control" placeholder="<?php esc_attr_e('Description','doctreat');?>"></textarea>
					</div>
				</fieldset>
			</div>
		</div>
	</li>
</script>
<script type="text/template" id="tmpl-load-services-options">
	<# if( !_.isEmpty(data['options']) ) {#>
		<# _.each( data['options'] , function(element, index, attr) {#>
				<option value="{{index}}" data-id="{{index}}">{{element["name"]}}</option>
			<#	});
		#>
	<# } #>
</script>
<script>
	// Get the modal
	var modal = document.getElementById('myModal');

	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	  modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}

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

