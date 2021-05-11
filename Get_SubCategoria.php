<?php
include('include/conexion.php');
if(!empty($_POST["cat_id"])) 
{
 $id=intval($_POST['cat_id']);
$query=mysqli_query($conexion,"SELECT * FROM SubCategoria WHERE Categoria=$id");
?>

<option value="">Seleccione Subcategoria</option>
<?php
 while($row=mysqli_fetch_array($query))
 {
  ?>
  <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['Nombre_sub']); ?></option>
  <?php
 }
}
?>