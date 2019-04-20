<?php
$sTitle = 'Account Activation';
require_once './components/top.php';
?>


    <div class="container">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 mx-auto">

                <form id="formAccountActivation">

                    <br>
                    <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>

                    <hr style="background-color: #bf0116;">
                    <h3>An activation key has been sent to your email address.</h3><br>

                    <h2>Account Activation:</h2>
                    <p class="small" style="color: #bf0116;">* These fields are required</p>

                    <br><label for="key"><i class="fas fa-key" style="color: #bf0116;"></i> Activation Key *</label>
                    <input name="key" class="form-control" type="text" placeholder="Activation Key"
                           required="required" value=""><br>

                    <button type="submit" class="btn btn-primary"> SUBMIT </button>
                    <br>


                </form>
                <br><h3 class="noAccountActivation" style="color: #bf0116;"></h3>

            </div>
        </div>
    </div>


<?php
$sScript = 'account-activation.js';
require_once './components/bottom.php';
?>