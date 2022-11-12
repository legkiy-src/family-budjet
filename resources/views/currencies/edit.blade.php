
@extends('layouts.app')
@section('content')
    <h3>Редактировать валюту</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('currencies.edit', ['id' => $currency->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Наименование</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $currency->name }}">
        </div>
        <div class="mb-3">
            <label for="symbol" class="form-label">Обозначение</label>
            <input type="text" class="form-control" id="symbol" name="symbol" value="{{ $currency->symbol }}">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection
