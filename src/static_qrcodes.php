<?php
session_start();

// Payload Authentication Guard
require_once './includes/payload_guard.php';
require_once BASE_PATH . '/lib/StaticQrcode/StaticQrcode.php';

$db = getDbInstance();
$static_qrcode = new StaticQrcode();

$select = array('id', 'filename', 'type', 'content', 'qrcode', 'created_at', 'updated_at');
$search_fields = array('filename', 'type', 'content');
require_once BASE_PATH . '/includes/search_order.php';
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;
$db->pageLimit = 15;

$rows = $db->arraybuilder()->paginate('static_qrcodes', $page, $select);
$total_pages = $db->totalPages;
?>


<!DOCTYPE html>
<html lang="en">
    <title>Qrcode Generator</title>
    <head>
    <?php include './includes/head.php'; ?>
    </head>
<body class="caesar-layout">
    <!-- Caesar Sidebar -->
    <?php include './includes/sidebar.php'; ?>
    
<div class="wrapper">
    <!-- Caesar Header -->
    <?php include './includes/navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-fluid py-4">
      
      <!-- Flash message-->
      <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
      <!-- /.Flash message-->
      
      <!-- QR List Card -->
      <div class="qr-list-card">
        <!-- Header with filters and add button -->
        <div class="qr-list-header">
          <!-- Filters (left side) -->
          <?php $options = $static_qrcode->setOrderingValues(); ?>
          <form action="" class="qr-list-filters">
            <input type="text" class="search-input" placeholder="Search" name="search_str" value="<?php echo htmlspecialchars($search_str??'', ENT_QUOTES, 'UTF-8'); ?>">
            <select name="order_by" class="filter-select">
              <?php foreach ($options as $opt_value => $opt_name):
                $selected = ($order_by === $opt_value) ? 'selected' : '';
                echo '<option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
              endforeach; ?>
            </select>
            <select name="order_dir" class="filter-select">
              <option value="Asc" <?php if ($order_dir == 'Asc') echo 'selected'; ?>>Asc</option>
              <option value="Desc" <?php if ($order_dir == 'Desc') echo 'selected'; ?>>Desc</option>
            </select>
            <button type="submit" class="btn-go">Go</button>
          </form>
          
          <!-- Add New button (right side) -->
          <a href="<?php echo url('static_qrcode.php'); ?>" class="btn-add-new">
            <i class="fa fa-plus"></i> Add New
          </a>
        </div>
        
        <!-- Table -->
        <?php include BASE_PATH . '/forms/table_static.php'; ?>
      </div>
      <!-- /.QR List Card -->
      
    </div><!-- /.container-fluid -->
  </div><!-- /.content-wrapper -->

    <!-- Footer and scripts -->
    <?php include './includes/footer.php'; ?>
    <!-- /.Footer and scripts -->
</body>
</html>
