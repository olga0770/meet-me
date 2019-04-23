<?php

if (
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
    !filter_var($_POST['password'], FILTER_SANITIZE_STRING) ||
    !(strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 20)) {
    http_response_code(400);
    echo '{"error":"1Something went wrong. Try login again."}';
    exit;
}

$passwordRegister = $_POST['password'];
$salt = 71;
$staticPeper = "dfdfswewegggfsdo034340fsfg3443213";
$hashed_password = hash("sha256", $passwordRegister . "my_secret" . $salt . $staticPeper);


require_once '../database.php';
try {
    $sQuery = $db->prepare('SELECT * FROM meetme_user WHERE email = :sEmail and password = :sPassword');
    $sQuery->bindValue(':sEmail', $_POST['email']);
    $sQuery->bindValue(':sPassword', $hashed_password);

    $sQuery->execute();
    $sQuery->fetchAll();

    if ($sQuery->rowCount()) {
        echo '{"error":"You are logged in"}';
        exit;
    }
    http_response_code(400);
    echo '{"error":"2Something went wrong. Try login again."}';






} catch (PDOException $e) {
    file_put_contents('log.txt', "error: $e", FILE_APPEND);
    echo '{"status":500, "message":"error", "code":"001", "line":' . __LINE__ . '}';
}

