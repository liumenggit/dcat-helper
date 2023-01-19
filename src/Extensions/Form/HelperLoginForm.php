<?php

namespace Liumenggit\Helper\Extensions\Form;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class HelperLoginForm extends Form
{
    // 处理表单提交请求
    public function handle(array $input)
    {

//        $this->response()->error('Your error message.');
        $this->response()->success('Processed successfully.')->refresh();

        return ['status' => 1, 'message' => '消息'];
    }

    protected function savedScript()
    {
        return <<<JS
        // data 为接口返回数据
        if (! data.status) {
            Dcat.error(data.message);

            return false;
        }
        sessionStorage.setItem("key","windows");
        Dcat.success(data.message);

        if (data.redirect) {
            Dcat.reload(data.redirect)
        }

        // 中止后续逻辑（默认逻辑）
        return false;
JS;
    }

    // 构建表单
    public function form()
    {
        // Since v1.6.5 弹出确认弹窗
        $this->confirm('您确定要提交表单吗', 'content');

        $this->email('email')->rules('email')->required();
        $this->password('password')->required();
        $this->switch('register', '注册');
    }

    /**
     * 返回表单数据，如不需要可以删除此方法
     *
     * @return array
     */
    public function default()
    {
        return [
            'name' => '',
            'email' => '',
        ];
    }
}
