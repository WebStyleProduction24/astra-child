<?php
/**
 * Template for Small Footer Layout 2
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.0
 */

$section_1 = astra_get_small_footer( 'footer-sml-section-1' );
$section_2 = astra_get_small_footer( 'footer-sml-section-2' );
$sections  = 0;

if ( '' != $section_1 ) {
	$sections++;
}

if ( '' != $section_2 ) {
	$sections++;
}
switch ( $sections ) {

	case '2':
	$section_class = 'ast-small-footer-section-equally ast-col-md-4 ast-col-xs-12';
	break;
	case '1':
	default:
	$section_class = 'ast-small-footer-section-equally ast-col-xs-12';
	break;
}

?>

<div class="ast-small-footer footer-sml-layout-2">
	<div class="ast-footer-overlay">
		<div class="ast-container">
			<div class="ast-small-footer-wrap" >
				<div class="ast-row ast-flex">

					<?php if ( $section_1 ) : ?>
						<div class="ast-small-footer-section ast-small-footer-section-1 <?php echo esc_attr( $section_class ); ?>" >
							<?php
								echo $section_1 // WPCS: XSS OK.
								?>
							</div>
						<?php endif; ?>
						<div class="ast-small-footer-section  <?php echo esc_attr( $section_class ); ?>" >
							<div class="footer__icons-links-ft">
								<div class="footer__icon-link-ft">
								<a href="https://www.facebook.com/sakc.info.ru" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/08/fb.jpg"></a>
								<a href="https://www.instagram.com/sakc.info.ru/" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/08/insta.jpg"></a>
								<a href="https://www.youtube.com/channel/UCIu0tgCMgQsdS5uz5FfY81Q?view_as=subscriber" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/08/yt.jpg"></a>
								<a href="https://ok.ru/group/63755040915507" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/08/ok.jpg"></a>
								<a href="https://vk.com/public196911197" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/08/vk.jpg"></a>
								</div>
							</div>
						</div>
						
						<?php if ( $section_2) : ?>
							<div class="ast-small-footer-section ast-small-footer-section-2 footer-copyright <?php echo esc_attr( $section_class ); ?>" >
								<div class="footer-copyright">
									<div class="footer-copyright-item">Copyright © 2020 SENSACION SAKC</div>
								</div>
							</div>
						<?php endif; ?>
						

					</div> <!-- .ast-row.ast-flex -->
				</div><!-- .ast-small-footer-wrap -->
			</div><!-- .ast-container -->
		</div><!-- .ast-footer-overlay -->
	</div><!-- .ast-small-footer-->
