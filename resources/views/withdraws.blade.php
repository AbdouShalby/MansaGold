@php($pageTitle = 'withdraws')
@extends('layouts.app')
@section('content')
    <div class="content">
        @if(isset($withdraws) && count($withdraws) > 0)
        <div class="row">
            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-1 col-12" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="col-12">
                <div class="card card-default mt-6 mb-4">
                    <div class="card-body text-center p-4">
                        <div class="basic-data-table">
                            <div id="basic-data-table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row justify-content-between top-information">
                                    <table id="basic-data-table" class="table nowrap dataTable no-footer" style="width:100%" role="grid" aria-describedby="basic-data-table_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">{{ __('withdraws.table.id') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Last name: activate to sort column ascending">{{ __('withdraws.table.name') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">{{ __('withdraws.table.amount') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">{{ __('withdraws.table.status.title') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">{{ __('withdraws.table.created') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending"></th>
                                            </tr>
                                        </thead>
                                        @foreach($withdraws as $withdraw)
                                        <tbody>
                                            <tr role="row">
                                                <td>{{ $withdraw->id }}</td>
                                                @if($withdraw->status == 0)
                                                    <td class="text-warning bg-dark">
                                                        @foreach($users as $user)
                                                            @if($user->id == $withdraw->user_id)
                                                                {{ $user->name }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="text-warning bg-dark">{{ $withdraw->amount }}</td>
                                                    <td class="text-warning bg-dark">{{ __('withdraws.table.status.waiting') }}</td>
                                                    <td class="text-warning bg-dark">{{ $withdraw->created_at }}</td>
                                                    <td class="text-warning bg-dark">
                                                        <a href="{{ route('withdraw-approve', $withdraw->id) }}" class="btn btn-outline-success">{{ __('withdraws.table.actions.approve') }}</a>
                                                        <a href="{{ route('withdraw-cancel', $withdraw->id) }}" class="btn btn-outline-danger">{{ __('withdraws.table.actions.cancel') }}</a>
                                                    </td>
                                                @endif
                                                @if($withdraw->status == 1)
                                                    <td class="text-success bg-dark">
                                                        @foreach($users as $user)
                                                            @if($user->id == $withdraw->user_id)
                                                                {{ $user->name }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="text-success bg-dark">{{ $withdraw->amount }}</td>
                                                    <td class="text-success bg-dark">{{ __('withdraws.table.status.approved') }}</td>
                                                    <td class="text-success bg-dark">{{ $withdraw->created_at }}</td>
                                                    <td class="text-success bg-dark">
                                                        <a disabled="" class="btn btn-success text-white">{{ __('withdraws.table.status.approved') }}</a>
                                                    </td>
                                                @endif
                                                @if($withdraw->status == 2)
                                                    <td class="text-danger bg-dark">
                                                        @foreach($users as $user)
                                                            @if($user->id == $withdraw->user_id)
                                                                {{ $user->name }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="text-danger bg-dark">{{ $withdraw->amount }}</td>
                                                    <td class="text-danger bg-dark">{{ __('withdraws.table.status.canceled') }}</td>
                                                    <td class="text-danger bg-dark">{{ $withdraw->created_at }}</td>
                                                    <td class="text-danger bg-dark">
                                                        <a disabled="" class="btn btn-danger text-white">{{ __('withdraws.table.status.canceled') }}</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mr-3 mb-3">
                        {!! $withdraws->links() !!}
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
                        <h2 class="mb-4">{{ __('withdraws.empty') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
