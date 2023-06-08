<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        @page {
            footer: page-footer;
            margin: 0;
            margin-top: 35pt;
            margin-bottom: 50pt;
            margin-footer: 18pt;
        }

        @page :first {
            margin-top: 0;
        }

        @font-face {
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipag.ttf') }}');
        }
        body {
            font-family: ipag !important;
        }

        table, tr, td {
            padding: 0;
            border-collapse: collapse;
        }
        table { width: 100%; }
        td { vertical-align: top; }

        .page-break-before { page-break-before: always; }

        .container { padding: 0 35pt; }

        main .container {
            margin-top: 2em;
        }
        main h2 {
            margin: 0 0 .8em;
            page-break-after: avoid;
        }
        main p, main .table-wrapper {
            margin: 0 0 1em;
        }

        .clearfix {
            clear: both;
        }

        .text-center { text-align: center; }

        .vertical-bar {
            display: block;
            width: 100px;
            border-bottom: 1px solid #ccc;
            margin: 0 auto;
        }

        .col1  { width: 8.33333%; }
        .col2  { width: 16.66667%; }
        .col3  { width: 25%; }
        .col4  { width: 33.33333%; }
        .col5  { width: 41.66667%; }
        .col6  { width: 50%; }
        .col7  { width: 58.33333%; }
        .col8  { width: 66.66667%; }
        .col9  { width: 75%; }
        .col10 { width: 83.33333%; }
        .col11 { width: 91.66667%; }
        .col12 { width: 100%; }

        #header {
            border: none;
            padding: 30pt 0;
            background-color: #3456D8;
        }

        #header table {
            color: #FFFFFF;
        }

        .grid-images {
            margin: -1%;
        }

        .tile-image {
            float: left;
            padding: 1%;
        }

        .tile-image img {
            display: block;
            width: 100%;
        }

        .details-column-table {
            margin: 0 15pt;
            table-layout: fixed;
        }

        .details-column-table tr {
            border: none;
            border-bottom: .5pt solid #ddd;
        }

        .details-column-table tr:last-child {
            border: none;
        }

        .details-column-table td {
            line-height: 30pt;
        }

        .details-column-table .label {
            /*//font-weight: bold;*/
        }

        .details-column-table .value {
            text-align: right;
            white-space: nowrap;
            /*font-weight: normal;*/
        }

        .tag {
            float: left;
            width: auto;
            margin: 0 .5em .5em;
            padding: .3em .5em;
            background-color: #eee;
            border-radius: 3px;
            text-align: center;
        }

        .contact-box {
            width: 350pt;
            margin: 35pt auto;
            padding: 30pt;
            border-radius: 2pt;
            border: 1pt solid rgba(0, 0, 0, .1);
            border-bottom-width: 3pt;
            page-break-inside: avoid;
        }

        .contact-image {
            margin: 0 auto;
            width: 30%;
            padding-bottom: 30%;
            border-radius: 50%;
            background-size: 100% auto;
            background-position: center;
            /*background-image: url(https://dummyimage.com/150x150);*/
        }

        .contact-details {
            margin: 0 auto;
            width: 70%;
            text-align: center;
        }

        .contact-name {
            margin-top: 18pt;
            margin-bottom: 0;
            font-size: 1.5em;
        }

        .contact-email {
            color: #aaa;
        }

        .contact-phone {
            margin-top: 15pt;
        }
    </style>
    <title></title>
</head>
<body>
<main>
    <div class="container">
        <h2 style="padding: 30pt 0 15pt 0;">領収書詳細</h2>
        <table style="margin: 0 -15pt;">
            <tr>
                <td class="col6" style="text-align: center; vertical-align: middle;">
{{--                    @if(!empty($data[0]['url']))--}}
{{--                        <img alt="image" src="{{asset('upload').'/'.$data[0]['url']}}" style="height: 360px">--}}
{{--                    @endif--}}
                   <img alt="Test Team" src="{{asset('upload').'/'.$data[0]['url']}}" style="height: auto; width: 100%">
                </td>
                <td class="col6">
                    <table class="details-column-table">
                        <tr>
                            <td class="label">{{__('pay-date')}}:</td>
                            <td class="value">{{!empty($data[0]['pay_date']) ? date('Y/m/d', strtotime($data[0]['pay_date'])) : ""}}</td>
                        </tr>
                        <tr>
                            <td class="label">{{__('cost-code')}}:</td>
                            <td class="value">{{!empty($data[0]['cost_code']) ? $data[0]['cost_code'] : ""}}</td>
                        </tr>
                        <tr>
                            <td class="label">{{__('summary')}}:</td>
                            <td class="value">{{!empty($data[0]['shop_id']) ? $data[0]['shop']['shop_name'] : ""}}</td>
                        </tr>
                        <tr>
                            <td class="label">{{__('account-item')}}:</td>
                            <td class="value">{{!empty($data[0]['account_id']) ? $data[0]['subject'] : ''}}</td>
                        </tr>
                        <tr>
                            <td class="label">金額:</td>
                            <td class="value">{{number_format($data[0]['total'])}}円</td>
                        </tr>
                        <tr>
                            <td class="label">税:</td>
                            <td class="value">{{$data[0]['percent']}}％</td>
                        </tr>
                        <tr>
                            <td class="label">{{__('content')}}:</td>
                            <td class="value">{{$data[0]['content']}}</td>
                        </tr>
                        <tr>
                            <td class="label">{{__('note')}}:</td>
                            <td class="value">{{$data[0]['note']}}</td>
                        </tr>
                        <tr>
                            <td class="label">{{__('import-date')}}:</td>
                            <td class="value">{{date('Y/m/d', strtotime($data[0]['created_at']))}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</main>
</body>
</html>
