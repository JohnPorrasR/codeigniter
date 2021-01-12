<form id="formulario1">
  <table class="table table-bordered" style="width:100%" id="tablaMantenimiento">
    <?php foreach($cajas1 as $k => $d): ?>
      <tr>
        <td width="30%">
          <label for="<?=$d['column_name']?>"><?= $label1[$k] ?></label> 
          <?php if ($d['required'] == 'required'): ?>
          <span style="color: red;">*</span> 
          <?php endif ?>
        </td>
        <td>
          <?php if ($d['combo'] == 1): ?>
            <?php if ($d['column_name'] == 'm_estado'): ?>
              <select name="<?= $d['column_name'] ?>" id="<?= $d['column_name'] ?>" class="form-control">
                <option value="">Selecione...</option>
                <option value="0">Bloqueado</option>
                <option value="1">Habilitado</option>
              </select>
            <?php else: ?>
              <select name="<?= $d['column_name'] ?>" id="<?= $d['column_name'] ?>" class="form-control" <?=$d['attr']?> style="width: 100%;">
              </select>
            <?php endif ?>
          <?php else: ?>
            <?php if ($d['type'] == 'text'): ?>
              <textarea  name="<?=$d['column_name']?>" id="<?=$d['column_name']?>" class="form-control <?= $d['data_type'] ?> <?= $d['required'] ?>" rows="5"></textarea>
            <?php else: ?>
              <input type="text" name="<?=$d['column_name']?>" id="<?=$d['column_name']?>" class="form-control <?= $d['data_type'] ?> <?= $d['required'] ?>">
            <?php endif ?>
          <?php endif ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<div id="divContent1"></div>
</form>