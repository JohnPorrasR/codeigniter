<div class="modal fade" id="modalMantenimiento" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalMantenimientoMTitle"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
	                <?php foreach ($tabs as $k => $t): ?>
	                	<li class="nav-item">
	                		<?php if ($k == 0): ?>
	                			<a class="nav-link active" id="tab<?= $k ?>-tab" data-toggle="tab" href="#tab<?= $k ?>" role="tab" aria-controls="tab<?= $k ?>" aria-selected="true"><?= $t ?></a>
	                		<?php else: ?>
	                			<a class="nav-link" id="tab<?= $k ?>-tab" data-toggle="tab" href="#tab<?= $k ?>" role="tab" aria-controls="tab<?= $k ?>" aria-selected="true"><?= $t ?></a>
	                		<?php endif ?>
	                	</li>
	                <?php endforeach ?>
                </ul>
                <div class="tab-content" id="myTabContent">
	                <?php foreach ($tabs as $k => $t): ?>
	                	<?php if ($k == 0): ?>
		                	<div class="tab-pane fade show active" id="tab<?= $k ?>" role="tabpanel" aria-labelledby="tab<?= $k ?>-tab">
	                	<?php else: ?>
		                	<div class="tab-pane fade" id="tab<?= $k ?>" role="tabpanel" aria-labelledby="tab<?= $k ?>-tab">
		                <?php endif ?>
		                		<?php $this->load->view('parts/modal/parts/'.'part_tab'.($k+1)); ?>
		                	</div>
	                <?php endforeach ?>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-pill" id="btnGuardarDatos">Guardar</button>
			</div>
		</div>
	</div>
</div>


