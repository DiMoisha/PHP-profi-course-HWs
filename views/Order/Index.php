<?php
    function IndexView($orders) {
        $view = '<p class="text-center bg-warning"><b>Заказов нет!</b></p>';

        if (count($orders) > 0) {
            $view = '<div><a href="#" id="ref_list-btn" title="Обновить список заказов" class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Обновить</a></div>
                    <script>
                        $(function(){
                            $("#ref_list-btn").click(function (){
                                $.ajax({
                                    url: "/orders",
                                    cache: false
                                    })
                                        .done(function( html ) {
                                        $( "body" ).html( html );
                                        });
                        
                                return false;
                            });
                        });
                    </script>        
                    <hr class="bhr">
                    <div class="table-responsive product-table-wrapper">
                        <table class="table table-bordered table-hover product-table table-grey-header">
                            <thead>
                                <tr class="bg-f3">
                                    <th>№ заказа</th>
                                    <th>Размещен</th>
                                    <th>Статус</th>
                                    <th>Покупатель</th>
                                    <th>Телефоны</th>
                                    <th>Контактное лицо</th>
                                    <th>E-mail</th>
                                    <th>Доставка</th>
                                    <th>Oплата</th>
                                </tr>
                            </thead>
                            <tbody>';
                           
            foreach($orders as $order) {
                $view .= '<tr class="dark-border-top">
                            <td><b class="text-center cl-red"><h3>'.$order -> orderId.'</h3></b></td>
                            <td>'.$order -> insDate.'</td>
                            <td'.($order -> orderStatusId == 5 ? ' class="cl-red">'.$order -> status : 
                            $_COOKIE['loginlogin'] && $_COOKIE['loginuserid'] && $_COOKIE['loginuser'] && $_COOKIE['loginemail'] && $_COOKIE['loginroleid'] 
                                && $_COOKIE['loginrole'] && intval($_COOKIE['loginroleid'])==1 ? 
                                '><select name="Status'.$order -> orderId.'" id="Status'.$order -> orderId.'" onchange="setStatus('.$order -> orderId.', this.value);">
                                    <option '.($order -> orderStatusId == 2 ? ' selected ' : '').'value ="2">Заказ отправлен в обработку</option>
                                    <option '.($order -> orderStatusId == 3 ? ' selected ' : '').'value ="3">Заказ исполняется</option>
                                    <option '.($order -> orderStatusId == 4 ? ' selected ' : '').'value ="4">Заказ выполнен</option>
                                </select> 
                                <script>
                                    function setStatus(orderId, statusId){
                                        $.ajax({
                                            url: "/setorder?orderid="+orderId.toString()+"&status="+statusId.toString(),
                                            cache: false
                                            })
                                                .done(function( html ) {
                                                $( "body" ).html( html );
                                                });
                                
                                        return false;
                                    };
                                </script>' : '>'.$order -> status
                            ).'</td>
                            <td>'.$order -> custName.'</td>
                            <td>'.$order -> custTel.'</td>
                            <td>'.$order -> contactPerson.'</td>
                            <td>'.$order -> custEmail.'</td>
                            <td>';

                if ($order -> isDelivery == 1) {
                    $view .= 'Доставка: '.$order -> deliveryAdress;
                } else {
                    $view .= '<b>Самовывоз</b>';
                }

                $view .= '</td><td>';

                if ($order -> isOnlinePay == 1) {
                    $view .= '<b>Оплата on-line</b><br />
                            <a href="/CreatePaymentOrder?.....payment params......"
                            title="Оплата заказа через Яндекс Кассу" class="btn btn-xs-sm-md btn-default" role="button">
                                <span class="glyphicon glyphicon-rub"></span>
                            </a>';
                } else {
                    $view .= 'Оплата наличными или картой';
                }

                $view .= '</td></tr>';

                if (count($order -> orderDetails) > 0) {
                    $view .= '<tr>
                                <td colspan="9" class="null-padding null-margin">
                                    <table class="table table-hover table-grey-header">
                                        <thead>
                                            <tr>
                                                <th>Товар</th>
                                                <th>Количество</th>
                                                <th>Ед. изм.</th>
                                                <th>Цена, руб.</th>
                                                <th>Сумма, руб.</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                    foreach($order -> orderDetails as $detail) {
                        $view .= '<tr>
                                    <td>'.$detail -> productName.'</td>
                                    <td>'.$detail -> quantity.'</td>
                                    <td>'.$detail -> unit.'</td>
                                    <td>'.$detail -> price.'</td>
                                    <td>'.$detail -> sm.'</td>
                                </tr>';
                    }

                    $view .= ' </tbody></table></td></tr>';
                }

                if ($order -> isDelivery == 1) {
                    $view .= '<tr><td colspan="9" class="text-right">Стоимость доставки: ';
                    if($_COOKIE['loginlogin'] && $_COOKIE['loginuserid'] && $_COOKIE['loginuser'] && $_COOKIE['loginemail'] && $_COOKIE['loginroleid'] 
                        && $_COOKIE['loginrole'] && intval($_COOKIE['loginroleid'])==1) {
                        $view .= '<input type="number" placeholder="1.0" step="0.01" min="0" max="99999999999.99" id="DeliverySum'.$order -> orderId.'" 
                                    value="'.$order -> deliverySum.'" pattern="\d+(.\d{0,3})?" required="required" size="12" />
                                    <a class="actionButtons btn btn-xs-sm btn-refresh" id="btn-DeliverySum'.$order -> orderId.'" title="Обновить стоимость доставки">&#8634;</a>
                                    <script>
                                            $(function(){
                                                $("#btn-DeliverySum'.$order -> orderId.'").click(function (){
                                                    let sm = $("#DeliverySum'.$order -> orderId.'").val();
                                                    $.ajax({
                                                        url: "/setorder?orderid='.$order -> orderId.'&deliverysum="+sm.toString(),
                                                        cache: false
                                                        })
                                                            .done(function( html ) {
                                                            $( "body" ).html( html );
                                                            });
                                            
                                                    return false;
                                                });
                                            });
                                    </script>';
                    } else {
                        $view .= $order -> deliverySum.' руб.';
                    }
                    $view .= '</td></tr>';
                    $view .= '<tr><td colspan="9" class="text-right">Стоимость товаров: '.$order -> orderSum.' руб.</td></tr>';
                } 

                $view .= '<tr>
                            <td>
                                <a href="#" id="cancel-btn-'.$order -> orderId.'" title="Отменить заказ" class="btn btn-default btn-danger"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Отменить заказ</a>
                                    <script>
                                        $(function(){
                                            $("#cancel-btn-'.$order -> orderId.'").click(function (){
                                                $.ajax({
                                                    url: "/cancelorder/?orderid='.$order -> orderId.'",
                                                    cache: false
                                                    })
                                                        .done(function( html ) {
                                                        $( "body" ).html( html );
                                                        });
                                        
                                                return false;
                                            });
                                        });
                                    </script>
                            </td>
                            <td colspan="9" class="text-right"><b>Сумма заказа: '.($order -> orderSum + $order -> deliverySum).' руб.</b></td>
                        </tr>';
                
                if (!empty($order -> orderNote)) {
                    $view .= '<tr><td colspan="9" class="text-right"><h6>Примечание к заказу</h6><p>'.$order -> orderNote.'</p></td></tr>';
                }

                $view .= '<tr class="bg-f3"><td colspan="9">&nbsp;</td></tr>';
            }
           
            $view .= '</tbody></table></div>';
        }       

        return $view;
    }