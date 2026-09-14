<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Réclamation #{{ $complaint->ticket_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #0f172a;
            line-height: 1.6;
            margin: 0;
            padding: 35px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .subtitle {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 3px;
        }
        .doc-title {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #0369a1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .ticket-ref {
            font-size: 12px;
            color: #475569;
            font-weight: normal;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .info-card {
            width: 48%;
            vertical-align: top;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }
        .card-header {
            font-size: 11px;
            font-weight: bold;
            color: #0369a1;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-row {
            margin-bottom: 6px;
            font-size: 12px;
        }
        .label {
            color: #64748b;
            font-weight: 500;
        }
        .val {
            color: #0f172a;
            font-weight: bold;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }
        .description-box {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 18px;
            font-size: 13px;
            color: #1e293b;
            min-height: 120px;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-bottom: 25px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .meta-table .bg-gray {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="logo">SyndicManager</div>
                <div class="subtitle">{{ optional(optional(optional($complaint->apartment)->building)->residence)->name ?? 'Résidence' }}</div>
            </td>
            <td class="doc-title" style="vertical-align: middle;">
                RÉCLAMATION – SIGNALER UN PROBLÈME<br>
                <span class="ticket-ref">Réf: #{{ $complaint->ticket_number }}</span>
            </td>
        </tr>
    </table>

    <!-- Info Grid (Habitant & Localisation) -->
    <table class="info-grid">
        <tr>
            <td class="info-card">
                <div class="card-header">Informations de l'Habitant</div>
                <div class="info-row"><span class="label">Nom & Prénom :</span> <span class="val">{{ optional($complaint->resident)->name ?? 'Copropriétaire' }}</span></div>
                <div class="info-row"><span class="label">Email :</span> <span class="val">{{ optional($complaint->resident)->email ?? 'N/A' }}</span></div>
                <div class="info-row"><span class="label">Téléphone :</span> <span class="val">{{ optional($complaint->resident)->phone ?? 'N/A' }}</span></div>
            </td>
            <td style="width: 4%;"></td>
            <td class="info-card">
                <div class="card-header">Localisation & Logement</div>
                <div class="info-row"><span class="label">Résidence :</span> <span class="val">{{ optional(optional(optional($complaint->apartment)->building)->residence)->name ?? 'Résidence Les Palmiers' }}</span></div>
                <div class="info-row"><span class="label">Immeuble :</span> <span class="val">{{ optional(optional($complaint->apartment)->building)->name ?? 'Bâtiment A' }}</span></div>
                <div class="info-row"><span class="label">Appartement :</span> <span class="val">N° {{ optional($complaint->apartment)->number ?? '-' }}</span></div>
                <div class="info-row"><span class="label">Étage :</span> <span class="val">{{ optional($complaint->apartment)->floor ?? '0' }}ème Étage</span></div>
            </td>
        </tr>
    </table>

    <!-- Ticket Summary Metadata -->
    <div class="section-title">Détails du dépôt</div>
    <table class="meta-table">
        <tr>
            <td class="bg-gray">Référence du ticket</td>
            <td><strong>#{{ $complaint->ticket_number }}</strong></td>
        </tr>
        <tr>
            <td class="bg-gray">Date et heure du dépôt</td>
            <td>{{ $complaint->created_at->format('d/m/Y à H:i:s') }}</td>
        </tr>
        <tr>
            <td class="bg-gray">Statut actuel</td>
            <td><span class="status-badge">{{ $complaint->status_label }}</span></td>
        </tr>
        @if($complaint->title)
        <tr>
            <td class="bg-gray">Objet / Titre</td>
            <td><strong>{{ $complaint->title }}</strong></td>
        </tr>
        @endif
    </table>

    <!-- Description Box -->
    <div class="section-title">Description complète du problème</div>
    <div class="description-box">
        {{ $complaint->description }}
    </div>

    <!-- Footer -->
    <div class="footer">
        Document officiel généré automatiquement par SyndicManager le {{ date('d/m/Y à H:i') }}.<br>
        Ce récépissé fait foi du dépôt de la réclamation auprès du Syndic de copropriété.
    </div>
</body>
</html>
