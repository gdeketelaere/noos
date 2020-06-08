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

$languages	= get_the_term_list( $post->ID, 'languages', '<ul class="dc-specializationslist dc-docinfo-specialities"><li class="dc-doc-specilities-tag"><span>', '</span></li><li class="dc-doc-specilities-tag"><span>', '</span></li></ul>' );



$languages	= !empty( $languages ) ? $languages : '';

if( !empty( $languages ) ){ ?>

	<div class="dc-specializations dc-aboutinfo dc-languagelist">

		<div class="dc-infotitle">

			<h3><img class="dc-icon--small" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/world.svg'; ?> "/> <?php esc_html_e('Languages','doctreat');?></h3>

		</div>

		<?php echo do_shortcode($languages);?>

	</div>

<?php } ?>



