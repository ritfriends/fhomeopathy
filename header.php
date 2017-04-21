<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "body-content-wrapper" div.
 *
 * @subpackage fHomeopathy
 * @author tishonator
 * @since fHomeopathy 1.0.0
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="body-content-wrapper">
			
			<header id="header-main-fixed"
						<?php if ( fhomeopathy_should_display_slider() ) : ?>

									style="background-repeat: no-repeat;height:100vh;"
									data-slides="<?php echo esc_attr( fhomeopathy_slides_json() ); ?>"
									data-currentslide="0"

						<?php endif; ?>>

					<?php if ( fhomeopathy_should_display_slider() ) : ?>

						<div id="slider-image-container">
							<div class="slider-prev">
								<span></span>
							</div>
							<div class="slider-next">
								<span></span>
							</div>

							<div class="slider-dots">
								<?php $slidesCount = fhomeopathy_get_slides_count(); ?>
								<?php for ($i = 0; $i < $slidesCount; ++$i) : ?>

										<span data-slidenum="<?php echo esc_attr( $i ); ?>">
										</span>

								<?php endfor; ?>
							</div>
						</div>

				<?php endif; ?>

				<div id="header-main-fixed-container">
					<div id="header-content-wrapper">

						<div id="header-logo">
							<?php fhomeopathy_show_website_logo_image_and_title(); ?>
						</div><!-- #header-logo -->

						<nav id="navmain">
							<?php wp_nav_menu( array( 'theme_location' => 'primary',
													  'fallback_cb'    => 'wp_page_menu',
													  
													  ) ); ?>
						</nav><!-- #navmain -->
						
						<div class="clear">
						</div><!-- .clear -->

					</div><!-- #header-content-wrapper -->
				</div>

			</header><!-- #header-main-fixed -->


			<div id="global-content-wrapper">
