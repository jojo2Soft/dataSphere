@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row my-5 justify-content-center">
        <div class="col-md-6 my-5">
            <div class="card">
                <div class="card-header">Importer un Dataset</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('datasets.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group my-3">
                            <label for="file">Fichier Dataset (CSV ou EXCEL)</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <div class="form-group my-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-0">Importer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
