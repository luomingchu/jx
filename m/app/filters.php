<?php

App::before(function ($request)
{
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
