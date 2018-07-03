<?php
/* Template Name: Курсы */
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
    <h1 class="title-big" style="text-align: left;" align="center"><? the_title() ?></h1>
    <div class="d-flex justify-content-between flex-wrap">
		<?
		$status = true;
		while ( have_rows( 'список' ) ) : the_row() ?>
			<? $_post = get_sub_field( 'курс' )->ID ?>
            <div class="course-item <?= $status ? 'course-big' : '' ?>"
                 style="background-image: url('<? if ( $status ) {
				     the_field( 'фото-большое', $_post );
			     } else {
				     echo get_the_post_thumbnail_url( $_post );
			     } ?>')">
				<? if ( get_field( 'дата', $_post ) ): ?>
                    <p class="date"><? the_field( 'дата', $_post ) ?></p>
				<? endif; ?>
                <a href="<?= get_permalink( $_post ) ?>"
                   class="title-big"><? the_field( 'название-короткое', $_post ); ?></a>
                <div class="info">
					<? if ( get_field( 'длительность', $_post ) ): ?>
                        <i class="far fa-clock"></i> <? the_field( 'длительность', $_post ) ?>
                        <br>
					<? endif; ?>
					<? if ( get_field( 'стоимость', $_post ) ): ?>
                        <i class="far fa-credit-card"></i> <? the_field( 'стоимость', $_post ) ?>
					<? endif; ?>
                </div>
                <div class="control">
                    <a href="" data-toggle="modal" data-target="#course"
                       class="add-to-cart btn-pink light" onclick="yaCounter48380480.reachGoal('zapis'); return true;">Записаться</a>
                    <a href="<?= get_permalink( $_post ) ?>" class="more">Подробнее</a>
                </div>
            </div>
			<?
			$status = false;
		endwhile; ?>
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
