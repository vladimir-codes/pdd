<?php
include_once("template.php");
?>

<form method="POST" enctype="multipart/form-data">
    <input type='file' name="img" accept="image/jpeg,image/gif,image/x-png"></input>
    <input type='submit' name='send' value='Отправить'>
    
</form>
<?php
    if(isset($_POST['send'])){
        print_r($_FILES['img']['name']);
        $filename = $_FILES['img']['name'];
        $path = "images/$filename";
        move_uploaded_file($_FILES['img']['tmp_name'],$path);
    }
?>