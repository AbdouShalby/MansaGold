@php($pageTitle = 'banners')
@extends('layouts.app')
@section('content')
    <script>
        function ShowThis(banner_path, banner_status, banner_url, created_at, updated_at) {
            if(banner_path !== '') {
                $("#avatar").attr("src", "{{ asset('') }}" + base64_decode(banner_path));
            } else {
                $("#avatar").attr("src", "{{ asset('img/no-img.png') }}");
            }

            if(banner_status == 0) {
                $("#banner_status").html('<span class="badge badge-danger">{{ __('banner.status.disabled') }}</span>');
            } else {
                $("#banner_status").html('<span class="badge badge-success">{{ __('banner.status.activated') }}</span>');
            }

            $("#banner_url").text(banner_url);

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
        @if(isset($banners) && count($banners) > 0)
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
                        <h2 class="mb-4">{{ __('banner.no.banners') }}</h2>
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
                                        <img id="avatar" src="" class="img-fluid rounded-circle" alt="Avatar Image">
                                    </div>

                                    <div class="card-body">
                                        <p class="py-2 text-black-50" id="banner_url"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="contact-info px-4">
                                <div class="mb-1" id="banner_status">
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
