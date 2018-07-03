<?
$price_old            = null;
$price                = null;
$variable             = null;
$available_variations = null;
if ( $_product ) {
	$variable = $_product->get_type() == 'variable';
	if ( $variable ) {
		$price     = $_product->get_price();
		$price_old = $price;
		/*$available_variations = $_product->get_available_variations();
		$variation_id         = $available_variations[0]['variation_id'];
		$variable_product1    = new WC_Product_Variation( $variation_id );
		$price_old            = $variable_product1->get_regular_price();
		$price                = $variable_product1->get_price();*/
	} else {
		$price_old = $_product->get_regular_price();
		$price     = $_product->get_price();
	}
	$sale          = ! ( $price == $price_old );
	$sale_percents = 0;
	if ( $sale ) {
		$sale_percents = abs( 100 - ceil( ( $price / $price_old ) * 100 ) );
	}
	?>
    <div class="product-card">
		<? if ( $sale ): ?>
            <div class="sale">Скидка <?= $sale_percents ?>%</div>
		<? endif; ?>
        <div class="photo">
			<?
			$image = null;
			if ( is_object_in_term( $_product->get_id(), 'product_cat', 'starter-pack' ) ) {
				$gallery      = $_product->get_gallery_image_ids();
				$image['url'] = wp_get_attachment_url( $gallery[0] );
				$image['alt'] = get_post_meta( $gallery[0], '_wp_attachment_image_alt', true );
				if ( ! $image['url'] ) {
					$image = wp_prepare_attachment_for_js( $_product->get_image_id() );
				}
			} else {
				$image = wp_prepare_attachment_for_js( $_product->get_image_id() );
			} ?>
            <img src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>">
        </div>
        <a href="<?= $_product->get_permalink() ?>" class="title"><?= $_product->get_title() ?></a>
        <p class="price"><?= $price ? $price . ' ₽' : '' ?></p>
		<? if ( $sale ): ?>
            <p class="price-sale"><?= $price_old ?> ₽</p>
		<? endif; ?>
        <div class="hover">
			<? if ( ! is_search() ): ?>
                <a href="<?= $_product->get_permalink() ?>" class="product-link <?= $variable ? 'disabled' : '' ?>">подробнее</a>
				<?
				if ( $variable ):
					/*$palette = $available_variations;
					$default = $_product->get_variation_default_attribute( 'Палитра' );
					$variationId = null;
					foreach ( $palette as $item ) {
						$attr = array_shift( $item['attributes'] );
						if ( $default == $attr ) {
							$variationId = $item['variation_id'];
						}
					}
					$addToCart = '?';
					unset( $_GET['add-to-cart'] );
					unset( $_GET['variation_id'] );
					if ( ! empty( $_GET['filters'] ) ) {
						$addToCart = '?' . http_build_query( $_GET ) . '&';
					}
					$addToCart .= 'add-to-cart=' . $_product->get_id() . '&variation_id=' . $variationId;*/
					?>
                    <a href="<?= $_product->get_permalink() ?>" class="add-to-cart btn-pink">подробнее</a>
				<? else : ?>
                    <a href="<?= $_product->add_to_cart_url() ?>" class="add-to-cart btn-pink"
                       onclick="yaCounter48380480.reachGoal('v_korzinu'); return true;"><i
                                class="fas fa-shopping-cart"></i> в корзину</a>
				<? endif; ?>
				<?
				$product = $_product;
				if ( ! $variable ) {
					echo do_shortcode( '[ti_wishlists_addtowishlist]' );
				}
			endif; ?>
        </div>
    </div>
<? } ?>