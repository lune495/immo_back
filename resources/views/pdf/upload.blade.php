<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader un Contrat</title>
    
    <!-- Importer le fichier CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <form action="{{ url('/api/upload_contract') }}" method="post" enctype="multipart/form-data" class="form-container">
        @csrf
        <input type="hidden" name="locataire_id" value="{{ request('locataire_id') }}">
        <input type="hidden" name="url_qr_code" value="">

        <div class="form-group">
            <label for="file">Sélectionnez un fichier (JPG, PNG, PDF)</label>
            <input type="file" name="file" id="file" accept=".jpg,.png,.pdf" required>
        </div>

        <button type="submit">Uploader le Contrat</button>
    </form>
    
</body>
</html>
