    $(document).ready(function(){

        $("#btnExcel").click(function(){
            ennlace = $("#txtBaseUrl").val()+'home/excel/'+$("#txtTabla").val();
            window.open(ennlace, '_blank');
            return false;
        });

        $("#btnEliminar").click(function(){
            var cod = $(".selected").find("td").eq(0).text();
            if(cod > 0)
            {
                $("#txtModalEstadoTitle").text('¿Desea bloquear el registro?');
                $("#txtCod").val(cod);
                $("#txtEstado").val(0);
                $("#modalEstado").modal('show');
            }
            else
            {
                alerta('error', 'Error:', 'Debe de seleccionar un registro');
            }
        });

        $("#btnDesbloquear").click(function(){
            var cod = $(".selected").find("td").eq(0).text();
            if(cod > 0)
            {
                $("#txtModalEstadoTitle").text('¿Desea habilitar el registro?');
                $("#txtCod").val(cod);
                $("#txtEstado").val(1);
                $("#modalEstado").modal('show');
            }
            else
            {
                alerta('error', 'Error:', 'Debe de seleccionar un registro');
            }
        });

        $("#btnCambioEstado").click(function(){
            var cod = $(".selected").find("td").eq(0).text();
            var data = new FormData();
            data.append("tabla", $("#txtTabla"+$("#txtTab").val()).val());
            data.append("x_id", $("#txtLabelId"+$("#txtTab").val()).val());
            data.append("id", cod);
            data.append("estado", $("#txtEstado").val());
            $.ajax({
                type: "POST",
                dataType:"json",
                data: data,
                contentType: false,
                processData: false,
                url: $("#txtBaseUrl").val()+'home/cambioEstado',
                // async: true,
                success : function(response){
                    switch(response.resp){
                        case 100:
                            alerta('success', 'Mensaje:', response.text);
                            $("#modalEstado").modal('hide');
                            reload_table1();
                            reload_table2();
                            reload_table3();
                        break;
                        case 10:
                            alerta('error', 'Error:', response.text);
                        break;
                    }
                }
            });
        });
        
        $("#btnNuevo").click(function(){
            $("#m_estado").val('');
            $("#tabla tbody tr").removeClass('selected');
            $('#formulario').find('input,select').each(function(idx,input){
                $(input).val('');
            });
            $("#"+$("#txtLabelId").val()).val(0);
            $("#m_estado").val(1);
            $("#modalMantenimiento").modal('show');
            return false;
        });

    });