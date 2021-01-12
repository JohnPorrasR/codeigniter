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
    $("#n_id_permiso_base").attr('readonly', 'readonly');
    $("#n_id_permiso_base").val(0);
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
        url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/cargar_combos',
        // async: true,
        success : function(response){
            for (var i = 0; i < response.perfiles.length; i++) {
                $("#m_perfil_entidad_id").append('<option value="'+response.perfiles[i]['n_id_perfil']+'">'+response.perfiles[i]['x_desc_perfil']+'</option>');
            }
            for (var i = 0; i < response.modulos.length; i++) {
                $("#m_modulo_id").append('<option value="'+response.modulos[i]['n_id_modulo']+'">'+response.modulos[i]['x_modulo_desc']+'</option>');
            }
        }
    });
</script>    
<script>
    var tabla1;
    $("#tabla1_filter .search-input-text").hide();

    $(document).ready(function(){

        $('#tabla1 thead .filters th').each(function() {
            var buscador = [0,1];
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
                    "data":     "perfil"
                },
                {
                    "class":    "text-center align-middle",
                    "data":     "modulo"
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

        $('#m_modulo_id').select2();

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
                        $("#n_id_permiso_base").val(response.data[0]["m_perfil_entidad_id"]);
                        $("#x_desc_perfil").val(response.data[0]["x_desc_perfil"]);
                        $("#divContent1").html(response.html);
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
            if($("#m_perfil_entidad_id").val() > 0)
            {
                if($("#m_modulo_id").val() != null)
                {
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
                                break;
                                case 10:
                                    alerta(response.tipo, response.titulo, response.text);
                                break;
                            }
                        }
                    });
                }
                else
                {
                    alerta('error', 'Mensaje: ', 'Debe de seleccionar un módulo');
                }
            }
            else
            {
                alerta('error', 'Mensaje: ', 'Debe de seleccionar un perfil');
            }
        });

        $("#m_modulo_id").change(function()
        {
            if($(this).val().length > 0){
                if($("#m_perfil_entidad_id").val() > 0){
                    $("#m_estado").val(1);
                    var data = new FormData();
                    data.append('mod',$(this).val());
                    data.append('perf',$("#m_perfil_entidad_id").val());
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        contentType: false,
                        processData: false,
                        data: data,
                        url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/obtener_modulo',
                        // async: true,
                        success : function(response){
                            $("#divContent1").html(response.html);
                        }
                    });
                }else{
                    alerta('error', 'Mensaje: ', 'Debe de seleccionar un módulo');
                }
            }else{
                alerta('error', 'Mensaje: ', 'Debe de seleccionar un perfil');
            }
        });

        $("#m_perfil_entidad_id").change(function()
        {
            if($("#m_perfil_entidad_id").val() > 0){
                $(".select2-selection select2-selection--multiple").val('');
                var data = new FormData();
                data.append('perf',$("#m_perfil_entidad_id").val());
                $.ajax({
                    type: "POST",
                    dataType:"json",
                    contentType: false,
                    processData: false,
                    data: data,
                    url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/obtener_modulo_perfil',
                    // async: true,
                    success : function(response){
                        $("#divContent1").html(response.html);
                    }
                });
            }else{
                alerta('error', 'Mensaje: ', 'Debe de seleccionar un módulo');
            }
        });

        $("#btnNuevo").click(function(){
            $(".select2-selection select2-selection--multiple").val('');
            $("#m_perfil_entidad_id").val('');
            $("#m_modulo_id").val('');
            $("#divContent1").html('');
        });

    });

</script>
<?php $this->load->view('template/cuerpo/parte4'); ?>

