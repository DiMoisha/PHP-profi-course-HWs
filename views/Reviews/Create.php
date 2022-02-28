<?php
    function CreateView() {
        return '<div class="row">
                    <div class="col-md-9">
                        <section id="feedbackForm">
                            <form action="/server/reviews.php" method="post" class="form-horizontal" role="form" enctype = "multipart/form-data">
                                <p class="text-info text-center">
                                    У вас есть вопросы, замечания по нашей работе или товарам и вы хотите оставить отзыв?<br />
                                    Пожалуйста, воспользуйтесь формой, расположенной ниже.
                                </p>
                                <br>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="UserName">Ваше имя</label>
                                    <div class="col-md-9">
                                        <input type="text" name="UserName" class="form-control" id="UserName" placeholder="Ваше имя">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="Email">Ваш e-mail</label>
                                    <div class="col-md-9">
                                        <input type="email" name="Email" class="form-control" id="Email" placeholder="ваш e-mail">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="ReviewText">Ваш отзыв</label>
                                    <div class="col-md-9">
                                        <textarea class = "form-control multi-line" rows = "3" name="ReviewText" id="ReviewText"></textarea>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <p align="center">
                                    <input class="actionButtons btn btn-xs-sm-md btn-success" type="submit" value="Оставить отзыв" />
                                </p>
                            </form>
                        </section>
                    </div>
                </div>';
    }