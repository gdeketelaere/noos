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
$mode 			 = !empty($_GET['mode']) ? esc_attr( $_GET['mode'] ) : '';

$add_references_url 	= Doctreat_Profile_Menu::Doctreat_profile_menu_link('references', $user_identity, true);
$saved_references_url 	= Doctreat_Profile_Menu::Doctreat_profile_menu_link('references', $user_identity, true,'saved');

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
	<form class="dc-user-account" method="post">	
		<div class="dc-dashboardbox dc-dashboardtabsholder dc-accountsettingholder">
			<div class="dc-dashboardtabs">
				<ul class="dc-tabstitle nav navbar-nav">
					<li class="nav-item">
						<a class="<?php echo empty( $mode ) ? 'active' : '';?>" href="<?php echo esc_url( $add_references_url );?>">
							<?php esc_html_e('Add new reference', 'doctreat'); ?>
						</a>
					</li>
					<li class="nav-item">
						<a class="<?php echo !empty( $mode ) && $mode === 'saved' ? 'active' : '';?>" href="<?php echo esc_url( $saved_references_url );?>">
							<?php esc_html_e('Saved references', 'doctreat'); ?>
						</a>
					</li>
				</ul>
			</div>
			<div class="dc-tabscontent tab-content">
				<?php 
					if( empty( $mode )){
						get_template_part('directory/front-end/templates/dashboard', 'profile-references-new'); 
					} elseif( !empty( $mode ) && $mode === 'saved' ){
						get_template_part('directory/front-end/templates/dashboard', 'profile-references-saved'); 
					}
				?>
			</div>
		</div>
	</form>
</div>
