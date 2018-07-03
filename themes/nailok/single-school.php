<?php
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
    <div class="course-banner" style="background-image: url('<? the_field( 'фото-большое' ) ?>')">
        <div class="info">
			<? if ( get_field( 'длительность' ) ): ?>
                <div class="icon"><i class="far fa-clock"></i></div>
				<? the_field( 'длительность' ) ?>
                <br>
			<? endif; ?>
			<? if ( get_field( 'стоимость' ) ): ?>
                <div class="icon"><i class="far fa-credit-card"></i></div>
				<? the_field( 'стоимость' ) ?>
                <br>
			<? endif; ?>
			<? if ( get_field( 'дата' ) ): ?>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
				<? the_field( 'дата' ) ?><br>
			<? endif; ?>
			<? if ( get_field( 'время' ) ): ?>
				<? the_field( 'время' ) ?>
                <div class="icon"></div>
			<? endif; ?>
            <!--<a href="" class="dates">другие даты</a>-->
        </div>
        <a href="" data-toggle="modal" data-target="#course" class="add-to-cart btn-pink"
           onclick="yaCounter48380480.reachGoal('zapis'); return true;">Записаться</a>
    </div>
    <div class="row justify-content-between">
        <div class="about formated-text <?= get_field( 'тренер' ) ? 'col-md-7' : 'col-12' ?>">
			<? the_field( 'контент' ) ?>
            <a href="" data-toggle="modal" data-target="#course" class="add-to-cart btn-pink"
               onclick="yaCounter48380480.reachGoal('zapis'); return true;">Записаться</a>
        </div>
		<? if ( get_field( 'тренер' ) ): ?>
            <div class="master col-md-5">
                <h4 class="title-big">Инструктор</h4>
                <img <? the_image( 'инструктор', get_field( 'тренер' ) ) ?> class="photo">
                <div class="text">
                    <h4><?= get_the_title( get_field( 'тренер' ) ) ?></h4>
					<? the_field( 'инструктор-контент', get_field( 'тренер' ) ) ?>
                </div>
            </div>
		<? endif; ?>
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
