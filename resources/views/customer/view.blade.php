@extends('layouts.app')

@section('content')
    <div class="container" id="viewCustomer">
        <!-- Create the editor container -->

        <div class="row mb-1 ">
            <div class="col-12">
                <div id="view-editor-container">
                </div>
            </div>

        </div>

        <div class="row  mt-1 mb-1 justify-content-between">

            <div class="col-auto mr-auto">
                <a type="button" class="btn btn-primary" href="/{{ $customer->customUrl }}/edit">Edit</a>
            </div>
            <div class="col-auto  text-end">
                <p>
                    Pub: {{ gmdate('j M Y H:i', strtotime($customer->created_at)) . ' UTC' }}
                    <br>
                    Edit: {{ gmdate('j M Y H:i', strtotime($customer->updated_at)) . ' UTC' }}
                    <br>
                    Views: {{ $customer->viewCount }}
                </p>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(function() {

            var viewQuill = new Quill('#view-editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: false
                },

            });

            var customerData = {!! json_encode($customer->personalData) !!};
            const customerObject = JSON.parse(customerData);
            viewQuill.setContents(customerObject);
            viewQuill.enable(false);

        })
    </script>
@endsection
