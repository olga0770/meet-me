<?php
session_start();
$sTitle = 'MeetMe Signup';
require_once './components/top.php';
$_SESSION["csrf_token"]=hash("sha256",rand()."secret");
?>

    <div class="container">

        <br>
        <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>
        <hr style="background-color: #bf0116;">
        <h2 class="waitingMessage">Make a profile:</h2>
        <p class="small" style="color: #bf0116;">* These fields are required</p>

        <div id="wait" style="display:none;width:200px;height:200px;position:absolute;top:50%;left:50%;padding:2px;margin-left: -100px;z-index:1">
            <img src='demo_wait.gif' width="200" height="200" /></div>

        <form id="formSignup">
            <div class="row">
                <div class="col-12 col-md-6">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>">

                    <div class="form-group">
                        <label for="userName"><i class="fas fa-user" style="color: #bf0116;"></i> User Name *</label>
                        <input id="userName" name="userName" class="form-control" type="text"
                               placeholder="User Name (3 to 20 characters)" required
                               value="<?php if (!empty($_POST['userName'])) {echo htmlentities($_POST['userName']);} ?>">
                        <span class="errorUserName" style="color: #bf0116;"></span>
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope" style="color: #bf0116;"></i> E-mail *</label>
                        <input id="email" name="email" class="form-control" type="email" placeholder="E-mail"
                               required value="">
                        <span class="errorEmail" style="color: #bf0116;"></span>
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Create Password *</label>
                        <input id="password" name="password" class="form-control" type="password"
                               placeholder="Create Password (8 to 20 characters)" required value=""
                               pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$"
                               title="Please include at least 1 uppercase character, 1 lowercase character, and 1 number.">
                        <span class="errorPassword" style="color: #bf0116;"></span>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Confirm
                            Password *</label>
                        <input id="confirmPassword" name="confirmPassword" class="form-control" type="password"
                               placeholder="Confirm Password" required value="">
                        <span class="errorConfirmPassword" style="color: #bf0116;"></span>
                    </div>
                </div>

                <div class="col-12 col-md-6">

                    <div class="form-group">
                        <label for="age"> <i class="fas fa-birthday-cake" style="color: #bf0116;"></i> Age *</label>
                        <input id="age" name="age" class="form-control" type="number" placeholder="Age" required value="">
                        <span class="errorAge" style="color: #bf0116;"></span>
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

                </div>
            </div>

            <br>
            <div class="form-group">
                <label for="bio"><i class="fas fa-file-alt" style="color: #bf0116;"></i> Bio *</label>
                <textarea id="bio" name="bio" class="form-control" placeholder="Bio (10 to 275 characters)"
                          rows="3" required></textarea>
                <span class="errorBio" style="color: #bf0116;"></span>
            </div>

            <hr style="background-color: #bf0116;">

            <br><input type="submit" class="btn btn-primary btn-lg" value="   SIGN UP   ">
        </form>




    </div>
    <br>

<?php
$sScript = 'signup.js';
require_once './components/bottom.php';
?>