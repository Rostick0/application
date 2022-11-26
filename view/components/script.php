<? if ($status_payment && $status_delivery) : ?>
    <script defer>
        let countCreated = 0;

        function renderProductHtml(countCreated) {
            return `
                        <div class="project__flex project__product _${countCreated}">
                            <div class="input-field col s12">
                                <input class="validate" id="product_name_${countCreated}" type="text" name="product_name[]">
                                <label for="product_name_${countCreated}">Наименование</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_track_number_${countCreated}" type="number" name="product_track_number[]">
                                <label for="product_track_number_${countCreated}">Трек номер</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_warehouse_${countCreated}" type="text" name="product_warehouse[]">
                                <label for="product_warehouse_${countCreated}">Склад</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_address_from_${countCreated}" type="text" name="product_address_from[]">
                                <label for="product_address_from_${countCreated}">Откуда</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_address_too_${countCreated}" type="text" name="product_address_to[]">
                                <label for="product_address_too_${countCreated}">Куда</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_count_${countCreated}" type="number" name="product_count[]" step="0.001">
                                <label for="product_count_${countCreated}">Количество*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_unit_measurement_${countCreated}" type="text" name="product_unit_measurement[]">
                                <label for="product_unit_measurement_${countCreated}">ед. из</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_price_${countCreated}" type="number" name="product_price[]" step="0.001">
                                <label for="product_price_${countCreated}">Цена</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_amount_${countCreated}" type="number" name="product_amount[]" step="0.001">
                                <label for="product_amount_${countCreated}">Сумма</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_purchase_price_${countCreated}" type="number" name="product_purchase_price[]" step="0.001">
                                <label for="product_purchase_price_${countCreated}">Цена закупа</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_purchase_amount_${countCreated}" type="number" name="product_purchase_amount[]" step="0.001">
                                <label for="product_purchase_amount_${countCreated}">Сумма закупа</label>
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
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input type="file" name="product_document[]">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_link_${countCreated}" type="text" name="product_link[]">
                                <label for="product_link_${countCreated}">Ссылка на товар</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_shipping_cost_${countCreated}" type="number" name="product_shipping_cost[]" step="0.001">
                                <label for="product_shipping_cost_${countCreated}">Стоимость доставки</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="product_status_exploitation[]">
                                    <? foreach ($status_exploitation as $value) : ?>
                                        <option value="<?= $value['status_exploitation_id'] ?>"><?= $value['name'] ?></option>
                                    <? endforeach; ?>
                                </select>
                                <label>
                                    Статус эксплуатации
                                </label>
                            </div>
                        </div>`;
        }
    </script>
<? endif ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="/view/static/js/all.js" defer></script>