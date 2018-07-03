<aside class="sidebar col-lg-4 col-xl-3 col-md-5">
	<?php get_search_form( true ); ?>
    <div class="menu-select">
        <a href="" class="group active">Группы</a>
        <i>/</i>
        <a href="" class="brand">Бренды</a>
    </div>
    <ul class="menu active">
		<?
		$menu       = wp_get_nav_menu_object( 5 );
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach ( $menu_items as $item ) {
			if ( $item->menu_item_parent == 0 ) {
				global $wp;
				$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
				$current = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$uri_parts[0]";
				$status  = '';
				if ( $current == $item->url ) {
					$status = 'active';
				}
				echo '<li class="' . $status . '">';
				if ( $status ) {
					echo '<i class="fas fa-arrow-right"></i> ';
				}
				echo '<a href="' . $item->url . '"  class="drop-open">';
				echo $item->title;
				echo '</a>';
				$sub_items = [];
				foreach ( $menu_items as $i ) {
					if ( $i->menu_item_parent == $item->ID ) {
						array_push( $sub_items, $i );
					}
				}
				if ( ! empty( $sub_items ) ) {

					echo ' <a data-toggle="dropdown"><i class="fas fa-plus"></i></a>
<ul class="dropdown-menu">';
					if ( ! empty( $sub_items ) ) {
						foreach ( $sub_items as $sub_item ) {
							echo '<li><a href="' . $sub_item->url . '">' . $sub_item->title . '</a>';
							$sub_sub_items = [];
							foreach ( $menu_items as $i_sub ) {
								if ( $i_sub->menu_item_parent == $sub_item->ID ) {
									array_push( $sub_sub_items, $i_sub );
								}
							}
							echo '<ul class="sub-menu">';
							foreach ( $sub_sub_items as $sub_sub_item ) {
								echo '<li><a href="' . $sub_sub_item->url . '">' . $sub_sub_item->title . '</a></li>';
							}
							echo '</ul>';
							echo '</li>';
						}
					}
					echo '</ul>';
				}
				echo '</li>';
			}
		} ?>
    </ul>
    <ul class="menu">
		<?
		$menu       = wp_get_nav_menu_object( 6 );
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach ( $menu_items as $item ) {
			if ( $item->menu_item_parent == 0 ) {
				global $wp;
				$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
                $current = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$uri_parts[0]";
				$status  = '';
				if ( $current == $item->url ) {
					$status = 'active';
				}
				echo '<li class="' . $status . '">';
				if ( $status ) {
					echo '<i class="fas fa-arrow-right"></i> ';
				}
				echo '<a href="' . $item->url . '"  class="drop-open">';
				echo $item->title;
				echo '</a>';
				$sub_items = [];
				foreach ( $menu_items as $i ) {
					if ( $i->menu_item_parent == $item->ID ) {
						array_push( $sub_items, $i );
					}
				}
				if ( ! empty( $sub_items ) ) {

					echo ' <a data-toggle="dropdown"><i class="fas fa-plus"></i></a>
<ul class="dropdown-menu">';
					if ( ! empty( $sub_items ) ) {
						foreach ( $sub_items as $sub_item ) {
							echo '<li><a href="' . $sub_item->url . '">' . $sub_item->title . '</a>';
							$sub_sub_items = [];
							foreach ( $menu_items as $i_sub ) {
								if ( $i_sub->menu_item_parent == $sub_item->ID ) {
									array_push( $sub_sub_items, $i_sub );
								}
							}
							echo '<ul class="sub-menu">';
							foreach ( $sub_sub_items as $sub_sub_item ) {
								echo '<li><a href="' . $sub_sub_item->url . '">' . $sub_sub_item->title . '</a></li>';
							}
							echo '</ul>';
							echo '</li>';
						}
					}
					echo '</ul>';
				}
				echo '</li>';
			}
		} ?>
    </ul>
	<? if ( ! is_front_page() ): ?>
        <div class="side-advantages">
            <? get_template_part( 'template-parts/advantage-delivery-min' ); ?>
	        <? get_template_part( 'template-parts/advantage-service-min' ); ?>
            <? get_template_part( 'template-parts/advantage-study-min' ); ?>
        </div>
	<? endif; ?>
</aside>