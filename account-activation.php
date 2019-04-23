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
                            </i> Upload your profile image *</label><br>
                        <label class="btn btn-outline-primary btn-block"> Choose file
                            <input type="file" name="document" required hidden></label>
                    </div>
                    <button type="submit" class="btn btn-primary"> SUBMIT</button>

                </form>

            </div>
        </div>
    </div>
    <br>

<?php

if (empty($_POST['key']) || (strlen($_POST['key'])) !== 60) {
    http_response_code(400);
    exit;
}

if (isset($_FILES['document']) &&
    ($_FILES['document']['error'] == UPLOAD_ERR_OK)) {
    $newPath = "" . basename($_FILES['document']['name']);
    if (move_uploaded_file($_FILES['document']['tmp_name'], $newPath)) {
        $binaryContent = file_get_contents($newPath);

        require_once 'database.php';
        try {
            $sQuery = $db->prepare("UPDATE meetme_user SET profileImage = :profileImage, active = 1 WHERE activationKey = :sActivationKey");
            $sQuery->bindValue(':profileImage', $binaryContent);
            $sQuery->bindValue(':sActivationKey', $_POST['key']);
            $sQuery->execute();

            if ($sQuery->rowCount()) {
                echo '
                    <div class="container">
                        <div class="row justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-8 col-lg-6 mx-auto">
                                                <hr style="background-color: #bf0116;">
                                                <p>Good job! You can login now.</p>
                                <a href="login.php"><label class="btn btn-primary"> LOGIN </label></a>
                            </div>
                        </div>
                    </div>
                    ';
                exit;
            }
                echo '
                    <div class="container">
                        <div class="row justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-8 col-lg-6 mx-auto">
                                                <hr style="background-color: #bf0116;">
                                                <p style="color: #bf0116;">Something went wrong. Try the activation again.</p>
                            </div>
                        </div>
                    </div>
                    ';

        } catch (PDOException $e) {
            http_response_code(500);
        }

    } else {
        print "Couldn't move file to $newPath";
        http_response_code(400);
    }

} else {
    print "No valid file uploaded.";
    http_response_code(400);
}

// require_once './components/bottom.php';
?>

<script src="jquery-3.3.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>


</body>
</html>
