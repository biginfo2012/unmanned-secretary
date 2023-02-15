<table class="table table-separate table-head-custom table-checkable" id="table">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">{{__('shop-name')}}</th>
        <th class="text-center">{{__('total')}}</th>
        <th class="text-center">{{__('pay-date')}}</th>
        <th class="text-center"></th>
    </tr>
    </thead>
    <tbody>

    @foreach($data as $index => $item)
        <tr style="">
            <td class="p-0 border text-center align-middle">{{$index+1}}</td>
            <td class="p-0 border text-left align-middle px-1">{{isset($item['shop_id']) ? $item['shop']['shop_name'] : ""}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['total']}}</td>
            <td class="p-0 border text-center align-middle">{{date('Y/m/d', strtotime($item['created_at']))}}</td>
            <td class="p-0 border text-center align-middle">
                <input type="hidden" value="{{$item['id']}}">
                <a href="{{route('company.client-cost-edit', $item['id'])}}" class="btn btn-outline-dark waves-effect ex_change" style="padding: 8px; margin: 5px;">{{__('detail')}}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
