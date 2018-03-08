<?php
/* Template Name: Корзина */
get_header(); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
	<div class="before-content">
		<div class="woocommerce-breadcrumb">
			<?php woocommerce_breadcrumb(); ?>
		</div>
		<div class="right">
			<a href=""><i class="fas fa-check-circle"></i>Как заказать</a>
			<a href=""><i class="fas fa-credit-card"></i>Как оплатить</a>
			<a href=""><i class="fas fa-cube"></i>Как получить</a>
		</div>
	</div>
	<section class="cart-section">
		<h1 class="title-big">Корзина</h1>
		<?= do_shortcode('[woocommerce_cart]') ?>
	</section>
		<?= do_shortcode('[woocommerce_checkout]') ?>
</main>

<?php get_footer(); ?>
