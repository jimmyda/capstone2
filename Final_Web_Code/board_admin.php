<?
//board_admin.php
// 1. 공통 인클루드 파일
include ("./include.php");

$admin = "SOFA";

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if((isset($_SESSION['user_id']))==false){
    ?>
    <script>
        alert("로그인 하셔야 합니다.");
        location.replace("board_login.php");
    </script>
    <?
}

// 3. 글 데이터 불러오기
$sql = "select * from board where b_idx = '".$_GET['b_idx']."'";
$result = sql_query($sql);
$data = mysqli_fetch_array($result);

// 4. 글이 없으면 메세지 출력후 되돌리기
if(!$data['b_idx']){
    ?>
    <script>
        alert("존재하지 않는 글입니다.");
        history.back();
    </script>
    <?
}

// 5. 본인의 글이 아니면 메세지 출력후 되돌리기
if($_SESSION['user_id'] != $admin){
    ?>
    <script>
        alert("관리자 페이지입니다.");
        history.back();
    </script>
    <?
}

// 6. 글
$sql_res_goodboard = "insert into good_board select * from board where b_num = '".$data['b_num']."'";
sql_query($sql_res_goodboard);

$sql_update_userinfo = "update user_info set goodboard=goodboard+1 where m_id = '".$data['m_id']."'";
sql_query($sql_update_userinfo);


// 7. 글목록 페이지로 보내기
?>
<script>
alert("good_board 테이블에 저장을 성공하였습니다.");
location.replace("./board_list.php");
</script>
