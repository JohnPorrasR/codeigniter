
        <aside class="left-sidebar bg-sidebar">
            <div class="sidebar sidebar-with-footer" id="sidebar">
                <div class="app-brand">
                    <a href="<?= @$this->session->userdata('base_url') ?>">
                        <svg class="brand-icon" height="33" preserveaspectratio="xMidYMid" viewbox="0 0 30 33" width="30" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" fill-rule="evenodd">
                                <path class="logo-fill-blue" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" fill="#7DBCFF">
                                </path>
                                <path class="logo-fill-white" d="M11 4v25l8 4V0z" fill="#FFF">
                                </path>
                            </g>
                        </svg>
                        <span class="brand-name">
                            FE
                        </span>
                    </a>
                </div>
                <div class="sidebar-scrollbar">
                    <ul class="nav sidebar-inner" id="sidebar-menu">
                        <li class="has-sub expand">
                            <a aria-controls="bandeja" aria-expanded="true" class="sidenav-item-link" data-target="#bandeja" data-toggle="collapse" href="javascript:void(0)">
                                <i class="mdi mdi mdi-folder-multiple-outline"></i>
                                <span class="nav-text">Bandeja</span>
                                <b class="caret"></b>
                            </a>
                            <ul class="collapse show" data-parent="#sidebar-menu" id="bandeja" style="">
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="http://173.212.194.231/fe/bandeja/receptor">
                                                        <span class="nav-text">
                                                            Receptor                                                        </span>
                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
                <hr class="separator"/>
                <div class="sidebar-footer">
                    <div class="sidebar-footer-content">

                    </div>
                </div>
            </div>
        </aside>  