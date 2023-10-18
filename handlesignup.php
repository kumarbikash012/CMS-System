<?php
//script to connect to the database
$servername="localhost";
$username="root";
$password="";
$database="cmssystem";
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("failed to connect".mysqli_connect_error());
}
// else{
//     echo"connected susscessfully";
// }
?>

<?php
$showError = false;
$showAlert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['SignupEmail'];
    $pass = $_POST['SignupPassword'];
    $cpass = $_POST['SignupcPassword'];
    $admin_code = $_POST['admin_code'];
    $role = ($admin_code === 'admin@123') ? 'admin' : 'user';

    // Check whether this email already exists in the database
    $existSql = "SELECT * FROM `username` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $showError = "Email already in use";
    } else {
        if ($pass == $cpass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `username` (`user_email`, `user_pass`, `role`, `timestamp`) VALUES ('$user_email', '$hash', '$role', current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
                header('Content-Type: application/json');
                echo json_encode(["msg" => "successful"]);
            }
        } else {
            echo json_encode(["msg" => "Passwords do not match"]);

            $showError = "Passwords do not match";
        }
    }
    // header("Location:/cmsproject/index.php?signupsuccess=false&error=$showError");
}
?>




