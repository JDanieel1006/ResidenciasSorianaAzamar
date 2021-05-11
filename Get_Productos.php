<?php
include('include/conexion.php');

 $id_cate = $_POST['IDCATE'];
 $id_sub = $_POST['IDSUB'];

?>
<thead>
    <tr>
        <th>Categoria</th>
        <th>Sub Categoria</th>
        <th>Nombre del producto</th>
        <th>Marca</th>
        <th></th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>Categoria</th>
        <th>Sub Categoria</th>
        <th>Nombre del producto</th>
        <th>Marca</th>
        <th></th>
    </tr>
</tfoot>

<tbody>
    <?php 
        $query=mysqli_query($conexion,"SELECT Productos.*,Categoria.Nombre,SubCategoria.Nombre_sub FROM Productos JOIN Categoria on Categoria.id=Productos.Categoria JOIN Subcategoria ON Subcategoria.id=Productos.SubCategoria WHERE Categoria.id = '$id_cate' AND subcategoria.id = '$id_sub'");
        while($row=mysqli_fetch_array($query))
        {
    ?>
    <tr>
        <td><?php echo htmlentities($row['Nombre_pro']);?></td>
        <td><?php echo htmlentities($row['Nombre']);?></td>
        <td> <?php echo htmlentities($row['Nombre_sub']);?></td>
        <td><?php echo htmlentities($row['Marca']);?></td>
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

