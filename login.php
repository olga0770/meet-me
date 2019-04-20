<?php
$sTitle = 'Login';
require_once './components/top.php';
?>


<div class="container">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 mx-auto">

            <form id="formLogin">

                <br>
                <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>

                <hr style="background-color: #bf0116;">
                <h3>Congratulations! Your account has been activated. Now you can login!</h3><br>

                <h2>Login:</h2>
                <p class="small">* These fields are required</p>

                <br><label for="userName"><i class="fas fa-user" style="color: #bf0116;"></i> User name *</label>
                <input name="userName" class="form-control" type="text" placeholder="User Name"
                       required="required" value="aaa">

                <br><label for="password"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Password *</label>
                <input name="password" class="form-control" type="password" placeholder="Password"
                       required="required" value="1234567"><br>

                <button type="submit" class="btn btn-primary"> LOGIN</button>
                <br>
                <hr style="background-color: #bf0116;">
                <p>Not a member?</p>
                <a href="signup.php" class="btn btn-primary" role="button"> SIGN UP FOR
                    FREE </a>

            </form>

        </div>
    </div>
</div>
<br>


<?php
$sScript = '';
require_once './components/bottom.php';
?>