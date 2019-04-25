<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="favicon.png"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>MeetMe – free and secure dating</title>
</head>

<body>
<div class="bg-image">

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-5 align-self-start" style="margin-top: 40px;">

                <div class="container bg-text">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-12 mx-auto">

                            <form id="formLogin">
                                <div class="container">
                                    <div class="row justify-content-center align-items-center h-100">
                                        <div class="col-12 col-md-10 mx-auto">

                                            <br>
                                            <h1>meet<i class="fas fa-heart" style="color: #bf0116;"></i>me</h1>

                                            <hr style="background-color: #bf0116;">

                                            <h5 style="margin: 15px 0 15px 0;">Meet new people! <br>Free and secure
                                                dating :)</h5>
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
                                            <br>
                                            <p class="errorLogin" style="color: #bf0116;"></p>

                                            <hr style="background-color: #bf0116;">
                                            <p>Not a member?</p>
                                            <a href="signup.php" class="btn btn-primary" role="button"> SIGN UP FOR
                                                FREE </a>
                                            <br>

                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php
$sScript = 'login.js';
require_once './components/bottom.php';
?>