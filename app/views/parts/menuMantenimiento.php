<div class="row">
    <?php 

        foreach ($acciones as $k => $a) {
            echo $a['x_contenido'];
        }

    ?>
    <input type="hidden" id="txtBaseUrl" value="<?= base_url() ?>">
    <input type="hidden" id="txtUrl" value="<?= $url ?>">
    <input type="hidden" id="txtTabla1" value="<?= @$tabla[0] ?>">
    <input type="hidden" id="txtTabla2" value="<?= @$tabla[1] ?>">
    <input type="hidden" id="txtTabla3" value="<?= @$tabla[2] ?>">
    <input type="hidden" id="txtLabelId1" value="<?= @$labelId[0] ?>">
    <input type="hidden" id="txtLabelId2" value="<?= @$labelId[1] ?>">
    <input type="hidden" id="txtLabelId3" value="<?= @$labelId[2] ?>">
    <input type="hidden" name="txtTab" id="txtTab" value="1">
</div>



