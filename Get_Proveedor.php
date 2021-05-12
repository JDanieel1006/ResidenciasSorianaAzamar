<?php
include('include/conexion.php');
    $id_cate = intval($_POST['IDCATE']);
    $id_sub = intval($_POST['IDSUB']);
    $query=mysqli_query($conexion,"SELECT * FROM proveedores WHERE Categoria = $id_cate AND Subcategoria = $id_sub ");
?>

<option value="">Seleccione Proveedor</option>
<?php
 while($row=mysqli_fetch_array($query))
 {
  ?>
  <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['Nombre_provedor']); ?></option>
  <?php
 }

?>