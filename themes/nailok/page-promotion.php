<?php
/* Template Name: Акции */
get_header(); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
    <div class="before-content">
        <div class="woocommerce-breadcrumb">
			<?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
				dimox_breadcrumbs();
			} ?>
        </div>
    </div>
    <h1 class="title-big"><? the_title() ?></h1>
	<? while ( have_rows( 'список' ) ) :
		the_row() ?>
        <div class="promotion-item" style="background-image: url('<? the_sub_field( 'изображение' ) ?>')">
			<? if ( get_sub_field( 'дата' ) ): ?>
                <p class="date"><? the_sub_field( 'дата' ) ?></p>
			<? endif; ?>
            <p href="" class="title-big"><? the_sub_field( 'название' ) ?></p>
			<? if ( get_sub_field( 'текст' ) ): ?>
                <a href="" class="add-to-cart btn-pink light">Подробнее</a>
			<? endif; ?>
        </div>
		<? if ( get_sub_field( 'текст' ) ): ?>
        <div class="item-content formated-text"><? the_sub_field( 'текст' ) ?></div>
	<? endif; ?>
	<? endwhile; ?>
	<?= apply_filters( 'the_content', wpautop( get_post_field( 'post_content', $id ), true ) ); ?>
	<? if ( get_field( 'Сео-контент' ) ): ?>
        <div class="paragraph seo-content d-none d-md-block">
            <hr class="d-none d-md-block">
			<? the_field( 'Сео-контент' ) ?>
        </div>
	<? endif; ?>
</main>

<?php get_footer(); ?>
