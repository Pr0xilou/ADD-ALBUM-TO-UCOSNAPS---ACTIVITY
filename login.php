<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
    <style>
		/* Basic Reset */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f7fc;
			color: #333;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
		}
		.container {
			background-color: white;
			padding: 30px;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			width: 100%;
			max-width: 400px;
			text-align: center;
		}
		h1 {
			font-size: 24px;
			color: #333;
			margin-bottom: 20px;
		}
		form {
			display: flex;
			flex-direction: column;
			align-items: stretch;
		}
		label {
			text-align: left;
			font-size: 14px;
			color: #555;
			margin-bottom: 5px;
		}
		input[type="text"],
		input[type="password"] {
			padding: 12px;
			margin-bottom: 15px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
			width: 100%;
		}
		input[type="submit"] {
			padding: 12px;
			border: none;
			background-color: #4CAF50;
			color: white;
			font-size: 16px;
			border-radius: 4px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			width: 100%;
		}
		input[type="submit"]:hover {
			background-color: #45a049;
		}
		.error,
		.success {
			margin-bottom: 20px;
			font-size: 16px;
			font-weight: bold;
		}
		.error {
			color: red;
		}
		.success {
			color: green;
		}
		p {
			font-size: 14px;
		}
		a {
			color: #4CAF50;
			text-decoration: none;
		}
		a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

		if ($_SESSION['status'] == "200") {
			echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
		}

		else {
			echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
		}

	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	<h1>Login Now!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="username">Password</label>
			<input type="password" name="password">
			<input type="submit" name="loginUserBtn" style="margin-top: 25px; ">
		</p>
	</form>
	<p>Don't have an account? You may register <a href="register.php">here</a></p>
</body>
</html>