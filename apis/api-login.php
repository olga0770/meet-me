<?php
session_start();
if (!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    echo '{"status":"Security Error"}';
    exit();
}
if (
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
    !filter_var($_POST['password'], FILTER_SANITIZE_STRING) ||
    !(strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 20)) {
    http_response_code(400);
    echo "Something went wrong. ";
    exit;
}
$sEmail = $_POST['email'];
$passwordRegister = $_POST['password'];
$staticPeper = "dfdfswewegggfsdo034340fsfg3443213";

require_once '../database.php';
try {
    // first reset the lock if applicable
    $sQueryAttempt = $db->prepare('UPDATE meetme_user
                      SET timeOfAccountLock = null,
                          numberOfFailedAttempts = 0
                      WHERE email = :sEmail and timeOfAccountLock is not null 
                        and now() > timeOfAccountLock + INTERVAL 3 MINUTE');
    $sQueryAttempt->bindValue(':sEmail', $sEmail);
    $sQueryAttempt->execute();


    $sQuerySalt = $db->prepare('SELECT salt FROM meetme_user WHERE email = :sEmail');
    $sQuerySalt->bindValue(':sEmail', $sEmail);
    $sQuerySalt->execute();
    $aSalts = $sQuerySalt->fetchAll();

    foreach ($aSalts as $salt) {
        $userSalt = $salt['salt'];
    }
    $hashed_password = hash("sha256", $passwordRegister . "my_secret" . $userSalt . $staticPeper);

    // select non-blocked user
    $sQuery = $db->prepare('SELECT * FROM meetme_user 
      WHERE email = :sEmail and password = :sPassword and salt = :sSalt 
      AND (timeOfAccountLock is null or now() > timeOfAccountLock + INTERVAL 3 MINUTE)');
    $sQuery->bindValue(':sEmail', $sEmail);
    $sQuery->bindValue(':sPassword', $hashed_password);
    $sQuery->bindValue(':sSalt', $userSalt);

    $sQuery->execute();
    $aUsers = $sQuery->fetchAll();

    if (count($aUsers)) {
        //session_start();
        $_SESSION['user'] = $aUsers[0];
        echo '{"status":1, "message":"login success"}';
        exit;

    } else {
        http_response_code(400);
        echo "Something went wrong. ";

        $sQueryAttempt = $db->prepare('UPDATE meetme_user 
                      SET timeOfAccountLock = if(numberOfFailedAttempts < 2, null, now()),
                          numberOfFailedAttempts = numberOfFailedAttempts + 1
                      WHERE email = :sEmail and timeOfAccountLock is null');
        $sQueryAttempt->bindValue(':sEmail', $sEmail);
        $sQueryAttempt->execute();
        http_response_code(400);
    }

    $sQueryLock = $db->prepare('select * from meetme_user where numberOfFailedAttempts = 3');
    $sQueryLock->execute();
    $sQueryLock->fetchAll();
    if ($sQueryLock->rowCount()) {
        http_response_code(400);
        echo "You have to wait for 3 min for the next login attempt.";
    }

} catch (PDOException $e) {
    http_response_code(500);
}

