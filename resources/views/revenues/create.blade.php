@extends('layouts.app')
@section('content')
    <h3>Добавить доход</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('revenues.create') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="accounts" class="form-label">Счёт</label>
            <select id="accounts" name="account" class="form-select">
                <option></option>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="articles" class="form-label">Стаья дохода</label>
            <select id="articles" name="article" class="form-select">
                <option></option>
                @foreach($articles as $article)
                    <option value="{{ $article->id }}">{{ $article->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="total_sum" class="form-label">Сумма</label>
            <input type="text" class="form-control" id="total_sum" name="total_sum" value="">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection
