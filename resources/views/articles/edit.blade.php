
@extends('layouts.app')
@section('content')
    <h3>Редактировать статью дохода/расхода</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('articles.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="hidden" name="id" value="{{ $article->id }}">
            <label for="operationType" class="form-label">Тип</label>
            <select id="operationType" name="operationType" class="form-select">
                @foreach($operationTypes as $operationType)
                    @if ($operationType->id == $article->operationType->id)
                        <option value="{{ $operationType->id }}" selected>{{ $operationType->name }}</option>
                    @else
                        <option value="{{ $operationType->id }}">{{ $operationType->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Наименование</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $article->name }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description">{{ $article->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection
