<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Email;
use app\common\model\Buy;
use app\common\model\Sell;
use think\Validate;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $this->redirect(url('sell'));
    }

    public function sell()
    {
        if (request()->isPost()) {
            $post = input('post.');

            $data = [
                'money'        => $post['money'],
                'bank_type'    => $post['bank_type'],
                'bank_account' => $post['bank_account'],
                'bank_card'    => $post['bank_card'],
                'bank_branch'  => $post['bank_branch'],
                'money_num'    => $post['money_num'],
                'money_count'    => $post['money_count'],
            ];

            if ($post['money_type'] == 1) {
                $data['money'] = 1000;
            }

            // 检查重复
            $info = (new Sell())->where($data)->order('id desc')->find();
            if (!empty($info) && $info['createtime'] > (time() - 10*60)) {
                $this->error('不要重复提交');
            }

            $data['ip'] = request()->ip();
            $user = new Sell($data);
            // 过滤post数组中的非数据表字段数据
            $user->allowField(true)->save();

            Email::instance()->to(config('site.email'))
                ->subject('收到新的订单')
                ->message("收到出售新的订单 金额：" . $data['money'])->send();

            $this->success();
        }
        return $this->fetch();
    }

    public function buy()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if ($data['money_type'] == 1) {
                $data['money'] = 1000;
            }
            if (!Validate::is($data['address'], '/^T[A-Za-z0-9]{33}$/')) {
                $this->error(__("请输入正确地址"));
            }
                    
            $data['ip'] = request()->ip();
            $user = new Buy($data);
            // 过滤post数组中的非数据表字段数据
            $user->allowField(true)->save();

            Email::instance()->to(config('site.email'))
                ->subject('收到新的订单')
                ->message("收到购买新的订单 金额：" . $data['money'])->send();

            $this->success();
        }
        return $this->fetch();
    }
}
