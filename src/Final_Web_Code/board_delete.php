<?
//board_delete.php : 본인의 글을 삭제한다. DB테이블 board에서 삭제한다.
// 1. 공통 인클루드 파일
include ("./include.php");

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
if($data['m_id'] != $_SESSION['user_id']){
    ?>
    <script>
        alert("본인의 글이 아닙니다.");
        history.back();
    </script>
    <?
}

// 6. 글 삭제하기
$sql_delete = "delete from board where b_num = '".$data['b_num']."' and b_reply like '".$data['b_reply']."%'";
sql_query($sql_delete);


// 7. 글목록 페이지로 보내기
?>
<script>
alert("글이 삭제 되었습니다.");
location.replace("./board_list.php");
</script>
