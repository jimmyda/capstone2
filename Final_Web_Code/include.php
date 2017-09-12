<?
//include.php : include함수. 데이터베이스에 연결한다.
// 1. 세션사용을 위한 초기화
session_start();

// 2. 사용자 정의 함수 include
include ("./lib.php");
include ("../UI/header.html");
// 3. DB 연결
$connect = sql_connect($db_host, $db_user, $db_pass, $db_name);

// 4. head 부분 
?>

