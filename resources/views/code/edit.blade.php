@php($pageTitle = 'codes')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>{{ __('codes.codes.edit') }}</h2>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-1" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('update.code', $code->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="code-input">{{ __('codes.code') }}</label>
                                <div class="input-group">
                                    <input name="key" type="text" class="form-control" id="code-input" onfocus="selectInputText()" value="{{ $code->code_key }}" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" id="copy-code-btn" onclick="copyCode()">Copy <i class="mdi mdi-content-copy"></i></button>
                                    </div>
                                    <script>
                                        function selectInputText() {
                                            var input = document.getElementById("code-input");
                                            input.setSelectionRange(0, input.value.length); // Select all text in the input field
                                        }

                                        function copyCode() {
                                            var button = document.getElementById("copy-code-btn");
                                            var input = document.getElementById("code-input");

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
                                </div>
                                @error('key')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('codes.balance') }}">{{ __('codes.balance') }}</label>
                                <input type="text" name="balance" class="form-control" id="{{ __('codes.balance') }}" placeholder="{{ __('codes.balance') }}" value="{{ $code->code_balance }}" required>
                                @error('balance')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('codes.code-group') }}">{{ __('codes.code-group') }}</label>
                                <select class="form-control" id="{{ __('codes.code-group') }}" name="group" required>
                                    @if(isset($groups) && count($groups) > 0)
                                        @foreach($groups as $group)
                                            <option {{ $group->id == $code->group_id ? 'selected' : '' }} value="{{ $group->id }}">{{ $group->group_name }}</option>
                                        @endforeach
                                    @else
                                        <option value="0">{{ __('codes.no.groups') }}</option>
                                    @endif
                                </select>
                                @error('group')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-footer pt-4 pt-5 mt-4 border-top">
                                <button type="submit" class="btn btn-primary btn-default">{{ __('codes.buttons.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
