<?php
namespace App\Controllers;

use App\Controllers\Base as cBase;
use App\Models\Order as mOrder;
use App\Models as models;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class OrderController extends cBase\Controller
{
    public $pageTitle;
    public $metaDescription;
    public $metaKeywords;
    public $pageCanonical;
    public $menuItem;
    public $pageHeading;
    public $view = 'Order';

    function __construct()
    {
        parent :: __construct();
    }

    /**
     * Возвращает список заказов.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Index($data)
    {
        $this->pageTitle       .= ' | Журнал заказов';
        $this->metaDescription  = 'Журнал заказов. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
        $this->metaKeywords     = 'Журнал заказов, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
        $this->pageCanonical    = 'https://lagoc.ru/orders';
        $this->menuItem         = 'orders';
        $this->pageHeading      = 'Журнал заказов';

        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $orders = [
                    'orders'  => mOrder\Order :: getOrders((int)$_COOKIE['authuserid'], (int)$_COOKIE['authroleid']),
                    'details' => mOrder\OrderDetail :: getAllDetails((int)$_COOKIE['authuserid'])
                ];

            return $orders ?? '<p class="text-warning">У вас пока нет заказов!</p><hr class="bhr" /><br />';
        }
        else {
            header("Location: /login");
        }
    }

    /**
     * Создает заказ.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Checkout($data)
    {
        $this->pageTitle       .= ' | Оформление заказа';
        $this->metaDescription  = 'Оформление заказа. Предварительный заказ, даставка. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
        $this->metaKeywords     = 'Оформление заказа, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
        $this->pageCanonical    = 'https://lagoc.ru/checkout';
        $this->menuItem         = 'checkout';
        $this->pageHeading      = 'Оформление заказа';

        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            if ($this -> isPost()) {
                $userId             = (int)$_COOKIE['authuserid'];
                $customerName       = isset($_POST['customername']) ? filter_var(trim($_POST['customername']), FILTER_SANITIZE_STRING) : false;
                $customerTel        = isset($_POST['customertel']) ? filter_var(trim($_POST['customertel']), FILTER_SANITIZE_STRING) : null;
                $customerEmail      = isset($_POST['customeremail']) ? filter_var(trim($_POST['customeremail']), FILTER_SANITIZE_STRING) : null;
                $contactPerson      = isset($_POST['contactperson']) ? filter_var(trim($_POST['contactperson']), FILTER_SANITIZE_STRING) : null;
                $isDelivery         = isset($_POST['isdelivery']) ? filter_var(trim($_POST['isdelivery']), FILTER_SANITIZE_STRING) : '';
                $isDelivery         = $isDelivery == "on" || $isDelivery == "true" ? 0 : 1;
                $deliveryAddress    = isset($_POST['deliveryaddress']) ? filter_var(trim($_POST['deliveryaddress']), FILTER_SANITIZE_STRING) : null;
                $isOnlinepay        = isset($_POST['isonlinepay']) ? filter_var(trim($_POST['isonlinepay']), FILTER_SANITIZE_STRING) : '';
                $isOnlinepay        = $isOnlinepay == "on" || $isOnlinepay == "true" ? 1 : 0;
                $orderNote          = isset($_POST['ordernote']) ? filter_var(trim($_POST['ordernote']), FILTER_SANITIZE_STRING) : null;

                if (mb_strlen($customerName) < 3 || mb_strlen($customerName) > 250) {
                    return '<p class="text-danger">Недопустимая длина наименования покупателя! Длина должна быть от 3 до 250 символов!</p><hr class="bhr" /><br />';
                }

                if (mb_strlen($customerTel) > 250) {
                    return '<p class="text-danger">Недопустимая длина телефонов! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                }

                if (mb_strlen($customerEmail) < 3 || mb_strlen($customerEmail) > 250) {
                    return '<p class="text-danger">Недопустимая длина email! Длина должна быть от 3 до 250 символов!</p><hr class="bhr" /><br />';
                }

                if (mb_strlen($contactPerson) > 250) {
                    return '<p class="text-danger">Недопустимая длина контактного лица! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                }

                $orderId = mOrder\Order :: createOrder(
                            [
                                'userid'            => $userId,
                                'customername'      => $customerName,
                                'customertel'       => $customerTel,
                                'customeremail'     => $customerEmail,
                                'contactperson'     => $contactPerson,
                                'isdelivery'        => $isDelivery,
                                'deliveryaddress'   => $deliveryAddress,
                                'isonlinepay'       => $isOnlinepay,
                                'ordernote'         => $orderNote
                            ]
                        );

                if ($orderId) {
                    mOrder\OrderDetail :: createDetails($orderId,  $userId);
                    models\Cart :: setStatusToOrder($userId);
                    setcookie('cartprodtotal', '', time() - 3600, '/');
                    header('Location: /completed?id='.$orderId);
                } else {
                    return '<p class="text-danger">Не удалось добавить заказ! Попробуйте еще раз!</p><hr class="bhr" /><br />';
                }
            }
        }
        else {
            header("Location: /login");
        }
    }

    /**
     * Возвращает сообщение пользователю об успешном заказе и его номере.
     *
     * @param mixed[] $data массив url-параметров.
     * @return string возвращает сторку с номером заказа.
     */
    function Completed($data) : string
    {
        $this->pageTitle       .= ' | Заказ отправлен в обработку';
        $this->metaDescription  = 'Заказ отправлен в обработку. Предварительный заказ, даставка. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
        $this->metaKeywords     = 'Заказ отправлен в обработку, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
        $this->pageCanonical    = 'https://lagoc.ru/completed';
        $this->menuItem         = 'completed';
        $this->pageHeading      = 'Заказ отправлен в обработку';

        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $orderId = isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING) : null;

            if ($orderId) {
                return $orderId;
            } else {
                header("Location: /cart");
            }
        } else {
            header("Location: /login");
        }
    }

    /**
     * Отменяет заказ.
     */
    public function Cancel()
    {
        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $orderId = (int)isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING) : null;
            mOrder\Order :: updateStatus($orderId, 9);
        }
        header("Location: /orders");
    }

    /**
     * Устанавливает статус заказа.
     */
    public function SetStatus()
    {
        if ($_COOKIE['authuserid'] && $_COOKIE['authuser'] && $_COOKIE['authroleid'] && $_COOKIE['authroleid'] == '1') {
            $orderId = (int)isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING) : null;
            $orderStatusId = (int)isset($_GET['status']) ? filter_var(trim($_GET['status']), FILTER_SANITIZE_STRING) : null;
            mOrder\Order :: updateStatus($orderId, $orderStatusId);
        }
        header("Location: /orders");
    }

    /**
     * Меняет стоимость доставки заказа.
     */
    public function SetDeliverySum()
    {
        if ($_COOKIE['authuserid'] && $_COOKIE['authuser'] && $_COOKIE['authroleid'] && $_COOKIE['authroleid'] == '1') {
            $orderId = (int)isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING) : null;
            $deliverySum = isset($_GET['deliverysum']) ? floatval(filter_var(trim($_GET['deliverysum']), FILTER_SANITIZE_STRING)) : 0;
            mOrder\Order :: updateDeliverySum($orderId, $deliverySum);
        }
        header("Location: /orders");
    }
}