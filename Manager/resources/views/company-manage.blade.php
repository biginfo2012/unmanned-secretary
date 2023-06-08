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
                                class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75 me-0">
                                <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                                    <h4 class="card-title mb-0">{{__('company-manage')}}</h4>
                                </div>
                                <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0 pe-0">
                                    <div
                                        class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="dt-buttons">
                                            <a class="dt-button add-new btn btn-dark" style="padding-left: 28px; padding-right: 28px" href="{{route('manager.company-add')}}">
                                                <span>{{__('new-add')}}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-2 pb-0">
                            <form class="dt_adv_search" method="POST" id="search_form">
                                @csrf
                                <div class="row g-1 mb-md-0">
                                    <div class="col-md-2">
                                        <div class="mb-1 row">
                                            <label for="status" class="col-sm-4 col-form-label-lg color-red-tmp"
                                                   style="padding-right: 0; padding-top: 10px">{{__('plan')}}</label>
                                            <div class="col-sm-8" style="padding-left: 0">
                                                <select class="form-select color-red-tmp" id="status" name="status" disabled>
                                                    <option value="">{{__('all')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-1 row">
                                            <label for="status" class="col-sm-3 col-form-label-lg"
                                                   style="padding-right: 0; padding-top: 10px">{{__('status')}}</label>
                                            <div class="col-sm-9" style="padding-left: 0">
                                                <select class="form-select" id="status" name="status">
                                                    <option value="">{{__('all')}}</option>
                                                    <option value="1">{{__('enable')}}</option>
                                                    <option value="0">{{__('stop')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-1 row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="colFormLabel" name="contact"
                                                       placeholder="{{__('please-input-contact-company')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <button class="btn btn-dark mr-2" id="btn_get_table"
                                                onclick="event.preventDefault();getTableData('{{route('manager.company-table')}}')">{{__('search')}}
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                            <div class="dt-buttons">
                                                <button type="button" class="dt-button add-new btn btn-dark" id="cost_export_excel"
                                                        onclick="event.preventDefault();exportFile('{{route('manager.company-export-csv')}}', 'csv')">
                                                    <i data-feather='download'></i>{{__('export')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
            getTableData('{{route('manager.company-table')}}');
        });
        let change_url = '{{route('manager.company-change-status')}}'
    </script>
</x-app-layout>
