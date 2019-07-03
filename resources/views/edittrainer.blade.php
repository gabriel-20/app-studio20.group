@extends('adminlte::page')

@section('title', 'Edit Trainer')

@section('content_header')
    <h1>Edit Trainer</h1>
@stop

@section('content')

<div class="col-lg-6">

<form method="POST" action="/admin/addtrainer">
    @csrf

    <div class="form-group">
        <label for="inputName">Trainer Name</label>
        <input type="text" class="form-control" name="name" id="inputName"  aria-describedby="nameHelp" value="{{ $trainer->name }}" placeholder="{{ $trainer->name }}" required>
        <small id="nameHelp" class="form-text text-muted">Enter trainer name for selected studio.</small>
    </div>
    
    <div class="form-group">
        <label for="inputEmail">Email address</label>
        <input type="email" class="form-control" name="email" id="inputEmail" aria-describedby="emailHelp" value="{{ $trainer->email }}" placeholder="{{ $trainer->email }}" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>

    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" required>
    </div>

    <div class="form-group">
        <label for="inputPhone">Phone Number</label>
        <input type="text" class="form-control" name="phone" restart id="inputPhone" aria-describedby="phoneHelp" value="{{ $trainer->phone }}" placeholder="{{ $trainer->phone }}" required>
        <small id="phoneHelp" class="form-text text-muted">+40 ..</small>
    </div>

    <div class="form-group">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputStudio">Select Studio</label>
            </div>
            <select name="studio" class="custom-select" id="inputStudio" required>
                @foreach ($studios as $studio)
                    @if ($studio->id ==  $trainer->studio ) 
                    <option selected value="{{ $studio->id }}">{{ $studio->name }}</option>
                    @else
                    <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputStudio">Select Type</label>
                </div>
                <select name="type" class="custom-select" id="inputType" required>
                    @foreach ($type as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                </select>
            </div>

        </div>

    </div>

    <input type="hidden" id="id" name="id" value="{{ $trainer->id }}">

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    
</div>

@stop

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
