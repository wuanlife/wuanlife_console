<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/class Email extends CI_Controller {
public function __construct()
	{
		parent::__construct();
		$this->load->model('wuan_model');
	}
public function send()
 {
	$this->load->library('Email');
	 $config['protocol'] = 'smtp';
     $config['smtp_host'] = 'smtp.126.com';
     $config['smtp_user'] = 'jyh120@126.com';//这里写上你的163邮箱账户
     $config['smtp_pass'] = 'Jyhlwy5032865';//这里写上你的163邮箱密码
     $config['mailtype'] = 'html';
     $config['validate'] = true;
     $config['priority'] = 1;
     $config['crlf']  = "\r\n";
     $config['smtp_port'] = 25;
     $config['charset'] = 'utf-8';
     $config['wordwrap'] = TRUE;
	
	 $this->email->initialize($config);
	 
	 $this->email->from('jyh120@126.com', 'liagnwenyuan');//发件人
	 $this->email->to('583239353@qq.com');



	 $data = $this->wuan_model->get_username();
	 $d = $data[0]['nickname'];

	//获取登陆用户名

	 $this->email->subject('test email');
	 $this->email->message("$d");
     $this->email->send();
     echo $this->email->print_debugger();
}
}