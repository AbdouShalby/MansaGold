@php($pageTitle = 'codes')
@extends('layouts.app')
@section('content')
    <script>
        function ShowThis(code_key, group_id, code_balance, code_status, used_at, created_at, updated_at) {
            let decoded_key = base64_decode(code_key);
            let formatted_key = decoded_key.replace(/(.{4})/g, "$1-");
            formatted_key = formatted_key.slice(0, -1); // remove the last "-" character
            $("#code_key").val(formatted_key);

            $("#group_id").text(group_id);

            $("#code_balance").text('{{ __('codes.balance') }}' + ': ' + code_balance);

            if(code_status == 0) {
                $("#code_status").html('<span class="badge badge-success">{{ __('codes.no.not-used') }}</span>');
            } else {
                $("#code_status").html('<span class="badge badge-danger">{{ __('codes.expired') }}</span>');
            }

            if(used_at !== '') {
                $("#used_at").text(used_at);
            } else {
                $("#used_at").text('{{ __('codes.no.not-used') }}');
            }

            $("#created_at").text(created_at);

            $("#updated_at").text(updated_at);
        }

        function base64_encode(s) {
            return btoa(encodeURIComponent(s));
        }
        function base64_decode(s) {
            return decodeURIComponent(atob(s));
        }
    </script>

    <div class="content">
        @if(isset($codes) && count($codes) > 0)
        <div class="row">
            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-1 col-12" role="alert">
                    {{ $message }}
                </div>
            @endif
            @foreach($codes as $code)
            <div class="col-lg-6 col-xl-4 col-xxl-3">
                <div class="card card-default mt-6 mb-4">
                    <div class="card-body text-center p-4">
                        <a href="javascript:;"
                            onclick="ShowThis('{{ base64_encode($code->code_key) }}','{{ $code->group_id }}','{{ $code->code_balance }}','{{ $code->code_status }}','{{ $code->used_at }}','{{ $code->created_at }}','{{ $code->updated_at }}')" data-toggle="modal" data-target="#modal-contact" class="text-secondary d-inline-block mb-3">

                            <div class="image mb-3 mt-n9">
                                    <img src="{{ asset('img/code.png') }}" class="img-fluid rounded-circle" alt="Avatar Image" style="width: 128px">
                            </div>

                            <h5 class="card-title text-dark">{{ rtrim(chunk_split($code->code_key, 4, '-'), '-') }}</h5>
                        </a>

                        <div class="row justify-content-center">
                            <div class="col-4 px-1">
                                <a href="{{ route('edit.code', $code->id) }}" class="mb-1 btn btn-pill btn-outline-success"><i class="mdi mdi-square-edit-outline"></i></a>
                            </div>
                            <div class="col-4 px-1">
                                <a href="{{ route('delete.code', $code->id) }}" class="mb-1 btn btn-pill btn-outline-danger"><i class="mdi mdi-delete"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <!-- Recent Order Table -->
                <div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                        <h2 class="mb-4">{{ __('codes.no.codes') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Contact Modal -->
    <div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-end border-bottom-0">
                    <button type="button" class="btn-close-icon" data-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close"></i>
                    </button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <div class="profile-content-left px-4">
                                <div class="card text-center widget-profile px-0 border-0">
                                    <div class="card-img mx-auto rounded-circle">
                                        <img id="avatar" src="{{ asset('img/code.png') }}" class="img-fluid rounded-circle" alt="Avatar Image">
                                    </div>

                                    <div class="card-body">
                                        <input name="key" type="text" class="form-control text-center" id="code_key" onfocus="selectInputText()" readonly>
                                        <div class="input-group-append mt-1">
                                            <button type="button" class="btn btn-success m-auto" id="copy-code-btn" onclick="copyCode()">Copy <i class="mdi mdi-content-copy"></i></button>
                                        </div>
                                        <script>
                                            function selectInputText() {
                                                var input = document.getElementById("code_key");
                                                input.setSelectionRange(0, input.value.length); // Select all text in the input field
                                            }

                                            function copyCode() {
                                                var button = document.getElementById("copy-code-btn");
                                                var input = document.getElementById("code_key");

                                                if (input.value === "") {
                                                    button.innerHTML = '<span>Empty</span> <i class="mdi mdi-alert"></i>';
                                                    button.classList.remove("btn-success");
                                                    button.classList.add("btn-danger");
                                                    setTimeout(function() {
                                                        button.innerHTML = '<span>Copy</span> <i class="mdi mdi-content-copy"></i>';
                                                        button.classList.remove("btn-danger");
                                                        button.classList.add("btn-success");
                                                    }, 2000);
                                                } else {
                                                    input.select(); // Select all text in the input field
                                                    document.execCommand("copy"); // Copy the selected text to the clipboard
                                                    button.innerHTML = '<span>Copied</span> <i class="mdi mdi-check"></i>';
                                                    button.classList.add("copied");
                                                    setTimeout(function() {
                                                        button.innerHTML = '<span>Copy</span> <i class="mdi mdi-content-copy"></i>';
                                                        button.classList.remove("copied");
                                                    }, 2000);
                                                }
                                            }
                                        </script>
                                        <p class="py-2 text-black-50" id="code_balance"></p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between ">
                                    <div class="text-center pb-4" id="phone">
                                        <h6 class="text-dark pb-2"></h6>
                                    </div>

                                    <div class="text-center pb-4" id="country">
                                        <h6 class="text-dark pb-2"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="contact-info px-4">
                                <div class="mb-1" id="code_status">
                                </div>
                                <p class="text-dark font-weight-medium pt-4 mb-2" >{{ __('groups.created') }}</p>
                                <p id="created_at"></p>
                                <p class="text-dark font-weight-medium pt-4 mb-2">{{ __('groups.updated') }}</p>
                                <p id="updated_at"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
