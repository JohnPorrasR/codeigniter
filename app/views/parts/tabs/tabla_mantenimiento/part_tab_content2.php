<table id="tabla2" class="table table-hover table-bordered" style="width:100%">
    <thead>
        <tr>
            <?php foreach ($labelTabla2 as $k => $l): ?>
            <th class="text-center" style="vertical-align: middle;"><?= $l ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <thead>
        <tr class="filters">
            <?php foreach ($labelTabla2 as $k => $l): ?>
            <th class="text-center" style="vertical-align: middle;"></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>