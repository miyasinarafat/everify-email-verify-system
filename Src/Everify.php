<?php

namespace App\Everify;

use PDO;

class Everify
{
    public $id, $uid, $con, $fname, $lname, $password, $re_password, $email, $verifier, $data, $errors;

    public function __construct()
    {
        session_start();
         $this->con = new PDO('mysql:host=localhost;dbname=e_verify', "root", "");
    }

    public function prepare($data)
    {
        if (!empty($data['id'])) {
            $this->id = $data['id'];
        }

        if (!empty($data['fname'])) {
            $this->fname = $data['fname'];
            $this->errors = true;
        }

        if (!empty($data['lname'])) {
            $this->lname = $data['lname'];
            $this->errors = true;
        }

        if (!empty($data['password'])) {
            $this->password = $data['password'];
            $this->errors = true;
        }

        if (!empty($data['repassword'])) {
            $this->re_password = $data['repassword'];
            $this->errors = true;
        }

        if (!empty($data['email'])) {
            $this->email = $data['email'];
            $this->errors = true;
        }

        if (!empty($data['verifier'])) {
            $this->verifier = $data['verifier'];
            $this->errors = true;
        }

        /*echo '<pre>';
        print_r($data);
        echo '</pre>';*/
    }

    public function validationMeg($vMeg)
    {
        if (isset($_SESSION["$vMeg"]) && !empty($_SESSION["$vMeg"])) {
            echo $_SESSION["$vMeg"];
            unset($_SESSION["$vMeg"]);
        }
    }

    public function store()
    {

        if (!empty($this->errors) == true) {
            try {

                $qr = "SELECT * FROM e_verify_table WHERE email=" . "'" . $this->email . "'";
                $query = $this->con->prepare($qr);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $exc) {
                echo 'Error: ' . $exc->getMessage();
            }

            if ($this->password !== $this->re_password) {

                $_SESSION['storeErrP'] = 'Please enter same password';
                header("location:signup.php");

            } elseif ($row['email'] == $this->email) {

                $_SESSION['storeErrE'] = 'Email Already Exist, Please try another one.';
                header("location:signup.php");

            } else {
                try {
                    $this->uid = uniqid();
                    $query = "INSERT INTO e_verify_table (`id`, `uid`, `fname`, `lname`, `password`, `email`, `is_active`,
 `created`) VALUES (:id, :uid, :fname, :lname, :password,
 :email, :is_active, :created)";
                    $stmt = $this->con->prepare($query);
                    $stmt->execute(array(
                        ':id' => null,
                        ':uid' => $this->uid,
                        ':fname' => $this->fname,
                        ':lname' => $this->lname,
                        ':password' => $this->password,
                        ':email' => $this->email,
                        ':is_active' => 0,
                        ':created' => date("Y-m-d h:i:s"),
                    ));


                    $to = $this->email;
                    $subject = 'Signup | Verification';
                    $message = '
                    Thanks for signing up!<br>
                    Activated your account by entering verification code in the form.<br>
                    ------------------------<br>
                    
                    Verification Code: <strong>' . $this->uid . '</strong><br>
                    
                    ------------------------<br>
                    Thank you.
                ';
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From:ThemeYellow<info@themeyellow.com>' . "\r\n";
                    @mail($to, $subject, $message, $headers);

                    $_SESSION['storeSuc'] = 'Successfully SignUp. Check your Inbox or Spambox for verification email.';
                    header("location:signup.php?id=verify");

                } catch (Exception $exc) {
                    echo 'Error: ' . $exc->getMessage();
                }
            }
        } else {
            $_SESSION['storeErr'] = 'Please fill up empty field.';
            header("location:signup.php");
        }
    }

    public function emailVerify()
    {
        if (!empty($this->errors) == true) {
            try {

                $qr = "SELECT * FROM e_verify_table WHERE uid=" . "'" . $this->verifier . "'";
                $query = $this->con->prepare($qr);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);

                if ($row['is_active'] == 1) {

                    $_SESSION['verifycon'] = "Email Already Verified.";
                    header("location:signup.php?id=verify");

                } elseif (isset($row) && !empty($row)) {

                    try {

                        $qr = "UPDATE e_verify_table SET is_active = :is_active, verified = :verified  WHERE uid =" . "'" . $this->verifier . "'";
                        $query = $this->con->prepare($qr);
                        $query->execute(array(
                            ":is_active" => 1,
                            ":verified" => date("Y-m-d h:i:s"),
                        ));
                        $_SESSION['verifySuc'] = "Registration Process Completed. Thank You for your Registration.";
                        header("location:signup.php?id=verify");

                    } catch (PDOException $e) {
                        echo 'Error: ' . $e->getMessage();
                    }

                } else {
                    $_SESSION['verifyERRR'] = "Verification Code Is Wrong.";
                    header("location:signup.php?id=verify");
                }

            } catch (Exception $exc) {
                echo 'Error: ' . $exc->getMessage();
            }
        } else {
            $_SESSION['verifyErr'] = 'Please fill up empty field.';
            header("location:signup.php?id=verify");
        }
    }
}