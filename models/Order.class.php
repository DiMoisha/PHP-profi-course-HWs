<?php
namespace App\Models\Order;

use App\Lib as lib;
use App\Models\Abstracts as mAbstracts;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class Order extends mAbstracts\Model
{
    protected static $table = 'orders';

    protected static function setProperties()
    {
        self::$properties['orderId'] = [
            'type' => 'int',
            'autoincrement' => true,
            'readonly' => true,
            'unsigned' => true
        ];

        self::$properties['userId'] = [
            'type' => 'int'
        ];

        self::$properties['orderStatusId'] = [
            'type' => 'int'
        ];

        self::$properties['customerName'] = [
            'type' => 'varchar',
            'size' => 250
        ];

        self::$properties['customerTel'] = [
            'type' => 'varchar',
            'size' => 250
        ];

        self::$properties['customerEmail'] = [
            'type' => 'varchar',
            'size' => 250
        ];

        self::$properties['contactPerson'] = [
            'type' => 'varchar',
            'size' => 250
        ];

        self::$properties['isDelivery'] = [
            'type' => 'tinyint'
        ];

        self::$properties['deliveryAddress'] = [
            'type' => 'text'
        ];

        self::$properties['isOnlinepay'] = [
            'type' => 'tinyint'
        ];

        self::$properties['inn'] = [
            'type' => 'varchar',
            'size' => 30
        ];

        self::$properties['bik'] = [
            'type' => 'varchar',
            'size' => 30
        ];

        self::$properties['rasch'] = [
            'type' => 'varchar',
            'size' => 250
        ];

        self::$properties['bank'] = [
            'type' => 'varchar',
            'size' => 250
        ];

        self::$properties['orderNote'] = [
            'type' => 'text'
        ];

        self::$properties['orderSum'] = [
            'type' => 'decimal',
            'size' => 10.2
        ];

        self::$properties['deliverySum'] = [
            'type' => 'decimal',
            'size' => 12.2
        ];
    }

    /**
     * Возвращает весь список заказов.
     *
     * @param int $userId ID пользователя.
     * @param int $userRoleId ID роли пользователя.
     * @return mixed[] $orders возвращает список заказов.
     */
    public static function getOrders(int $userId, int $userRoleId) : ?array
    {
        $sql = 'SELECT o.orderid, s.orderstatusid, status, customername, customertel, 
                        customeremail, contactperson, isdelivery, deliveryaddress, 
                        isonlinepay, inn, bik, rasch, bank, ordernote, ordertime, 
                        ordersum, deliverysum, lastchangestime
                FROM orders o INNER JOIN orderstatus s USING(orderstatusid)
                WHERE orderstatusid > 1 '.($userRoleId > 1 ? ' AND userid = :userid ' : '').'ORDER BY orderid';
        $orders = lib\DBContext :: getInstance() -> Select($sql, ['userid' => $userId]);

        return $orders && count($orders) > 0 ? $orders : null;
    }

    /**
     * Создает новый заказ.
     *
     * @param mixed[] $order Объект заказ - массив значений.
     * @return int возвращает ID заказа, который был добавлен.
     */
    public static function createOrder(array $order) : int
    {
        $sql = 'INSERT INTO orders (userid, orderstatusid, customername, customertel,
                customeremail, contactperson, isdelivery, deliveryaddress, 
                isonlinepay, ordernote, ordersum, lastchangestime) 
                SELECT :userid, 2, :customername, :customertel, 
                :customeremail, :contactperson, :isdelivery, :deliveryaddress, 
                :isonlinepay, :ordernote, SUM(sm) sm, now() 
                FROM cart WHERE orderstatusid = 1 AND userid = :userid';

        lib\DBContext :: getInstance() -> Query($sql,
            [
                'userid'            => $order['userid'],
                'customername'      => $order['customername'],
                'customertel'       => $order['customertel'],
                'customeremail'     => $order['customeremail'],
                'contactperson'     => $order['contactperson'],
                'isdelivery'        => $order['isdelivery'],
                'deliveryaddress'   => $order['deliveryaddress'],
                'isonlinepay'       => $order['isonlinepay'],
                'ordernote'         => $order['ordernote']
            ]);

        return lib\DBContext :: getInstance() -> GetLastInsertId(self :: $table);
    }

    /**
     * Обновляет время последних изменений в заказе.
     *
     * @param int $orderId ID заказа.
     */
    public static function setLastChangesTime(int $orderId) : void
    {
        lib\DBContext :: getInstance() -> Query(
            'UPDATE orders SET lastchangestime = now() WHERE orderid = :orderid',
            ['orderid' => $orderId]);
    }

    /**
     * Обновляет статус заказа.
     *
     * @param int $orderId ID заказа.
     * @param int $orderStatusId ID статуса.
     */
    public static function updateStatus(int $orderId, int $orderStatusId) : void
    {
        lib\DBContext :: getInstance() -> Query(
            'UPDATE orders SET orderstatusid = :orderstatusid, lastchangestime = now() WHERE orderid = :orderid',
            ['orderid' => $orderId, 'orderstatusid' => $orderStatusId]);
    }

    /**
     * Меняет стоимость доставки заказа.
     *
     * @param int $orderId ID заказа.
     * @param float $deliverySum Стоимость доставки.
     */
    public static function updateDeliverySum(int $orderId, float $deliverySum) : void
    {
        lib\DBContext :: getInstance() -> Query(
            'UPDATE orders SET deliverysum = :deliverysum, lastchangestime = now() WHERE orderid = :orderid',
            ['orderid' => $orderId, 'deliverysum' => $deliverySum]);
    }

//    /**
//     * Отменяет заказ.
//     *
//     * @param int $orderId ID заказа.
//     */
//    public static function cancelOrder(int $orderId) : void
//    {
//        lib\DBContext :: getInstance() -> Query(
//            'UPDATE orders SET orderstatusid = 9, lastchangestime = now() WHERE orderid = :orderid',
//            ['orderid' => $orderId]);
//    }
}