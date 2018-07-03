<!DOCTYPE html>
<html lang="<? bloginfo( 'language' ) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= wp_get_document_title() ?></title>
	<? wp_head() ?>
    <link rel="icon" sizes="16x16" href="<? path()  ?>img/fav-16.png">
    <link rel="icon" sizes="32x32" href="<? path()  ?>img/fav-32.png">
    <link rel="icon" sizes="64x64" href="<? path()  ?>img/fav-64.png">
    <link rel="icon" sizes="160x160" href="<? path()  ?>img/fav-160.png">
</head>
<?
if ( is_404() ) {
	$bodyClass = "not-found-page";
} else {
    if(is_page()){
        $bodyClass .= " custom-page ";
    }
	if ( is_front_page() ) {
		$bodyClass .= " home-page ";
	}
	if ( is_category( 21 ) ) {
		$bodyClass .= " news-page ";
	} else {
		global $post;
		$postcat = get_the_category( $post->ID );
		if ( $postcat[0]->term_id == 21 ) {
			$bodyClass .= " news-single-page ";
		}
	}
	if ( get_post_type() == 'school' ) {
		$bodyClass .= " course-page ";
	}
	if(get_page_template_slug() == 'woocommerce/hot-products.php'){
		$bodyClass .= " catalog-page ";
    }
	switch ( get_page_template_slug() ) {
		case 'page-coaches.php':
			$bodyClass = "coaches-page";
			break;
		case 'page-school.php':
			$bodyClass = "school-page";
			break;
		case 'page-promotion.php':
			$bodyClass = "promotion-page";
			break;
		case 'page-contacts.php':
			$bodyClass = "contacts-page";
			break;
	}
	if ( get_the_ID() == 255 ) {
		$bodyClass = "favorite-page";
	}
	if ( is_search() ) {
		$bodyClass = "search-page";
	}
	if ( is_cart() ) {
		$bodyClass = "cart-page";
	}
	if ( is_product() ) {
		$bodyClass = "product-page";
	}
	$cat = get_queried_object();
	if ( is_shop() || is_product_category() || $cat->taxonomy == 'pwb-brand' ) {
		$bodyClass = "catalog-page";
	}
}
?>
<body class="<?= $bodyClass ?>">
<script>
    var addToCart = <?= ( ! empty( $_GET['add-to-cart'] ) ) ? 'true' : 'false'?>;
</script>
<header class="header-mobile d-block d-md-none">
    <div class="top d-flex justify-content-between align-items-center">
        <a href="/" class="logo"><img <? the_image( 'хедер-лого', 'option' ) ?>></a>
        <div class="right d-flex align-items-center">
			<? if ( get_field( 'хедер-телефон', 'option' ) ): ?>
                <a href="tel:<?= preg_replace( '/[^0-9]/', '', get_field( 'хедер-телефон', 'option' ) ); ?>"
                   class="btn-pink round phone"><i class="fas fa-phone"></i></a>
			<? endif; ?>
            <a href="/cart" class="cart" onclick="yaCounter48380480.reachGoal('korzina'); return true;"><i class="fas fa-shopping-cart"></i></a>
            <button type="button" class="toggle-btn">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
	<?php wp_nav_menu( array(
		'menu'       => 'Хедер',
		'container'  => null,
		'items_wrap' => '<ul  class="menu">%3$s</ul>',
		'walker'     => new Bootstrap_Walker_Nav_Menu,
	) ); ?>
    <div class="bottom d-flex justify-content-between align-items-center">
        <a href="" class="filter"><i class="fas fa-filter"></i> Каталог</a>
        <a href="/?s=поиск" class="search">Поиск <i class="fas fa-search"></i></a>
    </div>
</header>
<header class="header container d-none d-md-block">
    <div class="row">
        <div class="col-lg-3"><a href="/" class="logo"><img <? the_image( 'хедер-лого', 'option' ) ?>></a>
        </div>
        <div class="col-lg-9">
            <div class="top row justify-content-around  justify-content-lg-between">
                <div class="left d-flex">
                    <!--<div class="cabinet">
                        <a data-toggle="dropdown"><i class="fas fa-user"></i> Личный кабинет <i
                                    class="fas fa-caret-down"></i></a>
						<?
						$menu_args = [
							'menu'       => 'Личный кабинет',
							'menu_class' => 'dropdown-menu',
							'container'  => null
						];
						//wp_nav_menu( $menu_args )
						?>
                    </div>-->
					<?
					$counter = new TInvWL_Public_TopWishlist( '' );
					$count   = $counter->counter();
					if ( $count ):?>
                        <div class="wishlist">
                            <a href="/wishlist"><i class="fas fa-heart"></i>Избранное (<?= $count ?>)</a>
                        </div>
					<? endif; ?>
                    <div class="cart">
                        <a href="/cart" onclick="yaCounter48380480.reachGoal('korzina'); return true;"><i class="fas fa-shopping-cart"></i>
							<? if ( ! empty( WC()->cart->get_cart() ) ): ?>
                                <span class="cart-counter"><? echo WC()->cart->get_cart_contents_count() ?></span>
							<? endif; ?>
                            Корзина</a>
                    </div>
                </div>
                <div class="right d-flex">
					<? if ( get_field( 'хедер-вк', 'option' ) ): ?>
                        <a target="_blank" href="<? the_field( 'хедер-вк', 'option' ) ?>" class="btn-pink round"><i
                                    class="fab fa-vk"></i></a>
					<? endif; ?>
					<? if ( get_field( 'хедер-инстаграм', 'option' ) ): ?>
                        <a target="_blank" href="<? the_field( 'хедер-инстаграм', 'option' ) ?>" class="btn-pink round"><i
                                    class="fab fa-instagram"></i></a>
					<? endif; ?>
					<? if ( get_field( 'хедер-телефон', 'option' ) ): ?>
                        <a href="tel:<?= preg_replace( '/[^0-9]/', '', get_field( 'хедер-телефон', 'option' ) ); ?>"
                           class="btn-pink phone"><i
                                    class="fas fa-phone"></i><? the_field( 'хедер-телефон', 'option' ) ?></a>
					<? endif; ?>
                </div>
            </div>
			<?php wp_nav_menu( array(
				'menu'       => 'Хедер',
				'container'  => null,
				'items_wrap' => '<ul  class="menu row  justify-content-around justify-content-lg-between">%3$s</ul>',
				'walker'     => new Bootstrap_Walker_Nav_Menu,
			) ); ?>
        </div>
    </div>
</header>
<div class="d-flex main-wrap">
    <div class="container">
        <div class="row flex-row flex-md-column-reverse flex-lg-row align-items-center align-items-lg-start">