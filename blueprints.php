<?php
// session_start();

// Connect to the database
$insert = false;
$update = false;
$delete = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "cmssystem";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if the connection was not successful
if (!$conn) {
    die("Sorry, we failed to connect: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php include 'header.php';?>

<?php
if (isset($_POST['upload'])) {
    $pdfName = $_POST['pdf_name'];
    $pdfFileName = $_FILES['pdf_file']['name'];
    $pdfTmpName = $_FILES['pdf_file']['tmp_name'];
    $pdfFileType = $_FILES['pdf_file']['type'];
    
    // Specify the folder path to store PDFs
    $pdfFolder = "pdf_folder/";

    if ($pdfFileType == 'application/pdf') {
        $pdfPath = $pdfFolder . $pdfFileName;
        
        if (move_uploaded_file($pdfTmpName, $pdfPath)) {
            // Insert the PDF file name, details, and path into the database
            $insertQuery = "INSERT INTO pdf_files (file_name, file_details, file_data) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);

            if ($stmt) {
                $fileDetails = $pdfName;
                mysqli_stmt_bind_param($stmt, "sss", $pdfFileName, $fileDetails, $pdfPath);

                if (mysqli_stmt_execute($stmt)) {
                   echo" PDF file uploaded and inserted into the database successfully";
                //    header("Refresh:0");
                   
                      exit();
                return;
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Prepared statement error: " . mysqli_error($conn);
            }
        } else {
            echo "Error moving the file to the PDF folder.";
        }
    } else {
        echo "Only PDF files are allowed.";
    }
}
?>


<?php

if (isset($_GET['pdf_id'])) {
    $pdfId = $_GET['pdf_id'];

    $selectQuery = "SELECT file_details, file_name, file_data FROM pdf_files WHERE id = ?";
    $stmt = mysqli_prepare($conn, $selectQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $pdfId);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $pdfFileName, $pdfPath);
            mysqli_stmt_fetch($stmt);

            // Output the PDF file to the browser
            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename='" . $pdfFileName . "'");
            readfile($pdfPath);
        }
    }

    mysqli_stmt_close($stmt);
}

// Close your database connection here
?>


</div>



<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if ($_SESSION['role'] === 'admin') {
        echo '<div class="container my-3">
        <h1 class="text-center">Add New BluePrint</h1>
        <form action="/cmsproject/blueprints.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="pdf_file" class="form-label">PDF File</label>
                <input class="form-control" id="pdf_file" name="pdf_file" type="file">
            </div>
            <div class="mb-3">
                <label for="pdf_name" class="form-label">PDF Details</label>
                <input type="text" class="form-control" id="pdf_name" name="pdf_name" placeholder="PDF Details">
            </div>
            <button type="submit" class="btn btn-primary" name="upload">Submit</button>
        </form>
    </div>';
    }
    else{
       echo' <h1 class="text-center">You have to be admin to add blueprints</h1>';

    }

    echo '<div class="property">';
    $sql = "SELECT * FROM `pdf_files`";
    $result = mysqli_query($conn, $sql);
    $sno = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $sno = $sno + 1;
        echo "<h2 class='property-sno'>" . $sno . "</h2>
        <h2 class='property-name'>" . $row['file_details'] . "</h2>
        <div class='property-details'>
          <div class='property-image'>
            <embed src='pdf_folder/" . $row['file_name'] . "' width='800' height='600' type='application/pdf'>
          </div>
        </div>";
    }
    echo '</div>';
} else {
    echo '<div class="container my-4">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to User Interface</h1>
        <p class="lead">Here You can update the status of your work so that the owner will know what\'s happening</p>
        <hr class="my-4">
        <p>It\'s a very delightful page for you too so that the owner wont call you all the time about work & will not disturb you. You just update every work status, and he will understand the requirements. ALL THE BEST!!!
        </p>
        <br>
        <h3>But First You have to log in</h3>
    </div>
</div>';
}
?>



<div class="property">
  <?php
  $sql = "SELECT * FROM `pdf_files`";
  $result = mysqli_query($conn, $sql);
  $sno = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    $sno = $sno + 1;
    echo "
   ";
  }
  ?>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" 
crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>
</html>