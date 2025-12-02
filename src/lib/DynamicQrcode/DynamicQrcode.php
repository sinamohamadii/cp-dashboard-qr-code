<?php
require_once 'config/config.php';

if (QRCODE_GENERATOR === "external-api.qrserver.com") {
    require_once BASE_PATH . '/lib/Qrcode/Qrcode.php';
}

if (QRCODE_GENERATOR === "internal-chillerlan.qrcode") {
    require_once BASE_PATH . '/lib/Qrcode/Qrcode-intchil.php';
}


class DynamicQrcode {
    private Qrcode $qrcode_instance;
    /**
     *
     */
    public function __construct() {
        $this->qrcode_instance = new Qrcode("dynamic");
    }

    /**
     *
     */
    public function __destruct() {
    }
    
    /**
     * Set friendly columns names to order tables entries
     * N.B. This function is called to generate the "list all" table
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'filename' => 'File Name',
            'identifier' => 'Identifier',
            'link' => 'Link',
            'qrcode' => 'Qr Code',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];

        return $ordering;
    }

    public function getQrcode($id) {
        return $this->qrcode_instance->getQrcode($id);
    }
    
    /**
     * Add qr code
     * Check out http://goqr.me/api/ for more information
     * We save the file obtained with the chosen name and in the selected folder
     * We save into db the url of qrcode image
     */
    public function addQrcode($input_data) {
        $data_to_db['filename'] = htmlspecialchars($input_data['filename'], ENT_QUOTES, 'UTF-8');
        $data_to_db['created_at'] = date('Y-m-d H:i:s');
        // Don't use htmlspecialchars on URLs - it breaks FILTER_VALIDATE_URL in read.php
        // URLs with & become &amp; which is invalid
        $data_to_db['link'] = filter_var($input_data['link'], FILTER_SANITIZE_URL);
        $data_to_db['format'] = $input_data['format'];
        $data_to_db['identifier'] = randomString(rand(5,8));
        $data_to_db['qrcode'] = $data_to_db['filename'].'.'.$data_to_db['format'];
        $data_to_db['state'] = 'enable'; // Default to enabled so redirect works

        $data_to_qrcode = READ_PATH.$data_to_db['identifier'];
        
        $this->qrcode_instance->addQrcode($input_data, $data_to_db, $data_to_qrcode);
    }
    
    /**
     * Edit qr code
     * 
     */
    public function editQrcode($input_data) {
        $data_to_db['filename'] = htmlspecialchars($input_data['filename'], ENT_QUOTES, 'UTF-8');
        $data_to_db['updated_at'] = date('Y-m-d H:i:s');
        // Don't use htmlspecialchars on URLs - it breaks FILTER_VALIDATE_URL in read.php
        $data_to_db['link'] = filter_var($input_data['link'], FILTER_SANITIZE_URL);
        $data_to_db['state'] = $input_data['state'];

        $this->qrcode_instance->editQrcode($input_data, $data_to_db);
    }

    
    /**
     * Delete qr code
     * 
     */
    public function deleteQrcode($id, $async = false) {
        $this->qrcode_instance->deleteQrcode($id, $async);
    }


    /**
     * Flash message Failure process
     */
    private function failure($message) {
        $_SESSION['failure'] = $message;
        header('Location: ' . url('dynamic_qrcodes.php'));
    	exit();
    }
    
    /**
     * Flash message Success process
     */
    private function success($message) {
        $_SESSION['success'] = $message;
        header('Location: ' . url('dynamic_qrcodes.php'));
    	exit();
    }
    
    /**
     * Flash message Info process
     */
    private function info($message) {
        $_SESSION['info'] = $message;
        header('Location: ' . url('dynamic_qrcodes.php'));
    	exit();
    }

    public function debug($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
        exit();
    }
}
?>
