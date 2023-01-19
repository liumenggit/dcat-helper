<?php

namespace Liumenggit\Helper\Http\Controllers;

//use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

// use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;


use Liumenggit\Helper\Actions\Grid\TextActions;
use Liumenggit\Helper\Extensions\Grid\HelperInstall;
use Liumenggit\Helper\Models\Helper as Helpers;
use Liumenggit\Helper\Repositories\HelperApi;

class HelperApiController extends AdminController
{
    // use PreviewCode;

    protected $header = '大家分享';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content->header($this->header)
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($repository = null)
    {
        $grid = new Grid($repository ?: new HelperApi());
        $grid->setActionClass(TextActions::class);
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            //操作功能的禁用
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableQuickEdit();
            $actions->disableView();
        });
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->append(new HelperInstall(Helpers::class));
        });

        $grid->column('name', '名称');
        $grid->column('args', '参数')->map(function ($path) {
            return $path['key'];
        })->label();
        $grid->column('script', '代码')->limit(50);
        $grid->column('desc', '描述')->limit(50);

//        $grid->directors->pluck('name')->label('primary');
//        $grid->casts->pluck('name')->label('primary');
//        $grid->genres->label('success');

//        $grid->disableActions();
        $grid->disableBatchDelete();
        $grid->disableCreateButton();
        $grid->disableFilterButton();

        // $grid->tools($this->buildPreviewButton());

//        $grid->filter(function (Grid\Filter $filter) {
//            $cities = ['广州', '上海', '北京', '深圳', '杭州', '成都'];
//
//            collect($cities)->each(function ($v) use ($filter) {
//                $filter->scope($v, $v);
//            });
//
//            // 默认选中“广州”
//            if (!Input::has(Grid\Filter\Scope::QUERY_NAME)) {
//                Input::replace([Grid\Filter\Scope::QUERY_NAME => '广州']);
//            }
//
//        });

        return $grid;
    }
}
