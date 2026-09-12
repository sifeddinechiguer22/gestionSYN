import React, { useState } from 'react';
import {
  AlertCircle,
  Clock,
  CheckCircle2,
  Filter,
  Plus,
  Wrench,
  X,
  Check
} from 'lucide-react';
import { MOCK_COMPLAINTS } from '../../data/mockData';
import { Complaint } from '../../types';

export const ComplaintsPage: React.FC = () => {
  const [complaints, setComplaints] = useState<Complaint[]>(MOCK_COMPLAINTS);
  const [filterStatus, setFilterStatus] = useState<string>('all');
  const [filterPriority, setFilterPriority] = useState<string>('all');
  const [toast, setToast] = useState<string | null>(null);

  const filtered = complaints.filter((c) => {
    const matchesStatus = filterStatus === 'all' || c.status === filterStatus;
    const matchesPriority = filterPriority === 'all' || c.priority === filterPriority;
    return matchesStatus && matchesPriority;
  });

  const updateStatus = (id: string, newStatus: 'En cours' | 'Résolu') => {
    setComplaints((prev) =>
      prev.map((c) => (c.id === id ? { ...c, status: newStatus } : c))
    );
    setToast(`Statut du ticket mis à jour : ${newStatus}`);
    setTimeout(() => setToast(null), 3000);
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
            Gestion des Réclamations & Incidents
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Suivi des pannes dans les parties communes, dysfonctionnements et interventions techniques.
          </p>
        </div>

        {/* Filters */}
        <div className="flex items-center space-x-2">
          <select
            value={filterStatus}
            onChange={(e) => setFilterStatus(e.target.value)}
            className="px-3 py-2 text-xs rounded-xl bg-white border border-slate-200 text-slate-700 shadow-xs focus:outline-none"
          >
            <option value="all">Tous les états</option>
            <option value="Nouveau">Nouveau</option>
            <option value="En cours">En cours</option>
            <option value="Résolu">Résolu</option>
          </select>

          <select
            value={filterPriority}
            onChange={(e) => setFilterPriority(e.target.value)}
            className="px-3 py-2 text-xs rounded-xl bg-white border border-slate-200 text-slate-700 shadow-xs focus:outline-none"
          >
            <option value="all">Toutes priorités</option>
            <option value="Urgente">Urgente</option>
            <option value="Moyenne">Moyenne</option>
            <option value="Basse">Basse</option>
          </select>
        </div>
      </div>

      {/* Complaints List */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        {filtered.map((comp) => (
          <div
            key={comp.id}
            className="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between"
          >
            <div>
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
                  <span className="text-[11px] font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
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

              <h3 className="text-sm font-bold text-slate-900 mt-2">{comp.title}</h3>
              <p className="text-xs text-slate-600 mt-1.5 leading-relaxed">{comp.description}</p>
            </div>

            <div className="mt-4 pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
              <div className="text-slate-400 text-[11px]">
                Par <strong className="text-slate-700">{comp.residentName}</strong> ({comp.apartment}) • {comp.date}
              </div>

              <div className="flex items-center space-x-1.5">
                {comp.status !== 'Résolu' && (
                  <button
                    onClick={() => updateStatus(comp.id, 'Résolu')}
                    className="px-2.5 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 font-semibold rounded-lg text-xs flex items-center space-x-1 transition-colors"
                  >
                    <CheckCircle2 className="w-3.5 h-3.5" />
                    <span>Clôturer</span>
                  </button>
                )}
                {comp.status === 'Nouveau' && (
                  <button
                    onClick={() => updateStatus(comp.id, 'En cours')}
                    className="px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 font-semibold rounded-lg text-xs flex items-center space-x-1 transition-colors"
                  >
                    <Wrench className="w-3.5 h-3.5" />
                    <span>Prendre en charge</span>
                  </button>
                )}
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};
