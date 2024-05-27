<?php
// Include necessary files and initialize variables
include_once 'php/feed.inc.php';
session_start();

// Check if the form is submitted
if(isset($_POST['post'])) {
    // Get the message content from the form
    $message = $_POST['message'];

    // Construct the SQL query to fetch phone numbers of all students
    $sql = "SELECT phone FROM studentlogin";
    $result = mysqli_query($conn, $sql);

    // Check if there are students in the database
    if(mysqli_num_rows($result) > 0) {
        // Loop through each student and send WhatsApp message
        while($row = mysqli_fetch_assoc($result)) {
            $phone = $row['phone']; // Get student's phone number

            // Construct the WhatsApp message content
            $whatsappMessage = "Hello, \n\n" . $message;

            // Send WhatsApp message using the WhatsApp API
            sendWhatsAppMessage($phone, $whatsappMessage);
        }

        // Close the database connection
        mysqli_close($conn);

        // Redirect back to the feed page or display success message
        header("Location: feed.php?success=1");
        exit();
    } else {
        // If no students found, display error message
        echo "No students found.";
    }
}

// Function to send WhatsApp message
function sendWhatsAppMessage($phone, $message) {
    // Construct the WhatsApp API URL with phone number and message content
    $whatsappAPI = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . urlencode($message);

    // Redirect the user to the WhatsApp API link
    header("Location: " . $whatsappAPI);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
</head>
<body>
    <h1>Message Sent Successfully!</h1>
</body>
</html>
