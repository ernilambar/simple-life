<?php
/**
 * Custom template tags for this theme.
 *
 * @package Simple_Life
 */

if ( ! function_exists( 'simple_life_paging_nav' ) ) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function simple_life_paging_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		$pagination_type = esc_attr( simple_life_get_option( 'pagination_type' ) );

		switch ( $pagination_type ) {
			case 'numeric':
				if ( function_exists( 'wp_pagenavi' ) ) {
					wp_pagenavi();
				} else {
					the_posts_pagination( array(
						'mid_size'           => 2,
						'prev_text'          => '<span class="meta-nav"><i class="fa fa-chevron-left" aria-hidden="true"></i></span> ' . __( 'Previous page', 'simple-life' ),
						'next_text'          => __( 'Next page', 'simple-life' ) . ' <span class="meta-nav"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>',
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'simple-life' ) . ' </span>',
					) );
				}
				break;

			case 'default':
				the_posts_navigation( array(
					'prev_text' => '<span class="meta-nav"><i class="fa fa-chevron-left" aria-hidden="true"></i></span> ' . __( 'Older posts', 'simple-life' ),
					'next_text' => __( 'Newer posts', 'simple-life' ) . ' <span class="meta-nav"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>',
					) );
				break;

			default:
				break;
		}

	}
endif;

if ( ! function_exists( 'simple_life_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function simple_life_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			'%s',
			'<i class="fa fa-calendar" aria-hidden="true"></i> <a href="' . esc_url( get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) ) ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			'<i class="fa fa-user" aria-hidden="true"></i> %s',
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function simple_life_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'simple_life_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'simple_life_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so simple_life_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so simple_life_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in simple_life_categorized_blog.
 */
function simple_life_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'simple_life_categories' );
}
add_action( 'edit_category', 'simple_life_category_transient_flusher' );
add_action( 'save_post',     'simple_life_category_transient_flusher' );


if ( ! function_exists( 'simple_life_post_format_icon' ) ) :

	/**
	 * Add post format icons.
	 */
	function simple_life_post_format_icon() {

		$current_post_format = get_post_format();
		if ( ! empty( $current_post_format ) ) {
			switch ( $current_post_format ) {
				case 'video':
					$format_icon = 'video-camera';
					break;
				case 'audio':
					$format_icon = 'microphone';
					break;
				case 'status':
					$format_icon = 'tasks';
					break;
				case 'image':
					$format_icon = 'file-image-o';
					break;
				case 'quote':
					$format_icon = 'quote-left';
					break;
				case 'link':
					$format_icon = 'link';
					break;
				case 'gallery':
					$format_icon = 'photo';
					break;
				default:
					$format_icon = 'file';
					break;
			}

		?>
			<span class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x" aria-hidden="true"></i>
			  <i class="fa fa-<?php echo esc_attr( $format_icon ); ?> fa-stack-1x fa-inverse" aria-hidden="true"></i>
			</span>
		<?php
		} // End if.
	}

endif;

if ( ! function_exists( 'simple_life_the_custom_logo' ) ) :

	/**
	 * Displays the optional custom logo.
	 *
	 * @since 1.8
	 */
	function simple_life_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
		else {
			$site_logo = simple_life_get_option( 'site_logo' );
			if ( ! empty( $site_logo ) ) {
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-link">
					<img src="<?php echo esc_url( $site_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
				</a>
				<?php
			}
		}

	}

endif;
