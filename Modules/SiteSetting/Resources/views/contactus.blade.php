@extends('layouts.admin.app')


@section('pageHeader')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        List
                    </div>
                    <h2 class="page-title">
                        QR Codes
                    </h2>

                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">

                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new QR Codes
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#modal-report" aria-label="Create new qr code">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </div>
                </div>


                {{-- <div>
                    <pre>
                        @php

                            if (isset($errors) && count($errors->all()) > 0) {
                                print_r($errors->all());
                            }

                            // print_r($qrData)

                        @endphp
                    </pre>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('pageBody')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h3 class="card-title">QR Codes</h3>
                        </div> --}}
                        {{-- <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    Show
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" value="8"
                                            size="3" aria-label="Invoices count">
                                    </div>
                                    entries
                                </div>
                                <div class="ms-auto text-muted">
                                    Search:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12">
                                <table class="table  datatable" id="datatable"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="w-1"><input class="form-check-input m-0 align-middle"
                                                    type="checkbox" aria-label="Select all qr Code"></th>
                                            <th class="w-1">Id
                                                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 15l6 -6l6 6" />
                                                </svg>
                                            </th>
                                            <th>Filename</th>
                                            <th>URI</th>
                                            <th>URL</th>
                                            <th>Qr Code</th>
                                            <th>Scan</th>
                                            <th>Operations</th>

                                        </tr>
                                    </thead>
                                </table>


                                                   </div>
                        {{-- <div class="card-footer d-flex align-items-center">
                            <p class="m-0 text-muted">Showing <span>1</span> to <span>8</span> of <span>16</span> entries
                            </p>
                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M15 6l-6 6l6 6" />
                                        </svg>
                                        prev
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 6l6 6l-6 6" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('pageModels')
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="qr/create" method="POST" enctype="multipart/form-data" class="modal-body">
                    @csrf



                    <div class="modal-body">

                        <input type="hidden" id="foreground" name="foreground" value="#000000">
                        <input type="hidden" id="background" name="background" value="#ffffff">
                        <input type="hidden" id="level" name="level" value="H">
                        <input type="hidden" id="size" name="size" value="500">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="identifier">Redirect identifier</label>
                                <p>It will be automatically generated</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">No of QR Code</label>
                                    <input type="number" class="form-control" name="noofqrcode" value="1"
                                        min="1" required="required" id="noofqrcode">
                                </div>
                            </div>
                            {{-- <div class="mb-3">
                            <label class="form-label">URL *</label>
                            <input type="url" class="form-control" pattern="http.*://.*" name="link"
                                value="https://whoicard.com/" placeholder="https://example.com" required="required"
                                id="link">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Filename *</label>
                            <input type="text" name="filename" value="" placeholder="My first Qrcode"
                                class="form-control error" required="required" id = "filename">
                        </div> --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Format</label>
                                    <select class="form-select" id="format" name="format">
                                        <option value="png">PNG</option>
                                        <option value="gif">GIF</option>
                                        <option value="jpeg">JPEG</option>
                                        <option value="jpg">JPG</option>
                                        <option value="svg" selected>SVG</option>
                                        <option value="eps">EPS</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('pageScripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#datatable').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('qr.getQrCodes') }}",
                    type: "POST",
                    data: function(data) {
                        data.search = $('input[type="search"]').val();
                    }
                },
                order: ['0', 'DESC'],
                pageLength: 10,
                searching: true,
                aoColumns: [{
                        data: 'id',
                        width: "20%",
                        render: function(data, type, row) {
                            return `<input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select invoice" value="${data}"> `; //you can add your view route here
                        }
                    },
                    {
                        data: 'id',
                    },
                    {
                        data: 'filename',
                    },
                    {
                        data: 'identifier',
                    },
                    {
                        data: 'link',
                        render: function(data, type, row) {
                            return `<a href="http://${data}" target="_blank">${data}</a>`;
                        }
                    },
                    {
                        data: 'qrcode',
                        render: function(data, type, row) {

                            return `<img src="{{ asset('storage/savedQr/${data}') }}" alt="" srcset="" width="100">`;
                        }
                    },
                    {
                        data: 'scan',
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            return `<span class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top"
                                                    data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">
                                                        Action
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        Another action
                                                    </a>
                                                </div>
                                            </span>`;
                        }
                    }

                ]
            });
        });
    </script>
@endsection
