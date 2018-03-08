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
            <div class="icon"><i class="far fa-clock"></i></div>
			<? the_field( 'длительность' ) ?>
            <br>
            <div class="icon"><i class="far fa-credit-card"></i></div>
			<? the_field( 'стоимость' ) ?>
            <br>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
			<? the_field( 'дата' ) ?><br>
	        <? the_field( 'время' ) ?>
            <div class="icon"></div>
            <!--<a href="" class="dates">другие даты</a>-->
        </div>
        <a href="" data-toggle="modal" data-target="#course" class="add-to-cart btn-pink">Записаться</a>
    </div>
    <div class="row justify-content-between">
        <div class="about col-md-7">
			<? the_field( 'контент' ) ?>
            <a href="" class="add-to-cart btn-pink">Записаться</a>
        </div>
        <div class="master col-md-5">
            <h4 class="title-big">Инструктор</h4>
            <img <? the_image( 'инструктор', get_the_ID() ) ?> class="photo">
            <div class="text">
				<? the_field( 'инструктор-контент' ) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
	        <? get_template_part( 'template-parts/banner-certificate' ) ?>
        </div>
    </div>
	<? get_template_part( 'template-parts/banner-address' ) ?>
</main>

<?php get_footer(); ?>
