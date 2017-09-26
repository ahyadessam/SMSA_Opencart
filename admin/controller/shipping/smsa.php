<?php
class ControllerShippingSmsa extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('shipping/smsa');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('shipping/smsa');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('smsa', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');


		############ Personal Information Label ############

		$data['entry_client_information'] = $this->language->get('entry_client_information');
		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');
        $data['entry_passkey'] = $this->language->get('entry_passkey');
        $data['entry_rate'] = $this->language->get('entry_rate');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_order'] = $this->language->get('entry_order');
        
        $data['entry_sName'] = $this->language->get('entry_sName');
        $data['entry_sContact'] = $this->language->get('entry_sContact');
        $data['entry_sAddr'] = $this->language->get('entry_sAddr');
        $data['entry_sCity'] = $this->language->get('entry_sCity');
        $data['entry_sPhone'] = $this->language->get('entry_sPhone');
        $data['entry_sCntry'] = $this->language->get('entry_sCntry');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_username'])) {
			$data['error_username'] = $this->error['error_username'];
		} else {
			$data['error_username'] = '';
		}

		if (isset($this->error['error_password'])) {
			$data['error_password'] = $this->error['error_password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['error_passkey'])) {
			$data['error_passkey'] = $this->error['error_passkey'];
		} else {
			$data['error_passkey'] = '';
		}
        
        if (isset($this->error['error_rate'])) {
			$data['error_rate'] = $this->error['error_rate'];
		} else {
			$data['error_rate'] = '';
		}
        
        if (isset($this->error['error_sName'])) {
			$data['error_sName'] = $this->error['error_sName'];
		} else {
			$data['error_sName'] = '';
		}
        if (isset($this->error['error_sContact'])) {
			$data['error_sContact'] = $this->error['error_sContact'];
		} else {
			$data['error_sContact'] = '';
		}
        if (isset($this->error['error_sAddr'])) {
			$data['error_sAddr'] = $this->error['error_sAddr'];
		} else {
			$data['error_sAddr'] = '';
		}
        if (isset($this->error['error_sCity'])) {
			$data['error_sCity'] = $this->error['error_sCity'];
		} else {
			$data['error_sCity'] = '';
		}
        if (isset($this->error['error_sPhone'])) {
			$data['error_sPhone'] = $this->error['error_sPhone'];
		} else {
			$data['error_sPhone'] = '';
		}
        if (isset($this->error['error_sCntry'])) {
			$data['error_sCntry'] = $this->error['error_sCntry'];
		} else {
			$data['error_sCntry'] = '';
		}

		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/shipping/smsa', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('extension/shipping/smsa', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');



		if (isset($this->request->post['smsa_username'])) {
			$data['smsa_username'] = $this->request->post['smsa_username'];
		} else {
			$data['smsa_username'] = $this->config->get('smsa_username');
		}

		if (isset($this->request->post['smsa_password'])) {
			$data['smsa_password'] = $this->request->post['smsa_password'];
		} else {
			$data['smsa_password'] = $this->config->get('smsa_password');
		}

		if (isset($this->request->post['smsa_passkey'])) {
			$data['smsa_passkey'] = $this->request->post['smsa_passkey'];
		} else {
			$data['smsa_passkey'] = $this->config->get('smsa_passkey');
		}

		if (isset($this->request->post['smsa_rate'])) {
			$data['smsa_rate'] = $this->request->post['smsa_rate'];
		} else {
			$data['smsa_rate'] = $this->config->get('smsa_rate');
		}

		if (isset($this->request->post['smsa_status'])) {
			$data['smsa_status'] = $this->request->post['smsa_status'];
		} else {
			$data['smsa_status'] = $this->config->get('smsa_status');
		}
        
        if (isset($this->request->post['smsa_sort_order'])) {
			$data['smsa_sort_order'] = $this->request->post['smsa_sort_order'];
		} else {
			$data['smsa_sort_order'] = $this->config->get('smsa_sort_order');
		}
        
        if (isset($this->request->post['smsa_sName'])) {
			$data['smsa_sName'] = $this->request->post['smsa_sName'];
		} else {
			$data['smsa_sName'] = $this->config->get('smsa_sName');
		}
        if (isset($this->request->post['smsa_sContact'])) {
			$data['smsa_sContact'] = $this->request->post['smsa_sContact'];
		} else {
			$data['smsa_sContact'] = $this->config->get('smsa_sContact');
		}
        if (isset($this->request->post['smsa_sAddr'])) {
			$data['smsa_sAddr'] = $this->request->post['smsa_sAddr'];
		} else {
			$data['smsa_sAddr'] = $this->config->get('smsa_sAddr');
		}
        if (isset($this->request->post['smsa_sCity'])) {
			$data['smsa_sCity'] = $this->request->post['smsa_sCity'];
		} else {
			$data['smsa_sCity'] = $this->config->get('smsa_sCity');
		}
        if (isset($this->request->post['smsa_sPhone'])) {
			$data['smsa_sPhone'] = $this->request->post['smsa_sPhone'];
		} else {
			$data['smsa_sPhone'] = $this->config->get('smsa_sPhone');
		}
        if (isset($this->request->post['smsa_sCntry'])) {
			$data['smsa_sCntry'] = $this->request->post['smsa_sCntry'];
		} else {
			$data['smsa_sCntry'] = $this->config->get('smsa_sCntry');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        
        if (!$this->user->hasPermission('access', 'shipping/smsa')) {
			$data['error_warning'] = $this->language->get('error_permission');
            $this->response->setOutput($this->load->view('shipping/smsa_perm', $data));
		}else{
            $this->response->setOutput($this->load->view('shipping/smsa', $data));
		}


	}

	protected function validate() {

		if (!$this->user->hasPermission('modify', 'shipping/smsa')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['smsa_username']) {
			$this->error['error_username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['smsa_password']) {
			$this->error['error_password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['smsa_passkey']) {
			$this->error['error_passkey'] = $this->language->get('error_passkey');
		}
        
        if (!$this->request->post['smsa_rate']) {
			$this->error['error_rate'] = $this->language->get('error_rate');
		}
        
        if (!$this->request->post['smsa_sName']) {
			$this->error['error_sName'] = $this->language->get('error_sName');
		}
        if (!$this->request->post['smsa_sContact']) {
			$this->error['error_sContact'] = $this->language->get('error_sContact');
		}
        if (!$this->request->post['smsa_sAddr']) {
			$this->error['error_sAddr'] = $this->language->get('error_sAddr');
		}
        if (!$this->request->post['smsa_sCity']) {
			$this->error['error_sCity'] = $this->language->get('error_sCity');
		}
        if (!$this->request->post['smsa_sPhone']) {
			$this->error['error_sPhone'] = $this->language->get('error_sPhone');
		}
        if (!$this->request->post['smsa_sCntry']) {
			$this->error['error_sCntry'] = $this->language->get('error_sCntry');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
