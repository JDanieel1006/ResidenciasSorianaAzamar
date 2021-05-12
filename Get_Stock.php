<?php
include('include/conexion.php');

 $id=intval($_POST['codigo_barras']);
 $query=mysqli_query($conexion,"SELECT * FROM productos WHERE CodigoBarras = $id");

?>

<form class="form-horizontal row-fluid" name="Category" method="post">
    <div class="form-group">
        <label>Stock actual <span class="text-danger">*</span></label>
        <input type="text" name="StockOld" id="danger" class="form-control" placeholder="Stock actual" values="<?php $row['Stock'] ?>" required>
    </div>

    <div class="form-group">
        <label>Stock a añadir <span class="text-danger">*</span></label>
        <input type="text" name="StockNew" id="danger" class="form-control" placeholder="Nuevo Stock" required>
    </div>

    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary btn-icon-split btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-save fa-sm text-white-50"></i>
            </span>
            <span class="text">Guardar</span>
        </button>
    </div>
</form>