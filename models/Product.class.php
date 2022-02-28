<?php
    class Product extends Model
    {
        protected static $table = 'products';

        protected static function setProperties()
        {
            self::$properties['productId'] = [
                'type' => 'int',
                'autoincrement' => true,
                'readonly' => true,
                'unsigned' => true
            ];

            self::$properties['categoryId'] = [
                'type' => 'int'
            ];

            self::$properties['productName'] = [
                'type' => 'varchar',
                'size' => 250
            ];

            self::$properties['tabIndex'] = [
                'type' => 'int'
            ];

            self::$properties['descr'] = [
                'type' => 'text'
            ];

            self::$properties['unit'] = [
                'type' => 'varchar',
                'size' => 60
            ];

            self::$properties['priceWONDS'] = [
                'type' => 'decimal',
                'size' => 10.2
            ];

            self::$properties['price'] = [
                'type' => 'decimal',
                'size' => 10.2
            ];

            self::$properties['htmlPageTitle'] = [
                'type' => 'varchar',
                'size' => 250
            ];

            self::$properties['htmlMetaDescr'] = [
                'type' => 'varchar',
                'size' => 250
            ];

            self::$properties['htmlMetaKeywords'] = [
                'type' => 'varchar',
                'size' => 250
            ];

            self::$properties['ismark'] = [
                'type' => 'tinyint'
            ];
        }

        /**
         * Возвращает весь список товаров.
         *
         * @return mixed[] $products Массив товаров.
         */
        public static function getProducts(): ?array
        {
            $sql = 'SELECT productid, productname, tabindex, unit, pricewonds, price 
                    FROM products WHERE ismark = 0 ORDER BY categoryid, tabindex, productname';
            $products = DBContext :: getInstance() -> Select($sql);

            if ($products && count($products) > 0) {
                return $products;
            }
            return null;
        }

        /**
         * Возвращает информацию по конкретному товару.
         *
         * @param int $productId ID товара.
         * @return mixed[] $product возвращает список записей по товару. Число записей = числу картинок товара.
         */
        public static function getProduct(int $productId): ?array
        {
            $sql = 'SELECT p.productid, p.categoryid, p.productname, p.tabindex, p.unit, p.descr, p.pricewonds, p.price,
                            p.htmlpagetitle, p.htmlmetadescr, p.htmlmetakeywords, i.productpicid, i.picname 
                    FROM products p LEFT JOIN productpics i USING(productid)
                    WHERE productid = :productid
                    ORDER BY i.productpicid';
            $product = DBContext :: getInstance() -> Select($sql, ['productid' => $productId]);

            if ($product && count($product) > 0) {
                return $product;
            }
            return null;
        }

        /**
         * Добавляет новый товар в БД.
         *
         * @param mixed[] $product Объект товар - массив значений.
         * @return mixed возвращает ID товара, который был добавлен.
         */
         public static function createProduct(array $product) : int
         {
             $sql = 'INSERT INTO products (categoryid, productname, tabindex, descr, unit, pricewonds, 
                     price, htmlpagetitle, htmlmetadescr, htmlmetakeywords) VALUES (:categoryid,:productname,:tabindex,
                     :descr, :unit, :pricewonds, :price, :htmlpagetitle, :htmlmetadescr, :htmlmetakeywords)';

             DBContext :: getInstance() -> Query($sql,
                 [
                    'categoryid'        => $product['categoryId'],
                    'productname'       => $product['productName'],
                    'tabindex'          => $product['tabIndex'],
                    'descr'             => $product['descr'],
                    'unit'              => $product['unit'],
                    'pricewonds'        => $product['priceWONDS'],
                    'price'             => $product['price'],
                    'htmlpagetitle'     => $product['htmlPageTitle'],
                    'htmlmetadescr'     => $product['htmlMetaDescr'],
                    'htmlmetakeywords'  => $product['htmlMetaKeywords']
                 ]);

             return DBContext :: getInstance() -> GetLastInsertId(self :: $table);
        }

        /**
         * Редактирует товар в БД.
         *
         * @param mixed[] $product Объект товар - массив значений.
         * @return mixed возвращает ID товара, который был добавлен.
         */
        public static function editProduct(array $product) : void
        {
            $sql = 'UPDATE products SET categoryid=:categoryid, productname=:productname, tabindex=:tabindex,
                    descr=:descr, unit=:unit, pricewonds=:pricewonds, price=:price, htmlpagetitle=:htmlpagetitle,
                    htmlmetadescr=:htmlmetadescr, htmlmetakeywords=:htmlmetakeywords WHERE productid=:productid';

            DBContext :: getInstance() -> Query($sql,
                [
                    'categoryid'        => $product['categoryId'],
                    'productname'       => $product['productName'],
                    'tabindex'          => $product['tabIndex'],
                    'descr'             => $product['descr'],
                    'unit'              => $product['unit'],
                    'pricewonds'        => $product['priceWONDS'],
                    'price'             => $product['price'],
                    'htmlpagetitle'     => $product['htmlPageTitle'],
                    'htmlmetadescr'     => $product['htmlMetaDescr'],
                    'htmlmetakeywords'  => $product['htmlMetaKeywords'],
                    'productid'         => $product['productId']
                ]);
        }

        /**
         * Удаляем товар в БД.
         *
         * @param int $productId ID товара.
         */
        public static function removeProduct(int $productId) : void
        {
            DBContext :: getInstance() -> Query('UPDATE products SET ismark = 1 WHERE productid = :productid',['productid' => $productId]);
        }
    }