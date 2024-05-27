<?php 
	include_once '../../includes/db.inc.php';
	if (isset($_POST['add'])) {
		$cname = $_POST['cname'];
		$website = $_POST['website'];
		$ctype = $_POST['ctype'];
		$status = $_POST['status'];
		$address = $_POST['address'];
		$phone = $_POST['telephone'];
		$salary_package = $_POST['salary_package'];

		$sql1 = "INSERT INTO `company` (`id`, `name`, `type`, `address`, `number`, `website`, `status`, `salary_package`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
		$stmt1 = mysqli_prepare($conn, $sql1);
		mysqli_stmt_bind_param($stmt1, 'ssssssd', $cname, $ctype, $address, $phone, $website, $status, $salary_package);
		$res1 = mysqli_stmt_execute($stmt1);
		if (!$res1) {
			?>
			<script>
				alert("Company could not be added");
				window.location.replace("../addcompanies.php?result=fail");
			</script>
			<?php
		} else {
			?>
			<script>
				alert("Company has been added successfully");
				window.location.replace("../viewcompanies.php?result=success");
			</script>
			<?php
		}
	}

	if (isset($_POST['update'])) {
		$cid = $_POST['cid'];
		$cname = $_POST['cname'];
		$website = $_POST['website'];
		$ctype = $_POST['ctype'];
		$status = $_POST['status'];
		$address = $_POST['address'];
		$phone = $_POST['telephone'];
		$minperc = $_POST['minperc'];

		$sql = "UPDATE company SET name=?, website=?, address=?, type=?, status=?, number=?, minperc=? WHERE id=?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, 'ssssssdi', $cname, $website, $address, $ctype, $status, $phone, $minperc, $cid);
		$res = mysqli_stmt_execute($stmt);
		if (!$res) {
			?>
			<script>
				alert("Company could not be updated");
				window.location.replace("../editcomp.php?result=fail");
			</script>
			<?php
		} else {
			?>
			<script>
				alert("Company has been updated");
				window.location.replace("../viewcompanies.php?result=success");
			</script>
			<?php
		}
	}
?>
