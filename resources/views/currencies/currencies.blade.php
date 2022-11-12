@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <h3>Валюты</h3>
        <div class="mb-2">
            <a href="{{ route('currencies.create') }}" class="btn btn-primary" role="button">Добавить</a>
        </div>
        <table id="data" class="table table-bordered table-hover">
            <thead>
            <tr class="text-center">
                <th>Наименование</th>
                <th>Обозначение</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($currencies as $currency)
                <tr>
                    <td><a href="{{ route('currencies.edit', ['id' => $currency['id']]) }}">{{ $currency['name'] }}</a></td>
                    <td>{{ $currency->symbol }}</td>
                    <td>
                        <a href="{{ route('currencies.edit', ['id' => $currency['id']]) }}" class="btn btn-light" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                            </svg>
                        </a>
                        <a class="btn btn-light" role="button" data-bs-toggle="modal" data-bs-target="#warningDelCurrency" data-currency-id="{{ $currency['id'] }}" id="delCurrencyBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            @empty
                <div class="text-danger m-2">Список пуст</div>
            @endforelse
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
    <div class="modal fade" id="warningDelCurrency" tabindex="-1" aria-labelledby="warningDelCurrency" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Внимание!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        При удалении валют, так же удалятся связанные с ними операции.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <a href="" class="btn btn-primary" role="button" id="delLink">Удалить</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#delCurrencyBtn').click(function(){
            let currencyId = $(this).attr('data-currency-id');
            console.log(currencyId);
            $("#delLink").attr('href', 'currencies/' + currencyId + '/delete' );
        });
    </script>
@endpush
