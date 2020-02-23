<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-code"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SNET Admin</div>
  </a>

  <?php
  $role_id = $this->session->userdata('role_id');

  $queryMenu = "SELECT `user_menu`.`id`,`menu`
                FROM `user_menu` JOIN `user_access_menu` 
                  ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                WHERE `user_access_menu`.`role_id`= $role_id
                ORDER BY `user_access_menu`.`menu_id` ASC
              ";
  $menus = $this->db->query($queryMenu)->result_array();
  ?>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Looping Menu -->
  <?php foreach ($menus as $menu) : ?>
    <div class="sidebar-heading">
      <?= $menu['menu']; ?>
    </div>

    <?php
      $menuID = $menu['id'];
      $querySubMenu = "SELECT * FROM `user_submenu`
                     WHERE `menu_id` = $menuID
                     AND `is_active` = 1
                    ";
      $subMenus = $this->db->query($querySubMenu)->result_array();
      ?>

    <!-- Nav Item - Dashboard -->
    <?php foreach ($subMenus as $subMenu) : ?>
      <!-- cek menu yang aktif -->
      <li class="nav-item <?= ($title == $subMenu['title']) ? 'active' : '' ?>">
        <a class="nav-link pb-0" href="<?= base_url($subMenu['url']); ?>">
          <i class="<?= $subMenu['icon']; ?>"></i>
          <span><?= $subMenu['title']; ?></span></a>
      </li>
    <?php endforeach; ?>

    <!-- Divider -->
    <hr class="sidebar-divider mt-3">

  <?php endforeach; ?>

  <!-- Nav Item - Logout -->
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-fw fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->