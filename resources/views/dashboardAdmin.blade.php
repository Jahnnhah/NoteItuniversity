@extends('layouts.app')

@section('title', 'Page_Acceuil')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
@endsection

@section('content')
<div class="container">
  <!-- Adjusted to use 'container' for consistent padding and centering -->
  <div class="cadre">
    <!-- Adjusted the 'cadre' for a more cohesive container style -->
    <div class="card">
      <!-- Using 'card' to follow Bootstrap or custom styles for card components -->
      <div class="card-body">
        <h3 class="card-title">Bienvenue sur le dashboard admin</h3>
        <h4 class="card-subtitle mb-2 text-muted">Nombre total d'étudiants: {{$nb_etudiant}}</h4>
        <!-- Corrected <h3> to <h4> for consistent heading hierarchy -->
        <h4 class="card-subtitle mb-2 text-success">Nombre admis: {{$admis['nb_admis']}}</h4>
        <!-- Changed 'text-succes' to 'text-success' to fix typo -->
        <h4 class="card-subtitle mb-2 text-danger">Nombre ajourné: {{$admis['nb_non_admis']}}</h4>
        <!-- Maintained 'text-danger' for consistency in error or negative status display -->
      </div>
    </div>
  </div>
</div>
@endsection
