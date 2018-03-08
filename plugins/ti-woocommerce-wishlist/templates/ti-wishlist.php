<?php
/**
 * The Template for displaying wishlist.
 *
 * @version             1.0.0
 * @package           TInvWishlist\Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header( 'shop' ); ?>

<?php get_sidebar() ?>
<div class="tinv-wishlist woocommerce tinv-wishlist-clear">
	<?php if ( function_exists( 'wc_print_notices' ) ) {
		wc_print_notices();
	} ?>
    <div class="before-content">
		<?php woocommerce_breadcrumb(); ?>
        <div class="right">
            <a href=""><i class="fas fa-check-circle"></i>Как заказать</a>
            <a href=""><i class="fas fa-credit-card"></i>Как оплатить</a>
            <a href=""><i class="fas fa-cube"></i>Как получить</a>
        </div>
    </div>
    <h1 class="title-big"><? the_title() ?></h1>
    <form action="<?php echo esc_url( tinv_url_wishlist() ); ?>" method="post" autocomplete="off">
		<?php
		foreach ( $products as $wl_product ) {
			$product = apply_filters( 'tinvwl_wishlist_item', $wl_product['data'] );
			unset( $wl_product['data'] );
			if ( $wl_product['quantity'] > 0 && apply_filters( 'tinvwl_wishlist_item_visible', true, $wl_product, $product ) ) {
				$product_url = apply_filters( 'tinvwl_wishlist_item_url', $product->get_permalink(), $wl_product, $product );
				do_action( 'tinvwl_wishlist_row_before', $wl_product, $product );
				?>
                <div class="product-card-long <?php echo esc_attr( apply_filters( 'tinvwl_wishlist_item_class', 'wishlist_item', $wl_product, $product ) ); ?>">
                    <div class="hover"></div>
                    <div class="photo">
						<? $image = wp_prepare_attachment_for_js( $product->get_image_id() ); ?>
                        <img src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>">
                    </div>
                    <div class="info">
						<?php
						if ( ! $product->is_visible() ) {
							echo apply_filters( 'tinvwl_wishlist_item_name', $product->get_title(), $wl_product, $product ) . '&nbsp;'; // WPCS: xss ok.
						} else {
							echo apply_filters( 'tinvwl_wishlist_item_name', sprintf( '<a href="%s" class="title">%s</a>', esc_url( $product_url ), $product->get_title() ), $wl_product, $product ); // WPCS: xss ok.
						}
						echo apply_filters( 'tinvwl_wishlist_item_meta_data', tinv_wishlist_get_item_data( $product, $wl_product ), $wl_product, $product ); // WPCS: xss ok.
						?>
                        <div class="bottom">
                            <p class="price"><?= $product->get_price() ?> ₽</p>
							<? $availability = $product->get_availability()['class'] ?>
                            <p class="available <?= $availability ?>">
                                <i class="fas <?= $availability == 'in-stock' ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
								<?= $availability == 'in-stock' ? 'В наличии' : 'Нет в наличии' ?></p>
                        </div>
                    </div>
                    <div class="buy">
						<? if ( $availability == 'in-stock' ): ?>
							<? if ( $product->get_type() == 'variable' ):
                                $palette = $product->get_available_variations();
								$default = $product->get_variation_default_attribute( 'Палитра' );
								$variationId = null;
								foreach ( $palette as $item ) {
									$attr = array_shift( $item['attributes'] );
									if ( $default == $attr ) {
										$variationId = $item['variation_id'];
									}
								}
								$addToCart = '?add-to-cart=' . $product->get_id() . '&variation_id=' . $variationId;
								?>
                                <a href="<?= $addToCart ?>" class="add-to-cart btn-pink"><i
                                            class="fas fa-shopping-cart"></i> в корзину</a>
							<? else : ?>
                                <a href="<?= $product->add_to_cart_url() ?>" class="add-to-cart btn-pink"><i
                                            class="fas fa-shopping-cart"></i> в корзину</a>
							<? endif; ?>
						<? endif; ?>
                        <button type="submit" class="remove-link" name="tinvwl-remove"
                                value="<?php echo esc_attr( $wl_product['ID'] ); ?>">Удалить из закладок
                        </button>
                    </div>
                </div>
				<?php
				do_action( 'tinvwl_wishlist_row_after', $wl_product, $product );
			}
		}
		?>
        <div class="d-none">
            <tr>
                <td colspan="100">
					<?php do_action( 'tinvwl_after_wishlist_table', $wishlist ); ?>
					<?php wp_nonce_field( 'tinvwl_wishlist_owner', 'wishlist_nonce' ); ?>
                </td>
            </tr>
        </div>
    </form>
	<?php do_action( 'tinvwl_after_wishlist', $wishlist ); ?>
    <div class="tinv-lists-nav tinv-wishlist-clear">
		<?php do_action( 'tinvwl_pagenation_wishlist', $wishlist ); ?>
    </div>
</div>
<?php get_footer(); ?>
