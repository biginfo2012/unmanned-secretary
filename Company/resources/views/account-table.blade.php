<table class="table table-separate table-head-custom table-checkable" id="table">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">{{__('account-subject')}}</th>
        <th class="text-center">{{__('assi-subject')}}</th>
        <th class="text-center">{{__('subject-code')}}</th>
        <th class="text-center">{{__('tax-type')}}</th>
        <th class="text-center">{{__('keyword')}}</th>
        <th class="text-center"></th>
    </tr>
    </thead>
    <tbody>

    @foreach($data as $index => $item)
        <tr>
            <td class="border text-center align-middle" style="padding: 10px">{{$index+1}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['subject']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['assistant']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['code']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['tax']['tax_type']}}</td>
            <td class="p-0 border text-left align-middle px-1">{{$item['keyword']['keyword']}}</td>
            <td class="p-0 border text-center align-middle">
                <input type="hidden" value="{{$item['id']}}">
                @if($item['user_id'] == \Illuminate\Support\Facades\Auth::user()->id)
                    <a href="{{route('company.account-edit', $item['id'])}}" class="btn btn-outline-dark waves-effect ex_change" style="padding: 8px; margin: 5px;">{{__('edit')}}</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
