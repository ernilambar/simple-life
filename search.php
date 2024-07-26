<?php
/**
 * The template for displaying search results pages
 *
 * @package Simple_Life
 */

get_header(); ?>

<section id="primary" <?php echo simple_life_content_class( 'content-area' ); ?>>
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: Search query. */
					printf( esc_html__( 'Search Results for: %s', 'simple-life' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php simple_life_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
