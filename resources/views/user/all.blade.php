@php($pageTitle = 'users')
@extends('layouts.app')
@section('content')=
    <div class="content">
        @if(isset($searchedUsers) && count($searchedUsers) > 0)
            <div class="row">
                <div class="search-form w-100">
                    <div class="input-group w-100">
                        <form class="form-inline w-100" method="POST" action="{{ route('users.search') }}" id="search-form">
                            @csrf
                            <input type="search" name="search" id="search-input" class="form-control w-75 m-auto"
                                   placeholder="{{ __('navbar.search-now') }}" autofocus autocomplete="off" />
                            <button type="submit" id="search-btn" class="btn btn-flat m-auto" onclick="document.getElementById('search-form').submit();">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($searchedUsers as $user)
                    <div class="col-lg-6 col-xl-4 col-xxl-3">
                        <div class="card card-default mt-6 mb-4">
                            <div class="card-body text-center p-4">
                                <a href="{{ route('edit.user', $user->id) }}" class="text-secondary d-inline-block mb-3">

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
        @elseif(isset($users) && count($users) > 0)
        <div class="row">
            <div class="search-form w-100">
                <div class="input-group w-100">
                    <form class="form-inline w-100" method="POST" action="{{ route('users.search') }}" id="search-form">
                        @csrf
                        <input type="search" name="search" id="search-input" class="form-control w-75 m-auto"
                               placeholder="{{ __('navbar.search-now') }}" autofocus autocomplete="off" />
                        <button type="submit" id="search-btn" class="btn btn-flat m-auto" onclick="document.getElementById('search-form').submit();">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
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
                        <a href="{{ route('edit.user', $user->id) }}" class="text-secondary d-inline-block mb-3">

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
@endsection
