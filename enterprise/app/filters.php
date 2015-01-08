<?php
App::before(function ($request)
{
    // 根据子域名，判断地址是否正确。
    if (is_null(Enterprise::whereDomain(select_enterprise())->first())) {
        return Response::make('您输入的企业管理后台地址错误，不存在此二级域名！', 402);
    }

    // 开启全局事务。
    db_begin_transaction();
});

App::after(function ($request, $response)
{
    // 提交全局事务。
    db_commit();

    // 对数NULL类型进行处理。
    $recstr = null;
    $recstr = function ($data) use(&$recstr)
    {
        if (is_array($data)) {
            return array_map($recstr, $data);
        } elseif ($data === null) {
            return (object) null;
        }
        return $data;
    };
    $data = json_decode($response->getContent(), true);
    if (! is_null($data)) {
        $response->setContent(json_encode($recstr($data)));
    }
});

Route::filter('auth', function ()
{
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make('由于长时间未操作，请重新登录！', 401);
        } else {
            return Redirect::guest('login');
        }
    } else {
        // 进行访问权限判断
        // 如果是超级管理员不用进行权限的判断
        if (Auth::user()->is_super != Manager::SUPER_VALID) {
            $route = Route::currentRouteName();
            // 获取当前用户的权限列表
            $access_purview = Auth::user()->getAccessPurview();
            if ($route != 'EnterpriseInfo') {
                // 先判断是否能进后台首页，没有权限直接跳出，防止权限验证递归跳转
                if (! $access_purview->has('Dashboard')) {
                    return Response::make('<div style="text-align: center;margin-top: 50px;width: 100%;border: 1px dotted #ccc;padding: 50px 0;background: #EEE;font-weight: bold;">您没有相关权限登录本系统！</div>', 401);
                }
                // 判断是否有在可访问权限列表中
                $route = Route::currentRouteName();
                $flag = false;
                if ($access_purview->has($route)) {
                    // 如果同一个路由有多个访问规则，则只有附加相同时才能访问
                    foreach ($access_purview->get($route) as $ap) {
                        if (empty($ap->condition)) {
                            $flag = true;
                            break;
                        } else {
                            $purview_url = action($ap->controller . '@' . $ap->action, $ap->condition);
                            // 判断path_info形式
                            if (URL::current() == $purview_url || URL::full() == $purview_url) {
                                $flag = true;
                                break;
                            } else {
                                // 判断query形式
                                $current_full_url = parse_url(URL::full());
                                if (! empty($current_full_url['query'])) {
                                    parse_str($current_full_url['query'], $query);
                                    $diff = array_diff_assoc($query, $ap->condition);
                                    if (empty($diff)) {
                                        $flag = true;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                if (! $flag) {
                    if (Request::ajax()) {
                        return Response::make('您没有相关权限执行此操作！', 403);
                    } else {
                        return Redirect::away(URL::previous())->with('message_error', '您没有相关权限执行此操作!');
                    }
                }
            }
        }
    }
});

Route::filter('auth.basic', function ()
{
    return Auth::basic();
});

Route::filter('guest', function ()
{
    if (Auth::check())
        return Redirect::to('/');
});

Route::filter('csrf', function ()
{
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException();
    }
});
