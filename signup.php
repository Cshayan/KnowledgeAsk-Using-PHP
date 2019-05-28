<?php
include 'connection.php';
?>
<?php
$name = $email = $pass = $rePass = '';
$nameErr = $emailErr = $passErr = $rePassErr = '';
$passConfirmError = $Error = '';
$encrypted_pass = '';
$successfulInsert = $successfulInsert2 = '';
$matchFound = 0;
$alreadyRegistered = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name'])) {
        $nameErr = 'Name is required';
    } else {
        $name = $_POST['name'];
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $Error = 'Error!!';
        }
    }
    if (empty($_POST['email'])) {
        $emailErr = 'Email is required';
    } else {
        $email = $_POST['email'];
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $Error = 'Error!!';
        }
    }
    if (empty($_POST['pass'])) {
        $passErr = 'Password is required';
        $Error = 'Error!!';
    } else {
        $pass = $_POST['pass'];
    }
    if (empty($_POST['re-pass'])) {
        $rePassErr = 'Confirm password is required';
        $Error = 'Error!!';
    } else {
        $rePass = $_POST['re-pass'];
    }

    if ($pass !== $rePass) {
        $passConfirmError = 'The passwords must be same';
        $Error = 'Error!!';
    }

    $encrypted_pass = base64_encode($pass);

    $select = "SELECT email from signup";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['email'] === $email) {
                $matchFound = 1;
                $alreadyRegistered = 'You have already registered! Please login into your account';
            }
        }
    }

    if ($matchFound == 0) {
        $insert = "INSERT INTO signup (username, email, pass) 
        VALUES ('$name', '$email', '$encrypted_pass')";
        $insert2 = "INSERT INTO userinfo (email) 
        VALUES ('$email')";

        if (mysqli_query($conn, $insert)) {
            $successfulInsert = 'Your have successfully signed in! Redirecting you to the login page shortly..';
             header("refresh:5; url=login.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        if (mysqli_query($conn, $insert2)) {
            $successfulInsert2 = 'Your have successfully signed in! Redirecting you to the login page shortly..';
            // header("refresh:5; url=login.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}

function test($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SignUp - KnowledgeAsk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" href="css/styleSignUp.css">
</head>

<body>
    <?php include 'nav.php'; ?>

    <!-- only for mobile view -->
    <div class="err-container">
        <?php echo $successfulInsert; ?>
        <?php echo $Error; ?><br>
        <?php echo $nameErr; ?><br>
        <?php echo $emailErr; ?><br>
        <?php echo $passConfirmError; ?><br>
        <?php echo $rePassErr; ?><br>
        <?php echo $alreadyRegistered; ?><br>
    </div>
    <!-- ends here -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="desc">Sign<span id="ask">Up</span></h1>
                        <small class="desc">It's completely free!</small><br>
                        <span class="desc" style="color: #55efc4"> <?php echo $successfulInsert; ?></span>
                        <span class="desc"  style="color: #eb4d4b;"> <?php echo $alreadyRegistered; ?></span>    
                    </div>
                    <!--SignUp form-->
                    <div class="card-body">
                        <div class="parentForm">
                            <div class="childForm">
                                <form class="form-container" id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-no-border" required="This felid is required" id="name" name="name" value="<?php echo $name; ?>">
                                        <label>Name*</label>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-no-border" required="This felid is required" id="email" name="email" value="<?php echo $email; ?>">
                                        <label>Email*</label>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-no-border" required="This feild is required" id="pass" name="pass" value="<?php echo $pass; ?>">
                                        <label>Password*</label>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-no-border" required="This feild is required" id="re-pass" name="re-pass" value="<?php echo $rePass; ?>">
                                        <label>Repeat Password*</label>
                                    </div>
                                    <p class="desc">Already have an account? <a href="login.php">Login</a> Here</p>
                                    <div class="form-group" style="float: right">
                                        <input type="submit" class="btn btn-warning btn-md" value="Submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="home.php">KnowledgeAsk</a> |
                        <a href="#">About</a> |
                        <a href="#">Contact Us</a> |
                        <a href="#">Terms and Conditions</a>
                        <br>
                        KnowledgeAsk &copy; 2019
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card" id="card-desc">
                    <div class="card-header">
                        <span id="know"> <i class="fas fa-atlas"></i> Knowledge<span id="ask">Ask</span></span><br>
                        <p class="desc">A place to gather and share knowledge</p>
                    </div>
                    <div class="card-footer">
                        <span class="error">All the * feilds are required.<br></span><br>
                        <div class="errorColor"  style="color: #eb4d4b;">
                            <?php echo $Error; ?><br>
                            <?php echo $nameErr; ?><br>
                            <?php echo $emailErr; ?><br>
                            <?php echo $passConfirmError; ?><br>
                            <?php echo $rePassErr; ?><br>
                            <?php echo $alreadyRegistered; ?><br>
                        </div>
                        Already have an account? <a href="login.php">Login</a> Here
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>