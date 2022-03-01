<?php
    class ProductPics extends Model
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
            $pics = DBContext :: getInstance() -> Select(
                'SELECT picname FROM productpics WHERE productid=:productid', ['productid' => $productId]);

            if ($pics && count($pics) > 0) {
                return $pics;
            }
            return null;
        }

        /**
         * Добавляет в БД картинку по конкретному товару.
         *
         * @param int $productId ID товара.
         * @param string $picName наименование файла картинки.
         */
        public static function addPic(int $productId, string $picName) : void
        {
            DBContext :: getInstance() -> Query(
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
            DBContext :: getInstance() -> Query('DELETE FROM productpics WHERE productid=:productid', ['productid' => $productId]);
        }
    }