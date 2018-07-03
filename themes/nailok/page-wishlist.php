<?php
/* Template Name: Желания */
get_header(); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
	endwhile;
	else: ?>
        <p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
	<?php// woocommerce_content(); ?>
</main>
<?php get_footer(); ?>
