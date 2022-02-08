<?php
    require_once 'autoload.php';

    try{
        App::init();
    }
    catch (PDOException $ex){
        echo "DB is not available";
        var_dump($ex -> getTrace());
    }
    catch (Exception $ex){
        echo $ex -> getMessage();
    }
