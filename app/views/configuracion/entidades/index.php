<?php $this->load->view('template/cuerpo/parte1'); ?>

    <link href="<?= base_url(); ?>resource/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?= base_url(); ?>resource/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/assets/css/lib/tableSelected.css" rel="stylesheet">
    <link href="<?= base_url(); ?>resource/vendors/toastr/toastr.min.css" rel="stylesheet"/>

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

                        <table id="tabla1" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <?php foreach ($labelTabla1 as $k => $l): ?>
                                    <th class="text-center" style="vertical-align: middle;"><?= $l ?></th>
                                    <?php endforeach ?>
                                </tr>
                            </thead>
                            <thead>
                                <tr class="filters">
                                    <?php foreach ($labelTabla1 as $k => $l): ?>
                                    <th class="text-center" style="vertical-align: middle;"></th>
                                    <?php endforeach ?>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
<script>

    var tabla1;
    var url = "<?= $url; ?>";

    $(document).ready(function(){

        $("#n_id_entidad").attr("readonly","readonly");

        $('#tabla1 thead .filters th').each(function() {
            var buscador = [0,1,5];
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
                "url" : "<?php echo base_url().'configuracion/entidades/mostrar_datos' ?>",
                "type": "POST"
            },
            "columns": [
                {
                    "class":    "text-center align-middle",
                    "data":     "id"
                },{
                    "class":    "text-left align-middle",
                    "data":     "nomb"
                },{
                    "class":    "text-left align-middle",
                    "data":     "abr"
                },{
                    "class":    "text-left align-middle",
                    "data":     "direc"
                },{
                    "class":    "text-center align-middle",
                    "data":     "nodo"
                },{
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

        $.ajax({
            type: "GET",
            dataType:"json",
            contentType: false,
            processData: false,
            url:"<?=base_url()?>"+url+'/combo',
            // async: true,
            success : function(data){
                $("#m_entidad_id").html('<option value="0">Seleccione...</option>');
                for (var i = 0; i < data.data.length; i++) {
                    $("#m_entidad_id").append('<option value="'+data.data[i]['n_id_entidad']+'">'+data.data[i]['x_entidad_nomb']+'</option>');
                }
            }
        });

    });

    function reload_table1() {
        // tabla_ie.ajax.reload(null,false);        
        tabla1.ajax.reload();
    }

    $('.search-input-text').on('keypress', function(e) { // for text boxes
        console.log(e);
        if (e.keyCode == 13) {
            var i = $(this).attr('data-column'); // getting column index
            var v = $(this).val(); // getting search input value
            tabla1.columns(i).search(v).draw();
        }
    });

    $('.search-input-select').on('change', function() { // for select box
        var i =$(this).attr('data-column');
        var v =$(this).val();
        tabla1.columns(i).search(v).draw();
    });

</script>
    <script src="<?= base_url(); ?>resource/assets/js/lib/funcionesDefault.js"></script>
<script>
    
    $(document).ready(function(){

        $("#btnEditar").click(function(){
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
                    url:"<?=base_url()?>"+url+'/obtener_dato',
                    // async: true,
                    success : function(response){
                        $("#n_id_entidad").val(response.data[0]["n_id_entidad"]);
                        $("#x_entidad_nomb").val(response.data[0]["x_entidad_nomb"]);
                        $("#x_entidad_abr").val(response.data[0]["x_entidad_abr"]);
                        $("#x_direccion").val(response.data[0]["x_direccion"]);
                        $("#m_entidad_id").val(response.data[0]["m_entidad_id"]);
                        $("#m_estado").val(response.data[0]["m_estado"]);
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
            $('#formulario1').find('input,select').each(function(idx,input){
                data.append($(input).attr("id"), $(input).val());
            });
            $.ajax({
                type: "POST",
                dataType:"json",
                contentType: false,
                processData: false,
                data: data,
                url:"<?=base_url()?>"+url+'/guardar',
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
        });

    });

</script>
<?php $this->load->view('template/cuerpo/parte4'); ?>

