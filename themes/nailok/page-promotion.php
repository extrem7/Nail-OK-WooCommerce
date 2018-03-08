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
            <p class="date"><? the_sub_field( 'дата' ) ?></p>
            <p href="" class="title-big"><? the_sub_field( 'название' ) ?></p>
			<? if ( get_sub_field( 'текст' ) ): ?>
                <a href="" class="add-to-cart btn-pink light">Подробнее</a>
			<? endif; ?>
        </div>
		<? if ( get_sub_field( 'текст' ) ): ?>
        <div class="item-content"><? the_sub_field( 'текст' ) ?></div>
	<? endif; ?>
	<? endwhile; ?>
    <div class="row">
        <div class="col-12">
			<? get_template_part( 'template-parts/banner-certificate' ) ?>
        </div>
    </div>
	<? get_template_part( 'template-parts/banner-address' ) ?>
	<? get_template_part( 'template-parts/banner-course' ) ?>
</main>

<?php get_footer(); ?>
