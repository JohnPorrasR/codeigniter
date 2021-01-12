<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?= base_url() ?>home/cpanel" class="site_title"><i class="fa fa-paw"></i> <span><?= @$this->session->userdata('sistema') ?></span></a>
        </div>

        <div class="clearfix"></div>
        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <?php foreach (@$this->session->userdata('menu_n1') as $k1 => $d1){ ?>
                     <h3><?= $d1["x_modulo_desc"] ?></h3>
                     <ul class="nav side-menu">
                     <?php foreach (@$this->session->userdata('menu_n2') as $k2 => $d2){ ?>
                         <?php if($d1["n_id_modulo"] == $d2["m_modulo_id"]): ?>
                         <li><a><i class="<?= $d2["x_etiqueta"] ?>"></i> <?= $d2["x_modulo_desc"] ?> <span class="fa fa-chevron-down"></span></a>
                             <ul class="nav child_menu">
                             <?php foreach (@$this->session->userdata('menu_n3') as $k3 => $d3){ ?>
                                 <?php if($d2["n_id_modulo"] == $d3["m_modulo_id"]): ?>
                                 <li><a href="<?= base_url().$d2["x_url"].'/'.$d3["x_url"] ?>"><?= $d3["x_modulo_desc"] ?></a></li>
                                 <?php endif ?>
                             <?php } ?>
                             </ul>
                         </li>
                         <?php endif ?>
                     <?php } ?>
                     </ul>
                <?php } ?>
                <br />
            </div>

        </div>
        <!-- /sidebar menu -->

    </div>
</div>