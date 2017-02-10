<?php
/**
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
	<div class="large-8 columns">
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
				<?php if ( ! is_page() ) { ?>
				<div class="meta-data">
					<?php the__date( $post ); ?>
					<?php the__comments( $post ); ?>
					<?php the__category( $post ); ?>
					<?php the__author( $post ); ?>
				</div>
				<?php } ?>
				<?php
				if (
					is_archive()
					OR is_home()
					OR is_search()
				) {
					the__excerpt( $post, array(
						'count' => 55
						,'read_more' => 'Read More'
						,'strip_tags' => '<p>'
					) );
				} else {
					the__content();
				}
				?>
			</div>
			<?php } // end while ( have_posts() ) ?>
		<?php if ( do__comments() ) { comments_template( '', true ); } ?>
		<?php do_action( 'after-loop' ); ?>
		<?php } else { // end if ( have_posts() ) ?>
			<div class="hentry">
			<?php if ( is_404() ) {
				echo get__option( '_404_content' );
			} else {
				global $s;

				if ( get__option( '_search_no_results_title' ) ) {
					$search = sprintf( __( get__option( '_search_no_results_title' ) . ' %1$s', 'parenttheme' ), $s );
				} else {
					$search = sprintf( __( 'Search: %1$s', 'parenttheme' ), $s );
				}
				?>
				<h1 class="h1"><?php echo $search; ?></h1>
				<div class="entry"><?php echo get__option( '_search_no_results_content' ); ?></div>
				<?php
			} ?>
			</div>
		<?php } ?>
		</div>
	</div>
	<div class="large-4 columns">
		<?php get__widget_area( 'Primary Sidebar' ); ?>
	</div>
	<?php do_action('section-main-bottom'); ?>
</div>
<?php

get_template_part( 'footer' );
