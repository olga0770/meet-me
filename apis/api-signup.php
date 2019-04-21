<?php
if (empty($_POST['userName']) ||
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    empty($_POST['confirmPassword']) ||
    empty($_POST['age']) ||
    empty($_POST['bio']) ||

    !isset($_POST['userGender']) ||
    !isset($_POST['chooseGender']) ||

    !filter_var($_POST['userName'], FILTER_SANITIZE_STRING) ||
    !filter_var($_POST['bio'], FILTER_SANITIZE_STRING) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
    !filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT) ||

    !(strlen($_POST['userName']) >= 3 && strlen($_POST['userName']) <= 20) ||
    !(strlen($_POST['bio']) >= 10 && strlen($_POST['bio']) <= 100) ||
    !(strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 20) ||
    !($_POST['age'] >= 18 && $_POST['age'] <= 100) ||

    !($_POST['password'] == $_POST['confirmPassword'])) {
    http_response_code(400);
    echo '{"error":""}';
    // file_put_contents('log.txt', "1post\n", FILE_APPEND);
    exit;
}

$passwordRegister = $_POST['password'];
$salt = 71;
$staticPeper = "dfdfswewegggfsdo034340fsfg3443213";
$hashed_password = hash("sha256", $passwordRegister . "my_secret" . $salt . $staticPeper);

$sActivationKey = password_hash(uniqid(), PASSWORD_DEFAULT);
// file_put_contents('log.txt', "2password-activationKey\n", FILE_APPEND);

require_once '../database.php';
$db->beginTransaction();
try {

    $sQueryUniqueEmail = $db->prepare('SELECT email FROM user WHERE email = :sEmail');
    $sQueryUniqueEmail->bindValue(':sEmail', $_POST['email']);
    $sQueryUniqueEmail->execute();
    $sQueryUniqueEmail->fetchAll();

    if ($sQueryUniqueEmail->rowCount()) {
        http_response_code(400);
        // echo json_encode(array("error" => "This email is already taken"));
        echo '{"error":"This email is already taken"}';
    } else {

        $sQuery = $db->prepare('INSERT INTO user (`userName`, `email`, `password`, `age`, `userGender`, `chooseGender`, 
                  `profileImage`, `bio`, `activationKey`, `active`, `numberOfFailedAttempts`, `timeOfAcountLock`)
                            VALUES (:sUserName, :sEmail, :sPassword, :iAge, :bUserGender, :bChooseGender, :profileImage, :sBio, 
                                    :sActivationKey, :bActive, :iNumberOfFailedAttempts, :timeOfAcountLock)');

        $sQuery->bindValue(':sUserName', $_POST['userName']);
        $sQuery->bindValue(':sEmail', $_POST['email']);
        $sQuery->bindValue(':sPassword', $hashed_password);
        $sQuery->bindValue(':iAge', $_POST['age']);
        $sQuery->bindValue(':bUserGender', $_POST['userGender']);
        $sQuery->bindValue(':bChooseGender', $_POST['chooseGender']);
        $sQuery->bindValue(':profileImage', null);
        $sQuery->bindValue(':sBio', $_POST['bio']);
        $sQuery->bindValue(':sActivationKey', $sActivationKey);
        $sQuery->bindValue(':bActive', 0);
        $sQuery->bindValue(':iNumberOfFailedAttempts', 0);
        $sQuery->bindValue(':timeOfAcountLock', null);

        file_put_contents('log.txt', "3bind\n", FILE_APPEND);

        $sQuery->execute();
        $db->commit();
        file_put_contents('log.txt', "4execute\n", FILE_APPEND);

        if ($sQuery->rowCount()) {
            echo '{"status":200, "message":"success"}';

            /*        $to = $_POST['email'];
                    $subject = 'MeetMe Activation Key';
                    $message = 'Your Activation Key is: '.$sActivationKey;
                    $email = mail($to, $subject, $message);*/

            // file_put_contents('log.txt', "5rowcount\n", FILE_APPEND);
            exit;
        }
    }

} catch (PDOException $e) {
    http_response_code(500);
    file_put_contents('log.txt', "error: $e", FILE_APPEND);
    echo '{"status":500, "message":"error", "code":"001", "line":' . __LINE__ . '}';
    $db->rollBack();
}


