@php($pageTitle = 'Search')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <h1>{{ __('navbar.search-result') }}</h1>
        </div>
        @if(!empty($groups))
        <div class="row">
            @foreach($groups as $group)
                <div class="col-lg-6 col-xl-4">
                    <div class="card card-default p-4">
                        <a class="media text-secondary">
                            <img src="{{ asset($group->group_avatar) }}" style="max-width: 100px" class="mr-3 img-fluid rounded" alt="Avatar Image">
                            <div class="media-body">
                                <h5 class="mt-0 mb-2 text-dark">{{ $group->group_name }}</h5>
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-1">
                                        <span>{{ __('groups.current') }}: <strong>{{ $group->current_subscription }}</strong></span>
                                    </li>
                                    <li class="d-flex mb-1">
                                        <span>{{ __('groups.max') }}: <strong>{{ $group->group_max_subscription }}</strong></span>
                                    </li>
                                    <li class="d-flex mb-1">
                                        <span>{{ __('groups.status.title') }}:
                                            @if($group->group_status == 0)
                                                <span class="badge badge-primary">{{ __('dashboard.recent-groups.status.available') }}</span>
                                            @elseif($group->group_status == 1)
                                                <span class="badge badge-success">{{ __('dashboard.recent-groups.status.completed') }}</span>
                                            @elseif($group->group_status == 2)
                                                <span class="badge badge-warning">{{ __('dashboard.recent-groups.status.manufacturing') }}</span>
                                            @elseif($group->group_status == 3)
                                                <span class="badge badge-danger">{{ __('dashboard.recent-groups.status.cancelled') }}</span>
                                            @endif
                                        </span>
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
