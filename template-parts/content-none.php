<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @subpackage fHomeopathy
 * @author tishonator
 * @since fHomeopathy 1.0.0
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

<article>

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<h1><?php esc_html_e( 'Oh no! Article not found! 404 error!', 'fhomeopathy' ); ?></h1>
	
	<?php elseif ( is_search() ) : ?>

			<h1><?php esc_html_e( 'No Results Found!', 'fhomeopathy' ); ?></h1>
			<?php get_search_form(); ?>

	<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fhomeopathy' ); ?></p>
			<?php get_search_form(); ?>

	<?php endif; ?>

</article>