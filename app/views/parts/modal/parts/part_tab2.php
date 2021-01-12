<form id="formulario2">
  <table class="table table-bordered" style="width:100%" id="tablaMantenimiento">
    <?php foreach($cajas2 as $k => $d): ?>
      <tr>
        <td width="30%">
          <?php if ($d['column_name'] != 'm_estado'): ?>
            <label for="<?=$d['column_name']?>"><?= $label2[$k] ?></label> 
            <?php if ($d['required'] == 'required'): ?>
            <span style="color: red;">*</span> 
            <?php endif ?>
          <?php endif ?>
        </td>
        <td>
          <?php if ($d['combo'] == 1): ?>
            <?php if ($d['column_name'] != 'm_estado'): ?>
              <select name="<?= $d['column_name'] ?>" id="<?= $d['column_name'] ?>" class="form-control">
                <option value="">Selecione...</option>
              </select>
            <?php endif ?>
          <?php else: ?>
          <input type="text" name="<?=$d['column_name']?>" id="<?=$d['column_name']?>" class="form-control <?= $d['data_type'] ?> <?= $d['required'] ?>">
          <?php endif ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<div id="divContent2"></div>
</form>