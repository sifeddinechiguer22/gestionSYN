<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu de Paiement - {{ $payment->receipt_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 30px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
        }
        .subtitle {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .receipt-title {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-box {
            width: 48%;
            vertical-align: top;
        }
        .box-title {
            font-size: 11px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #cbd5e1;
        }
        .details-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .total-box {
            background-color: #f0f5ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 15px;
            text-align: right;
            margin-bottom: 30px;
        }
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .stamp-box {
            margin-top: 20px;
            float: right;
            width: 200px;
            height: 80px;
            border: 2px dashed #94a3b8;
            text-align: center;
            padding-top: 10px;
            color: #64748b;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td>
                <div class="logo">SyndicManager</div>
                <div class="subtitle">Résidence Les Palmiers — Casablanca</div>
            </td>
            <td class="receipt-title">
                REÇU DE PAIEMENT<br>
                <span style="font-size: 12px; color: #64748b; font-weight: normal;">N° {{ $payment->receipt_number }}</span>
            </td>
        </tr>
    </table>

    <table class="info-grid">
        <tr>
            <td class="info-box">
                <div class="box-title">Émis par :</div>
                <strong>Syndic de Copropriété</strong><br>
                Résidence Les Palmiers<br>
                142 Bd Ghandi, Casablanca<br>
                Tél : +212 6 61 23 45 67<br>
                Email : syndic@palmiers.ma
            </td>
            <td style="width: 4%;"></td>
            <td class="info-box">
                <div class="box-title">Délivré à :</div>
                <strong>{{ optional($payment->payer)->name ?? 'Copropriétaire' }}</strong><br>
                {{ optional(optional($payment->apartment)->building)->name }} — Appartement N° {{ optional($payment->apartment)->number }}<br>
                Email : {{ optional($payment->payer)->email ?? 'N/A' }}<br>
                Tél : {{ optional($payment->payer)->phone ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Désignation / Motif</th>
                <th>Période</th>
                <th>Mode de Règlement</th>
                <th>Référence</th>
                <th style="text-align: right;">Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Cotisation Mensuelle de Syndic</strong></td>
                <td>{{ $payment->month }}</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ $payment->reference ?? 'N/A' }}</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($payment->amount, 2, ',', ' ') }} DH</td>
            </tr>
        </tbody>
    </table>

    <div class="total-box">
        <span style="font-size: 12px; color: #475569;">Montant Total Acquitté :</span><br>
        <span class="total-amount">{{ number_format($payment->amount, 2, ',', ' ') }} DH</span>
    </div>

    <div style="width: 100%; overflow: hidden;">
        <div class="stamp-box">
            Cachet & Signature du Syndic<br>
            <span style="font-size: 9px; color: #cbd5e1;">(Document officiel d'acquittement)</span>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        Reçu généré automatiquement par SyndicManager le {{ date('d/m/Y à H:i') }} — Document faisant foi de paiement.
    </div>
</body>
</html>
