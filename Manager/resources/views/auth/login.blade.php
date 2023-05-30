<x-guest-layout>
    <style>
        #iframe_container{
            position: absolute;
            right: 0;
            top: 0;
            height: 100vh;
            width: 40%;
            overflow: hidden;
        }
        iframe{
            height: 2000px;
            position: absolute;
            width: 1800px;
            top: 0;
        }
        iframe>header{
            display: none;
        }
        iframe>#main{
            display: flex !important;
        }

        .vk_post_body {
            padding-bottom: 45px;
        }
        .vk_post_title {
            font-size: 18px;
            line-height: 1.4;
            font-weight: 700;
            margin-bottom: 0;
            padding-bottom: 0.5em;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .vk_post .vk_post_title a {
            color: #333333;
        }
        .vk_post .vk_post_date {
            font-size: 11px;
            margin-top: 0.4rem;
            color: #666666;
        }
        .main-section>.vk_posts>.vk_post-col-lg-12 .vk_post_excerpt {
            font-size: 14px;
            margin: 0.8rem 0;
            line-height: 1.6;
            opacity: .8;
        }
        .vk_post-btn-display .vk_post_btnOuter {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: right;
        }
        .vk_post .vk_post_btn {
            font-size: 12px;
            text-decoration: none;
            padding-left: 1rem;
            padding-right: 1rem;
            white-space: nowrap;
            cursor: pointer;
        }
    </style>
    <div class="auth-wrapper">
        <div class="auth-inner row m-0">
            <!-- Login-->
            <div class="d-flex col-lg-12 align-items-center auth-bg px-2 p-lg-5">
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 px-xl-2 mx-auto">
                    <h2 class="card-title fw-bold mb-1 text-center">{{__('manager-title')}}</h2>
                    <h3 class="card-text mb-2 text-center" id="current_time"></h3>
                    <form class="auth-login-form mt-2" id="login_form" action="{{ route('login') }}" method="POST" style="margin-top: 50px !important;">
                        @csrf
                        <div class="mb-1">
                            <label class="form-label" for="login-email">{{__('user-id')}}</label>
                            <input class="form-control" id="login-email" type="text" name="email" aria-describedby="login-email" autofocus="" tabindex="1" required/>
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">{{__('password')}}</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge" id="login-password" type="password" name="password" aria-describedby="login-password" tabindex="2" required/><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <button class="btn btn-dark" tabindex="4" style="margin: auto" onclick="event.preventDefault(); refreshToken();">{{__('login')}}</button>
                        </div>

                    </form>

                </div>
            </div>
            <!-- /Login-->
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $('.text-content').each(function (){
                let content = $(this).val();
                console.log(content);
                $(this).next().html(content);
            })
        })
        var csrfToken = $('[name="csrf_token"]').attr('content');
        function refreshToken(){
            $.get('refresh-csrf').done(function(data){
                csrfToken = data; // the new token
                //$('[name="_token"]').val(data);
                console.log(data);
                $( "#login_form" ).submit();
            });
        }
    </script>
</x-guest-layout>
