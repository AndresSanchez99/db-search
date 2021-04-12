<?php 

$where = '';
$filtro ='';
$name = "";
if(isset($_REQUEST['name']) || isset($_REQUEST['price'])) {
  $filtro= $_REQUEST['filtro'];
if(isset($_REQUEST['name'])) {
  $name= $_REQUEST['name'];
  if($name != "") {
  $where = "WHERE product.id = '$name'";
}
}
}
if(isset($_REQUEST['price'])) {
  $price= $_REQUEST['price'];
  if ($price != ""){
    if ($where == "") {
     $where= "WHERE product.price = '$price'"; 
    } else {
    $where = "$where $filtro product.price = '$price'";
  }
}
}


    // 1. Connect to database
    $host = "localhost";
    $dbname = "system_computer_db_2021";
    $username = "root";
    $password = "";
    $cnx = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
 
     // 2. Build sql sentence
   $sql = "SELECT product.id as name, product.price 
   FROM products as product $where ORDER By product.id ASC";

    // 3. Prepare sql sentence
    $q = $cnx-> prepare($sql);
    
   // 4. Execute sql sentence
   $result = $q->execute();
    
   $request = $q-> fetchAll();
?>

<!DOCTYPE html>
<html lang=”en”>
<head>
    <meta charset=”UTF-8″ />
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/styletable.css" type="text/css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles2.css" type="text/css">
    <link rel="shortcut icon" type="imgage/x-icon" href="img/logosystemc.ico">

</head>
<body> 
<header id="main-header">
		
		<a id="logo-header" href="#">
			<span class="site-name">SCM</span>
			<span class="site-desc">A tu servicio</span>
		</a>

		<nav>
			<ul>
        <li><a href="homepage.html">Inicio</a></li>
        <li><a href="Services.html">Servicios</a></li>
		<li><a href="purchase_services.php">Solicitar Servicio</a></li>
			<li><a href="Products.html">Productos</a></li>
			<li><a href="list_products.php">Lista de Productos</a></li>
			<li><a href="purchase_products.php">Solicitar Producto</a></li>
			<li><a href="Contact.php">Contacto</a></li>
			<li><a href="list_service_request.php">Solicitudes servicio</a></li>
			<li><a href="list_product_request.php">Productos requeridos</a></li>
			
				
			</ul>
		</nav>

	</header>
  <center>
    <head><H1>Lista Productos</H1></head>
    <p>Puedes buscar por los siguientes filtros </p> 
    <form action= "list_products.php">
    Nombre Producto: <br/>
    <select name="name" > 
     <option value =""> Escoge una opción </option>
     <option value ="1"<?php if($name=="1"){echo "selected";}?>> disco duro de 1 tera </option>
     <option value ="2"<?php if($name=="2"){echo "selected";}?>> Teclado y mouse inalámbrico </option>
     <option value ="3"<?php if($name=="3"){echo "selected";}?>> Disco duro de 2 teras </option>
     <option value ="4"<?php if($name=="4"){echo "selected";}?>> Control inalámbrico para juegos en pc </option>
     <option value ="5"<?php if($name=="5"){echo "selected";}?>> Parlantes para pc </option>
    </select> <br/>
    <br/>
    Precio : <br/><input type = "number" name= "price" value="<?php echo $price; ?>" >
    <br/>
    <br/><button type = "submit" name ="filtro" value="AND"> Buscar todo </button> 
    <button type = "submit" name ="filtro" value= "OR"> Buscar por filtro </button> <br/>
     </form>
     <hr/>
     <center>
<table class="default">

<tr>

  <td>Nombre</td>

  <td>Precio</td>

</tr>
<?php
for($i=0;$i<count($request);$i++) {
    ?>
    <tr>
    <td> <?php $name = $request[$i]["name"];
        if ($name ==1 ) {
          echo 'disco duro 1 tera';
        }
        elseif ($name ==2 ){
          echo 'Teclado y mouse inalámbrico';
        
        } elseif ($name ==3 ) {
          echo 'Disco duro de 2 teras';

        }elseif ($name ==4 ) {
          echo 'Control inalámbrico para juegos en pc';
        }else {
          echo 'Parlantes para pc';
        }
        ?></td>
        <td> <?php echo $request[$i]["price"]?></td>
    </tr>
    <?php
}

?>


</table>
<footer id="main-footer">
		<a href="https://web.facebook.com/Systemcomputermzls/?_rdc=1&_rdr">Facebook</a>
				<a href="https://twitter.com"> Twitter</a>
				<a href="https://instagram.com"> Instragram </a>
		<p>&copy; 2021 <a> System Computer Manizales</a></p>
	
	</footer>
</center>
</body>
</html>