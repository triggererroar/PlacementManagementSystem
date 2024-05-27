<?php
session_start();
include_once '../includes/db.inc.php';

if (isset($_GET['comp'])) {
    $company_name = mysqli_real_escape_string($conn, $_GET['comp']); // Escape the input to prevent SQL injection

    // SQL query to fetch the company ID and package based on the company name
    $get_company_info_sql = "SELECT id, salary_package FROM company WHERE name = ?";
    $stmt = $conn->prepare($get_company_info_sql);
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $company_id = $row['id'];
        $package = $row['salary_package'];

        $user = $_SESSION['username'];

        // Insert into the applied table with company ID, name, status, chances, and package
        $insert_sql = "INSERT INTO applied (company_id, company, name, status, chances, package) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $initial_status = 'Pending'; // Assuming the initial status is 'Pending'
        $initial_chances = 0; // Assuming the initial chances is 0
        $stmt->bind_param("isssis", $company_id, $company_name, $user, $initial_status, $initial_chances, $package);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            ?>
            <script>
                alert("You have applied for the company successfully!");
                window.location.replace("../viewapply.php");
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Apply Unsuccessful, Try Again!");
                window.location.replace("../viewapply.php");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("Invalid company name!");
            window.location.replace("../viewapply.php");
        </script>
        <?php
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
