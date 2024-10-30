<?php
    global $wpdb; $error = "";
    $wpdb->query("CREATE TABLE IF NOT EXISTS spinslider (id INT PRIMARY KEY AUTO_INCREMENT, image VARCHAR(255), title VARCHAR(255));");
    $slides = ($wpdb->get_results("SELECT * FROM spinslider"));
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_FILES["image"])) {
            $image = $_FILES["image"];
            if($image["error"] > 0) {
                $error = "Unexpected error!";
            }
            elseif(strpos($image["type"], "jpeg") === false && strpos($image["type"], "jpeg") === false) {
                $error = "Unsupported format!";
            }
            elseif($image["size"] > 1000*1000) {
                $error = "File size limit exceeded! (1MB maximum)!";
            }
            else {
                $uploads = wp_upload_dir();
                if(!file_exists($uploads["path"])) {
                    $error = "Cannot access upload directory!";
                }
                else {
                    if(move_uploaded_file($image["tmp_name"], $uploads["path"] ."/". $image["name"]) === false) {
                        $error = "Failed to upload file!";
                    }
                    else {
                        $title = isset($_POST["title"]) ? $_POST["title"] : "";
                        $wpdb->query( $wpdb->prepare("INSERT INTO spinslider (image, title) VALUES (%s, %s)", $uploads["url"] ."/". $image["name"], $title) );
                        print <<<SCRIPT
<script>location.href="?page=spin-interactive-slider"</script>
SCRIPT;
                    }
                }
            }
        }
    }
?>

<style type="text/css">
    #wpbody form { border:1px solid #CCC; width:90%;padding:40px;background-color:#FFF }
</style>
<div id="wpbody">
    <h1>Add a new image</h1>
    <form method="post" action="?page=spin-interactive-slider&view=form" enctype="multipart/form-data">
        <input type="file" name="image"/><br>
        <label><b>Give to your image a title (optional) </b></label><br>
        <input size="100" name="title" />
        <input type="submit" value="Submit">
    </form>
    <p><?php echo $error ?></p>
</div>


