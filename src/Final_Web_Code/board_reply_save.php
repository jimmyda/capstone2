<?php
//board_reply_save.php : 넘겨받은 입력값을 DB 테이블 board에 저장하고, 댓글의 단계도 추가한다.
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

// 3. 부모글 데이터 불러오기
$sql = "select * from board where b_idx = '".$_POST['b_idx']."'";
$result = sql_query($sql);
$data = mysqli_fetch_array($result);

// 4. 부모글이 없으면 메세지 출력후 되돌리기
if(!$data['b_idx']){
    ?>
    <script>
        alert("존재하지 않는 글입니다.");
        history.back();
    </script>
    <?
}

// 5. 관리자가 아니면 메세지 출력후 되돌리기
if(($_POST['m_id']) != "SOFA"){
    ?>
    <script>
        alert("관리자만 댓글 쓰기가 가능합니다.");
        history.back();
    </script>
    <?
}

// 6. 댓글이 가능한지 검사
// 6-1. 부모글의 단계가 몇단계 인지 검사후 2단계면 댓글 불가
if(strlen($data['b_reply']) == 2){
    ?>
    <script>
        alert("더이상 댓글을 쓸수가 없습니다.");
        history.back();
    </script>
    <?
}

// 6-2 부모글에 달린 댓글의 마지막 댓글이 몇번째인지 검사

$sql2 = "select * from board where b_num = '".$data['b_num']."' and b_reply like '".$data['b_reply']."%' order by b_reply desc limit 1";
$result2 = sql_query($sql2);
$data2 = mysqli_fetch_array($result2);

$last_reply_char = substr($data2['b_reply'], strlen($data['b_reply']), 1);
if($last_reply_char == "Z"){
    ?>
    <script>
        alert("더이상 댓글을 쓸수가 없습니다.");
        history.back();
    </script>
    <?
}

// 7. 넘어온 변수 검사
if(trim($_POST['b_title']) == ""){
    ?>
    <script>
        alert("글제목을 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST['b_contents']) == ""){
    ?>
    <script>
        alert("글내용을 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

// 8. b_num 과 b_reply 만들기
$b_num = $data['b_num'];
if($last_reply_char){
    $b_reply = $data['b_reply'].chr(ord($last_reply_char) + 1);
}else{
    $b_reply = $data['b_reply']."A";
}

// 9. 글저장
$sql = "insert into board set b_num = '".$b_num."', b_reply = '".$b_reply."', m_id = '".$_SESSION['user_id']."', m_name = '".$_SESSION['user_name']."', b_title = '".addslashes(htmlspecialchars($_POST['b_title']))."', b_contents = '".addslashes(htmlspecialchars($_POST['b_contents']))."', b_regdate = now()";
sql_query($sql);


// 10. 글목록 페이지로 보내기
?>
<script>
alert(" 글이 저장 되었습니다.");
location.replace("./board_list.php");
</script>
