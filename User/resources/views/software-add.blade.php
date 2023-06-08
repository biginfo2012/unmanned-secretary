<x-app-layout>
    <!--begin::Content-->
    <div class="content-body">
        <!-- Ajax Sourced Server-side -->
        <section id="datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between align-items-center header-actions row mt-75 mx-0">
                                <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <!-- End Offcanvas -->
                                        <div class="mt-1 me-2">
                                            <p>{{__('account-type')}} : {{$account_type}}<span></span></p>
                                        </div>
                                        <div class="offcanvas-end-example">
                                            <button
                                                class="btn background-sky color-white"
                                                type="button"
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasEnd"
                                                aria-controls="offcanvasEnd"
                                                style="padding-right: 35px; padding-left: 35px"
                                            >
                                                {{__('change')}}
                                            </button>
                                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
                                                <div class="offcanvas-header mt-1">
                                                    <h5 id="offcanvasEndLabel" class="offcanvas-title">{{__('type-setting')}}</h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close text-reset"
                                                        data-bs-dismiss="offcanvas"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="offcanvas-body mx-0 flex-grow-0 mt-1">
                                                    <form class="dt_adv_search" method="POST" id="change_form">
                                                        @csrf
                                                        <p class="text-start">
                                                            {{__('please-select-soft')}}
                                                        </p>
                                                        <div class="" style="padding-left: 0">
                                                            <select class="form-select" id="account_type" name="account_type">
                                                                @foreach($account_types as $account)
                                                                    <option value="{{$account->id}}" {{$account->id == \Illuminate\Support\Facades\Auth::user()->account_type ? 'selected' : ''}}>{{$account->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="d-flex mt-1">
                                                            <button type="button" class="btn background-sky color-white d-grid w-100 me-1"
                                                                    onclick="event.preventDefault();changeForm('{{route('client.change-account-type')}}')">{{__('save')}}</button>
                                                            <a class="btn btn-flat-secondary d-grid w-100 ms-1" data-bs-dismiss="offcanvas">
                                                                {{__('cancel')}}
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/ End Offcanvas-->
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0 pe-0">
                                    <form class="dt_adv_search" method="POST" id="search_form">
                                        @csrf
                                    </form>
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <button type="button" class="dt-button add-new btn background-sky color-white" id="cost_export_excel"
                                                onclick="event.preventDefault();exportFileSoftware('{{route('client.cost-export-csv-software')}}', 'csv', '{{trim($user_code)}}')">
                                            <i data-feather='download'></i>{{__('csv-download')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0" id="table-part">
                            <table class="table table-separate table-head-custom table-checkable" id="table">
                                <thead>
                                <tr>
                                    <th class="text-center" width="5%"></th>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center" width="10%">{{__('pay-date')}}</th>
                                    <th class="text-center" width="20%">{{__('summary')}}</th>
                                    <th class="text-center" width="20%">{{__('account-item')}}</th>
                                    <th class="text-center" width="20%">{{__('price-down')}}</th>
                                    <th class="text-center" width="20%">{{__('import-date')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($data as $index => $item)
                                    <tr class="table-info">
                                        <td class="p-0 border text-left align-middle px-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input down_item" type="checkbox" id="inlineCheckbox_{{$item['id']}}" data-id="{{$item['id']}}" checked/>
                                            </div>
                                        </td>
                                        <td class="p-0 border text-left align-middle px-1">{{$index+1}}</td>
                                        <td class="p-0 border text-left align-middle px-1">{{!empty($item['pay_date']) ? date('Y/m/d', strtotime($item['pay_date'])) : ""}}</td>
                                        <td class="p-0 border text-left align-middle px-1">{{!empty($item['shop_name']) ? $item['shop_name'] : ""}}</td>
                                        <td class="p-0 border text-left align-middle px-1">{{!empty($item['subject']) ? $item['subject'] : ""}}</td>
                                        <td class="p-0 border text-left align-middle px-1">{{!empty($item['total']) ? number_format($item['total']) . "円": ""}}</td>
                                        <td class="p-0 border text-left align-middle px-1">{{date('Y/m/d', strtotime($item['created_at']))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end::Content-->
    <script>
        addEventListener('pageshow', (event) => {
            //getTableData('{{route('client.account-table')}}');
        });
        $(document).ready(function () {
            $('input.down_item[type=checkbox]').click(function () {
                if($(this)[0].checked){
                    $(this).parent().parent().parent().addClass('table-info')
                }
                else{
                    $(this).parent().parent().parent().removeClass('table-info')
                }
            })
        })
    </script>
</x-app-layout>
