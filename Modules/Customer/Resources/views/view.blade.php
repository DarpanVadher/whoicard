@extends('layouts.info.app')

@section('content')
    <div class="container">
        {{-- {{ $customerData }} --}}
        {{-- {{ $customerDocumentData }} --}}


        <div class="row  justify-content-between">
            <div class="col-md-4">
                <div class="card bg-white" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex text-black">
                            <div class="flex-shrink-0">
                                <img src="{{ $customerData->image ? asset('storage/customer/' . $customerData->customUrl . '/' . $customerData->image) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp' }} "
                                    alt="Generic placeholder image" class="img-fluid"
                                    style="width: 100px; border-radius: 10px;">
                            </div>
                            <div class="flex-grow-1 ms-3 ">
                                <h5 class="mb-1">{{ $customerData->name }}</h5>
                                <div class="d-flex pt-1">
                                    <a href="mailto:{{ $customerData->email }}" class="btn btn-primary me-1 flex-grow-1">
                                         Send Mail <i class="fa-solid fa-envelope"></i></a>
                                    <a href="tel:+91{{ $customerData->contactNumber }}"
                                        class="btn btn-primary btn-block me-1 flex-grow-1"> Call <i
                                        class="fa-solid fa-phone-volume"></i></a>
                                </div>

                                <div class="d-flex pt-1">
                                    <button type="button" class="btn btn-primary  me-1 flex-grow-1">Send Locations <i
                                            class="fa-solid fa-paper-plane"></i></button>
                                </div>

                                <div class="d-flex pt-1">
                                    <Button  type="button" class="btn btn-primary  me-1 flex-grow-1" onclick="window.location.href = '{{ $customerData->customUrl }}/vcard'">Save Contact <i class="fa-regular fa-address-card"></i></Button>
                                </div>

                            </div>


                        </div>


                    </div>
                </div>


                <div class="card  bg-white  mt-2" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex pt-1">
                            <button type="button" class="btn btn-primary me-1 flex-grow-1" data-bs-toggle="modal"
                                data-bs-target="#inqueryModal">
                                Inquery <i class="fas fa-question-circle"></i>
                            </button>
                            <button type="button" class="btn btn-primary me-1 flex-grow-1" data-bs-toggle="modal"
                            data-bs-target="#exchangeContactModal">Exchange
                                Contact <i class="fa-solid fa-address-card"></i></button>

                        </div>
                    </div>
                </div>

            </div>




            <div class="col-md-8">
                <div class="card bg-white mt-2" style="border-radius: 15px;">
                    <div class="card-body">
                        <!-- Jodit Editor Container -->
                        <div id="personalInfo"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row  justify-content-between">
            <div class="col-md-4">
                @if (count($customerDocumentData) > 0)
                    <div class="card bg-white mt-2" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5>Documents:</h5>
                            <div class="mt-2 pt-1">


                                @foreach ($customerDocumentData as $document)
                                    <a class="btn btn-primary m-1 flex-grow-1"
                                        href="{{ asset('storage/customer/' . $customerData->customUrl . '/documents/' . $document->fileName) }}"
                                        target="_blank">
                                        @if ($document->fileType == 'pdf')
                                            <i class="fa-solid fa-file-pdf"></i>
                                        @elseif($document->fileType == 'doc' || $document->fileType == 'docx')
                                            <i class="fa-solid fa-file-word"></i>
                                        @elseif($document->fileType == 'xlsx' || $document->fileType == 'xls')
                                            <i class="fa-solid fa-file-excel"></i>
                                        @elseif($document->fileType == 'ppt' || $document->fileType == 'pptx')
                                            <i class="fa-solid fa-file-powerpoint"></i>
                                        @elseif($document->fileType == 'jpg' || $document->fileType == 'jpeg' || $document->fileType == 'png')
                                            <i class="fa-solid fa-file-image"></i>
                                        @endif
                                        {{ explode('.', $document->fileName)[0] }}
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif
            </div>




            <div class="col-md-8">

                <div class="col-auto  text-end mt-2">
                    <p>

                        Pub: {{ date('d M Y H:i \U\T\C', strtotime($customerData->created_at)) }} <br>
                        Edit: {{ date('d M Y H:i \U\T\C', strtotime($customerData->created_at)) }}<br>
                        Views: {{ $customerData->viewCount }} <br>
                    </p>

                </div>
            </div>
        </div>



        <div class="row justify-content-between mt-2">



            <div class="col-auto mr-auto">

                <a type="button" class="btn btn-primary" href="/info/{{ $customerData->customUrl }}/edit">Edit</a>

            </div>



        </div>


    </div>
@endsection

@section('pageModels')
    {{-- Add Model for inquery --}}

    <!-- Modal -->
    <div class="modal fade " id="inqueryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Inquery <i class="fas fa-question-circle"></i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="customer/mail/send/inquery" method="POST">

                    @csrf
                    <input type="hidden" name="customUrl" value="{{ $customerData->customUrl }}">
                    <input type="hidden" name="customerEmail" value="{{$customerData->email}}">
                    <div class="modal-body">

                        <div class="mb-3">
                            <input type="text" class="form-control" id="inqueryName" name="inqueryName" placeholder="Name*" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="inqueryContactNumber" name="inqueryContactNumber" placeholder="Phone*"
                                required pattern="[0-9]{10}" min="10" max="10">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="inqueryEmail" name="inqueryEmail" placeholder="Email*" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="inquerySubject"  name="inquerySubject" placeholder="Subject*"
                                required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="inqueryMessage" rows="3"  name="inqueryMessage" placeholder="Message*" required></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Add Model for Exchange Contact --}}

    <!-- Modal -->
    <div class="modal fade" id="exchangeContactModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Exchange
                        Contact <i class="fa-solid fa-address-card"></i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="customer/mail/send/exchangeContact" method="POST">

                    @csrf

                    <div class="modal-body">

                        <input type="hidden" name="customUrl" value="{{ $customerData->customUrl }}">
                        <input type="hidden" name="customerEmail" value="{{$customerData->email}}">

                        <div class="mb-3">
                            <input type="text" class="form-control" id="inqueryName" name="inqueryName" placeholder="Name*" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="inqueryContactNumber" name="inqueryContactNumber" placeholder="Phone*"
                                required pattern="[0-9]{10}" min="10" max="10">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="inqueryEmail" name="inqueryEmail" placeholder="Email*" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="inquerySubject"  name="inquerySubject" placeholder="Event / Palce at We meet first time"
                                required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="inqueryMessage" rows="3"  name="inqueryMessage" placeholder="Message*" required></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
    <script>
        $(document).ready(function() {
            const editor = Jodit.make('#personalInfo', {
                readonly: true, // Set the editor to read-only
                toolbar: false, // Disable the toolbar
                disableDragAndDrop: true, // Disable drag and drop
                disableResize: true,
            });



            editor.value = {{ Js::from($customerData->personalData) }};

        });
    </script>
@endsection
