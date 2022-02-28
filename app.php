<?php
	require_once 'autoload.php';

	try {
        App :: init();
	}
    catch (PDOException $ex) {
        echo "Ошибка доступа к базе данных!";
    		//var_dump($ex -> getTrace());
	}
    catch (Exception $ex) {
        echo $ex -> getMessage();
	}