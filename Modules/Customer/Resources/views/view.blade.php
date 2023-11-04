@extends('layouts.info.app')

@section('content')
    <div class="container">
        {{-- {{ $customerData }} --}}
        {{-- {{ $customerDocumentData }} --}}


        <div class="row  justify-content-between">
            <div class="col-md-5">
                <div class="card bg-white" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex text-black">
                            <div class="flex-shrink-0">
                                <img src="{{ $customerData->image ? asset('storage/customer/' . $customerData->customUrl . '/' . $customerData->image) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp' }} "
                                    alt="Generic placeholder image" class="img-fluid"
                                    style="width: 150px; border-radius: 10px;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $customerData->name }}</h5>
                                <p class="mb-2 pb-1" style="color: #2b2a2a;"><a href="mailto:{{ $customerData->email }}" class="btn btn-primary me-1 flex-grow-1">
                                    <i class="fa-solid fa-envelope"></i> Send Mail</a>
                               <a
                                        href="tel:+91{{ $customerData->contactNumber }}" class="btn btn-primary me-1 flex-grow-1"><i class="fa-solid fa-phone-volume"></i> Call</a>
                                </p>

                                <div class="d-flex pt-1">

                                    <button type="button" class="btn btn-primary me-1 flex-grow-1">Send Locations</button>


                                </div>
                                <div class="d-flex pt-1">
                                    <button type="button" class="btn btn-outline-primary me-1 flex-grow-1">Exchange
                                        Contact</button>
                                    <button type="button" class="btn btn-primary me-1 flex-grow-1">Inquery</button>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>




            <div class="col-md-7">
                <div class="card bg-white" style="border-radius: 15px;">
                    <div class="card-body">
                        <!-- Jodit Editor Container -->
                        <div id="personalInfo"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row  justify-content-between">
            <div class="col-md-5">
                @if (count($customerDocumentData) > 0)
                    <div class="card bg-white mt-2" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex text-black">
                                <div class="mt-4">
                                    <h5>Documents:</h5>

                                    {{-- {{ $customerDocumentData }} --}}
                                    @foreach ($customerDocumentData as $document)
                                        <p class="mb-2 pb-1" style="color: #2b2a2a;">

                                            @if($document->fileType == 'pdf')

                                                <i class="fa-solid fa-file-pdf"></i>
                                            @elseif($document->fileType == 'doc' || $document->fileType == 'docx' )

                                                <i class="fa-solid fa-file-word"></i>


                                                @elseif($document->fileType == 'xlsx' ||$document->fileType == 'xls' )

                                                <i class="fa-solid fa-file-excel"></i>



                                                @elseif($document->fileType == 'ppt' || $document->fileType == 'pptx' )

                                                <i class="fa-solid fa-file-powerpoint"></i>


                                                @elseif($document->fileType == 'jpg' || $document->fileType == 'jpeg' || $document->fileType == 'png')

                                                <i class="fa-solid fa-file-image"></i>

                                                @endif



                                            {{ $document->fileName }}

                                            <a href="{{ asset('storage/customer/' . $customerData->customUrl . '/documents/' . $document->fileName) }}"
                                                download><i class="fa-solid fa-eye"></i></a>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>




            <div class="col-md-7">

                <div class="col-auto  text-end mt-2">
                    <p>

                        Pub: {{ date('d M Y H:i \U\T\C',  strtotime($customerData->created_at))  }} <br>
                        Edit: {{ date('d M Y H:i \U\T\C',  strtotime($customerData->created_at))  }}<br>
                        Views: {{  $customerData->viewCount }} <br>
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
