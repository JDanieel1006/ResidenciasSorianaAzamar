<?php
include('include/conexion.php');

 $id_cate = $_POST['IDCATE'];
 $id_sub = $_POST['IDSUB'];
 $id_provee = $_POST['IDPRO'];

?>

<tbody>
    <?php 
        $query=mysqli_query($conexion,"SELECT Productos.*, Categoria.Nombre, SubCategoria.Nombre_sub, proveedores.Nombre_provedor
                                       FROM Productos 
                                       JOIN Categoria on Categoria.id=Productos.Categoria 
                                       JOIN Subcategoria ON Subcategoria.id=Productos.SubCategoria 
                                       JOIN proveedores ON proveedores.id=Productos.Nombre_proveedor 
                                       WHERE Categoria.id = $id_cate AND subcategoria.id = $id_sub  AND proveedores.id = $id_provee");
        while($row=mysqli_fetch_array($query))
        {
    ?>
    <tr>
        <td><?php echo htmlentities($row['Nombre_pro']);?></td>
        <td><?php echo htmlentities($row['Nombre']);?></td>
        <td> <?php echo htmlentities($row['Nombre_sub']);?></td>
        <td><?php echo htmlentities($row['Marca']);?></td>
        <td><?php echo htmlentities($row['Nombre_provedor']);?></td>
        <td>
            <a href="Productos_edit.php?id=<?php echo $row['id']?>"
                class="d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm"></i></a>
            <a href="Admin_productos.php?id=<?php echo $row['id']?>&del=delete"
                onClick="return confirm('Esta seguro que desea eliminar ?')"
                class="d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm"></i></a>
        </td>

    </tr>
    <?php } ?>
</tbody>

