<?php
session_start();
include 'connection.php';

$loggedIn = 0;
$wrongDetails = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $select = 'SELECT email, pass FROM signup';
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['email'] === $_POST['email'] && base64_decode($row['pass']) === $_POST['pass']) {
                $loggedIn = 1;
                $_SESSION['email'] = $_POST['email'];
                header('Location:dashboard.php');
            }
        }
    }

    if ($loggedIn == 0) {
        $wrongDetails = 'Email or password entered is incorrect!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - KnowledgeAsk </title>
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
        <?php echo $wrongDetails; ?>
    </div>
    <!-- ends here -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="desc">Log<span id="ask">In</span></h1>
                        <small class="desc">Login and explore knowledge!</small><br>
                        <span class="desc"  style="color: #eb4d4b;"> <?php echo $wrongDetails; ?></span>
                    </div>
                    <!--SignUp form-->
                    <div class="card-body">
                        <div class="parentForm">
                            <div class="childForm">
                                <form class="form-container" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control form-control-no-border" required="This felid is required">
                                        <label>Email</label>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="password" name="pass" class="form-control form-control-no-border" required="">
                                        <label>Password</label>
                                    </div>
                                    <p class="desc">Don't have an account? <a href="signup.php">SignUp</a> Here</p>
                                    <div class="form-group" style="float: right">
                                        <input type="submit" class="btn btn-warning btn-md" value="Submit" name="submit">
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
                        <div class="errorColor" style="color: #eb4d4b;">
                            <?php echo $wrongDetails; ?>
                        </div>
                        Don't have an account? <a href="signup.php">SignUp</a> Here
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>