<?php
$debug = false;
//include(dirname(__DIR__) . '/components/hide_warnings.php');


require_once('../../assets/components/functions.php');
require_once('../../config/dbaccess.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_paths'])) {
    // Process file upload
    $targetDir = "../../uploads/news";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if the file is an actual image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        $allowedTypes = array("jpg", "jpeg", "png");
        if (in_array($fileType, $allowedTypes)) {
            // Move the uploaded file to the destination directory
            move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);

            // Get other form data
            $description = $_POST["description"];
            $title = $_POST["titel"];
            // Create a thumbnail
            $thumbnailPath = createThumbnail($targetFilePath, 300, 300, $targetDir);

            // Insert data into the database
            $sql = "INSERT INTO images (filename, path, thumbnail_path, description, title) VALUES ('$fileName', '$targetFilePath', '$thumbnailPath', '$description', '$title')";
            
            if ($db_obj->query($sql) === TRUE) {
                $success_upload = "Newsbeitrag erfolgreich hinzugefügt";
            } else {
                $fail_upload = "Es ist ein Fehler passiert";
            }
        } else {
            $fail_upload = "Datentyp nicht erlaubt";
        }
    } else {
        $fail_upload= "Datentyp ist kein Bild";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(dirname(__DIR__) . '/components/head.php'); ?>
</head>

<body>
    <main>
    <div class="container">
    <h2 class="mt-3">Newsbeitrag erstellen</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="file" class="form-label">Bild aussuchen:</label>
            <input type="file" name="file" id="file" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">News-Beitrag Text</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">News-Beitrag Titel</label>
            <input type?="text" name="titel" id="titel" class="form-control" rows="4" required></input>
        </div>

        <button type="submit" class="btn btn-primary" name="submit_paths">Abschicken</button>
        <?php if (isset($success_upload)) echo "<br>" . $success_upload . "<br>";?>
        <?php if (isset($fail_upload)) echo $success_upload;?>
    </form>
</div>
    </main>
    
</body>

</html>