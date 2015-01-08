<?php
/**
 * 会员等级控制器
 */
class LevelController extends BaseController
{

    /**
     * 设置等级信息
     */
    public function index()
    {
        $level = Level::where('level', 1)->first();
        if (empty($level)) {
            $level = new Level();
            $level->level = 1;
            $level->trade_count = 0;
            $level->turnover = 0;
            $level->coin = 0;
            $level->insource = 0;
            $level->save();
        }
        $list = Level::orderBy('level', 'asc')->get();
        if (! $list->isEmpty()) {
            $list = $list->keyBy('level');
            $list = $list->toArray();
        }
        return View::make('level.index')->with('list', $list);
    }

    /**
     * 开启指定的会员等级
     */
    public function getOpenLevel()
    {
        if (! Input::has('level') || ! in_array(Input::get('level'), range(1, 4))) {
            return Redirect::route('ManageMemberLevel')->withMessageError('请选择要开启的(V1~V4)会员等级');
        }
        $info = Level::where('level', Input::get('level'))->first();
        if (empty($info)) {
            $info = new Level();
            $info->level = Input::get('level');
            $info->trade_count = 0;
            $info->turnover = 0;
            $info->coin = 0;
            $info->insource = 0;
            $info->save();
        }
        return Redirect::route('ManageMemberLevel');
    }

    /**
     * 保存指店信息
     */
    public function postSetupLevel()
    {
        $trade_count = Input::get('trade_count');
        $turnover = Input::get('turnover');
        $coin = Input::get('icon');
        $insource = Input::get('insource');

        $list = Level::all();
        // 保存等级信息
        foreach ($list as $level) {
            $level->turnover = $turnover[$level->level];
            $level->trade_count = $trade_count[$level->level];
            $level->coin = $coin[$level->level];
            $level->insource = $insource[$level->level];
            $level->save();
        }
        return 'success';
    }
}