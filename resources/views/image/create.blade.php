@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Gambar</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Gambar</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">File Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Enter File Name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="file_name">File</label>
                            <input type="file" class="file-control @error('file_name') is-invalid @enderror" id="file_name"
                                name="file_name" placeholder="Upload File" value="{{ old('file_name') }}">
                            @error('file_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('image.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
