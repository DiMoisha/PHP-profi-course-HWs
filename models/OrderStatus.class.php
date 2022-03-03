<?php
    namespace App\Models\Order;

    class OrderStatus
    {
        const Deleted = 0;
        const Active = 1;
        const Inactive = 2;
        const Payed = 3;
        const Delivered = 4;
    }