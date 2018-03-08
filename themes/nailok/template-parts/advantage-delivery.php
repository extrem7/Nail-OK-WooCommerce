<? $item = get_field( 'преимущество-доставка','option' ) ?>
<a href="<?= $item['ccылка'] ?>" class="advantage-item delivery">
    <div class="text">
        <div class="title"><?= $item['заголовок'] ?></div>
        <p><?= $item['текст'] ?></p>
    </div>
    <img src="<? path() ?>img/delivery-item.png" alt="">
</a>