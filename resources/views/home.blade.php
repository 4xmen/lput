@extends('layouts.app')

@section('content')
<div class="container">
    <vue-jalali-calendar
        year="1394" {{-- year --}}
        month="4" {{-- month --}}
{{--        onSelect=""--}} {{-- your event o select --}}
        :texts='{"2015-07-10":"1","2015-07-09":"2","2015-08-10":"2"}' {{-- custom text each days --}}
    ></vue-jalali-calendar>
</div>
@endsection
