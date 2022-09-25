@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white overflow-hidden shadow-sm sm:rounded-lg"  style="min-width: 1232px;">
        <table id="data" class="table table-bordered table-hover">
            <thead>
            <tr class="text-center">
                <th>Название счёта</th>
                <th>Остаток</th>
                <th>Валюта</th>
                <th>Описание</th>
            </tr>
            </thead>
            <tbody>
            @forelse($accounts as $account)
                <tr>
                    <td>{{ $account['name'] }}</td>
                    <td>{{ number_format($account['balance'] / 100, 2) }}</td>
                    <td>{{ $account['currency'] }}</td>
                    <td>{{ $account['description'] }}</td>
                </tr>
            @empty
                <div class="text-danger m-2">Список пуст</div>
            @endforelse
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
@endsection
@push('styles')
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endpush
