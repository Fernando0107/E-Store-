<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
      
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
      
   <?php
if($_POST){
 
    // include database connection
    include 'config/database.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO productos SET producto_nombre=:producto_nombre, producto_sku=:producto_sku, producto_precio=:producto_precio, producto_stock=:producto_stock, producto_status=:producto_status, producto_proveedor=:producto_proveedor, producto_costo=:producto_costo, image=:image";
        //$query = "INSERT INTO productos SET producto_nombre=:producto_nombre, producto_sku=:producto_sku, producto_precio=:producto_precio, producto_stock=:producto_stock, producto_status=:producto_status, producto_proveedor=:producto_proveedor, producto_costo=:producto_costo, producto_categoria=:producto_categoria";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
 
        // posted values
        $name=htmlspecialchars(strip_tags($_POST['producto_nombre']));
        $sku=htmlspecialchars(strip_tags($_POST['producto_sku']));
        $price=htmlspecialchars(strip_tags($_POST['producto_precio']));
        $stock=htmlspecialchars(strip_tags($_POST['producto_stock']));
        $status=htmlspecialchars(strip_tags($_POST['producto_status']));
        $provee=htmlspecialchars(strip_tags($_POST['producto_proveedor']));
        $costo=htmlspecialchars(strip_tags($_POST['producto_costo']));
        // new 'image' field
        $image=!empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                : "";
        $image=htmlspecialchars(strip_tags($image));
        //$category=htmlspecialchars(strip_tags($_POST['producto_categoria']));
        // bind the parameters
        $stmt->bindParam(':producto_nombre', $name);
        $stmt->bindParam(':producto_sku', $sku);
        $stmt->bindParam(':producto_precio', $price);
        $stmt->bindParam(':producto_stock', $stock);
        $stmt->bindParam(':producto_status', $status);
        $stmt->bindParam(':producto_proveedor', $provee);
        $stmt->bindParam(':producto_costo', $costo);
        $stmt->bindParam(':image', $image);
        //$stmt->bindParam(':producto_categoria', $category);
        // specify when this record was inserted to the database
        $created=date('Y-m-d H:i:s');
         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
            // now, if image is not empty, try to upload the image
            if($image){
             
                // sha1_file() function is used to make a unique file name
                $target_directory = "uploads/";
                $target_file = $target_directory . $image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
             
                // error message is empty
                $file_upload_error_messages="";
                // make sure that file is a real image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check!==false){
                    // submitted file is an image
                }else{
                    $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                }
                // make sure certain file types are allowed
                $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                if(!in_array($file_type, $allowed_file_types)){
                    $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                }
                // make sure file does not exist
                if(file_exists($target_file)){
                    $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                }
                // make sure submitted file is not too large, can't be larger than 1 MB
                if($_FILES['image']['size'] > (1024000)){
                    $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                }
                // make sure the 'uploads' folder exists
                // if not, create it
                if(!is_dir($target_directory)){
                    mkdir($target_directory, 0777, true);
                }
                // if $file_upload_error_messages is still empty
                if(empty($file_upload_error_messages)){
                    // it means there are no errors, so try to upload the file
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                        // it means photo was uploaded
                    }else{
                        echo "<div class='alert alert-danger'>";
                            echo "<div>Unable to upload photo.</div>";
                            echo "<div>Update the record to upload photo.</div>";
                        echo "</div>";
                    }
                }
                 
                // if $file_upload_error_messages is NOT empty
                else{
                    // it means there are some errors, so show them to user
                    echo "<div class='alert alert-danger'>";
                        echo "<div>{$file_upload_error_messages}</div>";
                        echo "<div>Update the record to upload photo.</div>";
                    echo "</div>";
                }
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
         
    }
     }
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!-- html form here where the product information will be entered -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Nombre del Producto</td>
            <td><input type='text' name='producto_nombre' class='form-control' /></td>
        </tr>
        <tr>
            <td>SKU del Producto</td>
            <td><input name='producto_sku' class='form-control'></input></td>
        </tr>
        <tr>
            <td>Precio del Producto</td>
            <td><input type='text' name='producto_precio' class='form-control' /></td>
        </tr>
        <tr>
            <td>Stock del Producto</td>
            <td><input type='text' name='producto_stock' class='form-control'/></td>
        </tr>
        <tr>
            <td>Status del producto</td>
            <td><input type='text' name='producto_status' class='form-control'/></td>
        </tr>
        <tr>
            <td>Proveedor del Producto</td>
            <td><input type='text' name='producto_proveedor' class='form-control'/></td>
        </tr>
        <tr>
            <td>Costo del Producto</td>
            <td><input type='text' name='producto_costo' class='form-control'/></td>
        </tr>
        <tr>
            <td>Photo</td>
            <td><input type="file" name="image" /></td>
        </tr>
        <!---<tr>
            <td>Categoria del Producto</td>
            <td><input type='text' name='producto_categoria' class='form-control'/></td>
        </tr>-->
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
                <a href='index.php' class='btn btn-danger'>Back to read products</a>
            </td>
        </tr>
    </table>
</form>
          
    </div> <!-- end .container -->
      
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>