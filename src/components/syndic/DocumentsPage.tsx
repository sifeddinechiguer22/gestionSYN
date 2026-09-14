import React, { useState } from 'react';
import {
  FileText,
  Download,
  Upload,
  Search,
  Folder,
  CheckCircle2,
  Megaphone,
  Calendar,
  X,
  Plus
} from 'lucide-react';
import { MOCK_DOCUMENTS, MOCK_ANNOUNCEMENTS } from '../../data/mockData';

export const DocumentsPage: React.FC = () => {
  const [activeCategory, setActiveCategory] = useState<string>('all');
  const [toast, setToast] = useState<string | null>(null);

  const filteredDocs =
    activeCategory === 'all'
      ? MOCK_DOCUMENTS
      : MOCK_DOCUMENTS.filter((d) => d.category === activeCategory);

  const handleDownload = (name: string) => {
    setToast(`Téléchargement de "${name}"...`);
    setTimeout(() => setToast(null), 3000);
  };

  return (
    <div className="space-y-6 pb-12">
      {toast && (
        <div className="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-center justify-between">
          <span>{toast}</span>
          <button onClick={() => setToast(null)} className="text-emerald-600 font-bold">
            <X className="w-4 h-4" />
          </button>
        </div>
      )}

      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
            Documents Officiels & Archives Copropriété
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Procès-verbaux d'assemblée générale, contrats de maintenance, bilans et règlements.
          </p>
        </div>

        <button
          onClick={() => {
            setToast('Fonctionnalité d import de document disponible.');
            setTimeout(() => setToast(null), 3000);
          }}
          className="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition-all"
        >
          <Upload className="w-4 h-4 mr-1.5" />
          <span>Déposer un document</span>
        </button>
      </div>

      {/* Category Pills */}
      <div className="flex flex-wrap gap-2">
        {['all', 'Procès-Verbal AG', 'Règlement', 'Finances', 'Contrats'].map((cat) => (
          <button
            key={cat}
            onClick={() => setActiveCategory(cat)}
            className={`px-3 py-1.5 rounded-xl text-xs font-semibold transition-all ${
              activeCategory === cat
                ? 'bg-indigo-600 text-white shadow-xs'
                : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50'
            }`}
          >
            {cat === 'all' ? 'Tous les documents' : cat}
          </button>
        ))}
      </div>

      {/* Documents Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {filteredDocs.map((doc) => (
          <div
            key={doc.id}
            className="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between hover:border-indigo-300 transition-all group"
          >
            <div>
              <div className="flex items-center justify-between mb-3">
                <div className="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                  <FileText className="w-5 h-5" />
                </div>
                <span className="text-[10px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-200/60 px-2 py-0.5 rounded-md">
                  {doc.category}
                </span>
              </div>

              <h4 className="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                {doc.name}
              </h4>
              <p className="text-[11px] text-slate-400 mt-1">
                Taille : {doc.size} • Ajouté le {doc.date}
              </p>
            </div>

            <div className="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
              <span className="text-[11px] text-emerald-600 font-medium">Document certifié</span>
              <button
                onClick={() => handleDownload(doc.name)}
                className="inline-flex items-center space-x-1 text-xs font-bold text-indigo-600 hover:text-indigo-800"
              >
                <Download className="w-3.5 h-3.5" />
                <span>Télécharger</span>
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};
