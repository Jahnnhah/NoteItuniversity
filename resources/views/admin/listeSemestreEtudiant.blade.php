<!-- resources/views/vehicules/create.blade.php -->
@extends('layouts.app')

@section('title', 'Page_Acceuil')

@section('style')
<style>
    /* Custom styles for the create vehicule page */

    h1 {
        font-size: 2.5em;
        color: #101A45; /* Dark Blue color theme for headings */
        text-align: center;
        margin-bottom: 20px;
        font-family: Arial, sans-serif;
    }

    .table {
        margin-top: 20px;
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
        border: 1px solid #dee2e6;
    }

    .table th {
        background-color: #101A45; /* Dark Blue for the table header */
        color: #fff; /* White text for contrast */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #F5F5DC; /* Darker beige for striped rows */
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table a {
        font-weight: bold;
        color: #007BFF; /* Light blue for links */
    }

    .table a:hover {
        text-decoration: underline;
        color: #025ec1; /* Darker blue on hover */
    }

    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(16, 26, 69, 0.1); /* Light blue background on hover */
    }

    .btn-info {
        border-color: #00CFFF; /* Light blue border */
    }

    .btn-info:hover {
        border-color: #007BFF; /* Darker blue border for button hover */
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>Liste semestres</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Semestre</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semestres as $semestre)
                                <tr>
                                    <td>{{ $semestre->nom }}</td>
                                    <td>
                                        <a href="{{ route('listeEtudiantAdminSemestre', ['id' => $id, 'semestre' => $semestre->id]) }}" class="btn btn-info btn-block">
                                            {{ $semestre->nom }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
