
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo url('index.php'); ?>" class="brand-link">
      <img src="<?php echo asset_url('dist/img/Symbol_WhiteBlue.png'); ?>" alt="Logo" class="brand-image"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Qrcode Generator</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
           <a href="<?php echo url('index.php'); ?>" <?php echo ((substr(CURRENT_PAGE, 0, 9) == 'index.php')) ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li>
          <li <?php echo ((substr(CURRENT_PAGE, 0, 19) == 'dynamic_qrcodes.php') || (substr(CURRENT_PAGE, 0, 18) == 'dynamic_qrcode.php')) ? ' class="nav-item has-treeview menu-open"' : ' class="nav-item has-treeview"'; ?>>
            <a href="#" <?php echo ((substr(CURRENT_PAGE, 0, 19) == 'dynamic_qrcodes.php') || (substr(CURRENT_PAGE, 0, 18) == 'dynamic_qrcode.php')) ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
              <i class="nav-icon fa fa-qrcode"></i>
              <p>
                Dynamic Qr codes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo url('dynamic_qrcodes.php'); ?>" <?php echo ((substr(CURRENT_PAGE, 0, 19) == 'dynamic_qrcodes.php')) ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
                  <i class="far fa-circle nav-icon"></i>
                  <p>List all</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo url('dynamic_qrcode.php'); ?>" <?php echo (CURRENT_PAGE == 'dynamic_qrcode.php') ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add new</p>
                </a>
              </li>
            </ul>
          </li>
            <li <?php echo ((substr(CURRENT_PAGE, 0, 18) == 'static_qrcodes.php') || (substr(CURRENT_PAGE, 0, 17) == 'static_qrcode.php')) ? ' class="nav-item has-treeview menu-open"' : ' class="nav-item has-treeview"'; ?>>
                <a href="#" <?php echo ((substr(CURRENT_PAGE, 0, 18) == 'static_qrcodes.php') || (substr(CURRENT_PAGE, 0, 17) == 'static_qrcode.php')) ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
                    <i class="nav-icon fa fa-qrcode"></i>
                    <p>
                        Static Qr codes
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo url('static_qrcodes.php'); ?>" <?php echo ((substr(CURRENT_PAGE, 0, 18) == 'static_qrcodes.php')) ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
                            <i class="far fa-circle nav-icon"></i>
                            <p>List all</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo url('static_qrcode.php'); ?>" <?php echo (CURRENT_PAGE == 'static_qrcode.php') ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add new</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
