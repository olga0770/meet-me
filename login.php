<?php
$sTitle = 'MeetMe Login';
require_once './components/top.php';
?>


    <div class="container">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 mx-auto">

                <form id="formLogin">

                    <br>
                    <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>

                    <hr style="background-color: #bf0116;">

                    <h2>Login:</h2>
                    <p class="small" style="color: #bf0116;">* These fields are required</p>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope" style="color: #bf0116;"></i> E-mail *</label>
                        <input id="email" name="email" class="form-control" type="email" placeholder="E-mail"
                               required value="">
                        <span class="errorEmail" style="color: #bf0116;"></span>
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Password
                            *</label>
                        <input id="password" name="password" class="form-control" type="password"
                               placeholder="Password" required value="">
                        <span class="errorPassword" style="color: #bf0116;"></span>
                    </div>

                    <button type="submit" class="btn btn-primary"> LOGIN</button>

                </form>
                <br>
                <p class="errorLogin" style="color: #bf0116;"></p>

            </div>
        </div>
    </div>
    <br>


<?php
$sScript = 'login.js';
require_once './components/bottom.php';
?>