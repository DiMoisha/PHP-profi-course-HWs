<?php
namespace App\Models\Product;

use App\Lib as lib;
use App\Models\Abstracts as mAbstracts;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class ProductPics extends mAbstracts\Model
{
    protected static $table = 'productpics';

    protected static function setProperties()
    {
        self::$properties['productPicId'] = [
            'type' => 'int',
            'autoincrement' => true,
            'readonly' => true,
            'unsigned' => true
        ];

        self::$properties['productId'] = [
            'type' => 'int'
        ];

        self::$properties['picName'] = [
            'type' => 'varchar',
            'size' => 250
        ];
    }

    /**
     * Возвращает картинки по конкретному товару.
     *
     * @param int $productId ID товара.
     * @return mixed[] $pics возвращает список картинок.
     */
    public static function getPics(int $productId): ?array
    {
        $pics = lib\DBContext :: getInstance() -> Select(
            'SELECT picname FROM productpics WHERE productid=:productid', ['productid' => $productId]);

        return ($pics && count($pics) > 0) ? $pics : null;
    }

    /**
     * Добавляет в БД картинку по конкретному товару.
     *
     * @param int $productId ID товара.
     * @param string $picName наименование файла картинки.
     */
    public static function addPic(int $productId, string $picName) : void
    {
        lib\DBContext :: getInstance() -> Query(
            'INSERT INTO productpics(productid, picname) VALUES (:productid, :picname)',
            ['productid' => $productId, 'picname' => $picName]);
    }

    /**
     * Удаляет все картинки по конкретному товару.
     *
     * @param int $productId ID товара.
     */
    public static function removePics(int $productId) : void
    {
        lib\DBContext :: getInstance() -> Query('DELETE FROM productpics WHERE productid=:productid', ['productid' => $productId]);
    }
}