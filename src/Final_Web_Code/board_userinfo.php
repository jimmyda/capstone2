<?
//board_userinfo.php
// 1. 공통 인클루드 파일 
// 2. 사용자 정의 함수 include

include ("./include.php");
include ("../UI/board_userinfo_top.html");

$sql = "select * from user_info where m_id = '".$_SESSION['user_id']."'";
$result = sql_query($sql);
$data = mysqli_fetch_array($result);
$finder = "1";
$goodfinder = "3";


// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if((isset($_SESSION['user_id']))==false){
    ?>
    <script>
        alert("로그인 하셔야 합니다.");
        location.replace("board_login.php");
    </script>
    <?
}
// 3. 입력 HTML 출력
?>
<center>

<table cellspacing="1" align="center" style="width:500px;height:100px;border:0px;background-color:#999999;">
	<tr>
        <td align="center" valign="middle" style="width:200px;background-color:#696f75;color:#ffffff;">아이디</td>
        <td align="left" valign="middle" style="width:800px;background-color:#FFFFFF;padding:5px;"><?=$data['m_id']?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;background-color:#696f75;color:#ffffff;">이름</td>
        <td align="left" valign="middle" style="width:800px;background-color:#FFFFFF;padding:5px;"><?=$data['m_name']?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;background-color:#696f75;color:#ffffff">Good 게시물 갯수</td>
		<td align="left" valign="middle" style="width:800px;background-color:#FFFFFF;padding:5px;"><?=$data['goodboard']?></td>
		
		<small>* Good 게시물이란 커뮤니티 게시판에 올린 사용자의 글 중 관리자가 선택한 게시물을 의미합니다.</small>
 	</tr>

</table>
<br></br>

	<input type="button" value = " Modify Password " style="width=100%;height:40px;background: #0FC59B; border-radius: 5px; border: #46474a; color: #fff; font-weight: bold; text-transform: uppercase; outline: none;cursor: pointer;" onClick="location.href='./board_member_modify.php';">
	<input type="button" value = " Logout " style="width=100%;height:40px;background: #0FC59B; border-radius: 5px; border:#46474a; color: #fff; font-weight: bold; text-transform: uppercase; outline: none;cursor: pointer; margin-left:5px" onClick="location.href='./board_logout.php';">

</center>

<?

include ("../UI/footer.html");

?>




