<?php
session_start();
if(!isset($_SESSION["user"]))
    exit();
$sTitle = 'MeetMe Signup';
require_once './components/top.php';
?>

    <div class="container">

        <br>
        <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>
        <hr style="background-color: #bf0116;">
        <h2>Make a profile:</h2>
        <p class="small" style="color: #bf0116;">* These fields are required</p>

        <form id="formSignup" action="signup-new.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"] ?>">

            <div class="row">
                <div class="col-12 col-md-6">

                    <div class="form-group">
                        <label for="userName"><i class="fas fa-user" style="color: #bf0116;"></i> User Name *</label>
                        <input id="userName" name="userName" class="form-control" type="text"
                               placeholder="User Name (3 to 20 characters)" required
                               value="<?php if (!empty($_POST['userName'])) {echo htmlentities($_POST['userName']);} ?>">
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope" style="color: #bf0116;"></i> E-mail *</label>
                        <input id="email" name="email" class="form-control" type="email" placeholder="E-mail"
                               required value="<?php if (!empty($_POST['email'])) {echo htmlentities($_POST['email']);} ?>">
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Create Password *</label>
                        <input id="password" name="password" class="form-control" type="password"
                               placeholder="Create Password (8 to 20 characters)" required
                               value="<?php if (!empty($_POST['password'])) {echo htmlentities($_POST['password']);} ?>">
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Confirm
                            Password *</label>
                        <input id="confirmPassword" name="confirmPassword" class="form-control" type="password"
                               placeholder="Confirm Password" required
                               value="<?php if (!empty($_POST['confirmPassword'])) {echo htmlentities($_POST['confirmPassword']);} ?>">
                    </div>
                </div>

                <div class="col-12 col-md-6">

                    <div class="form-group">
                        <label for="age"> <i class="fas fa-birthday-cake" style="color: #bf0116;"></i> Age *</label>
                        <input id="age" name="age" class="form-control" type="number" placeholder="Age" required
                               value="<?php if (!empty($_POST['age'])) {echo htmlentities($_POST['age']);} ?>">
                    </div>

                    <div class="form-group">
                        <label for="userGender"><i class="fas fa-male" style="color: #bf0116;"></i>
                            <i class="fas fa-female" style="color: #bf0116;"></i> Gender *</label>
                        <select name="userGender" class="form-control">
                            <option value=1>Man</option>
                            <option value=0 selected>Woman</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="chooseGender"><i class="fas fa-male" style="color: #bf0116;"></i><i
                                class="fas fa-female" style="color: #bf0116;"></i> I'm looking for *</label>
                        <select name="chooseGender" class="form-control">
                            <option value=1 selected>Man</option>
                            <option value=0>Woman</option>
                        </select>
                    </div>

<!--                    <div class="form-group">
                        <label for="profileImage"><i class="fas fa-image" style="color: #bf0116;">
                            </i> Upload your profile image * (.jpg, .png, max 500KB)</label><br>
                        <label class="btn btn-outline-primary btn-block"> Choose file
                            <input type="file" name="file" required hidden></label>
                    </div>-->

                </div>
            </div>

            <br>
            <div class="form-group">
                <label for="bio"><i class="fas fa-file-alt" style="color: #bf0116;"></i> Bio *</label>
                <textarea id="bio" name="bio" class="form-control" placeholder="Bio (10 to 275 characters)"
                          rows="3" required><?php if (!empty($_POST['bio'])) {echo $_POST['bio'];} ?></textarea>
            </div>
            <hr style="background-color: #bf0116;">

            <br><input type="submit" class="btn btn-primary btn-lg" value="   SIGN UP   ">
        </form>

<!--        <div class="container">
            <div class="row">
                <div class="col-12">
                    <hr style="color: #bf0116;">
                <p style="color: #bf0116; margin-left: 15px;"><?php /*if (!empty($error)) {echo $error;} */?></p>
            </div>
        </div>
    </div>-->

    </div>
    <br>

    <script src="jquery-3.3.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>


    </body>
    </html>



<?php
if (!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    echo '{"status":"Security Error"}';
    exit;
}


if (empty($_POST['userName']) ||
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    empty($_POST['confirmPassword']) ||
    empty($_POST['age']) ||
    empty($_POST['bio']) ||
    !isset($_POST['userGender']) ||
    !isset($_POST['chooseGender'])) {
    http_response_code(400);
    exit;
}

if (!(strlen($_POST['userName']) >= 3 && strlen($_POST['userName']) <= 20)){
    echo '<li style="color: #bf0116; text-align: center;">User Name must be from 3 to 20 characters</li>';
    http_response_code(400);
}

if (!(strlen($_POST['bio']) >= 10 && strlen($_POST['bio']) <= 275)){
    echo '<li style="color: #bf0116; text-align: center;">Bio must be from 10 to 275 characters</li>';
    http_response_code(400);
}

if (!(strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 20)){
    echo '<li style="color: #bf0116; text-align: center;">Password must be from 8 to 20 characters</li>';
    http_response_code(400);
}

if (!($_POST['age'] >= 18 && $_POST['age'] <= 100)){
    echo '<li style="color: #bf0116; text-align: center;">You must be at least 18 years old</li>';
    http_response_code(400);
}

if (!($_POST['password'] === $_POST['confirmPassword'])){
    echo '<li style="color: #bf0116; text-align: center;">Password is not confirmed</li>';
    http_response_code(400);
}

$pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
if (!(preg_match($pattern, $_POST['password']))){
    echo '<li style="color: #bf0116; text-align: center;">Password must have at least 1 capital letter, 1 digit and 1 special character</li>';
    http_response_code(400);
    exit;
}


$passwordRegister = $_POST['password'];
$salt = password_hash(uniqid(), PASSWORD_DEFAULT);
$staticPeper = "dfdfswewegggfsdo034340fsfg3443213";
$hashed_password = hash("sha256", $passwordRegister . "my_secret" . $salt . $staticPeper);

$sActivationKey = password_hash(uniqid(), PASSWORD_DEFAULT);

require_once 'database.php';
$db->beginTransaction();
try {
    $sQueryUniqueEmail = $db->prepare('SELECT email FROM meetme_user WHERE email = :sEmail');
    $sQueryUniqueEmail->bindValue(':sEmail', $_POST['email']);
    $sQueryUniqueEmail->execute();
    $sQueryUniqueEmail->fetchAll();

    if ($sQueryUniqueEmail->rowCount()) {
        echo '<li style="color: #bf0116; text-align: center;">This e-mail is already taken</li>';
        http_response_code(400);

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

        if (!$sQuery->rowCount()) {
            http_response_code(400);
            exit;
            /*echo '<div class="container">
            <div class="row">
                <div class="col-12 style="margin-left: 15px;">
                    <hr style="background-color: #bf0116;">
                    <p>Good job! Go to account activation...</p>
                    <a href="account-activation.php"><label class="btn btn-primary btn-lg">   ACCOUNT ACTIVATION   </label></a>
                </div>
            </div>
         </div>';*/
        }
    }

} catch (PDOException $e) {
    http_response_code(500);
    $db->rollBack();
}

/*$to = $_POST['email'];
$subject = 'MeetMe Activation Key';
$message = 'Your Activation Key is: '.$sActivationKey;
$email = mail($to, $subject, $message);*/

$_SESSION['csrf_token'] = hash('sha256', rand() . 'secret');
