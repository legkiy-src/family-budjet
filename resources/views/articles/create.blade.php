@extends('layouts.app')
@section('content')
    <h3>Добавить статью дохода/расхода</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('articles.create') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="operationType" class="form-label">Тип операции</label>
            <select id="operationType" name="operationType" class="form-select">
                <option></option>
                @foreach($operationTypes as $operationType)
                    <option value="{{ $operationType->id }}">{{ $operationType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Наименование</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection
