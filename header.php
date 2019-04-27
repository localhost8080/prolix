<?php
/**
 * header template part
 *
 * @package prolix\template_parts
 */

/**
 * Header template part
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php
	if ( function_exists( 'yoast_analytics' ) ) {
		yoast_analytics();
	}
	wp_head();
?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<div class="holder">
	<div class="wrapper">
	<div class="overlay"></div>

