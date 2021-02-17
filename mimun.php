<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Max-Age: 86400');
  header('Access-Control-Allow-Headers: Origin,Accept,X-Requested-With,Content-Type,Access-Control-Request-Method,Access-Control-Request-Headers,Authorization');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header("Content-type:text/html;charset=utf-8");
  
  $ch = curl_init();//curl 초기화
  curl_setopt($ch, CURLOPT_URL, 'http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc/getCtprvnMesureLIst?serviceKey=bqe2eZbyRVgn4WUOJVUwtct8lxVxy%2B%2BaDAW3bywvmgTHVKaztYZz5qBJQcQOe%2BQVj%2FuuvbPCMHDh6Yz5ZFYlRw%3D%3D&numOfRows=1&pageNo=1&itemCode=PM10&dataGubun=HOUR&searchCondition=MONTH');//URL 지정
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//요청결과 문자열로 반환
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);//요청 타임아웃
  //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//원격 서버의 인증서가 유효한지 검사 안함
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST data
  //curl_setopt($ch, CURLOPT_POST, true);//true시 post 전송

  $response = curl_exec($ch);
  $errno = curl_errno($ch);

  $fileContents = str_replace(array("\n", "\r", "\t"), '', $response);
  $fileContents = trim(str_replace('"', "'", $fileContents));
  $simpleXml = simplexml_load_string($fileContents);
  $json = json_encode($simpleXml);
  echo $json;
?>
