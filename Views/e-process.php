<?php
include_once "../Src/Everify.php";

use App\Everify\Everify;

$obj = new Everify();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $obj->prepare($_POST);
    $obj->emailVerify();

} else {
    $_SESSION['Errors_R'] = "404 not found :(";
    header("location:errors.php");
}