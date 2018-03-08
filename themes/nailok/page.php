<?php
/* Template Name: Контакты */
get_header(); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
    <div class="before-content">
        <?php woocommerce_breadcrumb(); ?>
    </div>
    <h1 class="title-big"><? the_title() ?></h1>
    <?= apply_filters('the_content', get_post_field('post_content', $id)); ?>
</main>
<?php get_footer(); ?>
