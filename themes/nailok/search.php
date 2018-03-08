<?php
get_header(); ?>
<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
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
</main>
<?php get_footer(); ?>
