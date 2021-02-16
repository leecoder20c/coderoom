<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Max-Age: 86400');
  header('Access-Control-Allow-Headers: x-requested-with');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header("Content-type:text/html;charset=utf-8");
?>

<!DOCTYPE html>
<html lang="ko"dir="ltr" class="weather-app">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">

  <!--SEO-->
  <meta name="Author" content="#LeeSeungJu#LeeCoder">
  <meta name="robots" content="noidex, nofollow">
  <meta name="googlebot" content="noindex"/>
  <meta name="description" content="Web-Publisher Note">
  <meta name="format-detection" content="telephone=no"> <!-- 아이폰 number 버그 개선 -->
  <link rel="image_src" href="./lib/images/seo/logo.png" />
  <link rel="icon" href="./lib/images/seo/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon-precomposed" href="./lib/images/seo/logo.png" />
  <title>LeeCoder's Note | Weather</title>

  <!--스크립트 CDN 및 플러그인-->
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/16327/gsap-latest-beta.min.js"></script>

  <!-- 크로스브라우징-->
  <!--[if lt IE 9]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <script src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <link rel="stylesheet" href="./lib/css/ie9.css" />
  <![endif]-->


  <!--스타일시트-->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Noto+Serif+KR:wght@300&family=Potta+One&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://leecoder20c.github.io/coderoom/lib/css/base.css" /> -->
  <link rel="stylesheet" href="./lib/css/base.css" />
  <script>
    function getTime(data) {
      var now = new Date();
      var hours = ("0" + (now.getHours())).slice(-2);//시
      var minutes = ("0" + (now.getMinutes())).slice(-2);//분
      var seconds = ("0" + (now.getSeconds())).slice(-2);//초
      var milliseconds = now.getMilliseconds(); //밀리초
      var localeDate = now.toLocaleDateString(); //yyyy.m.d
      var localeTime = now.toLocaleTimeString(); //오전+시간+분+초
      var month = now.getMonth();//월
      var day = now.getDay();//일
      switch(month) {
        case 0: month = "Jan"; break;
        case 1: month = "Feb"; break;
        case 2: month = "Mar"; break;
        case 3: month = "Apr"; break;
        case 4: month = "May"; break;
        case 5: month = "Jun"; break;
        case 6: month = "Jul"; break;
        case 7: month = "Aug"; break;
        case 8: month = "Sep"; break;
        case 9: month = "Oct"; break;
        case 10: month = "Nov"; break;
        case 11: month = "Dec"; break;
      }
      switch(day) {
        case 1: day = "월"; break;
        case 2: day = "화"; break;
        case 3: day = "수"; break;
        case 4: day = "목"; break;
        case 5: day = "금"; break;
        case 6: day = "토"; break;
        case 7: day = "일"; break;
      }
      var date = now.getDate();//일
      var day = now.getDay();//요일
      if (data == "hm") return hours + ':' + minutes;
      else if (data == "hms") return hours + ':' + minutes + ':' + seconds;
      else if (data == "hmsm") return hours + ':' + minutes + ':' + seconds + ':' + milliseconds;
      else if (data == "time") return localeTime;//ex. 오전 11:27:17
      else if (data == "date") return localeDate;//ex. 2021. 2. 5.
      else if (data == "md") return month+'. '+date;//ex. Jan.1
      else if (data == "d") return day;//ex. 월,화,수,목,금,토,일
    }
  </script>
</head>
<body class="page-weather">
  <!--[if lt IE 9]><div class="legacy-browser">
  <div class="legacy-pad"><p>현재 사용중인 브라우저는 지원이 중단된 브라우저입니다.<br> 원활한 온라인 서비스를 위해 브라우저를 <a href="http://windows.microsoft.com/ko-kr/internet-explorer/ie-11-worldwide-languages" target="_blank">최신 버전</a>으로 업데이트 해주시길 바랍니다.  </p></div>
  </div><![endif]-->

  <!-- 웨더 앱// -->
  <div class="weather-wrap">
    <!-- 헤더// -->
    <div class="header">
      <h1 class="title">Weather</h1>
      <div class="util"><a href="#pop-geocode" target="_self" class="city">노원구, 서울특별시</a></div>
    </div>
    <!-- //헤더 -->
    <!-- 콘텐츠// -->
    <div class="content">
      <div class="today">
        <h3 class="blind">현재 날씨</h3>
        <div class="bg"></div>
        <div class="current-date"></div>
        <div class="current-time">00:00</div>
        <script>
          (function currentTime() {
            $('.current-date').text(getTime("md"));
            $('.current-time').text(getTime("hm"));
            setTimeout(function() {
              currentTime();
            }, 5000);
          })();
        </script>
        <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
        <div class="feels-like"><span class="blind">체감 온도</span><span class="value"></span><span class="unit">˚C</span></div>
        <div class="temp-minmax"><span class="temp-min">MIN <span class="blind">최고</span><span class="value"></span><span class="unit">˚C</span></span>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="temp-max">MAX <span class="blind">최저</span><span class="value"></span><span class="unit">˚C</span></span></div>
        <div class="humidity"><div class="icon"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 25.906 25.906" style="enable-background:new 0 0 25.906 25.906;" xml:space="preserve"><g><path style="fill: rgba(255,255,255,0.6);" d="M12.953,0c0,0-9,10.906-9,16.906c0,4.971,4.029,9,9,9s9-4.029,9-9C21.953,10.906,12.953,0,12.953,0z M9.026,17.496c0,1.426,0.668,4.25,1.134,5.426c-3.042-1.494-3.846-4.425-3.846-6.463c0-3.173,3.684-7.824,5.777-12.149 C11.861,6.581,9.026,13.177,9.026,17.496z"/></g></svg></div><div class="icon over" style="clip: rect(0px, 20px, 20px, 0px);"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 25.906 25.906" style="enable-background:new 0 0 25.906 25.906;" xml:space="preserve"><g><path style="fill:#3175d0;" d="M12.953,0c0,0-9,10.906-9,16.906c0,4.971,4.029,9,9,9s9-4.029,9-9C21.953,10.906,12.953,0,12.953,0z M9.026,17.496c0,1.426,0.668,4.25,1.134,5.426c-3.042-1.494-3.846-4.425-3.846-6.463c0-3.173,3.684-7.824,5.777-12.149 C11.861,6.581,9.026,13.177,9.026,17.496z"/></g></svg></div><span class="value"></span><span class="unit">%</span></div>
        <div class="mimun"><span class="blind">미세먼지 수치</span><span class="value"></span></div>
        <div class="weather"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" class="icon" draggable="false"></div>
        <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
      </div>
      <div class="notice">OpenWeather®, Last updated <span class="time"></span><a href="javascript:void(0);" title="새로고침" class="refresh"><span class="blind">REFRESH</span></a></div>
      <script>
        //새로고침
        $('.notice .refresh').on('click', function() {
          updateForecast();
          gsap.fromTo('.refresh', {rotation:0},{duration:1, rotation:360});
        });
      </script>
      <div class="forecast eachHour">
        <h3 class="tit">시간별 날씨</h3>
        <div class="scroll-wrap">
          <div class="scroll-inner">
            <div class="time time1">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time2">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time3">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time4">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time5">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time6">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time7">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time8">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time9">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time10">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time11">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time12">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time13">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time14">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time15">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time16">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time17">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time18">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time19">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time20">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time21">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time22">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time23">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time24">
              <div class="temperature"><span class="blind">온도</span><span class="value"></span><span class="unit">˚C</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="date"><span class="blind">시간</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
          </div>
        </div>
      </div>
      <div class="forecast daily">
        <h3 class="tit">주간 날씨</h3>
        <div class="scroll-wrap">
          <div class="scroll-inner">
            <div class="time time1">
              <div class="date"><span class="blind">날짜</span><span class="value"></span>일<span class="tip">(내일)</span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="temperature"><span class="temp-min"><span class="blind">최저 기온</span><span class="value"></span><span class="unit">˚C</span></span> / <span class="temp-max"><span class="blind">최고 기온</span><span class="value"></span><span class="unit">˚C</span></span></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time2">
              <div class="date"><span class="blind">날짜</span><span class="value"></span>일<span class="tip day"></span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="temperature"><span class="temp-min"><span class="blind">최저 기온</span><span class="value"></span><span class="unit">˚C</span></span> / <span class="temp-max"><span class="blind">최고 기온</span><span class="value"></span><span class="unit">˚C</span></span></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time3">
              <div class="date"><span class="blind">날짜</span><span class="value"></span>일<span class="tip day"></span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="temperature"><span class="temp-min"><span class="blind">최저 기온</span><span class="value"></span><span class="unit">˚C</span></span> / <span class="temp-max"><span class="blind">최고 기온</span><span class="value"></span><span class="unit">˚C</span></span></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time4">
              <div class="date"><span class="blind">날짜</span><span class="value"></span>일<span class="tip day"></span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="temperature"><span class="temp-min"><span class="blind">최저 기온</span><span class="value"></span><span class="unit">˚C</span></span> / <span class="temp-max"><span class="blind">최고 기온</span><span class="value"></span><span class="unit">˚C</span></span></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time5">
              <div class="date"><span class="blind">날짜</span><span class="value"></span>일<span class="tip day"></span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="temperature"><span class="temp-min"><span class="blind">최저 기온</span><span class="value"></span><span class="unit">˚C</span></span> / <span class="temp-max"><span class="blind">최고 기온</span><span class="value"></span><span class="unit">˚C</span></span></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time6">
              <div class="date"><span class="blind">날짜</span><span class="value"></span>일<span class="tip day"></span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="temperature"><span class="temp-min"><span class="blind">최저 기온</span><span class="value"></span><span class="unit">˚C</span></span> / <span class="temp-max"><span class="blind">최고 기온</span><span class="value"></span><span class="unit">˚C</span></span></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
            <div class="time time7">
              <div class="date"><span class="blind">날짜</span><span class="value"></span>일<span class="tip day"></span></div>
              <div class="weather-img"><img src="https://leecoder20c.github.io/coderoom/lib/images/weather/icon/default.png" alt="날씨 아이콘" class="icon" draggable="false"></div>
              <div class="temperature"><span class="temp-min"><span class="blind">최저 기온</span><span class="value"></span><span class="unit">˚C</span></span> / <span class="temp-max"><span class="blind">최고 기온</span><span class="value"></span><span class="unit">˚C</span></span></div>
              <div class="desc"><span class="blind">날씨설명</span><span class="value"></span></div>
              <div class="wind-speed"><span class="blind">풍속</span><span class="value"></span> 노트</div>
            </div>
          </div>
        </div>
      </div>
      <div class="notice">본 저작물은 공공누리 제1유형으로 개방한 한국환경공단 국가대기오염정보 조회 서비스를 활용하였습니다.</div>
    </div>
    <!-- //콘텐츠 -->
    <!-- 팝업// -->
    <div id="pop-geocode" class="pop-geocode">
      <a href="javascript:void(0);" class="close" title="닫기"><span class="bar1"></span><span class="bar2"></span></a>
      <ul class="city-list">
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">서울특별시</a>
          <ul>
            <li class="depth2"><a href="#서울" target="_self" class="location" data-city="seoul" data-name="Seoul" data-lat="37.5990998" data-lon="127.9861493">서울(전체)</a></li>
            <li class="depth2"><a href="#강남구" target="_self" class="location" data-city="seoul" data-name="강남구" data-lat="37.4959854" data-lon="127.0664091">강남구</a></li>
            <li class="depth2"><a href="#강동구" target="_self" class="location" data-city="seoul" data-name="강동구" data-lat="37.5492077" data-lon="127.1464824">강동구</a></li>
            <li class="depth2"><a href="#강북구" target="_self" class="location" data-city="seoul" data-name="강북구" data-lat="37.6469954" data-lon="127.0147158">강북구</a></li>
            <li class="depth2"><a href="#강서구" target="_self" class="location" data-city="seoul" data-name="강서구" data-lat="37.5657617" data-lon="126.8226561">강서구</a></li>
            <li class="depth2"><a href="#관악구" target="_self" class="location" data-city="seoul" data-name="관악구" data-lat="37.4653993" data-lon="126.9438071">관악구</a></li>
            <li class="depth2"><a href="#광진구" target="_self" class="location" data-city="seoul" data-name="광진구" data-lat="37.5481445" data-lon="127.0857528">광진구</a></li>
            <li class="depth2"><a href="#구로구" target="_self" class="location" data-city="seoul" data-name="구로구" data-lat="37.4954856" data-lon="126.858121">구로구</a></li>
            <li class="depth2"><a href="#금천구" target="_self" class="location" data-city="seoul" data-name="금천구" data-lat="37.4600969" data-lon="126.9001546">금천구</a></li>
            <li class="depth2"><a href="#노원구" target="_self" class="location" data-city="seoul" data-name="노원구" data-lat="37.655264" data-lon="127.0771201">노원구</a></li>
            <li class="depth2"><a href="#도봉구" target="_self" class="location" data-city="seoul" data-name="도봉구" data-lat="37.6658609" data-lon="127.0317674">도봉구</a></li>
            <li class="depth2"><a href="#동대문구" target="_self" class="location" data-city="seoul" data-name="동대문구" data-lat=" 37.5838012" data-lon="127.0507003">동대문구</a></li>
            <li class="depth2"><a href="#동작구" target="_self" class="location" data-city="seoul" data-name="동작구" data-lat="37.4965037" data-lon="126.9443073">동작구</a></li>
            <li class="depth2"><a href="#마포구" target="_self" class="location" data-city="seoul" data-name="마포구" data-lat="37.5622906" data-lon="126.9087803">마포구</a></li>
            <li class="depth2"><a href="#서대문구" target="_self" class="location" data-city="seoul" data-name="서대문구" data-lat=" 37.5820369" data-lon="126.9356665">서대문구</a></li>
            <li class="depth2"><a href="#서초구" target="_self" class="location" data-city="seoul" data-name="서초구" data-lat="37.4769528" data-lon="127.0378103">서초구</a></li>
            <li class="depth2"><a href="#성동구" target="_self" class="location" data-city="seoul" data-name="성동구" data-lat="37.5506753" data-lon="127.0409622">성동구</a></li>
            <li class="depth2"><a href="#성북구" target="_self" class="location" data-city="seoul" data-name="성북구" data-lat="37.606991" data-lon="27.0232185">성북구</a></li>
            <li class="depth2"><a href="#송파구" target="_self" class="location" data-city="seoul" data-name="송파구" data-lat="37.5048534" data-lon="127.1144822">송파구</a></li>
            <li class="depth2"><a href="#양천구" target="_self" class="location" data-city="seoul" data-name="양천구" data-lat="37.5270616" data-lon="126.8561534">양천구</a></li>
            <li class="depth2"><a href="#영등포구" target="_self" class="location" data-city="seoul" data-name="영등포구" data-lat=" 37.520641" data-lon="126.9139242">영등포구</a></li>
            <li class="depth2"><a href="#용산구" target="_self" class="location" data-city="seoul" data-name="용산구" data-lat="37.5311008" data-lon="126.9810742">용산구</a></li>
            <li class="depth2"><a href="#은평구" target="_self" class="location" data-city="seoul" data-name="은평구" data-lat="37.6176125" data-lon="126.9227004">은평구</a></li>
            <li class="depth2"><a href="#종로구" target="_self" class="location" data-city="seoul" data-name="종로구" data-lat="37.5990998" data-lon="126.9861493">종로구</a></li>
            <li class="depth2"><a href="#중구" target="_self" class="location" data-city="seoul" data-name="중구" data-lat=" 37.5579452" data-lon="126.9941904">중구</a></li>
            <li class="depth2"><a href="#중랑구" target="_self" class="location" data-city="seoul" data-name="중랑구" data-lat="37.5953795" data-lon="127.0939669">중랑구</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">부산광역시</a>
          <ul>
            <li class="depth2"><a href="#부산" target="_self" class="location" data-city="busan" data-name="Busan" data-lat="35.133331" data-lon="129.050003">부산(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">대구광역시</a>
          <ul>
            <li class="depth2"><a href="#대구광역시" target="_self" class="location" data-city="daegu" data-name="Daegu" data-lat="35.799999" data-lon="128.550003">대구(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">인천광역시</a>
          <ul>
            <li class="depth2"><a href="#인천광역시" target="_self" class="location" data-city="incheon" data-name="Incheon" data-lat="37.450001" data-lon="126.731667">인천(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">광주광역시</a>
          <ul>
            <li class="depth2"><a href="#광주광역시" target="_self" class="location" data-city="gwangju" data-name="Gwangju" data-lat="35.166672" data-lon="126.916672">광주(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">대전광역시</a>
          <ul>
            <li class="depth2"><a href="#대전광역시" target="_self" class="location" data-city="daejeon" data-name="Daejeon" data-lat="36.321388" data-lon="127.419724">대전(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">울산광역시</a>
          <ul>
            <li class="depth2"><a href="#울산광역시" target="_self" class="location" data-city="ulsan" data-name="Ulsan" data-lat="35.53722" data-lon="129.316666">울산(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">세종특별자치시</a>
          <ul>
            <li class="depth2"><a href="#세종특별자치시" target="_self" class="location" data-city="sejong" data-name="Chungju" data-lat="36.970558" data-lon="127.93222">세종(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">경기도</a>
          <ul>
            <li class="depth2"><a href="#경기도" target="_self" class="location" data-city="gyeonggi" data-name="Gyeonggi-do" data-lat="37.599998" data-lon="127.25">경기(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">강원도</a>
          <ul>
            <li class="depth2"><a href="#강원도" target="_self" class="location" data-city="gangwon" data-name="Gangwon-do" data-lat="37.75" data-lon="128.25">강원(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">충청북도</a>
          <ul>
            <li class="depth2"><a href="#충청북도" target="_self" class="location" data-city="chungbuk" data-name="Chungcheongbuk-do" data-lat="36.75" data-lon="128.0">충북(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">충청남도</a>
          <ul>
            <li class="depth2"><a href="#충청남도" target="_self" class="location" data-city="chungnam" data-name="Chungcheongnam-do" data-lat="36.5" data-lon="127.0">충남(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">전라북도</a>
          <ul>
            <li class="depth2"><a href="#전라북도" target="_self" class="location" data-city="Jeollabuk" data-name="Jeollabuk-do" data-lat="35.75" data-lon="127.25">전북(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">전라남도</a>
          <ul>
            <li class="depth2"><a href="#전라남도" target="_self" class="location" data-city="Jeollanam" data-name="Jeollanam-do" data-lat="34.75" data-lon="127.0">전남(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">경상북도</a>
          <ul>
            <li class="depth2"><a href="#경상북도" target="_self" class="location" data-city="gyeongbuk" data-name="Gyeongsangbuk-do" data-lat="36.333328" data-lon="128.75">경북(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">경상남도</a>
          <ul>
            <li class="depth2"><a href="#경상남도" target="_self" class="location" data-city="gyeongnam" data-name="Gyeongsangnam-do" data-lat="35.25" data-lon="128.25">경남(전체)</a></li>
          </ul>
        </li>
        <li class="depth1"><a href="javascript:void(0);" target="_self" class="tit">제주특별자치도</a>
          <ul>
            <li class="depth2"><a href="#제주특별자치도" target="_self" class="location" data-city="jeju" data-name="Jeju-do" data-lat="33.416672" data-lon="126.5">제주(전체)</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- //팝업 -->
    <script>
      //Var
      var $loca = $('.header .city');//도시명
      var $popClose = $('.pop-geocode .close');//팝업 내 닫기 버튼
      var $newLocaTit = $('.pop-geocode .tit');//도단위 리스트
      var $newLoca = $('.pop-geocode .location');//새로운 도시명 리스트

      //팝업 열기(도시명 클릭 시)
      $loca.on('click', function() {
        $('.pop-geocode').addClass("is-active");
      });

      //팝업 닫기
      $popClose.on('click', function() {
        $('.pop-geocode .tit + ul > .depth2').hide(0);
        $('.pop-geocode').removeClass("is-active");
      });

      //도시 드롭다운
      $newLocaTit.on('click', function() {
        var $this = $(this);
        $newLocaTit.removeClass('on');
        $this.addClass('on');
        $('.pop-geocode .tit + ul > .depth2').hide(0);
        $this.siblings('ul').find('.depth2').show(100);
      });

      //도시 변경하기
      $newLoca.on('click', function() {
        //Var
        $loca.text($(this).text()+', '+$(this).parents('.depth1').find('.tit').text());//도시명 변경
        forecast.geo.city = $(this).attr('data-name');//도시 변수 변경
        forecast.geo.lat = $(this).attr('data-lat');//Geo lat 변경
        forecast.geo.lon = $(this).attr('data-lon');//Geo lon 변경

        //Set
        updateForecast();//날씨 재실행

        //미세먼지 수치 변경
        var mimunVal = $(this).attr('data-mimun');
        setMimun(mimunVal);

        $popClose.trigger('click');//팝업 닫기
      });
    </script>
  </div>
  <!-- //웨더 앱 -->
  <script>
    /* api 정보 : https://openweathermap.org/forecast5 */
    var forecast = {
      city: "Seoul",
      lang: "kr",
      geo: {
        lat: 37.646809,
        lon: 127.0580746
      },//노원구 좌표계 WGS1984
      exclude: "alerts",//전체 보기
      getForecastDay: function(UTC) {
        var utc = UTC*1000;
        var time = new Date(utc);
        return time.getDate();
      },
      getForecastHour: function(UTC) {
        var utc = UTC*1000;
        var time = new Date(utc);
        return time.getHours();
      },
      weatherUrl: function() {
        return "https://api.openweathermap.org/data/2.5/weather?q="+this.city+"&appid="+"1c40f42436a06d02eff28e1526d29217"+"&lang="+this.lang;
      },
      onecallUrl: function() {
        return "https://api.openweathermap.org/data/2.5/onecall?lat="+this.geo.lat+"&lon="+this.geo.lon+"&exclude="+this.exclude+"&appid="+"1c40f42436a06d02eff28e1526d29217"+"&lang="+this.lang;
      }
    };
    //예보
    var updateForecast = function() {
      $.ajax({
        url: forecast.onecallUrl(),
        dataType: "json",
        type: "GET",
        async: "false",
        success: function(resp) {
          //console.log(resp);
          //현재 날씨
          $('.weather-wrap .today .bg').attr("style","background-image: url('https://leecoder20c.github.io/coderoom/lib/images/weather/"+resp.current.weather[0].main+".jpg');");//날씨별 배경
            /*온도별 날씨이미지 개별화*/
            if(parseInt(resp.current.temp - 273.15) < -7) {
              $('.weather-wrap .today .bg').attr("style","background-image: url('https://leecoder20c.github.io/coderoom/lib/images/weather/Cold.jpg');");//추운 날
            }
            if(parseInt(resp.current.temp - 273.15) > 27) {
              $('.weather-wrap .today .bg').attr("style","background-image: url('https://leecoder20c.github.io/coderoom/lib/images/weather/Hot.jpg');");//더운 날
            }
          $('.weather-wrap .today .temperature .value').text(parseInt(resp.current.temp - 273.15));//온도
          $('.weather-wrap .today .feels-like .value').text(parseInt(resp.current.feels_like - 273.15));//체감
          $('.weather-wrap .today .temp-max .value').text(parseInt(resp.current.temp - 273.15));//최대
          $('.weather-wrap .today .temp-min .value').text(parseInt(resp.current.temp - 273.15));//최저
          $('.weather-wrap .today .pressure .value').text(resp.current.pressure);//기압
          $('.weather-wrap .today .humidity .value').text(resp.current.humidity);//습도
          $('.weather-wrap .today .humidity .icon.over').css('clip','rect('+(20-parseInt(resp.current.humidity)*0.25)+'px, 20px, 24px, 0px)');
          $('.weather-wrap .today .weather .value').text(resp.current.weather[0].main);//메인날씨
          $('.weather-wrap .today .desc .value').text(resp.current.weather[0].description);//설명
          $('.weather-wrap .today .wind-deg .value').text(resp.current.wind_deg);//풍향
          $('.weather-wrap .today .wind-speed .value').text(resp.current.wind_speed);//풍속
          $('.weather-wrap .today .cloud .value').text(resp.current.clouds);//구름
          $('.weather-wrap .today .weather .icon').attr('src', 'https://leecoder20c.github.io/coderoom/lib/images/weather/icon/'+resp.current.weather[0].main+'.svg');//아이콘
          $('.weather-wrap .today .weather .icon').attr('data-stat',resp.current.weather[0].main);//아이콘 움직임
          $('.weather-wrap .notice .time').text(getTime('date')+' '+getTime('hm'));//시계
          //최대&최소 온도(12 시간 이내)
          for (i=0;i<12;i++) {
            var temp = parseInt(resp.hourly[i].temp - 273.15);
            var minCurrent = parseInt($('.weather-wrap .today .temp-min .value').text());
            var maxCurrent = parseInt($('.weather-wrap .today .temp-max .value').text());
            if (temp < minCurrent) {
              $('.weather-wrap .today .temp-min .value').text(temp);
            }
            if (temp > maxCurrent) {
              $('.weather-wrap .today .temp-max .value').text(temp);
            }
            //console.log('temp:'+temp+','+'minCurrent: '+minCurrent+','+'maxCurrent: '+maxCurrent);
          }

          //시간별 날씨
          for (i=0;i<resp.hourly.length;i++) {
            $('.weather-wrap .forecast.eachHour .time'+i).find('.date .value').text(forecast.getForecastHour(resp.hourly[i].dt)+'시');
            $('.weather-wrap .forecast.eachHour .time'+i).find('.temperature .value').text(parseInt(resp.hourly[i].temp - 273.15));
            $('.weather-wrap .forecast.eachHour .time'+i).find('.weather-img .icon').attr('src', 'https://leecoder20c.github.io/coderoom/lib/images/weather/icon/'+resp.hourly[i].weather[0].main+'.svg');
            $('.weather-wrap .forecast.eachHour .time'+i).find('.desc .value').text(resp.hourly[i].weather[0].description);
            $('.weather-wrap .forecast.eachHour .time'+i).find('.wind-speed .value').text(resp.hourly[i].wind_speed);
            $('.weather-wrap .forecast.eachHour .time'+i).find('.weather-img .icon').attr('data-stat',resp.hourly[i].weather[0].main);//아이콘 움직임
          }

          //한주간 날씨
          for (i=0;i<resp.daily.length;i++) {
            $('.weather-wrap .forecast.daily .time'+i).find('.date .value').text(forecast.getForecastDay(resp.daily[i].dt));//각 날의 정오 기준
            $('.weather-wrap .forecast.daily .time'+i).find('.temp-min .value').text(parseInt(resp.daily[i].temp.min - 273.15));
            $('.weather-wrap .forecast.daily .time'+i).find('.temp-max .value').text(parseInt(resp.daily[i].temp.max - 273.15));
            $('.weather-wrap .forecast.daily .time'+i).find('.weather-img .icon').attr('src', 'https://leecoder20c.github.io/coderoom/lib/images/weather/icon/'+resp.daily[i].weather[0].main+'.svg');
            $('.weather-wrap .forecast.daily .time'+i).find('.desc .value').text(resp.daily[i].weather[0].description);
            $('.weather-wrap .forecast.daily .time'+i).find('.wind-speed .value').text(resp.daily[i].wind_speed);
            $('.weather-wrap .forecast.daily .time'+i).find('.weather-img .icon').attr('data-stat',resp.daily[i].weather[0].main);//아이콘 움직임
            //요일
            var day = new Date();
            day = parseInt(day.getDay())+i%7;
            switch(day) {
              case 1: day = "월"; break;
              case 2: day = "화"; break;
              case 3: day = "수"; break;
              case 4: day = "목"; break;
              case 5: day = "금"; break;
              case 6: day = "토"; break;
              case 7: day = "일"; break;
            }
            $('.weather-wrap .forecast.daily .time'+i).find('.date .tip.day').text('('+day+')');
          }
        }
      }).then(function() {
        setTimeout(updateForecast, 600000);//10분마다 실행
      });
    };
    updateForecast();
    /*Descripttions 
      Clouds 구름
      Snow 눈
      Clear 맑음
      Rain 비
      Thunderstorm 폭풍
      Drizzle 보슬비
      Mist 미스트
      Smoke 연기
      Haze 연무
      Dust 먼지
      Fog 안개
      Sand 모래
      Ash 잿더미
      Squall 돌풍
      Tornado 태풍 */

    //미세먼지 API
    var updateMimun = function() {
      $.ajax({
        url: './mimun.php',
        dataType: "json",
        type: "GET",
        async: "false",
        success: function(resp) {
          //console.log(resp);
          for(key in resp.body.items.item) {
            if($('[data-city="'+key+'"]')) {
              $('[data-city="'+key+'"]').attr('data-mimun', resp.body.items.item[key]);
            }
          }
          setMimun($('[data-city="seoul"]').attr('data-mimun'));
        }
      }).then(function() {
        setTimeout(updateMimun, 36000000);//60분마다 실행
      });
    };
    updateMimun();
    var setMimun = function(val) {
      //Var
      var $mimun = $('.today .mimun');//미세먼지
      var mimunVal = parseInt(val);

      //Set
      if (mimunVal <= 30) { $mimun.attr('data-stat','good'); mimunState = 'Good'; }
      if (mimunVal > 30) { $mimun.attr('data-stat','normal'); mimunState = 'Normal'; }
      if (mimunVal > 80) { $mimun.attr('data-stat','bad'); mimunState = 'Bad'; }
      if (mimunVal > 150) { $mimun.attr('data-stat','hell'); mimunState = 'Hell'; }
      //$mimun.find('.value').text(mimunVal);//수치로 적용
      $mimun.find('.value').text(mimunState);//텍스트로 적용
    }
  </script>
</body>
</html>
