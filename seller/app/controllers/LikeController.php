<?php

/**
 * 赞模块
 */
class LikeController extends BaseController
{

    /**
     * 赞问题
     */
    public function postQuestion()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL'
            ]
        ], [
            'question_id.required' => '问题不能为空',
            'question_id.exists' => '问题不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要赞的对象。
        $data = Question::find(Input::get('question_id'));

        // 查看是否已经有赞过了，未赞过时添加赞。
        if (! $data->liked) {
            $like = new Like();
            $like->member()->associate(Auth::user());
            $like->target()->associate($data);
            $like->save();
            // 只做return显示用，数量已在添加like的模型事件中
            $data->like_count ++;
        } else {
            return Response::make('您已经赞过此问题了', 402);
        }

        // 返回赞的数量。
        return $data->like_count;
    }

    /**
     * 取消对问题的赞
     */
    public function postQuestionCancel()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL'
            ]
        ], [
            'question_id.required' => '为题不能为空',
            'question_id.exists' => '问题不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要赞的对象。
        $data = Question::find(Input::get('question_id'));

        // 查看是否已经有赞过了，已赞过了取消赞。
        $like = $data->likes()
            ->where('member_id', Auth::id())
            ->first();
        if (! is_null($like)) {
            $like->delete();
            $data->like_count --;
        } else {
            return Response::make('您没有赞过此问题，不用进行取消', 402);
        }

        // 返回赞的数量。
        return $data->like_count;
    }

    /**
     * 赞回答
     */
    public function postAnswer()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'answer_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.answers,id'
            ]
        ], [
            'answer_id.required' => '回答不能为空',
            'answer_id.exists' => '回答不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要赞的对象。
        $data = Answer::find(Input::get('answer_id'));

        // 查看是否已经有赞过了，未赞过时添加赞。
        if (! $data->liked) {
            $like = new Like();
            $like->member()->associate(Auth::user());
            $like->target()->associate($data);
            $like->save();
            $data->like_count ++;
        } else {
            return Response::make('您已经赞过此回答了', 402);
        }

        // 返回赞的数量。
        return $data->like_count;
    }

    /**
     * 取消对回答的赞
     */
    public function postAnswerCancel()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'answer_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.answers,id'
            ]
        ], [
            'answer_id.required' => '回答不能为空',
            'answer_id.exists' => '回答不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要赞的对象。
        $data = Answer::find(Input::get('answer_id'));

        // 查看是否已经有赞过了，已赞过了取消赞。
        $like = $data->likes()
            ->where('member_id', Auth::id())
            ->first();
        if (! is_null($like)) {
            $like->delete();
            $data->like_count --;
        } else {
            return Response::make('您没有赞过此回答，不用进行取消', 402);
        }

        // 返回赞的数量。
        return $data->like_count;
    }
}