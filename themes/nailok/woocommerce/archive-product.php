<?php
get_header( 'shop' );
$isPopular = get_page_template_slug() == 'woocommerce/hot-products.php';
?>

<?php get_sidebar() ?>
    <main class="content col-lg-8 col-xl-9">
		<? wc_print_notices(); ?>
        <div class="before-content">
            <div class="woocommerce-breadcrumb">
				<?php woocommerce_breadcrumb(); ?>
            </div>
            <div class="right">
                <a href="<?= get_permalink( 427 ) ?>"><i class="fas fa-check-circle"></i>Как заказать</a>
                <a href="<?= get_permalink( 427 ) ?>"><i class="fas fa-credit-card"></i>Как оплатить</a>
                <a href="<?= get_permalink( 427 ) ?>"><i class="fas fa-cube"></i>Как получить</a>
            </div>
        </div>
        <div class="catalog-control">
            <p class="show-as">
                Отображать
                <a href="" class="btn-pink round active show-block"><i class="fas fa-th-large"></i></a>
                <a href="" class="btn-pink round show-list"><i class="fas fa-th-list"></i></a>
            </p>
            <div class="woocommerce-ordering">
				<?
				if ( isset( $_GET[ current( array_keys( $_GET ) ) ] ) && empty( $_GET[ current( array_keys( $_GET ) ) ] ) ) {
					unset( $_GET[ current( array_keys( $_GET ) ) ] );
				}
				if ( isset( $_GET['shop/'] ) ) {
					unset( $_GET['shop/'] );
				}
				//pre( $_GET );
				unset( $_GET['add-to-cart'] );
				unset( $_GET['variation_id'] );
				global $page_cat;
				global $paged;
				$cat     = get_queried_object();
				$slug    = '';
				$baseUrl = $isPopular ? '/' . get_post( 6199 )->post_name . '/' : '/shop/';
				if ( is_product_category() ) {
					$slug    = get_queried_object()->slug;
					$baseUrl = "/shop/$slug/";
				} elseif ( $cat->taxonomy == 'pwb-brand' ) {
					$slug    = $cat->slug;
					$baseUrl = "/brand/$slug/";
				}
				$paged        = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : $page_cat;
				$orderby_copy = 'date';
				$orderbyWas   = false;
				if ( isset( $_GET['filters']['orderby'] ) ) {
					$orderby_copy = $_GET['filters']['orderby'];
					$orderbyWas   = true;
				}
				$orderlist = [
					'price'      => 'по цене(возрастание)',
					'price-desc' => 'по цене(убывание)',
					'popularity' => 'по популярности',
					'rating'     => 'по рейтингу',
					'date'       => 'по новизне'
				];
				?>
                Сортировать
                <a data-toggle="dropdown"><?= $orderlist[ $orderby_copy ] ?><i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
					<? foreach ( $orderlist as $key => $val ):
						if ( $orderby_copy == $key ) {
							continue;
						}
						$_GET['filters']['orderby'] = $key;
						$filters                    = '?' . http_build_query( $_GET );
						?>
                        <li><a href="<?= $baseUrl ./* $paged > 1 ? "page/$paged/" : '' .*/
						                 $filters ?>"><?= $val ?></a></li>
					<? endforeach;
					$_GET['filters']['orderby'] = $orderby_copy;
					if ( ! $orderbyWas ) {
						unset( $_GET['filters']['orderby'] );
					}
					?>
                </ul>
            </div>
            <div class="show-count">
                Показывать по
				<?
				$limit_copy = 15;
				$limitWas   = false;
				if ( isset( $_GET['filters']['limit'] ) ) {
					$limit_copy = $_GET['filters']['limit'];
					$limitWas   = true;
				}
				$_GET['filters']['limit'] = 15;
				$filters                  = '?' . http_build_query( $_GET );

				?>
                <a href="<?= $baseUrl . /*$paged > 1 ? "page/$paged/" : '' .*/
				             $filters ?>"
                   class="btn-pink round <?= $limit_copy == 15 ? 'active' : '' ?>">15</a>
				<?
				$_GET['filters']['limit'] = 30;
				$filters                  = '?' . http_build_query( $_GET );
				?>
                <a href="<?= $baseUrl . /*$paged > 1 ? "page/$paged/" : '' .*/
				             $filters ?>"
                   class="btn-pink round <?= $limit_copy == 30 ? 'active' : '' ?>">30</a>
				<?
				$_GET['filters']['limit'] = 45;
				$filters                  = '?' . http_build_query( $_GET );
				?>
                <a href="<?= $baseUrl . /*$paged > 1 ? "page/$paged/" : '' .*/
				             $filters ?>"
                   class="btn-pink round <?= $limit_copy == 45 ? 'active' : '' ?>">45</a>
				<?
				$_GET['filters']['limit'] = $limit_copy;
				if ( ! $limitWas ) {
					unset( $_GET['filters']['limit'] );
				}
				?>
            </div>
        </div>
		<?
		if ( ! is_shop() ): ?>
			<? if ( $isPopular ): ?>
                <h1 class="title-big"><? the_title() ?></h1>
                <p class="cat-about"><?= apply_filters( 'the_content', get_post_field( 'post_content', $id ) ); ?></p>
			<? else: ?>
                <h1 class="title-big"><? echo get_queried_object()->name ?></h1>
                <p class="cat-about"><?= $cat->description ?></p>
			<? endif;
		endif; ?>
		<?
		if ( is_product_category() ):
			if ( get_field( 'новинки', $cat ) ): ?>
                <section class="latest">
                    <div class="latest-list d-flex flex-wrap align-items-stretch align-items-lg-center justify-content-end border-pink">
                        <div class="hot col-xl-4 col-sm-6 col-12 ">
                            <h3 class="title-big">Новинки</h3>
                            <p class="paragraph"><? the_field( 'новинки', wc_get_page_id( 'shop' ) ) ?></p>
                            <a href="https://vk.com/naillsshop" target="_blank" class="btn-pink light"><i
                                        class="fas fa-arrow-right"></i>Подписаться</a>
                        </div>
						<? $latest = get_field( 'новинки', $cat );
						foreach ( $latest as $last ) {
							$_product = wc_get_product( $last ); ?>
                            <div class="col-xl-4 col-sm-6">
								<?
								require get_template_directory() . '/template-parts/product-card.php'; ?>
                            </div>
							<?
						}
						?>
                    </div>
                </section>
			<? endif;
			if ( ! get_field( 'включить-каталог', $cat ) && get_field( 'есть-коллекции', $cat ) ):
				//$collections = get_term_children( $cat->term_id, 'product_cat' );
				$collections = get_terms( 'product_cat', [ 'parent' => $cat->term_id, 'hide_empty' => false ] );
				?>
                <section class="collection">
                    <h2 class="title-big">Коллекции</h2>
                    <div class="collections row">
						<? require_once get_template_directory() . '/template-parts/collection-loop.php' ?>
                    </div>
                </section>
			<? endif; ?>
		<? endif; ?>
		<?
		if ( is_shop() || $cat->taxonomy == 'pwb-brand' || get_field( 'включить-каталог', $cat ) || $isPopular ): ?>
            <section class="products" style="<?= is_shop() ? 'padding-top:0' : '' ?>">
				<? if ( is_shop() ): ?>
                    <h1 class="title-big">Товары</h1>
				<? endif; ?>
                <div class="d-flex flex-wrap">
					<?
					$per_page = 15;
					$orderby  = null;
					$params   = [
						'post_type'   => 'product',
						'post_status' => 'publish',
						'paged'       => $paged
					];
					if ( isset( $_GET['filters']['limit'] ) ) {
						$per_page = $_GET['filters']['limit'];
					};
					$params['posts_per_page'] = $per_page;
					if ( isset( $_GET['filters']['orderby'] ) ) {
						$orderby = $_GET['filters']['orderby'];
					};
					switch ( $orderby ) {
						case 'date':
							$params['orderby'] = 'ASC';
							break;
						case 'price':
							$params['meta_key']                  = '_price';
							$params['orderby']['meta_value_num'] = 'ASC';
							break;
						case 'price-desc':
							$params['meta_key']                  = '_price';
							$params['orderby']['meta_value_num'] = 'DESC';
							break;
						case 'popularity':
							$params['meta_key']                  = 'total_sales';
							$params['orderby']['meta_value_num'] = 'DESC';
							break;
						case 'rating':
							$params['meta_key'] = '_wc_average_rating';
							$args['orderby']    = [
								'meta_value_num' => 'DESC',
								'ID'             => 'ASC',
							];
							break;
						default:
							$params['orderby'] = 'menu_order title';
							$params['order']   = 'ASC';
					}
					if ( is_product_category() ) {
						$params['tax_query'] = [
							[
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => get_queried_object()->term_id,
								'operator' => 'IN'
							]
						];
					}
					if ( $cat->taxonomy == 'pwb-brand' ) {
						$params['tax_query'] = [
							[
								'taxonomy' => 'pwb-brand',
								'field'    => 'term_id',
								'terms'    => get_queried_object()->term_id,
								'operator' => 'IN'
							]
						];
					}
					if ( $isPopular ) {
						$params['meta_query'] = [
							'relation' => 'OR',
							[
								'key'     => '_sale_price',
								'value'   => 0,
								'compare' => '>',
								'type'    => 'numeric'
							],
							[
								'key'     => 'новинка',
								'value'   => 1,
								'compare' => '=',
							]
						];
					}
					$wc_query = new WP_Query( $params );
					if ( $wc_query->have_posts() ) :
						while ( $wc_query->have_posts() ) :
							$wc_query->the_post();
							$_product = wc_get_product( $post->ID ); ?>
                            <div class="col-xl-4 col-sm-6">
								<? require get_template_directory() . '/template-parts/product-card.php' ?>
                            </div>
                            <div class="product-card-long">
                                <div class="hover"></div>
                                <div class="photo">
									<? $image = wp_prepare_attachment_for_js( $_product->get_image_id() ); ?>
                                    <img src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>">
                                </div>
                                <div class="info">
                                    <a href="<?= $_product->get_permalink() ?>"
                                       class="title"><?= $_product->get_title() ?></a>
                                    <div class="bottom">
                                        <p class="price"><?= $price ? $price . ' ₽' : '' ?></p>
                                    </div>
                                </div>
                                <div class="buy">
									<? if ( $variable ):
										/*$palette = $_product->get_available_variations();
										$default = $_product->get_variation_default_attribute( 'Палитра' );
										$variationId = null;
										foreach ( $palette as $item ) {
											$attr = array_shift( $item['attributes'] );
											if ( $default == $attr ) {
												$variationId = $item['variation_id'];
											}
										}
										$addToCart = '?';
										if ( ! empty( $_GET['filters'] ) ) {
											$addToCart = '?' . http_build_query( $_GET ) . '&';
										}
										$addToCart .= 'add-to-cart=' . $_product->get_id() . '&variation_id=' . $variationId;*/
										?>
                                        <!--<a href="<? //= $addToCart
										?>" class="add-to-cart btn-pink"><i
                                                    class="fas fa-shopping-cart"></i> в корзину</a>-->
									<? else : ?>
                                        <a href="<?= $_product->add_to_cart_url() ?>" class="add-to-cart btn-pink"
                                           onclick="yaCounter48380480.reachGoal('v_korzinu'); return true;"><i
                                                    class="fas fa-shopping-cart"></i> в корзину</a>
									<? endif; ?>
									<?
									$product = $_product;
									if ( ! $variable )
										echo do_shortcode( '[ti_wishlists_addtowishlist]' ) ?>
                                </div>
                            </div>
						<? endwhile;
					else :?>
                        <p>Товары не найдены<br><br><a href="/shop" class="btn-pink">Назад</a></p>
					<? endif;
					wp_reset_postdata(); ?>
                </div>
                <!--pagination-->
				<? if ( $wc_query->max_num_pages > 1 ): ?>
                    <div class="pagination">
						<?
						unset( $_GET['page'] );
						$filters = '';
						if ( ! empty( $_GET['filters'] ) ) {
							$filters = '?' . http_build_query( $_GET );
						}
						?>
                        <!--prev-->
                        <a href="<?= $baseUrl . $filters ?>" class="prev <? if ( $paged - 1 <= 0 )
							echo 'disabled' ?>"><<</a>
                        <a href="<?= $baseUrl . 'page/' . ( $paged - 1 ) . '/' . $filters ?>"
                           class="prev <? if ( $paged - 1 <= 0 )
							   echo 'disabled' ?>"><</a>
                        <!--prev-->
						<? if ( $paged - 4 > 0 ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged - 4 ) . '/' . $filters ?>"><? echo $paged - 4 ?></a>
						<? endif; ?>
						<? if ( $paged - 3 > 0 ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged - 3 ) . '/' . $filters ?>"><? echo $paged - 3 ?></a>
						<? endif; ?>
						<? if ( $paged - 2 > 0 ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged - 2 ) . '/' . $filters ?>"><? echo $paged - 2 ?></a>
						<? endif; ?>
						<? if ( $paged - 1 > 0 ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged - 1 ) . '/' . $filters ?>"><? echo $paged - 1 ?></a>
						<? endif; ?>

                        <!--current-->
                        <a href="<? echo $paged . '/?' . $filters ?>"
                           class="active disabled"><? echo $paged ?></a>
						<? if ( $wc_query->max_num_pages > $paged ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged + 1 ) . '/' . $filters ?>"><? echo $paged + 1 ?></a>
						<? endif; ?>
                        <!--current-->

						<? if ( $wc_query->max_num_pages > $paged + 1 ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged + 2 ) . '/' . $filters ?>"><? echo $paged + 2 ?></a>
						<? endif; ?>
						<? if ( $wc_query->max_num_pages > $paged + 2 ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged + 3 ) . '/' . $filters ?>"><? echo $paged + 3 ?></a>
						<? endif; ?>
						<? if ( $wc_query->max_num_pages > $paged + 3 ): ?>
                            <a href="<?= $baseUrl . 'page/' . ( $paged + 4 ) . '/' . $filters ?>"><? echo $paged + 4 ?></a>
						<? endif; ?>
                        <!--next-->
                        <a href="<?= $baseUrl . 'page/' . ( $paged + 1 ) . '/' . $filters ?>"
                           class="next <? if ( $wc_query->max_num_pages <= $paged )
							   echo 'disabled' ?>">></a>

                        <a href="<?= $baseUrl . 'page/' . $wc_query->max_num_pages . '/' . $filters ?>"
                           class="next <? if ( $wc_query->max_num_pages <= $paged )
							   echo 'disabled' ?>">>></a>
                        <!--next-->
                    </div>
				<? endif; ?>
                <!--pagination-->
            </section>
		<? endif; ?>
        <div class="paragraph seo-content d-none d-md-block">
            <hr class="d-none d-md-block">
			<?
			if ( $isPopular ) {
				echo apply_filters( 'the_content', get_field( 'Сео-контент' ) );
			} else {
				$term = get_term( get_queried_object()->term_id );
				$seo  = get_field( 'Сео-контент', $term );
				echo $seo ? $seo : apply_filters( 'the_content', get_post_field( 'post_content', wc_get_page_id( 'shop' ) ) );
			} ?>
        </div>
        <div class="after-advantages">
            <div class="advantage-item delivery min">
                <div class="text">
					<? $item = get_field( 'преимущество-доставка', 'option' ) ?>
                    <div class="title"><?= $item['заголовок'] ?></div>
                    <p><?= $item['текст'] ?></p>
                </div>
                <img src="<? path() ?>img/delivery-item.png" alt="">
            </div>
            <div class="advantage-item service min">
                <div class="text">
					<? $item = get_field( 'преимущество-сервис', 'option' ) ?>
                    <div class="title"><?= $item['заголовок'] ?></div>
                    <p><?= $item['текст'] ?></p>
                </div>
                <img src="<? path() ?>img/service-item.png" alt="">
            </div>
            <div class="advantage-item study min">
                <div class="text">
					<? $item = get_field( 'преимущество-учёба', 'option' ) ?>
                    <div class="title"><?= $item['заголовок'] ?></div>
                    <p><?= $item['текст'] ?></p>
                </div>
                <img src="<? path() ?>img/study-item.png" alt="">
            </div>
        </div>
    </main>

<? get_footer( 'shop' );
