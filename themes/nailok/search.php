<?php
get_header(); ?>
<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
	<? wc_print_notices(); ?>
    <form role="search" method="get" class="search-form search" action="<?php echo home_url( '/' ); ?>">
        <div class="input">
            <input type="search" placeholder="Что вы хотите найти?" value="<?php echo get_search_query() ?>" name="s">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <section class="products">
        <p class="paragraph"><?= woocommerce_page_title() ?><p>
        <div class="d-flex flex-wrap">
			<?
            pre(get_queried_object());
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					if ( get_post_type() != 'product' ) {
						continue;
					}
					$_product = wc_get_product( $post->ID ); ?>
                    <div class="col-xl-4 col-sm-6">
						<? require get_template_directory() . '/template-parts/product-card.php' ?>
                    </div>
				<? endwhile;
			else :?>
                <p>Товары не найдены<br><br><a href="/shop" class="btn-pink">Назад</a></p>
			<? endif;
			wp_reset_postdata(); ?>
        </div>
    </section>
</main>
<!--<main class="content col-lg-8 col-xl-9">
    <form role="search" method="get" class="search-form search" action="<?php echo home_url( '/' ); ?>">
        <div class="input">
            <input type="search" placeholder="Что вы хотите найти?" value="<?php echo get_search_query() ?>" name="s">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
	<?php while ( have_posts() ) : the_post(); ?>
        <div class="search-item">
            <a href="<? the_permalink() ?>" class="title-big"><? the_title() ?></a>
			<? the_content() ?>
        </div>
	<?php endwhile; ?>
</main>-->
<?php get_footer(); ?>
