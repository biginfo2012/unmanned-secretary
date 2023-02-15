<x-app-layout>
    <!--begin::Content-->
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
                        <div class="card-body mt-1">
                            <form class="form" id="save_form">
                                @csrf
                                <input type="hidden" name="id" value="{{isset($data) ? $data->id : ''}}">
                                <div class="row border-bottom">
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
                                <div class="row mt-1">
                                    <div class="col-md-12">
                                        <h5 class="mb-0">{{__('cost-detail')}}</h5>
                                    </div>
                                    <div class="mb-0 col-md-6">
                                        <div class="mb-0 row">
                                            <label for="contact" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('shop-name')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{isset($data['shop_id']) ? $data['shop']['shop_name'] : ""}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-md-6">
                                        <div class="mb-0 row">
                                            <label for="contact" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('pay-date')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{$data['pay_date']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-md-6">
                                        <div class="mb-0 row">
                                            <label for="contact" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('total')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{$data['total']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-md-6">
                                        <div class="mb-0 row">
                                            <label for="contact" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('percent')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{$data['percent']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-md-12">
                                        <div class="mb-0 row">
                                            <label for="remarks" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('photo')}}</label>
                                            <div class="col-sm-11" style="padding-left: 0">
                                                @if(!empty($data['url']))
                                                    <img class="mb-0" style="margin-top: 10px; max-width: 100%; height: auto" src="{{'http://localhost:8072/public/upload/'.$data['url']}}">
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-md-12">
                                        <div class="mb-0 row">
                                            <label for="remarks" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('content')}}</label>
                                            <div class="col-sm-11" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{$data['content']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-md-12">
                                        <div class="mb-0 row">
                                            <label for="remarks" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('note')}}</label>
                                            <div class="col-sm-11" style="padding-left: 0">
                                                <p class="mb-0" style="margin-top: 10px">{{$data['note']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
{{--                                        <button type="button" class="btn btn-primary me-1 btn_submit" onclick="event.preventDefault();saveForm('{{route('company.client-save')}}')" tabindex="12">{{__('register')}}</button>--}}
                                        <button type="reset" class="btn btn-dark waves-effect waves-float waves-light me-1" onclick="event.preventDefault();deleteData({{$data->id}}, '{{route('company.client-cost-delete')}}')" tabindex="13">{{__('delete')}}</button>
                                        <label class="btn btn-outline-secondary waves-effect " tabindex="14" id="btn_cancel">{{__('cancel')}}</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end::Content-->
</x-app-layout>
