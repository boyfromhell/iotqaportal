@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Roller Gate</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <button id="up" class="btn btn-block btn-outline-primary btn-lg">Up</button>
                                <button id="pause" class="btn btn-block btn-outline-primary btn-lg">Pause</button>
                                <button id="down" class="btn btn-block btn-outline-primary btn-lg">Down</button>
                            </div>
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
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script
        src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    ></script>
    <script>
        $(document).ready(function () {
            // document.getElementById("myDiv").style.display = "none";

            showPage();

            $('#up').click(function () {
                sendCommand('u')
            })

            $('#down').click(function () {
                sendCommand('d')
            })

            $('#pause').click(function () {
                sendCommand('p')
            })

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "100",
                "hideDuration": "100",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            function sendCommand(command) {
                showLoader();
                $.get("{!! url('roller-gate') !!}/" + command, function (data, status) {
                    console.log(data);
                    console.log(status);
                    if (status === 'success') {
                        showPage();
                        toastr.success('Successfully executed ' + command)
                    } else {
                        console.log(data);
                        toastr.warning('Error')
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    // console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    showPage();
                    toastr.error('Error: ' + errorThrown)

                });
            }
        })


    </script>
    <script>
        var myVar;

        // function myFunction() {
        //     myVar = setTimeout(showPage, 3000);
        // }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("app").style.display = "block";
        }

        function showLoader() {
            document.getElementById("loader").style.display = "block";
            document.getElementById("app").style.display = "none";
        }
    </script>
@endpush
