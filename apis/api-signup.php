<?php
session_start();
if (!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    echo '{"status":"Security Error"}';
    exit();
}

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
    !(strlen($_POST['bio']) >= 10 && strlen($_POST['bio']) <= 275) ||
    !(strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 20) ||
    !($_POST['age'] >= 18 && $_POST['age'] <= 100) ||

    !(preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,20}$/', $_POST['password'])) ||

    !($_POST['password'] === $_POST['confirmPassword'])) {
    http_response_code(400);
    echo "";
    exit;
}

$passwordRegister = $_POST['password'];
$salt = password_hash(uniqid(), PASSWORD_DEFAULT);
$staticPeper = "dfdfswewegggfsdo034340fsfg3443213";
$hashed_password = hash("sha256", $passwordRegister . "my_secret" . $salt . $staticPeper);

$sActivationKey = password_hash(uniqid(), PASSWORD_DEFAULT);

        require_once '../database.php';
        $db->beginTransaction();
        try {
            $sQueryUniqueEmail = $db->prepare('SELECT email FROM meetme_user WHERE email = :sEmail');
            $sQueryUniqueEmail->bindValue(':sEmail', $_POST['email']);
            $sQueryUniqueEmail->execute();
            $sQueryUniqueEmail->fetchAll();

            if ($sQueryUniqueEmail->rowCount()) {
                http_response_code(400);
                echo "This email is already taken";
            } else {
                $sQuery = $db->prepare('INSERT INTO meetme_user (`userName`, `email`, `password`, `salt`, `age`, `userGender`, `chooseGender`, 
                  `profileImage`, `bio`, `activationKey`, `active`, `numberOfFailedAttempts`, `timeOfAccountLock`, `isAdmin`)
                            VALUES (:sUserName, :sEmail, :sPassword, :sSalt, :iAge, :bUserGender, :bChooseGender, :profileImage, :sBio, 
                                    :sActivationKey, :bActive, :iNumberOfFailedAttempts, :timeOfAcountLock, :bIsAdmin)');

                $sQuery->bindValue(':sUserName', $_POST['userName']);
                $sQuery->bindValue(':sEmail', $_POST['email']);
                $sQuery->bindValue(':sPassword', $hashed_password);
                $sQuery->bindValue(':sSalt', $salt);
                $sQuery->bindValue(':iAge', $_POST['age']);
                $sQuery->bindValue(':bUserGender', $_POST['userGender']);
                $sQuery->bindValue(':bChooseGender', $_POST['chooseGender']);
                $sQuery->bindValue(':profileImage', null);
                $sQuery->bindValue(':sBio', $_POST['bio']);
                $sQuery->bindValue(':sActivationKey', $sActivationKey);
                $sQuery->bindValue(':bActive', 0);
                $sQuery->bindValue(':iNumberOfFailedAttempts', 0);
                $sQuery->bindValue(':timeOfAcountLock', null);
                $sQuery->bindValue(':bIsAdmin', 0);

                $sQuery->execute();
                $db->commit();

                if ($sQuery->rowCount()) {
                    echo '{"status":"Good job!"}';

/*                            $to = $_POST['email'];
                            $subject = 'MeetMe Activation Key';
                            $message = 'Your Activation Key is: '.$sActivationKey;
                            $email = mail($to, $subject, $message);*/


//  todo   https://forums.phpfreaks.com/topic/136585-solved-mail-command-takes-a-long-time-to-finish/
                    // we can always issue an 'at' command to run this mail command



                    exit;
                }
            }

        } catch (PDOException $e) {
            http_response_code(500);
            $db->rollBack();
        }




