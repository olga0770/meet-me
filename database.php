<?php

try {
    $sUserName = 'root';
    $sPassword = '';
    $sConnection = "mysql:host=localhost; dbname=meet_me; charset=utf8mb4";

    $aOptions = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $db = new PDO($sConnection, $sUserName, $sPassword, $aOptions);

} catch (PDOException $e) {
    echo '{"status":"err","message":"cannot connect to database"}';
    exit();
}



/*try{
    $sUserName = 'i55689';
    $sPassword = 'Ch93Q9vCBe';
    $sConnection = "mysql:host=localhost; dbname=i55689_01; charset=utf8mb4";

    $aOptions = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $db = new PDO( $sConnection, $sUserName, $sPassword, $aOptions );

}catch( PDOException $e){
    echo '{"status":"err","message":"cannot connect to database"}';
    exit();
}*/