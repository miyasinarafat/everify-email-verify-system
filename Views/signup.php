<?php
include_once "../Src/Everify.php";

use App\Everify\Everify;

$obj = new Everify();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verify System</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <? if (isset($_GET['id'])=="verify" && !empty($_GET['id'])=="verify") { ?>

                <h1 class="mt50 mb50">Verify Your Email</h1>
                <form action="e-process.php" method="post">
                    <div class="form-group">
                        <input type="text" name="verifier" class="form-control" placeholder="Enter Your Verifier Code">
                    </div>
                    <div class="form-group text-left">
                        <button type="submit" class="btn btn-primary">Verify Now</button>
                        <a href="signup.php" class="btn btn-link">Back to signup page</a>
                    </div>
                    <p class="text-success">  <? $obj->validationMeg("storeSuc"); ?> </p>
                    <p class="text-success">  <? $obj->validationMeg("verifySuc"); ?> </p>
                    <p class="text-danger"> <? $obj->validationMeg("verifyErr"); ?> </p>
                    <p class="text-danger"> <? $obj->validationMeg("verifycon"); ?> </p>
                    <p class="text-danger"> <? $obj->validationMeg("verifyERRR"); ?> </p>
                </form>

            <? } else { ?>

            <h1 class="mt50 mb50">SignUp Form</h1>
            <form method="post" action="signup-process.php">
                <div class="form-group">
                    <input type="text" name="fname" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group">
                    <input type="text" name="lname" class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="repassword" class="form-control" placeholder="Re-password">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group text-left">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="signup.php?id=verify" class="btn btn-link">Go to verification page</a>
                </div>

                <p class="text-danger"> <? $obj->validationMeg("storeErr"); ?> </p>
                <p class="text-danger"> <? $obj->validationMeg("storeErrP"); ?> </p>
                <p class="text-danger"> <? $obj->validationMeg("storeErrE"); ?> </p>
            </form>

            <? } ?>
        </div>
    </div>
</div>

<script src="js/jquery-1.12.4-min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jqueryvalidation/jquery.validate.min.js"></script>
<script src="js/jqueryvalidation/additional-methods.min.js"></script>
</body>
</html>
