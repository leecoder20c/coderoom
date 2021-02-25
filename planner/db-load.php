<?php
  include("./db.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //월 조회일 경우
    if (!empty($_POST['month'])) {
      $month = $_POST['month'];//변수 지정
      //DB조회
      try{
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $db->query('SELECT * FROM Infinite_Planner WHERE month = '.$month.' ORDER BY day ASC');
        while($row=$q->fetch()){
          if("$row[day]"){
            print '
            <article class="article id-'."$row[id]".' day-'."$row[day]".'">
              <header class="header">
                <span class="when">Day-'."$row[day]".'</span>
                <a href="javascript:void(0);" target="_self" draggable="false" class="btn-edit" data-id="'."$row[id]".'"data-month="day-'."$row[month]".'" data-day="day-'."$row[day]".'">edit</a>
              </header>
              <div class="cont">
                <div class="desc">'."$row[description]".'</div>
              </div>
            </article>';
          }
        }
      }catch(PDOException $e){
        print "데이터베이스 오류, 페이지 로딩에 실패했습니다.".$e->getMessage();
      }
    }
  }else{
    print "잘못된 접근입니다.<br><a href='javascript:history.back();'>뒤로가기</a>";
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //아이디 조회일 경우
    if (!empty($_POST['id'])) {
      $id = $_POST['id'];
      //DB조회
      try{
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $db->query('SELECT * FROM Infinite_Planner WHERE id = '.$id);
        while($row=$q->fetch()){
          print "$row[description]";
        }
      }catch(PDOException $e){
        print "데이터베이스 오류, 페이지 로딩에 실패했습니다.".$e->getMessage();
      }
    }
  }else{
    print "잘못된 접근입니다.<br><a href='javascript:history.back();'>뒤로가기</a>";
  }
?>
