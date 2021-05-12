<?php
session_start();
include('include/conexion.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

    if(isset($_GET['del']))
    {
	    mysqli_query($conexion,"DELETE FROM Productos where id = '".$_GET['id']."'");
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
                data: 'cat_id=' + val,
                success: function (data) {
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
        function getProveedores(val) {
            var id_cate = $("#category").val();
            var id_sub = $("#subcategory").val();
            $.ajax({
                type: "POST",
                url: "Get_Proveedor.php",
                data: {
                    IDCATE: id_cate,
                    IDSUB: id_sub
                },
                success: function (data) {
                    $("#proveedores").html(data);
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
                        <h1 class="h3 mb-0 text-gray-800">Administracion de productos</h1>
                        <button id="btnExport" class="btn btn-success btn-lg">Generar PDF</button>
                    </div>

                    <div>
                        <form class="form-horizontal row-fluid" name="Category" method="post">
                            <div class="form-group">
                                <label>Categoria <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control"
                                    onChange="getSubcat(this.value);" required>
                                    <option value="">Seleccione categoria</option>
                                    <?php $query=mysqli_query($conexion,"SELECT * FROM Categoria");
                                while($row=mysqli_fetch_array($query))
                                {?>

                                    <option value="<?php echo $row['id'];?>"><?php echo $row['Nombre'];?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>SubCategoria <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select class="form-control" name="subcategory" id="subcategory" class="span8 tip"
                                        onChange="getProveedores(this.value);" required>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Proveedor <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select class="form-control" name="proveedores" id="proveedores" class="span8 tip"
                                        onChange="getProductos(this.value);" required>
                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="container-fliud">
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DataTables Categorias</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" name="dataTable" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th>Sub Categoria</th>
                                                <th>Nombre del producto</th>
                                                <th>Marca</th>
                                                <th>Proveedor</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Categoria</th>
                                                <th>Sub Categoria</th>
                                                <th>Nombre del producto</th>
                                                <th>Marca</th>
                                                <th>Proveedor</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>

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
    <!-- pdfmake -->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script>
        $("body").on("click", "#btnExport", function () {
            html2canvas($('#dataTable')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                                text: 'REPORTE DE PRODUCTOS',
                                style: 'header'
                            },
                            {
                                image: data,
                                width: 500
                            }
                        ],
                        styles: {
                            header: {
                                fontSize: 22,
                                bold: true,
                                alignment: 'center'
                            }
                        }
                    };
                    pdfMake.createPdf(docDefinition).download("customer-details.pdf");
                }
            });
        });
    </script>


</body>

</html>
<?php } ?>