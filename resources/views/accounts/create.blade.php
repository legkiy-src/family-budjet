@extends('layouts.app')
@section('content')
    <h3>Добавить счёт</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('accounts.create') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Наименование</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="currencies" class="form-label">Валюта</label>
            <select id="currencies" name="currency" class="form-select">
                @foreach($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="balance" class="form-label">Баланс</label>
            <input type="number" min="0.01" step="0.01" class="form-control" id="balance" name="balance" value="{{ number_format(old('balance'), 2)}}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection
