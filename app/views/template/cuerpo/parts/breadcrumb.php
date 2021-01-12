<div class="breadcrumb-wrapper" style="margin: -30px auto 0;">
    <?php if(strlen(@$txt) > 0): ?>
        <h2><?= @$txt ?></h2>
    <?php endif; ?>
    <nav class="breadcrumb">
        <li class="breadcrumb-item">
            <span class="fa fa-home"></span>
            <a href="<?php echo base_url(); ?>home/cpanel">Inicio</a>
        </li>
        <?php if (strlen(@$nivel1) > 0) { ?>
        <li class="breadcrumb-item">
            <?php echo @$nivel1; ?>
        </li>
        <?php } ?>
        <?php if (strlen(@$nivel2) > 0) { ?>
        <li class="breadcrumb-item active">
            <?php echo @$nivel2; ?>
        </li>
        <?php } ?>
        <?php if (strlen(@$nivel3) > 0) { ?>
        <li class="breadcrumb-item active">
            <?php echo @$nivel3; ?>
        </li>
        <?php } ?>
    </nav>
</div>