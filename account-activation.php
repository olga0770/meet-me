<?php
$sTitle = 'MeetMe Account Activation';
require_once './components/top.php';
?>

<div class="container">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 mx-auto">

            <form id="formProfileImage" action="account-activation.php" method="post" enctype="multipart/form-data">

                <br>
                <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>
                <hr style="background-color: #bf0116;">
                <p>An activation key has been sent to your email address.</p>
                <h2>Account Activation:</h2>
                <p class="small" style="color: #bf0116;">* These fields are required</p>
                <br>

                <div class="form-group">
                    <label for="key"><i class="fas fa-key" style="color: #bf0116;"></i> Activation Key *</label>
                    <input name="key" class="form-control" type="text" placeholder="Activation Key"
                           required value="">
                </div>

                <div class="form-group">
                    <label for="profileImage"><i class="fas fa-image" style="color: #bf0116;">
                        </i> Upload your profile image * (.jpg, .png, max 500KB)</label><br>
                    <label class="btn btn-outline-primary btn-block"> Choose file
                        <input type="file" name="file" required hidden></label>
                </div>
                <button type="submit" class="btn btn-primary"> SUBMIT</button>

            </form>

        </div>
    </div>
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

$errorMessage = '<div class="container">
                        <div class="row justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-8 col-lg-6 mx-auto">
                                                <hr style="background-color: #bf0116;">
                                                <p style="color: #bf0116;">Something went wrong. Try the activation again.</p>
                            </div>
                        </div>
                    </div>';

$successMessage = '<div class="container">
                        <div class="row justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-8 col-lg-6 mx-auto">
                                                <hr style="background-color: #bf0116;">
                                                <p>Good job! You can login now.</p>
                                <a href="login.php"><label class="btn btn-primary"> LOGIN </label></a>
                            </div>
                        </div>
                    </div>';

if (empty($_POST['key']) || (strlen($_POST['key'])) !== 60) {
    http_response_code(400);
    // echo $errorMessage . 'key';
    exit;
}

if (isset($_FILES['file']['tmp_name'])) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
    if ($mime == 'image/jpeg' || $mime == 'image/png' && $_FILES['file']['size'] < 500000) {

        $file = $_FILES['file'];
        $name = $file['name'];
        $path = "uploads/" . basename($name);
        if (move_uploaded_file($file['tmp_name'], $path)) {

            require_once 'database.php';
            try {
                $sQuery = $db->prepare("UPDATE meetme_user SET profileImage = :profileImage, active = 1 
                  WHERE activationKey = :sActivationKey AND active = 0");
                $sQuery->bindValue(':profileImage', $path);
                $sQuery->bindValue(':sActivationKey', $_POST['key']);
                $sQuery->execute();

                if ($sQuery->rowCount()) {
                    echo $successMessage;
                    exit;
                }
                http_response_code(400);
                echo $errorMessage . 'database';

            } catch (PDOException $e) {
                http_response_code(500);
            }

        } else {
            http_response_code(400);
            echo $errorMessage . 'image problem';
        }

    }
    finfo_close($finfo);
    echo $errorMessage . 'not an image';
}



