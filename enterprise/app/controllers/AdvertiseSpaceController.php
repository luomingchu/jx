<?php

/**
 * 广告位管理
 *
 */
class AdvertiseSpaceController extends BaseController
{

    /**
     * 广告位列表
     */
    public function getList()
    {
        return View::make('advertise-space.list')->withList(AdvertiseSpace::latest()->paginate(10));
    }

    /**
     * 编辑广告位
     */
    public function getEdit($id = 0)
    {
        return View::make('advertise-space.edit')->withData(AdvertiseSpace::find($id));
    }

    /**
     * 保存编辑
     */
    public function postSave()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), array(
            'name' => array(
                'required',
                'max:255',
                'unique:advertise_spaces,name,'.Input::get('id').',id,deleted_at,null',
            ),
            'key_code' => array(
                'required',
                'regex:/^[\w\d_]+$/',
                'unique:advertise_spaces,key_code,'.Input::get('id').',id,deleted_at,null',
            ),
            'width' => array(
                'required',
                'numeric',
                'min:1'
            ),
            'height' => array(
                'required',
                'numeric',
                'min:1'
            ),
            'limit' => array(
                'numeric',
                'min:0'
            ),
            'remark' => array(
                'max:255'
            ),
        ),
            [
                'name.required' => '广告位名称不能为空',
                'name.max' => '广告位名称不能超过255个字符',
                'name.unique' => '已经有相关的广告位了，请重新输入',
                'key_code.required' => '广告位标识符不能为空',
                'key_code.regex' => '广告位标识符只能由数组、字符和下划线组成',
                'key_code.unique' => '已经有相关的广告位标识了',
                'with.required' => '广告位图片的宽度不能为空',
                'with.numeric' => '广告位图片的宽度只能是数字字符',
                'height.required' => '广告位图片的高度不能为空',
                'height.numeric' => '广告位图片的高度只能是数字字符',
                'limit:numeric' => '广告位广告容量只能是数字字符'
            ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要保存的对象。
        $advertise_space = AdvertiseSpace::findOrNew(Input::get('id', 0));
        // 填充提交的数据。
        $advertise_space->name = Input::get('name');
        $advertise_space->key_code = Input::get('key_code');
        $advertise_space->width = Input::get('width');
        $advertise_space->height = Input::get('height');
        $advertise_space->limit = Input::get('limit', 0);
        $advertise_space->remark = Input::get('remark', '');
        $advertise_space->template = Input::get('template', '');

        // 保存数据。
        $advertise_space->save();
        return $advertise_space;
    }

    /**
     * 删除广告位
     */
    public function postDelete()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'advertise_space_id' => [
                    'required',
                    'exists:advertise_spaces,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        AdvertiseSpace::find(Input::get('advertise_space_id'))->delete();
        return 'success';
    }
}
