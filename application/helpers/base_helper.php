<?php 

function is_login() {
	$ci =& get_instance();
	$userid_sess = $ci->session->userdata('user_id');
	if ($userid_sess) {
		$user = $ci->bm->get('tb_users','*', ['user_id' => $userid_sess])->row();
		if ($user->user_role == 'direktur') {
			redirect(site_url('direktur'));	
		} else {
			redirect(site_url('pm'));
		}
	}
}

function is_not_login() {
	$ci =& get_instance();
	$userid_sess = $ci->session->userdata('user_id');
	$login_sess = $ci->session->userdata('login_status');
	if (!$userid_sess && !$login_sess) {
		redirect('login');
	}
}

function user_login() {
	$ci =& get_instance();
	$id = $ci->session->userdata('user_id');
	return $ci->bm->get('tb_users','*',['user_id' => $id])->row();
}

function user_company() {
	$ci =& get_instance();
	$id = $ci->session->userdata('user_id');
	$ci->db->from('tb_users');
	$ci->db->join('tb_company', 'tb_users.ID_company=tb_company.company_id');
	$ci->db->where(['tb_users.user_id' => $id]);
	return $ci->db->get()->row();
}

function is_not_direktur() {
	$ci =& get_instance();
	if (user_login()->user_role == 'pm') {
		redirect(site_url('pm'));
	}
}

function is_not_pm() {
	$ci =& get_instance();
	if (user_login()->user_role == 'direktur') {
		redirect(site_url('direktur'));
	}
}

function slugify($str=NULL) {
	if ($str != NULL) {
		$str = preg_replace("/\s+/", '-', $str);
		$str = preg_replace("/&/", '', $str);
		$str = preg_replace("/[^\w\-]+/", '', $str);
		$str = preg_replace("/\-\-+/", '-', $str);
		$str = strtolower(trim($str, '-'));
	}
	return $str;
}

function randomID($length=10) {
	$ci =& get_instance();
	return $ci->mylibs->_randomID($length);
}

function number_IDN($number) {
	return number_format($number, 0, ',','.');
}

function hourIDN($label='') {
	return ($label) == '' ? date('h:i A', now('Asia/Jakarta')) : $label.' '.date('h:i A', now('Asia/Jakarta'));
}

function dateTimeIDN($datetime, $setDay = FALSE, $setTime = FALSE) {
	$dTimeData = [
		'days'	=> ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
		'months'	=> [
			'01'	=> 'Januari',
			'02'	=> 'Februari',
			'03'	=> 'Maret',
			'04'	=> 'April',
			'05'	=> 'Mei',
			'06'	=> 'Juni',
			'07'	=> 'Juli',
			'08'	=> 'Agustus',
			'09'	=> 'September',
			'10'	=> 'Oktober',
			'11'	=> 'November',
			'12'	=> 'Desember'
		]
	];

	$y = substr($datetime, 0, 4);
	$m = substr($datetime, 5, 2);
	$d = substr($datetime, 8, 2);
	$t = str_replace(':','.', substr($datetime, 11, 5));

	$tId = !$t ? '' : ' | '.$t.' WIB';

	$monthId = $dTimeData['months'][$m];
	$dIdx = date('w', mktime(0,0,0, $m, $d, $y));
	$dayId = $dTimeData['days'][$dIdx];
	
	$output = $setDay != FALSE ? $dayId.', '.$d.' '.$monthId.' '.$y : $d.' '.$monthId.' '.$y;
	$output .= $setTime != FALSE ? $tId : '';

	return $output;
}

function numberIDN($number=0, $prefix=FALSE, $pref_id = 'Rp') {
	if ($prefix == FALSE) {
		$format = number_format($number,0,',','.');
	} else {
		$format = $pref_id == 'Rp' ? $pref_id.'.'.number_format($number,0,',','.') : $pref_id.' '.number_format($number,0,',','.');
	}
	return $format;
}

function getIDCode($prefix = 'USR', $code = '', $digit = 5, $unique = TRUE) {
	$codeID = '';
	if ($unique == TRUE) {
		$codeID = $prefix.$code.random_string('numeric', $digit);
	} else {
		$codeID = $prefix.$code;
	}

	return $codeID;
}