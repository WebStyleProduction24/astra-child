<?php

/**

 * The template for displaying all single real estate.

 * Child theme Astra from Web Style Production 24 (https://wsp24.ru)

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.

}



get_header(); ?>



<div id="primary" <?php astra_primary_class(); ?>>



	<?php astra_primary_content_top(); ?>



	<?php astra_content_loop(); ?>



	<?php astra_primary_content_bottom(); ?>



</div><!-- #primary -->



<?php get_sidebar('real_estate'); ?>



<?php get_footer(); ?>

