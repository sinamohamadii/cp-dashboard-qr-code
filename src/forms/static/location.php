<form class="form" action="<?php echo url('static_qrcode.php?type=location'); ?>" method="post" id="static_form" enctype="multipart/form-data">
    <?php include BASE_PATH.'/forms/qrcode_options.php'; ?>
<!-- Input forms -->
    <div class="col-sm-4">
        <div class="form-group">
            <label>Latitude *</label>
            <input type="text" name="latitude" value="" placeholder="40.7127753" class="form-control">
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="form-group">
            <label>Longitude *</label>
            <input type="text" name="longitude" value="" placeholder="-74.0059728" class="form-control">
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12 d-flex" style="gap: 12px;">
            <a href="<?php echo url('static_qrcodes.php'); ?>" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>    
    </div>
                
</form>