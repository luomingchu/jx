<?php
/**
 * 消息控制器
 */
class MessageController extends BaseController
{

    /**
     * 获取消息列表
     */
    public function getList()
    {
        // 验证参数。
        $validator = Validator::make(Input::all(), [
            'type' => [
                'in:' . Message::TYPE_STORE . ',' . Message::TYPE_COMMUNITY . ',' . Message::TYPE_SYSTEM
            ],
            'read' => [
                'in:' . Message::READ_NO . ',' . Message::READ_YES
            ],
            'auto-tagging' => [
                'in:true,false'
            ],
            'limit' => [
                'integer',
                'between:1,200'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 获取数据。
        $messages = Auth::user()->messages()->latest('id');

        // 处理条件。
        if (Input::has('type')) {
            $messages->where('type', Input::get('type'));
        }
        if (Input::has('read')) {
            $messages->where('read', Input::get('read'));
        }

        // 取得要返回的单页数据。
        $messages = $messages->paginate(Input::get('limit', 15))->getCollection();

        // 修改此页的所有消息的已读状态。
        if (Input::get('auto-tagging', 'true') == 'true' && ! $messages->isEmpty()) {
            Message::whereIn('id', $messages->lists('id'))->update([
                'read' => Message::READ_YES
            ]);
        }

        // 强制加载关系。
        if (! $messages->isEmpty()) {
//            $messages->each(function (&$message)
//            {
//
//            });
        }

        // 返回结果。
        return $messages;
    }

    /**
     * 获取未读消息数
     */
    public function getCounter()
    {
        $result = Auth::user()->messages()->select(DB::raw("type,count(*) as num"))->where('read', Message::READ_NO)->groupBy('type')->get();

        $counter = [
            Message::TYPE_STORE => 0,
            Message::TYPE_COMMUNITY => 0,
            Message::TYPE_SYSTEM => 0
        ];
        if (! $result->isEmpty()) {
            foreach ($result as $item) {
                $counter[$item->type] = $item->num;
            }
        }

        return $counter;
    }
}