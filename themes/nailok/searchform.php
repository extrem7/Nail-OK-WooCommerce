<form role="search" method="get" class="search-form search" action="<?php echo home_url( '/' ); ?>">
    <div class="input">
        <input type="search" placeholder="Текст запроса" value="<?php echo get_search_query() ?>" name="s"
               title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>">
        <button type="submit"><i class="fas fa-search"></i></button>
    </div>
</form>