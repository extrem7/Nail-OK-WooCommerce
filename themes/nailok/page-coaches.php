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
		while ( have_rows( 'список' ) ) : the_row() ?>
            <div class="coach-item">
                <img <? repeater_image('фото') ?> class="photo">
                <div class="about">
                    <h4 class="title-big"><? the_sub_field('имя') ?></h4>
                    <p><? the_sub_field("описание") ?></p>
                    <!--<a href="" class="add-to-cart btn-pink light">Курсы Дарьи</a>-->
                </div>
            </div>
		<? endwhile; ?>
    </div>
	<? get_template_part( 'template-parts/banner-course' ) ?>
</main>

<?php get_footer(); ?>
