<?php
/**
 * The template used for displaying page content
 *
 * @subpackage fHomeopathy
 * @author tishonator
 * @since fHomeopathy 1.0.0
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-content">
		<h1 class="entry-title"><?php the_title(); ?></h1>

	<div class="before-content">
		<?php edit_post_link( __( 'Edit', 'fhomeopathy' ), '<span class="edit-icon">', '</span>' ); ?>
	</div>
	
	<div class="page-content">
		<?php
			if ( has_post_thumbnail() ) :

				the_post_thumbnail();

			endif;
			
			the_content( __( 'Read More...', 'fhomeopathy') );
		?>
	</div><!-- .page-content -->

	<div class="page-after-content">
		
		<?php if ( ! post_password_required() ) : ?>

			<?php if ('open' == $post->comment_status) : ?>

				<span class="comments-icon">
					<?php comments_popup_link(__( 'No Comments', 'fhomeopathy' ), __( '1 Comment', 'fhomeopathy' ), __( '% Comments', 'fhomeopathy' ), '', __( 'Comments are closed.', 'fhomeopathy' )); ?>
				</span>

			<?php endif; ?>

		<?php endif; ?>

	</div><!-- .page-after-content -->
</article><!-- #post-## -->

