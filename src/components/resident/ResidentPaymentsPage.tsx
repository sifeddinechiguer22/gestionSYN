import React, { useState } from 'react';
import {
  CreditCard,
  Download,
  CheckCircle2,
  Calendar,
  ShieldCheck,
  ArrowUpRight,
  FileText,
  X
} from 'lucide-react';
import { CURRENT_RESIDENT_PROFILE, MOCK_PAYMENTS } from '../../data/mockData';

export const ResidentPaymentsPage: React.FC = () => {
  const [toast, setToast] = useState<string | null>(null);

  const myPayments = [
    {
      id: 'pay-2026-03',
      month: 'Mars 2026',
      amount: 800,
      date: '03 Mars 2026',
      method: 'Carte bancaire (CMI)',
      receiptNumber: 'REC-2026-03-018',
      status: 'Réglé',
    },
    {
      id: 'pay-2026-02',
      month: 'Février 2026',
      amount: 800,
      date: '02 Février 2026',
      method: 'Virement bancaire CIH',
      receiptNumber: 'REC-2026-02-019',
      status: 'Réglé',
    },
    {
      id: 'pay-2026-01',
      month: 'Janvier 2026',
      amount: 800,
      date: '05 Janvier 2026',
      method: 'Carte bancaire (CMI)',
      receiptNumber: 'REC-2026-01-011',
      status: 'Réglé',
    },
    {
      id: 'pay-2025-12',
      month: 'Décembre 2025',
      amount: 800,
      date: '04 Décembre 2025',
      method: 'Virement bancaire CIH',
      receiptNumber: 'REC-2025-12-045',
      status: 'Réglé',
    },
  ];

  const handleDownload = (receipt: string) => {
    setToast(`Téléchargement de la quittance officielle ${receipt}...`);
    setTimeout(() => setToast(null), 3000);
  };

  return (
    <div className="space-y-6 pb-12">
      {toast && (
        <div className="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <CheckCircle2 className="w-4 h-4 text-emerald-600" />
            <span>{toast}</span>
          </div>
          <button onClick={() => setToast(null)}>
            <X className="w-3.5 h-3.5" />
          </button>
        </div>
      )}

      {/* Header */}
      <div>
        <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
          Mes Cotisations & Quittances
        </h1>
        <p className="text-sm text-slate-500 mt-1">
          Historique des règlements de charges pour le lot {CURRENT_RESIDENT_PROFILE.apartment}.
        </p>
      </div>

      {/* Account status card */}
      <div className="bg-gradient-to-r from-emerald-900 to-slate-900 rounded-2xl p-6 text-white shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div className="space-y-2">
          <div className="flex items-center space-x-2">
            <ShieldCheck className="w-5 h-5 text-emerald-400" />
            <span className="text-xs font-semibold uppercase tracking-wider text-emerald-300">
              Statut du compte : En règle
            </span>
          </div>
          <h2 className="text-3xl font-extrabold tracking-tight">0 MAD d'arriéré</h2>
          <p className="text-xs text-slate-300">
            Votre cotisation mensuelle s'élève à <strong>{CURRENT_RESIDENT_PROFILE.monthlyDue} MAD</strong>. Le mois de Mars 2026 est entièrement acquitté.
          </p>
        </div>

        <div className="p-4 bg-slate-800/80 rounded-xl border border-emerald-500/30 text-xs space-y-1 md:w-72">
          <span className="text-slate-400 block">Prochaine cotisation exigible</span>
          <span className="text-lg font-bold text-white block">Avril 2026 (800 MAD)</span>
          <span className="text-emerald-400 block font-medium">Échéance : 10 Avril 2026</span>
        </div>
      </div>

      {/* Payment receipts table */}
      <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-5 border-b border-slate-100 flex items-center justify-between">
          <h3 className="text-base font-bold text-slate-900">Historique des Quittances de Copropriété</h3>
          <span className="text-xs text-slate-400 font-medium">Documents juridiquement valides</span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse text-xs">
            <thead>
              <tr className="bg-slate-50 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                <th className="py-3 px-4">Réf. Quittance</th>
                <th className="py-3 px-3">Période couverte</th>
                <th className="py-3 px-3">Date de règlement</th>
                <th className="py-3 px-3">Moyen utilisé</th>
                <th className="py-3 px-3">Montant acquitté</th>
                <th className="py-3 px-3">Statut</th>
                <th className="py-3 px-4 text-right">Télécharger</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 text-slate-700">
              {myPayments.map((p) => (
                <tr key={p.id} className="hover:bg-slate-50/70 transition-colors">
                  <td className="py-3.5 px-4 font-mono font-bold text-emerald-700">{p.receiptNumber}</td>
                  <td className="py-3.5 px-3 font-semibold text-slate-900">{p.month}</td>
                  <td className="py-3.5 px-3 text-slate-500">{p.date}</td>
                  <td className="py-3.5 px-3 text-slate-600">{p.method}</td>
                  <td className="py-3.5 px-3 font-extrabold text-slate-900">{p.amount} MAD</td>
                  <td className="py-3.5 px-3">
                    <span className="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                      <CheckCircle2 className="w-3 h-3 mr-1" />
                      {p.status}
                    </span>
                  </td>
                  <td className="py-3.5 px-4 text-right">
                    <button
                      onClick={() => handleDownload(p.receiptNumber)}
                      className="inline-flex items-center space-x-1 px-2.5 py-1 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 transition-colors shadow-xs"
                    >
                      <Download className="w-3.5 h-3.5 text-slate-500" />
                      <span>PDF</span>
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};
