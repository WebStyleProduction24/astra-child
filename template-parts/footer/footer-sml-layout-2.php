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
							<div class="footer__icons-links">
								<div class="footer__icon-link"><a href="https://wa.me/+34660520536" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/07/whatsapp.png"></a></div>
								<div class="footer__icon-link"> <a href="https://telegram.me/PBIgroup_bot" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/07/telegram.png"></a></div>
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
