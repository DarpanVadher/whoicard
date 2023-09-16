@extends('layouts.app')

@section('content')
    <div class="container">



        <!-- Create the editor container -->
        <form action="/customer/add" method="POST" id="customerAddForm">
            @csrf
            <input name="id" type="hidden" value="{{ $customer->id }}">

            <div class="row">
                <span class="error text-danger" id="errorMessage"></span>
            </div>


            <div class="row mb-5 ">
                <div class="col-md-12">
                    <input name="about" type="hidden">
                    <div id="editor-container">
                    </div>
                    <span class="error text-danger" id="errorTextAbout"></span>

                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 mt-1">
                            <input class="form-control" name="editCode" type="text" placeholder="Enter Edit Code"
                                required>
                            <span class="error text-danger" id="errorTextEditCode"></span>

                        </div>
                        <div class="col-md-4 mt-1">
                            <input class="form-control form-group" name="newEditCode" type="text"
                                placeholder="New edit code - optional">

                            <span class="error text-danger" id="errorTextNewEditCode"></span>
                        </div>
                        <div class="col-md-4 mt-1">
                            <input class="form-control" name="newCustomUrl" type="text" placeholder="New url - optional">
                            <span class="error text-danger" id="errorTextNewCustomUrl"></span>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row  mt-1 mb-1 justify-content-between">

                <div class="col-auto"><button class="btn btn-success" id="saveProfile">Save Profile</button>
                    <a href="/{{ $customer->customUrl }}" class="btn btn-primary">Back</a>
                </div>
                <div class="col-auto ml-auto"> <button class="btn btn-danger" id="deleteProfile">Delete</button></div>
            </div>


        </form>
    </div>
@endsection



@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var customerData = {!! json_encode($customer->personalData) !!};
            const customerObject = JSON.parse(customerData);

            var quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: {
                        container: [
                            [{
                                header: [1, 2, false]
                            }],
                            ['bold', 'italic', 'underline'],
                            ['image', 'code-block']
                        ],
                        handlers: {
                            image: imageHandler
                        }
                    },
                    imageResize: {
                        
                    },


                },
            });

            quill.setContents(customerObject);

            var saveProfileButton = document.getElementById("saveProfile");

            saveProfileButton.onclick = function() {
                // Populate hidden form on submit
                var id = document.querySelector('input[name=id]');
                var about = document.querySelector('input[name=about]');
                var editCode = document.querySelector('input[name=editCode]');
                var newEditCode = document.querySelector('input[name=newEditCode]');
                var newCustomUrl = document.querySelector('input[name=newCustomUrl]');


                about.value = JSON.stringify(quill.getContents());

                // No back end to actually submit to!
                $.ajax({
                    data: {
                        id: id.value,
                        about: about.value,
                        editCode: editCode.value,
                        newEditCode: newEditCode.value,
                        newCustomUrl: newCustomUrl.value
                    },
                    url: "/customer/edit",
                    type: "POST",
                    dataType: 'json',
                    Accept: "application/json",
                    success: function(data) {

                        // console.log(data);
                        // const reponse = JSON.parse(data);
                        // console.log(data.url);

                        window.alert(`${data.success}`);
                        window.location.replace(`/${data.url}`);

                    },
                    error: function(data) {
                        const errorReponse = JSON.parse(data.responseText);

                        if (errorReponse?.errorMessage) document.getElementById("errorMessage")
                            .innerHTML = errorReponse?.errorMessage;

                        if (errorReponse?.error?.about) document.getElementById("errorTextAbout")
                            .innerHTML = errorReponse?.error?.about;

                        if (errorReponse?.error?.editCode) document.getElementById(
                            "errorTextEditCode").innerHTML = errorReponse?.error?.editCode;

                        if (errorReponse?.error?.newEditCode) document.getElementById(
                            "errorTextNewEditCode").innerHTML = errorReponse?.error?.newEditCode;

                        if (errorReponse?.error?.newCustomUrl) document.getElementById(
                                "errorTextNewCustomUrl").innerHTML = errorReponse?.error
                            ?.newCustomUrl;

                    }
                });

                return false;
            };

            /**
             * Step1. select local image
             *
             */
            function selectLocalImage() {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.click();

                // Listen upload local image and save to server
                input.onchange = () => {
                    const file = input.files[0];

                    // file type is only image.
                    if (/^image\//.test(file.type)) {
                        saveToServer(file);
                    } else {
                        console.warn('You could only upload images.');
                    }
                };
            }

            /**
             * Step2. save to server
             */
            function saveToServer(file) {
                const fd = new FormData();
                fd.append('image', file);

                // const xhr = new XMLHttpRequest();
                // xhr.open('POST', 'http://localhost:3000/upload/image', true);
                // xhr.onload = () => {
                //     if (xhr.status === 200) {
                //         // this is callback data: url
                //         const url = JSON.parse(xhr.responseText).data;
                //         insertToEditor(url);
                //     }
                // };
                // xhr.send(fd);

                $.ajax({
                    data: fd,

                    url: "/customer/image",
                    type: "POST",
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Set content type to false as we're sending FormDataF

                    success: function(data) {
                        // The 'data' parameter is already a parsed JSON object, so you can access it directly
                        insertToEditor(data.url);
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Log the error response
                    }
                });
            }

            /**
             * Step3. insert image url to rich editor.          
             */
            function insertToEditor(url) {
                // push image url to rich editor.
                const range = quill.getSelection();
                quill.insertEmbed(range.index, 'image', `${url}`);
            }



            function imageHandler() {
                selectLocalImage();
            }

            var deleteProfileButton = document.getElementById("deleteProfile");

            deleteProfileButton.onclick = function() {
                // Populate hidden form on submit
                var id = document.querySelector('input[name=id]');
                // No back end to actually submit to!
                $.ajax({
                    data: {
                        id: id.value,
                    },
                    url: `/customer/delete`,
                    type: "POST",
                    dataType: 'json',
                    Accept: "application/json",
                    success: function(data) {

                        // console.log(data);
                        // const reponse = JSON.parse(data);
                        // console.log(data.url);

                        window.alert(`${data.success}`);
                        window.location.replace(`/`);

                    },
                    error: function(data) {
                        const errorReponse = JSON.parse(data.responseText);

                        if (errorReponse?.errorMessage) document.getElementById("errorMessage")
                            .innerHTML = errorReponse?.errorMessage;

                        if (errorReponse?.error?.about) document.getElementById("errorTextAbout")
                            .innerHTML = errorReponse?.error?.about;

                        if (errorReponse?.error?.editCode) document.getElementById(
                            "errorTextEditCode").innerHTML = errorReponse?.error?.editCode;

                        if (errorReponse?.error?.newEditCode) document.getElementById(
                            "errorTextNewEditCode").innerHTML = errorReponse?.error?.newEditCode;

                        if (errorReponse?.error?.newCustomUrl) document.getElementById(
                                "errorTextNewCustomUrl").innerHTML = errorReponse?.error
                            ?.newCustomUrl;

                    }   
                });

                return false;
            }


        })
    </script>
@endsection
