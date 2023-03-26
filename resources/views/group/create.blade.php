@php($pageTitle = 'groups')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>{{ __('groups.groups.create') }}</h2>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-1" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('store.group') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="{{ __('groups.name') }}">{{ __('groups.name') }}</label>
                                <input type="text" name="group_name" class="form-control" id="{{ __('groups.name') }}" placeholder="{{ __('groups.name') }}" required>
                                @error('group_name')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('groups.max') }}">{{ __('groups.max') }}</label>
                                <input type="text" name="group_max" class="form-control" id="{{ __('groups.max') }}" placeholder="{{ __('groups.max') }}" required>
                                @error('group_max')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('groups.gain') }}">{{ __('groups.gain') }}</label>
                                <input type="text" name="group_gain" class="form-control" id="{{ __('groups.gain') }}" placeholder="{{ __('groups.gain') }}" required>
                                @error('group_gain')
                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('groups.avatar') }}">{{ __('groups.avatar') }}</label>
                                <input type="file" name="group_avatar" class="form-control-file" id="{{ __('groups.avatar') }}" accept="image/*" required>
                                @error('group_avatar')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
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
