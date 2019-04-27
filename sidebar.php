<?php
/**
 * sidebar template part
 *
 * @package prolix\template_parts
 */

/**
 * the sidebar for prolix
 */

?>
<aside class="sidebar mt-3">
	<div class="text-capitalize">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary-menu',
			)
		);
		if ( is_active_sidebar( 1 ) ) {
			dynamic_sidebar( 1 );
		}
		/* recent posts. */
		if ( is_active_sidebar( 4 ) ) {
			dynamic_sidebar( 4 );
		}
		if ( is_active_sidebar( 5 ) ) {
			dynamic_sidebar( 5 );
		}
?>
	</div>
</aside>
