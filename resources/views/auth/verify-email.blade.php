@extends('layouts.index')  {{-- sesuaikan dengan layout Anda --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifikasi Email</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif

                    <p>Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.</p>
                    <p>Jika Anda tidak menerima email,</p>

                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            Klik di sini untuk mengirim ulang email verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection