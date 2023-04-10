@php($pageTitle = 'dashboard')
@extends('layouts.app')
@section('content')
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card widget-block p-4 rounded bg-primary border">
                    <div class="card-block">
                        <i class="mdi mdi-account mr-4 text-white"></i><a href="{{ route('all.users') }}"><i class="mdi mdi-eye float-right text-white p-2 border"></i></a>
                        <h4 class="text-white my-2">{{ $totalUsers }}</h4>
                        <p>{{ __('dashboard.total-users') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card widget-block p-4 rounded bg-danger border">
                    <div class="card-block">
                        <i class="mdi mdi-folder-multiple-outline mr-4 text-white"></i><a href="{{ route('all.groups') }}"><i class="mdi mdi-eye float-right text-white p-2 border"></i></a>
                        <h4 class="text-white my-2">{{ $totalGroups }}</h4>
                        <p>{{ __('dashboard.total-groups') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card widget-block p-4 rounded bg-success border">
                    <div class="card-block">
                        <i class="mdi mdi-checkbox-marked-circle mr-4 text-white"></i>
                        <h4 class="text-white my-2">{{ $countOfGroupsCompleted }}</h4>
                        <p>{{ __('dashboard.total-groups-completed') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card widget-block p-4 rounded bg-dark border">
                    <div class="card-block">
                        <i class="mdi mdi-arrow-top-right mr-4 text-white"></i>
                        <h4 class="text-white my-2">{{ $totalInvest }}</h4>
                        <p>{{ __('dashboard.total-invest') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if(count($latestGroups) > 0)
        <div class="row">
            <div class="col-12">
                <!-- Recent Order Table -->
                <div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                        <h2>{{ __('dashboard.recent-groups.title') }}</h2>
                    </div>
                    <div class="card-body pt-0 pb-5">
                        <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                            <thead>
                            <tr>
                                <th>{{ __('dashboard.recent-groups.id') }}</th>
                                <th>{{ __('dashboard.recent-groups.name') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('dashboard.recent-groups.current') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('dashboard.recent-groups.max') }}</th>
                                <th>{{ __('dashboard.recent-groups.status.title') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($latestGroups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->group_name }}</td>
                                <td class="d-none d-lg-table-cell">{{ $group->current_subscription }}</td>
                                <td class="d-none d-lg-table-cell">{{ $group->group_max_subscription }}</td>
                                <td>
                                    @if($group->group_status == 0)
                                        <span class="badge badge-primary">{{ __('dashboard.recent-groups.status.available') }}</span>
                                    @elseif($group->group_status == 1)
                                        <span class="badge badge-warning">{{ __('dashboard.recent-groups.status.manufacturing') }}</span>
                                    @elseif($group->group_status == 2)
                                        <span class="badge badge-success">{{ __('dashboard.recent-groups.status.completed') }}</span>
                                    @elseif($group->group_status == 3)
                                        <span class="badge badge-danger">{{ __('dashboard.recent-groups.status.cancelled') }}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="dropdown show d-inline-block widget-dropdown">
                                        <a class="dropdown-toggle icon-burger-mini" href="" role="button"
                                           id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false" data-display="static"></a>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                            <li class="dropdown-item">
                                                <a href="{{ route('edit.group', $group->id) }}">{{ __('dashboard.edit') }}</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="{{ route('delete.group', $group->id) }}">{{ __('dashboard.delete') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- Sales Graph -->
                <div class="card card-default" data-scroll-height="675">
                    <div class="card-header">
                        <h2>Sales Of The Year</h2>
                    </div>
                    <div class="card-body">
                        <canvas id="linechart" class="chartjs"></canvas>
                    </div>
                    <div class="card-footer d-flex flex-wrap bg-white p-0">
                        <div class="col-6 px-0">
                            <div class="text-center p-4">
                                <h4>$6,308</h4>
                                <p class="mt-2">Total orders of this year</p>
                            </div>
                        </div>
                        <div class="col-6 px-0">
                            <div class="text-center p-4 border-left">
                                <h4>$70,506</h4>
                                <p class="mt-2">Total revenue of this year</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <!-- Recent Order Table -->
                <div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                        <h2 class="mb-4">{{ __('dashboard.recent-groups.no-invest') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
