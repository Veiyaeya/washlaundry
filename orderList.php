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

// Connect to Database
require_once('../classes/database.php');
$con = new database();

// Set Customer Name
$_SESSION['adminName'] = $_SESSION['adminFN'] . " " . $_SESSION['adminLN'];

// Initialize a variable to hold the SweetAlert configuration
$sweetAlertConfig = "";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order List - Washette Laundromat</title>
    <link rel="icon" type="image/png" href="img/icon.png" />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
      crossorigin="anonymous"
    />
    <!-- FontAwesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />  
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin.css" />
  </head>
  <body>
    <!-- particles background -->
    <div
      id="tsparticles"
      style="
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: -1;
      "
    ></div>

    <!-- Recent Order Card -->
    <div class="order-card-container mb-4">
      <div class="card p-4 no-hover-effect">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="card-title mb-0">
            <i class="fas fa-clock me-2"></i>Recent Order
          </div>
          <button
            type="button"
            class="btn btn-sm filter-btn"
            style="background:  #395c58; color: #baebe6"
            onclick="window.history.back();"
          >
            <i class="fas fa-arrow-left me-1"></i>Back
          </button>
        </div>
        <div class="orders table-responsive">
          <table class="transaction-table align-middle" id="recentOrderTable">
            <thead>
              <tr>
                <th scope="col">Transaction ID</th>
                <th scope="col">Date</th>
                <th scope="col">Service</th>
                <th scope="col">Status</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>

                  <!-- Fetch students from the database -->
                  <?php

                  // Prepare the SQL statement to fetch students
                  $transactions = $con->getLatestOrder();

                  // For each student, create a table row
                  // Assuming $students is an array of associative arrays
                  // Each associative array contains student_ID, student_FN, student_LN, student_email, and course_name
                  foreach ($transactions as $transaction) {
                    ?>

                    <tr>
                      <td>

                        <?php echo $transaction['TransactionID']; ?>
                      </td>

                      </td>
                      <td>

                        <?php echo $transaction['CustomerName']; ?>

                      </td>
                      <td>
                      <td>

                        <?php echo $transaction['FormattedDate']; ?>

                      </td>
                      <td>

                        <?php echo $transaction['Services']; ?>

                      </td>
                      <td>

                        <span class="glass-badge completed"><?php echo $transaction['Status']; ?></span>

                      </td>
                      <td>

                        <?php echo $transaction['TransacTotalAmount']; ?>

                      </td>
                    </tr>
                  </tbody>

                  <!-- Close the foreach loop -->
                  <?php

                  }

                  ?>
          </table>
        </div>
      </div>
    </div>

    <!-- main order content -->
    <div class="order-card-container">
      <!-- Laundry Transaction History Card -->
      <div class="card p-4 no-hover-effect">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="card-title mb-0">
            <i class="fas fa-box me-2"></i>Order List
          </div>
          <div class="d-flex align-items-center" style="gap: 10px">
            <input class="search" placeholder="Search" />
          </div>
        </div>
        <div class="orders table-responsive">
          <table class="transaction-table align-middle" id="ordersTable">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Date</th>
                <th scope="col">Service</th>
                <th scope="col">Status</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>

                  <!-- Fetch students from the database -->
                  <?php

                  // Prepare the SQL statement to fetch students
                  $transactions = $con->getAllTransactions();

                  // For each student, create a table row
                  // Assuming $students is an array of associative arrays
                  // Each associative array contains student_ID, student_FN, student_LN, student_email, and course_name
                  foreach ($transactions as $transaction) {
                    ?>

                    <tr>
                      <td>

                        <?php echo $transaction['TransactionID']; ?>
                      </td>

                      </td>
                      <td>

                        <?php echo $transaction['CustomerName']; ?>

                      </td>
                      <td>
                      <td>

                        <?php echo $transaction['FormattedDate']; ?>

                      </td>
                      <td>

                        <?php echo $transaction['Services']; ?>

                      </td>
                      <td>

                        <span class="glass-badge completed"><?php echo $transaction['Status']; ?></span>

                      </td>
                      <td>

                        <?php echo $transaction['TransacTotalAmount']; ?>

                      </td>
                    </tr>
                  </tbody>

                  <!-- Close the foreach loop -->
                  <?php

                  }

                  ?>
          </table>
        </div>
      </div>
    </div>

    <!-- scripts for frontend functionality -->
    <script src="userscript.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
    <script src="/particles.js"></script>
  </body>
</html>
