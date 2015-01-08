<?php
use Illuminate\Support\Facades\Input;

/**
 * 指币&内购额来源控制器
 *
 * @author jois
 */
class SourceController extends BaseController
{

    /**
     * 获取key-name
     */
    public function getSources()
    {
        return Source::all();
    }
}