<table class="table table-separate table-head-custom table-checkable" id="table">
    <thead>
    <tr>
        <th class="text-center" width="5%"></th>
        <th class="text-center" width="25%">{{__('down-date')}}</th>
        <th class="text-center" width="40%">{{__('down-name')}}</th>
        <th class="text-center" width="30%">{{__('down-count')}}</th>
    </tr>
    </thead>
    <tbody>

    @foreach($data as $index => $item)
        <tr>
            <td class="p-0 border text-left align-middle px-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input delete_item" type="checkbox" id="inlineCheckbox_{{$item['id']}}" data-id="{{$item['id']}}"/>
                </div>
            </td>
            <td class="p-0 border text-left align-middle px-1">{{date('Y/m/d', strtotime($item['report_date']))}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$user_code . "_" . date('Ymd', strtotime($item['report_date']))}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['report_count']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
