<style>
    /* public/css/custom.css */

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

    /* .table-striped tbody tr:nth-of-type(odd) {
        background-color: #F5F5DC; /* Darker beige for striped rows */
    } */

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table a {
        font-weight: bold;
        color: #007BFF; /* Light blue for links */
    }

    .table a:hover {
        text-decoration: underline;
        color: #0260c6; /* Darker blue on hover */
    }

    /* Additional styles for better appearance */
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

    .rattrapage {
        font-size: 1.2em;
        font-weight: bold;
        margin-top: 20px;
        color: #101A45; /* Default dark blue for general average */
        color: red;
    }

    .rattrapage.low {
        color: rgb(0, 220, 26); /* Red color for low average */
    }
</style>
<h1>Relevé de notes</h1>
<center> OPTION DEVELOPPEMENT </center>
<center> <p>N° d'inscription: {{ $releveDeNotes->first()->num_etu }} </p> </center>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
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
                @php
                    $rowColor = '';
                    foreach ($parametres as $parametre) {
                        if ($releveDeNote->note >= $parametre->borneinf && $releveDeNote->note <= $parametre->bornesup) {
                            $rowColor = $parametre->couleur;
                            break;
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $releveDeNote->code_matiere }}</td>
                    <td>{{ $releveDeNote->nom_matiere }}</td>
                    <td>{{ $releveDeNote->credit_obtenu }}</td>
                    <td style="color: {{ $rowColor }};">{{ $releveDeNote->note }}</td>
                    <td>{{ $releveDeNote->classification }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<p>Moyenne: {{ round($releveDeNotes->first()->moyenne_etudiant, 2) }}</p>
<p>Total crédit obtenu: {{ $releveDeNotes->first()->somme_credit }}</p>

@if ($releveDeNotes->first()->montant_rattrapage > 0)

    <p class="rattrapage @if($releveDeNotes->first()->montant_rattrapage >= 50000) low @endif" >Montant à payer pour le rattrapage: {{ $releveDeNotes->first()->montant_rattrapage }} Ar</p>
@else
    <p style="color: red">Pas de rattrapage nécessaire.</p>
@endif

{{-- <p class="general-average @if($average < 10) low @endif"> --}}
