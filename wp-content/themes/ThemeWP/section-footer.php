<?php
/**
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

?>
<div id="section-footer">
	<div class="row">
		<div class="large-12 columns end">
			<?php
			wp_nav_menu( array(
				'depth' => 1,
				'fallback_cb' => '',
				'theme_location' => 'footer-menu',
				'container' => 'ul',
			) );
			?>
		</div>
	</div>
</div>
