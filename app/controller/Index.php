<?php
namespace app\controller;



use app\service\Game\BotBjlService;
use app\validate\CommonValidate;
use think\exception\ValidateException;

use think\facade\BotFacade;
use think\facade\Config;
use think\GameBetting;

class Index extends BaseApiController
{

    public function index()
    {

        die;
        BotBjlService::getInstance()->Betting('zd/100&xd/40&h/80','-1001',['id'=>'5814792502']);
        die;
        $param = $this->request->only(['lang']);

        try {
            validate(CommonValidate::class)->scene('edit')->check($param);
        } catch (ValidateException $e) {
            fail([],$e->getError());
        }
        testNameModel::getInstance()->getOne(1);
        dump(1);die;
    }

    public function edit()
    {

        dump(2);die;
    }

    public function add()
    {
        dump(3);die;
    }
}
