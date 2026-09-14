import React from 'react';
import {
  Users,
  Building,
  CreditCard,
  TrendingUp,
  AlertTriangle,
  Receipt,
  AlertCircle,
  Megaphone,
  ArrowUpRight,
  ArrowDownRight,
  CheckCircle2,
  Clock,
  Plus,
  FileSpreadsheet,
  ChevronRight
} from 'lucide-react';
import {
  RESIDENCE_INFO,
  MOCK_PAYMENTS,
  MOCK_COMPLAINTS,
  MOCK_ANNOUNCEMENTS,
  MOCK_EXPENSES
} from '../../data/mockData';

interface SyndicDashboardProps {
  onNavigate: (tabId: string) => void;
  onOpenAddPayment?: () => void;
}

export const SyndicDashboard: React.FC<SyndicDashboardProps> = ({
  onNavigate,
  onOpenAddPayment,
}) => {
  const collectionRate = Math.round(
    (RESIDENCE_INFO.currentCollectedMonth / RESIDENCE_INFO.monthlyCollectionTarget) * 100
  );
  const totalUnpaid = RESIDENCE_INFO.monthlyCollectionTarget - RESIDENCE_INFO.currentCollectedMonth;
  const totalExpensesMonth = MOCK_EXPENSES.reduce((acc, curr) => acc + curr.amount, 0);

  const statsCards = [
    {
      id: 'stat-residents',
      title: 'Résidents inscrits',
      value: '84',
      subtext: '48 copropriétaires, 36 locataires',
      badge: '96% occupés',
      badgeType: 'positive',
      icon: Users,
      iconColor: 'text-indigo-600 bg-indigo-50 border-indigo-100',
      action: () => onNavigate('residents'),
    },
    {
      id: 'stat-appartements',
      title: 'Appartements & Lots',
      value: '48',
      subtext: 'Répartis sur 3 bâtiments (A, B, C)',
      badge: '3 bâtiments',
      badgeType: 'neutral',
      icon: Building,
      iconColor: 'text-sky-600 bg-sky-50 border-sky-100',
      action: () => onNavigate('batiments'),
    },
    {
      id: 'stat-paiements-mois',
      title: 'Paiements de Mars',
      value: `${collectionRate}%`,
      subtext: '38 cotisations reçues sur 48',
      badge: '10 restants',
      badgeType: 'warning',
      icon: CreditCard,
      iconColor: 'text-emerald-600 bg-emerald-50 border-emerald-100',
      action: () => onNavigate('paiements'),
    },
    {
      id: 'stat-encaisse',
      title: 'Total Encaissé (Mois)',
      value: `${RESIDENCE_INFO.currentCollectedMonth.toLocaleString('fr-FR')} ${RESIDENCE_INFO.currency}`,
      subtext: `Objectif : ${RESIDENCE_INFO.monthlyCollectionTarget.toLocaleString('fr-FR')} ${RESIDENCE_INFO.currency}`,
      badge: '+12% vs M-1',
      badgeType: 'positive',
      icon: TrendingUp,
      iconColor: 'text-teal-600 bg-teal-50 border-teal-100',
      action: () => onNavigate('paiements'),
    },
    {
      id: 'stat-impayes',
      title: 'Total Impayés (Mois)',
      value: `${totalUnpaid.toLocaleString('fr-FR')} ${RESIDENCE_INFO.currency}`,
      subtext: 'Relances automatiques prêtes',
      badge: '10 lots en retard',
      badgeType: 'danger',
      icon: AlertTriangle,
      iconColor: 'text-rose-600 bg-rose-50 border-rose-100',
      action: () => onNavigate('paiements'),
    },
    {
      id: 'stat-depenses',
      title: 'Dépenses Engagées',
      value: `${totalExpensesMonth.toLocaleString('fr-FR')} ${RESIDENCE_INFO.currency}`,
      subtext: '5 factures réglées ce mois',
      badge: 'Sous budget',
      badgeType: 'positive',
      icon: Receipt,
      iconColor: 'text-amber-600 bg-amber-50 border-amber-100',
      action: () => onNavigate('depenses'),
    },
    {
      id: 'stat-reclamations',
      title: 'Réclamations Actives',
      value: '4',
      subtext: '1 urgente (Ascenseur Bât B)',
      badge: '1 urgente',
      badgeType: 'danger',
      icon: AlertCircle,
      iconColor: 'text-purple-600 bg-purple-50 border-purple-100',
      action: () => onNavigate('reclamations'),
    },
  ];

  return (
    <div className="space-y-6 pb-12">
      {/* Page Title & Quick Actions */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
            Tableau de Bord Syndic
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Supervision générale de la copropriété {RESIDENCE_INFO.name} — Exercice Mars 2026.
          </p>
        </div>

        <div className="flex items-center space-x-2">
          <button
            onClick={() => onNavigate('paiements')}
            className="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-xs transition-colors"
          >
            <FileSpreadsheet className="w-4 h-4 mr-1.5 text-slate-500" />
            <span>Grand Livre</span>
          </button>

          <button
            onClick={() => onNavigate('annonces')}
            className="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-xs transition-colors"
          >
            <Megaphone className="w-4 h-4 mr-1.5 text-amber-500" />
            <span>Diffuser annonce</span>
          </button>

          <button
            onClick={() => onNavigate('paiements')}
            className="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs shadow-indigo-600/30 transition-all"
          >
            <Plus className="w-4 h-4 mr-1.5" />
            <span>Encaisser cotisation</span>
          </button>
        </div>
      </div>

      {/* Financial Health Summary Banner */}
      <div className="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-5 sm:p-6 text-white shadow-md relative overflow-hidden">
        <div className="absolute right-0 top-0 bottom-0 w-1/3 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-500/20 via-transparent to-transparent pointer-events-none" />

        <div className="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
          <div className="space-y-2 max-w-xl">
            <span className="text-[11px] font-semibold tracking-wider uppercase text-indigo-300 bg-indigo-500/20 border border-indigo-400/20 px-2.5 py-0.5 rounded-md">
              Situation de Trésorerie
            </span>
            <div className="flex items-baseline space-x-3">
              <span className="text-3xl font-extrabold tracking-tight">
                {RESIDENCE_INFO.bankBalance.toLocaleString('fr-FR')} {RESIDENCE_INFO.currency}
              </span>
              <span className="text-emerald-400 text-xs font-medium flex items-center">
                <ArrowUpRight className="w-3.5 h-3.5 mr-0.5" />
                Solde bancaire certifié (CIH Bank)
              </span>
            </div>
            <p className="text-xs text-slate-300">
              Cotisations collectées ce mois : <strong className="text-white">{RESIDENCE_INFO.currentCollectedMonth.toLocaleString('fr-FR')} {RESIDENCE_INFO.currency}</strong> sur un prévisionnel de {RESIDENCE_INFO.monthlyCollectionTarget.toLocaleString('fr-FR')} {RESIDENCE_INFO.currency}.
            </p>
          </div>

          {/* Progress bar */}
          <div className="w-full lg:w-80 bg-slate-800/80 p-4 rounded-xl border border-slate-700/60 backdrop-blur-xs">
            <div className="flex justify-between items-center text-xs mb-2">
              <span className="text-slate-300 font-medium">Recouvrement Mars</span>
              <span className="font-bold text-emerald-400">{collectionRate}%</span>
            </div>
            <div className="w-full bg-slate-700 h-2.5 rounded-full overflow-hidden">
              <div
                className="bg-gradient-to-r from-teal-400 to-emerald-400 h-full rounded-full transition-all duration-500"
                style={{ width: `${collectionRate}%` }}
              />
            </div>
            <div className="flex justify-between text-[11px] text-slate-400 mt-2">
              <span>38 payés</span>
              <span>10 en attente</span>
            </div>
          </div>
        </div>
      </div>

      {/* 7 Cards Statistiques demandées par l'utilisateur */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {statsCards.map((card) => {
          const IconComp = card.icon;
          return (
            <div
              key={card.id}
              id={card.id}
              onClick={card.action}
              className="bg-white rounded-xl p-4 sm:p-5 border border-slate-200/90 hover:border-indigo-300 hover:shadow-md transition-all cursor-pointer group"
            >
              <div className="flex items-start justify-between">
                <div className={`p-2.5 rounded-xl border ${card.iconColor}`}>
                  <IconComp className="w-5 h-5" />
                </div>
                <span
                  className={`text-[11px] font-semibold px-2 py-0.5 rounded-full ${
                    card.badgeType === 'positive'
                      ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'
                      : card.badgeType === 'danger'
                      ? 'bg-rose-50 text-rose-700 border border-rose-200/60'
                      : card.badgeType === 'warning'
                      ? 'bg-amber-50 text-amber-700 border border-amber-200/60'
                      : 'bg-slate-100 text-slate-700 border border-slate-200'
                  }`}
                >
                  {card.badge}
                </span>
              </div>

              <div className="mt-3">
                <p className="text-xs font-medium text-slate-500 uppercase tracking-wider">
                  {card.title}
                </p>
                <h3 className="text-xl font-bold text-slate-900 mt-1 tracking-tight">
                  {card.value}
                </h3>
                <p className="text-xs text-slate-400 mt-1 truncate">{card.subtext}</p>
              </div>

              <div className="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-indigo-600 font-medium group-hover:text-indigo-700">
                <span>Voir le détail</span>
                <ChevronRight className="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" />
              </div>
            </div>
          );
        })}
      </div>

      {/* Grid: Derniers Paiements & Dernières Réclamations */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {/* Derniers Paiements (7 cols) */}
        <div className="lg:col-span-7 bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
          <div className="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
              <h2 className="text-base font-bold text-slate-900">Derniers Paiements Encaissés</h2>
              <p className="text-xs text-slate-500 mt-0.5">Historique des cotisations récentes des copropriétaires</p>
            </div>
            <button
              onClick={() => onNavigate('paiements')}
              className="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors"
            >
              Tous les paiements →
            </button>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse text-xs">
              <thead>
                <tr className="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                  <th className="py-3 px-4">Copropriétaire</th>
                  <th className="py-3 px-3">Lot</th>
                  <th className="py-3 px-3">Mois</th>
                  <th className="py-3 px-3">Montant</th>
                  <th className="py-3 px-3">Méthode</th>
                  <th className="py-3 px-4 text-right">Statut</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 text-slate-700">
                {MOCK_PAYMENTS.slice(0, 5).map((payment) => (
                  <tr key={payment.id} className="hover:bg-slate-50/60 transition-colors">
                    <td className="py-3.5 px-4">
                      <div className="font-semibold text-slate-900">{payment.residentName}</div>
                      <div className="text-[11px] text-slate-400">{payment.receiptNumber}</div>
                    </td>
                    <td className="py-3.5 px-3">
                      <span className="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 font-medium text-slate-800">
                        {payment.apartment}
                      </span>
                    </td>
                    <td className="py-3.5 px-3 text-slate-600">{payment.month}</td>
                    <td className="py-3.5 px-3 font-bold text-slate-900">
                      {payment.amount} {RESIDENCE_INFO.currency}
                    </td>
                    <td className="py-3.5 px-3">
                      <span className="text-slate-500 text-[11px]">{payment.method}</span>
                    </td>
                    <td className="py-3.5 px-4 text-right">
                      <span
                        className={`inline-flex items-center px-2 py-0.5 rounded-full font-semibold text-[11px] ${
                          payment.status === 'Payé'
                            ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'
                            : 'bg-amber-50 text-amber-700 border border-amber-200/60'
                        }`}
                      >
                        {payment.status === 'Payé' && <CheckCircle2 className="w-3 h-3 mr-1" />}
                        {payment.status === 'En attente' && <Clock className="w-3 h-3 mr-1" />}
                        {payment.status}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Dernières Réclamations (5 cols) */}
        <div className="lg:col-span-5 bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col">
          <div className="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
              <div className="flex items-center space-x-2">
                <h2 className="text-base font-bold text-slate-900">Dernières Réclamations</h2>
                <span className="text-[11px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-rose-700">
                  {MOCK_COMPLAINTS.length}
                </span>
              </div>
              <p className="text-xs text-slate-500 mt-0.5">Signalements techniques et vie d'immeuble</p>
            </div>
            <button
              onClick={() => onNavigate('reclamations')}
              className="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors"
            >
              Gérer →
            </button>
          </div>

          <div className="p-4 flex-1 space-y-3">
            {MOCK_COMPLAINTS.map((complaint) => (
              <div
                key={complaint.id}
                className="p-3.5 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-colors"
              >
                <div className="flex items-start justify-between gap-2">
                  <div className="flex items-center space-x-2">
                    <span
                      className={`text-[10px] font-bold uppercase px-1.5 py-0.5 rounded ${
                        complaint.priority === 'Urgente'
                          ? 'bg-rose-600 text-white'
                          : complaint.priority === 'Haute'
                          ? 'bg-amber-600 text-white'
                          : 'bg-slate-200 text-slate-700'
                      }`}
                    >
                      {complaint.priority}
                    </span>
                    <span className="text-xs font-bold text-slate-900 line-clamp-1">
                      {complaint.title}
                    </span>
                  </div>
                  <span
                    className={`text-[11px] font-medium shrink-0 px-2 py-0.5 rounded-full ${
                      complaint.status === 'En cours'
                        ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/60'
                        : complaint.status === 'Nouveau'
                        ? 'bg-amber-50 text-amber-700 border border-amber-200/60'
                        : 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'
                    }`}
                  >
                    {complaint.status}
                  </span>
                </div>

                <p className="text-xs text-slate-600 mt-1.5 line-clamp-2">
                  {complaint.description}
                </p>

                <div className="mt-2.5 pt-2 border-t border-slate-200/60 flex items-center justify-between text-[11px] text-slate-400">
                  <span>
                    Par <strong className="text-slate-700">{complaint.residentName}</strong> ({complaint.apartment})
                  </span>
                  <span>{complaint.date}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Section "Dernières Annonces" demandée par l'utilisateur */}
      <div className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
        <div className="flex items-center justify-between mb-4">
          <div className="flex items-center space-x-2">
            <Megaphone className="w-5 h-5 text-indigo-600" />
            <div>
              <h2 className="text-base font-bold text-slate-900">Dernières Annonces & Communications</h2>
              <p className="text-xs text-slate-500">Diffusions officielles à l'attention des résidents</p>
            </div>
          </div>
          <button
            onClick={() => onNavigate('annonces')}
            className="text-xs font-semibold text-indigo-600 hover:text-indigo-800"
          >
            Publier une annonce →
          </button>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          {MOCK_ANNOUNCEMENTS.map((announcement) => (
            <div
              key={announcement.id}
              className={`p-4 rounded-xl border flex flex-col justify-between transition-all ${
                announcement.isPinned
                  ? 'bg-amber-50/50 border-amber-200/80 shadow-xs'
                  : 'bg-slate-50/50 border-slate-200/70 hover:bg-slate-50'
              }`}
            >
              <div>
                <div className="flex items-center justify-between mb-2">
                  <span
                    className={`text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full ${
                      announcement.category === 'Assemblée Générale'
                        ? 'bg-indigo-100 text-indigo-700'
                        : announcement.category === 'Travaux'
                        ? 'bg-amber-100 text-amber-800'
                        : 'bg-slate-200 text-slate-700'
                    }`}
                  >
                    {announcement.category}
                  </span>
                  {announcement.isPinned && (
                    <span className="text-[10px] font-bold text-amber-700 flex items-center">
                      📌 Épinglée
                    </span>
                  )}
                </div>

                <h4 className="text-sm font-bold text-slate-900 mb-1.5 leading-snug">
                  {announcement.title}
                </h4>
                <p className="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                  {announcement.content}
                </p>
              </div>

              <div className="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between text-[11px] text-slate-400">
                <span>{announcement.author}</span>
                <span>{announcement.date}</span>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};
