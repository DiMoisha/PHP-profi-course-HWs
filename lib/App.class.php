<?php
    class App
    {
        /**
         * Инициализация
         *
         * @throws Twig_Error_Loader
         * @throws Throwable
         * @throws Twig_Error_Syntax
         */
        public static function Init()
        {
            date_default_timezone_set('Europe/Moscow');
            DBContext :: getInstance() -> Connect(Config :: get('db_user'), Config :: get('db_password'), Config :: get('db_base'));

            if (php_sapi_name() !== 'cli' && isset($_SERVER) && isset($_GET)) {
                self :: webRouter($_GET['path'] ?? '');
            }
        }

        /**
         * Роутер - обрабатывает url и вызывает соответствующие методы контроллеров и рендер шаблонов
         *
         * @param mixed $url URL страницы
         * @throws Throwable
         * @throws Twig_Error_Loader
         * @throws Twig_Error_Syntax
         */
        protected static function webRouter($url)
        {
            /*
             * Route formulas:
             * ControllerName/ActionName/ID-parameter?html-parameters
             * ControllerName/ActionName
             * RouteAlias
             */
            //http://site.ru/index.php?path=News/delete/5

            $url = explode('/', $url);

            /*
             * Проверяем роут на соответствие из массива алиасов роутов, и если находим, то назначаем контроллер и метод
             */
            require_once __DIR__ . '/../config/routes.php';
            foreach (ROUTES as $route => $routeData) {
                if ($route === mb_strtolower($url[0].($url[1] ? '/'.$url[1] : ''))) {
                    $_GET['page'] = $routeData[0];
                    $_GET['action'] = $routeData[1];
                }
            }

            /*
             * Если не находим алиас в массиве роутов, идем стандартным путем
             */
            if (!isset($_GET['page'])) {
                if (!empty($url[0])) {
                    $_GET['page'] = $url[0];//Часть имени класса контроллера
                    if (isset($url[1])) {
                        if (is_numeric($url[1])) {
                            $_GET['id'] = $url[1];
                        } else {
                            $_GET['action'] = $url[1];//часть имени метода
                        }
                        if (isset($url[2])) {//формальный параметр для метода контроллера
                            $_GET['id'] = $url[2];
                        }
                    }
                } else {
                    $_GET['page'] = 'Home';
                }
            }

            if (isset($_GET['page'])) {
                $controllerName = ucfirst($_GET['page']) . 'Controller'; //HomeController
                $methodName     = ucfirst($_GET['action']) ?? 'Index';
                $controller     = null;
                $notFound       = true;

                if (class_exists($controllerName)) {
                    try {
                        $controller = new $controllerName();
                    } catch(Exception $ex) {}

                    $notFound = !($controller && method_exists($controller, $methodName));
                }

                if (!$notFound) {
                    /*
                     * Данные страницы - из метода контроллера
                     * Тэг - Заголовок страницы
                     * Метатэг - описание
                     * Метатэг - ключевые слова
                     * Канонический адрес
                     * Активное меню
                     * Основной заголовок на странице
                     * Текущий год
                     *
                     * ПАРАМЕТРЫ ИЗ КУКОВ:
                     * Авторизованный пользователь
                     * Роль пользователя
                     * Логин пользователя
                     * Количество товаров в корзине покупок
                     */
                    $data = [
                        'contentData'       => $controller -> $methodName($_GET),
                        'pageTitle'         => $controller -> pageTitle,
                        'metaDescription'   => $controller -> metaDescription,
                        'metaKeywords'      => $controller -> metaKeywords,
                        'pageCanonical'     => $controller -> pageCanonical,
                        'menuItem'          => $controller -> menuItem,
                        'pageHeading'       => $controller -> pageHeading,
                        'fYear'             => date('Y'),
                        'authUser'          => $_COOKIE['authuser'],
                        'authRoleId'        => $_COOKIE['authroleid'],
                        'login'             => $_COOKIE['login'],
                        'cartProductTotal'  => $_COOKIE['cartprodtotal'] ?? 0
                    ];

                    $view = $controller -> view . '/' . $methodName . '.html.twig';

                    if (!isset($_GET['asAjax'])) {
                        $loader = new Twig_Loader_Filesystem(Config:: get('path_views'));
                        $twig = new Twig_Environment($loader);
                        $template = $twig -> loadTemplate($view);

                        echo $template -> render($data);
                    } else {
                        echo json_encode($data);
                    }
                }
                else {
                    header("HTTP/1.0 404 Not Found");
                    header("HTTP/1.1 404 Not Found");

                    $data = [
                        'pageTitle'         => Config :: get('sitename').' | Страница не найдена',
                        'metaDescription'   => 'Страница не найдена',
                        'metaKeywords'      => 'Страница не найдена, 404',
                        'pageHeading'       => 'Ошибка 404',
                        'fYear'             => date('Y')
                    ];
                    $loader = new Twig_Loader_Filesystem(Config:: get('path_views'));
                    $twig = new Twig_Environment($loader);
                    $template = $twig -> loadTemplate('notfound.html.twig');
                    echo $template -> render($data);
                }
            }
        }
    }