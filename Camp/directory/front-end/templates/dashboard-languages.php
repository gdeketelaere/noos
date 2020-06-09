<?php 
/**
 *
 * The template part for displaying the user profile avatar
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */
global $current_user, $wp_roles, $userdata, $post;
$user_identity 	 = $current_user->ID;
$linked_profile  = doctreat_get_linked_profile_id($user_identity);
$post_id		= $linked_profile;

$languages		= doctreat_get_taxonomy_array('languages');
$db_lan				= apply_filters('doctreat_get_tax_query',array(),$post_id,'languages','');
$db_lan				= !empty( $db_lan ) ? wp_list_pluck($db_lan,'name') : array();

?>
<div class="dc-skills dc-tabsinfo">	
	<div class="dc-formtheme dc-skillsform">
		<div class="dc-category-holder dc-tabsinfo">
				<div class="dc-tabscontenttitle">
					<h3><?php esc_html_e('Select Languages','doctreat');?></h3>
				</div>
				<div class="dc-articletag-holder">
					<div class="dc-formtheme dc-skillsform">
						<fieldset>
							<div class="form-group">
								<div class="form-group-holder">
									<select class="dc-chosen-select" data-placeholder="<?php esc_attr_e('Choose languages','doctreat');?>" name="post_languages[]" multiple>
										<?php 
											if( !empty( $languages ) ){							
												foreach ($languages as $key => $item) {
													$term_id   = $item->name;
													$selected = '';
													if( in_array($term_id,$db_lan) ){
														$selected = 'selected';
													}
													?>
														<option <?php echo esc_attr( $selected );?> value="<?php echo esc_attr( $term_id ); ?>"><?php echo esc_html( $item->name ); ?></option>
													<?php 
												}
											}
										?>				
									</select>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
	</div>	
</div>
