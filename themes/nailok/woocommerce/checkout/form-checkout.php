<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//wc_print_notices();

//do_action( 'woocommerce_before_checkout_form', $checkout );

?>
<section class="checkout-section">
    <h4 class="title-big">Оформление заказа</h4>
    <form name="checkout" method="post" class="checkout woocommerce-checkout"
          action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data"
          onsubmit="yaCounter48380480.reachGoal('zakaz'); return true;">

		<?php if ( $checkout->get_checkout_fields() ) : ?>
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
			<?php do_action( 'woocommerce_checkout_billing' ); ?>
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		<?php endif; ?>
		<?php //do_action( 'woocommerce_checkout_before_order_review' ); ?>
        <div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
        </div>
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
        <div class="order">
            <p><? the_field( 'передзвоним' ) ?></p>
			<?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button add-to-cart btn-pink alt" name="woocommerce_checkout_place_order" id="place_order" value="Оформить заказ" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>
        </div>
    </form>
	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</section>