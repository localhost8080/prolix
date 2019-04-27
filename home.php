<?php
/**
 * this is the template for the home page when its set to display blog posts
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package prolix\template_parts
 */

/**
 * homepage when set to display blog posts on homepage
 */

get_header();
if ( have_posts() ) {
	?>
	<div class="jumbotron">
		<div class="container-fluid clearfix">
			<header>
				<h1 class="article_title">
					<?php
					printf(
						esc_html__( 'Featured Posts', 'prolix' )
					);
	?>
				</h1>
			</header>
		</div>
	</div>
	<?php
	echo $prolix->prolix_paralax_slider();
	?>
	<p class="lead text-center">Recent Posts</p>
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
				<li><?php previous_posts_link( 'Previous Entries', 'prolix' ); ?></li>
				<li><?php next_posts_link( 'Next Entries', 'prolix' ); ?></li>
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
