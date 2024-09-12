@extends('layouts.app')

@section('title', 'Page_Acceuil')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
@endsection

@section('content')
<div class="container"> <!-- Added 'container' class for proper layout -->
    <div class="cadre"> <!-- Retained 'cadre' for a custom-styled container -->
        <h1 class="mb-4">Config List</h1> <!-- Added margin-bottom for spacing -->

        <!-- Display success message -->
        @if(session('success'))
            <div class="alert alert-success">
                <!-- Used Bootstrap 'alert' classes for styling success messages -->
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive"> <!-- Added 'table-responsive' for responsiveness -->
            <table class="table table-bordered"> <!-- Used Bootstrap table classes for styling -->
                <thead class="thead-light"> <!-- Added 'thead-light' for a light-themed header -->
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Configuration</th>
                        <th>Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($configs as $config)
                        <tr>
                            <td>{{ $config->id }}</td>
                            <td>{{ $config->code }}</td>
                            <td>{{ $config->config }}</td>
                            <td>
                                <form action="{{ route('modifierConfigPost', $config->id) }}" method="POST" class="form-inline">
                                    <!-- Used 'form-inline' for better alignment -->
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="valeur" value="{{ $config->valeur }}" class="form-control mr-2" required>
                                    <!-- Added 'form-control' and 'mr-2' for styling and spacing -->
                                    <button type="submit" class="btn btn-primary">Modify</button>
                                    <!-- Used Bootstrap 'btn btn-primary' for button styling -->
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
