@extends('layouts.app')

@section('content')
    <div class="container">
        <vue-jalali-calendar
            :year="1394" {{-- year --}}
            :month="4" {{-- month --}}
            {{--        onSelect=""--}} {{-- your event o select --}}
            :texts='{"2015-07-10":"1","2015-07-09":"2","2015-08-10":"2"}' {{-- custom text each days --}}
        ></vue-jalali-calendar>

        <form action="">
            <div class="card mt-3">
                <div class="card-header">
                    Currency input sample
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            currency input sampe:
                        </div>
                        <div class="col-md-6">
                            <currency-input xid="test" xname="test" xtitle="Currency input sample" xvalue="10000"></currency-input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    Remix icon picker
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Remix icon picker
                        </div>
                        <div class="col-md-6">
                            <remix-icon-picker xname="icon" xvalue="ri-twitter-x-line"></remix-icon-picker>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    Font awesome free icon picker
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Font awesome free icon picker
                        </div>
                        <div class="col-md-6">
                            <awesome-icon-picker xname="icon" xvalue="fab fa-twitter"></awesome-icon-picker>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    DatePicker
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            DatePicker
                        </div>
                        <div class="col-md-6">
                            <vue-datetime-picker-input xname="datepicker" xtitle="my custom placeholder" :xvalue="679097914" ></vue-datetime-picker-input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    DateTimePicker
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            DateTimePicker
                        </div>
                        <div class="col-md-6">
                            <vue-datetime-picker-input xname="datepicker" xtitle="DOB" :close-on-Select="true" :xvalue="" :timepicker="true" xshow="hpdatetime"></vue-datetime-picker-input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    Date Range Picker
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Date Range Picker
                        </div>
                        <div class="col-md-6">
                            <vue-date-range-picker-input xname="datepicker" xtitle="Trip range" :close-on-Select="false" :xvalue="" :timepicker="true" xshow="hpdatetime"></vue-date-range-picker-input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    Searchable select
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Searchable select
                        </div>
                        <div class="col-md-6">
                            <searchable-select :items='{{\App\Models\Category::all(['id','title'])}}' title-field="title" xvalue="3" :close-on-Select="true"></searchable-select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    Searchable multi select
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Searchable multi select
                        </div>
                        <div class="col-md-6">
                            <searchable-multi-select :items='{{\App\Models\Category::all(['id','title'])}}' title-field="title" :xvalue='[3,11,7]' :close-on-Select="true"></searchable-multi-select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    Increment
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Searchable multi select
                        </div>
                        <div class="col-md-6">
                            <increment v-model="value"></increment>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
