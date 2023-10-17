@extends('layouts.front-end.app')

@section('title',auth('customer')->user()->f_name.' '.auth('customer')->user()->l_name)


@section('content')
    <!-- Page Title-->
    <div class="container rtl">
        <h3 class="py-3 m-0 text-center headerTitle">{{translate('profile_Info')}}</h3>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl">
        <div class="row g-3">
        <!-- Sidebar-->
        @include('web-views.partials._profile-aside')
        <!-- Content  -->
            <section class="col-lg-9 col-md-9 __customer-profile">
                <div class="card box-shadow-sm">
                    <div class="card-header">
                        <form class="mt-3 px-sm-2 pb-2" action="{{route('user-update')}}" method="post"
                              enctype="multipart/form-data">
                            <div class="row photoHeader g-3">
                                @csrf
                                <div class="d-flex mb-3 mb-md-0 align-items-center">
                                    <img id="blah"
                                        class="rounded-circle border __inline-48"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/profile')}}/{{$customerDetail['image']}}">

                                    <div class="{{Session::get('direction') === "rtl" ? 'pr-2' : 'pl-2'}}">
                                        <h5 class="font-name">{{$customerDetail->f_name. ' '.$customerDetail->l_name}}</h5>
                                        <label for="files"
                                            style="cursor: pointer; color:{{$web_config['primary_color']}};"
                                            class="spandHeadO m-0">
                                            {{translate('change_your_profile')}}
                                        </label>
                                        <span class="text-danger __text-10px">( * {{translate('image_ratio_should_be')}} 1:1 )</span>
                                        <input id="files" name="image" hidden type="file">
                                    </div>
                                </div>


                                <div class="card-body mt-md-3 p-0">
                                    <h3 class="font-nameA">{{translate('account_information')}} </h3>


                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="firstName">{{translate('first_name')}} </label>
                                            <input type="text" class="form-control" id="f_name" name="f_name"
                                                   value="{{$customerDetail['f_name']}}" required>
                                        </div>
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="lastName"> {{translate('last_name')}} </label>
                                            <input type="text" class="form-control" id="l_name" name="l_name"
                                                   value="{{$customerDetail['l_name']}}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="inputEmail4">{{translate('email')}} </label>
                                            <input type="email" class="form-control" type="email" id="account-email"
                                                   value="{{$customerDetail['email']}}" disabled>
                                        </div>
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="phone">{{translate('phone_number')}} </label>
                                            <small class="text-primary">(
                                                * {{translate('country_code_is_must_like_for_BD')}} 880
                                                )</small></label>
                                            <input type="number" class="form-control" type="text" id="phone"
                                                   name="phone"
                                                   value="{{$customerDetail['phone']}}" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="si-password">{{translate('new_password')}}</label>
                                            <div class="password-toggle">
                                                <input class="form-control" name="password" type="password"
                                                       placeholder="{{translate('minimum_8_characters_long')}}" id="password"
                                                >
                                                <label class="password-toggle-btn">
                                                    <input class="custom-control-input" type="checkbox"
                                                           style="display: none">
                                                    <i class="czi-eye password-toggle-indicator"
                                                       onChange="checkPasswordMatch()"></i>
                                                    <span
                                                        class="sr-only">{{translate('show_password')}} </span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 mb-0">
                                            <label for="newPass">{{translate('confirm_password')}} </label>
                                            <div class="password-toggle">
                                                <input class="form-control" name="confirm_password" type="password"
                                                       placeholder="{{translate('minimum_8_characters_long')}}" id="confirm_password">
                                                <div>
                                                    <label class="password-toggle-btn">
                                                        <input class="custom-control-input" type="checkbox"
                                                               style="display: none">
                                                        <i class="czi-eye password-toggle-indicator"
                                                           onChange="checkPasswordMatch()"></i><span
                                                            class="sr-only">{{translate('show_password')}} </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id='message'></div>
                                        </div>
                                        <div class="col-12 d-flex flex-wrap justify-content-between __gap-15 __profile-btns">
                                             <a class="btn btn-danger"
                                                 href="javascript:"
                                                 onclick="route_alert('{{ route('account-delete',[$customerDetail['id']]) }}','{{translate('want_to_delete_this_account')}}?')">
                                                 {{translate('delete_account')}}
                                             </a>
                                             <button type="submit" class="btn btn--primary">{{translate('update')}}   </button>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>
    <script>
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            $("#message").removeAttr("style");
            $("#message").html("");
            if (confirmPassword == "") {
                $("#message").attr("style", "color:black");
                $("#message").html("{{translate('please_ReType_Password')}}");

            } else if (password == "") {
                $("#message").removeAttr("style");
                $("#message").html("");

            } else if (password != confirmPassword) {
                $("#message").html("{{translate('passwords_do_not_match')}}!");
                $("#message").attr("style", "color:red");
            } else if (confirmPassword.length <= 6) {
                $("#message").html("{{translate('password_Must_Be_6_Character')}}");
                $("#message").attr("style", "color:red");
            } else {

                $("#message").html("{{translate('passwords_match')}}.");
                $("#message").attr("style", "color:green");
            }

        }

        $(document).ready(function () {
            $("#confirm_password").keyup(checkPasswordMatch);

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#files").change(function () {
            readURL(this);
        });

    </script>
    <script>
        function form_alert(id, message) {
            Swal.fire({
                title: '{{translate('are_you_sure')}}?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#' + id).submit()
                }
            })
        }
    </script>
@endpush
