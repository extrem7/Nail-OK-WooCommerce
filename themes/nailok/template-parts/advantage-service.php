<? $item = get_field( 'преимущество-сервис','option' ) ?>
<a href="<?= $item['ccылка'] ?>" class="advantage-item service">
    <div class="text">
        <div class="title"><?= $item['заголовок'] ?></div>
        <p><?= $item['текст'] ?></p>
    </div>
    <img src="<? path() ?>img/service-item.png" alt="">
</a>