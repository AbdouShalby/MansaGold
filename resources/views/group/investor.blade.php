@php($pageTitle = 'investor')
@extends('layouts.app')
@section('content')
    <div class="content">
        @if(isset($investors) && count($investors) > 0)
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
                                                <th class="sorting_asc" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">{{ __('groups.table.id') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Last name: activate to sort column ascending">{{ __('groups.table.name') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">{{ __('groups.table.balance') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="basic-data-table" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">{{ __('groups.table.created') }}</th>
                                            </tr>
                                        </thead>
                                        @foreach($investors as $inv)
                                        <tbody>
                                            <tr role="row">
                                                <td>{{ $inv->id }}</td>
                                                <td>
                                                    @foreach($users as $user)
                                                        @if($user->id == $inv->user_id)
                                                            @if($user->name != null)
                                                            <a href="{{ route('edit.user', $user->id) }}">{{ $user->name }}</a>
                                                            @else
                                                            {{ 'No Name' }}
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $inv->code_balance }}</td>
                                                <td>{{ $inv->subscribed_at }}</td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mr-3 mb-3">
                        {!! $investors->links() !!}
                    </div>
                </div>
            </div>
        </div
        @else
        <div class="row">
            <div class="col-12">
                <!-- Recent Order Table -->
                <div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                        <h2 class="mb-4">{{ __('groups.no-inv') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
