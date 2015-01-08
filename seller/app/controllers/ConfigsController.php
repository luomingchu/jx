<?php
use Illuminate\Support\Facades\Input;

/**
 * 系统参数控制器
 *
 * @author jois
 */
class ConfigsController extends BaseController
{

    /**
     * 获取key-value键+值的系统参数
     */
    public function getConfigs()
    {
        // 返回参数模型
        return Configs::all();
    }
}