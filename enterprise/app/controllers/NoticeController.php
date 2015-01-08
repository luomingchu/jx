<?php
/**
 * 公告控制器
 */
class NoticeController extends BaseController
{

    /**
     * 添加公告
     */
    public function getEdit()
    {
        $notice_info = [];
        if (Input::has('notice_id')) {
            $notice_info = Notice::find(Input::get('notice_id'));
        }
        return View::make('notice.edit')->with('info', $notice_info);
    }

    /**
     * 保存公告信息
     */
    public function postSave()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'notice_id' => [
                    'exists:notices,id'
                ],
                'title' => [
                    'required',
                ],
                'kind' => [
                    'required',
                    'in:'.Notice::KIND_PIC.','.Notice::KIND_TEXT,
                ],
                'content' => [
                    'required'
                ],
                'picture_id' => [
                    'required_if:kind,'.Notice::KIND_PIC
                ],
                'sort_order' => [
                    'integer',
                    'min:0'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $notice_info = Input::has('notice_id') ? Notice::find(Input::get('notice_id')) : new Notice();
        $notice_info->title = Input::get('title');
        $notice_info->kind = Input::get('kind');
        $notice_info->picture_id = Input::get('picture_id', 0);
        $notice_info->content = Input::get('content');
        $notice_info->status = Input::get('status', Notice::STATUS_OPEN);
        $notice_info->sort_order = Input::get('sort_order', 100);
        $notice_info->save();

        return $notice_info;
    }


    /**
     * 获取公告列表
     */
    public function getList()
    {
        $list = Notice::orderBy('sort_order', 'asc');
        if (Input::has('title')) {
            $list->where('title', 'like', "%".Input::get('title')."%");
        }
        if (Input::has('status')) {
            $list->where('status', Input::get('status'));
        }
        $list = $list->latest()->paginate(Input::get('limit', 10));
        return View::make('notice.list')->with('list', $list);
    }

    /**
     * 切换公告状态
     */
    public function postToggleStatus()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'notice_id' => [
                    'required',
                    'exists:notices,id'
                ],
                'status' => [
                    'required',
                    'in:'.Notice::STATUS_OPEN.','.Notice::STATUS_CLOSE
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $notice_info = Notice::find(Input::get('notice_id'));
        if (Input::get('status') == Notice::STATUS_OPEN) {
            $notice_info->status = Notice::STATUS_CLOSE;
        } else {
            $notice_info->status = Notice::STATUS_OPEN;
        }
        $notice_info->save();

        return 'success';
    }

    /**
     * 删除公告
     */
    public function postDeleteNotice()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'notice_id' => [
                    'required',
                    'exists:notices,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 删除公告
        $notice_id = (array)Input::get('notice_id');
        Notice::whereIn('id', $notice_id)->delete();

        return 'success';
    }
}