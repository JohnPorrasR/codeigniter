<div class="modal fade" id="modalCambiarClave" tabindex="-1" role="dialog" aria-labelledby="modalMantenimientoSTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalMantenimientoSTitle">Cambiar clave</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="clave">Clave</label>
						<input type="text" class="form-control" id="txtClave" placeholder="Clave">
						<div id="divClave" class="alert" style="display: none;"></div>
					</div>
					<div class="form-group">
						<label for="confirmar">Confirmar clave</label>
						<input type="text" class="form-control" id="txtConfirmar" placeholder="confirmar clave">
						<div id="divConfirmar" class="alert" style="display: none;"></div>
					</div>
				</form>
				<div id="divAlert" class="alert" style="display: none;"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary btn-pill" id="btnGuardarClave">Guardar</button>
			</div>
		</div>
	</div>
</div>
