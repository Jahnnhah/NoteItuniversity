@extends('layouts.app')

@section('title', 'Parametre Management')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="cadre">
        <h1 class="mb-4">Parameter List</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif

        <!-- Form for adding a new parameter -->
        <form action="{{ route('parametre.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="borneinf">Borne Inférieure:</label>
                <input type="number" name="borneinf" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bornesup">Borne Supérieure:</label>
                <input type="number" name="bornesup" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="couleur">Color:</label>
                <input type="text" name="couleur" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Parameter</button>
        </form>

        <!-- Table for listing parameters -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Borne Inférieure</th>
                        <th>Borne Supérieure</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parametres as $parametre)
                        <tr>
                            <td>{{ $parametre->id }}</td>
                            <td>
                                <form action="{{ route('parametre.update', $parametre->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="borneinf" value="{{ $parametre->borneinf }}" class="form-control" required>
                            </td>
                            <td>
                                    <input type="number" name="bornesup" value="{{ $parametre->bornesup }}" class="form-control" required>
                            </td>
                            <td>
                                <input type="text" name="couleur" value="{{ $parametre->couleur }}" class="form-control" required>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Modify</button>
                                </form>
                                <!-- Delete Form -->
                                <form action="{{ route('parametre.destroy', $parametre->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
