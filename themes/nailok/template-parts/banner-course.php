<?
$banner = get_field( 'баннер-курс', 'option' );
if ( $banner ): ?>
    <a href="<? the_field( 'баннер-курс-ссылка', 'option' ) ?>" class="banner-long">
        <p class="title"><?= $banner ?></p>
        <img src="<? path() ?>img/banner-long-2.png" alt="">
    </a>
<? endif; ?>