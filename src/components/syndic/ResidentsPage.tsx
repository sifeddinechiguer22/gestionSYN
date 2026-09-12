import React, { useState, useMemo } from 'react';
import {
  Search,
  Filter,
  UserPlus,
  Download,
  MoreVertical,
  Mail,
  Phone,
  CheckCircle2,
  AlertTriangle,
  Clock,
  ChevronLeft,
  ChevronRight,
  Eye,
  Edit,
  CreditCard,
  Building,
  Home,
  X,
  Check
} from 'lucide-react';
import { MOCK_RESIDENTS, RESIDENCE_INFO } from '../../data/mockData';
import { Resident } from '../../types';

export const ResidentsPage: React.FC = () => {
  const [residents, setResidents] = useState<Resident[]>(MOCK_RESIDENTS);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedBuilding, setSelectedBuilding] = useState<string>('all');
  const [selectedType, setSelectedType] = useState<string>('all');
  const [selectedPaymentStatus, setSelectedPaymentStatus] = useState<string>('all');

  // Pagination state
  const [currentPage, setCurrentPage] = useState(1);
  const [itemsPerPage, setItemsPerPage] = useState(6);

  // Modal / Drawer state
  const [isAddModalOpen, setIsAddModalOpen] = useState(false);
  const [selectedResidentForDetails, setSelectedResidentForDetails] = useState<Resident | null>(null);
  const [toastMessage, setToastMessage] = useState<string | null>(null);

  // New resident form state
  const [newFirstName, setNewFirstName] = useState('');
  const [newLastName, setNewLastName] = useState('');
  const [newEmail, setNewEmail] = useState('');
  const [newPhone, setNewPhone] = useState('');
  const [newBuilding, setNewBuilding] = useState('Bâtiment A');
  const [newApartment, setNewApartment] = useState('A-103');
  const [newFloor, setNewFloor] = useState(1);
  const [newType, setNewType] = useState<'Propriétaire' | 'Locataire' | 'Bailleur'>('Propriétaire');
  const [newMonthlyDue, setNewMonthlyDue] = useState(1000);

  // Filtered list
  const filteredResidents = useMemo(() => {
    return residents.filter((res) => {
      const fullName = `${res.firstName} ${res.lastName}`.toLowerCase();
      const matchesSearch =
        fullName.includes(searchTerm.toLowerCase()) ||
        res.apartment.toLowerCase().includes(searchTerm.toLowerCase()) ||
        res.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
        res.phone.includes(searchTerm);

      const matchesBuilding = selectedBuilding === 'all' || res.building === selectedBuilding;
      const matchesType = selectedType === 'all' || res.type === selectedType;
      const matchesPayment =
        selectedPaymentStatus === 'all' ||
        (selectedPaymentStatus === 'A_JOUR' && res.paymentStatus === 'A_JOUR') ||
        (selectedPaymentStatus === 'RETARD' && res.paymentStatus !== 'A_JOUR');

      return matchesSearch && matchesBuilding && matchesType && matchesPayment;
    });
  }, [residents, searchTerm, selectedBuilding, selectedType, selectedPaymentStatus]);

  // Pagination calculations
  const totalItems = filteredResidents.length;
  const totalPages = Math.ceil(totalItems / itemsPerPage) || 1;
  const startIndex = (currentPage - 1) * itemsPerPage;
  const paginatedResidents = filteredResidents.slice(startIndex, startIndex + itemsPerPage);

  const showToast = (msg: string) => {
    setToastMessage(msg);
    setTimeout(() => {
      setToastMessage(null);
    }, 3000);
  };

  const handleAddResident = (e: React.FormEvent) => {
    e.preventDefault();
    if (!newFirstName || !newLastName) return;

    const newRes: Resident = {
      id: `res-${Date.now()}`,
      firstName: newFirstName,
      lastName: newLastName,
      email: newEmail || `${newFirstName.toLowerCase()}.${newLastName.toLowerCase()}@email.com`,
      phone: newPhone || '+212 6 00 00 00 00',
      building: newBuilding,
      apartment: newApartment,
      floor: newFloor,
      type: newType,
      monthlyDue: Number(newMonthlyDue),
      paymentStatus: 'A_JOUR',
      unpaidAmount: 0,
      entryDate: new Date().toISOString().split('T')[0],
    };

    setResidents([newRes, ...residents]);
    setIsAddModalOpen(false);
    showToast(`Le résident ${newFirstName} ${newLastName} a été ajouté avec succès.`);

    // Reset form
    setNewFirstName('');
    setNewLastName('');
    setNewEmail('');
    setNewPhone('');
  };

  return (
    <div className="space-y-6 pb-12">
      {/* Toast Notification */}
      {toastMessage && (
        <div className="p-3.5 bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-lg border border-slate-700 flex items-center justify-between animate-in fade-in slide-in-from-top-2 duration-200">
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
            Registre des Résidents & Copropriétaires
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Gestion des occupants, coordonnées, statut d'occupation et situation des charges.
          </p>
        </div>

        <div className="flex items-center space-x-2">
          <button
            onClick={() => showToast('Génération de l’export Excel des résidents en cours...')}
            className="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-xs transition-colors"
          >
            <Download className="w-4 h-4 mr-1.5 text-slate-500" />
            <span>Exporter CSV</span>
          </button>

          <button
            id="btn-nouveau-resident"
            onClick={() => setIsAddModalOpen(true)}
            className="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs shadow-indigo-600/30 transition-all"
          >
            <UserPlus className="w-4 h-4 mr-1.5" />
            <span>Nouveau Résident</span>
          </button>
        </div>
      </div>

      {/* Quick Summary Pill Bar */}
      <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div className="bg-white p-3 rounded-xl border border-slate-200/90 shadow-xs flex items-center justify-between">
          <span className="text-xs text-slate-500 font-medium">Total résidents</span>
          <span className="text-sm font-bold text-slate-900">{residents.length}</span>
        </div>
        <div className="bg-white p-3 rounded-xl border border-slate-200/90 shadow-xs flex items-center justify-between">
          <span className="text-xs text-slate-500 font-medium">Propriétaires</span>
          <span className="text-sm font-bold text-indigo-600">
            {residents.filter((r) => r.type === 'Propriétaire' || r.type === 'Bailleur').length}
          </span>
        </div>
        <div className="bg-white p-3 rounded-xl border border-slate-200/90 shadow-xs flex items-center justify-between">
          <span className="text-xs text-slate-500 font-medium">Locataires</span>
          <span className="text-sm font-bold text-sky-600">
            {residents.filter((r) => r.type === 'Locataire').length}
          </span>
        </div>
        <div className="bg-white p-3 rounded-xl border border-slate-200/90 shadow-xs flex items-center justify-between">
          <span className="text-xs text-slate-500 font-medium">En retard de paiement</span>
          <span className="text-sm font-bold text-rose-600">
            {residents.filter((r) => r.paymentStatus !== 'A_JOUR').length}
          </span>
        </div>
      </div>

      {/* Filter and Search Bar */}
      <div className="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs space-y-3">
        <div className="grid grid-cols-1 md:grid-cols-12 gap-3">
          {/* Search Box */}
          <div className="md:col-span-5 relative">
            <Search className="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
            <input
              type="text"
              value={searchTerm}
              onChange={(e) => {
                setSearchTerm(e.target.value);
                setCurrentPage(1);
              }}
              placeholder="Rechercher par nom, n° d'appartement, email ou tél..."
              className="w-full pl-10 pr-4 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
            />
          </div>

          {/* Building Filter */}
          <div className="md:col-span-2">
            <select
              value={selectedBuilding}
              onChange={(e) => {
                setSelectedBuilding(e.target.value);
                setCurrentPage(1);
              }}
              className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
            >
              <option value="all">Tous les bâtiments</option>
              <option value="Bâtiment A">Bâtiment A</option>
              <option value="Bâtiment B">Bâtiment B</option>
              <option value="Bâtiment C">Bâtiment C</option>
            </select>
          </div>

          {/* Type Filter */}
          <div className="md:col-span-2">
            <select
              value={selectedType}
              onChange={(e) => {
                setSelectedType(e.target.value);
                setCurrentPage(1);
              }}
              className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
            >
              <option value="all">Tous les statuts</option>
              <option value="Propriétaire">Propriétaire occupant</option>
              <option value="Locataire">Locataire</option>
              <option value="Bailleur">Propriétaire bailleur</option>
            </select>
          </div>

          {/* Payment Status Filter */}
          <div className="md:col-span-3">
            <select
              value={selectedPaymentStatus}
              onChange={(e) => {
                setSelectedPaymentStatus(e.target.value);
                setCurrentPage(1);
              }}
              className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
            >
              <option value="all">Toutes les situations de charges</option>
              <option value="A_JOUR">À jour uniquement</option>
              <option value="RETARD">Impayés / En retard uniquement</option>
            </select>
          </div>
        </div>

        {/* Active filter tags counter */}
        {(searchTerm || selectedBuilding !== 'all' || selectedType !== 'all' || selectedPaymentStatus !== 'all') && (
          <div className="flex items-center justify-between pt-2 border-t border-slate-100 text-xs text-slate-500">
            <span>
              Résultats filtrés : <strong className="text-slate-800">{filteredResidents.length}</strong> résident(s) trouvé(s)
            </span>
            <button
              onClick={() => {
                setSearchTerm('');
                setSelectedBuilding('all');
                setSelectedType('all');
                setSelectedPaymentStatus('all');
                setCurrentPage(1);
              }}
              className="text-xs text-indigo-600 hover:text-indigo-800 font-medium"
            >
              Réinitialiser les filtres
            </button>
          </div>
        )}
      </div>

      {/* Main Table */}
      <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse text-xs">
            <thead>
              <tr className="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                <th className="py-3.5 px-4">Résident</th>
                <th className="py-3.5 px-3">Logement</th>
                <th className="py-3.5 px-3">Statut</th>
                <th className="py-3.5 px-3">Contact</th>
                <th className="py-3.5 px-3">Cotisation</th>
                <th className="py-3.5 px-3">Situation</th>
                <th className="py-3.5 px-4 text-right">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 text-slate-700">
              {paginatedResidents.length > 0 ? (
                paginatedResidents.map((res) => {
                  const initials = `${res.firstName.charAt(0)}${res.lastName.charAt(0)}`;
                  return (
                    <tr
                      key={res.id}
                      className="hover:bg-slate-50/70 transition-colors group cursor-pointer"
                      onClick={() => setSelectedResidentForDetails(res)}
                    >
                      {/* Name & Avatar */}
                      <td className="py-3.5 px-4">
                        <div className="flex items-center space-x-3">
                          <div className="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                            {initials}
                          </div>
                          <div>
                            <div className="font-bold text-slate-900 text-xs">
                              {res.firstName} {res.lastName}
                            </div>
                            <div className="text-[11px] text-slate-400">
                              Entré le {res.entryDate}
                            </div>
                          </div>
                        </div>
                      </td>

                      {/* Apartment & Building */}
                      <td className="py-3.5 px-3">
                        <div className="font-semibold text-slate-800 text-xs flex items-center space-x-1.5">
                          <span className="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 font-mono">
                            {res.apartment}
                          </span>
                        </div>
                        <div className="text-[11px] text-slate-400 mt-0.5">
                          {res.building} • Étage {res.floor}
                        </div>
                      </td>

                      {/* Type */}
                      <td className="py-3.5 px-3">
                        <span
                          className={`inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium ${
                            res.type === 'Propriétaire'
                              ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/60'
                              : res.type === 'Bailleur'
                              ? 'bg-purple-50 text-purple-700 border border-purple-200/60'
                              : 'bg-sky-50 text-sky-700 border border-sky-200/60'
                          }`}
                        >
                          {res.type}
                        </span>
                      </td>

                      {/* Contact */}
                      <td className="py-3.5 px-3">
                        <div className="flex items-center space-x-1 text-slate-700 text-xs">
                          <Phone className="w-3 h-3 text-slate-400" />
                          <span>{res.phone}</span>
                        </div>
                        <div className="flex items-center space-x-1 text-slate-400 text-[11px] mt-0.5">
                          <Mail className="w-3 h-3 text-slate-400" />
                          <span className="truncate max-w-[140px]">{res.email}</span>
                        </div>
                      </td>

                      {/* Monthly due */}
                      <td className="py-3.5 px-3">
                        <span className="font-bold text-slate-900">
                          {res.monthlyDue} {RESIDENCE_INFO.currency}
                        </span>
                        <span className="text-[10px] text-slate-400 block">/ mois</span>
                      </td>

                      {/* Status */}
                      <td className="py-3.5 px-3">
                        {res.paymentStatus === 'A_JOUR' ? (
                          <span className="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                            <CheckCircle2 className="w-3 h-3 mr-1" />
                            À jour
                          </span>
                        ) : res.paymentStatus === 'RETARD_1M' ? (
                          <span className="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                            <Clock className="w-3 h-3 mr-1" />
                            1 mois retard ({res.unpaidAmount} {RESIDENCE_INFO.currency})
                          </span>
                        ) : (
                          <span className="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                            <AlertTriangle className="w-3 h-3 mr-1" />
                            {res.unpaidAmount} {RESIDENCE_INFO.currency} impayé
                          </span>
                        )}
                      </td>

                      {/* Actions */}
                      <td className="py-3.5 px-4 text-right" onClick={(e) => e.stopPropagation()}>
                        <div className="flex items-center justify-end space-x-1.5">
                          <button
                            onClick={() => setSelectedResidentForDetails(res)}
                            title="Voir la fiche"
                            className="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-slate-100 transition-colors"
                          >
                            <Eye className="w-4 h-4" />
                          </button>
                          <button
                            onClick={() => showToast(`Envoi d'un rappel à ${res.firstName} ${res.lastName}...`)}
                            title="Envoyer un rappel"
                            className="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-slate-100 transition-colors"
                          >
                            <Mail className="w-4 h-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  );
                })
              ) : (
                <tr>
                  <td colSpan={7} className="py-8 text-center text-slate-400 text-xs">
                    Aucun résident ne correspond à vos critères de recherche.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        {/* Pagination Controls */}
        <div className="px-4 py-3 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
          <div className="text-slate-500">
            Affichage de <span className="font-semibold text-slate-800">{totalItems === 0 ? 0 : startIndex + 1}</span> à{' '}
            <span className="font-semibold text-slate-800">{Math.min(startIndex + itemsPerPage, totalItems)}</span> sur{' '}
            <span className="font-semibold text-slate-800">{totalItems}</span> résidents
          </div>

          <div className="flex items-center space-x-2">
            <button
              onClick={() => setCurrentPage((p) => Math.max(p - 1, 1))}
              disabled={currentPage === 1}
              className="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors flex items-center"
            >
              <ChevronLeft className="w-3.5 h-3.5 mr-1" />
              Précédent
            </button>

            {Array.from({ length: totalPages }, (_, i) => i + 1).map((pageNum) => (
              <button
                key={pageNum}
                onClick={() => setCurrentPage(pageNum)}
                className={`w-7 h-7 rounded-lg text-xs font-semibold transition-all ${
                  currentPage === pageNum
                    ? 'bg-indigo-600 text-white shadow-xs'
                    : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50'
                }`}
              >
                {pageNum}
              </button>
            ))}

            <button
              onClick={() => setCurrentPage((p) => Math.min(p + 1, totalPages))}
              disabled={currentPage === totalPages || totalPages === 0}
              className="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors flex items-center"
            >
              Suivant
              <ChevronRight className="w-3.5 h-3.5 ml-1" />
            </button>
          </div>
        </div>
      </div>

      {/* Modal: Ajouter un Nouveau Résident */}
      {isAddModalOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
          <div className="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-slate-200 animate-in fade-in zoom-in-95 duration-150">
            <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
              <h3 className="text-base font-bold text-slate-900">Ajouter un nouveau résident</h3>
              <button
                onClick={() => setIsAddModalOpen(false)}
                className="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleAddResident} className="p-6 space-y-4">
              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Prénom *</label>
                  <input
                    type="text"
                    required
                    value={newFirstName}
                    onChange={(e) => setNewFirstName(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                    placeholder="Ex: Hicham"
                  />
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Nom *</label>
                  <input
                    type="text"
                    required
                    value={newLastName}
                    onChange={(e) => setNewLastName(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                    placeholder="Ex: Alaoui"
                  />
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Email</label>
                  <input
                    type="email"
                    value={newEmail}
                    onChange={(e) => setNewEmail(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                    placeholder="hicham.alaoui@email.com"
                  />
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Téléphone</label>
                  <input
                    type="tel"
                    value={newPhone}
                    onChange={(e) => setNewPhone(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                    placeholder="+212 6 00 00 00 00"
                  />
                </div>
              </div>

              <div className="grid grid-cols-3 gap-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Bâtiment</label>
                  <select
                    value={newBuilding}
                    onChange={(e) => setNewBuilding(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                  >
                    <option value="Bâtiment A">Bâtiment A</option>
                    <option value="Bâtiment B">Bâtiment B</option>
                    <option value="Bâtiment C">Bâtiment C</option>
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Appartement</label>
                  <input
                    type="text"
                    value={newApartment}
                    onChange={(e) => setNewApartment(e.target.value)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                    placeholder="A-103"
                  />
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Étage</label>
                  <input
                    type="number"
                    value={newFloor}
                    onChange={(e) => setNewFloor(Number(e.target.value))}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                  />
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Statut d'occupation</label>
                  <select
                    value={newType}
                    onChange={(e) => setNewType(e.target.value as any)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                  >
                    <option value="Propriétaire">Propriétaire occupant</option>
                    <option value="Locataire">Locataire</option>
                    <option value="Bailleur">Propriétaire bailleur</option>
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Cotisation mensuelle (MAD)</label>
                  <input
                    type="number"
                    value={newMonthlyDue}
                    onChange={(e) => setNewMonthlyDue(Number(e.target.value))}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                  />
                </div>
              </div>

              <div className="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button
                  type="button"
                  onClick={() => setIsAddModalOpen(false)}
                  className="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors"
                >
                  Annuler
                </button>
                <button
                  type="submit"
                  className="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition-colors"
                >
                  Enregistrer le résident
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* Drawer: Fiche détaillée du résident */}
      {selectedResidentForDetails && (
        <div className="fixed inset-0 z-50 flex justify-end bg-slate-900/50 backdrop-blur-xs">
          <div className="bg-white w-full max-w-md h-full shadow-2xl flex flex-col border-l border-slate-200 animate-in slide-in-from-right duration-200">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between">
              <div>
                <h3 className="text-base font-bold text-slate-900">Fiche Copropriétaire / Résident</h3>
                <p className="text-xs text-slate-400">ID : {selectedResidentForDetails.id}</p>
              </div>
              <button
                onClick={() => setSelectedResidentForDetails(null)}
                className="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <div className="p-6 flex-1 overflow-y-auto space-y-5">
              {/* Header profile */}
              <div className="flex items-center space-x-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div className="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-base shadow-sm">
                  {selectedResidentForDetails.firstName.charAt(0)}
                  {selectedResidentForDetails.lastName.charAt(0)}
                </div>
                <div>
                  <h4 className="text-sm font-bold text-slate-900">
                    {selectedResidentForDetails.firstName} {selectedResidentForDetails.lastName}
                  </h4>
                  <span className="text-xs font-semibold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-200/60 mt-1 inline-block">
                    {selectedResidentForDetails.type}
                  </span>
                </div>
              </div>

              {/* Lot details */}
              <div className="space-y-2">
                <h5 className="text-xs font-bold text-slate-400 uppercase tracking-wider">Lot assigné</h5>
                <div className="p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs space-y-2">
                  <div className="flex justify-between">
                    <span className="text-slate-500">Appartement</span>
                    <span className="font-bold text-slate-900">{selectedResidentForDetails.apartment}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-slate-500">Bâtiment</span>
                    <span className="text-slate-800">{selectedResidentForDetails.building}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-slate-500">Étage</span>
                    <span className="text-slate-800">Étage {selectedResidentForDetails.floor}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-slate-500">Date d'emménagement</span>
                    <span className="text-slate-800">{selectedResidentForDetails.entryDate}</span>
                  </div>
                </div>
              </div>

              {/* Financial situation */}
              <div className="space-y-2">
                <h5 className="text-xs font-bold text-slate-400 uppercase tracking-wider">Situation des charges</h5>
                <div className="p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs space-y-2">
                  <div className="flex justify-between">
                    <span className="text-slate-500">Cotisation mensuelle</span>
                    <span className="font-bold text-slate-900">{selectedResidentForDetails.monthlyDue} MAD</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-slate-500">État du compte</span>
                    <span
                      className={`font-semibold px-2 py-0.5 rounded-md ${
                        selectedResidentForDetails.paymentStatus === 'A_JOUR'
                          ? 'bg-emerald-100 text-emerald-800'
                          : 'bg-rose-100 text-rose-800'
                      }`}
                    >
                      {selectedResidentForDetails.paymentStatus === 'A_JOUR'
                        ? 'À jour (0 MAD impayé)'
                        : `${selectedResidentForDetails.unpaidAmount} MAD de retard`}
                    </span>
                  </div>
                </div>
              </div>

              {/* Contacts */}
              <div className="space-y-2">
                <h5 className="text-xs font-bold text-slate-400 uppercase tracking-wider">Coordonnées directes</h5>
                <div className="p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs space-y-2">
                  <div className="flex items-center justify-between">
                    <span className="text-slate-500">Téléphone</span>
                    <a href={`tel:${selectedResidentForDetails.phone}`} className="font-semibold text-indigo-600">
                      {selectedResidentForDetails.phone}
                    </a>
                  </div>
                  <div className="flex items-center justify-between">
                    <span className="text-slate-500">Email</span>
                    <a href={`mailto:${selectedResidentForDetails.email}`} className="font-semibold text-indigo-600">
                      {selectedResidentForDetails.email}
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div className="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
              <button
                onClick={() => showToast(`Rappel envoyé à ${selectedResidentForDetails.email}`)}
                className="px-3 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-xl text-xs font-semibold"
              >
                Envoyer rappel
              </button>
              <button
                onClick={() => showToast('Ouverture de la fenêtre d encaissement')}
                className="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs"
              >
                Enregistrer paiement
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};
