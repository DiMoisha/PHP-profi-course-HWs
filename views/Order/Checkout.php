<?php
    function CheckoutView() {
        return '<div class="row">
                    <div class="col-md-12">
                        <section id="checkoutForm">
                            <form id="checkoutForm" action="/server/orders.php" method="post" class="form-horizontal" role="form" enctype = "multipart/form-data">
                                <input type="hidden" id="Action" name="Action" value="checkout">
                                <input type="hidden" id="ReturnUrl" name="ReturnUrl" value="/cart">
                                <h2>Доставка</h2>
                                <p>&nbsp;&nbsp;&nbsp;Стоимость доставки рассчитывается отдельно в зависимости от расстояния до объекта и выбранных товаров. После оформления заказа наш менеджер свяжется с вами по телефону или e-mail для согласования точной стоимости доставки.</p>
                                <p>Если вы самостоятельно заберете свой заказ, то поставьте галочку "Самовывоз" и поле "Полный адрес доставки" оставьте пустым.</p>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="IsNotDelivery">Самовывоз</label>
                                    <div class="col-md-9">
                                        <input class="form-control checkbox" id="IsNotDelivery" name="IsNotDelivery" type="checkbox" value="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="DeliveryAdress">Полный адрес доставки</label>
                                    <div class="col-md-9">
                                        <textarea class = "form-control multi-line" rows = "3" name="DeliveryAdress" id="DeliveryAdress"></textarea>
                                    </div>
                                    <p>&nbsp;</p>
                                    <label class="col-md-3 control-label" for="ordermap">Кликните по карте, чтобы выбрать адрес</label>
                                    <div id="ordermap" class="col-md-9" style="height: 400px;"></div>
                                </div>
                                <hr />
                                <h2>Информация о покупателе</h2>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="CustName">Ваше ФИО или наименование организации</label>
                                    <div class="col-md-9">
                                        <textarea class = "form-control multi-line" rows = "3" name="CustName" id="CustName" required></textarea>
                                        <p class="help-block">* полное наименование организации, ИП или ФИО частного лица</p>
                                    </div>
                                </div>
                                <h3>Контактные данные</h3>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="CustTel">Ваш телефон</label>
                                    <div class="col-md-9">
                                        <input type="tel" name="CustTel" class="form-control" id="CustTel" pattern="+7-[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                        required placeholder="+7-000-000-0000">
                                        <p class="help-block">* в формате +7-XXX-XXX-XXXXX</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="ContactPerson">Контактное лицо</label>
                                    <div class="col-md-9">
                                        <input type="text" name="ContactPerson" class="form-control" id="ContactPerson" placeholder="Контактное лицо">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="CustEmail">Ваш e-mail</label>
                                    <div class="col-md-9">
                                        <input type="email" name="CustEmail" class="form-control" id="CustEmail" placeholder="Ваш email" required>
                                    </div>
                                </div>
                                <hr />
                                <h2>Способ оплаты</h2>
                                <p>Если вы хотите оплатить заказ через интернет on-line, поставьте галочку "ON-LINE оплата".<br />
                                   Если вас интересует другой способ оплаты - оставьте поле "ON-LINE оплата" пустым, тогда способ оплаты вы согласуете с нашим менеджером.</p>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="IsOnLinePay">ON-LINE оплата</label>
                                    <div class="col-md-9">
                                        <input class="form-control checkbox" id="IsOnLinePay" name="IsOnLinePay" type="checkbox" value="true">
                                    </div>
                                </div>
                                <hr />
                                <h2>Дополнительная информация</h2>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="OrderNote">Примечение к заказу</label>
                                    <div class="col-md-9">
                                        <textarea class = "form-control multi-line" rows = "3" name="OrderNote" id="OrderNote"></textarea>
                                        <p class="help-block">* тут вы можете указать удобное для вас время доставки продукции и другие ваши пожелания</p>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <p align="center">
                                    <input class="actionButtons btn btn-xs-sm-md btn-success" type="submit" value="Подтвердить заказ" />
                                </p>
                            </form>
                        </section>
                    </div>
                </div>
                <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=72a328b5-a13a-4088-9448-e445f94d6357" type="text/javascript"></script>
                <script src="/js/event_reverse_geocode.js" type="text/javascript"></script>';
    }