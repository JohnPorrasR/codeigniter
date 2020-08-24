<div class="modal fade" id="modalMantenimientoM" tabindex="-1" role="dialog" aria-labelledby="modalMantenimientoMTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalMantenimientoMTitle"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formulario">
					<table class="table table-bordered" style="width:100%" id="tabla">
								<tr>
									<td><label for="lbltexto">Seleccione</label></td>
									<td>
										<select class="form-control" name="txtSeleccione" id="txtSeleccione">
											<option value=""></option>
										</select>
									</td>
								</tr>
						<?php foreach($dataCajas as $k => $d): ?>
							<?php if($d['m_visible'] == 1): ?>
								<?php if($d['column_name'] != 'm_estado'): ?>
								<tr>
									<td width="30%"><label for="<?=$d['column_name']?>"><?= $array[$k] ?></label></td>
									<td>
										<?php if($d['cmb'] == '1'): ?>
										<select class="form-control <?=$d['required']?>" name="<?=$d['column_name']?>" id="<?=$d['column_name']?>">
										</select>
										<?php else: ?>
											<?php if($d['data_type'] == 'file'): ?>
							                <div class="form-group" id="div_<?=$d['column_name']?>">
							                	<div class="input-group input-file" id="<?=$d['column_name']?>">
												  	<span class="input-group-btn">
												        <button class="btn btn-search btn-sm" type="button">Buscar</button>
												    </span>
												    <input style="height:29px;" type="text" class="form-control" placeholder='Seleccione un archivo...' />
												    <span class="input-group-btn">
													    <span class="btn-group" role="group" aria-label="Basic example">
													    	<button class="btn btn-primary btn-sm" type="button" onclick="guardarDoc('<?=$cad_ruta?>','<?=$d['column_name']?>')">Subir</button>
													    	<button class="btn btn-close btn-sm" type="button">X</button>
													    </span>
												    </span>
												    <div id="div_<?=$d['column_name']?>"></div>
												</div>
							                </div>
											<?php else: ?>
											<input type="text" name="<?=$d['column_name']?>" id="<?=$d['column_name']?>" class="form-control <?=$d['data_type']?> <?=$d['required']?>"
											<?php if($k == 0): ?>
												readonly
											<?php endif; ?>
											>
											<?php endif; ?>
										<?php endif; ?>
									</td>
								</tr>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
								<tr>
									<td><label>Entidad</label></td>
									<td>
										<select class="form-control" id="m_entidad_id" name="m_entidad_id">
											<option selected>Seleccione...</option>
											<?php foreach ($entidades as $k => $d): ?>
												<option value="<?= $d['n_id_entidad']  ?>"><?= $d['x_entidad_abr'] ?></option>
											<?php endforeach ?>
										</select>
									</td>
								</tr>
					</table>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-pill" id="btnGuardarDatos">Guardar</button>
			</div>
		</div>
	</div>
</div>


