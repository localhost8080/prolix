<?php
/*
 * Template Name Posts: Adventures
 */

get_header();
echo '<!-- google_ad_section_start-->';
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		echo $prolix->prolix_paralax_featured_sliders();
		require locate_template( 'featuredimage.php' );
		echo '<div id="post-' . get_the_ID() . '" ';
		echo post_class( 'post' );
		echo '>';
		$title_string = $prolix->prolix_post_title();
		$title_string = preg_replace( '(\d+)', '', $title_string );
		$title_string = preg_replace( '/Day/', '', $title_string );
		$title_string = preg_replace( '/day/', '', $title_string );
		$title_string = preg_replace( '/Part/', '', $title_string );
		$title_string = preg_replace( '/part/', '', $title_string );
		$title_string = preg_replace( '/[^A-Za-z0-9 ]/', '', $title_string );
		$title_string = trim( $title_string );
		$locations = explode( ' to ', $title_string );

		$map_url = 'https://www.google.com/maps/embed/v1/directions';
		$map_url .= '?key='.GOOGLE_MAPS_API_KEY;
		$map_url .= '&origin=' . urlencode( trim( $locations[0] ) );
		if ( ! empty( $locations[1] ) ) {
			$map_url .= '&destination=' . urlencode( trim( $locations[1] ) );
		} else {
			$map_url .= '&destination=' . urlencode( trim( $locations[0] ) );
		}
		$map_url .= '&mode=walking';
		?>
		<div class="container-fluid clearfix">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<iframe loading="lazy" width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $map_url; ?>"></iframe>
			</div>
		</div>
		<div class="container clearfix">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<?php
				// remove_filter( 'the_content', 'sharing_display', 19 );
				// remove_filter( 'the_excerpt', 'sharing_display', 19 );
				the_content();
				wp_link_pages( '<p><strong>Pages:</strong>', '</p>', 'number' );
		?>
			</div>
		</div>
		<?php
		next_post_link( '%link', '<span class="next_link btn btn-primary"><span class="fa fa-chevron-left"></span></span>', true );
		previous_post_link( '%link', '<span class="prev_link btn btn-primary"><span class="fa fa-chevron-right"></span></span>', true );
		echo '</div>';
	}
} else {
	?>
	<div class="container post clearfix">
		<?php
		get_template_part( 'error-snippet' );
	?>
	</div>
<?php
}
echo '<!-- google_ad_section_end-->';
get_footer();
