@php($pageTitle = 'logs')
@extends('layouts.app')
@section('content')
    <div class="content">
        @if(isset($logs) && count($logs) > 0)
        <div class="row">
            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-1 col-12" role="alert">
                    {{ $message }}
                </div>
            @endif
            @foreach($banners as $banner)
            <div class="col-lg-6 col-xl-4 col-xxl-3">
                <div class="card card-default mt-6 mb-4">
                    <div class="card-body text-center p-4">
                        <a href="javascript:;"
                            onclick="ShowThis('{{ base64_encode($banner->banner_path) }}','{{ $banner->banner_status }}','{{ $banner->banner_url }}','{{ $banner->created_at }}','{{ $banner->updated_at }}')" data-toggle="modal" data-target="#modal-contact" class="text-secondary d-inline-block mb-3">

                            <div class="image mb-3 mt-n9">
                                @if($banner->banner_path != null)
                                    <img src="{{ $banner->banner_path }}" class="img-fluid rounded-circle" alt="Avatar Image" style="width: 128px">
                                @else
                                    <img src="{{ asset('img/no-img.png') }}" class="img-fluid rounded-circle" alt="Avatar Image" style="width: 128px">
                                @endif
                            </div>
                        </a>

                        <div class="row justify-content-center">
                            <div class="col-4 px-1">
                                <a href="{{ route('edit.banner', $banner->id) }}" class="mb-1 btn btn-pill btn-outline-success"><i class="mdi mdi-square-edit-outline"></i></a>
                            </div>
                            <div class="col-4 px-1">
                                <a href="{{ route('delete.banner', $banner->id) }}" class="mb-1 btn btn-pill btn-outline-danger"><i class="mdi mdi-delete"></i></a>
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
                        <h2 class="mb-4">{{ __('logs.empty') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
