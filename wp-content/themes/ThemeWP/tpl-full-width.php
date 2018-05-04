<?php
/**
 * Template Name: Full Width
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

get_template_part( 'header' );

?>
<div id="section-main">
	<?php do_action('section-main-top'); ?>
	<?php if ( have_posts() ) { ?>
		<?php do_action( 'before-loop' ); ?>
		<?php while ( have_posts() ) { the_post(); ?>
			<div <?php post_class(); ?>>
				<?php the__content(); ?>
			</div>
		<?php } // end while ( have_posts() ) ?>
		<?php do_action( 'after-loop' ); ?>
	<?php } ?>
	<?php do_action('section-main-bottom'); ?>
</div>
<?php

get_template_part( 'footer' );
