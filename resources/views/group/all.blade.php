@php($pageTitle = 'groups')
@extends('layouts.app')
@section('content')
    <script>
        function ShowThis(name, current, max, status, avatar, gain, created, updated) {
            $("#name").text(base64_decode(name));
            $("#current").html('<p>{{ __('groups.current') }}</p> <h6 class="text-dark pb-2">' + current + ' {{ __('groups.gm') }}</h6>');
            $("#max").html('<p>{{ __('groups.max') }}</p> <h6 class="text-dark pb-2">' + max + ' {{ __('groups.gm') }}</h6>');
            if(gain == 3) {
                $("#gain").html('<span class="badge badge-dark">{{ __('groups.gain.normal') }}</span>');
            } else {
                $("#gain").html('<span class="badge badge-dark">{{ __('groups.gain.rezon') }}</span>');
            }
            if(status == 0) {
                $("#status").html('<span class="badge badge-primary">{{ __('dashboard.recent-groups.status.available') }}</span>');
            } else if(status == 1) {
                $("#status").html('<span class="badge badge-success">{{ __('dashboard.recent-groups.status.completed') }}</span>');
            } else if(status == 2) {
                $("#status").html('<span class="badge badge-warning">{{ __('dashboard.recent-groups.status.manufacturing') }}</span>');
            } else if(status == 3) {
                $("#status").html('<span class="badge badge-danger">{{ __('dashboard.recent-groups.status.cancelled') }}</span>');
            }
            if(avatar !== '') {
                $("#avatar").attr("src", "{{ asset('') }}" + base64_decode(avatar));
            } else {
                $("#avatar").attr("src", "{{ asset('img/no-img.png') }}");
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
        @if(isset($groups) && count($groups) > 0)
        <div class="row">
            @foreach($groups as $group)
            <div class="col-lg-6 col-xl-4 col-xxl-3">
                <div class="card card-default mt-6 mb-4">
                    <div class="card-body text-center p-4">
                        <a href="javascript:;"
                            onclick="ShowThis('{{ base64_encode($group->group_name) }}','{{ $group->current_subscription }}','{{ $group->group_max_subscription }}','{{ $group->group_status }}','{{ base64_encode($group->group_avatar) }}','{{ $group->group_gain }}','{{ $group->created_at }}','{{ $group->updated_at }}')" data-toggle="modal" data-target="#modal-contact" class="text-secondary d-inline-block mb-3">

                            <div class="image mb-3 mt-n9">
                                @if($group->group_avatar != null)
                                <img src="{{ $group->group_avatar }}" class="img-fluid rounded-circle" alt="Avatar Image" style="width: 128px">
                                @else
                                <img src="{{ asset('img/no-img.png') }}" class="img-fluid rounded-circle" alt="Avatar Image" style="width: 128px">
                                @endif
                            </div>

                            <h5 class="card-title text-dark">{{ $group->group_name }}</h5>
                        </a>

                        <div class="row justify-content-center">
                            <div class="col-4 px-1">
                                <a href="{{ route('edit.group', $group->id) }}" class="mb-1 btn btn-pill btn-outline-success"><i class="mdi mdi-square-edit-outline"></i></a>
                            </div>
                            <div class="col-4 px-1">
                                <a href="{{ route('delete.group', $group->id) }}" class="mb-1 btn btn-pill btn-outline-danger"><i class="mdi mdi-delete"></i></a>
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
                        <h2 class="mb-4">{{ __('dashboard.recent-groups.no-invest') }}</h2>
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
                                        <p><span id="gain"></span></p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between ">
                                    <div class="text-center pb-4" id="current">
                                    </div>

                                    <div class="text-center pb-4" id="max">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="contact-info px-4">
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
