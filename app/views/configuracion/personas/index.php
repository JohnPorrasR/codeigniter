<?php $this->load->view('template/cuerpo/parte1'); ?>

    <link href="<?= base_url(); ?>resource/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?= base_url(); ?>resource/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/assets/css/lib/tableSelected.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/toastr/toastr.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<?php $this->load->view('template/cuerpo/parte2'); ?>
<!-- page content -->
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <?php $this->load->view('parts/menuMantenimiento'); ?>
                    </div>
                    <div class="x_content">
                        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                            <?php foreach ($tabs as $k => $t): ?>
                                <li class="nav-item">
                                    <?php if ($k == 0): ?>
                                        <a class="nav-link active" id="tab_content<?= $k ?>-tab" data-toggle="tab" href="#tab_content<?= $k ?>" role="tab" aria-controls="tab_content<?= $k ?>" aria-selected="true"><?= $t ?></a>
                                    <?php else: ?>
                                        <a class="nav-link" id="tab_content<?= $k ?>-tab" data-toggle="tab" href="#tab_content<?= $k ?>" role="tab" aria-controls="tab_content<?= $k ?>" aria-selected="true"><?= $t ?></a>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <?php foreach ($tabs as $k => $t): ?>
                                <?php if ($k == 0): ?>
                                    <div class="tab-pane fade show active" id="tab_content<?= $k ?>" role="tabpanel" aria-labelledby="tab_content<?= $k ?>-tab">
                                <?php else: ?>
                                    <div class="tab-pane fade" id="tab_content<?= $k ?>" role="tabpanel" aria-labelledby="tab_content<?= $k ?>-tab">
                                <?php endif ?>
                                        <?php $this->load->view('parts/tabs/tabla_mantenimiento/'.'part_tab_content'.($k+1)); ?>
                                    </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- /page content -->

<?php $this->load->view('parts/modal/modalMantenimiento'); ?>
<?php $this->load->view('parts/modal/modalEstado'); ?>

<?php $this->load->view('template/cuerpo/parte3'); ?>
    <script src="<?= base_url(); ?>resource/assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/datatables/dataTables.bootstrap4.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/datatables/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/datatables/dataTables.select.min.js"></script>
    <script src="<?= base_url(); ?>resource/vendors/toastr/toastr.min.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/lib/tableSelected.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/lib/alerta.js"></script>
    <script src="<?= base_url(); ?>resource/assets/js/lib/validarInputs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $("#n_id_persona").attr('readonly', 'readonly');
    $("#n_id_persona").val(0);
    $("#x_usuario").attr('readonly', 'readonly');

    $("#tab_content0-tab").click(function(){
        $("#txtTab").val(1);
    });
    $("#tab0-tab").click(function(){
        $("#txtTab").val(1);
    });

    // Cargar datos de los combos    
    $.ajax({
        type: "POST",
        dataType:"json",
        contentType: false,
        processData: false,
        url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/combos',
        // async: true,
        success : function(response){
            $("#m_entidad_id").html('<option value="">Seleccione...</option>');
            for (var i = 0; i < response.entidades.length; i++) {
                $("#m_entidad_id").append('<option value="'+response.entidades[i]['n_id_entidad']+'">'+response.entidades[i]['x_entidad_nomb']+'</option>');
            }
            $("#x_tipo_doc").html('<option value="">Seleccione...</option>');
            for (var i = 0; i < response.tiposDocs.length; i++) {
                $("#x_tipo_doc").append('<option value="'+response.tiposDocs[i]+'">'+response.tiposDocs[i]+'</option>');
            }
            $("#m_perfil_entidad_id").html('<option value="">Seleccione...</option>');
            for (var i = 0; i < response.perfiles.length; i++) {
                $("#m_perfil_entidad_id").append('<option value="'+response.perfiles[i]['n_id_perfil_entidad']+'">'+response.perfiles[i]['x_desc_perfil']+'</option>');
            }
            $("#m_cargo_entidad_id").html('<option value="">Seleccione...</option>');
            for (var i = 0; i < response.cargos.length; i++) {
                $("#m_cargo_entidad_id").append('<option value="'+response.cargos[i]['n_id_cargo_entidad']+'">'+response.cargos[i]['x_cargo_desc']+'</option>');
            }
        }
    }); 
</script>    
<script>
    var tabla1;
    $("#tabla1_filter .search-input-text").hide();

    $(document).ready(function(){

        $('#tabla1 thead .filters th').each(function() {
            var buscador = [0,1,4,5,6,7,10,11,12,13];
            for (var i = 0; i <= buscador.length; i++) {
                if($(this).index() == buscador[i]){
                    var title = $('#tabla1 thead tr:eq(0) th').eq($(this).index()).text();
                    $(this).html('<input type="text" class="form-control form-control-sm searching" placeholder="" />');
                }
            }
        });

        tabla1 = $('#tabla1').DataTable({
            "processing": true, // Feature control the processing indicator.
            "searching": true,
            "order": [], // Initial no order.
            "ajax": {
                "url" : $("#txtBaseUrl").val()+'/'+$("#txtUrl").val()+"/mostrar_datos",
                "type": "POST"
            },
            "columns": [
                {
                    "class":    "text-center align-middle",
                    "data":     "id"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "pat"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "mat"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "nomb"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "tipo_doc"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "nro_doc"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "corr_p"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "corr_i"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "cel"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "cum"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "usu"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "cargo"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "perfil"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "estado"
                }
            ],
            "columnDefs": [
                {
                    "targets": [], //last column
                    "orderable": false, //set not orderable,
                }
            ],
            "orderCellsTop": true,
            "fixedHeader": true,
            "language": {
                "processing":       "Procesando...",
                "lengthMenu":       "Mostrar _MENU_ registros",
                "zeroRecords":      "NO SE ENCONTRARON RESULTADOS",
                "emptyTable":       "NINGÚN DATO DISPONIBLE EN ESTA TABLA",
                "info":             "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "infoEmpty":        "",//"Mostrando requerimientos del 0 al 0 de un total de 0 requerimientos",
                "infoFiltered":     "",
                "infoPostFix":      "",
                "search":           "Buscar:",
                "url":              "",
                "infoThousands":    ",",
                "loadingRecords":   "Cargando...",
                "paginate": {
                    "first":        "Primero",
                    "last":         "Último",
                    "next":         "Siguiente",
                    "previous":     "Anterior"
                },
                "aria": {
                    "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copyTitle": "Copiar al portapapeles",
                    "copySuccess": {
                        _: '%d filas copiadas al portapapeles',
                        1: '1 fila copiada al portapapeles'
                    }
                }
            },
            "lengthMenu": [[15, 30, 50, 100], [15, 30, 50, 100]],
            "iDisplayLength": 15,
        });

        tabla1.columns().eq(0).each(function(colIdx) {
            //$('input', $('.filters th')[colIdx]).on('keyup change', function() {
            $('input', $('.filters th')[colIdx]).on('keypress', function(e) {
                if (e.keyCode == 13) {
                    tabla1
                    .column(colIdx)
                    .search(this.value)
                    .draw();
                }
            });
        });
    });

    function reload_table1() {
        // tabla_ie.ajax.reload(null,false);        
        tabla1.ajax.reload();
    }

    $('#tabla1_filter .search-input-text').on('keypress', function(e) { // for text boxes
        console.log(e);
        if (e.keyCode == 13) {
            var i = $(this).attr('data-column'); // getting column index
            var v = $(this).val(); // getting search input value
            tabla1.columns(i).search(v).draw();
        }
    });

    $('#tabla1 .search-input-select').on('change', function() { // for select box
        var i =$(this).attr('data-column');
        var v =$(this).val();
        tabla1.columns(i).search(v).draw();
    });
</script>
    <script src="<?= base_url(); ?>resource/assets/js/lib/funcionesDefault.js"></script>
<script>

    $(document).ready(function(){

        $("#btnNuevo").click(function(){
            $('#formulario'+$("#txtTab").val()).find('input,select').each(function(idx,input){
                $("#"+$(input).attr("id")).val('');
            });
            $("#n_id_persona").val(0);
            $("#m_estado").val(1);
        });

        $("#x_num_doc").focusout(function(){
            $("#x_usuario").val($(this).val());
        });

        $("#btnEditar").click(function(){
            var tab = $("#txtTab").val();
            console.log(tab);
            //$("#"+tab).tabs("option", "active");
            var cod = $(".selected").find("td").eq(0).text();
            if(cod > 0)
            {
                var data = new FormData();
                data.append("txtCod", cod);
                $.ajax({
                    type: "POST",
                    dataType:"json",
                    contentType: false,
                    processData: false,
                    data: data,
                    url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/obtener_dato',
                    // async: true,
                    success : function(response){
                        $("#n_id_persona").val(response.data[0]['n_id_persona']);
                        $("#x_ape_pat").val(response.data[0]['x_ape_pat']);
                        $("#x_ape_mat").val(response.data[0]['x_ape_mat']);
                        $("#x_nombres").val(response.data[0]['x_nombres']);
                        $("#x_tipo_doc").val(response.data[0]['x_tipo_doc']);
                        $("#x_num_doc").val(response.data[0]['x_num_doc']);
                        $("#x_correo_personal").val(response.data[0]['x_correo_personal']);
                        $("#x_correo_institucional").val(response.data[0]['x_correo_institucional']);
                        $("#m_celular").val(response.data[0]['m_celular']);
                        $("#f_cumple").val(response.data[0]['f_cumple']);
                        $("#x_usuario").val(response.data[0]['x_usuario']);
                        $("#m_cargo_entidad_id").val(response.data[0]['m_cargo_entidad_id']);
                        $("#m_perfil_entidad_id").val(response.data[0]['m_perfil_entidad_id']);
                        $("#m_estado").val(response.data[0]['m_estado']);
                    }
                });
                $("#modalMantenimiento").modal('show');
            }
            else
            {
                alerta('error', 'Error:', 'Debe de seleccionar un registro');
            }
        });

        $("#btnGuardarDatos").click(function(){
            var data = new FormData();
            $('#formulario'+$("#txtTab").val()).find('input,select').each(function(idx,input){
                data.append($(input).attr("id"), $(input).val());
            });
            data.append('val',$("#txtTab").val());
            $.ajax({
                type: "POST",
                dataType:"json",
                contentType: false,
                processData: false,
                data: data,
                url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/guardar',
                // async: true,
                success : function(response){
                    switch(response.resp){
                        case 100:
                            alerta(response.tipo, response.titulo, response.text);
                            $("#modalMantenimiento").modal('hide');
                            reload_table1();
                            reload_table2();
                            reload_table3();
                        break;
                        case 10:
                            alerta(response.tipo, response.titulo, response.text);
                        break;
                    }
                }
            });
        });

        $("#m_entidad_id").change(function(){
            var data = new FormData();
            data.append("txtCod", $(this).val());
            $.ajax({
                type: "POST",
                dataType:"json",
                contentType: false,
                processData: false,
                data: data,
                url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/cargar_combos',
                // async: true,
                success : function(response){
                    $("#m_perfil_entidad_id").html('<option value="">Seleccione...</option>');
                    for (var i = 0; i < response.perfiles.length; i++) {
                        $("#m_perfil_entidad_id").append('<option value="'+response.perfiles[i]['n_id_perfil_entidad']+'">'+response.perfiles[i]['x_desc_perfil']+'</option>');
                    }
                    $("#m_cargo_entidad_id").html('<option value="">Seleccione...</option>');
                    for (var i = 0; i < response.cargos.length; i++) {
                        $("#m_cargo_entidad_id").append('<option value="'+response.cargos[i]['n_id_cargo_entidad']+'">'+response.cargos[i]['x_cargo_desc']+'</option>');
                    }
                }
            }); 
        });

    });

</script>
<?php $this->load->view('template/cuerpo/parte4'); ?>

