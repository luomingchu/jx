<?php
/**
 * 账号管理控制器
 */
class AccountManageController extends BaseController
{

    /**
     * 获取企业账号信息
     */
    public function index()
    {
        // 获取企业的账号信息
        $info = EnterpriseBankcard::where('enterprise_id', $this->enterprise_id)->first();

        // 获取门店账号信息
        /* $store_account = Store::with('group', 'province','city','district', 'account')->latest();

        $citys = $districts = [];

        // 根据地区来进行赛选
        if (Input::has('district_id')) {
            $store_account->where('district_id', Input::get('district_id'));
        } else if (Input::has('city_id')) {
            $store_account->where('city_id', Input::get('city_id'));
            $districts = District::where('city_id', Input::get('city_id'))->get();
        } else if (Input::has('province_id')) {
            $store_account->where('province_id', Input::get('province_id'));
            $citys = City::where('province_id', Input::get('province_id'))->get();
        }

        // 根据名称来进行赛选
        if (Input::has('name')) {
            $store_account->where('name', 'like', '%'.Input::get('name').'%');
        }
        $store_account = $store_account->paginate(15);
 */
        // 获取省份列表
        $provinces = Province::all();

        // 获取银行列表
        $banks = Bank::all();


        return View::make('account.index')->with(compact('info', 'store_account', 'citys', 'provinces', 'districts', 'banks'));
    }

    /**
     * 保存企业账号信息
     */
    public function postSave()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'bank_id' => [
                    'required',
                    'exists:banks,id'
                ],
                'branch_code' => [
                    'required'
                ],
                'number' => [
                    'required'
                ],
                'name' => [
                    'required'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $enterprise_bankcard = EnterpriseBankcard::where('enterprise_id', $this->enterprise_id)->first();
        empty($enterprise_bankcard) && $enterprise_bankcard = new EnterpriseBankcard();
        $enterprise_bankcard->enterprise_id = $this->enterprise_id;
        $enterprise_bankcard->bank_id = Input::get('bank_id');
        $enterprise_bankcard->branch_code = Input::get('branch_code');
        $enterprise_bankcard->number = Input::get('number');
        $enterprise_bankcard->name = Input::get('name');
        $enterprise_bankcard->branch_name = Input::get('branch_name');
        $enterprise_bankcard->save();
        return $enterprise_bankcard;
    }


    /**
     * 保存门店账号信息
     */
    public function postSaveStoreAccountInfo()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'store_id' => [
                    'required',
                    'exists:store,id'
                ],
                'bank_id' => [
                    'required',
                    'exists:banks,id'
                ],
                'branch_code' => [
                    'required'
                ],
                'number' => [
                    'required'
                ],
                'name' => [
                    'required'
                ],
                'branch_name' => [
                    'required'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $store = Store::find(Input::get('store_id'));
        $account = $store->account;
        empty($account) && $account = new StoreBankcard();

        $account->store_id = $store->id;
        $account->bank_id = Input::get('bank_id');
        $account->branch_code = Input::get('branch_code');
        $account->number = Input::get('number');
        $account->name = Input::get('name');
        $account->branch_name = Input::get('branch_name');
        $account->save();
        return $account;
    }


    /**
     * 批量导入门店账号信息
     */
    public function postMultiImportStoreAccount()
    {
        $import_error = 0;
        $import_success = 0;

        Excel::load(Input::file('report'), function ($reader) use (&$import_success, &$import_error)
        {
            $res = $reader->toArray();
            foreach ($res as $key => $item) {
                if ($key >= 1) {
                    $store_id = Store::find($item[1]);
                    if (! empty($store_id) && ! empty($item[6]) && ! empty($item['4'])) {
                        $inputs = [
                            'store_id' => trim($store_id->id),
                            'bank_id' => trim($item[3]),
                            'number' => trim($item[6]),
                            'name' => trim($item[7]),
                            'branch_name' => trim($item[5]),
                            'branch_code' => trim($item[4])
                        ];
                        $validator = Validator::make($inputs, [
                            'bank_id' => 'required',
                            'number' => 'required',
                            'name' => 'required',
                            'branch_name' => 'required',
                            'branch_code' => 'required',
                        ]);
                        if ($validator->fails()) {
                            ++$import_error;
                            continue;
                        }
                        $store_bank = StoreBankcard::where('store_id', $inputs['store_id'])->first();
                        empty($store_bank) && $store_bank = new StoreBankcard();
                        $store_bank->store_id = $inputs['store_id'];
                        $store_bank->bank_id = $inputs['bank_id'];
                        $store_bank->number = $inputs['number'];
                        $store_bank->name = $inputs['name'];
                        $store_bank->branch_name = $inputs['branch_name'];
                        $store_bank->branch_code = $inputs['branch_code'];
                        $store_bank->save();
                        ++$import_success;
                    } else {
                        ++$import_error;
                    }
                }
            }
        });

        if ($import_error > 0) {
            return Redirect::route('AccountManage')->withMessageWarning("导入成功{$import_success}笔，失败{$import_error}笔");
        }
        return Redirect::route('AccountManage')->withMessageSuccess("批量导入门店账户成功");
    }


    /**
     * 下载门店账户
     */
    public function getExportStoreAccount()
    {
        $data = [
            [
                '门店ID(请勿修改)',
                '门店名称(请勿修改)',
                '开户银行ID（请填写后面银行对应的ID）（1、中国银行；2、中国工商银行；3、中国建设银行；4、中国农业银行；5、中国邮政储蓄银行；6、中国光大银行；7、中国民生银行；8、交通银行；9、招商银行；10、平安银行；11、浦发银行；12、中信银行；13、兴业银行；14、华夏银行；15、广发银行）',
                '分行机构号（查询：https://e.czbank.com/CORPORBANK/query_unionBank_index.jsp；支付行号请以文本形式保存）',
                '银行网点',
                '银行账户（请以文本形式保存）',
                '账户名称'
            ]
        ];

        // 数据源
        $store_account = Store::with('group', 'province','city','district', 'account')->latest()->get();
        $rows = 0;
        foreach ($store_account as $item) {
            $rows = $rows + 1;
            if (! empty($item->account)) {
                array_push($data, [
                    (string) $item->id. ' ',
                    (string) $item->name . ' ',
                    $item->account->bank->id,
                    (string) empty($item->account->branch_code) ? ' ' : ' '.$item->account->branch_code,
                    (string) empty($item->account->branch_name) ? ' ' : ' '.$item->account->branch_name,
                    (string) empty($item->account->number) ? ' ' : ' '.$item->account->number,
                    (string) empty($item->account->name) ? ' ' : ' '.$item->account->name,
                ]);
            } else {
                array_push($data, [
                    (string) $item->id . ' ',
                    (string) $item->name . ' ',
                    ' ', ' ', ' ', ' ', ' '
                ]);
            }

        }
        if (! empty($data)) {
            $excel_name = 'store_account';
            $sheet_name = '门店银行账户(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name, $rows)
            {
                $excel->setTitle('门店银行账户');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('门店银行账户明细');

                $excel->sheet($sheet_name, function ($sheet) use($data, $rows)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);

                    $sheet->prependRow([]);

                    // 设置粗体
                    $sheet->cells('A2:G2', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                });
            })->export('xls');
        }
    }
}