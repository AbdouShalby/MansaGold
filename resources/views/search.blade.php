@php($pageTitle = 'Search')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <h1>{{ __('navbar.search-result') }}</h1>
        </div>
        @if(!empty($groups) || !empty($users))
        <div class="row">
            @foreach($groups as $group)
                <div class="col-lg-6 col-xl-4">
                    <div class="card card-default p-4">
                        <a class="media text-secondary" data-toggle="modal" data-target="#modal-contact">
                            <img src="{{ asset($group->group_avatar) }}" style="max-width: 100px" class="mr-3 img-fluid rounded" alt="Avatar Image">
                            <div class="media-body">
                                <h5 class="mt-0 mb-2 text-dark">{{ $group->group_name }}</h5>
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-1">
                                        <i class="mdi mdi-map mr-1"></i>
                                        <span>Nulla vel metus 15/178</span>
                                    </li>
                                    <li class="d-flex mb-1">
                                        <i class="mdi mdi-email mr-1"></i>
                                        <span>exmaple@email.com</span>
                                    </li>
                                    <li class="d-flex mb-1">
                                        <i class="mdi mdi-phone mr-1"></i>
                                        <span>(123) 888 777 632</span>
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-default p-4">
                    <h5 class="mt-0 mb-2 text-dark">{{ __('navbar.no-result') }}</h5>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
