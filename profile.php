<?php
session_start();
include 'connection.php';
$email = $_SESSION['email'];
$successMsg = '';
$picture = 'images/blankProfile.png';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = $_FILES['uploadFile']['name'];
    $tempname = $_FILES['uploadFile']['tmp_name'];
    $folder = "images/".$filename;
    move_uploaded_file($tempname, $folder);

    $upd = "UPDATE userinfo SET pic ='$folder' WHERE email = '$email' ";
    if (mysqli_query($conn, $upd)) {
        $successMsg = 'Profile Pic uploaded successfully';
        $_SESSION['successMsg'] = $successMsg;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
$select = "SELECT pic from userinfo WHERE email = '$email'";
$result = mysqli_query($conn, $select);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $picture = $row['pic'];
        $_SESSION['picture'] = $picture;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" type="text/css" href="css/styleProfile.css">
</head>

<body>
    <div class="container-fluid">
        <br>
        <?php include 'navOriginal.php';
        ?>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src='<?php echo $picture; ?>' class="img-fluid rounded-circle" alt="No profile image selected" />
                        <br><br>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <input type="file" class="form-control" name="uploadFile" required><br>
                            <input type="submit" class="btn btn-primary" value="Upload your Profile Picture" name="submit">
                        </form>
                        <br>
                        <div id="picUpload" class="alert alert-success"><?php echo $successMsg; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <span style="color: red">Email:-</span> <?php echo $email; ?><br><br>
                        <a class="btn btn-primary" href="#">Update Email</a><br><br>
                        <a class="btn btn-primary" href="#">Update Password</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <p style="color: red">Home:- </p>
                        <p style="color: red">Education:- </p>
                        <p style="color: red">Work:- </p>
                        <a class="btn btn-primary" href="#">Update Details</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p>Questions asked:-</p>
                        <p>Answers written:-</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="alert alert-success">Followers:-</p>
                        <p class="alert alert-warning">Following:-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>

</body>

</html>