import React, { useState } from 'react';
import {
  CreditCard,
  Plus,
  Download,
  Search,
  CheckCircle2,
  Clock,
  AlertCircle,
  FileSpreadsheet,
  Receipt,
  X,
  Check
} from 'lucide-react';
import { MOCK_PAYMENTS, MOCK_EXPENSES, RESIDENCE_INFO } from '../../data/mockData';
import { Payment } from '../../types';

export const PaymentsPage: React.FC = () => {
  const [paymentsList, setPaymentsList] = useState<Payment[]>(MOCK_PAYMENTS);
  const [activeTab, setActiveTab] = useState<'recettes' | 'depenses'>('recettes');
  const [searchTerm, setSearchTerm] = useState('');
  const [statusFilter, setStatusFilter] = useState('all');
  const [isAddPaymentModalOpen, setIsAddPaymentModalOpen] = useState(false);
  const [toastMessage, setToastMessage] = useState<string | null>(null);

  // New payment form
  const [resName, setResName] = useState('Karim Bennani');
  const [apt, setApt] = useState('A-101');
  const [amount, setAmount] = useState(1000);
  const [method, setMethod] = useState<'Virement' | 'Chèque' | 'Espèces' | 'En ligne'>('Virement');
  const [month, setMonth] = useState('Mars 2026');

  const filteredPayments = paymentsList.filter((p) => {
    const matchesSearch =
      p.residentName.toLowerCase().includes(searchTerm.toLowerCase()) ||
      p.apartment.toLowerCase().includes(searchTerm.toLowerCase()) ||
      p.receiptNumber.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesStatus = statusFilter === 'all' || p.status === statusFilter;
    return matchesSearch && matchesStatus;
  });

  const handleAddPayment = (e: React.FormEvent) => {
    e.preventDefault();
    const newPay: Payment = {
      id: `pay-${Date.now()}`,
      residentName: resName,
      apartment: apt,
      building: 'Bâtiment A',
      month,
      amount: Number(amount),
      date: new Date().toISOString().split('T')[0],
      method,
      status: 'Payé',
      receiptNumber: `REC-2026-${Math.floor(100 + Math.random() * 900)}`,
    };

    setPaymentsList([newPay, ...paymentsList]);
    setIsAddPaymentModalOpen(false);
    setToastMessage(`Paiement de ${amount} MAD pour ${resName} enregistré avec succès !`);
    setTimeout(() => setToastMessage(null), 3500);
  };

  return (
    <div className="space-y-6 pb-12">
      {/* Toast */}
      {toastMessage && (
        <div className="p-3.5 bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-lg border border-slate-700 flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <Check className="w-4 h-4 text-emerald-400" />
            <span>{toastMessage}</span>
          </div>
          <button onClick={() => setToastMessage(null)} className="text-slate-400 hover:text-white">
            <X className="w-3.5 h-3.5" />
          </button>
        </div>
      )}

      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
            Comptabilité & Trésorerie Syndic
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Suivi des encaissements de cotisations, reçus de copropriété et registre des dépenses.
          </p>
        </div>

        <div className="flex items-center space-x-2">
          <button
            onClick={() => {
              setToastMessage('Export du Grand Livre comptable en cours...');
              setTimeout(() => setToastMessage(null), 3000);
            }}
            className="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-xs transition-colors"
          >
            <Download className="w-4 h-4 mr-1.5 text-slate-500" />
            <span>Exporter Excel</span>
          </button>

          <button
            onClick={() => setIsAddPaymentModalOpen(true)}
            className="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs shadow-indigo-600/30 transition-all"
          >
            <Plus className="w-4 h-4 mr-1.5" />
            <span>Encaisser cotisation</span>
          </button>
        </div>
      </div>

      {/* Top 3 Metric Cards */}
      <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div className="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
          <div className="flex items-center justify-between text-xs text-slate-500">
            <span>Total Encaissé (Mars)</span>
            <span className="bg-emerald-50 text-emerald-700 text-[11px] font-bold px-2 py-0.5 rounded-full">
              79% collecté
            </span>
          </div>
          <div className="text-2xl font-bold text-slate-900 mt-2">
            {RESIDENCE_INFO.currentCollectedMonth.toLocaleString('fr-FR')} {RESIDENCE_INFO.currency}
          </div>
          <p className="text-xs text-slate-400 mt-1">Sur objectif de 48 000 MAD</p>
        </div>

        <div className="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
          <div className="flex items-center justify-between text-xs text-slate-500">
            <span>Reste à recouvrer</span>
            <span className="bg-rose-50 text-rose-700 text-[11px] font-bold px-2 py-0.5 rounded-full">
              10 appartements
            </span>
          </div>
          <div className="text-2xl font-bold text-rose-600 mt-2">
            9 600 {RESIDENCE_INFO.currency}
          </div>
          <p className="text-xs text-slate-400 mt-1">Échéance mensuelle passée</p>
        </div>

        <div className="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
          <div className="flex items-center justify-between text-xs text-slate-500">
            <span>Dépenses du mois</span>
            <span className="bg-amber-50 text-amber-700 text-[11px] font-bold px-2 py-0.5 rounded-full">
              5 factures
            </span>
          </div>
          <div className="text-2xl font-bold text-slate-900 mt-2">
            14 250 {RESIDENCE_INFO.currency}
          </div>
          <p className="text-xs text-slate-400 mt-1">Solde net du mois : +24 150 MAD</p>
        </div>
      </div>

      {/* Tabs: Recettes (Cotisations) vs Dépenses */}
      <div className="flex bg-slate-100 p-1 rounded-xl w-fit border border-slate-200 text-xs">
        <button
          onClick={() => setActiveTab('recettes')}
          className={`px-4 py-1.5 rounded-lg font-bold transition-all ${
            activeTab === 'recettes' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'
          }`}
        >
          Cotisations & Encaissements ({paymentsList.length})
        </button>
        <button
          onClick={() => setActiveTab('depenses')}
          className={`px-4 py-1.5 rounded-lg font-bold transition-all ${
            activeTab === 'depenses' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'
          }`}
        >
          Dépenses & Factures Immeuble ({MOCK_EXPENSES.length})
        </button>
      </div>

      {activeTab === 'recettes' ? (
        <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden space-y-4">
          {/* Table Search & Filter Header */}
          <div className="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div className="relative max-w-sm w-full">
              <Search className="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
              <input
                type="text"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                placeholder="Rechercher par résident, lot ou n° de reçu..."
                className="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20"
              />
            </div>

            <div className="flex items-center space-x-2">
              <select
                value={statusFilter}
                onChange={(e) => setStatusFilter(e.target.value)}
                className="px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-700 focus:outline-none"
              >
                <option value="all">Tous les états</option>
                <option value="Payé">Payé uniquement</option>
                <option value="En attente">En attente uniquement</option>
              </select>
            </div>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse text-xs">
              <thead>
                <tr className="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                  <th className="py-3 px-4">Réf. Quittance</th>
                  <th className="py-3 px-3">Copropriétaire</th>
                  <th className="py-3 px-3">Lot</th>
                  <th className="py-3 px-3">Mois couvert</th>
                  <th className="py-3 px-3">Montant</th>
                  <th className="py-3 px-3">Mode de paiement</th>
                  <th className="py-3 px-3">Date</th>
                  <th className="py-3 px-4 text-right">Statut</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 text-slate-700">
                {filteredPayments.map((p) => (
                  <tr key={p.id} className="hover:bg-slate-50/70 transition-colors">
                    <td className="py-3.5 px-4 font-mono font-semibold text-indigo-600">
                      {p.receiptNumber}
                    </td>
                    <td className="py-3.5 px-3 font-bold text-slate-900">{p.residentName}</td>
                    <td className="py-3.5 px-3">
                      <span className="px-2 py-0.5 rounded bg-slate-100 text-slate-800 font-medium">
                        {p.apartment}
                      </span>
                    </td>
                    <td className="py-3.5 px-3 text-slate-600">{p.month}</td>
                    <td className="py-3.5 px-3 font-extrabold text-slate-900">
                      {p.amount} {RESIDENCE_INFO.currency}
                    </td>
                    <td className="py-3.5 px-3 text-slate-500">{p.method}</td>
                    <td className="py-3.5 px-3 text-slate-400">{p.date}</td>
                    <td className="py-3.5 px-4 text-right">
                      <span
                        className={`inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold ${
                          p.status === 'Payé'
                            ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'
                            : 'bg-amber-50 text-amber-700 border border-amber-200/60'
                        }`}
                      >
                        {p.status === 'Payé' ? <CheckCircle2 className="w-3 h-3 mr-1" /> : <Clock className="w-3 h-3 mr-1" />}
                        {p.status}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      ) : (
        <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse text-xs">
              <thead>
                <tr className="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                  <th className="py-3 px-4">Poste de dépense</th>
                  <th className="py-3 px-3">Catégorie</th>
                  <th className="py-3 px-3">Fournisseur / Prestataire</th>
                  <th className="py-3 px-3">Date</th>
                  <th className="py-3 px-3">Montant</th>
                  <th className="py-3 px-4 text-right">État</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 text-slate-700">
                {MOCK_EXPENSES.map((exp) => (
                  <tr key={exp.id} className="hover:bg-slate-50/70 transition-colors">
                    <td className="py-3.5 px-4 font-bold text-slate-900">{exp.title}</td>
                    <td className="py-3.5 px-3">
                      <span className="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium">
                        {exp.category}
                      </span>
                    </td>
                    <td className="py-3.5 px-3 text-slate-600">{exp.vendor}</td>
                    <td className="py-3.5 px-3 text-slate-400">{exp.date}</td>
                    <td className="py-3.5 px-3 font-extrabold text-slate-900">
                      {exp.amount} {RESIDENCE_INFO.currency}
                    </td>
                    <td className="py-3.5 px-4 text-right">
                      <span
                        className={`inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold ${
                          exp.status === 'Payé'
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'bg-amber-50 text-amber-700'
                        }`}
                      >
                        {exp.status}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Modal: Encaisser Cotisation */}
      {isAddPaymentModalOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
          <div className="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-slate-200 animate-in fade-in zoom-in-95 duration-150">
            <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
              <h3 className="text-base font-bold text-slate-900">Encaisser une cotisation</h3>
              <button
                onClick={() => setIsAddPaymentModalOpen(false)}
                className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleAddPayment} className="p-6 space-y-4">
              <div>
                <label className="block text-xs font-medium text-slate-700 mb-1">Nom du copropriétaire</label>
                <input
                  type="text"
                  required
                  value={resName}
                  onChange={(e) => setResName(e.target.value)}
                  className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                />
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Lot / Appartement</label>
                  <input
                    type="text"
                    required
                    value={apt}
                    onChange={(e) => setApt(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                  />
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Mois couvert</label>
                  <select
                    value={month}
                    onChange={(e) => setMonth(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                  >
                    <option value="Mars 2026">Mars 2026</option>
                    <option value="Avril 2026">Avril 2026</option>
                    <option value="Février 2026">Février 2026</option>
                  </select>
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Montant (MAD)</label>
                  <input
                    type="number"
                    required
                    value={amount}
                    onChange={(e) => setAmount(Number(e.target.value))}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 font-bold"
                  />
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Mode de règlement</label>
                  <select
                    value={method}
                    onChange={(e) => setMethod(e.target.value as any)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                  >
                    <option value="Virement">Virement bancaire</option>
                    <option value="Chèque">Chèque</option>
                    <option value="Espèces">Espèces</option>
                    <option value="En ligne">Paiement en ligne</option>
                  </select>
                </div>
              </div>

              <div className="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button
                  type="button"
                  onClick={() => setIsAddPaymentModalOpen(false)}
                  className="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl"
                >
                  Annuler
                </button>
                <button
                  type="submit"
                  className="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs"
                >
                  Émettre la quittance
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
