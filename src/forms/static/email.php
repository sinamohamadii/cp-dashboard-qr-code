<form class="form" action="<?php echo url('static_qrcode.php?type=email'); ?>" method="post" id="static_form" enctype="multipart/form-data">
    <?php include BASE_PATH.'/forms/qrcode_options.php'; ?>
    
    <!-- Email Fields -->
    <div class="row mb-4">
        <div class="col-6 col-md-3">
            <div class="form-group">
                <label>Send to<span class="text-danger">*</span></label>
                <input type="email" name="email" value="" placeholder="Email" class="form-control">
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" value="" placeholder="" class="form-control">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>Message<span class="text-danger">*</span></label>
                <textarea class="form-control" name="message" rows="5" placeholder=""></textarea>
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