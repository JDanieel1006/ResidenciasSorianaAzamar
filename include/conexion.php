 <?
// Crear Conexión
 $conexion=mysqli_connect("localhost","root","Daniel1006","Soriana");
 
 // Comprobar conexión
 if (mysqli_connect_errno($conexion))
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
 ?>

 