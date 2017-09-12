<?php
//board_modify_save.php : board_modify.php에서 넘겨 받은 입력값을 DB 테이블 board에 저장한다.
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("로그인 하셔야 합니다.");
        location.replace("board_login.php");
    </script>
    <?
}

// 3. 넘어온 변수 검사
if(trim($_POST[b_idx]) == ""){
    ?>
    <script>
        alert("없는 글입니다.");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[b_title]) == ""){
    ?>
    <script>
        alert("글제목을 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[b_contents]) == ""){
    ?>
    <script>
        alert("글내용을 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

// 4. 수정할 글 데이터 불러오기
$sql = "select * from board where b_idx = '".$_POST[b_idx]."'";
$result = sql_query($sql);
$data = mysqli_fetch_array($result);


// 5. 글이 없으면 메세지 출력후 되돌리기
if(!$data[b_idx]){
    ?>
    <script>
        alert("존재하지 않는 글입니다.");
        history.back();
    </script>
    <?
}

// 6. 본인의 글이 아니면 메세지 출력후 되돌리기
if($data[m_id] != $_SESSION[user_id]){
    ?>
    <script>
        alert("본인의 글이 아닙니다.");
        history.back();
    </script>
    <?
}

// 7. 수정한 글 DB에 저장
$sql = "update board set b_title = '".addslashes(htmlspecialchars($_POST[b_title]))."', b_contents = '".addslashes(htmlspecialchars($_POST[b_contents]))."' where b_idx = '".$_POST[b_idx]."'";
sql_query($sql);

// 8. 글목록 페이지로 보내기
?>
<script>
alert("글이 저장 되었습니다.");
location.replace("./board_list.php");
</script>
