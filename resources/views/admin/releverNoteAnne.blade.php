<style>
    .centered-text {
        text-align: center;
        font-size: 1.2em;
        color: #101A45; /* Dark blue theme for text */
        margin-bottom: 20px;
    }

    .table-responsive {
        margin-top: 20px;
    }

    .table {
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
        background-color: #101A45; /* Dark blue for table header */
        color: #fff; /* White text for contrast */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #F5F5DC; /* Darker beige for striped rows */
    }

    .table-hover tbody tr:hover {
        background-color: rgba(16, 26, 69, 0.1); /* Light blue background on hover */
    }

    .general-average {
        font-size: 1.2em;
        font-weight: bold;
        margin-top: 20px;
        color: #101A45; /* Default dark blue for general average */
    }

    .general-average.low {
        color: red; /* Red color for low average */
    }

    .semester-average {
        font-weight: bold;
        color: #007BFF; /* Highlight color for the average text */
        margin-bottom: 10px;
    }
</style>

<!-- Display Student Registration Number -->
<p class="centered-text">N° d'inscription: {{ $releveDeNotesAnne[0]->first()->num_etu }}</p>

@foreach ($releveDeNotesAnne as $releveDeNotes)
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>EU</th>
                    <th>Intitulé</th>
                    <th>Crédits</th>
                    <th>Note/20</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($releveDeNotes as $releveDeNote)
                    <tr>
                        <td>{{ $releveDeNote->code_matiere }}</td>
                        <td>{{ $releveDeNote->nom_matiere }}</td>
                        <td>{{ $releveDeNote->credit_obtenu }}</td>
                        <td>{{ $releveDeNote->note }}</td>
                        <td>{{ $releveDeNote->classification }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Display Semester Average -->
    <p class="semester-average">Moyenne: {{ round($releveDeNotes->first()->moyenne_etudiant, 2) }}</p>
@endforeach

@php
    // Convert array to collection
    $releveDeNotesCollection = collect($releveDeNotesAnne);

    // Calculate the average of each semester
    $totalMoyennes = $releveDeNotesCollection->map(function($releveDeNotes) {
        return collect($releveDeNotes)->avg('moyenne_etudiant');
    });

    // Calculate the overall average
    $average = round($totalMoyennes->sum() / $totalMoyennes->count(), 2);
@endphp

<!-- Display General Average -->
<p class="general-average @if($average < 10) low @endif">
    Moyenne générale : {{ $average }}
</p>
