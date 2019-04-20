<?php
$sTitle = 'Signup';
require_once './components/top.php';
?>


    <div class="container">

        <br>
        <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>

        <hr style="background-color: #bf0116;">

        <h2>Make a profile:</h2>
        <p class="small" style="color: #bf0116;">* These fields are required</p>

        <form id="formSignup">

            <div class="row">
                <div class="col-12 col-md-6">

                    <br><label for="userName"><i class="fas fa-user" style="color: #bf0116;"></i> Profile name *</label>
                    <input name="userName" class="form-control" type="text" placeholder="User Name (3 to 20 characters)"
                           required="required" value="aaa">

                    <br><label for="email"><i class="fas fa-envelope" style="color: #bf0116;"></i> E-mail *</label>
                    <input name="email" class="form-control" type="email" placeholder="E-mail" required="required" value="olyalo0201@gmail.com">

                    <br><label for="password"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Create password *</label>
                    <input name="password" class="form-control" type="password" placeholder="Create password (6 to 15 characters)"
                           required="required" value="1234567">

                    <br><label for="confirmPassword"><i class="fas fa-unlock-alt" style="color: #bf0116;"></i> Confirm
                        password *</label>
                    <input name="confirmPassword" class="form-control" type="password" placeholder="Confirm password"
                           required="required" value="1234567">

                </div>

                <div class="col-12 col-md-6">

                    <br><label for="age"> <i class="fas fa-birthday-cake" style="color: #bf0116;"></i> Age</label>
                    <input name="age" class="form-control" type="number" placeholder="Age" value="55">

                    <br><label for="userGender"><i class="fas fa-male" style="color: #bf0116;"></i><i
                                class="fas fa-female" style="color: #bf0116;"></i> Gender</label>
                    <select name="userGender" class="form-control">
                        <option value=1>Man</option>
                        <option value=0 selected>Woman</option>
                    </select>

                    <br><label for="chooseGender"><i class="fas fa-male" style="color: #bf0116;"></i><i
                                class="fas fa-female" style="color: #bf0116;"></i> I'm looking for</label>
                    <select name="chooseGender" class="form-control">
                        <option value=1 selected>Man</option>
                        <option value=0>Woman</option>
                    </select>

                    <br><label for="profileImage"><i class="fas fa-image" style="color: #bf0116;"></i> Upload your
                        profile image</label><br>
                    <label name="profileImage" class="btn btn-outline-primary btn-block"> Choose file <input type="file"
                                                                                                             hidden></label>

                </div>
            </div>

            <br>
            <div class="form-group">
                <label for="bio"><i class="fas fa-file-alt" style="color: #bf0116;"></i> Bio</label>
                <textarea name="bio" class="form-control" placeholder="Bio (10 to 100 characters)"
                          rows="3">aaa aaa aaa aaa</textarea>
            </div>

            <hr style="background-color: #bf0116;">

            <br><input type="submit" class="btn btn-primary btn-lg" value="   SIGN UP   ">

        </form>

        <br><h3 class="noSignup" style="color: #bf0116;"></h3>
    </div>


    <br>

<?php
$sScript = 'signup.js';
require_once './components/bottom.php';
?>