<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="Notificaciones electronicas" name="description"/>
        <title>
            Factura Electronica
        </title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
        <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>resource/app/assets/plugins/nprogress/nprogress.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>resource/app/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>resource/app/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>resource/app/assets/css/sleek.css" id="sleek-css" rel="stylesheet"/>
        <!--  HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>resource/app/assets/plugins/nprogress/nprogress.js"></script>
    </head>
    <body class="header-fixed sidebar-fixed sidebar-dark header-light sidebar-minified" id="body">
    <div class="mobile-sticky-body-overlay">
    </div>
    <!--<div id="toaster"></div>-->
    <div class="wrapper">
        <aside class="left-sidebar bg-sidebar">
            <div class="sidebar sidebar-with-footer" id="sidebar">
            </div>
        </aside>
        <div class="page-wrapper">
            <?php include("template/fe/parts/cabeza.php"); ?>
            <div class="content-wrapper">
                <div class="content">                    
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Seleccione el modulo</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $ar = ['Notificaciones', 'Bandeja']; ?>
                                <?php $desc = ['Modulo para registrar, dar seguimiento y notificar', 'Modulo para recepcionar las notificaciones']; ?>
                                <?php foreach($grupoModulo as $k => $d): ?>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card mb-4">
                                            <!-- <img class="card-img-top" src="assets/img/elements/cc1.jpg"> -->
                                            <div class="card-body">
                                                <h5 class="card-title text-primary"><?= $ar[$k] ?></h5>
                                                <p class="card-text pb-3"><?= $desc[$k] ?></p>
                                                <a href="<?php echo base_url(); ?>home/redireccionar/<?= $d["m_grupo"] ?>" class="btn btn-outline-primary">Ingresar</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('./parts/modalCambiarClave') ?>
    <script src="<?php echo base_url(); ?>resource/app/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>resource/app/assets/plugins/slimscrollbar/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>resource/app/assets/plugins/jekyll-search.min.js"></script>
    <script src="<?php echo base_url(); ?>resource/app/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="<?php echo base_url(); ?>resource/app/assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
    <script src="<?php echo base_url(); ?>resource/app/assets/plugins/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>resource/app/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>resource/app/assets/js/sleek.bundle.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#btnCambiarClave").click(function(){
                $("#modalCambiarClave").modal('show');
                return false;
            });

            $("#btnGuardarClave").click(function(){
                var txtClave        = $("#txtClave").val();
                var txtConfirmar    = $("#txtConfirmar").val();
                var flag = false;
                if(txtClave.length > 6){
                    flag = true;
                    $("#divClave").hide();
                    $("#divClave").removeClass('alert-danger');
                }else{
                    $("#divClave").show();
                    $("#divClave").addClass('alert-danger');
                    $("#divClave").text("La clave debe de tener más de 6 digitos.");
                    flag = false;
                }
                if(txtConfirmar.length > 6){
                    flag = true;
                    $("#divConfirmar").hide();
                    $("#divConfirmar").removeClass('alert-danger');
                }else{
                    $("#divConfirmar").show();
                    $("#divConfirmar").addClass('alert-danger');
                    $("#divConfirmar").text("La clave de confirmación debe de tener más de 6 digitos.");
                    flag = false;
                }
                if(txtClave.length > 6 && txtConfirmar.length > 6){
                    if (txtClave.toString() == txtConfirmar.toString()) {
                        flag = true;
                        $("#divAlert").hide();
                        $("#divAlert").removeClass('alert-success');
                        $("#divAlert").removeClass('alert-danger');
                    }
                }else{
                    flag = false;
                    $("#divAlert").show();
                    $("#divAlert").addClass('alert-danger');
                    $("#divAlert").text("Los textos ingresados deben ser iguales."); 
                }
                if(flag = true){
                    var data = new FormData();
                    data.append("txtClave", txtClave);
                    data.append("txtConfirmar", txtConfirmar);
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        data: data,
                        contentType: false,
                        processData: false,
                        url:"<?php base_url() ?>"+'home/cambiar_clave',
                        success : function(data){
                            console.log(data.resp);
                            switch(data.resp){
                                case 100:
                                    $("#divAlert").show();
                                    $("#divAlert").addClass('alert-success');
                                    $("#divAlert").text(data.text);
                                break;
                                case 10:
                                    $("#divAlert").show();
                                    $("#divAlert").addClass('alert-danger');
                                    $("#divAlert").text(data.text);
                                break;
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
