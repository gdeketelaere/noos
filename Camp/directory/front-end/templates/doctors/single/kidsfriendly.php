<?php
/**
 *
 * The template used for doctors specialiizations
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post;
$post_id = $post->ID;

$kids	= ( get_field('camp_kids_f', $post_id ) ) ? get_field('camp_kids_f', $post_id ) : '';

if( !empty( $kids ) && $kids==1 ){ ?>
	<div class="dc-specializations dc-aboutinfo">
		<div class="dc-infotitle">
			<h3><?php esc_html_e('Kids Friendly','doctreat');?></h3>
		</div>

		<?php			
			esc_html_e('Accepte les enfants','camp');
		?>
	</div>
<?php } ?>

