<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
 
</head>
<body>
 
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Read Product</h1>
        </div>
         
        <?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['producto_id']) ? $_GET['producto_id'] : die('ERROR: Record ID not found.');
 
//include database connection
include 'config/database.php';
 
// read current record's data
try {
    // prepare select query
    $query = "SELECT producto_id, producto_nombre, producto_sku, producto_precio, producto_stock, producto_status, producto_costo, producto_proveedor, image FROM productos WHERE producto_id = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
 
    // this is the first question mark
    $stmt->bindParam(1, $id);
 
    // execute our query
    $stmt->execute();
 
    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // values to fill up our form
    $nombre = $row['producto_nombre'];
    $sku = $row['producto_sku'];
    $precio = $row['producto_precio'];
    $stock = $row['producto_stock'];
    $status = $row['producto_status'];
    $costo = $row['producto_costo'];
    $producto_proveedor = $row['producto_proveedor'];
    $image = htmlspecialchars($row['image'], ENT_QUOTES);
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>
 
        <!--we have our html table here where the record will be displayed-->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($nombre, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>SKU</td>
        <td><?php echo htmlspecialchars($sku, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Price</td>
        <td><?php echo htmlspecialchars($precio, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Stock</td>
        <td><?php echo htmlspecialchars($stock, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <td><?php echo htmlspecialchars($status, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Costo</td>
        <td><?php echo htmlspecialchars($costo, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Proveedor</td>
        <td><?php echo htmlspecialchars($producto_proveedor, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Image</td>
        <td>
        <?php echo $image ? "<img src='uploads/{$image}' style='width:300px;' />" : "No image found.";  ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <a href='index.php' class='btn btn-danger'>Back to read products</a>
        </td>
    </tr>
</table>
 
    </div> <!-- end .container -->
     
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>