<? $item = get_field( 'преимущество-учёба','option' ) ?>
<a href="<?= $item['ccылка'] ?>" class="advantage-item study min">
    <div class="text">
        <div class="title"><?= $item['заголовок'] ?></div>
        <p><?= $item['текст'] ?></p>
    </div>
    <img src="<? path() ?>img/study-item.png" alt="">
</a>