<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

// فیلتر روی محتوای تب توضیحات
add_filter( 'the_content', 'my_remove_tags_from_description', 20 );
function my_remove_tags_from_description( $content ) {
    // فقط در صفحه محصول تکی و تب توضیحات اجرا بشه
    if ( is_product() ) {
        // حذف h2
        $content = preg_replace( '/<h2[^>]*>(.*?)<\/h2>/is', '', $content );

        // حذف ul
        $content = preg_replace( '/<ul[^>]*>(.*?)<\/ul>/is', '', $content );
    }

    return $content;
}


?>

<?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>

<?php the_content(); ?>
