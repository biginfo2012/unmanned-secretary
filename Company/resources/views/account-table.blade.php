<table class="table table-separate table-head-custom table-checkable" id="table">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">{{__('client-name')}}</th>
        <th class="text-center">{{__('type')}}</th>
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
        <tr style="{{$item->status == 0 ? 'color: red' : ''}}">
            <td class="p-0 border text-center align-middle">{{$index+1}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['name']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['type'] == 1 ? __('co-op') : ($item['type'] == 2 ? __('solo-pro') : __('alone'))}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['email']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['charge']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['contact']}}</td>
            <td class="p-0 border text-center align-middle">{{date('Y/m/d', strtotime($item['created_at']))}}</td>
            <td class="p-0 border text-center align-middle">{{$item['status'] == 1 ? __('enable') : __('stop')}}</td>
            <td class="p-0 border text-center align-middle">
                <input type="hidden" value="{{$item['id']}}">
                <a href="{{route('company.account-edit', $item['id'])}}" class="btn btn-outline-dark waves-effect ex_change" style="padding: 8px; margin: 5px;">{{__('edit')}}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
