@extends('adminlte::page')

@section('title', 'Detailed Shift Report')

@section('content_header')
    <h1>Detailed Shift Report</h1>
@stop

@section('content')

    <style>
        .frow {
            border: 1px solid black;
            background: white;
            width:100%
        }

        .tbold{
            font-weight: bold;
        }

        .tcenter{
            text-align: center;
        }

        .pleft{
            padding-left:10px;
        }
    </style>

        <h5>Shift ID:  <span id="shiftId">{{ $id }}</span> </h5>

        <div class="container">

            <div class="row frow">

                <div class="col-lg-6">

                    <table class="table">
                        <tr><td>STUDIO</td><td class="tbold">{{ $inShift->studioName }}</td><td></td><td></td></tr>
                        <tr><td>DATE</td><td>{{ $inShift->created_at }}</td><td></td><td></td></tr>
                        <tr><td>SHIFT</td><td>{{ $inShift->trainer_shift_name }}</td><td></td><td></td></tr>
                        <tr><td>MODEL</td><td class="tbold">{{ $inShift->model }}</td><td></td><td></td></tr>
                        <tr><td>ROOM</td><td>{{ $inShift->room }}</td><td></td><td></td></tr>
                        <tr><td>AWARD PLACE</td><td>{{ $inShift->place_awd }}</td><td></td><td></td></tr>
                        <tr><td>AWARD POINTS</td><td>{{ $inShift->awd_points }}</td><td></td><td></td></tr>
                        <tr><td>PRICE PVT/MIN</td><td>{{ $inShift->price_minute_awemp }}$</td><td></td><td></td></tr>

                        @foreach ($resTrainerShift as $trainerShift)
                            @if ($inShift->support_main == $trainerShift->t_name)
                                <tr><td>SUPPORT IN CHARGE</td><td>{{ $trainerShift->t_name }}</td><td>{{ $trainerShift->date }}</td><td>{{ $trainerShift->end_date }}</td></tr>
                            @else
                                <tr><td>ADDITIONAL SUPPORT</td><td>{{ $trainerShift->t_name }}</td><td>{{ $trainerShift->date }}</td><td>{{ $trainerShift->end_date }}</td></tr>
                            @endif
                        @endforeach

                        {{--<tr><td>ADDITIONAL SUPPORT 1</td><td>{{ $inShift->support_main }}</td><td>{{ $inShift->trainer_shift }}</td><td>{{ $inShift->trainer_end_date }}</td></tr>--}}
                        {{--<tr><td>ADDITIONAL SUPPORT 2</td><td>{{ $inShift->support_main }}</td><td>{{ $inShift->trainer_shift }}</td><td>{{ $inShift->trainer_end_date }}</td></tr>--}}
                    </table>

                </div>
                <div class="col-lg-3">
                    Calendar June 2019
                </div>
                <div class="col-lg-3">
                    Calendar July 2019
                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">MODEL SHIFT INFO:</span>
                <div class="col-lg-12">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>ARRIVAL TIME</th><th>LOGIN TIME</th><th>PRE-LOGIN TIME</th><th>LOGIN TIME PERIOD</th><th>LOG OFF TIME PERIOD</th><th>ONLINE TIME</th><th>LOGOUT TIME</th><th>BREAKS TOTAL TIME</th><th>AVERAGE SHIFT SALES</th><th>TOTAL SHIFT SALES</th><th>SHIFT/AVERAGE</th>
                        </tr>
                        </thead>

                        <tr>
                            <td>{{ $inShift->arrival_time }}</td><td>{{ $inShift->login_time }}</td><td>{{ $inShift->pre_login_time }}</td><td>{{ $inShift->login_time_period_before }}</td><td>{{ $inShift->login_time_period_after }}</td><td>{{ $inShift->total_time_shift_w }}</td><td>{{ $inShift->logout_time }}</td><td>{{ $inShift->total_break_time_shift }}</td><td>{{ $inShift->avg_shift_sales }}</td><td>{{ $inShift->total_this_shift }}</td><td>{{ $inShift->shift_avg }}</td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">1. How did the model use the app since last logout till she ame to the studio today (short story) how much money she made while offline = income she had from messages + content sale +videocall income in this timeframe:</span>
                <div class="col-lg-12">

                    <table class="table">

                        <tr>
                            <td class="tcenter">{{ $inShift->field1 }}</td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">2. Live discution with model before shift start (or first break if the model started early), plan for the shift, good things from previous shift to continue and band ones to correct:</span>
                <div class="col-lg-12">

                    <table class="table">

                        <tr>
                            <td class="tcenter">{{ $inShift->field2 }}</td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">3. Aspects from the model's file we need to improve and how to improve and how did we improved them in this shift, details:</span>
                <div class="col-lg-12">

                    <table class="table">

                        <tr>
                            <td class="tcenter">{{ $inShift->field3 }}</td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">4. Model's feedback on this shift (to be completed by model or based on model's dictation):</span>
                <div class="col-lg-12">

                    <table class="table">

                        <tr>
                            <td class="tcenter">{{ $inShift->field4 }}</td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">5. Live discution with model after the half of the shift or after shift end, analyse of the plan done at shift start, what happened good and bad:</span>
                <div class="col-lg-12">

                    <table class="table">

                        <tr>
                            <td class="tcenter">{{ $inShift->field5 }}</td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">Notifications and Warnings:</span>
                <div class="col-lg-12">

                    <table class="table">
                        <thead>
                        <tr>
                            <th class="tcenter">Time recived</th><th class="tcenter">Suport</th><th class="tcenter">Reason</th><th class="tcenter">Time solved</th><th class="tcenter">Solved</th>
                        </tr>
                        </thead>


                        @foreach ($modeShiftWarnings as $warning)
                            <tr class="tcenter">
                                <td>{{ $warning->created_at }}</td><td>{{ $inShift->support_main }}</td><td>{{ $warning->name }}</td><td>{{ $warning->resolved_at }}</td><td>{{ $warning->reason }}</td>
                            </tr>
                        @endforeach

                    </table>

                </div>

            </div>

            <div class="row frow">
                <span class="tbold pleft">ScreenShots:</span>
                <div class="col-lg-12">

                    <table class="table">

                        <tr class="tcenter">
                            <td>picture_1</td><td>picture_1</td><td>picture_1</td><td>picture_1</td><td>picture_1</td><td>picture_1</td><td>picture_1</td><td>picture_1</td>
                        </tr>
                        <tr class="tcenter">
                            <td>picture_2</td><td>picture_2</td><td>picture_2</td><td>picture_2</td><td>picture_2</td><td>picture_2</td><td>picture_2</td><td>picture_2</td>
                        </tr>



                    </table>

                </div>

            </div>

        </div>

@stop

@section('adminlte_js')

    <script>


        $(document).ready( function () {

        } );





    </script>

@stop
