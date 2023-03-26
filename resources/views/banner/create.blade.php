@php($pageTitle = 'banners')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>{{ __('banner.banner.create') }}</h2>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-1" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('store.banner') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="{{ __('banner.banner.banner') }}">{{ __('banner.banner.banner') }}</label>
                                <input type="file" name="banner" class="form-control-file" id="{{ __('banner.banner.banner') }}" accept="image/*" required>
                                @error('banner')
                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('banner.status.title') }}">{{ __('banner.status.title') }}</label>
                                <select class="form-control" id="{{ __('banner.status.title') }}" name="banner_status" required>
                                    <option selected value="0">{{ __('banner.status.disable') }}</option>
                                    <option value="1">{{ __('banner.status.active') }}</option>
                                </select>
                                @error('banner_status')
                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="{{ __('banner.url') }}">{{ __('banner.url') }}</label>
                                <input type="text" name="banner_url" class="form-control" id="{{ __('banner.url') }}" placeholder="{{ __('banner.url') }}">
                                @error('banner_url')
                                    <div class="alert alert-danger col-12 mt-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-footer pt-4 pt-5 mt-4 border-top">
                                <button type="submit" class="btn btn-primary btn-default">{{ __('banner.buttons.create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
