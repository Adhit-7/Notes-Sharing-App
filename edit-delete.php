<?php
session_start();
include "config.php";


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["action"] == "edit") {
        $file = $_GET["file"];
        $category = $_GET["category"];
        $sql = "SELECT title FROM images WHERE image = '$file'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $title = $row["title"];
        } else {
            header("Location: teacher_page.php");
            exit();
        }
        
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Edit File</title>
            <link rel="stylesheet" type="text/css" href="css/edit-delete.css?v=<?php echo time(); ?>">

        </head>
        <body>
            <div class="container">
                <h2>Edit File</h2>

                <form method="post" action="edit-delete.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="file" value="<?php echo $file; ?>">
                    <label>Upload New file</label>
                    <input type="file" name="file-upload" id="file-upload"><br><br>
                    <label>Title</label>
                    <input type="text" name="title" value="<?php echo $title; ?>"><br><br>
                    <label>Category</label>
                    <select name="category">
                        <option value="empty" <?php if ($category == "empty")
                            echo "selected"; ?>>-</option>
                        <option value="CSIT" <?php if ($category == "CSIT")
                            echo "selected"; ?>>CSIT</option>
                        <option value="BCA" <?php if ($category == "BCA")
                            echo "selected"; ?>>BCA</option>
                        <option value="BIT" <?php if ($category == "BIT")
                            echo "selected"; ?>>BIT</option>
                        <option value="BBM" <?php if ($category == "BBM")
                            echo "selected"; ?>>BBM</option>
                        <option value="BBA" <?php if ($category == "BBA")
                            echo "selected"; ?>>BBA</option>
                    </select><br><br>
                    <button type="submit">Update</button>
                </form>
            </div>
        </body>

        </html>
        <?php
    } elseif ($_GET["action"] == "delete") {
        $file = $_GET["file"];
        $sql = "DELETE FROM images WHERE image = '$file'";
        if (mysqli_query($conn, $sql)) {
            header("Location: teacher_page.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "update") {
        $file = $_POST["file"];
        $title = $_POST["title"];
        $category = $_POST["category"];

        if ($_FILES["file-upload"]["error"] !== UPLOAD_ERR_NO_FILE) {
            $newFileName = $_FILES["file-upload"]["name"];
            $newFileTmp = $_FILES["file-upload"]["tmp_name"];


            $uploadsDir = "image/";
            move_uploaded_file($newFileTmp, $uploadsDir . $newFileName);



            $sql = "UPDATE images SET image = '$newFileName', title = '$title', category = '$category' WHERE image = '$file'";
        } else {
            $sql = "UPDATE images SET title = '$title', category = '$category' WHERE image = '$file'";
        }

        if (mysqli_query($conn, $sql)) {
            header("Location: teacher_page.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>