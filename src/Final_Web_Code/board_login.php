<center><?
//board_login.php : 로그인 화면에서 아이디와 비밀번호 입력 후, login_chk.php로 넘긴다.
// 1. 공통 인클루드 파일
// 1. 세션사용을 위한 초기화
session_start();

// 2. 사용자 정의 함수 include
include ("./lib.php");

// 3. DB 연결
$connect = sql_connect($db_host, $db_user, $db_pass, $db_name);


// 2. 로그인한 회원은 뒤로 보내기
if(isset($_SESSION['user_id'])){
    ?>
    <script>
        alert("로그인 하신 상태입니다.");
        history.back();
    </script>
    <?
}
// 3. 입력 HTML 출력>
?>
</center>

<br></br>
<br></br>
<br></br>
<br></br>
<br></br>
<br></br>
<br></br>
<br></br>
<br/>



<link href="css/board.css" rel="stylesheet">

<body style="background-image:url('77.png'); background-size:contain; background-repeat:no-repeat; background-color:black; background-position:center center;">
<center>

<table class="table_login">
    <tr>
        <td align="center" valign="middle" class="title" style="color:white;">로그인</td>
    </tr>
</table>

<br/>
<form name="loginForm" method="post" action="./login_chk.php" style="margin:0px; table-layout:fixed">
<table class="table_login">
    <tr>
        <td align="center" valign="middle" style="width:360px;height:50px;"><input type="text" placeholder="아이디" id="username" name="m_id" class="password_input" style="background-image:url('http://i.imgur.com/u0XmBmv.png');"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:360px;height:50px;"><input type="password" placeholder="비밀번호" id="password" name="m_pass" class="password_input"></td>
    </tr>
</table>
    <!-- 4. 로그인 버튼 클릭시 입력필드 검사 함수 login_chk 실행 -->
<table style="display:inline;">
    <tr>
        <td valign="middle" colspan="2"><input type="button" value=" 로그인 " onClick="login_chk();" class="button" style="float:left;"></td>
    </tr>
</table>
<table style="display:inline;">
	<tr>
        <td valign="middle" colspan="2"><input type="button" value=" 회원가입 " onClick="location.href='./board_register.php';" class="button" style="float:left;"></td>
    </tr>
</table>
</form>
</center>
</body>



<script>
// 5.입력필드 검사함수
function login_chk()
{
    // 6.form 지정
    var f = document.loginForm;

    // 7.입력폼 검사
    if(f.m_id.value == ""){
        // 8.값이 없으면 경고창으로 메세지 출력 후 함수 종료
        alert("아이디를 입력해 주세요.");
        return false;
    }

    if(f.m_pass.value == ""){
        alert("비밀번호를 입력해 주세요.");
        return false;
    }

    // 9.검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>
