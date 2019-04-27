<?php
/*
 * YARPP Template: prolix Author: jonathan Description: A simple example YARPP template.
 */
global $prolix;
?>
<section class="container-fluid post clearfix">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<?php
			/*
			* <h3>
			* <?php
			* // printf(
			* // esc_html__('Other Posts related to %s', 'prolix'),
			* // $prolix->prolix_post_title()
			* // );
			*
			* esc_html__('Related Posts', 'prolix');
			* ?>
			*
			* </h3>
			*/
?>

			<div>
				<?php
				if ( have_posts() ) {
					$colour = $prolix->prolix_get_random_blue_class();
					while ( have_posts() ) {
						the_post();
						$prolix->prolix_render_the_archive( $colour );
					}
				} else {
					echo '<p>';
					printf( esc_html__( 'No related posts.', 'prolix' ) );
					echo '</p>';
				}
?>
			</div>
		</div>
	</div>
</section>
