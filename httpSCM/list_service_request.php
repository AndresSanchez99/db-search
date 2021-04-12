<?php 

$where = '';
$filtro ='';
$name = "";
$email = "";
$type_document = "";
$number_document = "";
$service_name = "";
if(isset($_REQUEST['name']) || isset($_REQUEST['email']) || isset($_REQUEST['type_document']) || 
isset($_REQUEST['number_document']) || isset($_REQUEST['service_name'])) {
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

if(isset($_REQUEST['service_name'])) {
  $service_name= $_REQUEST['service_name'];
  if ($service_name != ""){
    if ($where == "") {
     $where= "WHERE service.id = '$service_name'"; 
    } else {
    $where = "$where $filtro service.id = '$service_name'";
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
   $sql = "SELECT user.name as user_name, user.type_document ,user.number_document, user.email, service.id as service_name, service.price, request.description
   FROM save_users as user JOIN save_service_request request ON user.id = request.id_user
   JOIN services service ON request.id_service = service.id $where ORDER By user.name ASC";

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
    <title>Solicitudes de Servicio</title>
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
			<li><a href="list_product_request.php">Productos requeridos</a></li>
				
        
				
			</ul>
		</nav>

	</header>
    <center>
    <head><H1>Lista Solicitudes de Servicio</H1></head>
    <p>Puedes buscar por los siguientes filtros 
      <br/> (El botón buscar te permite arrojar resultados de un filtro o varios filtros a la vez,
      <br/> mientras que el bóton buscar todo deben coincidir todos los filtros )
    </p> 
    <form action= "list_service_request.php">
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
    Numero documento: <br/><input type = "number" name= "number_document" value="<?php echo $number_document; ?>"  >
    <br/>
    Servicio : <br/>
     <select name="service_name" > 
     <option value =""> Escoge una opción </option>
     <option value ="1"<?php if($service_name=="1"){echo "selected";}?>> Formateo e instalación sistema operativo </option>
     <option value ="2"<?php if($service_name=="2"){echo "selected";}?>> Mantenimiento preventivo </option>
     <option value ="3"<?php if($service_name=="3"){echo "selected";}?>> Diagnostico de software y Hardware </option>
     <option value ="4"<?php if($service_name=="4"){echo "selected";}?>> Instalación de Programas </option>
     <option value ="5"<?php if($service_name=="5"){echo "selected";}?>> Instalación de juegos pc </option>
     
    </select> <br/>
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
  
  <td>Servicio</td>

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
        
        } elseif ($type_document ==2) {
          echo 'Cedula de extranjeria';
        }
        ?></td>
        <td> <?php echo $request[$i]["number_document"]?></td>
        <td> <?php echo $request[$i]["email"]?></td>
        <td> <?php $service_name = $request[$i]["service_name"];
        if ($service_name ==1) {
          echo 'Formateo e instalación sistema operativo';
        }
        elseif ($service_name ==2 ){
          echo 'Mantenimiento preventivo';
        
        } elseif ($service_name ==3) {
          echo 'Diagnostico de software y Hardware';
        }
        elseif ($service_name ==4) {
          echo 'Instalación de Programas';
        }
        else {
          echo 'Instalación de juegos pc';
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