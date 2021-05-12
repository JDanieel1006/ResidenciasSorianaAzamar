<?php
session_start();
include('include/conexion.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
    $pid=intval($_GET['id']);
    if(isset($_POST['submit']))
    {
        $CodigoBarras=$_POST['CodigoBarras'];
        $category=$_POST['category'];
        $subcategory=$_POST['subcategory'];
        $Nombre_pro=$_POST['Nombre_pro'];
        $Marca_pro=$_POST['Marca_pro'];
        $Precio_Venta=$_POST['Precio_Venta'];
            
        $sqlUPDATE="UPDATE Productos SET CodigoBarras='$CodigoBarras' ,Categoria='$category',SubCategoria='$subcategory',Nombre_pro='$Nombre_pro',Marca='$Marca_pro',Precio='$Precio_Venta' WHERE id='$pid' ";
        if (!mysqli_query($conexion,$sqlUPDATE))
        {
            die('Error: ' . mysqli_error($conexion));
        } 
        else
        {
            echo "<script>if(confirm('Producto guardado')){
                document.location='Productos.php';}
                else{ alert('Operacion Cancelada');
                }</script>"; 
        }
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>INVENTARIO - Soriana</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- jQuery 3 -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <script>
        function getSubcat(val) {
            $.ajax({
            type: "POST",
            url: "Get_SubCategoria.php",
            data:'cat_id='+val,
            success: function(data){
                $("#subcategory").html(data);
            }
            });
        }
        function selectCountry(val) {
        $("#search-box").val(val);
        $("#suggesstion-box").hide();
        }
    </script>

    <script>
        function getProductos(val) {
            var id_cate = $("#category").val();
            var id_sub = $("#subcategory").val();
            var id_provee = $("#proveedores").val();
            $.ajax({
                type: "POST",
                url: "Get_Productos.php",
                data: {
                    IDCATE: id_cate,
                    IDSUB: id_sub,
                    IDPRO: id_provee
                },
                success: function (data) {
                    $("#dataTable").html(data);
                }
            });
        }

        function selectCountry(val) {
            $("#search-box").val(val);
            $("#suggesstion-box").hide();
        }
    </script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Aqui se incluye la barra lateral de navegacion  -->
        <?php include("NavBar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("NavHeader.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Productos</h1>
                    </div>


                    <!-- Content Row -->


                    <div>
                        <form class="form-horizontal row-fluid" name="Category" method="post">

                            <?php 

                            $query=mysqli_query($conexion,"SELECT Productos.*,Categoria.Nombre AS catname,
                                                                  Categoria.id as cid,
                                                                  Subcategoria.Nombre_sub as subcatname,
                                                                  Subcategoria.id AS subcatid,
                                                                  proveedores.Nombre_provedor AS provname,
                                                                  proveedores.id AS provid
                                                                  FROM Productos 
                                                                  JOIN Categoria on Categoria.id=Productos.Categoria 
                                                                  JOIN Subcategoria ON Subcategoria.id=Productos.SubCategoria
                                                                  JOIN proveedores ON proveedores.id=Productos.Nombre_proveedor 
                                                                  WHERE Productos.id='$pid'");
                            while($row=mysqli_fetch_array($query))
                            {                      
                        ?>

                            <div class="form-group">
                                <label>Codigo de barras <span class="text-danger">*</span></label>
                                <input type="text" name="CodigoBarras" id="CodigoBarras" class="form-control"
                                    placeholder="Codigo de barras"
                                    value="<?php echo htmlentities($row['CodigoBarras']);?>" required>
                            </div>

                            <div class="form-group">
                                <label>Categoria <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control" onChange="getSubcat(this.value);" required>
                                    <option value="<?php echo htmlentities($row['cid']);?>"><?php echo htmlentities($row['catname']);?></option> 
                                    <?php $query2=mysqli_query($conexion,"SELECT * FROM Categoria");
                                while($rw=mysqli_fetch_array($query2))
                                {
                                    if($row['catname']==$rw['Nombre'])
                                    {
                                        continue;
                                    }
                                    else{
                                    ?>
                                    <option value="<?php echo $rw['id'];?>"><?php echo $rw['Nombre'];?></option>
                                    <?php 
                                    }
                                }
                                ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>SubCategoria <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select  class="form-control" id="subcategory" name="subcategory" class="span8 tip" onChange="getProveedores(this.value);" required>
                                        <option value="<?php echo htmlentities($row['subcatid']);?>"><?php echo htmlentities($row['subcatname']);?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nombre del proveedor <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select  class="form-control" id="Nombre_proveedor" name="Nombre_proveedor" class="span8 tip" required>
                                        <option value="<?php echo htmlentities($row['provid']);?>"><?php echo htmlentities($row['provname']);?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nombre del producto <span class="text-danger">*</span></label>
                                <input type="text" name="Nombre_pro" id="Nombre_pro" class="form-control"
                                    placeholder="Nombre del producto"
                                    value="<?php echo htmlentities($row['Nombre_pro']);?>" required>
                            </div>

                            <div class="form-group">
                                <label>Marca del producto <span class="text-danger">*</span></label>
                                <input type="text" name="Marca_pro" id="Marca_pro" class="form-control"
                                    placeholder="Marca del producto" value="<?php echo htmlentities($row['Marca']);?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Precio de venta <span class="text-danger">*</span></label>
                                <input type="text" name="Precio_Venta" id="Precio_Venta" class="form-control"
                                    placeholder="Precio de venta" value="<?php echo htmlentities($row['Precio']);?>"
                                    required>
                            </div>

                            

                            <?php } ?>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary btn-icon-split btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-save fa-sm text-white-50"></i>
                                    </span>
                                    <span class="text">Guardar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- SweetAlert 2 -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js">
    </script>


</body>

</html>
<?php } ?>