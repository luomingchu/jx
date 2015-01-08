<?php

/**
 * 收藏模块
 *
 * @author Latrell Chan
 *
 */
class FavoriteController extends BaseController
{

    /**
     * 问题的收藏列表
     */
    public function getQuestionList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $favorites = Question::with('member', 'pictures')->whereHas('favorites', function ($q)
        {
            $q->where('member_id', Auth::id());
        });
        if (Input::has('title')) {
            $title = trim(Input::get('title'));
            $favorites = $favorites->where('title', 'like', "%{$title}%");
        }

        return $favorites->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }

    /**
     * 收藏的指店列表
     */
    public function getVstoreList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $favorites = Vstore::with('store', 'member')->whereHas('favorites', function ($q)
        {
            $q->where('member_id', Auth::id());
        });
        if (Input::has('name')) {
            $name = trim(Input::get('name'));
            $favorites = $favorites->where('name', 'like', "%{$name}%");
        }

        return $favorites->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }

    /**
     * 商品的收藏列表
     */
    public function getGoodsList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 收藏加了指店id 后，用商品模型找出搜藏的商品，会找到对应所有的搜藏记录
       /*  $favorites = Goods::whereHas('favorites', function ($q)
        {
            $q->where('member_id', Auth::id());
        });

         if (Input::has('name')) {
            $name = trim(Input::get('name'));
            $favorites = $favorites->where('name', 'like', "%{$name}%");
        }
        */

        $favorites = Favorite::with('favorites','vstore','member')->where('favorites_type', 'Goods')->where('member_id', Auth::id());


        return $favorites->latest()
                    ->paginate(Input::get('limit', 15))
                    ->getCollection();
    }

    /**
     * 增加问题收藏
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
            'question_id.required' => '收藏的问答不能为空',
            'question_id.exists' => '收藏的问答不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要收藏的对象。
        $data = Question::find(Input::get('question_id'));

        // 检查当前用户是否已收藏。
        if (! $data->favorited) {
            // 增加收藏到用户。
            $favorite = new Favorite();
            $favorite->favorites()->associate($data);
            $favorite->member()->associate(Auth::user());
            $favorite->save();
            // 增加指店商品的收藏数
            // $data->increment('favorite_count');
        }

        // 返回成功信息。
        return 'success';
    }

    /**
     * 删除问题收藏
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
            'question_id.required' => '收藏的问答不能为空',
            'question_id.exists' => '收藏的问答不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要收藏的对象。
        $data = Question::find(Input::get('question_id'));

        // 检查当前用户是否已收藏。
        if ($data->favorited) {
            // 增加问题收藏到用户。
            // 取消收藏到用户。
            $data->favorites()
                ->where('member_id', Auth::user()->id)
                ->delete();
            // 减少指店商品的收藏数
            // $data->decrement('favorite_count');
        }

        // 返回成功信息。
        return 'success';
    }

    /**
     * 增加指店收藏
     */
    public function postVstore()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'vstore_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
            ]
        ], [
            'vstore_id.required' => '收藏的指店不能为空',
            'vstore_id.exists' => '收藏的指店不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要收藏的对象。
        $data = Vstore::find(Input::get('vstore_id'));

        // 检查当前用户是否已收藏。
        if (! $data->favorited) {
            // 增加收藏到用户。
            $favorite = new Favorite();
            $favorite->favorites()->associate($data);
            $favorite->member()->associate(Auth::user());
            $favorite->save();
            // 增加指店商品的收藏数
            // $data->increment('favorite_count');
        }

        // 返回成功信息。
        return 'success';
    }

    /**
     * 删除指店收藏
     */
    public function postVstoreCancel()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'vstore_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
            ]
        ], [
            'vstore_id.required' => '收藏的指店不能为空',
            'vstore_id.exists' => '收藏的指店不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要收藏的对象。
        $data = Vstore::find(Input::get('vstore_id'));

        // 检查当前用户是否已收藏。
        if ($data->favorited) {
            // 增加问题收藏到用户。
            // 取消收藏到用户。
            $data->favorites()
                ->where('member_id', Auth::user()->id)
                ->delete();
            // 减少指店商品的收藏数
            // $data->decrement('favorite_count');
        }

        // 返回成功信息。
        return 'success';
    }

    /**
     * 增加指店商品收藏
     */
    public function postGoods()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'goods_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.goods,id,deleted_at,NULL,status,' . Goods::STATUS_OPEN,
            'vstore_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
        ], [
            'goods_id.required' => '请指定要收藏的商品',
            'goods_id.exists' => '收藏的商品不存在',
            'vstore_id.required' => '请指定该商品的所属指店',
            'vstore_id.exists' => '商品的所属指店不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要收藏的商品
        $data = Goods::whereId(Input::get('goods_id'))->whereStoreId(Vstore::find(Input::get('vstore_id'))->store_id)
            ->whereStatus(Goods::STATUS_OPEN)
            ->first();
        if (is_null($data)) {
            return Response::make('参数错误[此商品不属于该指店]，或该商品已下架', 402);
        }

        // 检查当前用户是否已收藏。
        if (! $data->favorited) {
            // 增加收藏到用户。
            $favorite = new Favorite();
            $favorite->favorites()->associate($data);
            $favorite->member()->associate(Auth::user());
            $favorite->vstore_id = Input::get('vstore_id');
            $favorite->save();
            // 增加指店商品的收藏数
            $data->increment('favorite_count');
        }

        // 返回成功信息。
        return 'success';
    }

    /**
     * 删除指店商品收藏
     */
    public function postGoodsCancel()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'goods_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods,id'
            ]
        ], [
            'goods_id.required' => '请指定要取消收藏的商品',
            'goods_id.exists' => '取消收藏的商品不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要收藏的对象。
        $data = Goods::find(Input::get('goods_id'));

        // 检查当前用户是否已收藏。
        if ($data->favorited) {
            // 取消收藏到用户。
            $data->favorites()
                ->where('member_id', Auth::user()->id)
                ->delete();
            // 减少指店商品的收藏数
            $data->decrement('favorite_count');
        }

        // 返回成功信息。
        return 'success';
    }
}
