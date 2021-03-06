<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "body-content-wrapper" div and all content after.
 *
 * @subpackage fHomeopathy
 * @author tishonator
 * @since fHomeopathy 1.0.0
 *
 */
?>
				<div class="clear"></div>
			</div>

			<a href="#" class="scrollup"></a>

			<footer id="footer-main">

				<div id="footer-content-wrapper">

					<?php get_sidebar('footer'); ?>

					<div class="clear">
					</div>

					<div id="copyright">

						<p>
						 <?php fhomeopathy_show_copyright_text(); ?> <a href="<?php echo esc_url( 'https://tishonator.com/product/fhomeopathy' ); ?>" title="<?php esc_attr_e( 'fhomeopathy Theme', 'fhomeopathy' ); ?>">
							<?php esc_html_e('fHomeopathy Theme', 'fhomeopathy'); ?></a> <?php esc_attr_e( 'powered by', 'fhomeopathy' ); ?> <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" title="<?php esc_attr_e( 'WordPress', 'fhomeopathy' ); ?>">
							<?php esc_html_e('WordPress', 'fhomeopathy'); ?></a>
						</p>
						
					</div><!-- #copyright -->

				</div><!-- #footer-content-wrapper -->

			</footer><!-- #footer-main -->

		</div><!-- #body-content-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html>