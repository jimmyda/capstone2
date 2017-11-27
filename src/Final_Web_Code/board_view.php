<?
//board_view.php : 목록의 글 제목 클릭 시, 글을 보여준다.
// 1. 공통 인클루드 파일 
include ("./include.php");

// 2. 글 데이터 불러오기
$sql = "select * from board where b_idx = '".$_GET['b_idx']."'";
$result = sql_query($sql);
$data = mysqli_fetch_array($result);
$admin = "SOFA";

// 3. 글이 없으면 메세지 출력후 되돌리기
if(!$data['b_idx']){
    ?>
    <script>
        alert("존재하지 않는 글입니다.");
        history.back();
    </script>
    <?
}
// 4. 출력 HTML 출력
?>

<link href="css/board.css" rel="stylesheet">


<center>
<br/>
<table style="width:500px;height:50px;border:5px #000000 solid;border-radius:5px;">
    <tr>
        <td align="center" valign="middle" class="title">글 보기</td>
    </tr>
</table>
<br/>
<table cellspacing="1" class="table" style="background-color:#999999;">
    <tr>
        <td align="center" valign="middle" class="title_table">글제목</td>
        <td align="left" valign="middle" class="content_table"><?=$data['b_title']?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" class="title_table">작성자</td>
        <td align="left" valign="middle" class="content_table"><?=$data['m_name']?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" class="title_table">작성일</td>
        <td align="left" valign="middle" class="content_table"><?=substr($data['b_regdate'],0,10)?></td>
    </tr>
    <tr> 
        <td align="center" valign="middle" class="title_table">글내용</td>
        <td align="left" valign="top" class="content_table"><?=nl2Br($data['b_contents'])?></td>
    </tr>
     <tr> 
        <td align="center" valign="middle" class="title_table">첨부파일</td>
       <!-- <td align="left" valign="top" style="width:800px;background-color:#FFFFFF;padding:5px;"><?=nl2Br($data['b_file'])?></td>-->
    </tr>
    

    
</table>
<br/>
<table style="width:1000px;height:50px;">
    <tr>
        <td align="center" valign="middle">
        <input type="button" value=" 목록 " class="button_basic" onClick="location.href='./board_list.php?page=<?=$_GET['page']?>';">
        <?// 5. 로그인 한 경우면 글쓰기,댓글쓰기 버튼 보여주기?>
        <?if(isset($_SESSION['user_id'])){?>
        &nbsp;&nbsp;<input type="button" value=" 글쓰기 " class="button_basic" onClick="location.href='./board_write.php';">
        &nbsp;&nbsp;<input type="button" value=" 댓글쓰기 " class="button_basic" onClick="location.href='./board_reply.php?b_idx=<?=$data['b_idx']?>';">
        <?}?>
        <?// 6. 자신의 글일 경우, 삭제하기 버튼 보여주기?>
        <?if($_SESSION['user_id'] == $data['m_id']){?>
        &nbsp;&nbsp;<input type="button" value=" 삭제하기 " class="button_basic" onClick="board_delete('<?=$data['b_idx']?>');">
        <?}?>
		<?if($_SESSION['user_id'] == $admin){?>
        &nbsp;&nbsp;<input type="button" value=" 관리자:데이터베이스에 저장 " class="button_basic" onClick="board_admin('<?=$data['b_idx']?>');">
        <?}?>
        </td>
    </tr>
</table>
	
<script>
function board_delete(b_idx)
{
    if(confirm('댓글을 포함한 글을 삭제 하시겠습니까?')){
        location.href='./board_delete.php?b_idx=' + b_idx;
    }
}
function board_admin(b_idx)
{
	if(confirm('[관리자] DB(good_board)에 저장 하시겠습니까?')){
		location.href='./board_admin.php?b_idx=' + b_idx;
	}
}
</script>
</center>
