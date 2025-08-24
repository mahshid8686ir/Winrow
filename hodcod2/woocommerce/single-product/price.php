<?php
/**
 * Single Product Price - Custom Style
 *
 * @package WooCommerce\Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! function_exists( 'toPersianNumber' ) ) {
	function toPersianNumber( $input ) {
		$input = (string) $input;
		$en = ['0','1','2','3','4','5','6','7','8','9'];
		$fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
		return str_replace( $en, $fa, $input );
	}
}

global $product;

// قیمت فعلی و قبلی محصول
$price     = (float) $product->get_price();
$oldPrice  = (float) $product->get_regular_price();

// محاسبه درصد تخفیف
$offPercent = 0;
if ( $oldPrice > 0 && $price > 0 && $oldPrice > $price ) {
    $offPercent = round( ( ( $oldPrice - $price ) / $oldPrice ) * 100 );
}
?>

<?php if ( $product->get_price_html() ) : ?>
	<div class="price flex items-center m-3 flex-row-reverse justify-between">
		<!-- بخش قیمت‌ها -->
		<div class="flex flex-row-reverse gap-2 items-center">
			<p class="font-medium text-xs text-slate-400">تومان</p>
			<p class="font-black text-xl">
				<?= function_exists('toPersianNumber') ? toPersianNumber( number_format( $price ) ) : number_format( $price ) ?>
			</p>

			<?php if ( $offPercent ) : ?>
				<div class="font-normal text-[15px] text-slate-400 line-through ml-2">
					<?= function_exists('toPersianNumber') ? toPersianNumber( number_format( $oldPrice ) ) : number_format( $oldPrice ) ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- بخش درصد تخفیف -->
		<?php if ( $offPercent ) : ?>
			<div class="dis bg-red-600 p-1.5 px-2.5 rounded-lg ml-6">
				<p class="font-normal text-xs text-white">
					<?= function_exists('toPersianNumber') ? toPersianNumber( number_format( $offPercent ) ) : number_format( $offPercent ) ?>%
				</p>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
