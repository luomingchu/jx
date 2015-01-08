<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StaffController extends BaseController
{
    // Excel批量上传总数
    protected $total = 0;
    // 上传成功数
    protected $success = 0;
    // 上传失败数
    protected $error = 0;

    /**
     * 员工列表
     */
    public function getList()
    {
        $staffs = Staff::with('member', 'store');

        // 姓名筛选
        if (Input::has('real_name')) {
            $staffs->where('real_name', 'like', "%" . Input::get('real_name') . "%");
        }

        // 工号筛选
        if (Input::has('staff_no')) {
            $staffs->where('staff_no', 'like', "%" . Input::get('staff_no') . "%");
        }

        // 注册状态筛选
        if (Input::has('bind')) {
            Input::get('bind') == 'Y' ? $staffs->whereRaw(" member_id <> '' ") : $staffs->whereRaw(" member_id = '' ");
        }

        // 在职状态筛选
        if (Input::has('status')) {
            $staffs->where('status', '=', Input::get('status'));
        }

        $staffs = $staffs->latest('id')->paginate('15');

        return View::make('staff.list')->withData($staffs);
    }

    /**
     * Excel批量导入员工
     *
     * @author jois
     */
    public function importExcelStaff()
    {
        if(!Input::hasFile('report')){
        	return Redirect::route('StaffList')->withMessageError("请选择导入文件");
        }

        Excel::load(Input::file('report'), function ($reader)
        {

            $res = $reader->toArray();
            $excel_data = $res[0];
            foreach ($excel_data as $key => $item) {
                if ($key >= 1) {
                    $this->total = $this->total + 1;
                    $inputs = [
                        'real_name' => $item[1],
                        'staff_no' => $item[2],
                        'mobile' => $item[3],
                        'store_name' => $item[4],
                        'gender' => $item[5],
                        'age' => $item[6],
                        'status' => $item[7]
                    ];

                    $validator = Validator::make($inputs, [
                        'real_name' => 'required',
                        'staff_no' => 'required|unique:staffs,staff_no',
                        'mobile' => 'required|unique:staffs,mobile',
                        'store_name' => 'required|exists:store,name',
                        'gender' => 'in:"男","女"',
                        'status' => 'in:"在职","离职"',
                        'age' => 'numeric|min:10|max:120'
                    ]);
                    if ($validator->fails()) {
                        continue;
                    }
                    // 根据门店名找到对应门店ID
                    $store = Store::whereName(trim($inputs['store_name']))->first();
                    if (is_null($store)) {
                        continue;
                    }
                    // 新增员工
                    if ($inputs['gender'] == '男') {
                        $gender = Member::GENDER_MAN;
                    } else {
                        $gender = Member::GENDER_FEMALE;
                    }

                    if ($inputs['status'] ==  '在职') {
                        $status = Staff::STATUS_VALID;
                    } else {
                        $status = Staff::STATUS_INVALID;
                    }
                    $staff = new Staff();
                    $staff->real_name = $inputs['real_name'];
                    $staff->mobile = $inputs['mobile'];
                    $staff->store_id = $store->id;
                    $staff->staff_no = $inputs['staff_no'];
                    $staff->gender = $gender;
                    $staff->status = $status;
                    $staff->age = $inputs['age'];
                    $staff->save();
                    $this->success = $this->success + 1;
                }
            }
            $this->error = $this->total - $this->success;
        });
        if ($this->error > 0) {
            return Redirect::route('StaffList')->withMessageWarning("导入成功{$this->success}笔，失败{$this->error}笔");
        }
        return Redirect::route('StaffList')->withMessageSuccess("全部批量导入成功");
    }

    /**
     * 编辑员工信息
     */
    public function getEdit($id = 0)
    {
        $stores = Store::all();
        $id > 0 ? $staff = Staff::find($id) : $staff = new Staff();
        return View::make('staff.edit')->withData($staff)->withStores($stores);
    }

    /**
     * 保存员工信息
     */
    public function postSave()
    {
        // 获取输入。
        $inputs = Input::all();
        // 验证输入。
        $validator = Validator::make($inputs, [

            'real_name' => [
                'required'
            ],
            'email' => [
                'email'
            ],
            'mobile' => [
                'mobile',
                'unique:staffs,mobile,' . Input::get("id")
            ],
            'store_id' => [
                'required',
                'exists:store,id'
            ],
            'status' => [
                'required',
                'in:'.Staff::STATUS_VALID.','.Staff::STATUS_INVALID
            ],
            'staff_no' => [
                'unique:staffs,staff_no'. Input::get('id')
            ]
        ], [
            'real_name.required' => '真实姓名不能为空',
            'email.email' => '邮箱格式不正确',
            'mobile.mobile' => '手机号格式不存在',
            'mobile.unique' => '此手机号已经被使用',
            'store_id.required' => '所属门店不能为空',
            'status.in' => '在职状态只能为在职或离职',
            'staff_no.unique' => '已经有相同的工号了，请重新输入！'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        Input::get("id", 0) > 0 ? $staff = Staff::find(Input::get("id")) : $staff = new Staff();

        $staff->real_name = $inputs['real_name'];
        $staff->mobile = $inputs['mobile'];
        $staff->staff_no = $inputs['staff_no'];
        $staff->gender = $inputs['gender'];
        $staff->store_id = $inputs['store_id'];
        $staff->status = $inputs['status'];

        $staff->save();

        // 如果有设置门店则修改其开指店的所属门店
        if ($staff->store_id != '') {
            // 获取其是否有注册
            $memberInfo = MemberInfo::where('mobile', $staff->mobile)->first();
            if (! empty($memberInfo)) {
                $vstore = Vstore::where('member_id', $memberInfo->member_id)->first();
                if (! empty($vstore)) {
                    $vstore->store_id = $staff->store_id;
                    $vstore->save();
                }
            }
        }

        return $staff;
    }

    /**
     * 删除员工信息
     */
    public function delete()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:staffs,id'
            ]
        ], [
            'id.required' => '要删除的员工不能为空',
            'id.exists' => '要删除的员工不存在'
        ]);
        if ($validator->fails()) {
            return Redirect::route('StaffList')->withMessageError($validator->messages()
                ->first());
        }

        // 执行删除
        $staff = Staff::find(Input::get('id'))->delete();


        // 跳转回列表页。
        return Redirect::route('StaffList')->withMessageSuccess('删除成功');
    }
}
