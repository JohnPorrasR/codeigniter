
                    <div class="breadcrumb-wrapper" style="margin: -30px auto 0;">
                        <?php if(strlen(@$txt) > 0): ?>
                            <h2><?= @$txt ?></h2>
                        <?php endif; ?>
                        <nav class="breadcrumb">
                            <li class="breadcrumb-item">
                                <span class="mdi mdi-home"></span>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>home/cpanel">Inicio</a>
                            </li>
                            <?php if(strlen(@$ulTxt) > 0): ?>
                                <?php if(strlen(@$liTxt) > 0): ?>
                                    <li class="breadcrumb-item">
                                        <?php echo @$ulTxt; ?>
                                    </li>
                                <?php else:  ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?php base_url().$ul.'/'.$li ?>"><?php echo @$ulTxt; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif ?>
                            <?php if(strlen(@$liTxt) > 0): ?>
                                <?php if(strlen(@$txthijo) > 0): ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?php base_url().$ul.'/'.$li ?>"><?php echo @$liTxt; ?></a>
                                    </li>
                                <?php else:  ?>
                                    <li class="breadcrumb-item active">
                                        <?php echo @$liTxt; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if(strlen(@$txthijo) > 0): ?>
                                <li class="breadcrumb-item active">
                                    <?php echo @$txthijo; ?>
                                </li>
                            <?php endif; ?>
                        </nav>
                    </div>