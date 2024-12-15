<?php

@include "config.php";


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
    <title>Student Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/student_page.css?v=<?php echo time(); ?>">
</head>

<body>
    <header>
        <a href='login.php'><button class='btn'>Logout</button></a>
        <h1>Student Dashboard</h1>
    </header>
    <!-- <main> -->
    <section id="notes-section">
        <h2>Notes Categories</h2>


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