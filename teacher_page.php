
<?php 
@include "config.php";

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_FILES["file-upload"]) &&
    !isset($_SESSION["upload_processed"])
) {
    if ($_FILES["file-upload"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $category = $_POST["category"];
        if(isset($_POST['title'])) {
            $title = $_POST['title'];
        } else {
            $title = ""; 
        }
        $file_name = $_FILES["file-upload"]["name"];
        $file_tmp = $_FILES["file-upload"]["tmp_name"];

        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_ext !== "pdf") {
            echo "Error: Only PDF files are allowed.";
        }
        else{
        echo "The Category from the User is " . $category;
        }
        $uploads_dir = "image/";
        move_uploaded_file($file_tmp, $uploads_dir . $file_name);


        $sql = "INSERT INTO `images` (image, category, title) VALUES ('$file_name', '$category','$title')";

        if (mysqli_query($conn, $sql)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    else {
        echo "Please select a file to upload.";
    }
}

$sql = "SELECT image, category,title FROM images";
$result = mysqli_query($conn, $sql);
$files_by_category = [];
$csitArray = [];
$bitArray = [];
$bbaArray = [];
$bcaArray = [];
$bbmArray = [];

while ($row = mysqli_fetch_assoc($result)) {
   
    $categories = $row["category"];
    $file_name = $row["image"];
    $title = isset($row["title"]) ? $row["title"] : "";
    $files_by_category[$categories][] = $file_name;
    if ($categories == "CSIT") {
    
        array_push($csitArray, array("file" => $file_name, "title" => $title));
    }
    else if ($categories == "BCA") {
        array_push($bcaArray, array("file" => $file_name, "title" => $title));
    }
    else if ($categories == "BIT") {
    
        array_push($bitArray, array("file" => $file_name, "title" => $title));
    }
    else if ($categories == "BBA") {
        array_push($bbaArray, array("file" => $file_name, "title" => $title));
    }
    else if ($categories == "BBM") {
        array_push($bbmArray, array("file" => $file_name, "title" => $title));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/teacher_page.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <a href = 'login.php' ><button class = 'btn'>Logout</button></a> 
        <h1>Teacher Dashboard</h1>
    </header>
    <main>
        <section id="upload-section">
        <h2>Upload Notes</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" class="form-control" name="file-upload" id="file-upload" multiple>
            <select name="category" id="category-select">
                <option value="CSIT">CSIT</option>
                <option value="BCA">BCA</option>
                <option value="BIT">BIT</option>
                <option value="BBM">BBM</option>
                <option value="BBA">BBA</option>
            </select>
            <label>Title</label>
            <input type="text" name="title" class="form-control"><nbsm>
            <button type="submit" name ="form-submit" class="upload-btn">Upload</button>
        </form>
    </section>
</main>
    <section id="notes-section">
    <h2 style="margin: 20px;max-width: 99%;">Notes Categories</h2>
        
        
        <div id="categories">
                <div class="category" id="CSIT">
                    <h3>CSIT</h3>
                    <div class="notes-list" id="CSIT-notes">
                    </div>
                    <?php foreach($csitArray as $file) {
                      echo "<div class='pdf-container'>";
                      echo "<embed src='image/{$file['file']}' width='auto' height='auto' type='application/pdf'>";
                      echo "</div>";
                  
                      echo "<div class='pdf-container'>";
                      echo "<p>Title: {$file['title']}</p> "; 
                      echo "<a href='image/{$file['file']}' target='_blank'><button>View Full PDF</button></a> ";
                      echo "<a href='download.php?file={$file['file']}' target='_download'><button>Download PDF</button></a>";
                      echo "<a href='edit-delete.php?action=edit&file={$file['file']}&category={$categories}'><button>Edit</button></a>";
                      echo "<a href='edit-delete.php?action=delete&file={$file['file']}'><button>Delete</button></a>";

                      echo "</div>";
                  
                      echo "<br>"; 
                  }
                    
                    ?>

                    
                </div>
                <div class="category" id="BCA">
                    <h3>BCA</h3>
                    <div class="notes-list" id="BCA-notes">
                    <?php foreach($bcaArray as $file) {
                      echo "<div class='pdf-container'>";
                      echo "<embed src='image/{$file['file']}' width='auto' height='auto' type='application/pdf'>";
                      echo "</div>";
                  
                      echo "<div class='pdf-container'>";
                      echo "<p>Title: {$file['title']}</p>"; 
                      echo "<a href='image/{$file['file']}' target='_blank'><button>View Full PDF</button></a> ";
                      echo "<a href='download.php?file={$file['file']}' target='_download'><button>Download PDF</button></a>";
                      echo "<a href='edit-delete.php?action=edit&file={$file['file']}&category={$categories}'><button>Edit</button></a>";
                      echo "<a href='edit-delete.php?action=delete&file={$file['file']}'><button>Delete</button></a>";

                      echo "</div>";
                  
                      echo "<br>"; 
                    }
                    ?>
                        
                </div>
            </div>
            <div class="category" id="BIT">
                <h3>BIT</h3>
                <div class="notes-list" id="BIT">
                <?php foreach($bitArray as $file) {
                      echo "<div class='pdf-container'>";
                      echo "<embed src='image/{$file['file']}' width='auto' height='auto' type='application/pdf'>";
                      echo "</div>";
                  
                      echo "<div class='pdf-container'>";
                      echo "<p>Title: {$file['title']}</p>"; 
                      echo "<a href='image/{$file['file']}' target='_blank'><button>View Full PDF</button></a> ";
                      echo "<a href='download.php?file={$file['file']}' target='_download'><button>Download PDF</button></a>";
                      echo "<a href='edit-delete.php?action=edit&file={$file['file']}&category={$categories}'><button>Edit</button></a>";
                      echo "<a href='edit-delete.php?action=delete&file={$file['file']}'><button>Delete</button></a>";
 
                      echo "</div>";
                  
                      echo "<br>"; 
                    }
                    ?>
     
                </div>
            </div>
            <div class="category" id="BBM">
                    <h3>BBM</h3>
                    <div class="notes-list" id="BBM-notes">
                       
                       <?php foreach($bbmArray as $file){
                         echo "<div class='pdf-container'>";
                         echo "<embed src='image/{$file['file']}' width='auto' height='auto' type='application/pdf'>";
                         echo "</div>";
                     
                         echo "<div class='pdf-container'>";
                         echo "<p>Title: {$file['title']}</p>"; 
                         echo "<a href='image/{$file['file']}' target='_blank'><button>View Full PDF</button></a> ";
                         echo "<a href='download.php?file={$file['file']}' target='_download'><button>Download PDF</button></a>";
                         echo "<a href='edit-delete.php?action=edit&file={$file['file']}&category={$categories}'><button>Edit</button></a>";
                         echo "<a href='edit-delete.php?action=delete&file={$file['file']}'><button>Delete</button></a>";

                         echo "</div>";

                         echo "<br>"; 
                       }
                    ?>
                    </div>
                </div>
                <div class="category" id="BBA">
                    <h3>BBA</h3>
                    <div class="notes-list" id="BBA-notes">
                    <?php foreach($bbaArray as $file) {
                          echo "<div class='pdf-container'>";
                          echo "<embed src='image/{$file['file']}' width='auto' height='auto' type='application/pdf'>";
                          echo "</div>";
                      
                          echo "<div class='pdf-container'>";
                          echo "<p>Title: {$file['title']}</p>"; 
                          echo "<a href='image/{$file['file']}' target='_blank'><button>View Full PDF</button></a> ";
                          echo "<a href='download.php?file={$file['file']}' target='_download'><button>Download PDF</button></a>";
                          echo "<a href='edit-delete.php?action=edit&file={$file['file']}&category={$categories}'><button>Edit</button></a>";
                          echo "<a href='edit-delete.php?action=delete&file={$file['file']}'><button>Delete</button></a>";

                          echo "</div>";
                      
                          echo "<br>"; 
                    }
                    ?>
                     
                    </div>
                </div>
            </div>
        </div>
</section>

</main>
</body>
</html>