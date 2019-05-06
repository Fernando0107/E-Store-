<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Update a Record - PHP CRUD Tutorial</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
</head>
<body>
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Update Product</h1>
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
    $query = "SELECT producto_id, producto_nombre, producto_sku, producto_precio, producto_stock, producto_status, producto_costo, producto_proveedor FROM productos WHERE producto_id = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
     
    // this is the first question mark
    $stmt->bindParam(1, $id);
     
    // execute our query
    $stmt->execute();
     
    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
    // values to fill up our form
    $name = $row['producto_nombre'];
    $sku = $row['producto_sku'];
    $price = $row['producto_precio'];
    $stock = $row['producto_stock'];
    $status = $row['producto_status'];
    $costo = $row['producto_costo'];
    $provee = $row['producto_proveedor'];
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?> 
        <?php
 
// check if form was submitted
if($_POST){
     
    try{
     
        // write update query
        // in this case, it seemed like we have so many fields to pass and 
        // it is better to label them and not use question marks
        $query = "UPDATE productos 
                    SET producto_nombre=:producto_nombre, producto_sku=:producto_sku, producto_precio=:producto_precio, producto_stock=:producto_stock, producto_status=:producto_status, producto_proveedor=:producto_proveedor, producto_costo=:producto_costo 
                    WHERE producto_id = :producto_id";
 
        // prepare query for excecution
        $stmt = $con->prepare($query);
 
        // posted values
        $name=htmlspecialchars(strip_tags($_POST['producto_nombre']));
        $sku=htmlspecialchars(strip_tags($_POST['producto_sku']));
        $price=htmlspecialchars(strip_tags($_POST['producto_precio']));
        $stock=htmlspecialchars(strip_tags($_POST['producto_stock']));
        $status=htmlspecialchars(strip_tags($_POST['producto_status']));
        $provee=htmlspecialchars(strip_tags($_POST['producto_proveedor']));
        $costo=htmlspecialchars(strip_tags($_POST['producto_costo']));
 
        // bind the parameters
        $stmt->bindParam(':producto_nombre', $name);
        $stmt->bindParam(':producto_sku', $sku);
        $stmt->bindParam(':producto_precio', $price);
        $stmt->bindParam(':producto_stock', $stock);
        $stmt->bindParam(':producto_status', $status);
        $stmt->bindParam(':producto_proveedor', $provee);
        $stmt->bindParam(':producto_costo', $costo);
         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was updated.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
        }
         
    }
     
    // show errors
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!--we have our html form here where new record information can be updated-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Nombre</td>
            <td><input type='text' name='producto_nombre' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>SKU</td>
            <td><input type='text' name='producto_sku' value="<?php echo htmlspecialchars($sku, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Precio</td>
            <td><input type='text' name='producto_precio' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
         <tr>
            <td>Stock</td>
            <td><input type='text' name='producto_stock' value="<?php echo htmlspecialchars($stock, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
         <tr>
            <td>Status</td>
            <td><input type='text' name='producto_status' value="<?php echo htmlspecialchars($status, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
         <tr>
            <td>Costo</td>
            <td><input type='text' name='producto_costo' value="<?php echo htmlspecialchars($costo, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
         <tr>
            <td>Proveedor</td>
            <td><input type='text' name='producto_proveedor' value="<?php echo htmlspecialchars($provee, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn-primary' />
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