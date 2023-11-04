@extends('layouts.info.app')

@section('content')
    <div class="container">
        <form action="info/customer/add" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card shadow">

                <div class="row card-header m-2">
                    <h3>Profile Details : </h3>
                </div>


                <div class="row">
                    <div class="col-md-6 form-group">
                        <input type="hidden" name="indentifier" value="{{ $qrIdentifier }}">


                        <div class="m-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                aria-describedby="nameHelp" placeholder="Enter Name">

                            @error('name')
                                <div id="nameHelp" class="form-text text-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="m-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                aria-describedby="emailHelp" placeholder="Enter Email Address"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*">

                            @error('email')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="m-2">
                            <label for="number" class="form-label">Contact Number / WhatsApp Number</label>
                            <input type="text" class="form-control" id="number" name="number"
                                aria-describedby="numberHelp" placeholder="Enter Contact Number / WhatsApp Number"
                                pattern="[0-9]{10}" maxlength="10" minlength="10">

                            @error('number')
                                <div id="numberHelp" class="form-text text-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="m-2">
                            <label for="image" class="form-label">Upload Profile Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profileImage"
                                aria-describedby="profileImageHelp">

                            @error('profileImage')
                                <div id="profileImageHelp" class="form-text text-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="m-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                aria-describedby="usernameHelp" placeholder="Set Username">

                            @error('username')
                                <div id="usernameHelp" class="form-text text-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="m-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password"
                                aria-describedby="passwordHelp" placeholder="Set Password">

                            @error('password')
                                <div id="passwordHelp" class="form-text text-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <div class="m-2">
                            <label for="piTemplate" class="form-label">Personal Info Template</label>

                            <select class="form-select" name="piTemplate" id="piTemplate"
                                aria-label="Default select example">
                                <option value="" selected>Choose Template For Personal Info</option>
                                @if (count($profileTemplate) > 0)
                                    @foreach ($profileTemplate as $template)
                                        <option value="{{ $template->value }}">{{ $template->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1">No Template Found</option>
                                @endif

                            </select>
                            @error('password')
                                <div id="passwordHelp" class="form-text text-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <div class="m-2">
                            <textarea name="info" id="personalInfo" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <div class="m-2">
                            <label for="documents" class="form-label">Upload Documents</label>
                            <div class="input-group m-2">
                                <input type="file" class="form-control col-md-6" name="documents[]" id="documents">
                                <button type="button" class="btn btn-primary col-md-2" id="addDocument">+ Add</button>
                            </div>
                            <div class="row" id="documentsList">


                            </div>
                        </div>
                    </div>



                    <div class="col-md-12 ">
                        <div class="row justify-content-center m-2">
                            <button type="submit" class="btn btn-primary col-md-3 m-1">Submit</button>
                            <button type="reset" class="btn btn-secondary col-md-3 m-1">Reset</button>
                        </div>

                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            const editor = Jodit.make('#personalInfo');


            const Template = document.getElementById('piTemplate');

            Template.onChange = function() {
                const value = Template.value;
                editor.value = value;

                console.log(value);
            }

            $('#piTemplate').change(function() {
                const value = Template.value;
                editor.value = value;
            });



            // Function to add a new Document Upload Input
            function addElement() {
                const newElement = document.createElement('div');
                newElement.classList.add('input-group');
                newElement.classList.add('m-2');
                newElement.innerHTML = `<input type="file" class="form-control col-md-6" name="documents[]">`;
                newElement.innerHTML +=
                    `<button type="button" class="btn btn-danger col-md-2 remove-button" >- Remove</button>`;
                document.getElementById('documentsList').appendChild(newElement);

                // Add click event listener to the "Remove" button
                const removeButton = newElement.querySelector('.remove-button');
                removeButton.addEventListener('click', function() {
                    removeElement(newElement);
                });
            }

            // Function to remove a specific element
            function removeElement(element) {
                element.remove();
            }

            // Add click event listener to the "Add Element" button
            document.getElementById('addDocument').addEventListener('click', addElement);
        });
    </script>
@endsection
