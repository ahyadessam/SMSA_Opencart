<?php
class ModelSaleSmsa extends Model {
	
	public function getOrderStatusId($order_id)
	{
		$query = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order WHERE order_id =".(int)$order_id);
		return $query->row['order_status_id'];
	
	}
    
    public function addOrderHistory($order_id, $data, $awd) {
		$this->load->model('sale/order');
		$order_status_id = $this->getOrderStatusId($order_id);
        
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET shipping_custom_field = '" . json_encode(array('awd' => $awd)) . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($data['notify']) {
			$language = new Language();
			$language->load('sale/smsa');

			$subject = $order_info['store_name'];

			$message  = $language->get('text_order') . ' ' . $order_id . "\n";

			$adminemail = $this->config->get('config_email');
			
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
			$mail->setTo($order_info['email'].','.$adminemail);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($order_info['store_name']);
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}

		//$this->load->model('payment/amazon_checkout');
		//$this->model_payment_amazon_checkout->orderStatusChange($order_id, $data);
		
	}
    
    public function checkShipping($order_id){
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_history` WHERE order_id = '$order_id' AND comment LIKE 'SMSA%'");
        if($query->num_rows)
            return true;
        else
            return false;
    }
    
    public function addCancelHistory($order_id, $comment){
        $order_status_id = $this->getOrderStatusId($order_id);
        $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '0', comment = '" . $comment . "', date_added = NOW()");
    }

}
?>