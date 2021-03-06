    <!-- fin cuerpo -->
    </div>

    </div>
    <!-- fin pie -->
    <?php $this->load->view('template/cuerpo/parts/pie'); ?>
    <!-- fin pie -->
    </div>

    <!-- cambio de clave -->
    <?php $this->load->view('parts/modal/modalCambiarClave'); ?>
    <!-- fin cambio de clave -->

</div>

<!-- jQuery -->
<script src="<?= base_url() ?>resource/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() ?>resource/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>resource/vendors/nprogress/nprogress.js"></script>
<script src="<?= base_url() ?>resource/build/js/custom.min.js"></script>

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
                    url:"<?=base_url()?>"+'home/cambiar_clave',
                    success : function(data){
                        console.log(data.resp);
                        switch(data.resp){
                            case 100:
                                $("#divAlert").show();
                                $("#divAlert").addClass('alert-success');
                                $("#divAlert").text(data.text);
                                $("#txtClave").val('');
                                $("#txtConfirmar").val('');
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

