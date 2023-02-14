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
                                            <label for="account-name" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('client-name')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="client-name" class="form-control" name="name" placeholder="" value="{{isset($account) ? $account->name : ''}}" required tabindex="1" data-index="1"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="type" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0; padding-top: 10px">{{__('type')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <select class="form-select" id="type" name="type" tabindex="2" data-index="2">
                                                    <option value="1">{{__('co-op')}}</option>
                                                    <option value="2">{{__('sole-pro')}}</option>
                                                    <option value="3">{{__('alone')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="user-id" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">ID</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="email" id="user-id" class="form-control" name="email" placeholder="" value="{{isset($account) ? $account->email : ''}}" required tabindex="3" data-index="3"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="password" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('password')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="password" id="user-id" class="form-control" name="password" placeholder="" {{isset($account) ? '' : 'required'}} minlength="8" tabindex="4" data-index="4"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="post-code" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('post-code')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="number" id="post-code" class="form-control" name="post_code" placeholder="" value="{{isset($account) ? $account->post_code : ''}}" minlength="7" required tabindex="5" data-index="5"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="address" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('address')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="address" class="form-control" name="address" placeholder="" value="{{isset($account) ? $account->address : ''}}" required tabindex="6" data-index="6"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="contact" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('represent')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="represent" class="form-control" name="represent" placeholder="" value="{{isset($account) ? $account->represent : ''}}" required tabindex="7" data-index="7"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="charge" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('charge')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="text" id="charge" class="form-control" name="charge" placeholder="" value="{{isset($account) ? $account->charge : ''}}" required tabindex="8" data-index="8"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="contact" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('contact')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <input type="number" id="contact" class="form-control" name="contact" placeholder="" value="{{isset($account) ? $account->contact : ''}}" required tabindex="9" data-index="9"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="status" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('status')}}</label>
                                            <div class="col-sm-10" style="padding-left: 0">
                                                <select class="form-select" id="status" name="status" tabindex="10" data-index="10">
                                                    <option value="1" {{isset($account) && $account->status == 1 ? 'selected' : ''}}>{{__('enable')}}</option>
                                                    <option value="0" {{isset($account) && $account->status == 0 ? 'selected' : ''}}>{{__('stop')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-1 col-md-12">
                                        <div class="mb-1 row">
                                            <label for="remarks" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('remarks')}}</label>
                                            <div class="col-sm-11" style="padding-left: 0">
                                                <textarea rows="5" id="remarks" class="form-control" name="remarks" placeholder="" tabindex="11" data-index="11">{{isset($account) ? $account->remarks : ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="button" class="btn btn-primary me-1 btn_submit" onclick="event.preventDefault();saveForm('{{route('company.account-save')}}')" tabindex="12">{{__('register')}}</button>
                                        @if(isset($account))
                                            <button type="reset" class="btn btn-dark waves-effect waves-float waves-light me-1" onclick="event.preventDefault();deleteData({{$account->id}}, '{{route('company.account-delete')}}')" tabindex="13">{{__('delete')}}</button>
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
