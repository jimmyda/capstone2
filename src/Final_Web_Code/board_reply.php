<?php
//board_reply.php : 글에 대해 관리자가 댓글을 단다. 관리자권한을 가진 사람만 댓글을 달 수 있다. 이 댓글의 존재 여부를 사용자 등급 결정에 반영한다.
//댓글 입력값을 입력하고 저장코드 (board_reply_save.php)에 저장한다.
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

// 6. 댓글이 가능한지 검사
// 6-1. 이 글의 단계가 몇단계 인지 검사후 2단계면 댓글 불가
if(strlen($data['b_reply']) == 2){
    ?>
    <script>
        alert("Impossible!");
        history.back();
    </script>
    <?
}

// 6-2 이글에 달린 댓글의 마지막 댓글이 몇번째인지 검사

$sql2 = "select * from board where b_num = '".$data['b_num']."' and b_reply like '".$data['b_reply']."%' order by b_reply desc limit 1";
$result2 = sql_query($sql2);
$data2 = mysqli_fetch_array($result2);

if(substr($data2['b_reply'], strlen($data['b_reply']), 1) == "Z"){
    ?>
    <script>
        alert("더이상 댓글을 쓸수가 없습니다.");
        history.back();
    </script>
    <?
}

// 7. 입력 HTML 출력
?>
<center>
<br/>
<table style="width:1000px;height:50px;border:5px #34373a solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;color:#696f75;font-weight:bold;">취약점 Software 댓글 쓰기</td>
    </tr>
</table>
<br/>
<form name="bWriteForm" method="post" action="./board_reply_save.php" style="margin:0px;">
<input type="hidden" name="b_idx" value="<?=$data['b_idx']?>">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#696f75;color:#ffffff;">글제목</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="b_title" style="width:780px;" value=""></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:200px;background-color:#696f75;color:#ffffff;">글내용</td>
        <td align="left" valign="middle" style="width:800px;height:200px;">
        <textarea name="b_contents" style="width:800px;height:200px;"></textarea>
        </td>
    </tr>
    <!-- 4. 글쓰기 버튼 클릭시 입력필드 검사 함수 write_save 실행 -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 댓글쓰기 " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" 뒤로가기 " onClick="history.back();"></td>
    </tr>
</table>
</form>
</center>
<script>
// 5.입력필드 검사함수
function write_save()
{
    // 6.form 을 f 에 지정
    var f = document.bWriteForm;

    // 7.입력폼 검사

    if(f.b_title.value == ""){
        alert("글제목을 입력해 주세요.");
        return false;
    }

    if(f.b_contents.value == ""){
        alert("글내용을 입력해 주세요.");
        return false;
    }

    // 8.검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>
