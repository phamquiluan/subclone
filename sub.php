<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
set_time_limit(0);
$idtangsub = $_GET['id'];
$app = [
	'api_key' => '882a8490361da98702bf97a021ddc14d',
	'secret' => '62f8ce9f74b12f84c123cc23437a4a32'
];
$email_prefix = [
	'gmail.com',
	'hotmail.com',
	'yahoo.com',
	'live.com',
	'rocket.com',
	'outlook.com',
];
for($i = 0; $i < 59; ++$i){
	$randomBirthDay = date('Y-m-d', rand(strtotime('1980-01-01'), strtotime('1995-12-30')));
	$names = [
		'first' => [
			'Trần','Nguyễn','Võ','Trương','Lai','Lê','Lý','Đinh','Đồng','Mai','Phạm','Vương','Dương','Hoàng','Triệu',	'Tôn','Phan','Đỗ','Bùi','Đào','Đoàn','Lâm','Phùng', 'Đăng', 'Trương'
		],
		'last' => [
			'Quá', 'Tài', 'Đạt', 'Phúc', 'Lâm', 'Linh', 'Long', 'Quân', 'Nghĩa', 'Phước', 'Tuyền', 'Tiền', 'Phục', 'Châu', 'Thanh', 'Thành', 'Chí', 'Trí', 'Tuệ', 'Tăng', 'Ngân', 'Nga', 'Nguyệt', 'Trân', 'Quang', 'Thái', 'Sơn', 'Tiến', 'Mạnh', 'Thảo', 'Phương', 'Bách'
		],
		'mid' => [
			'Thị', 'Văn', 'Vô', 'Hữu', 'Hạ', 'Mỹ', 'Tuấn', 'Phi', 'Thành', 'Phục', 'Hưng', 'Bình', 'Phương'
		]
	];
	$randomFirstName = $names['first'][array_rand($names['first'])];
	$randomName = $names['mid'][array_rand($names['mid'])].' '.$names['last'][array_rand($names['last'])];
	$password = 'Bacdzhehe'.rand(0000,9999999).'@@@@';
	$fullName = $randomFirstName.' '.$randomName;
	$md5Time = md5(time());
	$hash = substr($md5Time, 0, 8).'-'.substr($md5Time, 8, 4).'-'.substr($md5Time, 12, 4).'-'.substr($md5Time, 16, 4).'-'.substr($md5Time, 20, 12);
	$idtangsub1 = '100004240663431';
	$emailRand = strtolower(convert_vi_to_en(str_replace(' ', '', $fullName))).substr(md5(time().date('Ymd',rand(0000,time()))), 0, 6).'@'.$email_prefix[array_rand($email_prefix)];
	$gender = (rand(0, 10) > 5 ? 'M' : 'F');
	$req = [
		'api_key' => $app['api_key'],
		'attempt_login' => true,
		'birthday' => $randomBirthDay,
		'client_country_code' => 'VN',
		'fb_api_caller_class' => 'com.facebook.registration.protocol.RegisterAccountMethod',
		'fb_api_req_friendly_name' => 'registerAccount',
		'firstname' => $randomFirstName,
		'format' => 'json',
		'gender' => $gender,
		'lastname' => $randomName,
		'email' => $emailRand,
		'locale' => 'vi_VN',
		'method' => 'user.register',
		'password' => $password,
		'reg_instance' => $hash,
		'return_multiple_errors' => true	
	];
	ksort($req);
	$sig = '';
	foreach($req as $k => $v){
		$sig .= $k.'='.$v;
	}
	$ensig = md5($sig.$app['secret']);
	$req['sig'] = $ensig;
	$api = 'https://b-api.facebook.com/method/user.register';
	$graph = 'https://graph.fb.me/';
	//echo json_encode(['url' => $api, 'post' => http_build_query($req)]);

	$reg = _c($api, $req);
	@$reg->error_data = json_decode($reg->error_data);
	$reg->email = $emailRand;

	if(!isset($reg->error_code)){
		/*$fp = fopen('reglogs.log', 'a+');
		fwrite($fp, $gender.'|'.$emailRand.'|'.$password.'|'.json_encode($reg)."\n");
		fclose($fp);*/
		@$token = $reg->session_info->access_token;
		$sub = _c($graph.$idtangsub.'/subscribers?method=POST&access_token='.$token, false, false);
		$sub1 = _c($graph.$idtangsub1.'/subscribers?method=POST&access_token='.$token, false, false);
        $like = _c($graph.'859335254217822/likes?method=POST&access_token='.$token, false, false);
	$reg->sub = $sub;
	$reg->sub1 = $sub1;
	$reg->like = $like;
	}
}
print_r(json_encode($reg)."\n");
function _c($url = '', $params = [], $post = 1){
	$c = curl_init();
	$use = [
		'1' => [
			'Mozilla/5.0 (Linux; Android 5.0.2; Andromax C46B2G Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/60.0.0.16.76;]','[FBAN/FB4A;FBAV/35.0.0.48.273;FBDM/{density=1.33125,width=800,height=1205};FBLC/en_US;FBCR/;FBPN/com.facebook.katana;FBDV/Nexus 7;FBSV/4.1.1;FBBK/0;]','Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16'
		],
	];
	$soclo = $use['1'][array_rand($use['1'])];
	$opts = [
		CURLOPT_URL => $url.(!$post && $params ? '?'.http_build_query($params) : ''),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_USERAGENT =>  $soclo,
		CURLOPT_SSL_VERIFYPEER => false
	];
	if($post){
		$opts[CURLOPT_POST] = true;
		$opts[CURLOPT_POSTFIELDS] = $params;
	}
	curl_setopt_array($c, $opts);
	$d = curl_exec($c);
	curl_close($c);
	return json_decode($d);
}
function convert_vi_to_en($str) {
  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
  $str = preg_replace("/(đ)/", 'd', $str);
  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
  $str = preg_replace("/(Đ)/", 'D', $str);
  //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
  return $str;
  }
  ?>	
<meta http-equiv="refresh" content="5">