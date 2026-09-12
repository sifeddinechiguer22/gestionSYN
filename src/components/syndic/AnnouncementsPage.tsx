import React, { useState } from 'react';
import {
  Megaphone,
  Plus,
  Calendar,
  Pin,
  Send,
  X,
  Check
} from 'lucide-react';
import { MOCK_ANNOUNCEMENTS } from '../../data/mockData';
import { Announcement } from '../../types';

export const AnnouncementsPage: React.FC = () => {
  const [announcements, setAnnouncements] = useState<Announcement[]>(MOCK_ANNOUNCEMENTS);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [toast, setToast] = useState<string | null>(null);

  // Form
  const [title, setTitle] = useState('');
  const [category, setCategory] = useState<'Assemblée Générale' | 'Travaux' | 'Rappel' | 'Événement'>('Travaux');
  const [content, setContent] = useState('');
  const [isPinned, setIsPinned] = useState(false);

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newAnn: Announcement = {
      id: `ann-${Date.now()}`,
      title,
      category,
      content,
      isPinned,
      date: new Date().toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }),
      author: 'Bureau du Syndic',
    };

    setAnnouncements([newAnn, ...announcements]);
    setIsModalOpen(false);
    setToast('Annonce publiée et notifiée à tous les résidents !');
    setTimeout(() => setToast(null), 3000);
    setTitle('');
    setContent('');
  };

  return (
    <div className="space-y-6 pb-12">
      {toast && (
        <div className="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <Check className="w-4 h-4 text-emerald-600" />
            <span>{toast}</span>
          </div>
          <button onClick={() => setToast(null)}>
            <X className="w-3.5 h-3.5" />
          </button>
        </div>
      )}

      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
            Annonces & Communications Résidents
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Diffusion des avis de travaux, convocations d'AG et informations générales aux copropriétaires.
          </p>
        </div>

        <button
          onClick={() => setIsModalOpen(true)}
          className="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition-all"
        >
          <Plus className="w-4 h-4 mr-1.5" />
          <span>Nouvelle annonce</span>
        </button>
      </div>

      {/* Announcements List */}
      <div className="space-y-4">
        {announcements.map((ann) => (
          <div
            key={ann.id}
            className={`p-5 rounded-2xl border transition-all ${
              ann.isPinned
                ? 'bg-amber-50/40 border-amber-200/80 shadow-xs'
                : 'bg-white border-slate-200/90 shadow-xs'
            }`}
          >
            <div className="flex items-center justify-between mb-3">
              <div className="flex items-center space-x-2">
                <span
                  className={`text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full ${
                    ann.category === 'Assemblée Générale'
                      ? 'bg-indigo-100 text-indigo-700'
                      : ann.category === 'Travaux'
                      ? 'bg-amber-100 text-amber-800'
                      : 'bg-slate-200 text-slate-700'
                  }`}
                >
                  {ann.category}
                </span>
                {ann.isPinned && (
                  <span className="text-xs font-bold text-amber-700 flex items-center bg-amber-100/80 px-2 py-0.5 rounded-full">
                    <Pin className="w-3 h-3 mr-1" />
                    Épinglée en tête
                  </span>
                )}
              </div>
              <span className="text-xs text-slate-400 font-medium">{ann.date}</span>
            </div>

            <h3 className="text-base font-bold text-slate-900 mb-2">{ann.title}</h3>
            <p className="text-xs text-slate-600 leading-relaxed max-w-3xl">{ann.content}</p>

            <div className="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
              <span>Diffusé par <strong className="text-slate-700">{ann.author}</strong></span>
              <span className="text-emerald-600 font-medium">Transmis par email & notification app</span>
            </div>
          </div>
        ))}
      </div>

      {/* Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
          <div className="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-slate-200">
            <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
              <h3 className="text-base font-bold text-slate-900">Publier une annonce officielle</h3>
              <button onClick={() => setIsModalOpen(false)} className="p-1 rounded-lg text-slate-400 hover:text-slate-600">
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleCreate} className="p-6 space-y-4">
              <div>
                <label className="block text-xs font-medium text-slate-700 mb-1">Titre de l'annonce *</label>
                <input
                  type="text"
                  required
                  value={title}
                  onChange={(e) => setTitle(e.target.value)}
                  placeholder="Ex: Réparation porte automatique parking"
                  className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                />
              </div>

              <div>
                <label className="block text-xs font-medium text-slate-700 mb-1">Catégorie</label>
                <select
                  value={category}
                  onChange={(e) => setCategory(e.target.value as any)}
                  className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                >
                  <option value="Travaux">Travaux & Maintenance</option>
                  <option value="Assemblée Générale">Assemblée Générale</option>
                  <option value="Rappel">Rappel de Règlement</option>
                  <option value="Événement">Événement & Réunion</option>
                </select>
              </div>

              <div>
                <label className="block text-xs font-medium text-slate-700 mb-1">Contenu du message *</label>
                <textarea
                  required
                  rows={4}
                  value={content}
                  onChange={(e) => setContent(e.target.value)}
                  placeholder="Détaillez la communication aux résidents..."
                  className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
                />
              </div>

              <div className="flex items-center space-x-2">
                <input
                  type="checkbox"
                  id="pin"
                  checked={isPinned}
                  onChange={(e) => setIsPinned(e.target.checked)}
                  className="rounded border-slate-300 text-indigo-600"
                />
                <label htmlFor="pin" className="text-xs text-slate-700 cursor-pointer">
                  Épingler cette annonce en haut du tableau d'affichage
                </label>
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
                  className="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs"
                >
                  Diffuser immédiatement
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
