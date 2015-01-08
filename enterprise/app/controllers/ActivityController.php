<?php

/**
 * 企业后台-活动管理控制器
 *
 * @author jois
 */
class ActivityController extends BaseController
{

    protected $activities = [
        'InnerPurchase' => '内购',
        'Presell' => '预售'
    ];

    /**
     * 活动列表
     */
    public function getList()
    {
        $body_type = Input::get('body_type');

        // 验证输入
        $validator = Validator::make(Input::all(), [
            'body_type' => [
                'required',
                'in:' . join(',', [
                    Activity::TYPE_PRESELL,
                    Activity::TYPE_INNER_PURCHASE
                ])
            ]
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::black()->withMessageError($validator->messages()
                ->first());
        }

        $data = Activity::with('body')->where('body_type', $body_type);

        // 活动名称搜索
        if (Input::has('title')) {
            $data->where('title', 'like', '%' . Input::get('title') . '%');
        }
        // 查找时间
        if (Input::has('start_date')) {
            $data->where('start_datetime', '>=', new \Carbon\Carbon(Input::get('start_date') . '00:00:00'));
        }
        if (Input::has('end_date')) {
            $data->where('end_datetime', '<=', new \Carbon\Carbon(Input::get('end_date') . '23:59:59'));
        }

        $data = $data->latest()->paginate();

        // 返回视图
        return View::make('activity.list')->withData($data)->withActivities($this->activities);
    }

    /**
     * 新增&修改活动
     */
    public function edit()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'body_type' => [
                'required',
                'in:' . implode(',', [
                    Activity::TYPE_PRESELL,
                    Activity::TYPE_INNER_PURCHASE
                ])
            ]
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::back()->withMessageError($validator->messages()->first());
        }

        // 取得要操作的活动。
        $data = Input::has('id') ? Activity::with('goods', 'groups', 'body')->find(Input::get('id')) : null;
        $group_list = [];
        $group_select = [];
        // 如果为修改活动
        if (! empty($data)) {
            if (! $data->groups->isEmpty()) {
                foreach ($data->groups as $groups) {
                    $path = $groups->path;
                    $path_ids = array_filter(explode(':', $path));
                    foreach ($path_ids as $pk => $pv) {
                        // 找出这个当前级的所有分类
                        $parent_path = Group::find($pv)->parent_path;
                        $group_list[$groups->id][$pk] = Group::whereParentPath($parent_path)->get()->toArray();
                        $group_select[$groups->id][$pk] = $pv;
                    }
                }
            }
//            $data = $data->toArray();
//            if (! empty($data['goods'])) {
//                foreach ($data['goods'] as $k=>$goods) {
//                    $data['goods'][$k]['enterprise_goods']['price'] = [];
//                    if (! empty($data['goods'][$k]['enterprise_goods']['sku'])) {
//                        $price = array_fetch($data['goods'][$k]['enterprise_goods']['sku'], 'price');
//                        sort($price);
//                        $data['goods'][$k]['enterprise_goods']['price_min'] = current($price);
//                        $data['goods'][$k]['enterprise_goods']['price_max'] = end($price);
//                    }
//                }
//            }
            if (! $data->goods->isEmpty()) {
                foreach ($data->goods as $goods) {
                    $price = $goods->enterprise_goods->sku->fetch('price')->toArray();
                    sort($price);
                    $goods->enterprise_goods->price_min = current($price);
                    $goods->enterprise_goods->price_max = end($price);
                }
            }
        }
        // 获取商品分类
        $category = GoodsCategory::where('parent_path', '')->get();

        // 获取最晚的活动时间
        $max_date = $max_time = '';
        // 获取商品内购额比率
        $inner_ratio = Configs::where('key', 'ratio_of_inner_purchase')->pluck('keyvalue');
        empty($inner_ratio) && $inner_ratio = 100;
        // 返回视图
        return View::make('activity.edit')->with(compact('data', 'category', 'group_list', 'group_select', 'max_date', 'max_time', 'inner_ratio'));
    }

    /**
     * 保存活动
     */
    public function save()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'id' => [
                'integer',
                'exists:activities,id'
            ],
            'title' => [
                'required',
                'max:140'
            ],
            'body_type' => [
                'required',
                'in:' . implode(',', [
                    Activity::TYPE_PRESELL,
                    Activity::TYPE_INNER_PURCHASE
                ])
            ],
            'start_date' => [
                'required',
                'date_format:Y/m/d'
            ],
            'start_time' => [
                'required',
                'date_format:H:i'
            ],
            'end_date' => [
                'required',
                'date_format:Y/m/d'
            ],
            'end_time' => [
                'required',
                'date_format:H:i'
            ],
            'status' => [
                'required',
                'in:' . implode(',', [
                    Activity::STATUS_OPEN,
                    Activity::STATUS_CLOSE
                ])
            ],
            'introduction' => [
                'required'
            ],
            'goods' => [
                'required',
                'array',
                'exists:enterprise_goods,id'
            ],
            'picture_id' => [
                'required',
                'exists:user_files,id'
            ],
            [
                'id.exists' => '没有相关活动信息',
                'title.required' => '活动标题不能为空',
                'title.max' => '活动标题最多为140个字符',
                'body_type.required' => '请选择活动类型',
                'body_type.in' => '选择的活动类型不正确',
                'start_date.required' => '活动开始日期不能为空',
                'start_date.date_format' => '活动开始日期格式不正确',
                'end_date.date_format' => '活动结束日期格式不正确',
                'end_date.required' => '活动结束日期不能为空',
                'start_time.required' => '活动开始时间不能为空',
                'end_time.required' => '活动结束时间不能为空',
                'start_time.date_format' => '活动开始时间格式不正确',
                'end_time.date_format' => '活动结束时间格式不正确',
                'introduction.required' => '活动简介不能为空',
                'goods.required' => '活动商品不能为空',
                'goods.exists' => '有相关活动商品不存在',
                'picture_id.required' => '活动图片不能为空',
                'picture_id.exists' => '活动图片保存出错'
            ]
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Response::make($validator->messages()->first(), 402);
        }

        // 检查活动的有效期
//        $error_message = $this->checkValid();
//        if ($error_message) {
//            return Response::make($error_message, 402);
//        }

        // 不同活动类型的额外验证。
        $error_message = $this->{'validator' . Input::get('body_type')}();
        if ($error_message) {
            return Response::make($error_message, 402);
        }

        // 取得要操作的活动。
        $activity = Input::has('id') ? Activity::find(Input::get('id')) : new Activity();

        // 不同活动类型的额外处理。
        $body = $this->{'save' . Input::get('body_type')}($activity);

        // 保存活动基本信息。
        $activity->start_datetime = new \Carbon\Carbon(Input::get('start_date') . Input::get('start_time') . ':00');
        $activity->end_datetime = new \Carbon\Carbon(Input::get('end_date') . Input::get('end_time') . ':59');
        $activity->status = Input::get('status');
        $activity->title = Input::get('title');
        $activity->introduction = Input::get('introduction');
        $activity->picture_id = Input::get('picture_id', 0);
        $activity->body()->associate($body);
        $activity->save();

        // 保存活动参与的商品列表。
        ActivitiesGoods::where('activity_id', $activity->id)->delete();
        foreach (Input::get('goods') as $goods) {
            $ag = new ActivitiesGoods();
            $ag->activity()->associate($activity);
            $ag->enterprise_goods_id = $goods;
            $ag->discount = Input::get("discount.{$goods}", 0);
            $ag->quota = Input::get("limited.{$goods}", 0);
            $ag->coin_max_use_ratio = Input::get("coin_ratio.{$goods}", 0);
            $ag->deposit = Input::get("deposit.{$goods}", 0);
            $ag->discount_price = round(EnterpriseGoods::find($goods)->price * Input::get("discount.{$goods}", 0) / 10, 2);
            $ag->brokerage_ratio = Input::get("brokerage.{$goods}", 0);
            $ag->save();
        }

        // 保存活动投放区域
        $groups = array_unique(array_filter(Input::get('groups', [])));
        if (! empty($groups)) {
            // 去除分类中有子类的父类
            foreach ($groups as $gk=>$gv) {
                $children = Group::find($gv)->childNode()->lists('id');
                $diff = array_intersect($groups, $children);
                if (! empty($diff)) {
                    unset($groups[$gk]);
                }
            }
        }
        $activity->groups()->sync($groups);

        // 返回成功消息。
        return $activity;
    }


    /**
     * 检查活动的有效性
     */
    public function checkValid()
    {
        $start = Input::get('start_date')." ".Input::get('start_time', '00:00').':00';
        if (Input::has('id')) {
            $flag = Activity::where('start_datetime', '<=', $start)->where('end_datetime', '>=', $start)->where('id', '!=', Input::get('id'))->get();
        } else {
            $flag = Activity::where('start_datetime', '<=', $start)->where('end_datetime', '>=', $start)->get();
        }
        if ($flag->isEmpty()) {
            $end = Input::get('end_date')." ".Input::get('end_time', '23:59').":59";
            if (Input::has('id')) {
                $flag = Activity::where('start_datetime', '<=', $end)->where('end_datetime', '>=', $end)->where('id', '!=', Input::get('id'))->get();
            } else {
                $flag = Activity::where('start_datetime', '<=', $end)->where('end_datetime', '>=', $end)->get();
            }
        }
        $selected_groups = [];
        // 获取选择区域所有上级及其区域
        foreach (Input::get('groups') as $group) {
            $groupInfo = Group::find($group);
            $selected_groups = array_unique(array_merge($selected_groups, array_filter(explode(':', $groupInfo->path))));
        }

        // 如果有相关活动，则过滤相关区域的已参加的商品列表
        if (! $flag->isEmpty()) {
            foreach ($flag as $activity) {
                $intersect = array_intersect($activity->groups->fetch('id')->toArray(), $selected_groups);
                if (! empty($intersect)) {
                    return '在当前时间内，选择的投放区域中已经有相关活动存在！';
                }
            }
        }

        return '';
    }


    /**
     * 验证内购活动
     */
    protected function validatorInnerPurchase()
    {
        return '';
    }

    /**
     * 保存内购活动
     */
    protected function saveInnerPurchase($activity)
    {
        $expand = new InnerPurchase();
        return $expand;
    }

    /**
     * 验证预售活动
     */
    protected function validatorPresell()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'start_settle_date' => [
                'required',
                'date_format:Y/m/d'
            ],
            'start_settle_time' => [
                'required',
                'date_format:H:i'
            ],
            'end_settle_date' => [
                'required',
                'date_format:Y/m/d'
            ],
            'end_settle_time' => [
                'required',
                'date_format:H:i'
            ],
        ]);
        return $validator->passes() ? '' : $validator->messages()->first();
    }

    /**
     * 保存预售活动
     */
    protected function savePresell($activity)
    {
        // 删除原来的预售活动信息
        if ($activity->body_id) {
            Presell::find($activity->body_id)->delete();
        }
        $expand = new Presell();
        $expand->start_settle_datetime = new \Carbon\Carbon(Input::get('start_settle_date') . Input::get('start_settle_time') . ':00');
        $expand->end_settle_datetime = new \Carbon\Carbon(Input::get('end_settle_date') . Input::get('end_settle_time') . ':00');
        $expand->save();
        return $expand;
    }


    /**
     * 开启活动
     */
    public function postOpenActivity()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'activity_id' => [
                    'required',
                    'exists:activities,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $activity = Activity::find(Input::get('activity_id'));
        $activity->status = Activity::STATUS_OPEN;
        $activity->save();

        return $activity;
    }

    /**
     * 删除活动
     */
    public function delete()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'activity_id' => [
                    'required',
                    'exists:activities,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $activity = Activity::find(Input::get('activity_id'));
        // 判断当前活动是否可删除
        if ($activity->status == Activity::STATUS_CLOSE || ($activity->status == Activity::STATUS_OPEN && strtotime($activity->end_datetime) < time())) {
            $activity->delete();
            return 'success';
        }
        return Response::make('此活动还未结束，暂时不能删除', 402);
    }


    /**
     * 检查获取区域的有效性
     */
    public function checkActivityGroupValid()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'start_date' => [
                    'required',
                    'date'
                ],
                'end_date' => [
                    'required',
                    'date'
                ],
                'start_time' => [
                    'required',
                ],
                'end_time' => [
                    'required',
                ],
                'selected_groups' => [
                    'required'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $start = Input::get('start_date')." ".Input::get('start_time', '00:00').':00';
        $end = Input::get('end_date')." ".Input::get('end_time', '23:59').":59";
        $flag = Activity::where('start_datetime', '<=', $start)->where('end_datetime', '>=', $start)->get();
        if ($flag->isEmpty()) {
            $flag = Activity::where('start_datetime', '<=', $end)->where('end_datetime', '>=', $end)->get();
        }
        // 如果选择的时间内没有相关的活动
        if ($flag->isEmpty()) {
            return 'success';
        }

        $selected_groups = Input::get('selected_groups');
        foreach ($flag as $activity) {
            $groups = $activity->groups;
            foreach ($groups as $g) {
                $group_paths = array_filter(explode(':', $g->path));

                // 判断是否新选择的区域包含此区域或是其父级区域
                $intersect = array_intersect($group_paths, $selected_groups);
                if (! empty($intersect)) {
                    $current = current($intersect);
                    if ($current == $g->id) {
                        return Response::make("在当前的时间范围内，{$g->name}已经有投放活动了，请重新选择！", 402);
                    } else {
                        $groupInfo = Group::find(current($intersect));
                        return Response::make("在当前的时间范围内，{$groupInfo->name}下的{$g->name}已经有投放活动了，请重新选择！", 402);
                    }
                }
            }
        }
        return 'success';
    }
}
