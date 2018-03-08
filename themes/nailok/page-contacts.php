<?php
/* Template Name: Контакты */
get_header(); ?>

<?php get_sidebar() ?>
<main class="content col-lg-8 col-xl-9">
    <div class="before-content">
		<?php woocommerce_breadcrumb(); ?>
    </div>
    <h1 class="title-big"><? the_title() ?></h1>
    <div class="row">
        <ul class="list col-sm-6 col-xl-5">
			<?
			$status = true;
			$li     = 0;
			while ( have_rows( 'точки-продаж' ) ) :
				the_row() ?>
                <li class="nav-item">
                    <a href="#tab-<?= $li ?>" class="btn-pink light <?= $status ? 'active' : '' ?>" data-toggle="tab">
                        <span><? the_sub_field( 'название' ) ?></span><i class="fas fa-shopping-cart"></i>
						<? if ( get_sub_field( 'учебный-центр' ) ): ?>
                            <i class="fas fa-graduation-cap"></i>
						<? endif ?>
                    </a>
                </li>
				<?
				$status = false;
				$li ++;
			endwhile; ?>
            <li>
                <p>
                    <i class="fas fa-shopping-cart"></i> - точка продаж
                    <br>
                    <i class="fas fa-graduation-cap"></i> - учебный центр
                </p>
            </li>
        </ul>
        <div class="tab-content col-sm-6 col-xl-7">
			<?
			$status = true;
			$li     = 0;
			while ( have_rows( 'точки-продаж' ) ) :
				the_row() ?>
                <div id="tab-<?= $li ?>" class="item tab-pane <?= $status ? 'active' : '' ?>">
					<? the_sub_field( 'контент' ) ?>
                </div>
				<?
				$status = false;
				$li ++;
			endwhile; ?>
            <div class="social d-flex">
				<? if ( get_field( 'хедер-вк', 'option' ) ): ?>
                    <a href="<? the_field( 'хедер-вк', 'option' ) ?>" class="btn-pink round"><i
                                class="fab fa-vk"></i></a>
				<? endif; ?>
				<? if ( get_field( 'хедер-инстаграм', 'option' ) ): ?>
                    <a href="<? the_field( 'хедер-инстаграм', 'option' ) ?>" class="btn-pink round"><i
                                class="fab fa-instagram"></i></a>
				<? endif; ?>
            </div>
        </div>
    </div>
    <div class="banner-address">
        <div class="info">
            <p><? the_field( 'карта-адрес' ) ?></p>
        </div>
		<? the_field( 'карта' ) ?>
    </div>
</main>
<?php get_footer(); ?>
