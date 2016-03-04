<?php
/**
 * The template part for displaying content of single post.
 *
 * @package Simple_Life
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<div class="entry-meta">
			<?php simple_life_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
 		<?php if ( has_post_thumbnail() ) : ?>
 			<div class="post-thumbnail-wrapper">
				<?php the_post_thumbnail( 'large', array( 'class' => 'aligncenter' ) ); ?>
 			</div>
 		<?php endif; ?>

		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'simple-life' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( esc_html__( ', ', 'simple-life' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', esc_html__( ', ', 'simple-life' ) );

			if ( ! empty( $category_list ) ) {
				echo '<span class="sl-category"><i class="fa fa-folder-open" aria-hidden="true"></i> ' . $category_list . '</span>';
			}
			if ( ! empty( $tag_list ) ) {
				echo '<span class="sl-tags"><i class="fa fa-tags" aria-hidden="true"></i> ' . $tag_list . '</span>';
			}

		?>

		<?php edit_post_link( esc_html__( 'Edit', 'simple-life' ), '<span class="edit-link pull-right"><i class="fa fa-edit" aria-hidden="true"></i>', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
