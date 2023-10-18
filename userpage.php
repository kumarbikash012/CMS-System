<?php
// Connect to the database

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
// else{
//     echo"succes";
// }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>CMS sysytem</title>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <style>
        /* Style for the dropdown */
        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        /* Style for the selected option text */
        #selectedOption {
            margin-top: 10px;
            font-size: 18px;
            color: #007bff;
        }
        .bik{
            background-color: yellow;
        }
    </style>
</head>
<body>
<?php include 'header.php';?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['snoEdit'])) {
        $sno = $_POST['snoEdit'];
        $status = $_POST['statusEdit'];

        $updateSql = "UPDATE `data` SET `status` = ? WHERE `sno` = ? ";
        $stmt = mysqli_prepare($conn, $updateSql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $status, $sno);

            if (mysqli_stmt_execute($stmt)) {
                // Status updated successfully

                // Check if the status has been stored in the database
                $checkSql = "SELECT `status` FROM `data` WHERE `sno` = ? ";
                $checkStmt = mysqli_prepare($conn, $checkSql);

                if ($checkStmt) {
                    mysqli_stmt_bind_param($checkStmt, "i", $sno);
                    if (mysqli_stmt_execute($checkStmt)) {
                        mysqli_stmt_store_result($checkStmt);
                        if (mysqli_stmt_num_rows($checkStmt) > 0) {
                            echo json_encode(['success' => true, 'message' => 'Status updated and stored in the database successfully']);
                        } else {
                            echo json_encode(['success' => false, 'error' => 'Status updated but not stored in the database']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
                    }
                    mysqli_stmt_close($checkStmt);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Prepared statement error for checking the status: ' . mysqli_error($conn)]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['success' => false, 'error' => 'Prepared statement error: ' . mysqli_error($conn)]);
        }
    } else {
        // Handle other operations or show an error message if needed
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<div class="property">';
    $sql = "SELECT * FROM `data`";
    $result = mysqli_query($conn, $sql);
    $index = 0;
   echo"<h1 class='text-center'>You can Change the Status Here</h1>";
 while ($row = mysqli_fetch_assoc($result)) {
        $sno =  $row['sno'] ;
        $index = $index+1;
        echo "
        <h2 class='property-sno'>" . $index . "</h2>
              <h2 class='property-name'>" . $row['name'] . "</h2>
              <div class='property-details'>
                  <div class='property-image'>
                      <img style='height:200px; width:300px;' src='" . $row['image'] . "' alt='image description'>
                  </div>
                  <div class='property-info'>
                      <p class='property-location'>" . $row['location'] . "</p>
                      <p class='property-price'>Price: $" . $row['price'] . "</p>
                      <p class='property-description'>" . $row['description'] . "</p>
                      <div class='property-buttons'>";

        if ($_SESSION['role'] === 'admin') {
            echo '<form method="post" action="userpage.php">'; // Open a form for each item
            echo '<select class="bik" id="dropdown' . $sno . '" name="statusEdit">'; // Name attribute should be "statusEdit"
            echo '<option value="option1"></option>';
            echo '<option value="Pending">Pending</option>';
            echo '<option value="InProgress">InProgress</option>';
            echo '<option value="Active">Active</option>';
            echo '<option value="Done">Done</option>';
            echo '</select>';
            echo '<button type="submit" class="update-status-button" data-sno="' . $sno . '">Update Status</button>';
            echo '<div id="selectedOption' . $sno . '">Status: ' . $row['status'] . '</div>';

            // Hidden input fields within the form
            echo '<input type="hidden" name="snoEdit" value="' . $sno . '">'; // Use "hidden" input type
            echo '</form>'; // Close the form for each item
        } else {
            
            echo '<form method="post" action="userpage.php">'; // Open a form for each item
            echo '<select class="bik" id="dropdown' . $sno . '" name="statusEdit">'; // Name attribute should be "statusEdit"
            echo '<option value="option1"></option>';
            echo '<option value="Pending">Pending</option>';
            echo '<option value="InProgress">InProgress</option>';
            echo '<option value="Active">Active</option>';
            echo '<option value="Done">Done</option>';
            echo '</select>';
            echo '<button type="submit" class="update-status-button" data-sno="' . $sno . '">Update Status</button>';
            echo '<div id="selectedOption' . $sno . '">Status: ' . $row['status'] . '</div>';

            // Hidden input fields within the form
            echo '<input type="hidden" name="snoEdit" value="' . $sno . '">'; // Use "hidden" input type
            echo '</form>';
        }

        echo "</div>
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

// mysqli_close($conn);
?>








    

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" 
crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
<script>
                    function updateText(sno) {
                        var dropdown = document.getElementById("dropdown" + sno);
                        var selectedOption = document.getElementById("selectedOption" + sno);
                        var selectedText = dropdown.options[dropdown.selectedIndex].text;
                        selectedOption.innerHTML = "Status: " + selectedText;

                        // You can also send an AJAX request here for user status updates
                    }
                </script>


<script>
    function updateStatus(sno) {
        var dropdown = document.getElementById("dropdown" + sno);
        var selectedOption = document.getElementById("selectedOption" + sno);
        var selectedText = dropdown.options[dropdown.selectedIndex].text;

        // Send an AJAX request to update the status
        $.ajax({
            url: 'userpage.php',
            method: 'POST',
            data: {
                snoEdit: sno,  // Update the name of the field
                statusEdit: status // Update the name of the field
            },
            success: function (response) {
                if (response.success) {
                    selectedOption.innerHTML = "Status: " + selectedText;
                } else {
                    alert('Status update failed. Error: ' + response.error);
                }
            },
            error: function (xhr, status, error) {
                alert('Status update failed. Error: ' + error);
            }
        });
    }
</script>

</body>
</html>