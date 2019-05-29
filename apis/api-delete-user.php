<?php
session_start();
require_once '../database.php';

if (!$_SESSION['user']) {
    exit;
}
    try {
        $sQuery = $db->prepare('DELETE FROM meetme_user WHERE id = :id');
        $sQuery->bindValue(':id', $_GET['id']);
        $sQuery->execute();

        if (!$sQuery->rowCount()) {
            echo '{"status":0, "message":"could not delete user"}';
            exit;
        }
        echo '{"status":1, "message":"user deleted"}';

    } catch (PDOException $ex) {
        http_response_code(500);
    }

