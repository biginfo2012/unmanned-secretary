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
                                    <h4 class="card-title mb-0">{{__('cost-manage')}}</h4>
                                </div>
                                <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0">
                                    <div
                                        class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="dt-buttons d-none">
                                            <button type="button" class="dt-button add-new btn btn-primary" id="cost_export_excel"
                                                    onclick="event.preventDefault();exportFile('{{route('client.cost-export-csv')}}', 'csv', '{{trim($account_type)}}')">
                                                <i data-feather='download'></i>{{__('export')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-0 pb-0">
                            <form class="dt_adv_search" method="POST" id="search_form">
                                @csrf
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="row g-1 mb-md-0">
                                    <div class="col-md-3">
                                        <div class="mb-1 row">
                                            <label for="type" class="col-sm-4 col-form-label-lg"
                                                   style="padding-right: 0; padding-top: 10px">{{__('account-item')}}</label>
                                            <div class="col-sm-8" style="padding-left: 0">
                                                <select class="form-select" id="type" name="account_keyword">
                                                    <option value="">{{__('all')}}</option>
                                                    @foreach($accounts as $item)
                                                        <option value="{{$item['keyword_id']}}">{{$item['subject']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-1 row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="colFormLabel" name="keyword"
                                                       placeholder="{{__('keyword-input')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn background-sky color-white mr-2" id="btn_get_table"
                                                onclick="event.preventDefault();getCostTableData('{{route('client.cost-table')}}')">{{__('search')}}
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check form-check-inline" style="padding-top: 7px">
                                            <input class="form-check-input" type="checkbox" id="down_item"/>
                                            <label class="form-check-label" for="down_item">{{__('down-item-show')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding-top: 7px">
                                        <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                            <label style="margin-right: 5px;">{{__('background')}}</label>
                                            <label class="px-1" style="background: #ffecd9; border: 1px solid; border-radius: 5px; margin-right: 5px;">{{__('not-read')}}</label>
                                            <label class="px-1" style="border: 1px solid; border-radius: 5px; margin-right: 5px;">{{__('read')}}</label>
                                            <label class="px-1" style="background: rgba(34, 41, 47, 0.1); border: 1px solid; border-radius: 5px">{{__('exported')}}</label>
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
    <div class="modal fade" id="imageModal" tabindex="-1" data-bs-backdrop="true" aria-hidden="false">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="" id="img_show" style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        addEventListener('pageshow', (event) => {
            getCostTableData('{{route('client.cost-table')}}');
        });
        $(document).ready(function () {
            const interval = setInterval(function() {
                getCostTableData('{{route('client.cost-table')}}')
            }, 60000)
            $('input#down_item').change(function () {
                getCostTableData('{{route('client.cost-table')}}')
            })
        })
        $(document).on('mouseenter', '.icon_img', function (){
            $('#imageModal').modal('toggle')
            $('#img_show')[0].src = '{{asset('upload').'/'}}' + $(this).data('url')
        })
        $(document).on('mouseleave', '.icon_img', function () {
            $('#imageModal').modal('hide')
        } )
    </script>
</x-app-layout>
