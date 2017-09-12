<?
//board_member_modify.php : 회원정보 수정 항목의 변수를 입력받고, 저장 코드(board_member_modify.php)로 넘긴다.
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
// 3. 입력 HTML 출력
?>
<br/>
<center>
<table style="width:320px;height:50px;border:5px #000000 solid;border-radius:5px;">
    <tr>
        <td align="center" valign="middle" style="font-size:25px;font-weight:bold;">비밀번호 수정</td>
    </tr>
</table>
</center>
<br/>
<form name="modifyForm" method="post" action="./board_member_modify_save.php" style="margin:0px;padding-left:260px;">
<center>
<table style="width:720px;height:50px;border:0px;margin-top:15px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;border-radius:5px;">비밀번호</td>
        <td  valign="middle" style="width:320px;height:50px;"><input type="password" name="m_pass" style="width:320px;height:40px;border:1px #ccc solid; border-radius:5px; background-image:url('http://i.imgur.com/Qf83FTt.png'); background-repeat:no-repeat; background-size:16px 80px; outline: none; padding: 0 20px 0 25px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;border-radius:5px;">비밀번호 확인</td>
        <td  valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass2" style="width:320px;height:40px;border:1px #ccc solid; border-radius:5px; background-image:url('http://i.imgur.com/Qf83FTt.png'); background-repeat:no-repeat; background-size:16px 80px; outline: none; padding: 0 20px 0 25px;"></td>
    </tr>
    <!-- 4. 정보수정 버튼 클릭시 입력필드 검사 함수 member_save 실행 -->
    <tr>
        <td valign="middle" colspan="2"><input type="button" value=" 정보 수정 " onClick="member_save();" style="width=100%;height:40px;background: #0FC59B; border-radius: 5px; border:#46474a; color: #fff; font-weight: bold; text-transform: uppercase; outline: none;cursor: pointer; margin-left:190px; margin-top:15px;"></td>
    </tr>
</table>
</center>
</form>

<script>
// 5.입력필드 검사함수
function member_save()
{
    // 6.form 을 f 에 지정
    var f = document.modifyForm;

    // 7.입력폼 검사

    if(f.m_pass.value == ""){
        alert("비밀번호를 입력해 주세요.");
        return false;
    }

    if(f.m_pass.value != f.m_pass2.value){
        // 8.비밀번호와 확인이 서로 다르면 경고창으로 메세지 출력 후 함수 종료
        alert("비밀번호를 확인해 주세요.");
        return false;
    }

    // 10.검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>
