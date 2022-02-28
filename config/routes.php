<?php
    const ROUTES = [
        ''              => ['Home', 'Index'],
        'home'          => ['Home', 'Index'],
        'about'         => ['Home', 'About'],
        'calculator'    => ['Home', 'Calculator'],
        'contact'       => ['Home', 'Contact'],
        'news'          => ['Home', 'News'],
        'pricelist'     => ['Home', 'Pricelist'],

        'register'      => ['Account', 'Register'],
        'login'         => ['Account', 'Login'],
        'logout'        => ['Account', 'Logout'],
        'edituser'      => ['Account', 'Edit'],
        'removeuser'    => ['Account', 'Remove'],
        'lk'            => ['Account', 'Index'],

        'products'      => ['Product', 'Index'],
        'product'       => ['Product', 'Product'],
        'addproduct'    => ['Product', 'Create'],
        'editproduct'   => ['Product', 'Edit'],
        'removeproduct' => ['Product', 'Remove'],

        'cart'          => ['Cart', 'Index'],
        'addtocart'     => ['Cart', 'Add'],
        'delfromcart'   => ['Cart', 'Remove'],
        'editcart'      => ['Cart', 'Edit'],

        'checkout'      => ['Order', 'Checkout'],
        'orders'        => ['Order', 'Index']
    ];