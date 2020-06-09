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
$url_video_camp = (get_field('camp_video_youtube_'.$user_roles, $post_id)) ? (string)get_field('camp_video_youtube_'.$user_roles, $post_id) : '' ;
?>
<div class="dc-skills dc-tabsinfo">
	<div class="dc-tabscontenttitle">
		<h3><?php esc_html_e('Your video','doctreat');?></h3>
	</div>
	<div class="dc-skillscontent-holder">
		<div class="dc-formtheme dc-skillsform">
			<fieldset>
				<div class="form-group">
					<div class="form-group-holder">
						<input type="text" class="form-control" name="input_video_camp" value="<?php echo $url_video_camp;?>" placeholder="<?php echo esc_attr('Your Video','doctreat');?>">
						<input type="hidden" name="input_id_user_video" value="<?php echo $post_id;?>">
						<input type="hidden" name="type_user_video" value="<?php echo $user_roles;?>">
					</div>
				</div>
				<div class="form-group dc-btnarea">
					<a href="javascript:;" class="dc-btn camp-save-video" ><?php esc_html_e('Save','doctreat');?></a>
				</div>
			</fieldset>
		</div>		
	</div>
</div>
