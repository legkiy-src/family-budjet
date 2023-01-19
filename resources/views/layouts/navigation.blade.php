<?php
use Illuminate\Support\Facades\Route;

$route = Route::currentRouteName();
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('accounts') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link {{ $route === 'accounts' ? 'active' : '' }}" aria-current="page" href="{{ route('accounts') }}">Счета</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $route === 'revenues' ? 'active' : '' }}" href="{{ route('revenues') }}">Доходы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $route === 'articles' ? 'active' : '' }}" href="{{ route('articles') }}">Статьи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $route === 'currencies' ? 'active' : '' }}" href="{{ route('currencies') }}">Валюты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $route === 'reports' ? 'active' : '' }}" href="{{ route('reports') }}">Отчёты</a>
                </li>
            </ul>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
