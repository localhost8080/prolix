<?php
/**
 * tag archive template part
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package prolix\template_parts
 */

/**
 * template for tag archives
 */

get_header();
if ( have_posts() ) {
	?>
	<div class="jumbotron category-banner">
		<div class="container-fluid clearfix">
			<header>
				<h1 class="article_title">
					<?php
					printf(
						esc_html__( 'Posts Tagged %s', 'prolix' ),
						single_cat_title( '', false )
					);
	?>
				</h1>

				<p>
					<?php
					printf(
						esc_html__( 'There are %1$s posts tagged %2$s', 'prolix' ),
						$wp_query->found_posts,
						single_cat_title( '', false )
					);
	?>
				</p>
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
