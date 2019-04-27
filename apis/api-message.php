<?php
session_start();
require_once '../database.php';

if (
    empty($_POST['message']) ||
    !filter_var($_POST['message'], FILTER_SANITIZE_STRING) ||
    !(strlen($_POST['message']) >= 3 && strlen($_POST['message']) <= 300)) {
    http_response_code(400);
    echo 'Must be from 3 to 300 characters. ';
    exit;
}

if (!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    echo '{"status":"Security Error"}';
    exit();
}

try {
    $sQuery = $db->prepare('INSERT INTO meetme_message (`message`, `friendId`, `yourId`)
                            VALUES (:sMessage, :iFriendId, :iYourId)');

    $sQuery->bindValue(':sMessage', $_POST['message']);
    $sQuery->bindValue(':iFriendId', $_POST['friendId']);
    $sQuery->bindValue(':iYourId', $_POST['yourId']);
    $sQuery->execute();

    if ($sQuery->rowCount()) {
        echo '{"status":"Good job!"}';
        exit;
    }

} catch (PDOException $e) {
    http_response_code(500);
}