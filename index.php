<?php
    /*
        Профессиональная веб-разработка на PHP
        Урок 2. ООП в PHP. Расширенное изучение
        1. Создать структуру классов ведения товарной номенклатуры.
            а) Есть абстрактный товар.
            б) Есть цифровой товар, штучный физический товар и товар на вес.
            в) У каждого есть метод подсчета финальной стоимости.
            г) У цифрового товара стоимость постоянная – дешевле штучного товара в два раза. У штучного товара обычная стоимость, 
                у весового – в зависимости от продаваемого количества в килограммах. 
                У всех формируется в конечном итоге доход с продаж.
            д) Что можно вынести в абстрактный класс, наследование?
        2. *Реализовать паттерн Singleton при помощи traits.
    */


    include_once 'Domain/Entities/candy.php';
    include_once 'Domain/Entities/cup.php';
    include_once 'Domain/Entities/phone.php';
    include_once 'Domain/Entities/productinsale.php';
    use Domain\Entities as myShop;

    // Создадим пару телефонов, чашку и мешочек конфет
    $phone_1 = new myShop\Phone(1,"Samsung A300","Мобильный телефон для души и тела",22000,'6.5" (2400x1080) IPS 90 Гц',
    "64 ГБ","4 ГБ","4 камеры 50 МП, 8 МП, 2 МП, 2 МП","5000 мА·ч","MediaTek Helio G88","2 (nano SIM)","Android 11","181 г");
    $phone_2 = new myShop\Phone(2,"Nokia NS-11","Мобильный телефон из Финляндии",32999,'5" 90 Гц',
    "6 ГБ","2 ГБ","2 камеры 2 МП, 2 МП","3000 мА·ч","Anio G88","1 (nano SIM)","Winw Mobile","400 г");
    echo $phone_1 -> getProductName().', price:'.$phone_1 -> getPrice();  
    echo '<br>';
    echo '<br>';  
    echo $phone_2 -> getProductName().', price:'.$phone_2 -> getPrice();  
    echo '<br>';

    $cup_1 = new myShop\Cup(3,"Чашка из дворца","Для настоящих королей",55555.55,"Gold","gold & platinum", "500ml", "12 cm", "10 cm");
    echo $cup_1 -> getPrice();  
    echo '<br>';

    $candy_1 = new myShop\Candy(4, "Конфеты Мерси","Для удовольствия вашего живота",99.99,"Красный большевик(с)","Шоколадные","С орехом и изюмом","Фольга и бумага");
    echo $candy_1 -> getPrice();  
    echo '<br>';

   
    // а теперь купленный товар и какой с него навар
    $sale_1 = new myShop\ProductInSale($phone_1, 2);
    echo 'Profit: '.$sale_1 -> getProfit();
    echo '<br>';
    echo 'Summ: '.$sale_1 -> getSm();
    echo '<br>';
    echo 'Price: '.$sale_1 -> getPrice();
    echo '<br>';

    $sale_2 = new myShop\ProductInSale($cup_1, 1);
    echo 'Profit: '.$sale_2 -> getProfit();
    echo '<br>';
    echo 'Summ: '.$sale_2 -> getSm();
    echo '<br>';
    echo 'Price: '.$sale_2 -> getPrice();
    echo '<br>';
    
    $sale_3 = new myShop\ProductInSale($candy_1, 3.5);
    echo 'Profit: '.$sale_3 -> getProfit();
    echo '<br>';
    echo 'Summ: '.$sale_3 -> getSm();
    echo '<br>';
    echo 'Price: '.$sale_3 -> getPrice();
    echo '<br>';