<x-app-layout>
    <!--begin::Content-->
    <style>
        #cost-img {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .img-viewer{
            width: 100% !important;
            height: 100% !important;
        }
        .viewer-download{
            background-image: url({{asset('icon/download.png')}});
            background-repeat: no-repeat;
            background-position: center;
            background-size: 17px;
        }
        #cost-img:hover {opacity: 0.7;}
    </style>
    <div class="content-body">
        <!-- Ajax Sourced Server-side -->
        <section>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div
                                class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                                    <h4 class="card-title mb-0">{{__('cost-detail')}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-0">
                            <form class="form" id="save_form">
                                @csrf
                                <input type="hidden" name="id" value="{{isset($data) ? $data->id : ''}}">
                                <div class="row border-bottom d-none">
                                    <div class="col-md-12">
                                        <h5 class="mb-0">{{__('client-detail')}}</h5>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-0 row">
                                            <label for="client-name" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('client-name')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{$data['user']['name']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-0 row">
                                            <label for="type" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0; padding-top: 10px">ID</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <div class="col-sm-10" style="padding-left: 0">
                                                    <p class="mb-0" style="margin-top: 10px">{{$data['user']['email']}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-0">
                                    <div class="mb-0 col-md-6">
                                        <div class="mb-0 row" style="height: 100%;">
                                            <label for="remarks" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0; align-self: auto">{{__('photo')}}</label>
                                            <div class="col-sm-9">
                                                @if(!empty($data['url']))
                                                    <img class="d-none" id="image" src="{{asset('upload').'/'.$data['url']}}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-md-6">
                                        <div class="mb-0 row">
                                            <div class="mb-0 col-md-6">
                                                <div class="mb-0 row">
                                                    <label for="pay-date" class="col-sm-4 col-form-label-lg"
                                                           style="padding-right: 0">{{__('pay-date')}} <span class="color-red-tmp">*</span></label>
                                                    <div class="col-sm-8" style="padding-left: 0">
                                                        <input type="text" class="form-control flatpickr" id="pay-date" name="pay_date" placeholder="YYYY/MM/DD" required tabindex="1" data-index="1"
                                                               value="{{!empty($data['pay_date']) ? date('Y/m/d', strtotime($data['pay_date'])) : ""}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-0 col-md-6">
                                                <div class="mb-0 row">
                                                    <label for="shop-name" class="col-sm-4 col-form-label-lg"
                                                           style="padding-right: 0">{{__('cost-code')}}</label>
                                                    <div class="col-sm-8" style="padding-left: 0">
                                                        <input type="text" class="form-control" disabled value="{{!empty($data['cost_code']) ? $data['cost_code'] : ""}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-0 row">
                                            <label for="shop-name" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('summary')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="shop-name" class="form-control" name="shop_name"
                                                       value="{{!empty($data['shop_id']) ? $data['shop']['shop_name'] : ""}}" tabindex="1" data-index="1"/>
                                            </div>
                                        </div>
                                        <div class="mb-0 row">
                                            <label for="account_id" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('account-item')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <select class="form-select" id="account_id" name="account_id" tabindex="2" data-index="2">
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->keyword_id}}" {{!empty($data['account_id']) && $account->keyword_id == $myaccount['keyword_id'] ? 'selected' : ''}}>{{$account->subject}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-0 row">
                                            <label for="total" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('amount')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <div class="input-group input-group-merge">
                                                    <input type="number" class="form-control" id="total" name="total" tabindex="4" data-index="4"
                                                           value="{{$data['total']}}"/>
                                                    <span class="input-group-text">円</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-0 row">
                                            <label for="percent" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('percent')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <select class="form-select" id="percent" name="percent" tabindex="2" data-index="2">
                                                    <option value="8" {{$data['percent'] == 8 ? 'selected' : ''}}>8％</option>
                                                    <option value="10" {{$data['percent'] == 10 ? 'selected' : ''}}>10％</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 5px">
                                            <label for="content" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('content')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <textarea rows="3" id="content" class="form-control" name="contents" placeholder="" tabindex="6" data-index="6">{{$data->content}}</textarea>
                                            </div>
                                        </div>
                                        <div class="mb-0 row">
                                            <label for="note" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('note')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <textarea rows="3" id="note" class="form-control" name="note" placeholder="" tabindex="7" data-index="7">{{$data->note}}</textarea>
                                            </div>
                                        </div>
                                        <div class="mb-0 row">
                                            <label for="remarks" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('import-date')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{date('Y/m/d', strtotime($data['created_at']))}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-12 text-center">
                                        <a type="button" class="dt-button add-new btn btn-primary me-1" id="cost_export_pdf"
                                           href="{{route('client.cost-export-pdf', $data->id)}}">
                                            <i data-feather='download'></i>{{__('report')}}
                                        </a>
                                        <button type="button" class="btn btn-primary me-1 btn_submit" onclick="event.preventDefault();saveForm('{{route('client.cost-save')}}')" tabindex="8">{{__('register')}}</button>
                                        <button type="reset" class="btn btn-dark waves-effect waves-float waves-light me-1" onclick="event.preventDefault();deleteData({{$data->id}}, '{{route('client.cost-delete')}}')" tabindex="9">{{__('delete')}}</button>
                                        <label class="btn btn-outline-secondary waves-effect " tabindex="10" id="btn_cancel">{{__('cancel')}}</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- The Modal -->
    <div class="modal fade text-start" id="imageModal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="width: fit-content">
            <div class="modal-content" style="background: transparent; box-shadow: none !important; width: fit-content">
                <button class="color-white position-absolute border-0 btn-search-sp"
                        style="right: -30px; top: -30px; height: 30px; background: transparent;"
                        data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather='x-circle' class="font-medium-5"></i>
                </button>
                <div class="modal-body p-0 text-center">
                    <img id="modal-img" style="max-width: 100%; max-height: 85vh; width: auto; height: auto">
                </div>
            </div>
        </div>
    </div>
    <!--end::Content-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.css">
    <script>
        let image = document.getElementById('image')
        const viewer = new Viewer(image, {
            className: "img-viewer",
            inline: true,
            title: false,
            toolbar: {
                zoomIn: function (){
                    viewer.zoom(0.5);
                },
                zoomOut: function (){
                    viewer.zoom(-0.5);
                },
                // oneToOne: 4,
                // reset: 4,
                rotateLeft: 1,
                rotateRight: 1,
                // flipHorizontal: 4,
                // flipVertical: 4,
                download: function () {
                    const a = document.createElement('a');
                    a.href = viewer.image.src;
                    a.download = viewer.image.alt;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                },
            },
        });
    </script>
</x-app-layout>
