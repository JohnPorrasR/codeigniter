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
    $("#n_id_perfil").attr('readonly', 'readonly');
    $("#n_id_perfil").val(0);
    $("#n_id_perfil_entidad").attr('readonly', 'readonly');
    $("#n_id_perfil_entidad").val(0);
    $("#n_id_perfil_accion").attr('readonly', 'readonly');
    $("#n_id_perfil_accion").val(0);

    $("#tab_content0-tab").click(function(){
        $("#txtTab").val(1);
    });
    $("#tab_content1-tab").click(function(){
        $("#txtTab").val(2);
    });
    $("#tab_content2-tab").click(function(){
        $("#txtTab").val(3);
    });
    $("#tab0-tab").click(function(){
        $("#txtTab").val(1);
    });
    $("#tab1-tab").click(function(){
        $("#txtTab").val(2);
    });
    $("#tab2-tab").click(function(){
        $("#txtTab").val(3);
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
                $("#formulario2 #m_perfil_id").append('<option value="'+response.perfiles[i]['n_id_perfil']+'">'+response.perfiles[i]['x_desc_perfil']+'</option>');
                $("#formulario3 #m_perfil_id").append('<option value="'+response.perfiles[i]['n_id_perfil']+'">'+response.perfiles[i]['x_desc_perfil']+'</option>');
            }
            for (var i = 0; i < response.acciones.length; i++) {
                if(i == 0){
                    $("#m_accion_id").html('<option value="'+response.acciones[i]['n_id_accion']+'">'+response.acciones[i]['x_descripcion']+'</option>');
                }else{
                    $("#m_accion_id").append('<option value="'+response.acciones[i]['n_id_accion']+'">'+response.acciones[i]['x_descripcion']+'</option>');
                }
            }
            for (var i = 0; i < response.modulos.length; i++) {
                $("#m_modulo_id").append('<option value="'+response.modulos[i]['n_id_modulo']+'">'+response.modulos[i]['x_modulo_desc']+'</option>');
            }
            for (var i = 0; i < response.entidades.length; i++) {
                $("#m_entidad_id").append('<option value="'+response.entidades[i]['n_id_entidad']+'">'+response.entidades[i]['x_entidad_nomb']+'</option>');
            }
        }
    });
</script>    
<script>
    var tabla1;
    $("#tabla1_filter .search-input-text").hide();

    $(document).ready(function(){

        $('#tabla1 thead .filters th').each(function() {
            var buscador = [0,1,2];
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
                "url" : $("#txtBaseUrl").val()+'/'+$("#txtUrl").val()+"/mostrar_perfiles",
                "type": "POST"
            },
            "columns": [
                {
                    "class":    "text-center align-middle",
                    "data":     "id"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "nomb"
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
<script>
    var tabla2;
    $("#tabla2_filter .search-input-text").hide();

    $(document).ready(function(){

        $('#tabla2 thead .filters th').each(function() {
            var buscador = []; //[0,1,2];
            for (var i = 0; i <= buscador.length; i++) {
                if($(this).index() == buscador[i]){
                    var title = $('#tabla2 thead tr:eq(0) th').eq($(this).index()).text();
                    $(this).html('<input type="text" class="form-control form-control-sm searching" placeholder="" />');
                }
            }
        });

        tabla2 = $('#tabla2').DataTable({
            "processing": true, // Feature control the processing indicator.
            "searching": true,
            "order": [], // Initial no order.
            "ajax": {
                "url" : $("#txtBaseUrl").val()+'/'+$("#txtUrl").val()+"/mostrar_perfiles_entidades",
                "type": "POST"
            },
            "columns": [
                {
                    "class":    "text-center align-middle",
                    "data":     "id"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "nomb"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "entidad"
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

        tabla2.columns().eq(0).each(function(colIdx) {
            //$('input', $('.filters th')[colIdx]).on('keyup change', function() {
            $('input', $('.filters th')[colIdx]).on('keypress', function(e) {
                if (e.keyCode == 13) {
                    tabla2
                    .column(colIdx)
                    .search(this.value)
                    .draw();
                }
            });
        });
    });

    function reload_table2() {
        // tabla_ie.ajax.reload(null,false);        
        tabla2.ajax.reload();
    }

    $('#tabla2_filter .search-input-text').on('keypress', function(e) { // for text boxes
        console.log(e);
        if (e.keyCode == 13) {
            var i = $(this).attr('data-column'); // getting column index
            var v = $(this).val(); // getting search input value
            tabla2.columns(i).search(v).draw();
        }
    });

    $('#tabla2 .search-input-select').on('change', function() { // for select box
        var i =$(this).attr('data-column');
        var v =$(this).val();
        tabla2.columns(i).search(v).draw();
    });
</script>
<script>
    var tabla3;
    $("#tabla3_filter .search-input-text").hide();

    $(document).ready(function(){
        $('#tabla3 thead .filters th').each(function() {
            var buscador = []; //[0,1,2,3,4];
            for (var i = 0; i <= buscador.length; i++) {
                if($(this).index() == buscador[i]){
                    var title = $('#tabla3 thead tr:eq(0) th').eq($(this).index()).text();
                    $(this).html('<input type="text" class="form-control form-control-sm searching" placeholder="" />');
                }
            }
        });

        tabla3 = $('#tabla3').DataTable({
            "processing": true, // Feature control the processing indicator.
            "searching": true,
            "order": [], // Initial no order.
            "ajax": {
                "url" : $("#txtBaseUrl").val()+'/'+$("#txtUrl").val()+"/mostrar_perfiles_acciones",
                "type": "POST"
            },
            "columns": [
                {
                    "class":    "text-center align-middle",
                    "data":     "id"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "per"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "mod"
                },
                {
                    "class":    "text-left align-middle",
                    "data":     "acc"
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

        tabla3.columns().eq(0).each(function(colIdx) {
            //$('input', $('.filters th')[colIdx]).on('keyup change', function() {
            $('input', $('.filters th')[colIdx]).on('keypress', function(e) {
                if (e.keyCode == 13) {
                    tabla3
                    .column(colIdx)
                    .search(this.value)
                    .draw();
                }
            });
        });
    });
    
    function reload_table3() {
        // tabla_ie.ajax.reload(null,false);        
        tabla3.ajax.reload();
    }

    $('#tabla3_filter .search-input-text').on('keypress', function(e) { // for text boxes
        if (e.keyCode == 13) {
            var i = $(this).attr('data-column'); // getting column index
            var v = $(this).val(); // getting search input value
            tabla3.columns(i).search(v).draw();
        }
    });

    $('#tabla3 .search-input-select').on('change', function() { // for select box
        var i =$(this).attr('data-column');
        var v =$(this).val();
        tabla3.columns(i).search(v).draw();
    });
</script>
    <script src="<?= base_url(); ?>resource/assets/js/lib/funcionesDefault.js"></script>
<script>

    $(document).ready(function(){

        $('#formulario3 #m_accion_id').select2();

        $("#btnEditar").click(function(){
            var tab = $("#txtTab").val();
            console.log(tab);
            //$("#"+tab).tabs("option", "active");
            var cod = $(".selected").find("td").eq(0).text();
            if(cod > 0)
            {
                var data = new FormData();
                data.append("txtCod", cod);
                if(tab == 1)
                {
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        contentType: false,
                        processData: false,
                        data: data,
                        url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/obtener_dato',
                        // async: true,
                        success : function(response){
                            $("#"+$("#txtLabelId1").val()).val(response.data[0]["n_id_perfil"]);
                            $("#x_desc_perfil").val(response.data[0]["x_desc_perfil"]);
                            $("#m_estado").val(response.data[0]["m_estado"]);
                        }
                    });
                }
                else if(tab == 2)
                {
                    $("#"+$("#txtLabelId1").val()).val('');
                    $("#x_desc_perfil").val('');
                    $("#m_estado").val('');
                    $("#m_perfil_id").val('');
                    $("#m_modulo_id").val('');
                    $("#m_accion_id").val('');
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        contentType: false,
                        processData: false,
                        data: data,
                        url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/obtener_perfil_entidad',
                        // async: true,
                        success : function(response){
                            $("#"+$("#txtLabelId2").val()).val(response.data[0]["n_id_perfil_entidad"]);
                            $("#formulario2 #m_perfil_id").val(response.data[0]["m_perfil_id"]);
                            $("#m_entidad_id").val(response.data[0]["m_entidad_id"]);
                        }
                    });
                }
                else
                {
                    $("#"+$("#txtLabelId3").val()).val('');
                    $("#x_desc_perfil").val('');
                    $("#m_estado").val('');
                    $("#n_id_perfil").val(0);
                    $("#x_desc_perfil").val('');
                    $("#m_estado").val('');
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        contentType: false,
                        processData: false,
                        data: data,
                        url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/obtener_perfil_accion',
                        // async: true,
                        success : function(response){
                            $("#"+$("#txtLabelId2").val()).val(response.data[0]["n_id_perfil_accion"]);
                            $("#formulario3 #m_perfil_id").val(response.data[0]["m_perfil_id"]);
                            alerta(response.tipo, response.titulo, response.text);
                        }
                    });
                }
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

        $("#formulario3 #m_modulo_id").change(function()
        {
            if($(this).val() > 0){
                if($("#formulario3 #m_perfil_id").val() > 0){
                    var data = new FormData();
                    data.append('mod',$(this).val());
                    data.append('perf',$("#formulario3 #m_perfil_id").val());
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        contentType: false,
                        processData: false,
                        data: data,
                        url: $("#txtBaseUrl").val()+$("#txtUrl").val()+'/obtener_perfil_modulo',
                        // async: true,
                        success : function(response){
                                $("#divContent3").html('');
                            if(response.data.length > 0){
                                for (var i = 0; i < response.data.length; i++) {
                                    $("#divContent3").append('<h3 class="badge badge-primary" style="margin:3px 5px;">'+response.data[i]['x_descripcion']+'</h3>');
                                }
                            }
                        }
                    });
                }else{
                    alerta('error', 'Mensaje: ', 'Debe de seleccionar un módulo');
                }
            }else{
                alerta('error', 'Mensaje: ', 'Debe de seleccionar un perfil');
            }
        });

    });

</script>
<?php $this->load->view('template/cuerpo/parte4'); ?>

