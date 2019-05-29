<?php
session_start();
$sTitle = 'MeetMe Account';
require_once './components/top.php';

if ($_SESSION['user']['isAdmin'] == 1) {
    header('Location: admin.php');
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
                <p class="small text-muted" style="text-align: right; display: inline-block;">Welcome ' . $_SESSION['user']['userName'] . '! </p>
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
            $sQuery = $db->prepare('SELECT * FROM meetme_user WHERE isAdmin = 0 AND active = 1 ORDER BY timeAdded desc');
            $sQuery->execute();
            $aUsers = $sQuery->fetchAll();
            foreach ($aUsers as $user) {

                // ' . htmlentities($message['userName']) . '

                if ($user['id'] == $_SESSION['user']['id']) {

                    echo '<div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="card text-white bg-dark mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-sm-2">
                                                <img src="'.htmlentities($user['profileImage']).'" class="card-img" alt="MeetMe Profile Image">
                                            </div>
                                            <div class="col-md-10">
                                                <div class="card-body">
                                                    <h5 class="card-title">' . ($user['userGender'] == 1 ?
                            "<i class='fas fa-male' style='color: #bf0116;'></i>" :
                            "<i class='fas fa-female' style='color: #bf0116;'></i>") . ' ' . htmlentities($user['userName']) . '\'s Account Details</h5>
                                                    <hr  style="background-color: #808080;">
                                                    <p class="card-text small">Age: ' . htmlentities($user['age']) . '</p>                                
                                                    <p class="card-text small" style="margin-top: -15px;">E-mail: ' . htmlentities($user['email']) . '</p> 
                                                    <p class="card-text small" style="margin-top: -15px;">Looking for: ' . ($user['chooseGender'] == 1 ? "MAN" : "WOMEN") . '</p>
                                                    <hr  style="background-color: #808080;">
                                                    <p class="card-text">' . htmlentities($user['bio']) . '</p>                               
                                                    <p class="card-text small text-muted">Registered: ' . $user['timeAdded'] . '</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <br><br><h4>' . $user['userName'] . ', they are waiting for you...</h4><br>
                        </div>';
                }
            }

            foreach ($aUsers as $user) {
                if ($user['id'] != $_SESSION['user']['id']) {

                    echo '<div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card text-white bg-dark mb-3" id="' . $user['id'] . '">                
                                <a href="message.php?id=' . $user['id'] . '">
                                    <img src="' . htmlentities($user['profileImage']) . '" class="card-img-top" alt="MeetMe Profile Image"></a>
                                <div class="card-body">
                                    <h5 class="card-title">' . ($user['userGender'] == 1 ?
                            "<i class='fas fa-male' style='color: #bf0116;'></i>" :
                            "<i class='fas fa-female' style='color: #bf0116;'></i>") . ' ' . $user['userName'] . '</h5>
                                    <p class="card-text small">Looking for: ' . ($user['chooseGender'] == 1 ? "MAN" : "WOMEN") . '</p>
                                    <p class="card-text small text-muted" style="margin-top: -15px;">Registered: ' . $user['timeAdded'] . '</p>
                                </div>
                            </div>
                         </div>';
                }
            }

        } catch (PDOException $e) {
            http_response_code(500);
        }
        ?>

    </div>
</div>

<script src="jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>
</html>