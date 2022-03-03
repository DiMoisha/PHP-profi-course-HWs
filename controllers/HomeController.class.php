<?php
namespace App\Controllers;

use App\Controllers\Base as cBase;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class HomeController extends cBase\Controller
{
    public $pageTitle;
    public $metaDescription;
    public $metaKeywords;
    public $pageCanonical;
    public $menuItem;
    public $pageHeading;
    public $view = 'Home';

    function __construct()
    {
        parent :: __construct();
        $this -> metaDescription = 'ООО ЛАГОС. Производство, продажа материалов для дорожного строительства. Асфальт. Битумная эмульсия. Новости ООО ЛАГОС';
        $this -> metaKeywords    = 'дорожное строительство, материалы для строительства дорог, производство, асфальт, бетон, битум, мастика, асфальтобетонный завод, ООО ЛАГОС';
        $this -> pageCanonical   = 'https://lagoc.ru';
        $this -> menuItem        = 'home';
        $this -> pageHeading     = 'ООО "ЛАГОС"';
    }

    /**
     * Возвращает в представление информацию для главной страницы в переменную contentData
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Index($data){
        $this -> pageTitle      .= ' | Главная';
        return null;
    }

    /**
     * Возвращает информацию для страницы "О нас"
     *
     * @param mixed[] $data массив url-параметров.
     */
    function About($data){
        $this -> pageTitle      .= ' | О компании | Производство, продажа материалов, контакты';
        $this -> metaDescription = 'Деятельность завода. Асфальт. Битумная эмульсия. Производство материалов для дорожного строительства';
        $this -> metaKeywords    = 'о предприятии, производство, продажа материалов, производство асфальта, дорожные работы, асфальтобетонный завод, ООО ЛАГОС';
        $this -> pageCanonical   = 'https://lagoc.ru/about';
        $this -> menuItem        = 'about';
        $this -> pageHeading     = 'О компании';
        return null;
    }

    /**
     * Возвращает информацию для страницы "Калькулятор асфальта"
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Calculator($data){
        $this -> pageTitle      .= ' | Калькулятор асфальта | Расчет расхода';
        $this -> metaDescription = 'Калькулятор асфальта, расчет расхода асфальта для строительства дорог. Точный расчет расхода асфальта';
        $this -> metaKeywords    = 'расчет асфальта, калькулятор асфальта, толщина слоя, асфальтобетонный завод, асфальт, ООО ЛАГОС';
        $this -> pageCanonical   = 'https://lagoc.ru/calculator';
        $this -> menuItem        = 'calculator';
        $this -> pageHeading     = 'Калькулятор асфальта';
        return null;
    }

    /**
     * Возвращает информацию для страницы "Контакты"
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Contact($data){
        $this -> pageTitle      .= ' | Контакты | Адрес, отделы, схема проезда';
        $this -> metaDescription = 'ООО ЛАГОС асфальтобетонный завод в Москве и Московской области';
        $this -> metaKeywords    = 'Контакты завода ОО ЛАГОС. Точный адрес, телефоны отделов, подробная схема проезда до завода, электронная почта и телефоны для контакта с сотрудниками';
        $this -> pageCanonical   = 'https://lagoc.ru/contact';
        $this -> menuItem        = 'contact';
        $this -> pageHeading     = 'Контакты ООО "ЛАГОС"';
        return null;
    }

    /**
     * Возвращает информацию для страницы "Новости"
     *
     * @param mixed[] $data массив url-параметров.
     */
    function News($data){
        $this -> pageTitle      .= ' | Новости | Важная информация для наших покупателей';
        $this -> metaDescription = 'Новости ЛАГОС. Важная, оперативная информация для наших покупателей.';
        $this -> metaKeywords    = 'новости ЛАГОС, новости, информация для клиентов, асфальт, бетон, битум, асфальтобетонный завод, ЛАГОС';
        $this -> pageCanonical   = 'https://lagoc.ru/news';
        $this -> menuItem        = 'news';
        $this -> pageHeading     = 'Новости ООО "ЛАГОС"';
        return null;
    }

    /**
     * Возвращает информацию для страницы "Прайслист"
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Pricelist($data){
        $this -> pageTitle      .= ' | Прайс-лист | Скачать';
        $this -> metaDescription = 'Прайс-лист ООО ЛАГОС асфальтобетонный завод в Москве и Московской области';
        $this -> metaKeywords    = 'Прайс-лист, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
        $this -> pageCanonical   = 'https://lagoc.ru/pricelist';
        $this -> menuItem        = 'pricelist';
        $this -> pageHeading     = 'Прайс-лист';
        return null;
    }
}

//site/index.php?path=index/test/5