@extends('layouts.app')
@section('content')
    <div class="py-12 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="accounts-home-tab" data-bs-toggle="pill" data-bs-target="#accounts-home" type="button" role="tab" aria-controls="accounts-home" aria-selected="true">Счета</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-operations-tab" data-bs-toggle="pill" data-bs-target="#pills-operations" type="button" role="tab" aria-controls="pills-operations" aria-selected="false">Операции</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-articles-tab" data-bs-toggle="pill" data-bs-target="#pills-articles" type="button" role="tab" aria-controls="pills-articles" aria-selected="false">Статьи</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-currencies-tab" data-bs-toggle="pill" data-bs-target="#pills-currencies" type="button" role="tab" aria-controls="pills-currencies" aria-selected="false">Валюты</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-reports-tab" data-bs-toggle="pill" data-bs-target="#pills-reports" type="button" role="tab" aria-controls="pills-reports" aria-selected="false">Отчёты</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="accounts-home" role="tabpanel" aria-labelledby="accounts-home-tab" tabindex="0">

                </div>
                <div class="tab-pane fade" id="pills-operations" role="tabpanel" aria-labelledby="pills-operations-tab" tabindex="0">

                </div>
                <div class="tab-pane fade" id="pills-articles" role="tabpanel" aria-labelledby="pills-articles-tab" tabindex="0">

                </div>
                <div class="tab-pane fade" id="pills-currencies" role="tabpanel" aria-labelledby="pills-currencies-tab" tabindex="0">

                </div>
                <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab" tabindex="0">

                </div>
            </div>
        </div>
    </div>
@endsection
