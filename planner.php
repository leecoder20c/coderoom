<?php
  //Session checker
  session_start();
  if (isset($_SESSION['user_id'])) {

  } else {
    header("location:./planner/login.php");
  }
?>
<!DOCTYPE html>
<html lang="ko"dir="ltr" class="planner-app">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">

  <!--SEO-->
  <meta name="Author" content="#Tiger & Rabbit Company #Tiny Tiger Application Teams #LeeCoder">
  <meta name="robots" content="noidex, nofollow">
  <meta name="googlebot" content="noindex"/>
  <meta name="description" content="Simply planner application">
  <meta name="format-detection" content="telephone=no"> <!-- 아이폰 number 버그 개선 -->
  <link rel="image_src" href="./lib/images/planner/seo/logo.png" />
  <link rel="icon" href="./lib/images/planner/seo/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon-precomposed" href="./lib/images/planner/seo/logo.png" />
  <title>Infinite planner</title>

  <!--스크립트 CDN 및 플러그인-->
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/16327/gsap-latest-beta.min.js"></script>
  <script src="https://kit.fontawesome.com/66d4020c09.js" crossorigin="anonymous"></script>


  <!--스타일시트-->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400&family=Nanum+Gothic:wght@400&family=Tangerine:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="./lib/css/planner.css" />
  <script>
    function getTime(data) {
      var now = new Date();
      var hours = ("0" + (parseInt(now.getHours()))).slice(-2);//시
      var minutes = ("0" + (parseInt(now.getMinutes()))).slice(-2);//분
      var seconds = ("0" + (parseInt(now.getSeconds()))).slice(-2);//초
      var milliseconds = parseInt(now.getMilliseconds()); //밀리초
      var localeDate = parseInt(now.toLocaleDateString()); //yyyy.m.d
      var localeTime = parseInt(now.toLocaleTimeString()); //오전+시간+분+초
      var month = parseInt(now.getMonth());//월(문자표기용)
      var monthNumber = parseInt(now.getMonth())+1;//월(숫자표기용)
      var monthNumber2 = ("0" + (parseInt(now.getMonth())+1)).slice(-2);//월(숫자 2자리표기)
      var date = parseInt(now.getDate());//일
      var date2 = ("0" + (parseInt(now.getDate()))).slice(-2);//월(숫자 2자리표기)
      var day = parseInt(now.getDay());//요일
      var year = parseInt(now.getFullYear());//연도 4자리 표기
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
        case 0: day = "일"; break;
        case 1: day = "월"; break;
        case 2: day = "화"; break;
        case 3: day = "수"; break;
        case 4: day = "목"; break;
        case 5: day = "금"; break;
        case 6: day = "토"; break;
        case 7: day = "일"; break;
      }
      if (data == "hm") return hours + ':' + minutes;
      else if (data == "hms") return hours + ':' + minutes + ':' + seconds;
      else if (data == "hmsm") return hours + ':' + minutes + ':' + seconds + ':' + milliseconds;
      else if (data == "time") return localeTime;//ex. 오전 11:27:17
      else if (data == "date") return localeDate;//ex. 2021. 2. 5.
      else if (data == "md") return month+'. '+date;//ex. Jan.1
      else if (data == "mm") return month;//ex. Jan
      else if (data == "mn") return monthNumber;//ex. 1
      else if (data == "dd") return date;//ex. Jan.1
      else if (data == "d") return day;//ex. 월,화,수,목,금,토,일
      else if (data == "mm/dd/yyyy") return monthNumber2+'/'+date2+'/'+year;
    }
  </script>
</head>
<body class="page-planner">
  <!--[if lt IE 9]><div class="legacy-browser">
  <div class="legacy-pad"><p>현재 사용중인 브라우저는 지원이 중단된 브라우저입니다.<br> 원활한 온라인 서비스를 위해 브라우저를 <a href="http://windows.microsoft.com/ko-kr/internet-explorer/ie-11-worldwide-languages" target="_blank">최신 버전</a>으로 업데이트 해주시길 바랍니다.  </p></div>
  </div><![endif]-->
  <main class="ly-wrap">
    <!-- 헤더 -->
    <header class="ly-header">
      <h1 class="tit"><img src="./lib/images/planner/seo/logo.svg" alt="" class="logo">Infinite Planner</h1>
      <a href="javascript:void(0);" class="btn-gotoday">Today</a>
    </header>
    <!-- 컨텐츠// -->
    <section class="ly-content">
      <!-- 날짜 선택하기// -->
      <div class="date">
        <!-- 월 선택 -->
        <div class="month"><span class="value">-</span><input type="text" class="select-month" id="select-month"></div>
        <!-- 일 선택 -->
        <div class="day">
          <ul class="scroll" style="width: calc(50px * 31 + 20px);">
          </ul>
        </div>
      </div>
      <!-- //날짜 선택하기 -->
      <!-- 다이어리// -->
      <div class="diary">
        <!-- <article class="article day-1">
          <header class="header">
            <span class="when">Day-1</span>
            <a href="javascript:void(0);" target="_self" draggable="false" class="btn-edit" data-month="day-2" data-day="day-1">edit</a>
          </header>
          <div class="cont">
            <p class="desc">19'<br>Who am I?<br>Another day another destny...<br><br>20'<br>What do you want to know?<br>I am goning to talk about my life!<br><br>21'<br>New year is here!<br>Happy new year!</p>
          </div>
        </article> -->
      </div>
      <!-- //다이어리 -->
    </section>
    <!-- //컨텐츠 -->

    <!-- 팝업: 에디터 -->
    <div class="popup">
      <!-- 닫기 -->
      <a href="javascript:void(0);" draggable="false" class="btn-close" title="닫기"><span class="bar1"></span><span class="bar2"></span></a>
      <!-- 타이틀 -->
      <p class="tit">Editor</p>
      <!-- 에디터 -->
      <textarea name="" class="editor" id="editor"></textarea>
      <!-- 전송 버튼 -->
      <a href="javascript:void(0);" draggable="false" class="btn-submit" title="작성">Done</a>
    </div>
  </main>

  <script>
    //전역 변수
    var $lnbMonth = $('.ly-content .date .month');
    var $lnbDay = $('.ly-content .date .day');
    var $diary = $('.ly-content .diary');

    //일 네비게이션 생성
    var loadDays = function(month) {
      var length = null;
      var result = null;
      var $dayScrollWrap = $lnbDay.find('.scroll');
      switch(month) {//월 문자로 변환
        case 1: length = 31; break;
        case 2: length = 29; break;
        case 3: length = 31; break;
        case 4: length = 30; break;
        case 5: length = 31; break;
        case 6: length = 30; break;
        case 7: length = 31; break;
        case 8: length = 31; break;
        case 9: length = 30; break;
        case 10: length = 31; break;
        case 11: length = 30; break;
        case 12: length = 31; break;
      }
      $dayScrollWrap.attr('style','width :calc(50px * '+length+' + 20px);').html('');//일 네비게이션 스타일 변경
      for(i=1; i <= length; i++) {//일 개수만큼 네비게이션 삽입
        $dayScrollWrap.append("<li><a href='javascript:void(0);' draggable='false' data-date="+i+" class='btn-day'>"+i+"</a></li>");
      }
      $lnbDay.find('.btn-day').on('click', activeDay);//일 네비게이션 클릭
    }
    //컨텐츠 리스트 생성
    var loadList = function(month) {
      $.ajax({
        type: "POST",
        url: './planner/db-load.php',
        data: {"month": month},
        success: function(result) {
          //Reset
          $diary.html("");
          //Set
          $diary.append(result);
          //Event 재설정
          popup();
        },
        error: function(result) {
          console.log(result);
        }
      });
    };
    //선택된 날짜 활성화
    var goDate = function(month,day) {
      $lnbMonth.find('.value').text(month);//월 표시
      $lnbDay.find('.btn-day[data-date='+day+']').trigger('click');//오늘 날짜 클릭
      moveLeftScrollDayBtn(day);//오늘 날짜 네비게이션 스크롤
    }
    //일 네비게이션 스크롤
    var moveLeftScrollDayBtn = function(day) {
      var todayBtn = $lnbDay.find('.btn-day[data-date='+day+'] ');
      $lnbDay.stop().animate({
        "scrollLeft":todayBtn.offset().left - $lnbDay.find('.btn-day[data-date="1"]').offset().left - 10
      }, 1000);//네비게이션 버튼 스크롤 (오늘 - 첫날's offset left')
    };
    //일 선택 시 네비게이션 활성화 및 해당 컨텐츠로 스크롤 이동
    var activeDay = function(e) {
      //Reset
      $lnbDay.find('.selected').removeClass('selected');

      //Var
      var $this = $(this);
      var $target = $('.day-'+$this.attr('data-date'));//다이어리-대상

      //Set
      $this.parent('li').addClass('selected');//네비게이션 버튼 활성
      if($target.length) {
        var getTargetOffsetTop = ($target.offset().top)-$('.day-1').offset().top;//대상 스크롤값 측정
        $diary.stop().animate({"scrollTop":getTargetOffsetTop}, 1000);//이동
      }
    }
    //선택된 날짜 실행
    var updateDatepicker = function(date) {
      if($(this).hasClass('hasDatepicker')) {
        var selectDate = $(this).val();
      } else {
        var selectDate = date;
      }
      var selectYear = parseInt(selectDate.slice(6,10));
      var selectDay = parseInt(selectDate.slice(3,5));
      var selectMonth = parseInt(selectDate.slice(0,2));
      loadDays(selectMonth);//일 버튼 세팅
      loadList(selectMonth);//해당 월 리스트 로드
      switch(selectMonth) {//월 문자로 변환
        case 1: selectMonth = "Jan"; break;
        case 2: selectMonth = "Feb"; break;
        case 3: selectMonth = "Mar"; break;
        case 4: selectMonth = "Apr"; break;
        case 5: selectMonth = "May"; break;
        case 6: selectMonth = "Jun"; break;
        case 7: selectMonth = "Jul"; break;
        case 8: selectMonth = "Aug"; break;
        case 9: selectMonth = "Sep"; break;
        case 10: selectMonth = "Oct"; break;
        case 11: selectMonth = "Nov"; break;
        case 12: selectMonth = "Dec"; break;
      }
      setTimeout(function() {
        goDate(selectMonth,selectDay);//해당 일로 스크롤 이동
      },100)
    }
    //스크롤 드래그 적용
    var drag2scroll = function(target) {
      var ele = target.get(0);
      ele.style.cursor = 'grab';
      var pos = { top: 0, left: 0, x: 0, y: 0 };
      var mouseDownHandler = function(e) {
        ele.style.cursor = 'grabbing';
        ele.style.userSelect = 'none';
        pos = {
            left: ele.scrollLeft,
            top: ele.scrollTop,
            // Get the current mouse position
            x: e.clientX,
            y: e.clientY,
        };

        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', mouseUpHandler);
      };
      var mouseMoveHandler = function(e) {
        // How far the mouse has been moved
        var dx = e.clientX - pos.x;
        var dy = e.clientY - pos.y;
        // Scroll the element
        ele.scrollTop = pos.top - dy;
        ele.scrollLeft = pos.left - dx;
      };
      var mouseUpHandler = function(e) {
        ele.style.cursor = 'grab';
        ele.style.removeProperty('user-select');
        document.removeEventListener('mousemove', mouseMoveHandler);
        document.removeEventListener('mouseup', mouseUpHandler);
      };
      // Attach the handler
      ele.addEventListener('mousedown', mouseDownHandler);
    };
    //팝업
    var popup = function() {
      //Var
      var $popup = $('.popup');//팝업
      var $popOpen = $('.btn-edit');//팝업 열기 버튼
      var $popClose = $('.popup .btn-close');//팝업 닫기 버튼
      var $popSubmit = $('.popup .btn-submit');//작성 버튼
      var $editor = $('#editor');//작성 버튼
      var dbId = null;
      var dbDesc = null;

      var popupOpen = function() {//팝업 열기

        //Var
        dbId = $(this).attr('data-id');

        //DB불러오기
        $.ajax({
          type: "POST",
          url: './planner/db-load.php',
          data: {"id": dbId},
          success: function(result) {
            $editor.val(result);
          },
          error: function(result) {
            console.log(result);
          }
        });

        //Event
        $popup.addClass("is-active");
      };

      //Event
      $popOpen.on('click', popupOpen);

      $popSubmit.on('click', function() {//수정사항 전송
        dbDesc = $('#editor').val();
        //DB전송
        $.ajax({
          type: "POST",
          url: './planner/db-update.php',
          data: {"id": dbId, "desc": dbDesc},
          success: function(result) {
            //console.log('성공');
            $('.id-'+dbId).find('.desc').html(dbDesc);
            $popClose.trigger('click');//닫기
          },
          error: function(result) {
            console.log(result);
          }
        });
      });

      $popClose.on('click', function() {//팝업 닫기
        $popup.removeClass("is-active");
      })
    };

    //데이트 피커
    $("#select-month").datepicker({
      showAnim: 'slideDown',
      showOtherMonths: true,
      selectOtherMonths: true,
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
      showMonthAfterYear: true,
      yearSuffix: '년'
    });
    //날짜 선택: 데이터 불러오기
    $("#select-month").change(updateDatepicker);
    //오늘 선택 시 오늘 날짜 불러오기 
    $('.btn-gotoday').on('click',function() { updateDatepicker(getTime('mm/dd/yyyy')); });

    //페이지 로드 후
    $(function() {
      drag2scroll($lnbDay);//일 네비게이션 좌우 드래그
      drag2scroll($diary);//다이어리 상하 드래그
      updateDatepicker(getTime('mm/dd/yyyy'));//오늘 날짜로 최초 데이터 실행
    });
  </script>
</body>
</html>
