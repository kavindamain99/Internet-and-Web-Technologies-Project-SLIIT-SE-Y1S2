<?php
require("config.php");

$fname = $lname = $email = $user_type = $password = $conf_pass = $sql = $ref_success = "";
$fname_err = $lname_err = $email_err = $user_type_err = $password_err = $conf_pass_err = $pw_match_err = "";

if (isset($_POST["reg_submit"])) {

    function test_input($form_data)
    {
        $form_data = stripslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        return $form_data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //First name
        if (empty($_POST["fname"])) {
            $fname_err = "First name is required*";
        } else {
            $fname = test_input($_POST["fname"]);
        }

        //Last name
        if (empty($_POST["lname"])) {
            $lname_err = "Last name is required*";
        } else {
            $lname = test_input($_POST["lname"]);
        }

        //Email
        if (empty($_POST["email"])) {
            $email_err = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email";
            }
        }

        //User type 
        if (empty($_POST["user_type"])) {
            $user_type_err = "User Type is required";
        } else {
            $user_type = test_input($_POST["user_type"]);
        }

        //Password
        if (empty($_POST["password"])) {
            $password_err = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        //Confirm passowrd
        if (empty($_POST["conf_pass"])) {
            $conf_pass_err = "Confirm password is required";
        } else {
            $conf_pass = test_input($_POST["conf_pass"]);
        }

        //Compare passwords
        if (0 != strcmp($password, $conf_pass)) {

            $conf_pass_err =  "Entered passwords donot match";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);


            if ($fname && $lname &&  $email && $user_type && $password && $conf_pass) {

                if ($user_type == "buyer") {
                    $sql = "INSERT INTO  auc_sys_buyer (b_fname, b_lname, b_email, b_user_type, b_password) values('$fname', '$lname', '$email', '$user_type', '$password')";
                } elseif ($user_type == "seller") {
                    $sql = "INSERT INTO  auc_sys_seller (s_fname, s_lname, s_email, s_user_type, s_password) values('$fname', '$lname', '$email', '$user_type', '$password')";
                }
                if ($sql) {
                    if ($conn->query($sql) === TRUE) {
                        $fname = $lname = $email = $user_type = $password = $conf_pass = "";
                        // $ref_success = "Registration successfull";
                        header("refresh:0; url=login.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    

<header>

    <div id="header_bg" >
    <h1 id="header" style="color:red">BIDMI&nbsp;&nbsp;
     <a href="seller_dashboard.php" id="header">Seller Dashboard</a>&nbsp;&nbsp;
        <a href="buyer_dashboard.php" id="header"> Buyer Dashboard</a></h1>
    </div>
    
    
    
</header>    
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles/main_styles.css">
    <link rel="stylesheet" href="styles/registration.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/header.css">
</head>

<body>

    <h2 class="reg-success-text"> <?php echo $ref_success ?> </h2>

    <div class="out-outer-wrapper bg">

        <div class="outer-wrapper">
            <div class="card-wrapper">
                <div class="card-body">
                    <div class="reg-form-div">
                        <!-- User registration form -->
                        <form class="from-style" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                            <h2 class="title">Registration Form</h2>
                            <p class="title-tag">Please fill in this form to create an account.</p>
                            <hr class="hr-styles">

                            <div class="div-row">
                                <!-- First Name -->
                                <div class="input-group">
                                    <label class="input-label">First Name</label>
                                    <input class="input-field" type="text" name="fname" value="<?php echo $fname; ?>"><br>
                                    <p class="error"><?php echo  $fname_err ?> </p>
                                </div>
                                <!-- Last name -->
                                <div class="input-group">
                                    <label class="input-label">Last Name</label>
                                    <input class="input-field" type="text" name="lname" value="<?php echo $lname; ?>"><br>
                                    <p class="error"><?php echo $lname_err ?> </p>
                                </div>
                            </div>

                            <div class="div-row">
                                <!-- Email -->
                                <div class="input-group">
                                    <label class="input-label"> E-mail</label>
                                    <input class="input-field" type="text" name="email" value="<?php echo $email; ?>"><br>
                                    <p class="error"><?php echo $email_err ?> </p>
                                </div>

                                <!-- User Type -->
                                <div class="input-group">
                                    <label class="input-label">User Type</label>

                                    <div class="radio_btn-inner-div">
                                        <label class="radio-label">
                                            <input class="radio-input" type="radio" name="user_type" value="buyer" <?php if (isset($user_type) && $user_type == "buyer") echo "checked"; ?>>Buyer
                                        </label>

                                        <label class="radio-label">
                                            <input class="radio-input" type="radio" name="user_type" value="seller" <?php if (isset($user_type) && $user_type == "seller") echo "checked"; ?>>Seller <br>
                                        </label>
                                    </div>
                                    <p class="error"><?php echo $user_type_err ?> </p>
                                </div>
                            </div>
                            <!-- Password -->
                            <div class="div-row">
                                <div class="input-group">
                                    <label class="input-label">Password</label>
                                    <input class="input-field" type="password" name="password" value=""><br>
                                    <p class="error"><?php echo  $password_err ?> </p>
                                </div>

                                <div class="input-group">
                                    <label class="input-label">Confirm Password</label>
                                    <input class="input-field" type="password" name="conf_pass" value=""><br>
                                    <p class="error"><?php echo $conf_pass_err; ?> </p>
                                </div>
                            </div>
                             <!-- Confirm password -->
                            <div class="div-row-outer">
                                <p class="title-tag-bottom">By creating an account you agree to our <a href="" style="color:dodgerblue">Terms & Privacy</a>.</p>
                                <div class="submit-btn-outer-div">
                                    <input class="btn btn-radius-2 btn-blue" type="submit" value="submit" name="reg_submit">
                                </div>
                                <p><a class="tag-bottom-outer" href="login.php">Already have an account ?</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    
    <footer id="footer">
  <div id="list">  
<ul>
    <li><a href="#">&#169 2020 |</a></li>  
    <li><a href="#">Register For Free |</a></li>
    <li><a href="#">Privacy Policy |</a></li>
    <li><a href="#">Terms of Use |</a></li>
    <form>
    <input type="email" name="notification" placeholder="Your Email adress">
    <input type="submit" value="Connect" style="background-color:greenyellow">        
    <label for="notification" style="color:white">Connect us ! Be the First to Know Premier items delivered to your inbox.</label>
    
    </form>

 
</ul>    
</div>    
    
</footer>  
    
</html>