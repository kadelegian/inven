<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pusat Data Inventaris & Perawatan</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>template/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url() ?>template/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url() ?>template/ionicons-2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url() ?>template/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>template/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url() ?>template/dist/css/skins/_all-skins.min.css">

    <?php
    if (isset($add_css)) {
        foreach ($add_css as $css) {
            ?>
            <link rel="stylesheet" href="<?= base_url('assets/css/' . $css) ?>">
    <?php
        }
    }
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php
        if ($this->ion_auth->logged_in()) {
            ?>
            <header class="main-header">
                <!-- Logo -->
                <a href="<?= site_url() ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><i class="fa fa-tachometer" aria-hidden="true"></i><b>CPANEL</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <?php
                                $user = $this->ion_auth->user()->row();
                                $user_name = $user->first_name . ' ' . $user->last_name;
                                ?>


                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url() ?>template/dist/img/user.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?= $user_name ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url() ?>template/dist/img/user.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            <?= $user_name ?>

                                        </p>
                                    </li>

                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= site_url('auth/edit_user/' . $user->id) ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <?php
                                                echo anchor('auth/logout', 'Sign out', array('class' => 'btn btn-default btn-flat'));
                                                ?>

                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url() ?>template/dist/img/user.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?= $user_name ?></p>

                        </div>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">

                        <?php
                            if ($this->ion_auth->is_admin()) {

                                $menu = $this->db->get_where('menu', array('is_parent' => 0, 'is_active' => 1));
                            } else {

                                $menu = $this->db->get_where('menu', array('is_parent' => 0, 'is_active' => 1, 'is_admin' => 0));
                            }

                            foreach ($menu->result() as $m) {
                                // chek ada sub menu
                                $submenu = $this->db->get_where('menu', array('is_parent' => $m->id, 'is_active' => 1));
                                if ($submenu->num_rows() > 0) {
                                    // tampilkan submenu
                                    echo "<li class='treeview'>
                                    " . anchor('#',  "<i class='$m->icon'></i>" . strtoupper($m->name) . ' <i class="fa fa-angle-left pull-right"></i>') . "
                                        <ul class='treeview-menu'>";
                                    foreach ($submenu->result() as $s) {
                                        echo "<li>" . anchor($s->link, "<i class='$s->icon'></i> <span>" . strtoupper($s->name)) . "</span></li>";
                                    }
                                    echo "</ul>
                                    </li>";
                                } else {
                                    echo "<li>" . anchor($m->link, "<i class='$m->icon'></i> <span>" . strtoupper($m->name)) . "</span></li>";
                                }
                            }
                            ?>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
        <?php } ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <?php
            echo $contents;
            ?>



        </div><!-- /.content-wrapper -->

        <footer class="main-footer no-print">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.3.0
            </div>
            <strong>Copyright &copy; <?= date('Y') ?> <a href="https://mtkbali.com">MTK Bali</a>.</strong> All rights reserved.
        </footer>

        <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url() ?>template/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url() ?>template/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url() ?>template/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>template/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url() ?>template/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url() ?>template/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url() ?>template/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url() ?>template/dist/js/demo.js"></script>
    <!-- page script -->
    <?php if (isset($add_js)) {
        foreach ($add_js as $js) {
            ?>
            <script src="<?= base_url('assets/js/' . $js) ?>"></script>
    <?php
        }
    } ?>
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
</body>

</html>