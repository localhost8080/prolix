<?php
/**
 * template part to output a featured image or a default image if none set
 *
 * @package prolix\template_parts
 */

/**
 * output the featured image, or a default image if none set
 */
if ( has_post_thumbnail() ) {
	// the current post has a thumbnail
	// set_post_thumbnail_size( 605, 100,1 ); // Normal post thumbnails
	$slider_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	$theimg = $slider_image[0];
} else {
	$theimg = get_header_image();
}
?>
<h1 itemprop="name" class="prolix_h1_tag" style="background-image:url('<?php echo $theimg; ?>');">
	<?php echo $prolix->prolix_post_title(); ?>
</h1>
<figure class="thumbnail main_image m-0 breadcrumb">
	<figcaption>
		<span class="fa fa-comment-o fa-fw"></span>
		<?php echo $prolix->prolix_post_title(); ?>
	</figcaption>
</figure>
