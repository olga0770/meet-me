<?php
session_start();
$sTitle = 'MeetMe Admin';
require_once './components/top.php';

if ($_SESSION['user']['isAdmin'] != 1) {
    header('Location: index.php');
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
                <p class="small text-muted" style="text-align: right; display: inline-block;">Welcome Admin ' . $_SESSION['user']['userName'] . '! </p>
                <img src="' . $_SESSION['user']['profileImage'] . '" style="width: 30px; height: 30px; border-radius: 20px;" /></div>
                    <hr style="background-color: #505050; margin-top: 0;">
                </div>
            </div>
        </div>';
}
?>

    <div class="container">
        <div class="row">

            <?php
            require_once 'database.php';
            try {
                $sQuery = $db->prepare('SELECT * FROM meetme_user WHERE isAdmin = 0 ORDER BY timeAdded desc');
                $sQuery->execute();
                $aUsers = $sQuery->fetchAll();

                foreach ($aUsers as $user) {

                        echo '<div id="'.$user['id'].'" class="col-sm-12 userObject">
                                    <div class="card text-white bg-dark mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-sm-2">
                                                <img src="'.htmlentities($user['profileImage']).'" class="card-img" alt="MeetMe Profile Image">
                                            </div>
                                            <div class="col-md-10">
                                                <div class="card-body">
                                                    <h5 class="card-title">' . ($user['userGender'] == 1 ?
                                "<i class='fas fa-male' style='color: #bf0116;'></i>" :
                                "<i class='fas fa-female' style='color: #bf0116;'></i>").' '.$user['userName'].'</h5>
                                                    <hr  style="background-color: #808080;">
                                                    <p class="card-text small">Age: '.$user['age'].'</p>                                
                                                    <p class="card-text small" style="margin-top: -15px;">E-mail: '.$user['email'].'</p> 
                                                    <p class="card-text small" style="margin-top: -15px;">
                                                        Looking for: '.($user['chooseGender'] == 1 ? "MAN" : "WOMEN") . '</p>
                                                    <hr  style="background-color: #808080;">
                                                    <p class="card-text">'.htmlentities($user['bio']).'</p>
                                                    <p class="card-text">User is activated: '.($user['active'] == 1 ? "YES" : "NO") . '</p>                               
                                                    <p class="card-text small text-muted">Registered: '.$user['timeAdded'].'</p>                                                                                                        
                                                    <div>' . ($user['active'] == 1 ?
                                "<button  type='button' class='btn btn-primary btnDeactivate'>Deactivate</button>" :
                                "<button  type='button' class='btn btn-primary btnActivate'>Activate</button>").'                                                   
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }

            } catch (PDOException $e) {
                http_response_code(500);
            }
            ?>

        </div>
    </div>

<?php
$sScript = 'admin.js';
require_once './components/bottom.php';