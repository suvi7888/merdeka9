<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	
	public function index()
	{
		echo "<i>Sukses! terhubung ke service autentikasi...</i>";
	}
	
	public function login()
	{
		$arr_data = array();
		$post_param = $this->input->post();
		if(count($post_param) > 0)
		{
			$this->db->where('username', $post_param['username']);
			$query = $this->db->get('ppid_pengguna')->result();
			if(count($query) > 0)
			{
				if($query[0]->password === $post_param['password'])
				{
					$arr_data['msg'] = 'Data Ditemukan';
					$arr_data['data'] = $query;
				}
				else if($query[0]->password !== $post_param['password'])
				{
					$arr_data['msg'] = 'Password Salah';
					$arr_data['data'] = array();
				}
			}
			else
			{
				$arr_data['msg'] = 'Username Tidak Ada';
				$arr_data['data'] = array();
			}
		}
		else
		{
			$arr_data['msg'] = 'Parameter Tidak Terkirim';
			$arr_data['data'] = array();
		}
		
		// print response
		echo json_encode($arr_data);
	}


	public function lupa_password()
	{
		if ($this->input->post()) {
			$email = $this->input->post('email');

			## cek apakah user tsb ada email nya gak 
			$cek_email = $this->db->select('email,username,nama')->from('ppid_pengguna')->where('email',$email)->get()->row_array();

			if (isset($cek_email)) {

				### update password , 
				$ubah_password_data = array('password' => '12345678');
				$this->db->where('email', $cek_email['email']);
				$rubah = $this->db->update('ppid_pengguna', $ubah_password_data);
				## kirim email langsung password baru 
				$kepada = $cek_email['email'];
				$judul = 'Lupa Password PPID Online';
				$isi = '<p>Yang Terhormat, <b>'.$cek_email['nama'].'</b></p>
				<p>Terima kasih telah melakukan permohonan lupa password diaplikasi kami</p>
				<p>Berikut adalah password baru kamu : <b>12345678</b></p>
				<br/>
				<br/>

				Salam Keterbukaan Informasi Publik,<br>
				Admin Aplikasi PPID Kementerian ESDM
				';
				$headers_ss  = 'MIME-Version: 1.0' . "\r\n";
				$headers_ss .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers_ss .= 'From: PPID ESDM <noreply@ppid.esdm.go.id>' . "\r\n";
				$send_email = mail($kepada, $judul, $isi, $headers_ss);

				### end

				$arr_data['msg'] = 'Berhasil mengubah password';
				$arr_data['data'] = array();

			} else {
				$arr_data['msg'] = 'Email tidak ditemukan';
				$arr_data['data'] = array();
			}

		} else {
			$arr_data['msg'] = 'Parameter salah';
			$arr_data['data'] = array();
		}
		echo json_encode($arr_data);
	}


	
	public function registration()
	{
		$arr_data = array();
		$get_post = $this->input->post();
		if(count($get_post) > 0)
		{
			$this->db->where('username', $get_post['username']);
			$username = $this->db->get('ppid_pengguna')->result();
			if(count($username) > 0)
			{
				$arr_data['msg'] = 'Username sudah terdaftar, silahkan ketikkan username selain "'.$get_post['username'].'"';
				$arr_data['data'] = array();
			}
			else
			{
				$this->db->where('email', $get_post['email']);
				$email = $this->db->get('ppid_pengguna')->result();
				if(count($email) > 0)
				{
					$arr_data['msg'] = 'Alamat email sudah terdaftar, silahkan ketikkan email selain "'.$get_post['email'].'"';
					$arr_data['data'] = array();
				}
				else
				{
					$sql = "select max(id_pengguna) as id_pengguna from ppid_pengguna";
					$query = $this->db->query($sql);
					$getLastId = $query->row_array();
					$userId = (int)$getLastId['id_pengguna'] + 1;

					$seed = str_split('abcdefghijklmnopqrstuvwxyz'
							.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'); // and any other characters
					shuffle($seed);
					$rand = '';
					foreach (array_rand($seed, 10) as $k){
						$rand .= $seed[$k];
					}
					$kode_aktifasi=$rand;

					
					$data = array(
						'id_pengguna' => @$userId,
						'nama'		=> $get_post['fullname'],
						'username'	=> $get_post['username'],
						'email'		=> $get_post['email'],
						'password'	=> $get_post['password'],
						'activation_code' => $kode_aktifasi,
						'role'		=> 'pemohon'
					);
					$insert = $this->db->insert('ppid_pengguna', $data);
					
					if(@$insert)
					{
						

						$kepada = $get_post['email'];
						$judul = 'Registrasi PPID Online';
						$isi = '<p>Yang Terhormat Pemohon, <b>'.$get_post['fullname'].'</b></p>
						<p>Terima kasih telah melakukan registrasi permohonan informasi publik di PPID Kementerian Energi dan Sumber Daya Mineral (KESDM).</p>
						<p>Berikut informasi username Anda untuk login ke aplikasi:<br>'.$get_post['username'].'</p>
						<p>Silahkan klik link berikut untuk aktivasi akun Anda di Aplikasi PPID KESDM.<br>
						<a href="'.site_url('auth/aktifasi/'.$kode_aktifasi).'" target="_blank">Aktifasi</a>
						</p>
						<br/>
						<br/>

						Salam Keterbukaan Informasi Publik,<br>
						Admin Aplikasi PPID Kementerian ESDM
						';
						$headers_ss  = 'MIME-Version: 1.0' . "\r\n";
						$headers_ss .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers_ss .= 'From: PPID ESDM <noreply@ppid.esdm.go.id>' . "\r\n";
						$send_email = mail($kepada, $judul, $isi, $headers_ss);

						$arr_data['msg'] = 'Berhasil Registrasi, Silahkan periksa email anda untuk aktifasi.';
						$arr_data['data'] = array();
					}
					else
					{
						$arr_data['msg'] = 'Gagal Registrasi, silahkan ulangi kembali';
						$arr_data['data'] = array();
					}
				}
			}
		}
		else
		{
			$arr_data['msg'] = 'Parameter tidak terkirim';
			$arr_data['data'] = array();
		}
		
		// print response
		echo json_encode($arr_data);
	}
	
}
