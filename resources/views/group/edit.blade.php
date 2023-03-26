@php($pageTitle = 'groups')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>{{ __('groups.groups.edit') }}</h2>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-1" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('update.group', $group->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="{{ __('groups.name') }}">{{ __('groups.name') }}</label>
                                <input type="text" name="group_name" class="form-control" id="{{ __('groups.name') }}" placeholder="{{ __('groups.name') }}" value="{{ $group->group_name }}" required>
                                @error('group_name')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('groups.max') }}">{{ __('groups.max') }}</label>
                                <input type="text" name="group_max" class="form-control" id="{{ __('groups.max') }}" placeholder="{{ __('groups.max') }}" value="{{ $group->group_max_subscription }}" required>
                                @error('group_max')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('groups.gain') }}">{{ __('groups.gain') }}</label>
                                <input type="text" name="group_gain" class="form-control" id="{{ __('groups.gain') }}" placeholder="{{ __('groups.gain') }}" value="{{ $group->group_gain }}" required>
                                @error('group_gain')
                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('groups.status.title') }}">{{ __('groups.status.title') }}</label>
                                <select class="form-control" id="{{ __('groups.status.title') }}" name="group_status" required>
                                    <option {{ $group->group_status == 0 ? 'selected' : '' }} value="0">{{ __('groups.status.available') }}</option>
                                    <option {{ $group->group_status == 1 ? 'selected' : '' }} value="1">{{ __('groups.status.completed') }}</option>
                                    <option {{ $group->group_status == 2 ? 'selected' : '' }} value="2">{{ __('groups.status.manufacturing') }}</option>
                                    <option {{ $group->group_status == 3 ? 'selected' : '' }} value="3">{{ __('groups.status.cancelled') }}</option>
                                </select>
                                @error('group_status')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('groups.avatar') }}">{{ __('groups.avatar') }}</label>
                                <input type="file" name="group_avatar" class="form-control-file" id="{{ __('groups.avatar') }}" accept="image/*">
                                @error('group_avatar')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-footer pt-4 pt-5 mt-4 border-top">
                                <button type="submit" class="btn btn-primary btn-default">{{ __('groups.buttons.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
