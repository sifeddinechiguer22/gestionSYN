import React, { useState } from 'react';
import {
  Home,
  CheckCircle2,
  Clock,
  AlertCircle,
  FileText,
  Download,
  CreditCard,
  Plus,
  ArrowUpRight,
  ShieldAlert,
  Car,
  Box,
  Layers,
  Sparkles
} from 'lucide-react';
import {
  CURRENT_RESIDENT_PROFILE,
  MOCK_PAYMENTS,
  MOCK_COMPLAINTS,
  MOCK_ANNOUNCEMENTS,
  RESIDENCE_INFO
} from '../../data/mockData';

interface ResidentDashboardProps {
  onNavigate: (tabId: string) => void;
  onOpenNewComplaint: () => void;
}

export const ResidentDashboard: React.FC<ResidentDashboardProps> = ({
  onNavigate,
  onOpenNewComplaint,
}) => {
  const [downloadSuccess, setDownloadSuccess] = useState<string | null>(null);

  // Resident specific data
  const myPayments = MOCK_PAYMENTS.filter(
    (p) => p.residentName === 'Fatima-Zahra El Mansouri' || p.apartment === 'B-204'
  );
  const myComplaints = MOCK_COMPLAINTS.filter(
    (c) => c.apartment === 'B-204'
  );

  const handleDownloadReceipt = (receiptNumber: string) => {
    setDownloadSuccess(`Téléchargement de la quittance ${receiptNumber}...`);
    setTimeout(() => {
      setDownloadSuccess(null);
    }, 3000);
  };

  return (
    <div className="space-y-6 pb-12">
      {/* Welcome Banner with Fast Actions */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <div className="flex items-center space-x-2">
            <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
              Bonjour, {CURRENT_RESIDENT_PROFILE.name.split(' ')[0]} 👋
            </h1>
            <span className="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-emerald-200">
              Copropriétaire
            </span>
          </div>
          <p className="text-sm text-slate-500 mt-1">
            Bienvenue sur votre espace résident — {RESIDENCE_INFO.name}.
          </p>
        </div>

        <div className="flex items-center space-x-2">
          <button
            onClick={() => onNavigate('documents')}
            className="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-xs transition-colors"
          >
            <FileText className="w-4 h-4 mr-1.5 text-slate-500" />
            <span>Règlement copropriété</span>
          </button>

          <button
            id="resident-new-complaint-btn"
            onClick={onOpenNewComplaint}
            className="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs shadow-emerald-600/30 transition-all"
          >
            <Plus className="w-4 h-4 mr-1.5" />
            <span>Signaler un incident</span>
          </button>
        </div>
      </div>

      {downloadSuccess && (
        <div className="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-center space-x-2 animate-in fade-in duration-200">
          <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0" />
          <span>{downloadSuccess} Fichier PDF généré avec succès.</span>
        </div>
      )}

      {/* Top 2 Cards: Carte "Mon Appartement" & "Statut du Paiement du Mois" */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {/* Carte Mon Appartement (7 cols) */}
        <div className="lg:col-span-7 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 relative overflow-hidden">
          <div className="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
            <div className="flex items-center space-x-3">
              <div className="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center">
                <Home className="w-5 h-5" />
              </div>
              <div>
                <h2 className="text-base font-bold text-slate-900">Mon Logement & Annexes</h2>
                <p className="text-xs text-slate-500">
                  {CURRENT_RESIDENT_PROFILE.building} • Étage {CURRENT_RESIDENT_PROFILE.floor}
                </p>
              </div>
            </div>
            <span className="text-sm font-extrabold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200/60">
              Apt. {CURRENT_RESIDENT_PROFILE.apartment}
            </span>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 py-1">
            <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
              <span className="text-[11px] font-medium text-slate-400 block mb-0.5">Typologie</span>
              <span className="text-sm font-bold text-slate-800">{CURRENT_RESIDENT_PROFILE.rooms}</span>
            </div>
            <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
              <span className="text-[11px] font-medium text-slate-400 block mb-0.5">Superficie</span>
              <span className="text-sm font-bold text-slate-800">{CURRENT_RESIDENT_PROFILE.surface}</span>
            </div>
            <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
              <span className="text-[11px] font-medium text-slate-400 block mb-0.5">Tantièmes</span>
              <span className="text-sm font-bold text-slate-800">{CURRENT_RESIDENT_PROFILE.tantiemes}</span>
            </div>
            <div className="p-3 bg-slate-50 rounded-xl border border-slate-100">
              <span className="text-[11px] font-medium text-slate-400 block mb-0.5">Cotisation mensuelle</span>
              <span className="text-sm font-bold text-indigo-600">{CURRENT_RESIDENT_PROFILE.monthlyDue} MAD</span>
            </div>
          </div>

          {/* Annexes / Dépendances */}
          <div className="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3 text-xs">
            <div className="flex items-center space-x-1.5 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg">
              <Car className="w-3.5 h-3.5 text-slate-500" />
              <span>Parking : <strong className="text-slate-900">{CURRENT_RESIDENT_PROFILE.parkingSpot}</strong></span>
            </div>
            <div className="flex items-center space-x-1.5 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg">
              <Box className="w-3.5 h-3.5 text-slate-500" />
              <span>Dépendance : <strong className="text-slate-900">{CURRENT_RESIDENT_PROFILE.cellarSpot}</strong></span>
            </div>
            <button
              onClick={() => onNavigate('appartement')}
              className="ml-auto text-xs font-semibold text-emerald-600 hover:text-emerald-800"
            >
              Fiche complète du lot →
            </button>
          </div>
        </div>

        {/* Statut du Paiement du Mois (5 cols) */}
        <div className="lg:col-span-5 bg-gradient-to-br from-emerald-900 to-slate-900 rounded-2xl p-6 text-white shadow-md flex flex-col justify-between relative overflow-hidden">
          <div className="absolute right-0 top-0 w-32 h-32 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />

          <div>
            <div className="flex items-center justify-between">
              <span className="text-[11px] font-semibold tracking-wider uppercase text-emerald-300 bg-emerald-500/20 border border-emerald-400/30 px-2.5 py-0.5 rounded-md">
                Charges & Cotisations
              </span>
              <span className="inline-flex items-center space-x-1 text-xs font-bold text-emerald-300">
                <CheckCircle2 className="w-4 h-4" />
                <span>À jour</span>
              </span>
            </div>

            <div className="mt-4">
              <p className="text-xs text-slate-300">Cotisation du mois en cours (Mars 2026)</p>
              <div className="flex items-baseline space-x-2 mt-1">
                <span className="text-3xl font-extrabold tracking-tight text-white">800 MAD</span>
                <span className="text-xs text-emerald-400 font-semibold">Réglée par carte bancaire</span>
              </div>
            </div>

            <div className="mt-4 p-3 rounded-xl bg-slate-800/80 border border-emerald-500/20 text-xs space-y-1">
              <div className="flex justify-between text-slate-300">
                <span>Réf. quittance :</span>
                <span className="font-mono text-white">REC-2026-03-018</span>
              </div>
              <div className="flex justify-between text-slate-300">
                <span>Prochaine échéance :</span>
                <span className="text-emerald-300 font-semibold">{CURRENT_RESIDENT_PROFILE.nextDueDate}</span>
              </div>
            </div>
          </div>

          <div className="mt-5 pt-4 border-t border-slate-800/80 flex items-center justify-between">
            <button
              onClick={() => handleDownloadReceipt('REC-2026-03-018')}
              className="inline-flex items-center space-x-1.5 text-xs font-bold bg-white hover:bg-slate-100 text-slate-900 px-3.5 py-2 rounded-xl transition-colors shadow-xs"
            >
              <Download className="w-3.5 h-3.5" />
              <span>Télécharger Quittance</span>
            </button>
            <button
              onClick={() => onNavigate('paiements')}
              className="text-xs font-semibold text-emerald-400 hover:text-emerald-300"
            >
              Historique des reçus →
            </button>
          </div>
        </div>
      </div>

      {/* Grid: Derniers Paiements & Réclamations en cours */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {/* Derniers Paiements (6 cols) */}
        <div className="lg:col-span-6 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5">
          <div className="flex items-center justify-between mb-4">
            <div className="flex items-center space-x-2">
              <CreditCard className="w-4 h-4 text-emerald-600" />
              <h2 className="text-base font-bold text-slate-900">Mes Derniers Paiements</h2>
            </div>
            <button
              onClick={() => onNavigate('paiements')}
              className="text-xs font-semibold text-emerald-600 hover:text-emerald-800"
            >
              Tous mes paiements →
            </button>
          </div>

          <div className="space-y-3">
            {myPayments.length > 0 ? (
              myPayments.map((p) => (
                <div
                  key={p.id}
                  className="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-slate-50 transition-colors"
                >
                  <div className="flex items-center space-x-3">
                    <div className="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                      <CheckCircle2 className="w-4 h-4" />
                    </div>
                    <div>
                      <h4 className="text-xs font-bold text-slate-900">Cotisation {p.month}</h4>
                      <p className="text-[11px] text-slate-400">{p.date} • {p.method}</p>
                    </div>
                  </div>

                  <div className="text-right flex items-center space-x-3">
                    <div>
                      <span className="text-xs font-bold text-slate-900 block">{p.amount} MAD</span>
                      <span className="text-[10px] text-emerald-600 font-medium">Validé</span>
                    </div>
                    <button
                      onClick={() => handleDownloadReceipt(p.receiptNumber)}
                      title="Télécharger reçu"
                      className="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-emerald-600 hover:border-emerald-300 transition-colors"
                    >
                      <Download className="w-3.5 h-3.5" />
                    </button>
                  </div>
                </div>
              ))
            ) : (
              <p className="text-xs text-slate-500 py-4 text-center">Aucun historique disponible.</p>
            )}

            <div className="p-3.5 rounded-xl border border-slate-100 bg-slate-50/60 flex items-center justify-between">
              <div className="flex items-center space-x-3">
                <div className="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                  <CheckCircle2 className="w-4 h-4" />
                </div>
                <div>
                  <h4 className="text-xs font-bold text-slate-900">Cotisation Février 2026</h4>
                  <p className="text-[11px] text-slate-400">02 Fév. 2026 • Virement CIH</p>
                </div>
              </div>
              <div className="text-right flex items-center space-x-3">
                <div>
                  <span className="text-xs font-bold text-slate-900 block">800 MAD</span>
                  <span className="text-[10px] text-emerald-600 font-medium">Validé</span>
                </div>
                <button
                  onClick={() => handleDownloadReceipt('REC-2026-02-019')}
                  title="Télécharger reçu"
                  className="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-emerald-600 hover:border-emerald-300 transition-colors"
                >
                  <Download className="w-3.5 h-3.5" />
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Réclamations en cours (6 cols) */}
        <div className="lg:col-span-6 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5 flex flex-col justify-between">
          <div>
            <div className="flex items-center justify-between mb-4">
              <div className="flex items-center space-x-2">
                <AlertCircle className="w-4 h-4 text-amber-500" />
                <h2 className="text-base font-bold text-slate-900">Mes Réclamations en cours</h2>
              </div>
              <button
                onClick={onOpenNewComplaint}
                className="text-xs font-semibold text-emerald-600 hover:text-emerald-800"
              >
                + Nouveau ticket
              </button>
            </div>

            <div className="space-y-3">
              {myComplaints.map((comp) => (
                <div key={comp.id} className="p-4 rounded-xl border border-amber-200/80 bg-amber-50/40">
                  <div className="flex items-center justify-between mb-2">
                    <span className="text-[10px] font-bold uppercase tracking-wider bg-rose-600 text-white px-2 py-0.5 rounded">
                      {comp.priority}
                    </span>
                    <span className="text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2.5 py-0.5 rounded-full flex items-center space-x-1">
                      <Clock className="w-3 h-3" />
                      <span>{comp.status}</span>
                    </span>
                  </div>

                  <h4 className="text-xs font-bold text-slate-900">{comp.title}</h4>
                  <p className="text-xs text-slate-600 mt-1 line-clamp-2">{comp.description}</p>

                  {/* Progress tracker timeline */}
                  <div className="mt-3 pt-3 border-t border-amber-200/60 flex items-center justify-between text-[11px]">
                    <span className="text-slate-500">Prise en charge par le technicien Schindler</span>
                    <span className="text-slate-400">{comp.date}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
            <span className="text-xs text-slate-500">Un problème dans les parties communes ?</span>
            <button
              onClick={onOpenNewComplaint}
              className="text-xs font-bold text-emerald-600 hover:text-emerald-800"
            >
              Créer une réclamation →
            </button>
          </div>
        </div>
      </div>

      {/* Annonces récentes & Notifications Résidence */}
      <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5">
        <div className="flex items-center justify-between mb-4">
          <div className="flex items-center space-x-2">
            <Sparkles className="w-4 h-4 text-indigo-600" />
            <h2 className="text-base font-bold text-slate-900">Annonces récentes de la résidence</h2>
          </div>
          <button
            onClick={() => onNavigate('annonces')}
            className="text-xs font-semibold text-emerald-600 hover:text-emerald-800"
          >
            Toutes les annonces →
          </button>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          {MOCK_ANNOUNCEMENTS.slice(0, 2).map((ann) => (
            <div
              key={ann.id}
              className="p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-slate-50 transition-colors"
            >
              <div className="flex items-center justify-between mb-2">
                <span className="text-[10px] font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded-md">
                  {ann.category}
                </span>
                <span className="text-[11px] text-slate-400">{ann.date}</span>
              </div>
              <h4 className="text-xs font-bold text-slate-900 mb-1">{ann.title}</h4>
              <p className="text-xs text-slate-600 line-clamp-2">{ann.content}</p>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};
