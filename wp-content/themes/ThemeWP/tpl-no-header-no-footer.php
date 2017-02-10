<?php
/**
 * Template Name: No header or footer
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

get_template_part( 'header-head' );

?>
<body <?php body_class(); echo apply_filters( 'tag_body_attr', '' ); ?>>
	<?php do_action('after_body_tag'); ?>
	<div id="section-main">
		<?php if ( have_posts() ) { ?>
			<?php while ( have_posts() ) { the_post(); ?>
				<div <?php post_class(); ?>>
					<?php the__content(); ?>
				</div>
			<?php } // end while ( have_posts() ) ?>
		<?php } ?>
	</div>
<?php wp_footer(); ?>
</body>
</html>
