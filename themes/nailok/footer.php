</div>
</div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row flex-nowrap flex-md-wrap">
            <div class="col-xl-3 col-lg-2 d-block d-md-none d-lg-block">
                <a href="" class="logo d-none d-md-block"><img <? the_image( 'футер-лого', 'option' ) ?>></a>
                <div class="social d-flex">
					<? if ( get_field( 'хедер-вк', 'option' ) ): ?>
                        <a href="<? the_field( 'хедер-вк', 'option' ) ?>"><i class="fab fa-vk"></i></a>
					<? endif; ?>
					<? if ( get_field( 'хедер-инстаграм', 'option' ) ): ?>
                        <a href="<? the_field( 'хедер-инстаграм', 'option' ) ?>"><i class="fab fa-instagram"></i></a>
					<? endif; ?>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3">
				<?php wp_nav_menu( array(
					'menu'       => 'Футер',
					'container'  => null,
					'items_wrap' => '<ul  class="menu">%3$s</ul>',
					'walker'     => new Bootstrap_Walker_Nav_Menu,
				) ); ?>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-flex align-items-center flex-column">
                <div class="wrap">
                    <p class="title"><i class="fas fa-phone"></i>Телефоны:</p>
                    <ul class="phones">
						<?
						while ( have_rows( 'футер-телефоны', 'option' ) ) : the_row() ?>
                            <li><span><? the_sub_field( 'место' ) ?> </span><a
                                        href="tel:<?= preg_replace( '/[^0-9]/', '', get_sub_field( 'телефон' ) ); ?>"><? the_sub_field( 'телефон' ) ?></a>
                            </li>
						<? endwhile; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-5 d-none d-md-flex align-items-center flex-column">
                <div class="wrap">
                    <p class="title"><i class="fas fa-map-marker-alt"></i>Точки продаж:</p>
                    <p class="location"><? the_field( 'футер-точки', 'option' ) ?></p>
                </div>
            </div>
        </div>
        <div class="bottom d-flex flex-column flex-md-row justify-content-center"><? the_field( 'футер-копирайт', 'option' ) ?></div>
    </div>
</footer>
<a href="" class="scroll-up"><i class="fa fa-angle-double-up"></i></a>
<? if ( get_post_type() == 'school' || get_page_template_slug() == 'page-school.php' ): ?>
    <div class="modal fade thanks-modal" id="thanks">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">Закрыть <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <p class="title"><? the_field( 'благодарность-заголовок', 160 ) ?></p>
                    <p class="text"><? the_field( 'благодарность-текст', 160 ) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade course-modal" id="course">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">Закрыть <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <p class="title"><? the_field( 'попап-заголовок', 160 ) ?></p>
                    <p class="text"><? the_field( 'попап-текст', 160 ) ?></p>
					<?= do_shortcode( '[contact-form-7 id="187" title="Курс"]' ) ?>
                </div>
            </div>
        </div>
    </div>
<? endif; ?>
<div class="modal fade thanks-modal" id="thanks-product">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">Закрыть <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <p class="title">Товар успешно добавлен в корзину</p>
            </div>
        </div>
    </div>
</div>
<? wp_footer() ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js" defer></script>
<? if ( is_front_page() ): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
<? endif; ?>
</body>
</html>