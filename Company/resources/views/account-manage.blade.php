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
                                    <h4 class="card-title mb-0">{{__('account-manage')}}</h4>
                                </div>
                                <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0">
                                    <div
                                        class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <!-- End Offcanvas -->
                                        <div class="mt-1 me-2">
                                            <p>{{__('account-type')}} : {{$account_type}}<span></span></p>
                                        </div>
                                        <div class="offcanvas-end-example">
                                            <button
                                                class="btn btn-flat-primary"
                                                type="button"
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasEnd"
                                                aria-controls="offcanvasEnd"
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
                                                            <button type="button" class="btn btn-flat-primary d-grid w-100 me-1"
                                                                    onclick="event.preventDefault();changeForm('{{route('company.change-account-type')}}')">{{__('save')}}</button>
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
                            </div>
                        </div>
                        <div class="card-body m-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center header-actions mx-0 row mb-0">
                                <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start mb-0">
                                    <h5 class="mb-0">{{__('account-manage')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-0 pb-0">
                            <form class="dt_adv_search" method="POST" id="search_form">
                                @csrf
                                <div class="row g-1 mb-md-0">
                                    <div class="col-md-2">
                                        <div class="mb-1 row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="colFormLabel" name="subject"
                                                       placeholder="{{__('account-subject-name')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-1 row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="colFormLabel" name="code"
                                                       placeholder="{{__('subject-code')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-1 row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="colFormLabel" name="keyword"
                                                       placeholder="{{__('keyword')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <button class="btn btn-success mr-2" id="btn_get_table"
                                                onclick="event.preventDefault();getTableData('{{route('company.account-table')}}')">{{__('search')}}
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                            <div class="dt-buttons">
                                                <a class="dt-button add-new btn btn-primary" href="{{route('company.account-add')}}">
                                                    <span>{{__('new-add')}}</span></a>
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
            getTableData('{{route('company.account-table')}}');
        });
    </script>
</x-app-layout>
