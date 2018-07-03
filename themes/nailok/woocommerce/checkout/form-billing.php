<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <div class="row justify-content-between">
        <div class="col-md-6">
            <p class="title-big">Адрес доставки</p>
            <input type="text" class="input-text input" name="billing_city" id="billing_city" placeholder="Город"
                   value="<? //= $checkout->get_value( 'billing_city' ) ?>"
                   autocomplete="<?= $fields['billing_city']['autocomplete'] ?>" maxlength="32">
            <input type="text" class="input-text input" name="billing_address_1" id="billing_address_1"
                   placeholder="Улица"
                   value="<? //= $checkout->get_value( 'billing_address_1' ) ?>"
                   autocomplete="<?= $fields['billing_address_1']['autocomplete'] ?>" maxlength="32">

            <div class="address-details">
                <input type="text" class="input-text input" name="billing_address_2" id="billing_address_2"
                       placeholder="Дом"
                       value="<? //= $checkout->get_value( 'billing_address_2' ) ?>"
                       autocomplete="<?= $fields['billing_address_2']['autocomplete'] ?>" maxlength="4">
                <input type="text" class="input-text input" name="billing_postcode" id="billing_postcode"
                       placeholder="Корпус"
                       value="<? //= $checkout->get_value( 'billing_postcode' ) ?>"
                       autocomplete="<?= $fields['billing_postcode']['autocomplete'] ?>" maxlength="4">
                <input type="text" class="input-text input" name="billing_state" id="billing_state"
                       placeholder="Квартира"
                       value="<? //= $checkout->get_value( 'billing_state' ) ?>"
                       autocomplete="<?= $fields['billing_state']['autocomplete'] ?>" maxlength="4">
            </div>
        </div>
        <div class="col-md-6">
            <p class="title-big">Контактные данные</p>
            <input type="text" class="input-text input" name="billing_first_name" id="billing_first_name"
                   placeholder="Имя"
                   value="<? //= $checkout->get_value( 'billing_first_name' ) ?>"
                   autocomplete="<?= $fields['billing_first_name']['autocomplete'] ?>" maxlength="32">
            <input type="text" class="input-text input" name="billing_phone" id="billing_phone" placeholder="Телефон"
                   value="<? //= $checkout->get_value( 'billing_phone' ) ?>"
                   autocomplete="<?= $fields['billing_phone']['autocomplete'] ?>">
            <input type="email" class="input" class="input-text " name="billing_email" id="billing_email"
                   placeholder="Email"
                   value=""
                   autocomplete="<?= $fields['billing_email']['autocomplete'] ?>" maxlength="32">
            <input type="text" name="order_comments" id="order_comments" placeholder="Комментарий" class="input"
                   maxlength="32">
        </div>
        <select name="billing_country" id="billing_country"
                class="country_to_state country_select select2-hidden-accessible d-none" autocomplete="country"
                tabindex="-1"
                aria-hidden="true">
            <option value="RU" selected="selected">Россия</option>
        </select>
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		foreach ( $fields as $key => $field ) {
			if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
				$field['country'] = $checkout->get_value( $field['country_field'] );
			}
			if ( $key != 'billing_city' && $key != 'billing_address_1' && $key != 'billing_country' && $key != 'politics' && $key != 'billing_email'
			     && $key != 'billing_first_name' && $key != 'billing_phone' && $key != 'billing_phone' && $key != 'order_comments'
			     && $key != 'billing_address_2' && $key != 'billing_postcode' && $key != 'billing_state' && $key != 'billing_company' ) {
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
		}
		?>
        <div class="checkbox">
            <input type="checkbox" id="delivery"><label for="delivery"><i
                        class="fas fa-check"></i></label>
            <p>Мне не нужна доставка, заберу из точки продаж на
                <select name="billing_company" id="billing_company" disabled
                        autocomplete="<?= $fields['billing_company']['autocomplete'] ?>">
					<?
					$status = true;
					while ( have_rows( 'точки-выдачи' ) ) :
						the_row() ?>
                        <option value="<? the_sub_field( 'название' ) ?>"><? the_sub_field( 'название' ) ?></option>
						<?
						$status = false;
					endwhile; ?>
                </select></p>
        </div>
        <div class="checkbox">
            <input type="checkbox" class="input-checkbox " name="politics" id="politics" value="1">
            <label for="politics"><i class="fas fa-check"></i></label>
            <p>С <a href="<? the_field( 'политика-файл', 'option' ) ?>" target="_blank">политикой конфиденциальности</a>
                согласен</p>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="g-recaptcha" data-sitekey="6LcFo1MUAAAAAOTq2cH-9Nn4q2Kp3bYhDR78HBUx"></div>
    </div>

<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>