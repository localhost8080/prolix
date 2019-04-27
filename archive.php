<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example,  prolix
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package prolix
 */

/**
 * The template for displaying Archive pages
 */

get_header();
if ( have_posts() ) {
	?>
	<div class="jumbotron category-banner">
		<div class="container-fluid clearfix">
			<header>
				<h1 class="article_title">
					<?php
					if ( is_category() ) {
						printf( '%s', single_cat_title( '', false ) );
					} elseif ( is_tag() ) {
						printf(
							esc_html__( 'Posts Tagged %s', 'prolix' ),
							single_cat_title( '', false )
						);
					} elseif ( is_day() ) {
						printf(
							esc_html__( 'Archive for %s', 'prolix' ),
							get_the_time( 'F jS, Y' )
						);
					} elseif ( is_month() ) {
						printf(
							esc_html__( 'Archive for %s', 'prolix' ), get_the_time( 'F Y' )
						);
					} elseif ( is_year() ) {
						printf(
							esc_html__( 'Archive for %s', 'prolix' ),
							get_the_time( 'Y' )
						);
					} elseif ( is_search() ) {
						printf(
							esc_html__( 'Search Results', 'prolix' )
						);
					} elseif ( is_author() ) {
						printf(
							esc_html__( 'All entries by this author', 'prolix' )
						);
					} elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
						printf(
							esc_html__( 'Blog Archives', 'prolix' )
						);
					} elseif ( is_home() ) {
						printf(
							esc_html__( 'Recent Posts', 'prolix' )
						);
					}
	?>
				</h1>
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
<?php
} else {
	?>
	<div class="container-fluid post clearfix">
		<?php
		get_template_part( 'error-snippet' );
	?>
	</div>
<?php
}
get_footer();
