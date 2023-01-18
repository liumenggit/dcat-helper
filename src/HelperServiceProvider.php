<?php

namespace Liumenggit\Helper;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Liumenggit\Helper\Models\Helper;
use Illuminate\Support\Facades\Schema;

class HelperServiceProvider extends ServiceProvider
{
    protected $js = [
        'js/index.js',
    ];
    protected $css = [
        'css/index.css',
    ];

    public function register()
    {
        //
    }

    public function init()
    {

        if (Schema::hasTable('dcat_helper')) {
            $Helpers = Helper::where('status', 1)->get();
            foreach ($Helpers as $Helper) {
                $name = $Helper->name;
                $script = $Helper->script;
                $argKey = $Helper->args ? $Helper->args : [];
                $prepped = function (...$argsValue) use ($script, $argKey) {
                    //定义变量
                    $values = "let column='" . $this->column . "';\n";
                    foreach ($argKey as $k => $v) {
                        $values = $values . "let " . $v['key'] . "='" . (array_key_exists($k, $argsValue) ? $argsValue[$k] : $v['value']) . "';\n";
                    }
                    $this->script($this->getScript() . "\n(function(){\n" . $values . "\n" . $script . "\n})();");
                    return $this;
                };
                Form\Field::macro($name, $prepped);
            }
        }
        parent::init();

    }

    protected $menu = [
        [
            'title' => '管理帮手',
            'uri' => 'helper',
            'icon' => 'fa-align-justify', // 图标可以留空
        ], [
            'title' => '获取帮手',
            'uri' => 'gethelper',
            'icon' => 'fa-align-justify', // 图标可以留空
        ]
    ];

    public function settingForm()
    {
        return new Setting($this);
    }
}
