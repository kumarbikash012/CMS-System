<?php
session_start();

echo'<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/cmsproject">CMS System</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="/cmsproject">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Userpage.php">User Page</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="blueprints.php">Blue Prints</a>
    </li>
  </ul>
  <div class="row mx-2">';

if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])== true){
  echo   '<form class="form-inline my-2 my-lg-0">
  <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
  <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
  <p class="text-light my-0 mx-2">Welcome '. $_SESSION['useremail'].'</p>
  <a href="logout.php"class="btn btn-outline-success ml-2">Logout</a>


</form>';
}
else{
  echo'<form class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
  </form>
      <button class= "btn btn-outline-success ml-2" data-toggle="modal" data-target="#loginmodal">Login</button>
      <button class= "btn btn-outline-success mx-2" data-toggle="modal" data-target="#signupmodal">Signup</button>';
}

  echo'</div>
</div>
</nav>';


include 'signupmodal.php';
include 'loginmodal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']== "true"){
  echo "<div class='alert alert-primary my-0' role='alert'>
  You have successfully signed up!!
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
  <span aria-hidden='true'>&times</span>
</button>
</div>";  
}


?>




<!-- <?php
//session_start();

//echo '<nav class="navbar navbar-expand-lg bg-primary">
    // <div class="container">
    //   <a class="navbar-brand" href="#">CMS</a>
    //   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    //     <span class="navbar-toggler-icon"></span>
    //   </button>
    //   <div class="collapse navbar-collapse" id="navbarSupportedContent">
    //     <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    //       <li class="nav-item">
    //         <a class="nav-link active" href="#">Home</a>
    //       </li>
    //       <li class="nav-item">
    //         <a class="nav-link" href="#">Link</a>
    //       </li>
    //       <li class="nav-item dropdown">
    //         <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
    //           Dropdown
    //         </a>
    //         <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    //           <li><a class="dropdown-item" href="#">Action</a></li>
    //           <li><a class="dropdown-item" href="#">Another action</a></li>
    //           <li><hr class="dropdown-divider"></li>
    //           <li><a class="dropdown-item" href="#">Something else here</a></li>
    //         </ul>
    //       </li>
    //       <li class="nav-item">
    //         <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    //       </li>
    //     </ul>
    //        <div class="row mx-2">';   
            
           //if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            //echo '
//             <form class="form-inline my-2 my-lg-0">
//               <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
//               <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
//               <p class="text-light my-0 mx-2">Welcome ' . $_SESSION['useremail'] . '</p>
//               <a href="logout.php" class="btn btn-outline-success ml-2">Logout</a>
//             </form>';
//           } else {
//             echo '<form class="form-inline my-2 my-lg-0">
//               <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
//               <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
//             </form>
//             <button class="btn btn-outline-success ml-2" data-toggle="modal" data-target="#loginmodal">Login</button>
//             <button class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#signupmodal">Signup</button>';
//           }
          
//         echo'
//       </div></div> 
        
     
//   </nav>';

//   include 'signupmodal.php';
//   include 'loginmodal.php';
// if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']== "true"){
//   echo "<div class='alert alert-primary my-0' role='alert'>
//   You have successfully signed up!!
//   <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
//   <span aria-hidden='true'>&times</span>
// </button>
// </div>";  
//}
 // ?>  -->


<!-- <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">CMS</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav> -->
  


