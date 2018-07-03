<?php
/* Template Name: Главная */
get_header(); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
	<? wc_print_notices(); ?>
    <section id="banner" class="carousel slide banner" data-interval="4000" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
			<?
			$status = true;
			while ( have_rows( 'слайдер-продаж' ) ) : the_row() ?>
                <div class="carousel-item <?= $status ? 'active' : '' ?>"
                     style="background-image: url('<? the_sub_field( 'картинка' ) ?>')">
                    <a href="<? the_sub_field( 'ссылка' ) ?>" class="wrap">
                        <h2 class="title-big"><? the_sub_field( 'заголовок' ) ?></h2>
                        <p class="text"><? the_sub_field( 'текст' ) ?></p>
						<? if ( get_sub_field( 'скидка' ) ): ?>
                            <span class="sale"><? the_sub_field( 'скидка' ) ?></span>
						<? endif; ?>
                    </a>
                </div>
				<?
				$status = false;
			endwhile; ?>
        </div>
        <ol class="carousel-indicators">
			<?
			$status = true;
			$li     = 0;
			while ( have_rows( 'слайдер-продаж' ) ) : the_row() ?>
                <li data-target="#banner" data-slide-to="<?= $li ?>" class="<?= $status ? 'active' : '' ?>"></li>
				<?
				$status = false;
				$li ++;
			endwhile; ?>
        </ol>
    </section>
	<? if ( get_field( 'наборы-список' ) ): ?>
        <section class="starter-pack d-flex">
            <div class="left">
                <h2 class="title-big">
                    Наборы<br>
                    для старта
                </h2>
                <p class="text"><? the_field( 'наборы' ) ?></p>
                <a href="<?= get_term_link( 30 ) ?>" class="btn-pink light">
                    <i class="fas fa-arrow-right"></i>Посмотреть все наборы</a>
            </div>
            <div id="starter-pack" class="carousel slide" data-interval="4000" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
					<?
					$packs     = get_field( 'наборы-список' );
					$status    = true;
					$i         = 1;
					foreach ( $packs as $pack ):
						$product = wc_get_product( $pack );
						$image = wp_prepare_attachment_for_js( $product->get_image_id() );
						?>
                        <div class="carousel-item <?= $status ? 'active' : '' ?>"
                             style="background-image: url('<?= $image['url'] ?>')">
                            <div class="wrap">
                                <a href="<?= $product->get_permalink() ?>" class="title">
                                    <mark><?= $product->get_title() ?></mark>
                                </a>
                                <div class="buy">
                                    <a href="<?= $product->add_to_cart_url() ?>" class="add-to-cart btn-pink"><i
                                                class="fas fa-shopping-cart"></i>в
                                        корзину</a>
									<?= do_shortcode( '[ti_wishlists_addtowishlist]' ) ?>
                                </div>
                                <div class="bottom">
                                    <p class="price"><?= $product->get_price() ?> ₽</p>
                                    <div class="num">
                                        <span class="big"><?= $i ?></span>
                                        <i>/</i>
                                        <span class="min"><?= count( $packs ) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?
						$status = false;
						$i ++;
					endforeach;
					?>
                </div>
                <a class="car-cont carousel-control-prev" href="#starter-pack" role="button"
                   data-slide="prev"><i class="fas fa-chevron-left"></i></a>
                <a class="car-cont carousel-control-next" href="#starter-pack" role="button"
                   data-slide="next"><i class="fas fa-chevron-right"></i></a>
            </div>
        </section>
	<? endif; ?>
    <section class="products">
        <div class="hot">
            <h3 class="title-big"><? the_field( 'горячие-заголовок' ) ?></h3>
            <p class="paragraph"><? the_field( 'горячие-текст' ) ?></p>
            <a href="<?= get_permalink( 6199 ) ?>" class="btn-pink light"><i class="fas fa-arrow-right"></i>Посмотреть
                все</a>
        </div>
		<?
		$products = get_field( 'горячие' );

		foreach ( $products as $id ):
			$_product = wc_get_product( $id ); ?>
			<? require 'template-parts/product-card.php' ?>
		<? endforeach; ?>
    </section>
    <section class="advantages d-flex justify-content-between">

		<? get_template_part( 'template-parts/advantage-delivery' ) ?>
		<? get_template_part( 'template-parts/advantage-service' ) ?>
    </section>
    <section class="brands-section">
        <h3 class="title-big">Бренды</h3>
        <div id="brands" class="carousel slide d-none d-md-block" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
				<?
				$status = true;
				while ( have_rows( 'слайдер-бренды' ) ) : the_row() ?>
                    <div class="carousel-item <?= $status ? 'active' : '' ?>">
						<? while ( have_rows( 'слайд' ) ) : the_row() ?>
                            <a href="<? the_sub_field( 'ссылка' ) ?>"><img <? repeater_image( 'логотип' ) ?>></a>
						<? endwhile; ?>
                    </div>
					<?
					$status = false;
				endwhile; ?>
            </div>
            <ol class="carousel-indicators">
				<?
				$status = true;
				$li     = 0;
				if ( count( get_field( 'слайдер-бренды' ) ) > 1 ):
					while ( have_rows( 'слайдер-бренды' ) ) : the_row() ?>
                        <li data-target="#brands" data-slide-to="<?= $li ?>"
                            class="<?= $status ? 'active' : '' ?>"></li>
						<?
						$status = false;
						$li ++;
					endwhile;
				endif; ?>
            </ol>
        </div>
        <div id="brands-mobile" data-interval="2000" class="carousel slide d-block d-md-none" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
				<?
				$status = true;
				while ( have_rows( 'слайдер-бренды-мобильный' ) ) : the_row() ?>
                    <div class="carousel-item <?= $status ? 'active' : '' ?>">
                        <a href="<? the_sub_field( 'ссылка' ) ?>"><img <? repeater_image( 'логотип' ) ?>></a>
                    </div>
					<?
					$status = false;
				endwhile; ?>
            </div>
            <ol class="carousel-indicators">
				<?
				$status = true;
				$li     = 0;
				while ( have_rows( 'слайдер-бренды-мобильный' ) ) : the_row() ?>
                    <li data-target="#brands-mobile" data-slide-to="<?= $li ?>" class="<?= $status ? 'active' : '' ?>"></li>
					<?
					$status = false;
					$li ++;
				endwhile; ?>
            </ol>
        </div>
    </section>
    <section class="benefits">
		<? $benefits = get_field( 'преимущества' ) ?>
        <div class="row justify-content-around">
            <a href="<? the_permalink( 448 ) ?>" class="item active col-xl-4 col-md-6">
                <i class="far fa-thumbs-up"></i>
                <p class="title-big"><?= $benefits['блок-1-заголовок'] ?></p>
                <p class="paragraph"><?= $benefits['блок-1-текст'] ?></p>
            </a>
            <a href="<? the_permalink( 775 ) ?>" class="item col-xl-4 col-md-6">
                <i class="fas fa-graduation-cap"></i>
                <p class="title-big"><?= $benefits['блок-2-заголовок'] ?></p>
                <p class="paragraph"><?= $benefits['блок-2-текст'] ?></p>
            </a>
            <a href="<? the_permalink( 282 ) ?>" class="item col-xl-4 col-md-6">
                <i class="far fa-dot-circle"></i>
                <p class="title-big"><?= $benefits['блок-3-заголовок'] ?></p>
                <p class="paragraph"><?= $benefits['блок-3-текст'] ?></p>
            </a>
        </div>
        <div class="paragraph seo-content d-none d-md-block">
            <hr class="d-none d-md-block">
			<? the_field( 'Сео-контент' ) ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
