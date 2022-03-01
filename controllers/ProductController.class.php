<?php
    class ProductController extends Controller
    {
        public $pageTitle;
        public $metaDescription;
        public $metaKeywords;
        public $pageCanonical;
        public $menuItem;
        public $pageHeading;
        public $view = 'Product';

        function __construct()
        {
            parent:: __construct();
        }

        /**
         * Возвращает информацию по списку продукции.
         *
         * @param mixed[] $data массив url-параметров.
         * @return mixed[] возвращает массив товаров.
         */
        function Index($data) : array
        {
            $this->pageTitle       .= ' | Продукция и услуги | Купить, цена';
            $this->metaDescription  = 'Купить продукцию по выгодной цене. Предварительный заказ, даставка. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
            $this->metaKeywords     = 'Продукцию и услуги купить, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
            $this->pageCanonical    = 'https://lagoc.ru/products';
            $this->menuItem         = 'products';
            $this->pageHeading      = 'Продукция';

            return Product:: getProducts();
        }

        /**
         * Возвращает информацию по конкретному товару.
         *
         * @param mixed[] $data массив url-параметров.
         * @return mixed[] возвращает массив значений по товару.
         */
        function Product($data) : array
        {
            $productId = isset($_GET['id']) ? intval(filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING)) : 0;

            if ($productId > 0) {
                $product = Product :: getProduct($productId);

                if ($product) {
                    $this->pageTitle       .= $product[0]['productname'].' | Купить, цена';
                    $this->metaDescription  = $product[0]['productname'].' купить по выгодной цене. Предварительный заказ, даставка. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
                    $this->metaKeywords     = $product[0]['productname'].' купить, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
                    $this->pageCanonical    = 'https://lagoc.ru/product?id='.$productId;
                    $this->menuItem         = 'product';
                    $this->pageHeading      = $product[0]['productname'];

                    return $product;
                } else {
                    header('Location: /notfound');
                }
            } else {
                header('Location: /notfound');
            }
        }

        /**
         * Добавляет новый товар.
         *
         * @param mixed[] $data массив url-параметров.
         * @throws Exception
         */
        function Create($data)
        {
            $this->pageTitle       .= ' | Добавление товара';
            $this->metaDescription  = 'Добавление товара. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
            $this->metaKeywords     = 'Добавление товара, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
            $this->pageCanonical    = 'https://lagoc.ru/addroduct';
            $this->menuItem         = 'addproduct';
            $this->pageHeading      = 'Добавление товара';

            if ($_COOKIE['authuserid'] && $_COOKIE['authuser'] && $_COOKIE['authroleid'] && $_COOKIE['authroleid'] == '1') {
                if ($this -> isPost()) {
                    $categoryId         = isset($_POST['categoryid']) ? intval(filter_var(trim($_POST['categoryid']), FILTER_SANITIZE_STRING)) : 1;
                    $productName        = isset($_POST['productname']) ? filter_var(trim($_POST['productname']), FILTER_SANITIZE_STRING) : false;
                    $tabIndex           = isset($_POST['tabindex']) ? intval(filter_var(trim($_POST['tabindex']), FILTER_SANITIZE_STRING)) : 1;
                    $descr              = isset($_POST['descr']) ? filter_var(trim($_POST['descr']), FILTER_SANITIZE_STRING) : false;
                    $unit               = isset($_POST['unit']) ? filter_var(trim($_POST['unit']), FILTER_SANITIZE_STRING) : false;
                    $priceWONDS         = isset($_POST['pricewonds']) ? floatval(filter_var(trim($_POST['pricewonds']), FILTER_SANITIZE_STRING)) : 0;
                    $price              = isset($_POST['price']) ? floatval(filter_var(trim($_POST['price']), FILTER_SANITIZE_STRING)) : 0;
                    $htmlPageTitle      = isset($_POST['htmlpagetitle']) ? filter_var(trim($_POST['htmlpagetitle']), FILTER_SANITIZE_STRING) : false;
                    $htmlMetaDescr      = isset($_POST['htmlmetadescr']) ? filter_var(trim($_POST['htmlmetadescr']), FILTER_SANITIZE_STRING) : false;
                    $htmlMetaKeywords   = isset($_POST['htmlmetakeywords']) ? filter_var(trim($_POST['htmlmetakeywords']), FILTER_SANITIZE_STRING) : false;

                    if (mb_strlen($productName) < 3 || mb_strlen($productName) > 250) {
                        return '<p class="text-danger">Недопустимая длина наименования! Длина должна быть от 3 до 250 символов!</p><hr class="bhr" /><br />';
                    }

                    if (mb_strlen($unit) > 60) {
                        return '<p class="text-danger">Недопустимая длина единицы измерения! Длина должна быть до 60 символов!</p><hr class="bhr" /><br />';
                    }

                    if (mb_strlen($htmlPageTitle) > 250) {
                        return '<p class="text-danger">Недопустимая длина заголовка страницы товара! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                    }

                    if (mb_strlen($htmlMetaDescr) > 250) {
                        return '<p class="text-danger">Недопустимая длина описание страницы товара! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                    }

                    if (mb_strlen($htmlMetaKeywords) > 250) {
                        return '<p class="text-danger">Недопустимая длина ключевые слова страницы товара! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                    }

                    $product = [
                        'categoryId'        => $categoryId,
                        'productName'       => $productName,
                        'tabIndex'          => $tabIndex,
                        'descr'             => $descr,
                        'unit'              => $unit,
                        'priceWONDS'        => $priceWONDS,
                        'price'             => $price,
                        'htmlPageTitle'     => $htmlPageTitle,
                        'htmlMetaDescr'     => $htmlMetaDescr,
                        'htmlMetaKeywords'  => $htmlMetaKeywords
                    ];

                    //$pics = [$_FILES['uploadpic1'], $_FILES['uploadpic2'], $_FILES['uploadpic3'], $_FILES['uploadpic4'],$_FILES['uploadpic5']];
                    $pics = [];

                    for ($i = 1; $i < 6; $i ++) {
                        if ($_FILES['uploadpic'.$i]) $pics[] = $_FILES['uploadpic'.$i];
                    }

                    $productId = Product :: createProduct($product);

                    if ($productId) {
                        $this -> loadProductPics($productId, $pics);
                    } else {
                        return '<p class="text-danger">Не удалось добавить товар! Попробуйте еще раз!</p><hr class="bhr" /><br />';
                    }

                    header('Location: /products');
                }
            } else {
                header('Location: /products');
            }
        }

        /**
         * Редактирование товара.
         *
         * @param mixed[] $data массив url-параметров.
         * @throws Exception
         */
        function Edit($data)
        {
            if ($_COOKIE['authuserid'] && $_COOKIE['authuser'] && $_COOKIE['authroleid'] && $_COOKIE['authroleid'] == '1') {
                $productId = isset($_GET['id']) ? intval(filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING)) : 0;

                $this->pageTitle       .= ' | Редактирование товара';
                $this->metaDescription  = 'Редактирование товара. Продукция и услуги, асфальтобетонный завод ООО ЛАГОС';
                $this->metaKeywords     = 'Редактирование товара, цена, производство, дорожные материалы, асфальтобетонный завод, ООО ЛАГОС';
                $this->pageCanonical    = 'https://lagoc.ru/editproduct?id='.$productId;
                $this->menuItem         = 'editproduct';
                $this->pageHeading      = 'Редактирование товара';

                $product = null;

                if ($productId > 0) {
                    $product = Product:: getProduct($productId);

                    if (!$product) {
                        header('Location: /notfound');
                    }
                } else {
                    header('Location: /notfound');
                }

                $contendData = [
                    'warning' => '',
                    'product' => $product
                ];

                if ($this -> isPost()) {
                    $categoryId         = isset($_POST['categoryid']) ? intval(filter_var(trim($_POST['categoryid']), FILTER_SANITIZE_STRING)) : 1;
                    $productName        = isset($_POST['productname']) ? filter_var(trim($_POST['productname']), FILTER_SANITIZE_STRING) : false;
                    $tabIndex           = isset($_POST['tabindex']) ? intval(filter_var(trim($_POST['tabindex']), FILTER_SANITIZE_STRING)) : 1;
                    $descr              = isset($_POST['descr']) ? filter_var(trim($_POST['descr']), FILTER_SANITIZE_STRING) : false;
                    $unit               = isset($_POST['unit']) ? filter_var(trim($_POST['unit']), FILTER_SANITIZE_STRING) : false;
                    $priceWONDS         = isset($_POST['pricewonds']) ? floatval(filter_var(trim($_POST['pricewonds']), FILTER_SANITIZE_STRING)) : 0;
                    $price              = isset($_POST['price']) ? floatval(filter_var(trim($_POST['price']), FILTER_SANITIZE_STRING)) : 0;
                    $htmlPageTitle      = isset($_POST['htmlpagetitle']) ? filter_var(trim($_POST['htmlpagetitle']), FILTER_SANITIZE_STRING) : false;
                    $htmlMetaDescr      = isset($_POST['htmlmetadescr']) ? filter_var(trim($_POST['htmlmetadescr']), FILTER_SANITIZE_STRING) : false;
                    $htmlMetaKeywords   = isset($_POST['htmlmetakeywords']) ? filter_var(trim($_POST['htmlmetakeywords']), FILTER_SANITIZE_STRING) : false;

                    if (mb_strlen($productName) < 3 || mb_strlen($productName) > 250) {
                        $contendData['warning'] = '<p class="text-danger">Недопустимая длина наименования! Длина должна быть от 3 до 250 символов!</p><hr class="bhr" /><br />';
                        return $contendData;
                    }

                    if (mb_strlen($unit) > 60) {
                        $contendData['warning'] = '<p class="text-danger">Недопустимая длина единицы измерения! Длина должна быть до 60 символов!</p><hr class="bhr" /><br />';
                        return $contendData;
                    }

                    if (mb_strlen($htmlPageTitle) > 250) {
                        $contendData['warning'] = '<p class="text-danger">Недопустимая длина заголовка страницы товара! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                        return $contendData;
                    }

                    if (mb_strlen($htmlMetaDescr) > 250) {
                        $contendData['warning'] = '<p class="text-danger">Недопустимая длина описание страницы товара! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                        return $contendData;
                    }

                    if (mb_strlen($htmlMetaKeywords) > 250) {
                        $contendData['warning'] = '<p class="text-danger">Недопустимая длина ключевые слова страницы товара! Длина должна быть до 250 символов!</p><hr class="bhr" /><br />';
                        return $contendData;
                    }

                    $product = [
                        'productId'         => $productId,
                        'categoryId'        => $categoryId,
                        'productName'       => $productName,
                        'tabIndex'          => $tabIndex,
                        'descr'             => $descr,
                        'unit'              => $unit,
                        'priceWONDS'        => $priceWONDS,
                        'price'             => $price,
                        'htmlPageTitle'     => $htmlPageTitle,
                        'htmlMetaDescr'     => $htmlMetaDescr,
                        'htmlMetaKeywords'  => $htmlMetaKeywords
                    ];

                    $pics = [];
                    $extPics = [];

                    for ($i = 1; $i < 6; $i ++) {
                        if ($_FILES['uploadpic'.$i]) {
                            $pics[] = $_FILES['uploadpic'.$i];
                        }

                        $delPic = $_POST['delpic'.$i];
                        $extPicName = filter_var(trim($_POST['picname'.$i]), FILTER_SANITIZE_STRING);

                        if (!$delPic && !empty($extPicName)) {
                            $extPics[] = $extPicName;
                        }
                    }

                    Product :: editProduct($product);
                    ProductPics ::removePics($productId);

                    if (count($pics) > 0)
                    {
                        $this -> loadProductPics($productId, $pics);
                    }

                    if (count($extPics) > 0)
                    {
                        foreach($extPics as $picName) {
                            ProductPics :: addPic($productId, $picName);
                        }
                    }

                    header('Location: /products');
                } else {
                    return $contendData;
                }
            } else {
                header('Location: /products');
            }
        }

        /**
         * Удаление товара.
         *
         * @param mixed[] $data массив url-параметров.
         */
        function Remove($data)
        {
            if ($_COOKIE['authuserid'] && $_COOKIE['authuser'] && $_COOKIE['authroleid'] && $_COOKIE['authroleid'] == '1') {
                $productId = isset($_GET['id']) ? intval(filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING)) : 0;

                if ($productId > 0) {
                    Product :: removeProduct($productId);
                } else {
                    header('Location: /notfound');
                }

                header('Location: /products');
            } else {
                header('Location: /products');
            }
        }

        /**
         * Загружает на сайт картинки по конкретному товару.
         *
         * @param int $productId ID товара.
         * @param mixed[] $pics Массив картинок.
         * @throws Exception
         */
        private function loadProductPics(int $productId, array $pics)
        {
            foreach ($pics as $pic) {
                if ($pic && isset($pic['name']) && !empty($pic['name'])) {
                    $picName = $pic['name'];
                    $fileSize = $pic['size'];
                    $img = Config :: get('path_public')."/images/products/".$picName;
                    $thumb = Config :: get('path_public')."/images/products/thumbnails/".$picName;
                    $explode = explode(".", $picName);
                    $extension = $explode[sizeof($explode) - 1];

                    if(in_array($extension, ["png", "gif", "jpg", "jpeg"])) {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime = finfo_file($finfo, $pic['tmp_name']);
                        $allowed_mime_types = ["image/jpg", "image/jpeg", "image/gif", "image/png"];
                        if(in_array($mime, $allowed_mime_types)) {
                            if($fileSize < 3*1024*1024) {
                                if(move_uploaded_file($pic['tmp_name'], $img)) {
                                    if ($this -> resizeImage($img, $thumb, 120, 90, $extension)) {
                                        ProductPics :: addPic($productId, $picName);
                                        continue;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        /**
         * Делает resize картинки и записывает ее в указанную папку.
         *
         * @param mixed $file Файл картинки.
         * @param string $newfile Имя нового файла с полным путем.
         * @param int $w Ширина картинки в пикселях.
         * @param int $h Высота картинки в пикселях.
         * @param string $type Тип файла.
         */
        private function resizeImage($file, string $newfile, int $w, int $h, string $type = "jpg") : bool
        {
            list($width, $height) = getimagesize($file);

            if ($type == "png") {
                $src = imagecreatefrompng($file);
            } else if ($type == "gif") {
                $src = imagecreatefromgif($file);
            } else {
                $src = imagecreatefromjpeg($file);
            }

            $dst = imagecreatetruecolor($w, $h);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);

            if ($type == "png") {
                imagepng($dst, $newfile);
            } else if ($type == "gif") {
                imagegif($dst, $newfile);
            } else {
                imagejpeg($dst, $newfile, 80);
            }

            imagedestroy($dst);

            return true;
        }
    }

