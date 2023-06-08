<table class="table table-separate table-head-custom table-checkable" id="table">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">{{__('user-code')}}</th>
        <th class="text-center">{{__('client-name')}}</th>
        <th class="text-center">{{__('type')}}</th>
        <th class="text-center">{{__('this-month')}}</th>
        <th class="text-center">{{__('prev-month')}}</th>
        <th class="text-center">{{__('total-cnt')}}</th>
        <th class="text-center">{{__('user-id')}}</th>
        <th class="text-center">{{__('charge')}}</th>
        <th class="text-center">{{__('contact')}}</th>
        <th class="text-center">{{__('register-date')}}</th>
        <th class="text-center">{{__('status')}}</th>
        <th class="text-center"></th>
    </tr>
    </thead>
    <tbody>

    @foreach($data as $index => $item)
        <tr style="{{$item['status'] == 0 ? 'color: red' : ''}}">
            <td class="p-0 border text-end align-middle px-1">{{$index+1}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['user_code']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['name']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['type'] == 1 ? __('co-op') : ($item['type'] == 2 ? __('solo-pro') : __('alone'))}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['this_month']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['prev_month']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['total_cnt']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['email']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['charge']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['contact']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{date('Y/m/d', strtotime($item['created_at']))}}</td>
            <td class="p-0 border text-left align-middle px-1">
                <select class="form-select change_status" name="status">
                    <option value="1" {{$item['status'] == 1 ? 'selected' : ''}}>{{__('enable')}}</option>
                    <option value="0" {{$item['status'] == 0 ? 'selected' : ''}}>{{__('stop')}}</option>
                </select>
                <input type="hidden" value="{{$item['id']}}">
            </td>
            <td class="p-0 border text-left align-middle px-1">
                <input type="hidden" value="{{$item['id']}}">
                <a href="{{route('manager.client-edit', $item['id'])}}" class="btn btn-dark waves-effect ex_change" style="padding: 8px; margin: 5px;">{{__('detail')}}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
