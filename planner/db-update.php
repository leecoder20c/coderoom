<?php
  //Include and Require
  include("./db.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //월 조회일 경우
    if (!empty($_POST['id'])) {
      $id = $_POST['id'];//변수 지정
      $desc = $_POST['desc'];//변수 지정
      try{
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt =$db->prepare('UPDATE Infinite_Planner SET description="'.$desc.'" WHERE id='.$id);
          $stmt->execute(array());
          //Go back
          $prevPage = $_SERVER['HTTP_REFERER'];
          header('location:'.$prevPage);
      }catch(PDOException $e){
        print "잘못된 접근입니다.".$e->getMessage();
      }
    } else {
      print "잘못된 접근입니다.";
    }
  }else{
    print "잘못된 접근입니다.<br><a href='javascript:history.back();'>뒤로가기</a>";
  }
?>
