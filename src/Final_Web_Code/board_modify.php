<?
//board_modify.php : 자신이 쓴 글을 수정한다. 수정 입력값 입력 후, 저장코드(board_modify_save.php)로 넘긴다.
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

// 3. 글 데이터 불러오기
$sql = "select * from board where b_idx = '".$_GET[b_idx]."'";
$result = sql_query($sql);
$data = mysqli_fetch_array($result);

// 4. 글이 없으면 메세지 출력후 되돌리기
if(!$data[b_idx]){
    ?>
    <script>
        alert("존재하지 않는 글입니다.");
        history.back();
    </script>
    <?
}

// 5. 본인의 글이 아니면 메세지 출력후 되돌리기
if($data[m_id] != $_SESSION[user_id]){
    ?>
    <script>
        alert("본인의 글이 아닙니다.");
        history.back();
    </script>
    <?
}

// 5. 입력 HTML 출력
?>
<br/>
<table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">글 수정</td>
    </tr>
</table>
<br/>
<form name="bWriteForm" method="post" action="./board_modify_save.php" style="margin:0px;">
<input type="hidden" name="b_idx" value="<?=$data[b_idx]?>">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">글제목</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="b_title" style="width:780px;" value="<?=$data[b_title]?>"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:200px;background-color:#CCCCCC;">글내용</td>
        <td align="left" valign="middle" style="width:800px;height:200px;">
        <textarea name="b_contents" style="width:800px;height:200px;"><?=$data[b_contents]?></textarea>
        </td>
    </tr>
    <!-- 4. 글쓰기 버튼 클릭시 입력필드 검사 함수 write_save 실행 -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 글수정 " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" 뒤로가기 " onClick="history.back();"></td>
    </tr>
</table>
</form>
<script>
// 5.입력필드 검사함수
function write_save()
{
    // 6.form 지정
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
