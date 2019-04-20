<?php

// guard clauses:
file_put_contents('logtest.txt', "execute-00\n", FILE_APPEND);

if (empty($_POST['userName'])) {
    http_response_code(400);
    exit;
}

file_put_contents('logtest.txt', "execute-01\n", FILE_APPEND);

if (!(strlen($_POST['userName']) >= 3 && strlen($_POST['userName']) <= 20)) {
    http_response_code(400);
    echo json_encode(array("error"=>"error!", "hi"=>"ho"));
    exit;
}

file_put_contents('logtest.txt', "execute-02\n", FILE_APPEND);


require_once 'database.php';

try {
    file_put_contents('logtest.txt', "execute-1\n", FILE_APPEND);
    $sQuery = $db->prepare('INSERT INTO test (`userName`) VALUES (:sUserName)');
    $sQuery->bindValue(':sUserName', $_POST['userName']);
    $sQuery->execute();

    file_put_contents('logtest.txt', "execute-10\n", FILE_APPEND);


    if ($sQuery->rowCount()) {
        echo '{"status":200, "message":"success"}';
        exit;
    }
    http_response_code(400);

    echo json_encode(array("data"=>"hello", "error"=>""));


} catch (PDOException $e) {
    echo json_encode(array("error"=>"error", "code"=> $e->getCode(), "message"=>$e->getMessage()));
    http_response_code(500);
}
