<?php
namespace App\Controllers;

use App\Controllers\Base as cBase;
use App\Models as models;
use Exception;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class CartController extends cBase\Controller
{
    public $pageTitle;
    public $metaDescription;
    public $metaKeywords;
    public $pageCanonical;
    public $menuItem;
    public $pageHeading;
    public $view = 'Cart';

    function __construct()
    {
        parent :: __construct();
    }

    /**
     * Возвращает содержимое корзины.
     *
     * @param mixed[] $data массив url-параметров.
     * @return mixed[] возвращает массив товаров.
     */
    function Index($data) : ?array
    {
        $this->pageTitle       .= ' | Корзина покупок';
        $this->metaDescription  = 'Корзина покупок. Предварительный заказ, даставка. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
        $this->metaKeywords     = 'Корзина покупок, продукцию, услуги купить, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
        $this->pageCanonical    = 'https://lagoc.ru/cart';
        $this->menuItem         = 'cart';
        $this->pageHeading      = 'Ваша корзина';

        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $userId = $_COOKIE['authuserid'];
            return models\Cart :: getCart($userId);
        }
        else {
            header("Location: /login");
        }
    }

    /**
     * Подсчет количества товаров в корзине.
     */
    private function setTotal() : void
    {
        setcookie('cartprodtotal', '', time() - 3600, '/');

        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $userId = $_COOKIE['authuserid'];
            $total = models\Cart :: getTotal($userId);

            if ($total) {
                setcookie('cartprodtotal', (string)$total[0]['cnt'], time() + 3600 * 24 * 365, '/'); // На один год
            }
        }
    }

    /**
     * Добавляет новый товар в корзину.
     *
     * @param mixed[] $data массив url-параметров.
     * @throws Exception
     */
    function Add($data) : void
    {
        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $userId = $_COOKIE['authuserid'];

            if ($this -> isPost()) {
                $productId  = isset($_POST['productid']) ? intval(filter_var(trim($_POST['productid']), FILTER_SANITIZE_STRING)) : 0;
                $price      = isset($_POST['price']) ? floatval(filter_var(trim($_POST['price']), FILTER_SANITIZE_STRING)) : 0;

                models\Cart :: addProduct($userId, $productId, 1, $price);
                $this -> setTotal();
            }

            header("Location: /cart");
        }
        else {
            header("Location: /login");
        }
    }

    /**
     * Редактирование товара.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Edit($data) : void
    {
        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $userId = $_COOKIE['authuserid'];

            if ($this -> isPost()) {
                $productId  = isset($_POST['productid']) ? intval(filter_var(trim($_POST['productid']), FILTER_SANITIZE_STRING)) : 0;
                $quantity   = isset($_POST['quantity']) ? floatval(filter_var(trim($_POST['quantity']), FILTER_SANITIZE_STRING)) : 0;

                models\Cart :: setQuantity($userId, $productId, $quantity);
                $this -> setTotal();
            }

            header("Location: /cart");
        }
        else {
            header("Location: /login");
        }
    }

    /**
     * Удаление товара из корзины.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Remove($data) : void
    {
        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $userId = $_COOKIE['authuserid'];

            if ($this -> isPost()) {
                $productId  = isset($_POST['productid']) ? intval(filter_var(trim($_POST['productid']), FILTER_SANITIZE_STRING)) : 0;

                models\Cart :: removeProduct($userId, $productId);
                $this -> setTotal();
            }

            header("Location: /cart");
        }
        else {
            header("Location: /login");
        }
    }
}