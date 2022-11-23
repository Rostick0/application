<? if ($status_payment && $status_delivery) : ?>
    <script defer>
        let count_created = 0;

        const productHtml = `
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <input class="validate" id="product_name_${count_created}" type="text" name="product_name[]">
                                <label for="product_name_${count_created}">Наименование</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_address_from_${count_created}" type="text" name="product_address_from[]">
                                <label for="product_address_from_${count_created}">Откуда</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_address_too_${count_created}" type="text" name="product_address_to[]">
                                <label for="product_address_too_${count_created}">Куда</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_count_${count_created}" type="number" name="product_count[]" step="0.001">
                                <label for="product_count_${count_created}">Количество*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_unit_measurement_${count_created}" type="text" name="product_unit_measurement[]">
                                <label for="product_unit_measurement_${count_created}">ед. из</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_price_${count_created}" type="number" name="product_price[]" step="0.001">
                                <label for="product_price_${count_created}">Цена</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_amount_${count_created}" type="number" name="product_amount[]" step="0.001">
                                <label for="product_amount_${count_created}">Сумма</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_purchase_price_${count_created}" type="number" name="product_purchase_price[]" step="0.001">
                                <label for="product_purchase_price_${count_created}">Цена закупа</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_purchase_amount_${count_created}" type="number" name="product_purchase_amount[]" step="0.001">
                                <label for="product_purchase_amount_${count_created}">Сумма закупа</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="product_status_delivery[]">
                                    <? foreach ($status_delivery as $value) : ?>
                                        <option value="<?= $value['status_delivery_id'] ?>"><?= $value['name'] ?></option>
                                    <? endforeach; ?>
                                </select>
                                <label>
                                    Статус доставка
                                </label>
                            </div>
                            <div class="input-field col s12">
                                <select name="product_status_payment[]">
                                    <? foreach ($status_payment as $value) : ?>
                                        <option value="<?= $value['status_payment_id'] ?>"><?= $value['name'] ?></option>
                                    <? endforeach; ?>
                                </select>
                                <label>
                                    Статус оплаты
                                </label>
                            </div>
                        </div>`;
    </script>
<? endif ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="/view/static/js/all.js" defer></script>