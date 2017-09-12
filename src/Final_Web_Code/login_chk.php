<?php
//login_chk.php : 로그인 버튼 누를 시, 로그인 가능한 상태인지 확인한다.
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인한 회원은 뒤로 보내기
if(isset($_SESSION['user_id'])){
    ?>
    <script>
        alert("로그인 하신 상태입니다 check");
        history.back();
    </script>
    <?
}

// 3. 넘어온 변수 검사
if(trim($_POST['m_id']) == ""){
    ?>
    <script>
        alert("아이디를 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

if($_POST['m_pass'] == ""){
    ?>
    <script>
        alert("비밀번호를 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

// 4. 같은 아이디가 있는지 검사
$chk_sql = "select * from user_info where m_id = '".trim($_POST['m_id'])."'";
$chk_result = sql_query($chk_sql);
$chk_data = mysqli_fetch_array($chk_result);

// 5. 아이디가 존재 하는 경우
if($chk_data['m_idx']){

    // 5. 입력된 비밀번호와 저장된 비밀번호가 같은지 비교해서
    if($_POST['m_pass'] == $chk_data['m_pass']){
        // 6. 비밀번호가 같으면 세션값 부여 후 이동
        $_SESSION['user_idx'] = $chk_data['m_idx'];
        $_SESSION['user_id'] = $chk_data['m_id'];
        $_SESSION['user_name'] = $chk_data['m_name'];

        ?>
        <script>
        alert("환영합니다.");
        location.replace("../UI/home.html");
        </script>
        <?
        exit;
    }else{
        // 7. 비밀번호가 다르면
        ?>
        <script>
            alert("비밀번호가 다릅니다.");
            history.back();
        </script>
        <?
        exit;
    }
}else{
    // 8. 아이디가 존재하지 않으면
    ?>
    <script>
        alert("존재하지 않는 회원입니다.");
        history.back();
    </script>
    <?
    exit;
}
?>
