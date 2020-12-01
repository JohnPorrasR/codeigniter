<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
        <button class="sidebar-toggle" id="sidebar-toggler">
            <span class="sr-only">
                -
            </span>
        </button>
        <div class="search-form d-none d-lg-inline-block">
        </div>
        <div class="navbar-right ">
            <ul class="nav navbar-nav">
                <li class="dropdown user-menu">
                    <button class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">
                        <img alt="User Image" class="user-image" src="<?= @$this->session->userdata('base_url') ?>resource/app/assets/img/user/user.png"/>
                        <span class="d-none d-lg-inline-block">
                            <?= @$this->session->userdata('nomb') ?>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-footer">
                            <a href="#" id="btnCambiarClave">
                                <i class="mdi mdi-settings">
                                </i>
                                Cambiar clave
                            </a>
                        </li>
                        <li class="dropdown-footer">
                            <a href="<?php echo base_url();?>home/logout">
                                <i class="mdi mdi-logout">
                                </i>
                                Salir
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>