<?
//board_member_modify_save.php : board_member_modify.php에서 입력받은 변수를 DB의 테이블 user_info에 저장한다. 회원정보를 수정한다.
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
if($_POST['m_pass'] == ""){
    ?>
    <script>
        alert("비밀번호를 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

if($_POST['m_pass'] != $_POST['m_pass2']){
    ?>
    <script>
        alert("비밀번호를 확인해 주세요.");
        history.back();
    </script>
    <?
    exit;
}


// 4. DB의 회원정보 수정
$sql = "update user_info set m_pass = '".$_POST['m_pass']."' where m_id = '".$_SESSION['user_id']."'";
sql_query($sql);

// 8. 첫 페이지(index.php)로 보내기
?>
<script>
alert(" 회원정보가 수정 되었습니다.");
location.replace("board_list.php");
</script>
