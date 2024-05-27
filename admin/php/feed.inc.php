<?php 
	session_start();
	include_once '../../includes/db.inc.php';

	if (isset($_POST['post'])) {
		$message = $_POST['message'];
		$user = $_SESSION['username'];
		
		// Insert the message into the feed table
		$sql = "INSERT INTO feed (user, message, date, time) VALUES ('$user', '$message', CURDATE(), CURTIME())";
		$res = mysqli_query($conn, $sql);

		if (!$res) {
			header("Location: ../index.php?result=fail");
			exit(); // Exit to prevent further execution
		}

		// Function to send WhatsApp message
		function sendWhatsAppMessage($phone, $message) {
			// Construct the WhatsApp API URL with phone number and message content
			//$whatsappAPI = "https://web.whatsapp.com/accept?code=IDiaVQiUI1I3CMXs21j2oj" ;
			$whatsappAPI = "https://web.whatsapp.com/send?phone=" . "&text=" . urlencode($message); ;
			//. $phone . "&text=" . urlencode($message);

			// Redirect the user to the WhatsApp API link
			header("Location: " . $whatsappAPI);
			exit();
		}

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
    	    header("Location: ../index.php?result=success");
    	    exit();
    	} else {
    	    // If no students found, display error message
    	    echo "No students found.";
    	}
	}
?>
