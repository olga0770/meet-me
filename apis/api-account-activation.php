<?php

if( empty($_POST['key']) || (strlen($_POST['key'])) !== 60 ){
    http_response_code(400);
    exit;
}

require_once '../database.php';

try{

    $sQuery = $db->prepare('UPDATE user SET active = 1
                            WHERE activationKey = :sKey');
    $sQuery->bindValue(':sKey', $_POST['key']);
    $sQuery->execute();

    if( $sQuery->rowCount() ){
        echo '{"status":1, "message":"you are activated"}';
        exit;
    }
    http_response_code(400);

}catch(PDOException $ex){
    http_response_code(500);
}
