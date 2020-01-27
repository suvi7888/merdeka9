<?php 
/**
 * 
 */
class Notification 
{
	
	function sending()
	{
		$ci =& get_instance();
		$config['protocol']    	= 'smtp';
		$config['smtp_host']    = 'ssl://smtp.zoho.com';
		$config['smtp_port']    = '465';
		// $config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'lutfi@awanesia.com';
		$config['smtp_pass']    = 'P4vshCIp2FRj';
		$config['charset']    	= 'utf-8';
		$config['newline']    	= "\r\n";
	    $config['mailtype'] 	= 'text'; // or html
	    $config['validation']	= TRUE; // bool whether to validate email or not      

	    $ci->email->initialize($config);

	    try{

	    	$param = array(
	    		'subject' => $ci->input->get('subject'),
	    		'message' => $ci->input->get('message'),
	    		'to' => $ci->input->get('to')
	    	);

	    	if(empty($param)) throw New \Exception('Params not found', 500);

	    	$ci->email->from('noreply@ppid.esdm.go.id', 'PPID ESDM');
	    	$ci->email->to($param['to']);

	    	$ci->email->subject($param['subject']);
	    	$ci->email->message($param['message']);  

	    	$ci->email->send(); 

	    	$status   = 200;
	    	$data     = empty($ci->email->print_debugger()) ? 'Berhasil Kirim' : $ci->email->print_debugger();
	    	$errorMsg = null;
	    }catch(\Exception $e){
	    	$status   = $e->getCode() ? $e->getCode() : 500;;
	    	$data     = null;
	    	$errorMsg = $e->getMessage();
	    }
	    return json_encode(['status' => $status , 'data' => $data , 'message' => $errorMsg]);
	}
}
