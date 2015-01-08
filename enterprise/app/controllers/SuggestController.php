<?php
use Illuminate\Http\Response;
use Carbon\Carbon;

/**
 * 用户对商品的建议信息
 *
 * @author jois
 */
class SuggestController extends BaseController
{

    /**
     * 建议列表
     */
    public function getList()
    {
        $data = Suggest::latest()->paginate(15);
        if (Input::has('name')) {
            $name = Input::get('name');
            $data = Suggest::where('content', 'like', "%{$name}%")->latest()->paginate(15);
        }

        // 返回视图
        return View::make('suggest.list')->withData($data);
    }

    /**
     * 编辑建议，提出备注
     */
    public function edit($id = 0)
    {
        // 返回视图
        return View::make('suggest.edit')->withData(Suggest::find($id));
    }

    /**
     * 保存备注后的建议
     */
    public function save()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), array(
            'id' => 'exists:suggest,id',
            'remark' => 'required'
        ), array(
            'id.exists' => '保存的建议信息不存在！',
            'remark.required' => '备注不能为空！'
        ));

        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            Input::flash();
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        // 取得要保存的对象。
        $suggest = Input::has('id') ? Suggest::find(Input::get('id')) : new Suggest();

        // 保存数据。
        $suggest->remark = trim(Input::get('remark'));
        $suggest->remark_time = new Carbon();
        $suggest->save();

        return Redirect::route("SuggestList")->withMessageSuccess('保存成功');
    }
}
