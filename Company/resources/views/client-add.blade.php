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
                                    <h4 class="card-title mb-0">{{isset($user) ?__('client-detail') : __('client-add')}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <form class="form" id="save_form">
                                @csrf
                                <input type="hidden" name="id" value="{{isset($user) ? $user->id : ''}}">
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="company-code" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('user-code')}}</label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <input type="text" id="company-code" class="form-control" placeholder="" value="{{isset($user) ? $user->user_code : $code}}" tabindex="1" disabled data-index="1"/>
                                                <input type="hidden" name="user_code" value="{{isset($user) ? $user->user_code : $code}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="client-name" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('client-name')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <input type="text" id="client-name" class="form-control" name="name" placeholder="" value="{{isset($user) ? $user->name : ''}}" required tabindex="1" data-index="1"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="user-id" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('user-id')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <input type="email" id="user-id" class="form-control" name="email" placeholder="" value="{{isset($user) ? $user->email : ''}}" required tabindex="3" data-index="3"/>
                                            </div>
                                            <label class="col-sm-4 ps-0" style="padding-top: 10px">{{__('half-string')}}</label>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="password" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('password')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <input type="password" id="user-id" class="form-control" name="password" placeholder="" {{isset($user) ? '' : 'required'}} minlength="8" tabindex="4" data-index="4"/>
                                            </div>
                                            <label class="col-sm-4 ps-0" style="padding-top: 10px">{{__('half-string')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="represent" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('represent')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <input type="text" id="represent" class="form-control" name="represent" placeholder="" value="{{isset($user) ? $user->represent : ''}}" required tabindex="11"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="charge" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('charge')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <input type="text" id="charge" class="form-control" name="charge" placeholder="" value="{{isset($user) ? $user->charge : ''}}" required tabindex="12"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="type" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0; padding-top: 10px">{{__('type')}}</label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <select class="form-select" id="type" name="type" tabindex="2" data-index="2">
                                                    <option value="1" {{isset($user) && $user->type == 1 ? 'selected' : ''}}>{{__('co-op')}}</option>
                                                    <option value="2" {{isset($user) && $user->type == 2 ? 'selected' : ''}}>{{__('solo-pro')}}</option>
                                                    <option value="3" {{isset($user) && $user->type == 3 ? 'selected' : ''}}>{{__('alone')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="status" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('status')}}</label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <select class="form-select" id="status" name="status" tabindex="14">
                                                    <option value="1" {{isset($user) && $user->status == 1 ? 'selected' : ''}}>{{__('enable')}}</option>
                                                    <option value="0" {{isset($user) && $user->status == 0 ? 'selected' : ''}}>{{__('stop')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-12">
                                        <div class="mb-1 row">
                                            <label for="post_code" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('post-code')}} <span class="color-red-tmp">*</span></label>
                                            <div class="col-sm-3 ps-0">
                                                <input type="number" id="post_code_zip" class="form-control" name="post_code" placeholder="" value="{{isset($user) ? $user->post_code : ''}}" minlength="7" required tabindex="5"/>
                                            </div>
                                            <div class="col-sm-1 px-0">
                                                <button type="button" class="btn btn-dark btn_search_address px-1" onclick="event.preventDefault()">{{__('search-address')}}</button>
                                            </div>
                                            <label class="col-sm-2 ps-0" style="padding-top: 10px">{{__('half-string')}} {{__('no-hyphen')}}</label>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-12">
                                        <div class="mb-1 row">
                                            <label for="prefecture" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('prefecture')}}</label>
                                            <div class="col-sm-3 ps-0">
                                                <input type="text" id="prefecture" class="form-control" name="prefecture" value="{{isset($user) ? $user->prefecture : ''}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-12">
                                        <div class="mb-1 row">
                                            <label for="city" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('city')}}</label>
                                            <div class="col-sm-6 ps-0">
                                                <input type="text" id="city" class="form-control" name="city" value="{{isset($user) ? $user->city : ''}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-12">
                                        <div class="mb-1 row">
                                            <label for="town" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('town')}}</label>
                                            <div class="col-sm-6 ps-0">
                                                <input type="text" id="town" class="form-control" name="town" value="{{isset($user) ? $user->town : ''}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-12">
                                        <div class="mb-1 row">
                                            <label for="after" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('after')}}</label>
                                            <div class="col-sm-6 ps-0">
                                                <input type="text" id="after" class="form-control" name="after" value="{{isset($user) ? $user->after : ''}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <div class="mb-1 row">
                                            <label for="contact" class="col-sm-2 col-form-label-lg"
                                                   style="padding-right: 0">{{__('contact')}}</label>
                                            <div class="col-sm-6" style="padding-left: 0">
                                                <input type="text" id="contact" class="form-control" name="contact" placeholder="" value="{{isset($user) ? $user->contact : ''}}" required tabindex="2"/>
                                            </div>
                                            <label class="col-sm-4 ps-0" style="padding-top: 10px">{{__('half-string')}}</label>
                                        </div>
                                    </div>
                                    <div class="mb-1 col-md-12">
                                        <div class="mb-1 row">
                                            <label for="remarks" class="col-sm-1 col-form-label-lg"
                                                   style="padding-right: 0">{{__('remarks')}}</label>
                                            <div class="col-sm-11" style="padding-left: 0">
                                                <textarea rows="5" id="remarks" class="form-control" name="remarks" placeholder="" tabindex="11" data-index="11">{{isset($user) ? $user->remarks : ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-12 text-center">
                                        <button type="button" class="btn btn-warning me-1 btn_submit" onclick="event.preventDefault();saveForm('{{route('company.client-save')}}')" tabindex="12">{{__('register')}}</button>
                                        @if(isset($user))
                                            <button type="reset" class="btn btn-danger waves-effect waves-float waves-light me-1" onclick="event.preventDefault();deleteData({{$user->id}}, '{{route('company.client-delete')}}')" tabindex="13">{{__('delete')}}</button>
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
