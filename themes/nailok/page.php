<?php
get_header(); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
    <div class="before-content">
		<?php woocommerce_breadcrumb(); ?>
    </div>
    <h1 class="title-big"><? the_title() ?></h1>
    <div class="formated-text">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
			echo apply_filters( 'the_content', wpautop(get_the_content(null,true),true ));
		endwhile;endif; ?>
		<?// apply_filters( 'the_content', get_post_field( 'post_content', $id ) ); ?>
    </div>
	<? if ( get_field( 'Сео-контент' ) ): ?>
        <div class="paragraph seo-content d-none d-md-block">
            <hr class="d-none d-md-block">
			<? the_field( 'Сео-контент' ) ?>
        </div>
	<? endif; ?>
</main>
<?php get_footer(); ?>
