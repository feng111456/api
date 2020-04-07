<?php
/**返回错误信息 */
function returnErrorJson($code,$string,$statusNum){
    return response()->json(['error_code'=>$code,'msg'=>$string],$statusNum);
}
/**返回正确信息 */
function returnSucccessJson($data){
    return response()->json(['error_code'=>0,'msg'=>'ok','res'=>$data],200);
}
//检测访问令牌函数
function checkAccess_token($access_token,$time){
    $sign = "123456abc";
    $token = md5($sign.$time);
    if($access_token!=$token){
        return false;
    }
    return true;
}