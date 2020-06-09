<?php 
/**
 *
 * The template part for displaying the user profile basics
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */
global $current_user, $wp_roles, $userdata, $theme_settings;
$user_identity 	 = $current_user->ID;
$linked_profile  = doctreat_get_linked_profile_id($user_identity);

$first_name 	= get_user_meta($user_identity, 'first_name', true);
$last_name 		= get_user_meta($user_identity, 'last_name', true);


$post_id 		= $linked_profile;
$user_meta		= doctreat_get_post_meta( $post_id );
$name_bases		= array();

if( function_exists( 'doctreat_get_name_bases' ) ) {
	$name_bases	= doctreat_get_name_bases();
}

$display_name	= get_the_title( $post_id );
$display_name	= !empty( $display_name ) ? $display_name : '';
$am_name_base	= !empty( $user_meta['am_name_base'] ) ? $user_meta['am_name_base'] : '';
$am_sub_heading	= !empty( $user_meta['am_sub_heading'] ) ? $user_meta['am_sub_heading'] : '';
$am_first_name	= !empty( $user_meta['am_first_name'] ) ? $user_meta['am_first_name'] : '';
$am_last_name	= !empty( $user_meta['am_last_name'] ) ? $user_meta['am_last_name'] : '';

$enable_options		= !empty($theme_settings['doctors_contactinfo']) ? $theme_settings['doctors_contactinfo'] : '';
$system_access		= !empty($theme_settings['system_access']) ? $theme_settings['system_access'] : '';
$web_url			= !empty( $user_meta['am_web_url'] ) && !empty($enable_options) ? $user_meta['am_web_url'] : '';

$am_starting_price		= !empty( $user_meta['am_starting_price'] ) ? $user_meta['am_starting_price'] : '';
$am_short_description	= !empty( $user_meta['am_short_description'] ) ? $user_meta['am_short_description'] : '';

$post_object 	= get_post( $post_id );
$content 	 	= !empty($post_object->post_content) ? apply_filters( 'the_content', $post_object->post_content ) : '';
?>
<div class="dc-yourdetails dc-tabsinfo">
	<div class="dc-tabscontenttitle">
		<h3><?php esc_html_e('Your Details', 'doctreat'); ?></h3>
	</div>
	<div class="dc-formtheme dc-userform">
		<fieldset>
			<div class="form-group form-group-half">
				<span class="dc-select">
					<select name="am_name_base">
						<option value="" disabled=""><?php esc_html_e('Select one', 'doctreat'); ?></option>
						<?php if( !empty( $name_bases ) ) {?>
							<?php foreach ( $name_bases as $key => $name_base ) { ?>
								<option value="<?php echo esc_attr( $key );?>" <?php selected( $am_name_base, $key, true); ?>><?php echo esc_html($name_base); ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</span>
			</div>
			<div class="form-group form-group-half toolip-wrapo">
				<input type="text" value="<?php echo esc_attr( $am_sub_heading ); ?>" name="am_sub_heading" class="form-control" placeholder="<?php esc_attr_e('Sub Heading', 'doctreat'); ?>">
				<?php do_action('doctreat_get_tooltip','element','am_sub_heading');?>
			</div>
			<div class="form-group form-group-half toolip-wrapo">
				<input type="text" name="am_first_name" class="form-control" value="<?php echo esc_attr( $first_name ); ?>" placeholder="<?php esc_attr_e('First name', 'doctreat'); ?>">
				<?php do_action('doctreat_get_tooltip','element','am_first_name');?>
			</div>			
			<div class="form-group form-group-half toolip-wrapo">
				<input type="text" value="<?php echo esc_attr( $last_name ); ?>" name="am_last_name" class="form-control" placeholder="<?php esc_attr_e('Last Name', 'doctreat'); ?>">
				<?php do_action('doctreat_get_tooltip','element','am_last_name');?>
			</div>
			<div class="form-group toolip-wrapo">
				<input type="text" name="display_name" class="form-control" value="<?php echo esc_attr( $display_name ); ?>" placeholder="<?php esc_attr_e('Display name', 'doctreat'); ?>">
				<?php do_action('doctreat_get_tooltip','element','display_name');?>
			</div>
			<div class="form-group form-group-half toolip-wrapo">
				<input type="text" name="am_starting_price" class="form-control" value="<?php echo esc_attr( $am_starting_price ); ?>" placeholder="<?php esc_attr_e('Starting Price', 'doctreat'); ?>">
				<?php do_action('doctreat_get_tooltip','element','am_starting_price');?>
			</div>
			<?php if( !empty($enable_options) ){ ?>
				<div class="form-group toolip-wrapo">
					<input type="text" name="am_web_url" class="form-control" value="<?php echo esc_attr( $web_url ); ?>" placeholder="<?php esc_attr_e('Web url', 'doctreat'); ?>">
					<?php do_action('doctreat_get_tooltip','element','am_web_url');?>
				</div>
			<?php } ?>
			<div class="form-group">
				<textarea name="content" class="form-control" placeholder="<?php esc_attr_e('Description', 'doctreat'); ?>"><?php echo esc_html( $content ); ?></textarea>
			</div>
		</fieldset>
	</div>
</div>
<?php 
	if( !empty($enable_options) ){
		get_template_part('directory/front-end/templates/dashboard', 'phone_numbers');
	}
