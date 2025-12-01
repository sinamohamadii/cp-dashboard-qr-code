<form class="form" action="<?php echo url('static_qrcode.php?type=phone'); ?>" method="post" id="static_form" enctype="multipart/form-data">
    <?php include BASE_PATH.'/forms/qrcode_options.php'; ?>
    
    <!-- Phone Fields -->
    <div class="row mb-4">
        <div class="col-6 col-md-3">
            <div class="form-group">
                <label>Country Code<span class="text-danger">*</span></label>
                <select name="country_code" class="form-control">
                    <?php include BASE_PATH . '/forms/static/country-code.html'; ?> 
                </select>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="form-group">
                <label>Phone Number<span class="text-danger">*</span></label>
                <input type="text" name="phone_number" value="" placeholder="" class="form-control">
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