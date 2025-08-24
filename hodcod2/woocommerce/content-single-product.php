<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'w-1/2', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */

	?>
    <!-- ستون محصول اصلی -->
    <div class="">
        <?php
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

    

    <!-- ستون محصولات مشابه -->
	<aside class="border border-gray-300 order-2 lg:order-1 lg:col-span-1 bg-white rounded-2xl p-4 h-fit xl:mx-0 mx-5">
		<h3 class="font-bold text-[#152b4b] mb-3">محصولات مشابه</h3>
		<div class="space-y-4">
			<?php
			$related_ids = wc_get_related_products( $product->get_id(), 3 );
			$related = wc_get_products( array( 'include' => $related_ids ) );

			foreach ( $related as $rel_prod ) :
				$rel_id = $rel_prod->get_id();
				$rel_link = get_permalink( $rel_id );
				$rel_img  = wp_get_attachment_image( $rel_prod->get_image_id(), 'thumbnail', false, [ 'class' => 'w-16 h-12 object-cover rounded' ] );
			?>
			<a href="<?php echo esc_url( $rel_link ); ?>" class="flex items-center gap-3 border-b border-gray-300 pb-3 last:border-0 hover:bg-gray-50 transition">
				<?php echo $rel_img; ?>
				<h4 class="text-xs text-slate-600 font-normal"><?php echo esc_html( $rel_prod->get_name() ); ?></h4>
			</a>
			<?php endforeach; ?>
		</div>
	</aside>
</div>
