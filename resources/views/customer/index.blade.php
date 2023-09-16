@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Create the editor container -->
        <form action="/customer/add" method="POST" id="customerAddForm">
            @csrf
            <div class="row mb-5">
                <div class="col-12">
                    <input name="about" type="hidden">
                    <div id="editor-container">
                    </div>
                </div>
            </div>
            <div class="row ">

                <div class="col-md-10">
                    <div class="row ">
                        <div class="col-md-6">
                            <input class="form-control" name="customEditCode" type="text" placeholder="Custom Edit Code">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" name="customUrl" type="text" placeholder="Custom Url">
                        </div>
                    </div>

                </div>
                <div class="col-md-2">
                    <button class="btn  btn-primary w-100" id="saveProfile">Save Profile</button>
                </div>
            </div>
            <!-- </form> -->
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


            const
                defaultDelta = {
                    "ops": [{
                        "insert": "WhoICard Emergency Keychain"
                    }, {
                        "attributes": {
                            "header": 2
                        },
                        "insert": "\n"
                    }, {
                        "insert": "\n"
                    }, {
                        "insert": "\n\n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Name"
                    }, {
                        "insert": ": Arjun Sharma\n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Email ID"
                    }, {
                        "insert": ": support@whoicard.com\n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Call / WhatsApp"
                    }, {
                        "insert": ": +918141165881\n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Job in Company"
                    }, {
                        "insert": ": WhoICard\n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Address"
                    }, {
                        "insert": ": Vadodara, Gujarat - 390009 India.\n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Date of Birth"
                    }, {
                        "insert": ": 01/01/2001 \n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Blood Group"
                    }, {
                        "insert": ": B+ \n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Medical conditions"
                    }, {
                        "insert": ": Type 1 diabetes.\n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Allergies"
                    }, {
                        "insert": ": Sulfa and Aspirin. \n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Surgeries"
                    }, {
                        "insert": ": partial nephrectomy. \n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Medical Information"
                    }, {
                        "insert": ": Headache (Sometime Only) \n"
                    }, {
                        "attributes": {
                            "bold": true
                        },
                        "insert": "Running Medicine"
                    }, {
                        "insert": ": Vicks Action 500 (When Headache) \n\nIn case of an emergency, please contact below. "
                    }, {
                        "attributes": {
                            "header": 2
                        },
                        "insert": "\n"
                    }, {
                        "insert": "\nABC Sharma: +91 9123456789 \nXYZ Sharma: +91 9123445566 \n\n(Call/WhatsApp in Hindi and English) \n\nGovernment health ID Card "
                    }, {
                        "attributes": {
                            "header": 2
                        },
                        "insert": "\n"
                    }, {
                        "insert": "\nHealth ID Number (hidn): 71-0000-0000-0000 \nHealth ID (hid): userhealthexampleid@ndhm \n\nInsurance & Medical Policy "
                    }, {
                        "attributes": {
                            "header": 2
                        },
                        "insert": "\n"
                    }, {
                        "insert": "Policy: Life Insurance Corporation of India \nPolicy Name: LIC Arogya Rakshak \nPolicy Type: Cashless \nPolicy Number: 00123456 \n\nAmbulance Number: 108"
                    }, {
                        "attributes": {
                            "header": 1
                        },
                        "insert": "\n"
                    }]
                };

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

            quill.setContents(defaultDelta);

            var saveProfileButton = document.getElementById("saveProfile");

            // var form = document.querySelector('form');

            saveProfileButton.onclick = function() {
                // Populate hidden form on submit
                var about = document.querySelector('input[name=about]');
                var customEditCode = document.querySelector('input[name=customEditCode]');
                var customUrl = document.querySelector('input[name=customUrl]');

                about.value = JSON.stringify(quill.getContents());

                console.log(about.value);

                // console.log("Submitted", $(form).serialize(), $(form).serializeArray());

                // No back end to actually submit to!
                $.ajax({
                    data: {
                        about: about.value,
                        customEditCode: customEditCode.value,
                        customUrl: customUrl.value
                    },
                    url: "/customer/add",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

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

        })
    </script>
@endsection
