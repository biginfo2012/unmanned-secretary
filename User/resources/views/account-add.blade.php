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
                                    <h4 class="card-title mb-0">{{isset($account) ? __('account-detail') : __('account-add')}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <form class="form" id="save_form">
                                @csrf
                                <input type="hidden" name="id" value="{{isset($account) ? $account->id : ''}}">
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="account-subject" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('account-subject')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="account-subject" class="form-control" name="subject" placeholder="" value="{{isset($account) ? $account->subject : ''}}" required tabindex="1" data-index="1"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="type" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0; padding-top: 10px">{{__('type')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <select class="form-select" id="type" name="type" tabindex="2" data-index="2">
                                                    @foreach($types as $type)
                                                        <option value="{{$type->id}}" {{isset($account) && $account->type == $type->id ? 'selected' : ''}}>{{$type->tax_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="account-assistant" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('assi-subject')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="account-assistant" class="form-control" name="assistant" placeholder="" value="{{isset($account) ? $account->assistant : ''}}" tabindex="3" data-index="3"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="code" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('subject-code')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="code" class="form-control" name="code" placeholder="" value="{{isset($account) ? $account->code : ''}}" tabindex="4" data-index="4"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="keyword" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('keyword')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="keyword" class="form-control" name="keyword" placeholder="" value="{{isset($account) ? $account->keyword : ''}}" required tabindex="5" data-index="5"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="button" class="btn btn-primary me-1 btn_submit" onclick="event.preventDefault();saveForm('{{route('client.account-save')}}')" tabindex="12">{{__('register')}}</button>
                                        @if(isset($account))
                                            <button type="reset" class="btn btn-dark waves-effect waves-float waves-light me-1" onclick="event.preventDefault();deleteData({{$account->id}}, '{{route('client.account-delete')}}')" tabindex="13">{{__('delete')}}</button>
                                        @endif
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
