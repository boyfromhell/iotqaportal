@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Roller Gate</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Device ID</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Type</th>
                                        <th>Model</th>
                                        <th>Serial</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($devices as $device)
                                    <tr>
                                        <td>{{ $device['id'] }}</td>
                                        <td><a href="{{ url('devices/'.$device['id']) }}">{{ $device['name'] }}</a></td>
                                        <td>{{ $device['brand'] }}</td>
                                        <td>{{ $device['type'] }}</td>
                                        <td>{{ $device['model'] }}</td>
                                        <td>{{ $device['macAddress'] }}</td>
                                        <td>
                                            <i></i>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
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
