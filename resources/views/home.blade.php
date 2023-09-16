@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Create the editor container -->
    <!-- <form> -->
    <div class="row form-group mb-2">
        <!-- <label for="about">About me</label> -->
        <input name="about" type="hidden">
        <div id="editor-container">
        </div>
    </div>
    <div class="row ">
        <div class="col-md-10">
            <div class="row">
            <div class="col-md-6">
                <input class="form-control" name="customEditCode" type="text" placeholder="Custom Edit Code">
            </div>
            <div class="col-md-6 ">
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