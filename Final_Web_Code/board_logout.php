<?
//board_logout.php : 사이트에서 로그아웃한다.
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 모든 세션값을 빈값으로 
//$_SESSION['user_idx'] = 0;
//$_SESSION['user_id']) = 0
//$_SESSION['user_name'] = 0;

session_unset();

?>
<script>
alert(" 로그아웃 되었습니다. ");
location.replace("board_login.php");
</script>
