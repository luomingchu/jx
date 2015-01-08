<?php

class GlobalController extends BaseController {


    /**
     * 对软件本身的问题反馈
     */
    public function sysSuggestion()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'content' => 'required'
            ], [
            'content.required' => '反馈内容不能为空'
            ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 保存反馈
        $suggestion = new Suggestion();
        $suggestion->member()->associate(Auth::user());
        $suggestion->content = Input::get('content');
        $suggestion->ip = Request::getClientIp();
        $suggestion->save();

        return $suggestion;
    }
}