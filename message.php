<?php
session_start();
$sTitle = 'MeetMe Message';
require_once './components/top.php';


if($_SESSION['user']['id'] == $_GET['id']){
    header('Location: account.php');
    exit;
}

if($_GET['id'] == 3){
    header('Location: account.php');
    exit;
}

if (!$_SESSION['user']) {
    header('Location: login.php');
    exit;
} else {
    echo '<div class="container" style="margin-top: 15px;">
            <div class="row">
                <div class="col-12">
                <div style="text-align: right;">
                <a href="account.php">
                <p class="small text-muted" style="text-align: right; display: inline-block;">Welcome ' . $_SESSION['user']['userName'] . '! </p></a>
                <img src="' . $_SESSION['user']['profileImage'] . '" style="width: 30px; height: 30px; border-radius: 20px;" /></div>
                    <hr style="background-color: #505050; margin-top: 0;">
                </div>
            </div>
        </div>';
}

$iFriendId = $_GET['id'];
$sToken = hash('sha256', rand() . 'secret');
$_SESSION['csrf_token'] = $sToken;

require_once 'database.php';
try {
    $sQuery = $db->prepare('SELECT * FROM meetme_user WHERE id = :id AND isAdmin = 0');
    $sQuery->bindValue(':id', $iFriendId);
    $sQuery->execute();
    $aUsers = $sQuery->fetchAll();
    foreach ($aUsers as $user) {
        echo '
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <img src="' . htmlentities($user['profileImage']) . '" class="card-img" alt="MeetMe Profile Image">
                    </div>
                    <div class="col-md-9">
                                <h5 class="card-title">' . ($user['userGender'] == 1 ?
                "<i class='fas fa-male' style='color: #bf0116;'></i>" :
                "<i class='fas fa-female' style='color: #bf0116;'></i>") . ' ' . $user['userName'] . '</h5>
                                <p class="card-text small">Age: ' . $user['age'] . '</p>                                
                                <p class="card-text small" style="margin-top: -15px;">Looking for: ' . ($user['chooseGender'] == 1 ? "MAN" : "WOMEN") . '</p>
                                <p class="card-text">' . htmlentities($user['bio']) . '</p>                               
                                <p class="card-text small text-muted">Registered: ' . $user['timeAdded'] . '</p>
                    </div>
                </div>
                <hr style="background-color: #505050;">
            </div>';
    }
} catch (PDOException $e) {
    http_response_code(500);
}

?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6">
                <form id="formMessage">

                    <div class="form-group">
                        <p class="small" style="color: #bf0116; margin-bottom: 0;">* These fields are required</p>
                        <label for="message"><i class="fas fa-sticky-note" style="color: #bf0116;"></i> Message
                            *</label>
                        <textarea id="message" name="message" class="form-control"
                                  placeholder="Message (3 to 300 characters)"
                                  rows="3" required></textarea>
                        <span class="errorMessage" style="color: #bf0116;"></span>
                    </div>
                    <input id="toUserId" name="friendId" class="form-control" type="number" hidden
                           value="<?php echo $iFriendId ?>">
                    <input id="fromUserId" name="yourId" class="form-control" type="number" hidden
                           value="<?php echo $_SESSION['user']['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>">
                    <button type="submit" class="btn btn-primary"> SUBMIT </button>
                </form>
            </div>
        </div>
    </div><br><br>
<?php

try {
    $sQuery = $db->prepare('SELECT m.message, m.friendId, m.yourId, m.timeWritten, u.userName
        FROM meetme_message AS m 
        JOIN meetme_user AS u on u.id = m.yourId
        ORDER BY m.timeWritten desc');
    $sQuery->execute();
    $aMessages = $sQuery->fetchAll();

    foreach ($aMessages as $message) {

        $sMessage = '<div class="row no-gutters">                        
                        <div class="col-12">
                            <div class="card-body">
                                <span style="color: #bf0116;">' . htmlentities($message['userName']) . ': </span>
                                <span>' . htmlentities($message['message']) . '</span>                              
                                <p class="card-text small" style="text-align: right;">' . htmlentities($message['timeWritten']) . '</p>
                            </div>
                        </div>
                    </div>';

        if ($message['yourId'] == $iFriendId && $message['friendId'] == $_SESSION['user']['id']) {
            echo '<div class="container">
                        <div class="row justify-content-start">
                            <div class="col-11">
                                <div class="card text-white bg-dark mb-3">
                                    ' . $sMessage . '
                                </div>
                            </div>
                        </div>
                    </div>';

        } elseif ($message['yourId'] == $_SESSION['user']['id'] && $message['friendId'] == $iFriendId) {
            echo '<div class="container">
                        <div class="row justify-content-end">
                            <div class="col-11">
                                <div class="card text-white bg-secondary mb-3">
                                    ' . $sMessage . '
                                </div>
                            </div>
                        </div>
                    </div>';
        }
    }

} catch (PDOException $ex) {
    http_response_code(500);
}

$sScript = 'message.js';
require_once './components/bottom.php';

