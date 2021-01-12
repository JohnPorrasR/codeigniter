<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Plantilla</title>

        <!-- Bootstrap -->
        <link href="<?= base_url() ?>resource/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>resource/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>resource/vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?= base_url() ?>resource/vendors/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>resource/build/css/custom.min.css" rel="stylesheet">
        <script src="<?php base_url() ?>resource/app/assets/plugins/nprogress/nprogress.js"></script>
        <link href="<?php base_url() ?>resource/app/assets/plugins/toastr/toastr.min.css" rel="stylesheet"/>
    </head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form>
                    <h1>Ingresar al sistema</h1>
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
                        <p>¿Olvidaste tu contraseña o no tiene una cuenta?</p>
                        <p>Correo  : demo@gmail.com</p>
                    </div>
                </form>
            </section>
        </div>
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