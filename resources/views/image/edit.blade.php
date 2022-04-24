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
            <h2 class="section-title">Edit Image</h2>
            <div class="card">
                <form action="{{ route('image.update', $images->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card-header">
                        <h4>Validasi Edit Data Gambar</h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name">File Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $images->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">File</label>
                            <input type="file" class="file-control @error('image') is-invalid @enderror" id="image"
                                name="image">
                            <img src="{{ asset('uploads/images/'.$images->file_name)}}" alt="{{ $images->name}}" width="70px" height="70px">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                        <a class="btn btn-secondary" href="{{ route('user.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
