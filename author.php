<?php
/**
 *  author pages template part.
 *  have an archive and a bio for the author
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package prolix
 */

/**
 * The template for displaying Author archive pages
 */

get_header();
if ( have_posts() ) {
	?>
	<div class="jumbotron category-banner">
		<div class="container-fluid clearfix">
			<header class="profile">
				<div class="col-sm-12">
					<div class="col-xs-12 col-sm-8">
						<h2><?php the_author_meta( 'display_name' ); ?></h2>

						<p>
						  <strong>
							<?php
							printf(
								esc_html__( 'Website: ', 'prolix' )
							);
	?>
						  </strong>
							<?php the_author_link(); ?>
						</p>
					</div>
					<div class="col-xs-12 col-sm-4 text-center">
						<figure>
							<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
							<figcaption class="ratings">
								<p>
									<?php
									printf(
										esc_html__( 'Post count: %s', 'prolix' ),
										$wp_query->found_posts
									);
	?>
								</p>
							</figcaption>
						</figure>
					</div>
				</div>
				<div class="col-xs-12 divider">
					<div class="col-xs-12">
						<?php
						$description = get_the_author_meta( 'description' );
						if ( ! empty( $description ) ) {
							echo '<p>' . $description . '</p>';
						}
	?>
					</div>
				</div>
			</header>
		</div>
	</div>
	<section class="container-fluid post clearfix">
		<?php
		$colour = $prolix->prolix_get_random_blue_class();
		while ( have_posts() ) {
			the_post();
			$prolix->prolix_render_the_archive( $colour );
		}
	?>
	</section>
	<section class="container-fluid post clearfix">
		<?php
		get_template_part( 'advert' );
	?>
	</section>
	<div class="container-fluid post clearfix">
		<nav class="navitems text-center">
			<ul class="pagination">
				<li><?php previous_posts_link( esc_html__( 'Previous Entries', 'prolix' ) ); ?></li>
				<li><?php next_posts_link( esc_html__( 'Next Entries', 'prolix' ) ); ?></li>
			</ul>
		</nav>
	</div>
<?php } else { ?>
	<div class="container-fluid post clearfix">
		<?php
		get_template_part( 'error-snippet' );
	?>
	</div>
<?php
}
get_footer();
