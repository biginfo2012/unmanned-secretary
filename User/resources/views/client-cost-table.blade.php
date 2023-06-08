<table class="table table-separate table-head-custom table-hover" id="table">
    <thead>
    <tr>
        <th class="text-center" width="5%">No</th>
        <th class="text-center" width="10%">{{__('icon')}}</th>
        <th class="text-center" width="10%">{{__('pay-date')}}</th>
        <th class="text-center" width="20%">{{__('summary')}}</th>
        <th class="text-center" width="15%">{{__('account-item')}}</th>
        <th class="text-center" width="10%">{{__('down-tax')}}</th>
        <th class="text-center" width="10%">{{__('price-down')}}</th>
        <th class="text-center" width="10%">{{__('import-date')}}</th>
        <th class="text-center" width="5%"></th>
    </tr>
    </thead>
    <tbody>

    @foreach($data as $index => $item)
        <tr class="{{$item['status'] ? ($item['export'] == 1 ? 'table-active' : '') : 'table-warning'}}">
            <td class="p-0 border text-end align-middle px-1">{{$index+1}}</td>
            <td class="p-0 border text-start align-middle px-1">
                <img class="icon_img" src="{{asset('icon/icon.png')}}" style="width: 15px; height: 15px; margin-right: 5px;" data-url="{{$item['url']}}">
                @if(empty($item['url']) || empty($item['pay_date']) || empty($item['shop_name']) || empty($item['subject']) || empty($item['total']) || empty($item['percent']))
                    <img src="{{asset('icon/warning.png')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('no-input')}}" style="width: 15px; height: 15px">
                @endif
                @if(!empty($item['note']))
                    <img src="{{asset('icon/memo.png')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{!empty($item['note']) ? $item['note'] : ""}}" style="width: 15px; height: 15px">
                @endif
                @if($item['export'] == 1)
                    <img src="{{asset('icon').'/export-dark.png'}}" style="width: 15px;" class="me-1">
                @endif
            </td>
            <td class="p-0 border text-left align-middle px-1">{{!empty($item['pay_date']) ? date('Y/m/d', strtotime($item['pay_date'])) : ""}}</td>
            <td class="p-0 border text-left align-middle px-1"><label data-bs-toggle="tooltip" data-bs-placement="top" title="{{!empty($item['shop_name']) ? $item['shop_name'] : ""}}">{{!empty($item['shop_name']) ? $item['shop_name'] : ""}}</label></td>
            <td class="p-0 border text-left align-middle px-1">{{!empty($item['subject']) ? $item['subject'] : ""}}</td>
            <td class="p-0 border text-left align-middle px-1">{{!empty($item['percent']) ? $item['percent'] . "%" : ""}}</td>
            <td class="p-0 border text-left align-middle px-1">{{!empty($item['total']) ? number_format($item['total']) . "円": ""}}</td>
            <td class="p-0 border text-left align-middle px-1">{{date('Y/m/d', strtotime($item['created_at']))}}</td>
            <td class="p-0 border text-left align-middle">
                <input type="hidden" value="{{$item['id']}}">
                <a href="{{route('client.cost-edit', $item['id'])}}" class="btn background-sky color-white waves-effect ex_change" style="padding: 8px; margin: 5px;">{{__('detail')}}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
