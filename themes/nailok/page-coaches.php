<?php
/* Template Name: Тренера */
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
    <div class="d-flex justify-content-around flex-wrap">
		<?
        $coaches = get_field('список');
		foreach ($coaches as $coach) :?>
            <div class="coach-item">
                <img <? the_image('инструктор',$coach) ?> class="photo">
                <div class="about">
                    <? the_field("краткое-описание",$coach) ?>
                    <!--<a href="" class="add-to-cart btn-pink light">Курсы Дарьи</a>-->
                </div>
            </div>
		<? endforeach; ?>
    </div>
	<?= apply_filters( 'the_content', wpautop( get_post_field( 'post_content', $id ), true ) ); ?>
	<? if ( get_field( 'Сео-контент' ) ): ?>
        <div class="paragraph seo-content d-none d-md-block">
            <hr class="d-none d-md-block">
			<? the_field( 'Сео-контент' ) ?>
        </div>
	<? endif; ?>
</main>

<?php get_footer(); ?>
