<?php
/**
 * The template part for displaying content in loop.
 *
 * @package Simple_Life
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-post-format">
				<?php simple_life_post_format_icon(); ?>
			</div>
		<?php endif; ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark" >', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php simple_life_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php $content_layout = simple_life_get_option( 'content_layout' ); ?>

		<?php if ( 'excerpt' === $content_layout ) : ?>

			<div class="entry-summary">

				<?php the_excerpt(); ?>

			</div>

		<?php else : ?>
			<?php if ( 'excerpt-thumb' === $content_layout ) : ?>

				<?php
				// Excerpt with thumb.
				$archive_image_thumbnail_size = esc_attr( simple_life_get_option( 'archive_image_thumbnail_size' ) );
				$archive_image_alignment      = esc_attr( simple_life_get_option( 'archive_image_alignment' ) );
				?>

				<div class="entry-summary entry-summary-with-thumbnail">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( $archive_image_thumbnail_size, array( 'class' => 'align' . $archive_image_alignment ) ); ?>
						</a>
					<?php endif; ?>
					<?php the_excerpt(); ?>
				</div>

			<?php else : ?>

				<?php
				// Full post.
				$archive_image_thumbnail_size = esc_attr( simple_life_get_option( 'archive_image_thumbnail_size' ) );
				$archive_image_alignment      = esc_attr( simple_life_get_option( 'archive_image_alignment' ) );
				?>
				<div class="entry-content">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( $archive_image_thumbnail_size, array( 'class' => 'align' . $archive_image_alignment ) ); ?>
						</a>
					<?php endif; ?>
					<?php the_content( esc_html__( 'Continue reading', 'simple-life' ) . ' <span class="meta-nav">&rarr;</span>' ); ?>
					<?php
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'simple-life' ),
								'after'  => '</div>',
							)
						);
					?>
				</div><!-- .entry-content -->

			<?php endif ?>

		<?php endif ?>

	<footer class="entry-footer">
		<?php if ( 'post' === get_post_type() ) : // Hide category and tag text for pages on Search. ?>
			<?php
				/* translators: used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list( esc_html__( ', ', 'simple-life' ) );
			if ( $categories_list && simple_life_categorized_blog() ) :
				?>
			<span class="cat-links">
			<i class="fa fa-folder-open" aria-hidden="true"></i>
				<?php printf( '%1$s', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
			<?php endif; // End if categories. ?>

			<?php
				/* translators: used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list( '', esc_html__( ', ', 'simple-life' ) );
			if ( $tags_list ) :
				?>
			<span class="tags-links">
			<i class="fa fa-tags" aria-hidden="true"></i>
				<?php printf( '<span>&nbsp;%1$s</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
			<?php endif; // End if $tags_list. ?>
		<?php endif; // End if 'post' == get_post_type(). ?>

		<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>

		<span class="comments-link"><i class="fa fa-comment" aria-hidden="true"></i>&nbsp;<?php comments_popup_link( esc_html__( 'Leave a comment', 'simple-life' ), esc_html__( '1 Comment', 'simple-life' ), esc_html__( '% Comments', 'simple-life' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( esc_html__( 'Edit', 'simple-life' ), '<span class="edit-link pull-right"><i class="fa fa-edit" aria-hidden="true"></i>', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
