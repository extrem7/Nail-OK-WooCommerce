<? foreach ( $collections as $item ):
	$item = get_term( $item );
	if ( ! get_field( 'это-коллекция', $item ) ) {
		continue;
	}
	$thumbnail_id = get_term_meta( $item->term_id, 'thumbnail_id', true );
	$image        = wp_prepare_attachment_for_js( $thumbnail_id );
	$link = get_field( 'ccылка-коллекции', $item );
	?>
	<a href="<?= $link?$link:get_category_link( $item->term_id ); ?>" class="col-xl-4 col-sm-6">
		<div class="collection-card">
			<? if ( get_field( 'акция', $item ) ): ?>
				<div class="sale">Акция</div>
			<? endif; ?>
			<div class="photo">
				<img src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>">
			</div>
			<p class="title"><?= $item->name ?></p>
			<div class="hover">
				<p class="title"><?= $item->name ?></p>
				<div class="add-to-cart btn-pink">Подробнее</div>
			</div>
		</div>
	</a>
<? endforeach; ?>