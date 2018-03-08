<?
$banner = get_field( 'баннер-сертификат', 'option' );
if ( $banner ): ?>
    <a href="<? the_field( 'баннер-сертификат-ссылка', 'option' ) ?>" class="banner-long">
        <p class="title"><?= $banner ?></p>
        <img src="<? path() ?>img/banner-long-1.png" alt="">
    </a>
<? endif; ?>