@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container py-4">
    <h2 class="mb-3">Dashboard</h2>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Selamat datang</h5>
                    <p class="card-text">Halo, {{ auth()->user()->name ?? auth()->user()->email }}.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
