<form class="form" action="<?php echo url('static_qrcode.php?type=skype'); ?>" method="post" id="static_form" enctype="multipart/form-data">
    <?php include BASE_PATH.'/forms/qrcode_options.php'; ?>
<!-- Input forms -->
    <div class="col-sm-4">
        <div class="form-group">
            <label>Skype username *</label>
            <input type="text" name="skype_username" value="" placeholder="" class="form-control">
        </div>
    </div>
    
<div class="row mt-4">
    <div class="col-12 d-flex" style="gap: 12px;">
        <a href="<?php echo url('static_qrcodes.php'); ?>" class="btn-cancel">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>    
</div>
                
</form>