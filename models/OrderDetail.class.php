<?php
namespace App\Models\Order;

use App\Lib as lib;
use App\Models\Abstracts as mAbstracts;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class OrderDetail extends mAbstracts\Model
{
    protected static $table = 'orderdetails';

    protected static function setProperties()
    {
        self::$properties['orderDetailId'] = [
            'type' => 'int',
            'autoincrement' => true,
            'readonly' => true,
            'unsigned' => true
        ];

        self::$properties['orderId'] = [
            'type' => 'int'
        ];

        self::$properties['cartId'] = [
            'type' => 'int'
        ];

        self::$properties['productId'] = [
            'type' => 'int'
        ];

        self::$properties['quantity'] = [
            'type' => 'decimal',
            'size' => 12.3
        ];

        self::$properties['price'] = [
            'type' => 'decimal',
            'size' => 10.2
        ];

        self::$properties['sm'] = [
            'type' => 'decimal',
            'size' => 12.2
        ];
    }

    /**
     * Возвращает детали всех заказов.
     *
     * @param int $userId ID пользователя.
     * @return mixed[] $details возвращает список товаров всех заказов.
     */
    public static function getAllDetails(int $userId) : ?array
    {
        $details = lib\DBContext :: getInstance() -> Select(
            'SELECT orderdetailid, orderid, productname, unit, d.quantity, d.price, d.sm
                   FROM orderdetails d INNER JOIN products p USING(productid)
                   INNER JOIN orders o USING(orderid)
                   WHERE o.userid = :userid', ['userid' => $userId]);
        return $details && count($details) > 0 ? $details : null;
    }

//    /**
//     * Возвращает детали заказа.
//     *
//     * @param int $orderId ID заказа.
//     * @return mixed[] $details возвращает список товаров в заказе.
//     */
//    public static function getDetails(int $orderId) : ?array
//    {
//        $details = lib\DBContext :: getInstance() -> Select(
//            'SELECT orderdetailid, orderid, productname, unit, d.quantity, d.price, d.sm
//                   FROM orderdetails d INNER JOIN products p USING(productid)
//                   WHERE orderid=:orderid',
//            ['orderid' => $orderId]);
//
//        return $details && count($details) > 0 ? $details : null;
//    }

    /**
     * Создает детали заказа из корзины. Сама корзина обновляется через триггер.
     *
     * @param int $orderId ID заказа.
     * @param int $userId ID пользователя.
     */
    public static function createDetails(int $orderId, int $userId) : void
    {
        lib\DBContext :: getInstance() -> Query(
            'INSERT INTO orderdetails (orderid, cartid, productid, quantity, price, sm)
                   SELECT :orderid, cartid, productid, quantity, price, sm FROM cart
                   WHERE orderstatusid = 1 AND userid = :userid',
            ['orderid' => $orderId, 'userid' => $userId]);
    }
}