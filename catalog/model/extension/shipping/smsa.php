<?php 

class ModelExtensionShippingSmsa extends Model {
    public function getQuote($address){
        $this->load->language('shipping/smsa');
        //var_dump($this->cart->getSubtotal());
        if($this->config->get('free_status') == '1' && $this->cart->getSubtotal() >= $this->config->get('free_total')){
            return array();
        }else{
            $quote_data['smsa'] = array(
    			'code'         => 'smsa.smsa',
    			'title'        => $this->language->get('text_description'),
    			'cost'         => $this->config->get('smsa_rate'),
    			'tax_class_id' => '',
    			'text'         => $this->currency->format($this->tax->calculate($this->config->get('smsa_rate'), '', false), $this->session->data['currency'])
    		);
            
            $method_data = array(
    			'code'       => 'smsa',
    			'title'      => $this->language->get('text_title'),
    			'quote'      => $quote_data,
    			'sort_order' => $this->config->get('smsa_sort_order'),
    			'error'      => false
    		);
            
            return $method_data;
        }
    }
}