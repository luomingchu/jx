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
});

Route::filter('auth', function ()
{
    if (Auth::guest()) {
        if (Request::ajax() || Request::wantsJson()) {
            return Response::make('由于长时间未操作，请重新登录！', 401);
        } else {
            return Redirect::guest(route('Login'));
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
