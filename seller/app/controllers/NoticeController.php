<?php
/**
 * 公告模块
 */
class NoticeController extends BaseController
{

    /**
     * 获取公告列表
     */
    public function getNotice()
    {

        return Notice::where('status', Notice::STATUS_OPEN)->orderBy('sort_order', 'asc')->latest()->paginate(Input::get('limit', 10))->getCollection();
    }



    /**
     * 查看公告详情
     */
    public function getNoticeDetailView()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'notice_id' => [
                    'required',
                    'exists:'.Config::get('database.connections.own.database').'.notices,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $info = Notice::find(Input::get('notice_id'));
        return View::make('notice.info')->with(compact('info'));
    }
}