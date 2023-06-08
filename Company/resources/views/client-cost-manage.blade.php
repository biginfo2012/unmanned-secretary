<x-app-layout>
    <!--begin::Content-->
    <div class="content-body">
        <!-- Ajax Sourced Server-side -->
        <section id="datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div
                                class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                                    <h4 class="card-title mb-0">{{__('cost-manage')}} : {{$user->name}}</h4>
                                </div>
                                <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0">
                                    <div
                                        class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="dt-buttons">
                                            <button type="button" class="dt-button add-new btn btn-warning" id="cost_export_excel"
                                                    onclick="event.preventDefault();exportFile('{{route('company.cost-export-csv')}}', 'csv', '{{trim($account_type)}}')">
                                                <i data-feather='download'></i>{{__('export')}}
                                            </button>
{{--                                            <a type="button" class="dt-button add-new btn btn-primary" id="cost_export_pdf"--}}
{{--                                               href="{{route('company.client-cost-export-pdf', $user->id)}}">--}}
{{--                                                <i data-feather='download'></i>{{__('report')}}--}}
{{--                                            </a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="dt_adv_search" method="POST" id="search_form">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                        </form>
{{--                        <div class="card-body mt-2 pb-0">--}}
{{--                            <form class="dt_adv_search" method="POST" id="search_form">--}}
{{--                                @csrf--}}
{{--                                <div class="row g-1 mb-md-0">--}}
{{--                                    <div class="col-md-2">--}}
{{--                                        <div class="mb-1 row">--}}
{{--                                            <label for="type" class="col-sm-4 col-form-label-lg"--}}
{{--                                                   style="padding-right: 0; padding-top: 10px">{{__('type')}}</label>--}}
{{--                                            <div class="col-sm-8" style="padding-left: 0">--}}
{{--                                                <select class="form-select" id="type" name="type">--}}
{{--                                                    <option value="">{{__('all')}}</option>--}}
{{--                                                    <option value="1">{{__('co-op')}}</option>--}}
{{--                                                    <option value="2">{{__('solo-pro')}}</option>--}}
{{--                                                    <option value="3">{{__('alone')}}</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-3">--}}
{{--                                        <div class="mb-1 row">--}}
{{--                                            <div class="col-sm-12">--}}
{{--                                                <input type="text" class="form-control" id="colFormLabel" name="contact"--}}
{{--                                                       placeholder="{{__('please-input-contact-company')}}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-md-2">--}}
{{--                                        <button class="btn btn-success mr-2" id="btn_get_table"--}}
{{--                                                onclick="event.preventDefault();getTableData('{{route('company.client-table')}}')">検　索--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
                        <div class="card-body pt-0" id="table-part">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end::Content-->
    <script>
        addEventListener('pageshow', (event) => {
            getTableData('{{route('company.client-cost-table')}}');
        });
    </script>
</x-app-layout>
