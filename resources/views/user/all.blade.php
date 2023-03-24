@php($pageTitle = 'users')
@extends('layouts.app')
@section('content')
    <script>
        function ShowThis(name, email, phone, country, status, user_avatar, role, created, updated) {
            $("#name").text(base64_decode(name));

            if(email !== '') {
                $("#email").text(email);
            } else {
                $("#email").text('{{ __('users.no.email') }}');
            }

            if(phone !== '') {
                $("#phone").text(phone);
            } else {
                $("#phone").text('{{ __('users.no.phone') }}');
            }

            if(country !== '') {
                $("#country").text(country);
            } else {
                $("#country").text('{{ __('users.no.country') }}');
            }

            if(status == 0) {
                $("#status").html('<span class="badge badge-danger">{{ __('users.no-groups-to-see') }}</span>');
            } else {
                $("#status").html('<span class="badge badge-success">{{ __('users.see-all-groups') }}</span>');
            }

            if(user_avatar !== '') {
                $("#avatar").attr("src", "{{ asset('') }}" + base64_decode(user_avatar));
            } else {
                $("#avatar").attr("src", "{{ asset('img/no-img.png') }}");
            }

            if(role == 0) {
                $("#role").html('<span class="badge badge-info">{{ __('users.normal') }}</span>');
            } else {
                $("#role").html('<span class="badge badge-dark">{{ __('users.admin') }}</span>');
            }

            $("#created").text(created);
            $("#updated").text(updated);
        }

        function base64_encode(s) {
            return btoa(encodeURIComponent(s));
        }
        function base64_decode(s) {
            return decodeURIComponent(atob(s));
        }
    </script>

    <div class="content">
        @if(isset($users) && count($users) > 0)
        <div class="row">
            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-1 col-12" role="alert">
                    {{ $message }}
                </div>
            @endif
            @foreach($users as $user)
            <div class="col-lg-6 col-xl-4 col-xxl-3">
                <div class="card card-default mt-6 mb-4">
                    <div class="card-body text-center p-4">
                        <a href="javascript:;"
                            onclick="ShowThis('{{ base64_encode($user->name) }}','{{ $user->email }}','{{ $user->phone }}','{{ $user->country }}','{{ $user->status }}','{{ base64_encode($user->user_avatar) }}','{{ $user->role }}','{{ $user->created_at }}','{{ $user->updated_at }}')" data-toggle="modal" data-target="#modal-contact" class="text-secondary d-inline-block mb-3">

                            <div class="image mb-3 mt-n9">
                                @if($user->user_avatar != null)
                                    <img src="{{ $user->user_avatar }}" class="img-fluid rounded-circle" alt="Avatar Image" style="width: 128px">
                                @else
                                    <img src="{{ asset('img/no-img.png') }}" class="img-fluid rounded-circle" alt="Avatar Image" style="width: 128px">
                                @endif
                            </div>

                            <h5 class="card-title text-dark">{{ $user->name }}</h5>
                        </a>

                        <div class="row justify-content-center">
                            <div class="col-4 px-1">
                                <a href="{{ route('edit.user', $user->id) }}" class="mb-1 btn btn-pill btn-outline-success"><i class="mdi mdi-square-edit-outline"></i></a>
                            </div>
                            @if(Auth::user()->id != $user->id)
                                <div class="col-4 px-1">
                                    <a href="{{ route('delete.user', $user->id) }}" class="mb-1 btn btn-pill btn-outline-danger"><i class="mdi mdi-delete"></i></a>
                                </div>
                            @endif
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
                        <h2 class="mb-4">{{ __('users.no.users') }}</h2>
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
                                        <h4 class="py-2 text-dark" id="name"></h4>
                                        <p class="py-2 text-black-50" id="email"></p>
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
                                <div class="mb-1" id="role">
                                </div>
                                <div class="mb-1" id="status">
                                </div>
                                <p class="text-dark font-weight-medium pt-4 mb-2" >{{ __('groups.created') }}</p>
                                <p id="created"></p>
                                <p class="text-dark font-weight-medium pt-4 mb-2">{{ __('groups.updated') }}</p>
                                <p id="updated"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
