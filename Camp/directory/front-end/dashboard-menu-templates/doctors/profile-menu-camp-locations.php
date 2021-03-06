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

$reference 		 = (isset($_GET['ref']) && $_GET['ref'] <> '') ? $_GET['ref'] : '';
$mode 			 = (isset($_GET['mode']) && $_GET['mode'] <> '') ? $_GET['mode'] : '';
$user_identity   = $current_user->ID;
?>
<li class="<?php echo esc_attr( $reference === 'camp-locations' ? 'dc-active' : ''); ?>">
	<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('camp-locations', $user_identity); ?>">
		<i class="lnr-map-marker"></i>
		<span><?php esc_html_e('My Customs Locations','doctreat');?></span>
	</a>
</li>
