<?php
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
$salt = 71;
$staticPeper = "dfdfswewegggfsdo034340fsfg3443213";
$hashed_password = hash("sha256", $passwordRegister . "my_secret" . $salt . $staticPeper);

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

    // select non-blocked user
    $sQuery = $db->prepare('SELECT * FROM meetme_user WHERE email = :sEmail and password = :sPassword 
                            AND (timeOfAccountLock is null or now() > timeOfAccountLock + INTERVAL 3 MINUTE)');
    $sQuery->bindValue(':sEmail', $sEmail);
    $sQuery->bindValue(':sPassword', $hashed_password);
    $sQuery->execute();
    $sQuery->fetchAll();

    if ($sQuery->rowCount()) {
        echo '{"status":"You are logged in"}';
        exit;
    }else{
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
    if ($sQueryLock->rowCount()){
        http_response_code(400);
        echo "You have to wait for 3 min for the next login attempt.";
    }

} catch (PDOException $e) {
    file_put_contents('log.txt', "error: $e", FILE_APPEND);
    echo '{"status":500, "message":"error", "code":"001", "line":' . __LINE__ . '}';
}

