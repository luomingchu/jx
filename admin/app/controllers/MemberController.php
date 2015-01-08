<?php
use Carbon\Carbon;

class MemberController extends BaseController
{

    /**
     * 会员列表
     */
    public function showList()
    {
        $data = Member::paginate();
        return View::make('member.list')->withData($data);
    }

    /**
     * 待审核实名列表
     */
    public function showRealNameList()
    {
        $data = Member::where('real_name_status', Member::REANNAME_STATUS_PENDING)->paginate();
        return View::make('member.realname.list')->withData($data);
    }

    /**
     * 显示会员的实名信息资料
     */
    public function showRealNameInfo()
    {
        $member = Member::find(Input::get('id'));
        if (is_null($member)) {
            return Redirect::back()->withMessageError('会员不存在。');
        }
        return View::make('member.realname.info')->withData($member);
    }

    /**
     * 实名审核
     */
    public function postRealNameVerify()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'integer',
                'exists:members,id,deleted_at,NULL,real_name_status,' . Member::REANNAME_STATUS_PENDING
            ],
            'real_name_status' => [
                'required',
                'in:' . Member::REANNAME_STATUS_APPROVED . ',' . Member::REANNAME_STATUS_UNAPPROVED
            ]
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        // 取出真实名称
        $real_name = RealName::where('member_id', Input::get('id'))->first()->name;

        // 审核操作。
        $member = Member::find(Input::get('id'));
        $member->real_name = $real_name;
        $member->real_name_status = Input::get('real_name_status');
        $member->save();
        return Redirect::route('RealNameList')->withMessageSuccess(sprintf('成功 %s %s 的实名申请。', Input::get('real_name_status') == Member::REANNAME_STATUS_APPROVED ? '通过' : '驳回', $member->realname->name));
    }

    /**
     * 反馈信息列表
     */
    public function showSuggestionsList()
    {
        $data = Suggestion::paginate();
        return View::make('member.suggestion.list')->withData($data);
    }

    /**
     * 添加备注
     */
    public function editSuggestionsRemark()
    {
        $data = Suggestion::with('member')->find(Input::get('id'));
        return View::make('member.suggestion.edit')->withData($data);
    }

    /**
     * 反馈信息加备注处理
     */
    public function saveSuggestionRemark()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => 'required|integer|exists:suggestions,id',
            'remark' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withMessageError($validator->messages()
                ->first())
                ->withInput();
        }

        // 审核操作。
        $suggestion = Suggestion::with('member.avatar')->find(Input::get('id'));
        $suggestion->remark = Input::get('remark');
        $suggestion->remark_time = new Carbon();
        $suggestion->save();
        return Redirect::route('SuggestionList')->withMessageSuccess('保存成功');
    }
}
