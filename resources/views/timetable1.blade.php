@extends('adminlte::page')

@section('title', 'TraineTime Tablers')


@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('css/TimeTable.css') }}">
@stop

@section('content_header')
    <h1>Time Table</h1>
@stop

@section('content')

<div id="example"></div>

@stop

@section('adminlte_js')

<script src="https://code.createjs.com/1.0.0/createjs.min.js"></script>
<script src="{{ asset('js/TimeTable.js') }}"></script>

<script>

    $(document).ready(function() {

        var instance = new TimeTable({

            // Beginning Time
            startTime: "01:00",

            // Ending Time
            endTime: "23:00",

            // Time to divide(minute)
            divTime: "60",

            // Time Table
            shift: shiftObj,

            // Other options
            option: {

            // workTime include time not displaying
            workTime: true,

            // bg color
            bgcolor: ["#00FFFF"],

            // {index :  name, : index: name,,..}
            // selectBox index and shift index should be same
            // Give randome if shift index was not in selectBox index
            // selectBox: {
            //     "2" : "Jason Paige",
            //     "3" : "Mr.Jason",
            //     "25" : "Mrs.Jason"
            // }
            }

            });

            instance.init("#example");


    } );

    let shiftObj = {
    "1" : {
        "Maria Anders": [
            {"1" : "10:00-12:00"},
            {"2" : "13:00-14:00"},
            {"9" : "17:00-20:00"},
        ]
    },
    "2" : {
        "Jason Paige": [
            {"3" : "11:00-12:45"},
            {"5" : "14:00-19:30"},
        ]
    },
    "500" : {
        "Roland Mendel": [
            {"8" : "13:00-19:00"}
        ]
    },
    "3" : {
        "Helen Bennett": [
            {"1" : "10:00-12:00"},
            {"2" : "13:00-14:00"},
            {"9" : "17:00-20:00"},
        ]
    },
    "4" : {
        "Mrs.Smith": [
            {"8" : "10:00-13:30"},
            {"7" : "14:00-17:30"},
        ]
    },
    "5" : {
        "Francisco Chang": [
            {"1" : "12:00-15:30"}
        ]
    },
    "6" : {
        "Yoshi Tannamuri": [
            {"0" : "15:00-22:30"}
        ]
    },
    "7" : {
        "Giovanni Rovelli": [
            {"9" : "15:00-18:30"}
        ]
    },
    "8" : {
        "John Doe": [
            {"1" : "10:00-12:00"},
            {"2" : "13:00-14:00"},
            {"3" : "17:00-20:30"},
        ]
    },
    "9" : {
        "MR.JSON": [
            {"2" : "09:00-12:59"},
            {"4" : "15:00-15:20"},
            {"7" : "17:00-17:30"},
        ]
    },
};

</script>
@stop


