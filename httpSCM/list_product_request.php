<?php 

$where = '';
$filtro ='';
$name = "";
$email = "";
$type_document = "";
$number_document = "";
$product_name = "";
if(isset($_REQUEST['name']) || isset($_REQUEST['email']) || isset($_REQUEST['type_document']) || 
isset($_REQUEST['number_document']) || isset($_REQUEST['product_name'])) {
  $filtro= $_REQUEST['filtro'];
  if(isset($_REQUEST['name'])) {
    $name= $_REQUEST['name'];
    if ($name != ""){
      $where = "WHERE user.name = '$name'";
  }
  }
}

if(isset($_REQUEST['email'])) {
  $email= $_REQUEST['email'];
  if ($email != ""){
    if ($where == "") {
     $where= "WHERE user.email = '$email'"; 
    } else {
    $where = "$where $filtro user.email = '$email'";
  }
}
}
if(isset($_REQUEST['type_document'])) {
  $type_document= $_REQUEST['type_document'];
  if ($type_document != ""){
    if ($where == "") {
     $where= "WHERE user.type_document = '$type_document'"; 
    } else {
    $where = "$where $filtro user.type_document = '$type_document'";
  }
}
}
if(isset($_REQUEST['number_document'])) {
  $number_document= $_REQUEST['number_document'];
  if ($number_document != ""){
    if ($where == "") {
     $where= "WHERE user.number_document= '$number_document'"; 
    } else {
    $where = "$where $filtro user.number_document = '$number_document'";
  }
}
}
if(isset($_REQUEST['product_name'])) {
    $product_name= $_REQUEST['product_name'];
    if ($product_name != ""){
      if ($where == "") {
       $where= "WHERE product.id = '$product_name'"; 
      } else {
      $where = "$where $filtro product.id = '$product_name'";
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
   $sql = "SELECT user.name as user_name, user.type_document,user.number_document, user.email, product.id as product_name, product.price, request.description
   FROM save_users as user JOIN save_product_request request ON user.id = request.id_user
   JOIN products product ON request.id_product = product.id $where ORDER By user.name ASC";

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
    <title>Solicitudes de Productos</title>
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
      <li><a href="index.php">Entrada</a></li>
      <li><a href="homepage.html">Inicio</a></li>
      <li><a href="Services.html">Servicios</a></li>
		<li><a href="purchase_services.php">Solicitar Servicio</a></li>
			<li><a href="Products.html">Productos</a></li>
			<li><a href="list_products.php">Lista de Productos</a></li>
			<li><a href="purchase_products.php">Solicitar Producto</a></li>
			<li><a href="Contact.php">Contacto</a></li>
			<li><a href="list_service_request.php">Solicitudes servicio</a></li>
			
			
        
				
			</ul>
		</nav>

	</header>
    <center>
    <head><H1>Lista Solicitudes de Productos</H1></head>
    <p>Puedes buscar por los siguientes filtros 
    <br/> (Para utilizar el botón "Buscar completo" todos los campos deben coincidir)
    </p> 
    <form action= "list_product_request.php">
    Nombre Completo: <br/><input type = "text" name= "name" value="<?php echo $name; ?>" >
    <br/>
    Correo Electronico: <br/><input type = "email" name= "email" value="<?php echo $email; ?>" >
    <br/>
     Tipo de Documento : <br/>
     <select name="type_document" > 
     <option value =""> Escoge una opción </option>
     <option value ="0"<?php if($type_document=="0"){echo "selected";}?>> Tarjeta de Identidad </option>
     <option value ="1"<?php if($type_document=="1"){echo "selected";}?>> Cedula de Ciudadania </option>
     <option value ="2"<?php if($type_document=="2"){echo "selected";}?>> Cedula de extranjeria </option>
    </select> <br/>
    Numero documento: <br/><input type = "number" name= "number_document" value="<?php echo $number_document; ?>"  > <br/>
    Producto : <br/>
    <select name="product_name" > 
     <option value =""> Escoge una opción </option>
     <option value ="1"<?php if($product_name=="1"){echo "selected";}?>> disco duro de 1 tera </option>
     <option value ="2"<?php if($product_name=="2"){echo "selected";}?>> Teclado y mouse inalámbrico </option>
     <option value ="3"<?php if($product_name=="3"){echo "selected";}?>> Disco duro de 2 teras </option>
     <option value ="4"<?php if($product_name=="4"){echo "selected";}?>> Control inalámbrico para juegos en pc </option>
     <option value ="5"<?php if($product_name=="5"){echo "selected";}?>> Parlantes para pc </option>
    </select> <br/>
    <br/>
    <br/><button type = "submit" name ="filtro" value="AND"> Buscar todo </button> 
    <button type = "submit" name ="filtro" value= "OR"> Buscar por filtro </button> <br/>
     </form>
     <hr/>
     <center>
<table class="default">

<tr>

  <td>Nombre</td>

  <td>Tipo Documento</td>

  <td>Numero Documento</td>

  <td>Email</td>

  <td>Producto</td>

  <td>Precio</td>

  <td>Descripción</td>

</tr>
<?php
for($i=0;$i<count($request);$i++) {
    ?>
    <tr>
        <td> <?php echo $request[$i]["user_name"]?></td>
        <td> <?php $type_document = $request[$i]["type_document"];
        if ($type_document ==0) {
          echo 'Tarjeta de Identidad';
        }
        elseif ($type_document ==1 ){
          echo 'Cedula de Ciudadania';
        
        } else {
          echo 'Cedula de extranjeria';
        }
        ?></td>
        <td> <?php echo $request[$i]["number_document"]?></td>
        <td> <?php echo $request[$i]["email"]?></td>    
        <td> <?php $product_name = $request[$i]["product_name"];
        if ($product_name ==1 ) {
          echo 'disco duro 1 tera';
        }
        elseif ($product_name ==2 ){
          echo 'Teclado y mouse inalámbrico';
        
        } elseif ($product_name ==3 ) {
          echo 'Disco duro de 2 teras';

        }elseif ($product_name ==4 ) {
          echo 'Control inalámbrico para juegos en pc';
        }else {
          echo 'Parlantes para pc';
        }
      
        ?></td>
        <td> <?php echo $request[$i]["price"]?></td>
        <td> <?php echo $request[$i]["description"]?></td>
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