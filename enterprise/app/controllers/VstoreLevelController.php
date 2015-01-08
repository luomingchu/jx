<?php
/**
 * 指店等级控制器
 */
class VstoreLevelController extends BaseController
{

    /**
     * 指店等级设置主页
     */
    public function index()
    {
        $list = VstoreLevel::orderBy('level', 'asc')->get();
        if (! $list->isEmpty()) {
            $list = $list->keyBy('level');
            $list = $list->toArray();
        }
        return View::make('vstore_level.index')->with('list', $list);
    }

    /**
     * 保存指店信息
     */
    public function postSetupLevel()
    {
        $brokerage_ratio = Input::get('brokerage_ratio');
        $trade_count = Input::get('trade_count');
        $turnover = Input::get('turnover');

        // 保存等级信息
        foreach ($brokerage_ratio as $level=>$ratio) {
            $info = VstoreLevel::where('level', $level)->first();
            empty($info) && $info = new VstoreLevel();
            $info->level = $level;
            $info->trade_count = empty($trade_count[$level]) ? 0 : $trade_count[$level];
            $info->turnover = empty($turnover[$level]) ? 0 : $turnover[$level];
            $info->brokerage_ratio = empty($brokerage_ratio[$level]) ? 0 : $brokerage_ratio[$level];
            $info->save();
        }

        return 'success';
    }
}