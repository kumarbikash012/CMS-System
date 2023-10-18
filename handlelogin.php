<!-- <?php
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
$showError =false;
if($_SERVER["REQUEST_METHOD"]=="POST"){
    // include 'dbconnect.php';
    $email= $_POST['LoginEmail'];
    $pass= $_POST['loginpass'];

    //check wheather this emailexist or not

    $Sql= "SELECT * From `username` where user_email = '$email'";
    $result= mysqli_query($conn, $Sql);
    // $numRows= mysqli_num_rows($result);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row= mysqli_fetch_assoc($result);
            if(password_verify($pass,$row['user_pass'])){
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['sno']=$row['sno'];
                $_SESSION['useremail']=$email;
                $_SESSION['role'] = $row['role'];
                echo "logged in" . $email;

                if ($_SESSION['role'] === 'admin') {
                    header("Location:/cmsproject/index.php"); // Redirect to admin dashboard
                } else {
                    header("Location:/cmsproject/userpage.php"); // Redirect to user dashboard
                }
                exit();  
            }
            // header("Location:/cmsproject/index.php");
        }   
        // header("Location:/cmsproject/index.php");
        $showError = "Invalid email or password";
        header("Location: /cmsproject/index.php?loginerror=$showError");

  }

  ?>






