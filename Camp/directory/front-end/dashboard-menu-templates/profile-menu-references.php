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

$references 		 = (isset($_GET['ref']) && $_GET['ref'] <> '') ? $_GET['ref'] : '';
$mode 			 = (isset($_GET['mode']) && $_GET['mode'] <> '') ? $_GET['mode'] : '';
$url_identity 	 = $current_user->ID;
?>
<li class="<?php echo esc_attr( $references === 'references' && $mode ==='' ? 'dc-active' : ''); ?>">
	<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('references', $url_identity); ?>">
		<i class="lnr lnr-earth"></i>
		<span><?php esc_html_e('My Network','doctreat');?></span>
	</a>
</li>