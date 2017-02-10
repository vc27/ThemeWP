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
	<div class="row">
	<?php do_action('section-main-top'); ?>
	<div class="large-12 columns">
		<?php do_action( 'before-loop' ); ?>
		<div class="layout-archive-loop">
		<?php if ( have_posts() ) { ?>
			<?php while ( have_posts() ) { the_post(); ?>
			<div <?php post_class(); ?>>
				<?php the__title( $post, array(
					'element' => 'inherit',
					'class' => 'inherit',
					'add_permalink' => 'inherit'
				) ); ?>
				<?php the__content(); ?>
			</div>
			<?php } // end while ( have_posts() ) ?>
		<?php if ( do__comments() ) { comments_template( '', true ); } ?>
		<?php do_action( 'after-loop' ); ?>
		<?php } ?>
		</div>
	</div>
	<?php do_action('section-main-bottom'); ?>
</div>
<?php

get_template_part( 'footer' );
