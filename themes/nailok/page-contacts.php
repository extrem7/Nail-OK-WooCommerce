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
                    <div class="social d-flex">
						<? if ( get_field( 'хедер-вк', 'option' ) ): ?>
                            <a title="Группа вконтакте магазина Ноготок" href="<? the_field( 'хедер-вк', 'option' ) ?>"
                               target="_blank" class="btn-pink round"><i class="fab fa-vk"></i></a>
						<? endif; ?>
						<? if ( $li == 0 ): ?>
                            <a title="Группа вконтакте учебного центра Ноготок" href="https://vk.com/schoolnogotok"
                               target="_blank" class="btn-pink round"><i class="fab fa-vk"></i></a>
						<? endif; ?>
						<? if ( get_field( 'хедер-инстаграм', 'option' ) ): ?>
                            <a title="Instagram Ноготок" href="<? the_field( 'хедер-инстаграм', 'option' ) ?>"
                               target="_blank" class="btn-pink round"><i class="fab fa-instagram"></i></a>
						<? endif; ?>
                    </div>
                    <div class="map d-none"><? the_sub_field( 'карта' ) ?></div>
                    <p class="map-title d-none"><? the_sub_field( 'карта-заголовок' ) ?></p>
                </div>
				<?
				$status = false;
				$li ++;
			endwhile; ?>
        </div>
    </div>
    <div class="banner-address">
		<?
		$map = get_field( 'точки-продаж' )[0];
		?>
        <div class="info">
            <p><?= $map['карта-заголовок'] ?></p>
        </div>
        <iframe src="<?= $map['карта'] ?>" class="map" style="border:0" allowfullscreen></iframe>
    </div>
	<? if ( get_field( 'Сео-контент' ) ): ?>
        <div class="paragraph seo-content d-none d-md-block">
            <hr class="d-none d-md-block">
			<? the_field( 'Сео-контент' ) ?>
        </div>
	<? endif; ?>
</main>
<?php get_footer(); ?>
