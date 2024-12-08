<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALOPIT NA ALBUM MAKER</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding: 20px;
        }

        h1, h2, h3, h4 {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Navbar styling */
        .navbar {
            width: 100%;
            padding: 15px 20px;
            background-color: #3CAEA3;
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .navbar a {
            color: white;
            font-size: 18px;
            margin-left: 15px;
        }

        .navbar a:hover {
            color: #f0f0f0;
        }

        /* Form Styling */
        form {
            width: 100%;
            max-width: 500px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        form p {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="file"],
        select,
        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Image and Album Containers */
        .albumContainer {
            width: 100%;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .albumContainer h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .albumContainer a {
            margin-right: 15px;
            font-size: 16px;
        }

        .albumContainer img {
            width: 100%;
            max-width: 150px;
            margin: 5px;
            border-radius: 5px;
        }

        .images {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .photoContainer {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 48%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .photoContainer img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .photoDescription {
            padding: 15px;
        }

        .photoDescription h2 {
            font-size: 18px;
            font-weight: 600;
            color: #4CAF50;
        }

        .photoDescription p {
            font-size: 14px;
            color: #777;
        }

        .photoDescription h4 {
            font-size: 16px;
            color: #333;
            margin-top: 10px;
        }

        .photoDescription a {
            color: #4CAF50;
            font-size: 14px;
        }

        .photoDescription a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .images .photoContainer {
                width: 100%;
            }

            .albumContainer {
                max-width: 100%;
            }
        }

        /* Styling for Create Album Form */
        .createAlbumForm {
            width: 100%;
            max-width: 500px;
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .createAlbumForm form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .createAlbumForm input[type="text"] {
            margin-bottom: 15px;
        }

        .createAlbumForm button {
            width: 100%;
        }

        /* Margin and Padding for Structure */
        .margin-top {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <p>
            <label for="#">Description</label>
            <input type="text" name="photoDescription">
        </p>
        <p>
            <label for="#">Photo Upload</label>
            <input type="file" name="image">
        </p>
        <p>
            <label for="#">Select Album</label>
            <select name="album_id">
                <option value="">None</option> 
                <?php
                    $getAllAlbums = getAllAlbums($pdo, $_SESSION['username']);
                    foreach ($getAllAlbums as $album) {
                        echo "<option value='" . $album['album_id'] . "'>" . $album['album_name'] . "</option>";
                    }
                ?>
            </select>
        </p>
        <input type="submit" name="insertPhotoBtn" style="margin-top: 10px;">
    </form>
    
    <div class="createAlbumForm" style="display: flex; justify-content: center;">
        <form action="core/handleForms.php" method="POST">
            <label for="album_name">Album Name</label>
            <input type="text" name="album_name" required>
            <button type="submit" name="createAlbumBtn">Create Album</button>
        </form>
    </div>

    <?php $getAllPhotos = getAllPhotos($pdo); ?>
    <?php foreach ($getAllPhotos as $row) { ?>
        <div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
            <div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">
                <img src="images/<?php echo $row['photo_name']; ?>" alt="" style="width: 100%;">
                <div class="photoDescription" style="padding:25px;">
                    <a href="profile.php?username=<?php echo $row['username']; ?>"><h2><?php echo $row['username']; ?></h2></a>
                    <p><i><?php echo $row['date_added']; ?></i></p>
                    <h4><?php echo $row['description']; ?></h4>

                    <?php if ($_SESSION['username'] == $row['username']) { ?>
                        <a href="editphoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Edit </a>
                        <br>
                        <br>
                        <a href="deletephoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Delete</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $getAllAlbums = getAllAlbums($pdo, $_SESSION['username']);
    foreach ($getAllAlbums as $album) {
    ?>
        <div class="albumContainer">
            <h3><?php echo $album['album_name']; ?></h3>
            <a href="editAlbum.php?album_id=<?php echo $album['album_id']; ?>">Edit</a>
            <a href="core/handleForms.php?deleteAlbumBtn=true&album_id=<?php echo $album['album_id']; ?>" onclick="return confirm('Are you sure you want to delete this album?')">Delete</a>
            
            <?php
            $photosInAlbum = getPhotosInAlbum($pdo, $album['album_id']);
            foreach ($photosInAlbum as $photo) {
            ?>
                <img src="images/<?php echo $photo['photo_name']; ?>" alt="Photo">
            <?php } ?>
        </div>
    <?php } ?>               
</body>
</html>
