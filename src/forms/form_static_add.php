<fieldset>
    <div class="qr-tabs-card">
            <div class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#text" role="tab"><i class="fas fa-align-left"></i> Text</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#email" role="tab"><i class="far fa-envelope"></i> Email</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#phone" role="tab"><i class="fas fa-phone-volume"></i> Phone</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#sms" role="tab"><i class="far fa-comments"></i> SMS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#whatsapp" role="tab"><i class="fab fa-whatsapp"></i> Whatsapp</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#skype" role="tab"><i class="fab fa-skype"></i> Skype</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#location" role="tab"><i class="fas fa-map-marker-alt"></i> Location</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#vcard" role="tab"><i class="far fa-address-card"></i> Vcard 0.4</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#event" role="tab"><i class="fas fa-calendar-alt"></i> Event</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#bookmark" role="tab"><i class="far fa-bookmark"></i> Bookmark</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#wifi" role="tab"><i class="fas fa-wifi"></i> Wifi</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#paypal" role="tab"><i class="fab fa-paypal"></i> Paypal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#bitcoin" role="tab"><i class="fab fa-bitcoin"></i> Bitcoin</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#twofa" role="tab"><i class="fa fa-key"></i> 2FA</a>
                  </li>
                </ul>
            </div>
              <div class="card-body">
                <div class="tab-content" >
                    <div class="tab-pane fade show active" id="text" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <?php include BASE_PATH . '/forms/static/text.php'; ?>      
                    </div>
                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/email.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="phone" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/phone.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="sms" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/sms.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="whatsapp" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/whatsapp.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="skype" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/skype.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/location.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="vcard" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/vcard.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/event.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="bookmark" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/bookmark.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="wifi" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/wifi.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/paypal.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="bitcoin" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/bitcoin.php'; ?>  
                    </div>
                    <div class="tab-pane fade" id="twofa" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/forms/static/2fa.php'; ?>  
                    </div>
                </div>
              </div>
    </div><!-- /.qr-tabs-card -->
</fieldset>