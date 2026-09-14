<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport d'Activité Syndic</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #334155; line-height: 1.5; margin: 0; padding: 20px; }
        .header { border-bottom: 2px solid #0284c7; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #0f172a; margin: 0 0 5px 0; font-size: 22px; }
        .header p { margin: 0; color: #64748b; font-size: 11px; }
        .kpi-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .kpi-card { background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; text-align: center; }
        .kpi-title { font-size: 10px; font-weight: bold; text-transform: uppercase; color: #64748b; margin-bottom: 5px; }
        .kpi-value { font-size: 18px; font-weight: bold; color: #0f172a; }
        .section-title { font-size: 15px; font-weight: bold; color: #0f172a; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #e2e8f0; padding: 8px 10px; text-align: left; font-size: 11px; }
        table.data-table th { background-color: #f1f5f9; color: #334155; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SyndicManager — Rapport de Gestion</h1>
        <p>Généré le {{ date('d/m/Y à H:i') }} | Résidence : {{ $residence->name ?? 'Résidence Les Palmiers' }}</p>
    </div>

    <table class="kpi-table">
        <tr>
            <td style="width: 25%; padding-right: 5px;">
                <div class="kpi-card">
                    <div class="kpi-title">Encaissé ce mois</div>
                    <div class="kpi-value" style="color: #059669;">{{ number_format($totalCollectedThisMonth, 2, ',', ' ') }} DH</div>
                </div>
            </td>
            <td style="width: 25%; padding: 0 5px;">
                <div class="kpi-card">
                    <div class="kpi-title">Impayés Totaux</div>
                    <div class="kpi-value" style="color: #e11d48;">{{ number_format($totalUnpaid, 2, ',', ' ') }} DH</div>
                </div>
            </td>
            <td style="width: 25%; padding: 0 5px;">
                <div class="kpi-card">
                    <div class="kpi-title">Réclamations Actives</div>
                    <div class="kpi-value" style="color: #d97706;">{{ $activeComplaintsCount }}</div>
                </div>
            </td>
            <td style="width: 25%; padding-left: 5px;">
                <div class="kpi-card">
                    <div class="kpi-title">Appartements Occupés</div>
                    <div class="kpi-value">{{ $occupiedApartmentsCount }} / {{ $totalApartmentsCount }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Derniers Règlements Enregistrés</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>N° Reçu</th>
                <th>Résident / Logement</th>
                <th>Mois</th>
                <th>Montant</th>
                <th>Mode</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentPayments as $payment)
                <tr>
                    <td>{{ $payment->receipt_number }}</td>
                    <td>{{ optional($payment->payer)->name ?? 'N/A' }} (Appt {{ optional($payment->apartment)->number ?? 'N/A' }})</td>
                    <td>{{ $payment->month }}</td>
                    <td><strong>{{ number_format($payment->amount, 2, ',', ' ') }} DH</strong></td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8;">Aucun paiement enregistré.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Réclamations & Signalements en cours</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>N° Ticket</th>
                <th>Sujet / Titre</th>
                <th>Résident</th>
                <th>Priorité</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentComplaints as $complaint)
                <tr>
                    <td>#{{ $complaint->ticket_number }}</td>
                    <td>{{ $complaint->title }}</td>
                    <td>{{ optional($complaint->resident)->name ?? 'Copropriétaire' }}</td>
                    <td>{{ ucfirst($complaint->priority) }}</td>
                    <td>{{ ucfirst($complaint->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8;">Aucune réclamation en cours.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Document officiel généré automatiquement par SyndicManager — Système de Gestion de Copropriété.
    </div>
</body>
</html>
