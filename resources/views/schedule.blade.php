@extends('adminlte::page')

@section('title', 'Manager Schedule & Model Allocation')

@section('content_header')
    <h1>Manager Schedule & Model Allocation</h1>
@stop

@section('content')

    <style>
        .ftablew{
            width:200px;
        }
        .stablew{
            width:100%;
        }
        .fcontainer{
            margin-top: 50px;
            margin-left: 10px;
            margin-right: 10px;
            width: 100%;
        }
        .mtop{
            margin-top:25px;
        }
        .fbold{
            font-weight: bold;
        }
        .green-white{
            background-color: green;
            color: white;
            text-align: center;
        }
        select{
            background: green;
            color: white;
        }

    </style>


    <div class="container fcontainer">

        <div class="row ">

            <div class="col-lg-6">

                <table class="ftablew table-bordered fbold">

                    <tr><td>STUDIO</td><td>{{ $sname }}</td></tr>
                    <tr><td>MANAGER</td><td>{{ $username }}</td></tr>

                </table>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <table class="ftablew table-bordered mtop fbold">

                    <tr><td>MONTH</td>
                        <td id="monthSelect">
                            <select class="selectChange">
                                {!! $selectMonths !!}
                            </select>
                        </td>

                </table>

            </div>

        </div>



        <div class="row">

            <div class="col-lg-12">

                <table id="firstTable" class="stablew mtop">

                </table>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <table id="secondTable" class="stablew mtop ">
                    {{--<tbody>--}}
                        {{--<tr  class="fbold"><td>Second Period</td><td>01.06.2019</td><td>02.06.2019</td><td>03.06.2019</td><td>04.06.2019</td><td>05.06.2019</td><td>06.06.2019</td><td>07.06.2019</td><td>08.06.2019</td><td>09.06.2019</td><td>10.06.2019</td><td>11.06.2019</td><td>12.06.2019</td><td>13.06.2019</td><td>14.06.2019</td><td>15.06.2019</td></tr>--}}
                        {{--<tr><td class="fbold">T1 07:00-19:00</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td></tr>--}}
                        {{--<tr><td class="fbold">T2 07:00-19:00</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td></tr>--}}
                        {{--<tr><td class="fbold">Aditional Support/Trainer T1</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td></tr>--}}
                        {{--<tr><td class="fbold">T2 19:00-07:00</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td></tr>--}}
                        {{--<tr><td class="fbold">T2 19:00-07:00</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td></tr>--}}
                        {{--<tr><td class="fbold">Aditional Support/Trainer T2</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td><td>Select..</td></tr>--}}
                        {{--<tr><td class="fbold">Total models T1</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td></tr>--}}
                        {{--<tr><td class="fbold">Total models T2</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td><td>12</td></tr>--}}
                    {{--</tbody>--}}
                </table>

            </div>

        </div>


        <div class="row">

            <div class="col-lg-6">

                <table class="stablew mtop ">
                    <thead class="fbold">
                    <tr><th>Name</th><th>Job Title</th><th>Models First Period</th><th>Models Second Period</th></tr>
                    </thead>
                    <tbody>

                        @foreach($trFinal as $user)

                            <tr><td>{{ $user['name'] }}</td><td>{{ $user['job'] }}</td><td>Edit</td><td>Edit</td></tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>



    </div>

@stop

@section('adminlte_js')

    <script>

        let year = {{ $y }};
        let endSecond = {{ $ndays }};
        let endFirst = 15;

        $(document).ready( function () {

            let selectChange = $('.selectChange');

            generateShiftSchedule1(selectChange.val());
            generateShiftSchedule2(selectChange.val());

            selectChange.change(function (){
                let selectedMonth = $(this).val();
                generateShiftSchedule1(selectedMonth);
                generateShiftSchedule2(selectedMonth);

            });

        } );

        function generateShiftSchedule1(month){

            let firstTable = $('#firstTable');
            firstTable.empty();

                let f_tr = $("<tr/>",{ "class": "fbold"});

                let f_td = $("<td/>",{text: "Shift schedule:"});
                let emptyTd = '';
                for (let i = 0; i < endFirst; i++) emptyTd += "<td></td>";

                f_tr.append(f_td);
                f_tr.append(emptyTd);

                firstTable.append(f_tr);
                //---------------------------------------

                let s_tr = $("<tr/>",{ "class": "fbold"});
                let s_td = $("<td/>",{text: "First Period:"});
                s_tr.append(s_td);

                for (let i = 1; i < endFirst + 1; i++) {
                    let td = $("<td/>",{text: aZ(i)+"."+aZ(month)+"."+year});
                    s_tr.append(td);
                }
                firstTable.append(s_tr);
                //----------------------------------------
                let tr1 = $("<tr/>",{});
                let td1 =  $("<td/>",{"class": "fbold" , text: "T1 07:00-19:00"});
                tr1.append(td1);

                for (let i = 1; i < endFirst + 1; i++) {
                    let td = $("<td/>",{text: "Select.."});
                    tr1.append(td);
                }
                firstTable.append(tr1);
                //-----------------------------------------
                let tr2 = $("<tr/>",{});
                let td2 =  $("<td/>",{"class": "fbold" , text: "T2 07:00-19:00"});
                tr2.append(td2);

                for (let i = 1; i < endFirst + 1; i++) {
                    let td = $("<td/>",{text: "Select.."});
                    tr2.append(td);
                }
                firstTable.append(tr2);
            //-----------------------------------------
                let tr3 = $("<tr/>",{});
                let td3 =  $("<td/>",{"class": "fbold" , text: "Aditional Support/Trainer T1"});
                tr3.append(td3);

                for (let i = 1; i < endFirst + 1; i++) {
                    let td = $("<td/>",{text: "Select.."});
                    tr3.append(td);
                }
                firstTable.append(tr3);
            //-----------------------------------------
            let tr4 = $("<tr/>",{});
            let td4 =  $("<td/>",{"class": "fbold" , text: "T2 19:00-07:00"});
            tr4.append(td4);

            for (let i = 1; i < endFirst + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr4.append(td);
            }
            firstTable.append(tr4);
            //-----------------------------------------
            let tr5 = $("<tr/>",{});
            let td5 =  $("<td/>",{"class": "fbold" , text: "T2 19:00-07:00"});
            tr5.append(td5);

            for (let i = 1; i < endFirst + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr5.append(td);
            }
            firstTable.append(tr5);
            //-----------------------------------------
            let tr6 = $("<tr/>",{});
            let td6 =  $("<td/>",{"class": "fbold" , text: "Aditional Support/Trainer T2"});
            tr6.append(td6);

            for (let i = 1; i < endFirst + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr6.append(td);
            }
            firstTable.append(tr6);
            //-----------------------------------------
            let tr7 = $("<tr/>",{});
            let td7 =  $("<td/>",{"class": "fbold" , text: "Total models T1"});
            tr7.append(td7);

            for (let i = 1; i < endFirst + 1; i++) {
                let td = $("<td/>",{text: "12"});
                tr7.append(td);
            }
            firstTable.append(tr7);
            //-----------------------------------------
            let tr8 = $("<tr/>",{});
            let td8 =  $("<td/>",{"class": "fbold" , text: "Total models T2"});
            tr8.append(td8);

            for (let i = 1; i < endFirst + 1; i++) {
                let td = $("<td/>",{text: "12"});
                tr8.append(td);
            }
            firstTable.append(tr8);

        }

        function generateShiftSchedule2(month){

            endSecond = daysInMonth(month , year);
            console.log("max days: " + endSecond);

            let secondTable = $('#secondTable');
            secondTable.empty();

            let s_tr = $("<tr/>",{ "class": "fbold"});
            let s_td = $("<td/>",{text: "Second Period:"});
            s_tr.append(s_td);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: aZ(i)+"."+aZ(month)+"."+year});
                s_tr.append(td);
            }
            secondTable.append(s_tr);

            //----------------------------------------
            let tr1 = $("<tr/>",{});
            let td1 =  $("<td/>",{"class": "fbold" , text: "T1 07:00-19:00"});
            tr1.append(td1);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr1.append(td);
            }
            secondTable.append(tr1);
            //-----------------------------------------
            let tr2 = $("<tr/>",{});
            let td2 =  $("<td/>",{"class": "fbold" , text: "T2 07:00-19:00"});
            tr2.append(td2);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr2.append(td);
            }
            secondTable.append(tr2);
            //-----------------------------------------
            let tr3 = $("<tr/>",{});
            let td3 =  $("<td/>",{"class": "fbold" , text: "Aditional Support/Trainer T1"});
            tr3.append(td3);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr3.append(td);
            }
            secondTable.append(tr3);
            //-----------------------------------------
            let tr4 = $("<tr/>",{});
            let td4 =  $("<td/>",{"class": "fbold" , text: "T2 19:00-07:00"});
            tr4.append(td4);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr4.append(td);
            }
            secondTable.append(tr4);
            //-----------------------------------------
            let tr5 = $("<tr/>",{});
            let td5 =  $("<td/>",{"class": "fbold" , text: "T2 19:00-07:00"});
            tr5.append(td5);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr5.append(td);
            }
            secondTable.append(tr5);
            //-----------------------------------------
            let tr6 = $("<tr/>",{});
            let td6 =  $("<td/>",{"class": "fbold" , text: "Aditional Support/Trainer T2"});
            tr6.append(td6);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "Select.."});
                tr6.append(td);
            }
            secondTable.append(tr6);
            //-----------------------------------------
            let tr7 = $("<tr/>",{});
            let td7 =  $("<td/>",{"class": "fbold" , text: "Total models T1"});
            tr7.append(td7);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "12"});
                tr7.append(td);
            }
            secondTable.append(tr7);
            //-----------------------------------------
            let tr8 = $("<tr/>",{});
            let td8 =  $("<td/>",{"class": "fbold" , text: "Total models T2"});
            tr8.append(td8);

            for (let i = 16; i < endSecond + 1; i++) {
                let td = $("<td/>",{text: "12"});
                tr8.append(td);
            }
            secondTable.append(tr8);

        }

        function aZ(n){
            if(n <= 9){
                return "0" + n;
            }
            return n
        }

        function daysInMonth (month, year) {
            return new Date(year, month, 0).getDate();
        }


    </script>

@stop
