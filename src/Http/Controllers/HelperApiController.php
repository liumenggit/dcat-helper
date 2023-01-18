<?php

namespace Liumenggit\Helper\Http\Controllers;

//use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

// use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;


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

        $grid->number();
        $grid->title->display(function ($v) {
            $v = '豆瓣API已停止对外开放...';

            return sprintf('<a href="%s" target="_blank"><i>《%s》</i></a>', $this->alt, $v);
        });
        $grid->images->first()->image('', 100);
        $grid->year;
        $grid->rating->display(function ($v) {
            $style = '';
            $color = Admin::color();

            if ($v < 3) {
                $style = $color->alpha('primary', 0.4);
            } elseif ($v >= 3 && $v < 7) {
                $style = $color->alpha('primary', 0.6);
            } elseif ($v >= 7 && $v < 8) {
                $style = $color->alpha('primary', 0.8);
            } elseif ($v >= 8 && $v < 9) {
                $style = $color->primary();
            } elseif ($v >= 9) {
                $style = $color->primaryDarker();
            }

            return "<span class='badge' style='background:$style;color:#fff'>$v</span>";
        });
        $grid->directors->pluck('name')->label('primary');
        $grid->casts->pluck('name')->label('primary');
        $grid->genres->label('success');

        $grid->disableActions();
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
