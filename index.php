<?php
// Connect to the database
$insert = false;
$update = false;
$delete = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "cmssystem";

// Creating a connection here 
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if the connection was not successful
if (!$conn) {
    die("Sorry, we failed to connect: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['snoEdit'])) {
        
        $sno = $_POST['snoEdit'];
        $name = $_POST['nameEdit'];
        $description = $_POST['descriptionEdit'];
        $location = $_POST['locationEdit'];
        $price = $_POST['priceEdit'];

        // Checking if a new image was uploaded
        if (isset($_FILES["imageEdit"]) && $_FILES["imageEdit"]["error"] === UPLOAD_ERR_OK) {
            $image = $_FILES["imageEdit"]["name"];
            $target_dir = "images/";
            $target_file = $target_dir . basename($image);

            if (move_uploaded_file($_FILES["imageEdit"]["tmp_name"], $target_file)) {
                // Preparing a SQL statement to select the old image
                $oldImageSql = "SELECT `image` FROM `data` WHERE `sno`=?";
                $stmtSelect = mysqli_prepare($conn, $oldImageSql);
                mysqli_stmt_bind_param($stmtSelect, "i", $sno);
                mysqli_stmt_execute($stmtSelect);
                $resultSelect = mysqli_stmt_get_result($stmtSelect);

                if ($row = mysqli_fetch_assoc($resultSelect)) {
                    $oldImagePath = $row['image'];

                    // Deleting the old image from the server
                    if (!empty($oldImagePath)) {
                        unlink($oldImagePath);
                    }

                    // Preparing a SQL statement to update the record with the new image
                    $updateImageSql = "UPDATE `data` SET `name`=?, `image`=?, `location`=?, `price`=?, `description`=? WHERE `sno`= ?";
                    $stmtUpdate = mysqli_prepare($conn, $updateImageSql);
                    mysqli_stmt_bind_param($stmtUpdate, "sssssi", $name, $target_file, $location, $price, $description, $sno);
                    mysqli_stmt_execute($stmtUpdate);

                    if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {
                        $update = true;
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "There is something wrong with this code: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "Sorry, there was an error uploading your new image file.";
            }
        } else {
            
            $updateSql = "UPDATE `data` SET `name`=?, `location`=?, `price`=?, `description`=? WHERE `sno`=?";
            $stmtUpdate = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($stmtUpdate, "ssssi", $name, $location, $price, $description, $sno);
            mysqli_stmt_execute($stmtUpdate);

            if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {
                $update = true;
                header("Location: index.php");
                exit();
            } else {
                echo "There is something wrong with this code: " . mysqli_error($conn);
            }
        }
    } else {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $location = $_POST["location"];
        $price = $_POST["price"];

        // Checking if a file was uploaded successfully
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $image = $_FILES["image"]["name"];
            $target_dir = "images/";
            $target_file = $target_dir . basename($image);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Preparing a SQL statement to insert a new record with the image
                $insertSql = "INSERT INTO `data` (`name`, `image`, `location`, `price`, `description`) VALUES (?, ?, ?, ?, ?)";
                $stmtInsert = mysqli_prepare($conn, $insertSql);
                mysqli_stmt_bind_param($stmtInsert, "sssss", $name, $target_file, $location, $price, $description);
                mysqli_stmt_execute($stmtInsert);

                if (mysqli_stmt_affected_rows($stmtInsert) > 0) {
                    $insert = true;
                    // Redirecting to index.php after successful insertion
                    header("Location: index.php");
                    exit();
                } else {
                    echo "There is something wrong with this code: " . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "No file was uploaded or an error occurred during upload.";
        }
    }
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];

    if (is_numeric($sno)) {
        $deleteImageSql = "SELECT `image` FROM `data` WHERE `sno`=?";
        $stmtSelect = mysqli_prepare($conn, $deleteImageSql);
        mysqli_stmt_bind_param($stmtSelect, "i", $sno);
        mysqli_stmt_execute($stmtSelect);
        $resultSelect = mysqli_stmt_get_result($stmtSelect);

        if ($row = mysqli_fetch_assoc($resultSelect)) {
            $deleteImagePath = $row['image'];

            if ($deleteImagePath) {
                // Deleting the image file from the server
                unlink($deleteImagePath);

                // Preparing a SQL statement to delete the record
                $deleteSql = "DELETE FROM `data` WHERE `sno` = ?";
                $stmtDelete = mysqli_prepare($conn, $deleteSql);
                mysqli_stmt_bind_param($stmtDelete, "i", $sno);
                mysqli_stmt_execute($stmtDelete);

                if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
                    $delete = true;
                    header("Location: index.php");
                    exit();
                } else {
                    echo "There is something wrong with this code: " . mysqli_error($conn);
                }
            }
        }
    } else {
        echo "Invalid 'sno' value for deletion.";
    }
}
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $deleteImageSql = "SELECT `image` FROM `data` WHERE `sno`='$sno'";
  $deleteImageResult = mysqli_query($conn, $deleteImageSql);
  $deleteImagePath = mysqli_fetch_assoc($deleteImageResult)['image'];

  if ($deleteImagePath) {
      unlink($deleteImagePath);

      $deleteSql = "DELETE FROM `data` WHERE `sno` = $sno";
      $result = mysqli_query($conn, $deleteSql);

      if ($result) {
          $delete = true;
          header("Location: index.php");
          exit();
      } else {
          echo "There is something wrong with this code: " . mysqli_error($conn);
      }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>CMS sysytem</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" 
crossorigin="anonymous">
</script>
</head>
<body>
<?php include 'header.php';?>

<?php
    if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])== true){
    echo'<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Update Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/cmsproject/index.php?update=true" method="post" enctype="multipart/form-data" >
            <input type="hidden" name="snoEdit" id= "snoEdit">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="nameEdit" name="nameEdit" placeholder="">
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input class="form-control form-control-lg" id="imageEdit" name="imageEdit" type="file">
              </div>
              <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="locationEdit" name="locationEdit" placeholder="">
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">price</label>
                <input type="number" class="form-control" id="priceEdit" name="priceEdit" placeholder="">
              </div>
              <div class="mb-3">
                <label for="desc" class="form-label">Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>
              <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>';
    }

    // else{

    //     echo ' 
    //     <div class="container">
    //   <h1 class="py-2">Please Log In</h1>
    //   <p class="lead">You need to be logged in to update something.</p>
    //   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginmodal">Login</button>
    // </div>';
        
    // }

    ?>




<?php 
 if ($insert) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Successfully Inserted.</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

if ($update) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Successfully Updated.</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

if ($delete) {
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Record Deleted.</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

?>
<?php
    if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])== true){

      if ($_SESSION['role'] === 'admin'){
    echo'<div class="container my-3 ">
    <h1 class="text-center">Add New Property</h1>
    <form action="/cmsproject/index.php" method="post" enctype="multipart/form-data" >
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Bikash">
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input class="form-control form-control-lg" id="image" name="image" type="file">
      </div>
      <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" id="location" name="location" placeholder="Odisha">
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">price</label>
        <input type="number" class="form-control" id="price" name="price" placeholder="Rs 1200">
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>';
}

else{
  echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>You dont have admin acces </strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}

    }

    else{

        echo ' 
        <div class="container">
        <h1 class="text-center">See New Property</h1>
        <p class="lead text-center " >You Need To Logged In To Add a Property, edit or Delete any thing </p></div>';
        
    }

    ?>

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  echo '<div class="property">';
  $sql = "SELECT * FROM `data`";
  $result = mysqli_query($conn, $sql);
  $index = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    $sno = $row['sno'];
    $index = $index + 1;
    echo "
    <div class='property-item'>
      <h2 class='property-sno'>" . $index . "</h2>
      <h2 id='name" . $row['sno'] . "' class='property-name'>" . $row['name'] . "</h2>
      <div class='property-details'>
        <div class='property-image'>
          <img id='image" . $row['sno'] . "' style='height:200px; width:300px;' src='" . $row['image'] . "' alt='image description'>
        </div>
        <div class='property-info'>
          <p id='location" . $row['sno'] . "' class='property-location'>" . $row['location'] . "</p>
          <p id='price" . $row['sno'] . "' class='property-price'>Price: $" . $row['price'] . "</p>
          <p id='desc" . $row['sno'] . "' class='property-description'>" . $row['description'] . "</p>
          <div class='property-buttons'>";
          if ($_SESSION['role'] === 'admin') {
            echo "<button class='edit btn btn-sm btn-primary edit-button' id='" . $row['sno'] . "'>Edit</button>";
            echo "<button class='deletes btn btn-sm btn-danger delete-button' id='d" . $row['sno'] . "'>Delete</button>";
          }
    echo "</div>
        </div>
      </div>
    </div>";
  }
  echo '</div>';
} else {
  // User is not logged in, displaying data without edit and delete buttons
  echo '<div class="property">';
  $sql = "SELECT * FROM `data`";
  $result = mysqli_query($conn, $sql);
  $index =0;
  while ($row = mysqli_fetch_assoc($result)) {
    $index = $index+1;
    echo "
    <div class='property-item'>
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
        </div>
      </div>
    </div>";
  }
  echo '</div>';
}
?>




  

 








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script>


edits = document.getElementsByClassName('edit-button');
Array.from(edits).forEach((element) => {
  element.addEventListener("click", (e) => {
    alert(e.target.id); 
    let row = e.target.closest(".property"); // Find the closest ancestor with class "property"
    let name = $(`#name${e.target.id}`)[0].innerText;

    let imageSrc = $(`#image${e.target.id}`).attr('src');
    let location = $(`#location${e.target.id}`)[0].innerText;
    let price = $(`#price${e.target.id}`)[0].innerText;
    let description = $(`#desc${e.target.id}`)[0].innerText;

    // Set modal input values
    descriptionEdit.value = description;
    nameEdit.value = name;
    image.src = imageSrc; // Display the image in an <img> element
    priceEdit.value = price;
    locationEdit.value = location;
    snoEdit.value = e.target.id; // Get the id attribute from the clicked "Edit" button
    console.log(snoEdit.value);
    
    // Use jQuery to toggle the modal
    $('#editModal').modal('toggle');

    console.log(name, imageSrc, location, price, description);
  });
});



  deletes = document.getElementsByClassName('deletes');
  Array.from(deletes).forEach((element) => {
    element.addEventListener("click", (e) => {
      console.log("delete");
     sno = e.target.id.substr(1,);
    //  alert(sno); return

      if(confirm("Press a button!")) {
        console.log("Yes");
        window.location = `/cmsproject/index.php?delete=${sno}`;
      }
      else{
        console.log("No");
      }

    });
  });
</script>



</body>
</html>

<!-- DELETE FROM `data` WHERE `data`.`sno` = 1 -->
