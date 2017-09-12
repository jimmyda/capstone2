<?
//board_write_save.php : board_write.php에서 넘겨받은 입력값을 DB 테이블 board에 저장한다.
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

// 3. 넘어온 변수 검사
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


// 4. 글저장
$sql = "insert into board set b_num = '0', b_reply = '', m_id = '".$_SESSION['user_id']."', m_name = '".$_SESSION['user_name']."', b_title = '".addslashes(htmlspecialchars($_POST['b_title']))."', b_contents = '".addslashes(htmlspecialchars($_POST['b_contents']))."', b_regdate = now()";
sql_query($sql);

// 5. 저장된 글번호 찾기
$b_idx = mysqli_insert_id();

// 6. 글번호 저장
$sql = "update board set b_num = '".$b_idx."' where b_idx = '".$b_idx."'";
sql_query($sql);

// 7. 글목록 페이지로 보내기
?>
<script>
alert(" 글이 저장 되었습니다.");
location.replace("./board_list.php");
</script>
