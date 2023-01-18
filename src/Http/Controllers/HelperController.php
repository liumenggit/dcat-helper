<?php

namespace Liumenggit\Helper\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;
use Liumenggit\Helper\Actions\Grid\TextActions;
use Liumenggit\Helper\Extensions\Grid\ExportJson;
use Liumenggit\Helper\Http\Repositories\Helper;
use Liumenggit\Helper\Models\Helper as Helpers;

class HelperController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Helper(), function (Grid $grid) {
            $grid->setActionClass(TextActions::class);
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                //操作功能的禁用
//                $actions->disableDelete();
//                $actions->disableEdit();
                $actions->disableQuickEdit();
                $actions->disableView();
            });
            $grid->toolsWithOutline(false); //列表主题反向
            $grid->disableRowSelector(); //禁用行选择器
            $grid->disableFilterButton(); //禁用过滤器按钮

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                // append一个操作
                $actions->append(new ExportJson(Helpers::class));
            });
//            $grid->export();
//            $grid->column('id')->sortable();
            $grid->column('name', '名称');
            $grid->column('args', '参数')->map(function ($path) {
                return $path['key'];
            })->label();
            $grid->column('desc', '描述')->limit(50);
            $grid->status('状态')->switch();
//            $grid->column('created_at');
//            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Helper(), function (Form $form) {
            $form->footer(function ($footer) {
                // 去掉`重置`按钮
                $footer->disableReset();
                // 去掉`查看`checkbox
                $footer->disableViewCheck();
                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();
                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();
            });

            $form->tools(function (Form\Tools $tools) {
                // 去掉跳转列表按钮
//                $tools->disableList();
                // 去掉跳转详情页按钮
                $tools->disableView();
                // 去掉删除按钮
                $tools->disableDelete();
            });

            $form->text('name')->updateRules('required|regex:/^\w+$/', [
                'regex' => '只允许英文',
            ]);
            $form->table('args', '参数', function (NestedForm $table) {
                $table->text('key', '键名');
                $table->text('value', '默认值');
                $table->text('desc', '描述');
            })->help('请注意参数顺序');

            $form->ace('script', '代码')->help('column为当前标签名；在代码中直接访问参数名即可获取值；');

            $form->text('desc', '描述');
            $form->switch('status', '状态');
            $form->confirm('您确定要提交表单吗？', '修改信息将影响已经使用的公共方法！');

//            $form->display('created_at');
//            $form->display('updated_at');
        });
    }
}
