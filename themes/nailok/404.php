<?php get_header(); ?>
<?php get_sidebar() ?>
    <main class="content col-lg-8 col-xl-9">
        <p class="error-text">
            К сожалению, такой страницы
            на сайте пока нет, попробуйте
            <a href="/">вернутся на главную</a> или
            воспользуйтесь поиском
        </p>
        <form role="search" method="get" class="search-form search" action="<?php echo home_url( '/' ); ?>">
            <div class="input">
                <input type="search" placeholder="Что вы хотите найти?" value="<?php echo get_search_query() ?>" name="s">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </main>
<?php get_footer(); ?>