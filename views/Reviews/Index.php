<?php
    function IndexView($reviews) {
        if (count($reviews) < 1) {
            $list = "<p><strong>Отзывов пока нет!</strong></p>";
        } else {     
            $list = "";
            foreach  ($reviews as $item) {
                $list .= '<div class="content-item review-item">
                            <p class="item-name review-username"><strong>'.$item -> userName.' ('.$item -> userEmail.')</strong></p>
                            <p class="review-text">&nbsp;&nbsp;&nbsp;'.$item -> reviewText.'</p>
                            <br>
                            <p class="item-name review-insdate cl-darkgey"><strong>'.$item -> insDate.'</strong></p>
                        </div>';
            }
        }

        return '<div>
                    <span class="cl-darkgey"><b>Количество отзывов - '.count($reviews).'</b></span>
                    <div class="pull-right">
                        <a href="/addreview" class="btn btn-xs-sm-md btn-success" role="button" title="Оставить отзыв">Оставить отзыв</a>
                    </div>
                </div>
                <hr>
                <div class="container-fluid content-item-list review-list">'.$list.'</div>
                <br>
                <div>
                    <div class="pull-right">
                        <a href="/addreview" class="btn btn-xs-sm-md btn-success" role="button" title="Оставить отзыв">Оставить отзыв</a>
                    </div>
                </div>';
    }