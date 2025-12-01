<?php
session_start();

// Payload Authentication Guard
require_once './includes/payload_guard.php';
require_once BASE_PATH . '/lib/DynamicQrcode/DynamicQrcode.php';

$dynamic_qrcode_instance = new DynamicQrcode();

$edit = false;
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["edit"]) && $_GET["edit"] == "true" && isset($_GET["id"])) {
    $edit = true;
    $dynamic_qrcode = $dynamic_qrcode_instance->getQrcode($_GET["id"]);
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["del_id"])) {
    $dynamic_qrcode_instance->deleteQrcode($_POST["del_id"]);
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit"])) {
    if(
            isset($_POST["identifier"]) &&
            isset($_POST["filename"]) &&
            isset($_POST["link"]) &&
            isset($_POST["state"]) &&
            isset($_POST["id"])
    )
        $dynamic_qrcode_instance->editQrcode($_POST);
}

if($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST["edit"])) {
    if(
        isset($_POST["foreground"]) &&
        isset($_POST["background"]) &&
        isset($_POST["link"]) &&
        isset($_POST["filename"]) &&
        isset($_POST["format"])
    )
        $dynamic_qrcode_instance->addQrcode($_POST);
}
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
      
      <!-- Flash messages -->
      <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
      <!-- /.Flash messages -->

      <!-- Form Card -->
      <div class="form-card">
        <form class="form" action="" method="post" id="dynamic_form" enctype="multipart/form-data">
          <div class="form-card-body">
            <?php
              if($edit)
                include BASE_PATH.'/forms/form_dynamic_edit.php';
              else
                include BASE_PATH . '/forms/form_dynamic_add.php';
            ?>
          </div>
          <div class="form-card-footer">
            <a href="<?php echo url('dynamic_qrcodes.php'); ?>" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-submit">Save Changes</button>
          </div>
        </form>
      </div>
      
    </div><!--/. container-fluid -->
  </div><!-- /.content-wrapper -->

<!-- Footer and scripts -->
<?php include './includes/footer.php'; ?>

<!-- Page script -->
<script type="text/javascript">
$(document).ready(function(){
   $('#dynamic_form').validate({
       rules: {
            filename: {
                required: true,
            },
            link: {
                required: true,
                minlength: 3
            },   
        }
    });
});
</script>

<script>
    $(function () {

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

    })
</script>
</body>
</html>
