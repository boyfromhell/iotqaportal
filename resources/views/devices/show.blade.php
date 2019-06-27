@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Device Info</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">

                                <tr>
                                    <th>Device ID</th>
                                    <td>{{ $device['id'] }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><a href="{{ url('devices/'.$device['id']) }}">{{ $device['name'] }}</a></td>
                                </tr>
                                <tr>
                                    <th>Brand</th>
                                    <td>{{ $device['brand'] }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ $device['type'] }}</td>
                                </tr>
                                <tr>
                                    <th>Model</th>
                                    <td>{{ $device['model'] }}</td>
                                </tr>
                                <tr>
                                    <th>Serial</th>
                                    <td>{{ $device['macAddress'] }}</td>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Device Actions</div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Action Id</th>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($actions as $action)
                                        <tr>
                                            <td>{{$action['id']}}</td>
                                            <td>{{$action['name']}}</td>
                                            <td>{{$action['displayName']}}</td>
                                            <td>
                                                <a href="{{ url("devices/{$device['id']}/action/{$action['name']}") }}"
                                                   class="btn btn-outline-primary">Run</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Device Events</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Action Id</th>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{$event['id']}}</td>
                                            <td>{{$event['eventName']}}</td>
                                            <td>{{$event['statusName']}}</td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('scripts')


@endpush
