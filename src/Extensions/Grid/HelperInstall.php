<?php

namespace Liumenggit\Helper\Extensions\Grid;

use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class HelperInstall extends RowAction
{
    protected $model;

    public function __construct(string $model = null)
    {
        $this->model = $model;
    }

    /**
     * 标题
     *
     * @return string
     */
    public function title()
    {
        return '安装助手';
    }

    /**
     * 设置确认弹窗信息，如果返回空值，则不会弹出弹窗
     *
     * 允许返回字符串或数组类型
     *
     * @return array|string|void
     */
    public function confirm()
    {
        return [
            // 确认弹窗 title
            "您确定安装本助手吗？",
            // 确认弹窗 content
            $this->row->name,
        ];
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return \Dcat\Admin\Actions\Response
     */
    public function handle(Request $request)
    {
//        dd($request->get('row'));
        // 获取当前行ID
        $id = $this->getKey();

        // 获取 parameters 方法传递的参数
        $model = $request->get('model');

        // 复制数据
        $model::create($request->get('row'));

        // 返回响应结果并刷新页面
        return $this->response()->success("安装成功: [{$request->get('row')['name']}]")->refresh();
    }

    /**
     * 设置要POST到接口的数据
     *
     * @return array
     */
    public function parameters()
    {
        return [
            'model' => $this->model,
            'row' => $this->row
        ];
    }
}
