<?php
get_header( 'shop' ); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
    <div class="before-content">
		<?php woocommerce_breadcrumb(); ?>
        <div class="right">
            <a href="<?= get_permalink( 427 ) ?>"><i class="fas fa-check-circle"></i>Как заказать</a>
            <a href="<?= get_permalink( 427 ) ?>"><i class="fas fa-credit-card"></i>Как оплатить</a>
            <a href="<?= get_permalink( 427 ) ?>"><i class="fas fa-cube"></i>Как получить</a>
        </div>
    </div>
	<?
	wc_print_notices();
	$product     = wc_get_product( $post->ID );
	$productType = $product->get_type();
	$palette     = null;
	$default     = null;
	if ( $productType == 'variable' ) {
		$palette = $product->get_available_variations();
		$default = $product->get_variation_default_attribute( 'Палитра' );
	}
	?>
    <section class="product <?= $productType == 'variable' ? 'variable' : '' ?> " data-id="<?= $product->get_id() ?>">
        <h1 class="title-big"><? the_title() ?></h1>
        <div class="d-flex justify-content-center flex-wrap">
            <div class="col-xl-6 col-lg-9 col-md-8">
                <div class="border-pink">
                    <div class="album">
						<? if ( get_field( 'новинка' ) ): ?>
                            <div class="new">Новинка</div>
						<? endif; ?>
						<?
						$gallery   = $product->get_gallery_image_ids();
						$photo_url = '';
						$photo_alt = '';
						if ( $productType == 'variable' ) {
							foreach ( $palette as $item ) {
								$attr = array_shift( $item['attributes'] );
								if ( $default == $attr ) {
									$photo_url = $item['image']['url'];
									$photo_alt = $item['image']['alt'];
									break;
								}
							}
						} else if ( ! empty( $gallery ) ) {
							$photo_url = wp_get_attachment_url( $gallery[0] );
							$photo_alt = get_post_meta( $gallery[0], '_wp_attachment_image_alt', true );
						} else {
							$image     = wp_prepare_attachment_for_js( $product->get_image_id() );
							$photo_url = $image['url'];
							$photo_alt = $image['alt'];
						}
						?>
                        <img src="<?= $photo_url ?>" alt="<?= $photo_alt ?>" class="photo-big">
						<? if ( count( $gallery ) != 1 ): ?>
                            <div class="small">
								<?
								$status        = true;
								foreach ( $gallery as $photo ):
									$photo_url = wp_get_attachment_url( $photo );
									$photo_alt = get_post_meta( $photo, '_wp_attachment_image_alt', true ); ?>
                                    <div class="photo <?= $status ? 'active' : '' ?>">
                                        <img src="<? echo $photo_url ?>" alt="<? echo $photo_alt ?>">
                                        <div class="layout"></div>
                                    </div>
									<?
									$status = false;
								endforeach; ?>
                            </div>
						<? endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-9 col-md-6 product-control">
				<?= do_shortcode( '[ti_wishlists_addtowishlist]' ) ?>
                <p class="info">
					<?
					//brands
					$taxonomy    = 'pwb-brand';
					$slug        = 'pwb-brand';
					$term        = get_term_by( 'slug', $slug, $taxonomy );
					$term_id     = $term->term_id;
					$brand_terms = wp_get_post_terms( $post->ID, $taxonomy, array( "fields" => "all" ) );
					$status      = true;
					foreach ( $brand_terms as $brand_item ) {
						if ( $brand_item->parent == $term_id ):?>
                            <b><?= $status ? 'Бренд:' : '' ?> <?= $brand_item->name; ?></b><br>
						<? endif;
						$status = false;
					}
					?>
					<? if ( $product->get_sku() ): ?>
                        Код: <?= $product->get_sku() ?><br>
					<? endif; ?>
					<?
					//attributes
					$attributes = $product->get_attributes();
					foreach ( $attributes as $attribute ):
						$attrName = $attribute->get_name();
						if ( $attribute->get_variation() || $attrName == 'pa_color' || $attrName == 'pa_size' ) {
							continue;
						}
						$values = [];
						if ( $attribute->is_taxonomy() ) {
							$attribute_taxonomy = $attribute->get_taxonomy_object();
							$attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );
							foreach ( $attribute_values as $attribute_value ) {
								$value_name = esc_html( $attribute_value->name );
								if ( $attribute_taxonomy->attribute_public ) {
									$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
								} else {
									$values[] = $value_name;
								}
							}
						} else {
							$values = $attribute->get_options();
							foreach ( $values as &$value ) {
								$value = make_clickable( esc_html( $value ) );
							}
						}
						if ( $attribute->get_visible() ) :?>
							<?= wc_attribute_label( $attribute->get_name() ) ?>:
							<?= implode( ', ', $values ) ?>
                            <br>
						<? endif;
					endforeach; ?>
                </p>
				<? $availability = $product->get_availability()['class'] ?>
                <p class="available <?= $availability ?>">
                    <i class="fas <?= $availability == 'in-stock' ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
					<?= $availability == 'in-stock' ? 'В наличии' : 'Нет в наличии' ?></p>
				<? if ( $availability == 'in-stock' ): ?>
                    <p class="price"><?= $product->get_price() ?> ₽/шт</p>
					<?
					if ( $productType == 'variable' ):
						$variationId = null;
						foreach ( $palette as $item ) {
							$attr = array_shift( $item['attributes'] );
							if ( $default == $attr ) {
								$variationId = $item['variation_id'];
							}
						}
						$addToCart = '?add-to-cart=' . $product->get_id() . '&variation_id=' . $variationId;
						?>
						<?
						$max_value = $product->get_max_purchase_quantity();
						$min_value = $product->get_min_purchase_quantity();
						if ( $max_value && $min_value === $max_value ):?>
                            <div class="quantity hidden">
                                <input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty"
                                       name="<?php echo esc_attr( $input_name ); ?>"
                                       value="<?php echo esc_attr( $min_value ); ?>"/>
                            </div>
						<? else : ?>
                            <div class="quantity">
                                <label for="<?php echo esc_attr( $input_id ); ?>">Количество:</label>
                                <button class="minus"><i class="fas fa-minus"></i></button>
								<?
								$input_value = isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity();
								?>
                                <input type="number" id="<?php echo esc_attr( $input_id ); ?>"
                                       class="input-text qty text" step="<?php echo esc_attr( $step ); ?>"
                                       min="<?php echo esc_attr( $min_value ); ?>"
                                       max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
                                       name="quantity"
                                       value="<?php echo esc_attr( $input_value ); ?>"
                                       title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>"
                                       size="4" pattern="<?php echo esc_attr( $pattern ); ?>"
                                       inputmode="<?php echo esc_attr( $inputmode ); ?>"/>
                                <button class="plus"><i class="fas fa-plus"></i></button>
                            </div>
						<? endif; ?>
                        <a href="<?= $addToCart ?>" class="add-to-cart btn-pink"
                           onclick="yaCounter48380480.reachGoal('v_korzinu'); return true;"><i
                                    class="fas fa-shopping-cart"></i>В
                            корзину</a>
					<? elseif ( $productType == 'simple' ): ?>
                        <form class="cart" method="post" enctype="multipart/form-data">
                            <div class="woocommerce-variation-add-to-cart variations_button">
								<?
								$max_value = $product->get_max_purchase_quantity();
								$min_value = $product->get_min_purchase_quantity();
								if ( $max_value && $min_value === $max_value ):?>
                                    <div class="quantity hidden">
                                        <input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty"
                                               name="<?php echo esc_attr( $input_name ); ?>"
                                               value="<?php echo esc_attr( $min_value ); ?>"/>
                                    </div>
								<? else : ?>
                                    <div class="quantity">
                                        <label for="<?php echo esc_attr( $input_id ); ?>">Количество:</label>
                                        <button class="minus"><i class="fas fa-minus"></i></button>
										<?
										$input_value = isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity();
										?>
                                        <input type="number" id="<?php echo esc_attr( $input_id ); ?>"
                                               class="input-text qty text" step="<?php echo esc_attr( $step ); ?>"
                                               min="<?php echo esc_attr( $min_value ); ?>"
                                               max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
                                               name="quantity"
                                               value="<?php echo esc_attr( $input_value ); ?>"
                                               title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>"
                                               size="4" pattern="<?php echo esc_attr( $pattern ); ?>"
                                               inputmode="<?php echo esc_attr( $inputmode ); ?>"/>
                                        <button class="plus"><i class="fas fa-plus"></i></button>
                                    </div>
								<? endif; ?>
                                <button type="submit"
                                        class="single_add_to_cart_button add-to-cart btn-pink button alt"
                                        onclick="yaCounter48380480.reachGoal('v_korzinu'); return true;"><i
                                            class="fas fa-shopping-cart"></i> <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                                </button>
                                <input type="hidden" name="add-to-cart"
                                       value="<?php echo absint( $product->get_id() ); ?>"/>
                                <input type="hidden" name="product_id"
                                       value="<?php echo absint( $product->get_id() ); ?>"/>
                                <input type="hidden" name="variation_id" class="variation_id" value="0"/>
                            </div>
                        </form>
					<? endif; ?>
				<? endif; ?>
            </div>
        </div>
		<? if ( $productType == 'variable' && count( $palette ) > 0 && count( $palette ) <= 20 ): ?>
            <div class="col-12">
                <h3 class="title-big">Палитра</h3>
                <p class="choice paragraph"></p>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="palette col-xl-5">
                    <div class="list d-flex flex-wrap">
						<? foreach ( $palette as $item ):
							$attr = array_shift( $item['attributes'] );
							?>
                            <div class="item" data-variation-id="<?= $item['variation_id'] ?>">
                                <input type="radio" name="palette" id="<?= $attr ?>"
                                       value="<?= $attr ?>" <?= $default == $attr ? 'checked' : '' ?>>
                                <label class="item" for="<?= $attr ?>"
                                       style="background-image: url('<?= $item['image']['url']; ?>')"></label>
                                <div class="popover popover-bottom"><?= $attr ?></div>
                            </div>
						<? endforeach; ?>
                    </div>
                </div>
                <div class="col-xl-7 d-flex justify-content-end">
					<? get_template_part( 'template-parts/advantage-delivery' ) ?>
                </div>
            </div>
            <div class="d-flex flex-wrap">
				<? if ( $product->get_description() ): ?>
                    <div class="col-xl-6">
                        <h4 class="title-big">Описание</h4>
                        <div class="paragraph"><?= $product->get_description() ?></div>
                    </div>
				<? endif; ?>
				<? if ( get_field( 'состав' ) ): ?>
                    <div class="col-xl-6">
                        <h4 class="title-big">Состав</h4>
                        <p class="paragraph"><? the_field( 'состав' ) ?></p>
                    </div>
				<? endif; ?>
            </div>
		<? else: ?>
			<? if ( $productType == 'variable' && count( $palette ) > 0 ): ?>
                <h3 class="title-big">Палитра</h3>
                <p class="choice paragraph"></p>
                <div class="palette">
                    <div class="list d-flex flex-wrap">
						<? foreach ( $palette as $item ):
							$attr = array_shift( $item['attributes'] );
							?>
                            <div class="item" data-variation-id="<?= $item['variation_id'] ?>">
                                <input type="radio" name="palette" id="<?= $attr ?>"
                                       value="<?= $attr ?>" <?= $default == $attr ? 'checked' : '' ?>>
                                <label class="item" for="<?= $attr ?>"
                                       style="background-image: url('<?= $item['image']['url']; ?>')"></label>
                                <div class="popover popover-bottom"><?= $attr ?></div>
                            </div>
						<? endforeach; ?>
                    </div>
                </div>
			<? endif; ?>
            <div class="d-flex align-items-center flex-wrap">
                <div class="col-xl-5">
					<? if ( $product->get_description() ): ?>
                        <h4 class="title-big">Описание</h4>
                        <div class="paragraph"><?= $product->get_description() ?></div>
					<? endif; ?>
                </div>
                <div class="col-xl-7 d-flex justify-content-end">
					<? get_template_part( 'template-parts/advantage-delivery' ) ?>
                </div>
            </div>
			<? if ( get_field( 'состав' ) ): ?>
                <div class="col-12">
                    <h4 class="title-big">Состав</h4>
                    <div class="paragraph"><? the_field( 'состав' ) ?></div>
                </div>
			<? endif; ?>
		<? endif; ?>
    </section>
	<?
	$upSells = $product->get_upsell_ids();
	if ( $upSells ):?>
        <section class="collection">
            <h2 class="title-big">Рекомендуем также</h2>
            <div class="d-flex flex-wrap">
				<?
				foreach ( $upSells as $product ):
					$_product = wc_get_product( $product ); ?>
                    <div class="col-lg-4">
						<? require get_template_directory() . '/template-parts/product-card.php'; ?>
                    </div>
				<? endforeach; ?>
            </div>
        </section>
	<? endif; ?>
	<?
	$terms = get_the_terms( $id, 'product_cat' );
	if ( count( $terms ) > 1 ) {
		$cat    = end( $terms );
		$parent = get_term( $cat->parent, 'product_cat' );
		if ( get_field( 'есть-коллекции', $parent ) ):
			$collections = get_term_children( $parent->term_id, 'product_cat' );
			unset( $collections[ array_search( $cat->term_id, $collections ) ] );
			if ( ! empty( $collections ) ):
				?>
                <section class="collection">
                    <h2 class="title-big">Коллекции</h2>
                    <div class="collections row">
						<? require_once get_template_directory() . '/template-parts/collection-loop.php' ?>
                    </div>
                </section>
			<? endif;
		endif;
	} ?>
	<? if ( get_field( 'Сео-контент' ) ): ?>
        <div class="paragraph seo-content d-none d-md-block">
            <hr class="d-none d-md-block"><? the_field( 'Сео-контент' ) ?>
        </div>
	<? endif; ?>
</main>

<?php get_footer(); ?>
