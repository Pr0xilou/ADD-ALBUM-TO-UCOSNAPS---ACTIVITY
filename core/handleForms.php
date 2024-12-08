<?php  
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
			$_SESSION['message'] = $insertQuery['message'];

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$usernameFromDB = $loginQuery['userInfoArray']['username'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			header("Location: ../index.php");
		}

		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}

}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['user_id']);
	unset($_SESSION['username']);
	header("Location: ../login.php");
}


if (isset($_POST['insertPhotoBtn'])) {
    // Get Description
    $description = $_POST['photoDescription'];

    // Get file name
    $fileName = $_FILES['image']['name'];

    // Get temporary file name
    $tempFileName = $_FILES['image']['tmp_name'];

    // Get file extension
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Generate random characters for image name
    $uniqueID = sha1(md5(rand(1,9999999)));

    // Combine image name and file extension
    $imageName = $uniqueID.".".$fileExtension;

    // Get the selected album ID (if any)
    $album_id = isset($_POST['album_id']) ? $_POST['album_id'] : null;

    // Save image 'record' to database (including album_id)
    $saveImgToDb = insertPhoto($pdo, $imageName, $_SESSION['username'], $description, null, $album_id);

    // Store actual 'image file' to images folder
    if ($saveImgToDb) {
        // Specify path
        $folder = "../images/".$imageName;

        // Move file to the specified path 
        if (move_uploaded_file($tempFileName, $folder)) {
            header("Location: ../index.php");
        }
    }
}
if (isset($_POST['deletePhotoBtn'])) {
	$photo_name = $_POST['photo_name'];
	$photo_id = $_POST['photo_id'];
	$deletePhoto = deletePhoto($pdo, $photo_id);

	if ($deletePhoto) {
		unlink("../images/".$photo_name);
		header("Location: ../index.php");
	}

}
if (isset($_POST['createAlbumBtn'])) {
    $album_name = trim($_POST['album_name']);
    if (!empty($album_name)) {
        createAlbum($pdo, $album_name, $_SESSION['username']);
        header("Location: ../index.php");
    } else {
        $_SESSION['message'] = "Album name cannot be empty!";
        $_SESSION['status'] = '400';
        header("Location: ../index.php");
    }
}
if (isset($_POST['editAlbumBtn'])) {
    $album_name = trim($_POST['album_name']);
    $album_id = $_POST['album_id'];
    if (!empty($album_name)) {
        updateAlbum($pdo, $album_id, $album_name);
        header("Location: ../index.php");
    } else {
        $_SESSION['message'] = "Album name cannot be empty!";
        $_SESSION['status'] = '400';
        header("Location: ../index.php");
    }
}
if (isset($_GET['deleteAlbumBtn'])) {
    $album_id = $_GET['album_id'];
    deleteAlbum($pdo, $album_id);
    header("Location: ../index.php");
}