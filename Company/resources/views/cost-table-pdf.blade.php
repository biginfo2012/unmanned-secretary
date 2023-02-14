<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Laravel 8 Generate PDF From View</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-3">経費一覧</h2>
    <table class="table table-bordered mb-5">
        <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">{{__('shop-name')}}</th>
            <th class="text-center">{{__('total')}}</th>
            <th class="text-center">{{__('pay-date')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $index => $item)
            <tr style="">
                <td class="p-0 border text-center align-middle">{{$index+1}}</td>
                <td class="p-0 border text-left align-middle px-1">{{$item['shop']['shop_name']}}</td>
                <td class="p-0 border text-left align-middle px-1">{{$item['total']}}</td>
                <td class="p-0 border text-center align-middle">{{date('Y/m/d', strtotime($item['created_at']))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
