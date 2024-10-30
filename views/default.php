<?php

    global $wpdb;
    $wpdb->query("CREATE TABLE spinslider IF NO EXISTS (id INT PRIMARY KEY AUTO_INCREMENT, image VARCHAR(255), title VARCHAR(255));");

    if(isset($_GET["delete-id"]) && is_numeric($_GET["delete-id"])) {
        $wpdb->query($wpdb->prepare("DELETE FROM spinslider WHERE id = %s LIMIT 1", $_GET["delete-id"]));
    }
    $slides = ($wpdb->get_results("SELECT * FROM spinslider ORDER BY id DESC"));

?>

<style type="text/css">
    #wpbody table { width:95%; border-collapse: collapse;}
    #wpbody table th { background-color:#FFF; }
    #wpbody table td { background-color:#EFEFEF;height:100px; }
    #wpbody table th, #wpbody table td { border:1px solid #CCC; }
    #wpbody table th:first-child, #wpbody table td:first-child { width:110px;text-align:center }
    #notice { background-color:#FFF;width:95%; }
    #wpbody div { margin:10px 0 }
</style>
<div id="wpbody">
    <h1>Spin Interactive Slider</h1>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                </tr>
            </thead>
        <?php foreach($slides as $slide): ?>
            <tr>
                <td><img width="100" src="<?php echo $slide->image ?>" /><button onclick="location.href='?page=spin-interactive-slider&delete-id=<?php echo $slide->id ?>'" >Delete</button></td><td><?php echo $slide->title ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        <button onclick="location.href='?page=spin-interactive-slider&view=form'">New slide</button>
    </div>
    <div id="notice">Slider Shortcode: [spinslider]</div>
</div>


