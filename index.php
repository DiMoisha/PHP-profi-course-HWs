<?php
    # Профессиональная веб-разработка на PHP
    # Урок 1. ООП в PHP. Базовые понятия
    # 1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
    # 2. Описать свойства класса из п.1 (состояние).
    # 3. Описать поведение класса из п.1 (методы).
    # 4. Придумать наследников класса из п.1. Чем они будут отличаться?


    # РЕШЕНИЕ:
    # Класс Product интернет-магазина, описывает товар - ID, наименование, описание, цену.
    # Поведение класса описывается методами: изменения цены, получения текущей цены, получение полного описания товара.

    class Product
    {
        protected $productId;
        protected $productName;
        protected $descr;
        protected $price;

        function __construct($productId, $productName, $descr, $price) {
            $this -> productId = $productId;
            $this -> productName = $productName;
            $this -> descr = $descr;
            $this -> price = $price;
        }

        function getProductId() {
            return $this -> productId;
        }

        function getProductName() {
            return $this -> productName;
        }

        function getDescr() {
            return $this -> descr;
        }

        function getPrice() {
            return $this -> price;
        }

        function setPrice($price): void {
            $this -> price = $price;
        } 

        function getPriceString() {
            return "Цена ".$this -> productName." ".$this -> price." руб.";
        }

        function getFullDescr() {
            return "<h1>".$this -> productName."</h1><p>".$this -> descr."</p>";
        }
    }

    # Класс ProductItem, наследник от Product описывает карточку товара, открываемую на просмотр. 
    # В этом классе есть список картинок и методы для внесения и получения картинок.

    class ProductItem extends Product
    {
        protected $productPics = [];

        function __construct($productId, $productName, $descr, $price, $pics = []) {
            parent::__construct($productId, $productName, $descr, $price);
            $this -> productPics = $pics;
        }
      
        function stProductPics($pics): void {
            $this -> productPics = $pics;
        }

        function addPic($pic): void {
            $this -> productPics[] = $pic;
        }

        function getProductPics() {
            if (count($this -> productPics) > 0) {
                $pics = "";

                foreach ($this -> productPics as $pic) {
                    $pics .= '<a href="/images/products/'.$pic -> productName.'"><img data-src="holder.js/120x90" class="img-thumbnail product-img-thumbnail" 
                    src="/images/products/thumbnails/'.$pic -> productName.'" alt="'.$pic -> productName.'" /></a>';
                }

                return $pics;
            } else {
                return "Картинок нет!";
            }
        }
    }

    #Класс , наследник от Product описывает товар в корзине покупок. Тут уже появились поля - 
    #количество, сумма. Методы - добавление товара в корзину, изменение количества,
    #пересчет суммы, возврат строки корзины

    class ProductInCart extends Product
    {
        protected $quantity;
        protected $sm;

        function __construct($productId, $productName, $descr, $price, $quantity = 1) {
            parent::__construct($productId, $productName, $descr, $price);
            $this -> quantity = $quantity;
            $this -> calc();
        }

        function setQuantity($quantity): void {
            $this -> quantity = $quantity;
            $this -> calc();
        }

        function getCartItem() {
            return $this -> productName.", цена: ".$this -> price."руб. кол-во:".$this -> quantity."сумма:".$this -> sm."руб.";
        }

        private function calc(): void {
            $this -> sm = $this -> price * $this -> quantity;
        }
    }

    # Наследники, хоть и описывают фактически одну сущность - объект Товар, но отличаются представлением этой
    # сущности в разных ипостасях и соотвественно поведением 


    # 5. Дан код:
    class A {   
        public function foo() {
            static $x = 0;
            echo ++$x;
        }
    }
    $a1 = new A();
    $a2 = new A();
    $a1->foo();
    $a2->foo();
    $a1->foo();
    $a2->foo();
    
    #Что он выведет на каждом шаге? Почему?

    # ОТВЕТ: на каждом шаге будет выведен инкремент x. Т.е. - 1   2   3   4.
    # Это происходит, потому что x это статическое поле (static) и будет одинаково меняться во всех экземплярах класса(объектах), 
    # независимо от того какой экземпляр класса изменил это поле



    # Немного изменим п.5:
    class A {
        public function foo() {
            static $x = 0;
            echo ++$x;
        }
    }
    class B extends A {
    }
    $a1 = new A();
    $b1 = new B();
    $a1->foo(); 
    $b1->foo(); 
    $a1->foo(); 
    $b1->foo();

    # 6. Объясните результаты в этом случае.

    # ОТВЕТ: на каждом шаге будет выведен инкремент x. - 1   1   2   2. для каждого класса!!!.
    # Это происходит, потому что x это статическое поле (static) и будет одинаково меняться во всех экземплярах класса(объектах), 
    # независимо от того какой экземпляр класса изменил это поле. Но поскольку класс В - это отдельный класс, хоть и наследник А,
    # он будет иметь свое статическое поле х. Поэтому результат 1 1 2 2. 



    # 7. *Дан код:
    class A {
        public function foo() {
            static $x = 0;
            echo ++$x;
        }
    }
    class B extends A {
    }
    $a1 = new A;
    $b1 = new B;
    $a1->foo(); 
    $b1->foo(); 
    $a1->foo(); 
    $b1->foo(); 

    # Что он выведет на каждом шаге? Почему?

    # ОТВЕТ: на каждом шаге будет выведен инкремент x. - 1   1   2   2. для каждого класса!!!.
    # Это происходит, потому что x это статическое поле (static) и будет одинаково меняться во всех экземплярах класса(объектах), 
    # независимо от того какой экземпляр класса изменил это поле. Но поскольку класс В - это отдельный класс, хоть и наследник А,
    # он будет иметь свое статическое поле х. Поэтому результат 1 1 2 2. 
    # Разница с пунктом 6 заключается в создании объектов. А именно скобки () после имени класса. Но поскольку в конструктор класса 
    # не передаются параметры, скобки можно опустить