<?php
class autorize extends database
{
    public function signup($data)
    {
        $_POST['ID'] = uniqid();
        $info =  $this->validate_form($data);
        if (!is_array($info)) {
            return null;
        }
        $check = $this->getall("users", "email = ? or phone_number = ?", [$info['email'], $info['phone_number']]);
        if ($check > 0) {
            echo $this->message("User with email or phone number alrady exit.", "error");
            return null;
        }

        $info['password'] = password_hash($info['password'], PASSWORD_DEFAULT);
        unset($info['confrim_password']);

        $insert = $this->quick_insert("users", $info);
        if ($insert) {
            session_start();
            // $d->updateadmintoken($value['ID'], "users");
            $_SESSION['userSession'] = htmlspecialchars($info['ID']);
            $actInfo = ["userID" => $info['ID'],  "date_time" => date("Y-m-d H:i:s"), "action_name" => "Registration", "description" => "Account Registration."];
            $this->new_activity($actInfo);
            $return = [
                "message" => ["Success", "Account Created", "success"],
                "function" => ["loadpage", "data" => ["index", "null"]],
            ];
            return json_encode($return);
        }
    }

    public function signin()
    {
        $d = new database;
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        if (!empty($email) && !empty($password)) {
            $value = $d->getall("users", "email = ?", [$email]);
            if (is_array($value)) {
                if (password_verify($password, $value['password'])) {
                    if (htmlspecialchars($value['status']) == 0) {
                        $reason = "";
                        if ($value['reason'] != "") {
                            $reason = htmlspecialchars($value['reason']);
                        }
                        $d->message("We're sorry, your account has been blocked. <br> <b>Reason: </b> " . $reason, "error");
                    } else {
                        // reson here
                        session_start();
                        // $d->updateadmintoken($value['ID'], "users");
                        $urlgoto = "index.php";
                        $_SESSION['userSession'] = htmlspecialchars($value['ID']);
                        if (isset($_SESSION['urlgoto'])) {
                            $urlgoto = htmlspecialchars($_SESSION['urlgoto']);
                        }
                        $actInfo = ["userID" => $value['ID'],  "date_time" => date("Y-m-d H:i:s"),"action_name" => "Login", "description" => "Account login access."];
                        $this->new_activity($actInfo);
                        // $d->message("Account logged in Sucessfully <a href='index.php'>Click here to proceed.</a>", "error");
                        $return = [
                            "message" => ["Success", "Account Logged in", "success"],
                            "function" => ["loadpage", "data" => ["index", "null"]],
                        ];
                        return json_encode($return);
                    }
                } else {
                    $d->message("Password Incorrect", "error");
                }
            } else {
                $d->message("Email doesn't exist.", "error");
            }
        } else {
            $d->message("Make sure you enter your email and password", "error");
        }
    }



    public function sendotp()
    {
        $d = new database;
        $email = htmlspecialchars($_POST['email']);
        if (isset($_POST['email'])) {
            $checkemail = $d->fastgetwhere("users", "email = ?", $email, "");
            if ($checkemail) {
                $data = $d->fastgetwhere("users", "email = ?", $email, "details");
                $id = $data['ID'];
                $reset =  mt_rand(000000, 99999);
                $hashreset = password_hash($reset, PASSWORD_DEFAULT);
                $where = "ID ='$id'";
                $update = $d->update("users", "", $where, ["reset" => $hashreset]);
                if ($update) {
                    // ($to, $from_name, $subject, $body, $message = '')
                    $sendmail = $d->smtpmailer($to = $data['email'], "no-reply@bestimelive.com", "Password Reset ($reset)", "<h4>Your Password Reset</h4>
                    We have sent you this email in response to your request to reset your password on Bestimelive.
                    <p>Use OTP code below to rest your password <h1>$reset</h> <hr>
        
                    </p><small>Do not reply because this email is not monitored by anyone.</small>", $data['first_name'], "");
                    if ($sendmail) {
                        // $_SESSION['otp'] = "sent";
                        $d->message("OTP sent to $email", "success");
                    }
                } else {
                    $d->message("Error", "error");
                }
            } else {
                $d->message("Email not found by check and try again", "error");
            }
        } else {
            $d->message("Please enter email address", "error");
        }
    }

    function resetpassword()
    {
        $d = new database;
        $email = htmlspecialchars($_POST['email']);
        $value = $d->checkmessage(["OTP", "password", "confirm_password"]);
        if (is_array($value)) {
            $data = $d->getall("users", "email = ?", [$email]);
            if (password_verify($value['OTP'], $data['reset'])) {
                $newpassword = password_hash($value['password'], PASSWORD_DEFAULT);
                $where = "email ='$email'";
                $update = $d->update("users", ["password" => $newpassword, "reset" => ""], $where, message: "Password Reset successfully. You can now <a class='btn btn-default' href='signin.php'>Login here</a> with your new password");
            } else {
                $d->message("Incorrect OTP", "error");
            }
        }
    }
}
