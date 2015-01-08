<?php

App::before(function ($request)
{
    // 根据子域名，自动定位分库。
//     $host = Request::server('HTTP_HOST');
//     $host = str_replace(parse_url(Config::get('app.url'), PHP_URL_HOST), '', $host);
//     preg_match('/([^.]+)\./i', $host, $matchs);
//     $domain = $matchs[1];
//     Config::set('database.connections.own.database', 'zbond_' . $domain);

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
    //     Log::info('Call route.', [
    //         'RouteName' => Route::currentRouteName(),
    //         'Request' => (string) $request,
    //         'Response' => (string) $response
    //     ]);
});

Route::filter('auth', function ()
{
    if (Auth::guest()) {
        if (Request::ajax() || Request::wantsJson()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Response::make('Unauthorized', 401);
            //return Redirect::guest('login');
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
