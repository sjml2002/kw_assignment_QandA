<?php
    //대부분 model 디렉토리와 연관있는 요청
    //model폴더 페이지 이름과 데이터(JSON으로 받기) 각종 http method로 받기
    //데이터가 없거나(일부 요청만) 페이지 이름 일치하는 것이 없는 경우 예외처리
    //페이지 이동의 이름은 pageURL로
    //데이터는 웬만하면 아래 4가지 이름으로 하기
    //1.추가시킬 데이터: createData
    //2.수정시킬 데이터: updateData
    //3.삭제시킬 데이터: deleteData
    //4.조회할 데이터: searchData
    //5.그 외 데이터: 각자 기능을 알 수 있을만한 이름
    header("Content-type: application/json");
    $Data = NULL;
    if(isset($_GET['data'])){
        $Data = json_decode($_GET['data'], true);
    }
    else if(isset($_POST['data'])) {
        $Data = json_decode($_POST['data'], true);
    }
    
    //$Data가 잘 들어왔는지 확인
    function requestValidation() {
        return empty($Data) ? true : false;
    }

    try{
        if(requestValidation() === false){
            throw new exception("400");
        }
        else if($Data['pageURL'] === "LoginProcess"){ //로그인 요청
            //연결 요청에 따라 데이터 받고 보내기
            require_once("../model/LoginProcess.php");
            $result = loginProcess($Data["id"], $Data["pw"]);
            if($result){ 
                //로그인 성공
                echo "true";
            }
            else{
                //로그인 실패
                echo "false";
            }
        }
        else if($Data['pageURL'] === "SignupProcess") { //회원가입 요청
            require_once("../model/SignupProcess.php");
            $result = signupProcess($Data["id"], $Data["pw"]);
            if($result) { //회원가입 성공
                echo "true";
            }
            else {
                echo "false";
            }
        }
        else if($Data['pageURL'] === "SessionVerify") { //세션 확인
            require_once("../model/SessionVerify.php");
            $result = sessionVerify();
            if(!$result) { //세션값 비정상
                echo "false";
            }
            else{
                echo $result;
            }
        }
        else if($Data['pageURL'] === "LogoutProcess") { //로그아웃 요청
            require_once("../model/LogoutProcess.php");
            $result = logoutProcess();
            if($result) {
                echo "true";
            }
            else{
                echo "false";
            }
        }
        else{
            throw new exception("404");
        }
    } catch(exception $e){
        //XMLHttpRequest에 htttpStateCode를 response보내는 걸로 해서 view에서 처리
        if($e->getMessage() === "400"){
            header('Location: /view/errorPage/400BadRequest.html');
        }
        else if($e->getMessage() === "404"){
            header('Location: /view/errorPage/404NotFound.html');
        }
        else if($e->getMessage() === "500"){
            header('Location: /view/errorPage/500InternalServerError.html');
            //header location으로 500error페이지 만들어서 랜딩
        }
    }
?>