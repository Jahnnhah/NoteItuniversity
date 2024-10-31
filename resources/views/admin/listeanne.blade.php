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

</style>
<h1>Liste des annee</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Annee</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($anne as $a)
                <tr>

                    <td>
                        <a href="{{ route('releveDeNoteAnne', ['id' => $id, 'anne' => $a['anne']]) }}" class="btn btn-info btn-block">
                            L{{ $a['anne'] }}
                        </a>
                    </td>



                </tr>
            @endforeach

        </tbody>
    </table>
</div>
