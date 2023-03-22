@php($pageTitle = 'users')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>{{ __('users.users.create') }}</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store.user') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="{{ __('users.name') }}">{{ __('users.name') }}</label>
                                <input type="text" name="name" class="form-control" id="{{ __('users.name') }}" placeholder="{{ __('users.name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('users.email') }}">{{ __('users.email') }}</label>
                                <input type="email" name="email" class="form-control" id="{{ __('users.email') }}" placeholder="{{ __('users.email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('Password') }}">{{ __('Password') }}</label>
                                <input type="password" name="password" class="form-control" id="{{ __('Password') }}" placeholder="{{ __('Password') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('Confirm Password') }}">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" class="form-control" id="{{ __('Confirm Password') }}" placeholder="{{ __('Confirm Password') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('users.phone') }}">{{ __('users.phone') }}</label>
                                <input type="text" name="phone" class="form-control" id="{{ __('users.phone') }}" placeholder="{{ __('users.phone') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('users.country') }}">{{ __('users.country') }}</label>
                                <input type="text" name="country" class="form-control" id="{{ __('users.country') }}" placeholder="{{ __('users.country') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('users.status') }}">{{ __('users.status') }}</label>
                                <select class="form-control" id="{{ __('users.status') }}" name="status" required>
                                    <option selected value="0">{{ __('users.no-groups-to-see') }}</option>
                                    <option value="1">{{ __('users.see-all-groups') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('users.role') }}">{{ __('users.role') }}</label>
                                <select class="form-control" id="{{ __('users.role') }}" name="role" required>
                                    <option selected value="0">{{ __('users.normal') }}</option>
                                    <option value="1">{{ __('users.admin') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="{{ __('users.avatar') }}">{{ __('users.avatar') }}</label>
                                <input type="file" name="avatar" class="form-control-file" id="{{ __('users.avatar') }}" required>
                            </div>
                            <div class="form-footer pt-4 pt-5 mt-4 border-top">
                                <button type="submit" class="btn btn-primary btn-default">{{ __('groups.buttons.create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
