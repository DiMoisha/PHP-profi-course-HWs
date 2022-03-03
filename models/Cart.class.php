<?php
namespace App\Models;

use App\Lib as lib;
use App\Models\Abstracts as mAbstracts;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class Cart extends mAbstracts\Model
{
    protected static $table = 'cart';

    protected static function setProperties()
    {
        self::$properties['cartId'] = [
            'type' => 'int',
            'autoincrement' => true,
            'readonly' => true,
            'unsigned' => true
        ];

        self::$properties['userId'] = [
            'type' => 'int'
        ];

        self::$properties['productId'] = [
            'type' => 'int'
        ];

        self::$properties['orderStatusId'] = [
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
     * Возвращает весь список товаров в корзине.
     *
     * @param int $userId ID пользователя.
     * @return mixed[] $cart возвращает массив товаров в корзине.
     */
    public static function getCart(int $userId) : ?array
    {
        $sql = 'SELECT cartid, c.productid, p.productname, p.unit, c.price, quantity, sm
                    FROM cart c INNER JOIN products p USING(productid)
                    WHERE userid = :userid AND orderstatusid = 1
                    ORDER BY cartid';
        $cart = lib\DBContext :: getInstance() -> Select($sql, ['userid' => $userId]);

        return $cart && count($cart) > 0 ? $cart : null;
    }

    /**
     * Добавляет новый товар в корзину.
     *
     * @param int $userId ID пользователя.
     * @param int $productId ID товара.
     * @param float $quantity Количество товара.
     * @param float $quantity Цена товара.
     */
    public static function addProduct(int $userId, int $productId, float $quantity, float $price) : void
    {
        $sql = 'SELECT cartid FROM cart WHERE userid = :userid AND productid = :productid AND orderstatusid = 1';
        $checkRow = lib\DBContext :: getInstance() -> Select($sql, ['userid' => $userId, 'productid' => $productId]);

        if ($checkRow && count($checkRow) > 0)
            $sql = 'UPDATE cart SET quantity = quantity + :quantity, sm = sm + :quantity * :price 
                         WHERE userid = :userid AND productid = :productid AND orderstatusid = 1';
        else
            $sql = 'INSERT INTO cart (userid, productid, orderstatusid, quantity, price, sm) 
                        VALUES (:userid, :productid, 1, :quantity, :price, :sm)';

        lib\DBContext :: getInstance() -> Query($sql,
            [
                'userid'    => $userId,
                'productid' => $productId,
                'quantity'  => $quantity,
                'price'     => $price,
                'sm'        => $quantity * $price
            ]
        );
    }

    /**
     * Меняет количество товара в корзине.
     *
     * @param int $userId ID пользователя.
     * @param int $productId ID товара.
     * @param float $quantity Количество товара.
     */
    public static function setQuantity(int $userId, int $productId, float $quantity) : void
    {
        lib\DBContext :: getInstance() -> Query(
            'UPDATE cart SET quantity = :quantity, sm = price * :quantity
                        WHERE userid = :userid AND productid = :productid AND orderstatusid = 1',
            [
                'userid'    => $userId,
                'productid' => $productId,
                'quantity'  => $quantity
            ]
        );
    }

    /**
     * Удаляет товар из корзины.
     *
     * @param int $userId ID пользователя.
     * @param int $productId ID товара.
     */
    public static function removeProduct(int $userId, int $productId) : void
    {
        lib\DBContext :: getInstance() -> Query(
            'DELETE FROM cart WHERE userid = :userid AND productid = :productid AND orderstatusid = 1',
            [
                'userid'    => $userId,
                'productid' => $productId
            ]
        );
    }

    /**
     * Подсчет суммы и кол-ва товаров в корзине.
     *
     * @param int $userId ID пользователя.
     * @return mixed[] $total возвращает массив итоговых значений.
     */
    public static function getTotal(int $userId) : ?array
    {
        $sql = 'SELECT SUM(sm) sm, COUNT(*) cnt FROM cart
                    WHERE userid = :userid AND orderstatusid = 1
                    GROUP BY userid';
        $total = lib\DBContext :: getInstance() -> Select($sql, ['userid' => $userId]);

        return $total && count($total) > 0 ? $total : null;
    }

    /**
     * Отправляет всю корзину в заказ.
     *
     * @param int $userId ID пользователя.
     */
    public static function setStatusToOrder(int $userId) : void
    {
        lib\DBContext :: getInstance() -> Query(
        'UPDATE cart SET orderstatusid = 2 WHERE orderstatusid = 1 AND userid = :userid',['userid' => $userId]);
    }
}