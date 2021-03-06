<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\UserPoint;

class UserPointController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function userPointList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('type', null) !== null){$data['type'] = $request->input('type');};
        $data['user_id'] = Token::$uid;
        
        $res = UserPoint::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加积分明细
    public function userPointAdd(Request $request)
	{
        //参数
        $data['type'] = $request->input('type',null);
        $data['point'] = $request->input('point',null);
        $data['des'] = $request->input('des',null);
        if($request->input('user_point', null) !== null){$data['user_point'] = $request->input('user_point');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['type']===null || $data['point']===null || $data['des']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserPoint::add($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}