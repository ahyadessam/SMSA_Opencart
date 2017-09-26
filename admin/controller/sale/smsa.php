<?php 

class ControllerSaleSmsa extends Controller {
    public $_apiUrl = "http://track.smsaexpress.com/SECOM/SMSAwebService.asmx";
    
    public function index(){
        
    }
    
    public function create(){
        $this->language->load('sale/smsa');
        $this->load->model('sale/order');
		$this->load->model('sale/smsa');
        
        $this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		
		$order_info = $this->model_sale_order->getOrder($order_id);
        
        if($order_info){
            $data['order'] = $order_info;
            
            if($order_info['shipping_code'] != 'smsa.smsa'){
                $data['error_warning'] = $this->language->get('not_smsa');
            }
            
            if($this->model_sale_smsa->checkShipping($order_id)){
                $data['shipped'] = $this->language->get('txt_shipped');
                $data['awd']        = $order_info['shipping_custom_field']['awd'];
            }
            
            //check SMSA configuration
            $status = $this->config->get('smsa_status');
            $passkey = $this->config->get('smsa_passkey');
            $smsa_sName = $this->config->get('smsa_sName');
            $smsa_sContact = $this->config->get('smsa_sContact');
            $smsa_sAddr = $this->config->get('smsa_sAddr');
            $smsa_sCity = $this->config->get('smsa_sCity');
            $smsa_sPhone = $this->config->get('smsa_sPhone');
            $smsa_sCntry = $this->config->get('smsa_sCntry');
            
            
            if($status == 0 || empty($passkey) || empty($smsa_sName) || empty($smsa_sContact) || 
            empty($smsa_sAddr) || empty($smsa_sCity) || empty($smsa_sPhone) || empty($smsa_sCntry)){
                $data['not_found'] = $this->language->get('smsa_settings');
            }else{
                $order_products = $this->model_sale_order->getOrderProducts($order_id);                
                $data['products'] = $order_products;
                //shipping
                if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['do_shipping']){
                    $order_num = time();
                    
                    $variables = array(
                        'passKey'       => $passkey,
                        'refNo'         => $order_num,
                        'sentDate'      => date('Y/m/d'),
                        'idNo'          => $order_id,
                        'cName'         => $order_info['shipping_firstname'].' '.$order_info['shipping_lastname'],
                        'cntry'         => 'KSA',
                        'cCity'         => 'Riyadh',
                        'cZip'          => '',
                        'cPOBox'        => '',
                        'cMobile'       => $order_info['telephone'],
                        'cTel1'         => '',
                        'cTel2'         => '',
                        'cAddr1'        => $order_info['shipping_address_1'],
                        'cAddr2'        => $order_info['shipping_address_2'],
                        'shipType'      => 'DLV',
                        'PCs'           => count($order_products),
                        'cEmail'        => $order_info['email'],
                        'carrValue'     => '',
                        'carrCurr'      => '',
                        'codAmt'        => $order_info['total'],
                        'weight'        => '1',
                        'custVal'       => '',
                        'custCurr'      => '',
                        'insrAmt'       => '',
                        'insrCurr'      => '',
                        'itemDesc'      => '',
                        'sName'         => $smsa_sName,
                        'sContact'      => $smsa_sContact,
                        'sAddr1'        => $smsa_sAddr,
                        'sAddr2'        => '',
                        'sCity'         => $smsa_sCity,
                        'sPhone'        => $smsa_sPhone,
                        'sCntry'        => $smsa_sCntry,
                        'prefDelvDate'  => '',
                        'gpsPoints'     => ''
                    );
                    
                    $xml = $this->createXml('http://track.smsaexpress.com/secom/addShip', 'addShip', $variables);
                    $result = $this->send($xml);
                    $order_status = $result['soapBody']['addShipResponse']['addShipResult'];
                    
                    if(is_numeric($order_status)){
                        $data['awd']        = $order_status;
                        $shipmenthistory = "SMSA AWB No. ".$order_status." - Order No. ".$order_num;
						if(isset($this->request->post['send_mail']) && $this->request->post['send_mail'] == 'yes')
						{
								$is_email = 1;
						}else{
								$is_email = 0;
						}
                        
						$message = array(
							'notify' => $is_email,
							'comment' => $shipmenthistory
						);
						$this->model_sale_smsa->addOrderHistory($order_id, $message, $order_status);
                        
                        $data['success'] = $this->language->get('txt_success').' : '.$order_status;
                    }else{
                        $data['error_warning'] = $order_status;
                    }
                }
            }
            
            $variables = array(
                'awbNo'     => '290009959909',
                'passkey'   => ''
            );
            
            
            
            //$data = $this->createXml('http://track.smsaexpress.com/secom/getTracking', 'getTracking', $variables);
                    //$result = $this->send($data);
//var_dump($result['soapBody']['getTrackingResponse']['getTrackingResult']['diffgrdiffgram']['NewDataSet']['Tracking']);
        }else{
            $data['not_found'] = $this->language->get('not_found');
        }
        
        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        
        $data['text_shipping']  = $this->language->get('text_shipping');
        $data['heading_title']  = $this->language->get('heading_title');
        $data['order_details']  = $this->language->get('order_details');
        $data['name']           = $this->language->get('text_name');
        $data['address']        = $this->language->get('text_address');
        $data['phone']          = $this->language->get('text_phone');
        $data['send_to_client'] = $this->language->get('send_to_client');
        $data['mail']           = $this->language->get('text_email');
        $data['cancel_shipping']= $this->language->get('cancel_shipping');
        $data['cancel_confirm'] = $this->language->get('cancel_confirm');
        
        $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_orders'),
			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
        
        $this->response->setOutput($this->load->view('sale/smsa_shipping', $data));
    }
    
    public function cancel(){
        $this->load->model('sale/smsa');
        $this->language->load('sale/smsa');
        
        $awb = $this->request->get['awb'];
        if(empty($awb)){
            $data['error'] = $this->language->get('general_error');
        }
        $variables = array(
            'awbNo'     => $awb,
            'passkey'   => $this->config->get('smsa_passkey'),
            'reas'      => 'Order not completed'
        );
        
        $data = $this->createXml('http://track.smsaexpress.com/secom/cancelShipment', 'cancelShipment', $variables);
        $result = $this->send($data);
        
        $data['success'] = $result['soapBody']['cancelShipmentResponse']['cancelShipmentResult'];
        $this->model_sale_smsa->addCancelHistory($this->request->get['order_id'], 'Cancel shipping to SMSA');
        
        $this->document->setTitle($this->language->get('heading_title'));
        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        
        $data['text_shipping']  = $this->language->get('text_shipping');
        $data['heading_title']  = $this->language->get('heading_title');
        
        $this->response->setOutput($this->load->view('sale/smsa_cancel', $data));
    }
    
    public function createXml($SOAPAction, $method, $variables){
        $xmlcontent = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <'.$method.' xmlns="http://track.smsaexpress.com/secom/">';
                  if(count($variables)){
                    foreach($variables As $key=>$val){
                        $xmlcontent .= '<'.$key.'>'.$val.'</'.$key.'>';
                    }
                  }
        $xmlcontent .= '</'.$method.'>
              </soap:Body>
            </soap:Envelope>';
            
        $headers = array(
            "POST /SECOM/SMSAwebService.asmx HTTP/1.1",
            "Host: track.smsaexpress.com",
            "Content-Type: text/xml; charset=utf-8",
            "Content-Length: ".strlen($xmlcontent),
            "SOAPAction: ".$SOAPAction
        );
        
        return array(
            'xml'       => $xmlcontent,
            'header'    => $headers
        );
    }
    
    public function send(array $data){
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data['header']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_URL, $this->_apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data['xml']);
        $content=curl_exec($ch);
        
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $content);
        $xml = new SimpleXMLElement($response);
        $array = json_decode(json_encode((array)$xml), TRUE);
        return $array;
    }
}