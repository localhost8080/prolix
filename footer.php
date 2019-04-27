<?php
/**
 * prolix theme footer
 *
 * @package prolix\template_parts
 */
/**
 * footer template part
 */
?>
</div>
<?php
get_sidebar();
?>
</div>
<?php
require locate_template( 'navigation.php' );
if ( empty( $hide_the_footer_links ) ) {
	?>
<footer class="page-footer special-color p-4">
	<div class="container-fluid clearfix">
		<aside>

			<?php
			if ( is_active_sidebar( 6 ) || is_active_sidebar( 7 ) ) {
		?>
							<div class="row">
							<div class="col-sm-6 col-md-6 col-lg-6 no-bullets mb">
						<?php
						if ( is_active_sidebar( 6 ) ) {
							dynamic_sidebar( 6 );
						}
		?>
					</div>
							<div class="col-sm-6 col-md-6 col-lg-6 no-bullets mb">
						<?php
						if ( is_active_sidebar( 7 ) ) {
							dynamic_sidebar( 7 );
						}
		?>
					</div>
						</div>

							<?php
			}
	?>
				<div class="row">

				<?php
				if ( is_active_sidebar( 9 ) ) {
		?>

									<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
									<p class="nav-header h5">
							<?php
							printf( esc_html__( 'Useful Stuff', 'prolix' ) );
		?>
						  </p>
						<?php
						// sidebar 10 for some things in Îfooter
						dynamic_sidebar( 9 );
		?>
									</div>

									<?php
				}
				if ( is_active_sidebar( 10 ) ) {
					?>

					<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
					<p class="nav-header h5">
							<?php
							printf( esc_html__( 'More Useful Stuff', 'prolix' ) );
					?>
						  </p>
						<?php
						// sidebar 10 for some things in footer
						dynamic_sidebar( 10 );
					?>
					</div>
					<?php
				}
	?>

				</div>
		</aside>
	</div>
</footer>
<?php
}
wp_footer();
?>
</body>
</html>
