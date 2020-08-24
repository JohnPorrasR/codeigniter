<!DOCTYPE html>
<html lang="es">
<head>
    <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Sleek Dashboard - Free Bootstrap 4 Admin Dashboard Template and UI Kit. It is very powerful bootstrap admin dashboard, which allows you to build products like admin panels, content management systems and CRMs etc.">
    <title>Firma Electronica</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" />
    <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="<?php base_url() ?>resource/app/assets/plugins/nprogress/nprogress.css" rel="stylesheet" />
    <link id="sleek-css" rel="stylesheet" href="<?php base_url() ?>resource/app/assets/css/sleek.css" />
    <link href="<?php base_url() ?>resource/app/assets/img/favicon.png" rel="shortcut icon" />
    <script src="<?php base_url() ?>resource/app/assets/plugins/nprogress/nprogress.js"></script>
    <link href="<?php base_url() ?>resource/app/assets/plugins/toastr/toastr.min.css" rel="stylesheet"/>
    <style type="text/css">
        .error{
            background-color: hsla(0, 100%, 50%, .3);
        }
        .error:focus{
            background-color: hsla(0, 100%, 50%, .3);
        }
    </style>
</head>

</head>
<body class="" id="body">
    <br><br><br>
    <div class="container d-flex flex-column justify-content-between vh-100">
        <div class="row justify-content-center mt-5">
        <div class="col-xl-5 col-lg-6 col-md-10">
            <div class="card">
            <div class="card-header bg-primary">
                <div class="app-brand">
                <a href="/index.html">
                    <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                    viewBox="0 0 30 33">
                    <g fill="none" fill-rule="evenodd">
                        <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                        <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                    </g>
                    </svg>
                    <span class="brand-name">Casilla Electrónica</span>
                </a>
                </div>
            </div>
            <div class="card-body p-5">
                <form>
                <div class="row">
                    <div class="form-group col-md-12 mb-4">
                    <input type="text" name="txtuser" id="txtuser" class="form-control input-lg textoNum required" id="email" aria-describedby="emailHelp" placeholder="Usuario">
                    </div>
                    <div class="form-group col-md-12 ">
                    <input type="password" name="txtpws" id="txtpws" class="form-control input-lg required" id="password" placeholder="Clave">
                    </div>
                    <div class="col-md-12">
                        <input type="button" class="btn btn-lg btn-primary btn-block mb-4" id="btnIngresar" value="Ingresar">
                    </div>
                    <div class="col-md-12">
                        <ul>
                            ¿Olvidaste tu contraseña o no tiene una cuenta?
                            <li>Telefóno: 999-999-999</li>
                            <li>Correo  : demo@gmail.com</li>
                        </ul>
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
        <div class="copyright pl-0">
        <p class="text-center">&copy; 2018 Copyright Sleek Dashboard Bootstrap Template by
            <a class="text-primary" href="http://www.iamabdus.com/" target="_blank">Abdus</a>.
        </p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="<?php base_url() ?>resource/app/assets/plugins/toastr/toastr.min.js"></script>
    <script src="<?php base_url() ?>resource/app/assets/js/lib/alerta.js"></script>
    <script src="<?php base_url() ?>resource/app/assets/js/lib/validarInputs.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#btnIngresar").click(function(){
                var data = new FormData();
                data.append("txtuser", $("#txtuser").val());
                data.append("txtpws", $("#txtpws").val());
                if(validarInput() == true){
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        data: data,
                        contentType: false,
                        processData: false,
                        url:"<?php base_url() ?>"+'home/login',
                        // async: true,
                        success : function(data){
                            switch(data.resp){
                              case 100:
                                bloquearInputs();
                                alerta('success', 'Mensaje:', data.text);
                                window.location.href = "<?php base_url() ?>" + "home/cpanel";
                              break;
                              case 10:
                                alerta('error', 'Error:', data.text);
                              break;
                            }
                        }
                    });
                }else{
                    alerta('error', 'Error: ','Los campos que son obligatorios.');
                }
            });
        });
    </script>
</body>
</html>