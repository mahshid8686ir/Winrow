<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// گرفتن قیمت‌ها و تبدیل به عدد
$price        = (float) $product->get_price();
$regularPrice = (float) $product->get_regular_price();

// محاسبه درصد تخفیف فقط اگر قیمت اصلی موجود باشه
$offPercent = 0;
if ( $regularPrice > 0 && $price > 0 && $regularPrice > $price ) {
	$offPercent = round( ( ( $regularPrice - $price ) / $regularPrice ) * 100 );
}

?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<span class="flex gap-2 items-center  m-3  justify-between">
    <?php if ( $offPercent ) : ?>
        <span class="bg-red-600 text-white font-normal text-xs p-1 px-2.5 rounded-lg">
            <?= toPersianNumerals( number_format( $offPercent ) ) ?>%
        </span>
    <?php endif; ?>
    <span class="grow"></span>
    <?php if ( $offPercent ) : ?>
        <span class="font-normal text-sm text-slate-400 line-through"><?= toPersianNumerals( number_format( $regularPrice ) ) ?></span>
    <?php endif; ?>
    <span class="font-semibold text-base"><?= toPersianNumerals( number_format( $price ) ) ?></span>
    <span class="font-semibold text-xs text-slate-400">تومان</span>
</span>

<?php endif; ?>
