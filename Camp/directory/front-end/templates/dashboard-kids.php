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
$user_info = get_userdata($current_user->ID);
$user_roles= implode(', ', $user_info->roles);
$user_roles=(string)$user_roles;

if ($user_roles=='doctors') {

	$kids = (get_field('camp_kids_f', $post_id)) ? get_field('camp_kids_f', $post_id) : 0 ;
}
else {

	$kids = (get_field('camp_kids_f_doctors', $post_id)) ? get_field('camp_kids_f_doctors', $post_id) : 0 ;
}

if ($kids==1) {
	$checked_on='checked';
	$checked_off='';
}
else {
	$checked_on='';
	$checked_off='checked';
}

?>
<div class="dc-skills dc-tabsinfo">
	<div class="dc-tabscontenttitle">
		<h3><?php esc_html_e('Kids Friendly','doctreat');?><?php echo $kids;?></h3>
	</div>
	<div class="dc-skillscontent-holder">
		<div class="dc-formtheme dc-skillsform">
			<fieldset>
				<div class="form-group">
					<div class="form-group-holder" style="display: flex; justify-content: space-around;">
						<div style="display: flex;">
							<input type="radio"  id="checked_on" name="input_kids_camp" value="1" <?php echo $checked_on;?>>
							<label for="checked_on">Oui</label>
						</div>

						<div style="display: flex;">
							<input type="radio" id="checked_ff" name="input_kids_camp" value="0" <?php echo $checked_ff;?>>
							<label for="checked_ff">Non</label>
						</div>						
					</div>
					<input type="hidden" name="input_id_user_kids" value="<?php echo $post_id;?>">
					<input type="hidden" name="type_user_kids" value="<?php echo $user_roles;?>">
				</div>
				<div class="form-group dc-btnarea">
					<a href="javascript:;" class="dc-btn camp-save-kids" ><?php esc_html_e('Save','doctreat');?></a>
				</div>
			</fieldset>
		</div>		
	</div>
</div>
