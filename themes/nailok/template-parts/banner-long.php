<?
global $banner;
if ( $banner ): ?>
	<? if ( in_array('min', $banner) ): ?>
        <a href="<?= $banner['url'] ?>" class="advantage-item service-second min">
            <div class="text">
                <div class="title"><?= $banner['title'] ?></div>
                <p><?= $banner['text'] ?></p>
            </div>
            <img src="<?= $banner['img'] ?>" alt="">
        </a>
	<? else: ?>
        <a href="<?= $banner['url'] ?>" class="banner-long">
            <p class="title"><?= $banner['text'] ?></p>
            <img src="<?= $banner['img'] ?>" alt="">
        </a>
	<? endif;
endif; ?>