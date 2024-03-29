<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
  <div class="sidebar-brand-icon">
    <i class="fas fa-chess-rook"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Admin Page</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Query dari Menu -->
<?php 
  $role_id = $this->session->userdata('role_id');
  $queryMenu = "SELECT user_menu.id, nama 
                FROM  user_menu 
                JOIN user_access_menu 
                ON user_menu.id=user_access_menu.menu_id 
                WHERE user_access_menu.role_id=$role_id
                ORDER BY user_menu.id, user_menu.urutan ASC";
  $menu = $this->db->query($queryMenu)->result_array();
?>
<!-- Looping Menu -->
<?php foreach($menu as $m): ?>
<div class="sidebar-heading">
    <?php echo $m['nama']; ?>
</div>
  <!-- Sub MEnu -->
  <?php 
      $menuId = $m['id'];
      $querySubMenu = "SELECT * 
                        FROM  user_sub_menu 
                        WHERE menu_id=$menuId AND
                        is_active = 1
                        ORDER BY menu_id, urutan ASC";
      $submenu = $this->db->query($querySubMenu)->result_array();
  ?>
  <?php foreach($submenu as $sm): ?>
  <?php if($sm['is_parent']==''){?>
    <!-- Nav Item - Dashboard -->
    <?php if($title == $sm['title']): ?>
      <li class="nav-item active">
    <?php else: ?>
      <li class="nav-item">
    <?php endif; ?>
    
      <a class="nav-link pb-0" href="<?php echo base_url($sm['url']); ?>">
        <i class="<?php echo $sm['icon']?>"></i>
        <span><?php echo $sm['title']?></span></a>
    </li>
  <?php }else{ 
    $collapseid = 'collapse'.$sm['id'];  
  ?>
    <?php if($title == $sm['title']): ?>
      <li class="nav-item active">
    <?php else: ?>
      <li class="nav-item">
    <?php endif; ?>
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?php echo $collapseid; ?>" aria-expanded="true" aria-controls="<?php echo $collapseid; ?>">
      <i class="<?php echo $sm['icon']?>"></i>
      <span><?php echo $sm['title']?></span>
    </a>
    <div id="<?php echo $collapseid; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        
        <?php 
            $sub_menu_id = $sm['id'];
            $querySubSubMenu = "SELECT * 
                              FROM  user_sub_sub_menu 
                              WHERE sub_menu_id=$sub_menu_id AND
                              is_active = 1
                              ORDER BY urutan ASC";
            $subsubmenu = $this->db->query($querySubSubMenu)->result_array();
        ?>
        <?php foreach($subsubmenu as $ssm): ?>
        <a class="collapse-item" href="<?php echo base_url($ssm['url']); ?>"><?php echo $ssm['title']?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </li>
  <?php } ?>
  <?php endforeach; ?>
 <!-- Divider -->
 <hr class="sidebar-divider mt-3">
<?php endforeach; ?>


 <!-- Nav Item - Charts -->
<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url('auth/logout'); ?>">
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