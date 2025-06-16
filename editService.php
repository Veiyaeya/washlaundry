<?php

// Start the session
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Checks if there is a user logged in
if (!isset($_SESSION['adminID']) || isset($_SESSION['CustomerID'])) {
  
  // If not logged in, redirect to login page
  if (!isset($_SESSION['adminID'])) {
    header("Location: ../washette/loginAdmin.php");
    exit();
  } else {
    // If a customer is logged in, redirect to user home page
    header("Location: ../washette/userFolder/userHome.php");
    exit();
  }
}

// Database connection file
require_once('../classes/database.php');

// Create an instance of the database class
$con = new database();

// SweetAlert Initialization
$sweetAlertConfig = "";

// Fetch service_id from POST
$service_id = $_POST['service_id'] ?? null;

// Fetch service data based on the service_id
$service_data = $con->getServiceByID($service_id);

// Check if the form is submitted
if(isset($_POST['save'])) {

  // Get the form data
  $service_name = $_POST['service_name'];
  $service_desc = $_POST['service_desc'];
  $service_id = $_POST['service'];

  // Update service data
  $userID = $con->updateService($service_id, $service_name, $service_desc);

  // Success message if $userID is returned
    if($userID) {
      $sweetAlertConfig = "
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Service updated successfully.',
          confirmButtonText: 'Continue'
        }).then(() => {
          window.location.href = 'services.php';
        });
      </script>";
    } else {
      $sweetAlertConfig = "
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to update service. Please try again.',
          confirmButtonText: 'Try Again'
        });
      </script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Service</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="./package/dist/sweetalert2.css">
</head>

<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Edit Service</h2>

    <form method="POST" action="" class="bg-white p-4 rounded shadow-sm">

      <!-- Disabled input to store the service ID -->
      <div class="mb-3">
        <label for="service_id" class="form-label">Service ID</label>
        <!-- Disabled input for display only -->
        <input type="text" value="<?php echo $service_data['laundry_id']?>" id="service_id" class="form-control" disabled required>
        <!-- Hidden input for actual submission -->
        <input type="hidden" name="service" value="<?php echo $service_data['laundry_id']?>">
      </div>

      <!-- Input fields for service name -->
      <div class="mb-3">
        <label for="service_name" class="form-label">Service Name</label>
        <input type="text" name="service_name" value="<?php echo $service_data['laundry_name']?>" id="service_name" class="form-control" placeholder="Enter your new service name" required>
      </div>

      <!-- Input fields for service description -->
      <div class="mb-3">
        <label for="service_desc" class="form-label">Service Description</label>
        <input type="text" name="service_desc" value="<?php echo $service_data['laundry_desc']?>" id="service_desc" class="form-control" placeholder="Enter your new service description" required>
      </div>

      <button type="submit" name="save" class="btn btn-primary w-100">Save</button>
      
    </form>
  </div>
  
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
  <script src="./package/dist/sweetalert2.js"></script>
  <?php echo $sweetAlertConfig; ?>

</body>
</html>