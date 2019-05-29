<?php
session_start();
require_once '../database.php';

if (!$_SESSION['user']) {
    exit;
}

try{
    $sQuery = $db->prepare('UPDATE meetme_user SET active = 0 WHERE id = :id');
    $sQuery->bindValue(':id', $_GET['id']);
    $sQuery->execute();

    if( !$sQuery->rowCount() ){
        echo '{"status":0, "message":"could not deactivate user"}';
        exit;
    }
    echo '{"status":1, "message":"user deactivated"}';

}catch(PDOException $ex){
    http_response_code(500);
}