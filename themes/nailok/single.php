<?php
get_header(); ?>

<?php get_sidebar() ?>
<?
global $post;
$postcat = get_the_category( $post->ID );
if ( $postcat[0]->term_id == 21 ): ?>
    <main class="content col-lg-8 col-xl-9">
        <div class="before-content">
            <div class="woocommerce-breadcrumb">
				<?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
					dimox_breadcrumbs();
				} ?>
            </div>
        </div>
        <h1 class="title-big"><? the_title() ?></h1>
        <? the_field('контент',false,true) ?>
    </main>
<? endif; ?>
<?php get_footer(); ?>