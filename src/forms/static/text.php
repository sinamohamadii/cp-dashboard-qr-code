<form class="form" action="<?php echo url('static_qrcode.php?type=text'); ?>" method="post" id="static_form" enctype="multipart/form-data">
    <?php include BASE_PATH.'/forms/qrcode_options.php'; ?>
    
    <!-- Text Input -->
    <div class="row mb-4">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>Text<span class="text-danger">*</span></label>
                <textarea class="form-control" name="text" rows="5" placeholder=""></textarea>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 d-flex" style="gap: 12px;">
            <a href="<?php echo url('static_qrcodes.php'); ?>" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>    
    </div>
</form>