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
    <h1 class="title-big"><? single_cat_title() ?></h1>
    <div class="row">
		<?php
		$wp_query = new WP_Query();
		$limit    = 9;
		$wp_query->query( [ 'cat' => '21', 'posts_per_page' => $limit ] );
		while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <article class="news-item" style="background-image: url('<? the_post_thumbnail_url() ?>')">
                <div class="top d-flex">
					<?
					$ru_month = [
						'Январь',
						'Февраль',
						'Март',
						'Апрель',
						'Май',
						'Июнь',
						'Июль',
						'Август',
						'Сентябрь',
						'Октябрь',
						'Ноябрь',
						'Декабрь'
					];
					$month    = $ru_month[ intval( get_the_date( 'm' ) ) - 1 ];
					?>
                    <div class="date"><?
						echo get_the_date( 'd' );
						echo ' ' . $month . ' ';
						echo get_the_date( 'Y' );
						?></div>
                    <div class="time"><i class="fas fa-hourglass-half"></i><? the_field( 'время-чтения' ) ?></div>
                </div>
                <a href="<? the_permalink() ?>" class="title-big"><? the_title() ?></a>
                <p class="text"><?php remove_filter( 'the_content', 'wpautop' );
					the_content(); ?></p>
                <a href="<? the_permalink() ?>" class="btn-pink light">Читать далее</a>
            </article>
		<?php endwhile;
		?>
    </div>
	<? if ( ( $wp_query->max_num_pages * $limit ) > $limit ): ?>
        <div class="more">
            <hr>
            <a href="">Показать больше статей</a>
            <hr>
        </div>
		<?
	endif;
	wp_reset_query(); ?>
    <div class="seo-text">
        <p class="paragraph d-none d-md-block"><?
			$term = get_queried_object();
			the_field( 'сео-текст', $term ) ?></p>
    </div>
</main>

<?php get_footer(); ?>
