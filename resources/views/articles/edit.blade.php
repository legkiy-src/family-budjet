
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
    <form action="{{ route('articles.edit', ['id' => $article->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="type" class="form-label">Тип</label>
            <select id="type" name="type" class="form-select">
                <option value="1" {{ $selected = $article->type === 1 ? 'selected' : '' }}>Доход</option>
                <option value="2" {{ $selected = $article->type === 2 ? 'selected' : '' }}>Расход</option>
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
