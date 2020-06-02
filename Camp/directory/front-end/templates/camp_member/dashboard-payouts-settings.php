<?php 
/**
 *
 * The template part for displaying the template to display email settings
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

$payrols	= doctreat_get_payouts_lists();
?>
<div class="dc-tabsinfo dc-email-settings">
	<div class="dc-tabscontenttitle">
		<h3><?php esc_html_e('Payouts Settings', 'doctreat'); ?></h3>
	</div>
	<div class="dc-settingscontent">
		<div class="dc-description">
			<p><?php esc_html_e('All the earning will be sent to below selected payout method','doctreat');?></p>
		</div>
		<div class="dc-formtheme dc-userform payout-holder">
			<form class="dc-payout-settings">
				<?php 
					if( !empty($payrols) ) {
						foreach ($payrols as $pay_key	=> $payrol) {
							if( !empty($payrol['status']) && $payrol['status'] === 'enable' ) {
								$contents	= get_user_meta($user_identity,'payrols',true);
								$db_option	= !empty( $contents['type'] ) ? $contents['type'] : '';
								$db_option_display	= !empty( $contents['type'] ) && $pay_key === $contents['type'] ? 'display:block' : 'display:none';
								$db_option_display	= !empty($contents['payrol']) && $contents['payrol'] === 'paypal' ? 'display:block' : $db_option_display; //only for migration
							?>
							<fieldset>
								<div class="dc-checkboxholder">
									<span class="dc-radio">
										<input id="payrols-<?php echo esc_attr( $payrol['id'] ); ?>" <?php checked( $pay_key, $db_option); ?> type="radio" name="payout_settings[type]" value="<?php echo esc_attr( $payrol['id'] ); ?>">
										<label for="payrols-<?php echo esc_attr( $payrol['id'] ); ?>">
											<figure class="dc-userlistingimg">
												<img src="<?php echo esc_url( $payrol['img_url'] ); ?>" alt="<?php echo esc_attr( $payrol['title'] ); ?>">
											</figure>
										</label>
									</span>
								</div>
								<div class="fields-wrapper dc-haslayout" style="<?php echo esc_attr( $db_option_display );?>">
									<?php if( !empty($payrol['desc'])) {?>
										<div class="dc-description"><p><?php echo do_shortcode($payrol['desc']);?></p></div>
									<?php }?>
									<?php 
									if( !empty($payrol['fields'])) {
										foreach( $payrol['fields'] as $key => $field ){
											$db_value		= !empty($contents[$key]) ? $contents[$key] : "";
										?>
										<div class="form-group form-group-half toolip-wrapo">
											<input type="<?php echo esc_attr($field['type']);?>" name="payout_settings[<?php echo esc_attr($key);?>]" id="<?php echo esc_attr($key);?>-payrols" class="form-control" placeholder="<?php echo esc_attr($field['placeholder']);?>" value="<?php echo esc_attr( $db_value ); ?>">
											<?php do_action('doctreat_get_tooltip','element',$key);?>
										</div>
									<?php }}?>
								</div>
							</fieldset>
							<?php

							}
						}
					}
				?>
				<fieldset>
					<div class="form-group dc-btnarea">
						<button type="submit" class="dc-btn dc-payrols-settings" data-id="<?php echo esc_attr( $payrol['id'] ); ?>"><?php esc_html_e("Submit",'doctreat');?></button>
					</div>
				</fieldset>
			</form>	
		</div>
	</div>
</div>