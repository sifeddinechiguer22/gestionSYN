import React, { useState } from 'react';
import {
  AlertCircle,
  Plus,
  Clock,
  CheckCircle2,
  Wrench,
  X,
  Check
} from 'lucide-react';
import { MOCK_COMPLAINTS, CURRENT_RESIDENT_PROFILE } from '../../data/mockData';
import { Complaint } from '../../types';

export const ResidentComplaintsPage: React.FC = () => {
  const [complaints, setComplaints] = useState<Complaint[]>([
    ...MOCK_COMPLAINTS.filter((c) => c.apartment === 'B-204'),
    {
      id: 'rec-prev-01',
      residentName: CURRENT_RESIDENT_PROFILE.name,
      apartment: 'B-204',
      title: 'Interphone combiné muet après orage',
      category: 'Autre',
      priority: 'Moyenne',
      status: 'Résolu',
      date: '14 Janvier 2026',
      description: 'Le combiné intérieur ne sonnait plus. L’électricien de garde a réinitialisé la centrale.',
    }
  ]);

  const [isModalOpen, setIsModalOpen] = useState(false);
  const [toast, setToast] = useState<string | null>(null);

  // Form
  const [title, setTitle] = useState('');
  const [category, setCategory] = useState<'Ascenseur' | 'Plomberie' | 'Éclairage' | 'Bruit / Voisinage' | 'Parking' | 'Autre'>('Ascenseur');
  const [priority, setPriority] = useState<'Basse' | 'Moyenne' | 'Haute' | 'Urgente'>('Moyenne');
  const [description, setDescription] = useState('');

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const newComp: Complaint = {
      id: `rec-${Date.now()}`,
      residentName: CURRENT_RESIDENT_PROFILE.name,
      apartment: CURRENT_RESIDENT_PROFILE.apartment,
      title,
      category,
      priority,
      status: 'Nouveau',
      date: new Date().toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }),
      description,
    };

    setComplaints([newComp, ...complaints]);
    setIsModalOpen(false);
    setToast('Votre signalement a été transmis au bureau du syndic avec succès.');
    setTimeout(() => setToast(null), 3500);
    setTitle('');
    setDescription('');
  };

  return (
    <div className="space-y-6 pb-12">
      {toast && (
        <div className="p-3.5 bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-lg border border-slate-700 flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <Check className="w-4 h-4 text-emerald-400" />
            <span>{toast}</span>
          </div>
          <button onClick={() => setToast(null)} className="text-slate-400 hover:text-white">
            <X className="w-3.5 h-3.5" />
          </button>
        </div>
      )}

      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
            Mes Réclamations & Signalements
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Déclarez et suivez les interventions sur les parties communes ou équipements.
          </p>
        </div>

        <button
          onClick={() => setIsModalOpen(true)}
          className="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs shadow-emerald-600/30 transition-all"
        >
          <Plus className="w-4 h-4 mr-1.5" />
          <span>Nouvelle réclamation</span>
        </button>
      </div>

      {/* Complaints Grid */}
      <div className="space-y-4">
        {complaints.map((comp) => (
          <div
            key={comp.id}
            className="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs"
          >
            <div className="flex items-center justify-between mb-2">
              <div className="flex items-center space-x-2">
                <span
                  className={`text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded ${
                    comp.priority === 'Urgente'
                      ? 'bg-rose-600 text-white'
                      : comp.priority === 'Haute'
                      ? 'bg-amber-600 text-white'
                      : 'bg-slate-200 text-slate-700'
                  }`}
                >
                  {comp.priority}
                </span>
                <span className="text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-0.5 rounded-md">
                  {comp.category}
                </span>
              </div>

              <span
                className={`text-xs font-semibold px-2.5 py-0.5 rounded-full ${
                  comp.status === 'Résolu'
                    ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'
                    : comp.status === 'En cours'
                    ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/60'
                    : 'bg-amber-50 text-amber-700 border border-amber-200/60'
                }`}
              >
                {comp.status}
              </span>
            </div>

            <h3 className="text-base font-bold text-slate-900 mt-2">{comp.title}</h3>
            <p className="text-xs text-slate-600 mt-1 leading-relaxed">{comp.description}</p>

            <div className="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
              <span>Date de dépôt : {comp.date}</span>
              <span className="text-emerald-600 font-medium">
                {comp.status === 'Résolu' ? 'Intervention finalisée' : 'Dossier assigné au technicien'}
              </span>
            </div>
          </div>
        ))}
      </div>

      {/* Modal: Déclarer incident */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
          <div className="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-slate-200">
            <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
              <h3 className="text-base font-bold text-slate-900">Signaler un incident au syndic</h3>
              <button onClick={() => setIsModalOpen(false)} className="p-1 rounded-lg text-slate-400 hover:text-slate-600">
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleSubmit} className="p-6 space-y-4">
              <div>
                <label className="block text-xs font-medium text-slate-700 mb-1">Intitulé du problème *</label>
                <input
                  type="text"
                  required
                  value={title}
                  onChange={(e) => setTitle(e.target.value)}
                  placeholder="Ex: Éclairage défaillant palier 2ème étage Bât B"
                  className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                />
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Catégorie</label>
                  <select
                    value={category}
                    onChange={(e) => setCategory(e.target.value as any)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                  >
                    <option value="Ascenseur">Ascenseur</option>
                    <option value="Plomberie">Plomberie / Eau</option>
                    <option value="Éclairage">Éclairage / Électricité</option>
                    <option value="Parking">Parking & Accès</option>
                    <option value="Bruit / Voisinage">Bruit & Voisinage</option>
                    <option value="Autre">Autre incident</option>
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Degré d'urgence</label>
                  <select
                    value={priority}
                    onChange={(e) => setPriority(e.target.value as any)}
                    className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                  >
                    <option value="Moyenne">Moyenne (Sous 48h)</option>
                    <option value="Urgente">Urgente (Immédiate)</option>
                    <option value="Haute">Haute (Sous 24h)</option>
                    <option value="Basse">Basse (Simple remarque)</option>
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-xs font-medium text-slate-700 mb-1">Description détaillée *</label>
                <textarea
                  required
                  rows={3}
                  value={description}
                  onChange={(e) => setDescription(e.target.value)}
                  placeholder="Localisation précise, heure constatée, symptômes..."
                  className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                />
              </div>

              <div className="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button
                  type="button"
                  onClick={() => setIsModalOpen(false)}
                  className="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl"
                >
                  Annuler
                </button>
                <button
                  type="submit"
                  className="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs"
                >
                  Envoyer la réclamation
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
