@extends('adminlte::page')

@push('css')
    <style>
        .calendar {
            border: 1.5px solid black;
            border-radius: 4px;
        }


        .calendar table {
            table-layout: fixed;
            width: 100%;
        }

        .calendar .card-header{
            font-weight: bolder;
            background-color: #CCEAE1;
            border-radius: 4px 4px 0 0;
        }


        .table-bordered td, .table-bordered th
        {
            border:0;
            text-align: center;
        }

        .table-bordered th{
            color: #8c97a1;
            font-size: 17px;
            font-weight: 400;
            line-height: 17px;
            letter-spacing: -.02em;
            text-transform: capitalize;
        }

        .weekend {
            background-color: #C0C0C0;
        }

        .birthday {
            background-color: #ffc6f561;
        }

        .national_holiday {
            background-color: #C1ECAC;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .alternative_holiday {
            background-color: #abbbea;
        }

        .company_holiday {
            background-color: #00bc8c66;
        }

        .selectable_day:hover {
            background-color: #ffedb7;
        }

        .tooltip-inner {
            background-color: #333;
            color: #fff;
        }

        .tooltip-arrow {
            border-top-color: #333;
        }

    </style>
@endpush

@section('content')
    <livewire:calendar key="{{ now() }}" />
@stop


@section('js')
    @stack('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
