<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage fhomeopathy
 * @author tishonator
 * @since fHomeopathy 1.0.0
 *
 */

 get_header(); ?>

<div class="clear">
</div><!-- .clear -->

<div id="main-content-wrapper">

	<div id="main-content">

		<h1><?php _e( 'Oops! That page can&rsquo;t be found.', 'fhomeopathy' ); ?></h1>

		<div class="content">
			<p>
				<?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'fhomeopathy' ); ?>
			</p>

			<?php get_search_form(); ?>
		</div><!-- .content -->

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>
