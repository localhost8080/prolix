<?php
/**
 * navigation template part
 *
 * @package prolix\template_parts
 */

/**
 * nav bar
 */

?>
<nav role="navigation" class="navbar fixed-top navbar-dark bg-primary">
	<div class="">
		<a title="navigation menu" href="javascript:void(0);" class="navbar-brand sidebar-toggle">
			<span class="fa fa-bars"></span>
		</a>
		<?php echo '<h2 class="navbar-brand d-none d-sm-inline"><a class="navbar-brand" title="' . get_bloginfo('name') . '" href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h2>'; ?>
	</div>
	<div class="material-search">
	<?php get_search_form();?>
	</div>
</nav>

