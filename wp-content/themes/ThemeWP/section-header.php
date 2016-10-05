<?php
/**
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

?>
<div id="section-header">
	<div class="row">
		<div class="large-12 columns end">
			<?php
			wp_nav_menu( array(
				'fallback_cb' => '',
				'theme_location' => 'primary-menu',
				'container' => 'ul',
			) );
			?>
		</div>
	</div>
</div>
