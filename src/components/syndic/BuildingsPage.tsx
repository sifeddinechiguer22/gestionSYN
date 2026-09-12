import React, { useState } from 'react';
import {
  Building,
  Home,
  CheckCircle2,
  Users,
  Layers,
  Sparkles,
  ArrowUpRight,
  Shield,
  Phone
} from 'lucide-react';
import { RESIDENCE_INFO } from '../../data/mockData';

export const BuildingsPage: React.FC = () => {
  const [selectedBuilding, setSelectedBuilding] = useState<'all' | 'A' | 'B' | 'C'>('all');

  const buildingsData = [
    {
      id: 'A',
      name: 'Bâtiment A — Mimosa',
      floors: 5,
      apartmentsCount: 16,
      occupancy: '16 / 16 (100%)',
      elevatorStatus: 'Opérationnel',
      caretaker: 'M. Hassan (Gardien jour)',
      caretakerPhone: '+212 6 60 11 22 44',
      apartments: [
        { code: 'A-001', floor: 0, res: 'Houda Mezouar', status: 'Occupé' },
        { code: 'A-101', floor: 1, res: 'Karim Bennani', status: 'Occupé' },
        { code: 'A-102', floor: 1, res: 'Sami Chami', status: 'Occupé' },
        { code: 'A-201', floor: 2, res: 'Nadia Kabbaj', status: 'Occupé' },
        { code: 'A-302', floor: 3, res: 'Omar Tazi', status: 'Occupé' },
        { code: 'A-402', floor: 4, res: 'Tariq Filali', status: 'Occupé' },
      ]
    },
    {
      id: 'B',
      name: 'Bâtiment B — Jasmin',
      floors: 5,
      apartmentsCount: 16,
      occupancy: '15 / 16 (94%)',
      elevatorStatus: 'En maintenance (Technicien en route)',
      caretaker: 'M. Brahim (Gardien nuit)',
      caretakerPhone: '+212 6 60 33 44 55',
      apartments: [
        { code: 'B-103', floor: 1, res: 'Amina Berrada', status: 'Occupé' },
        { code: 'B-204', floor: 2, res: 'Fatima-Zahra El Mansouri', status: 'Occupé' },
        { code: 'B-302', floor: 3, res: 'Rachid Tahiri', status: 'Occupé' },
        { code: 'B-401', floor: 4, res: 'Mehdi Chraibi', status: 'Occupé' },
        { code: 'B-404', floor: 4, res: 'Vacant (En rénovation)', status: 'Vacant' },
      ]
    },
    {
      id: 'C',
      name: 'Bâtiment C — Olivier',
      floors: 4,
      apartmentsCount: 16,
      occupancy: '15 / 16 (94%)',
      elevatorStatus: 'Opérationnel',
      caretaker: 'M. Hassan (Gardien jour)',
      caretakerPhone: '+212 6 60 11 22 44',
      apartments: [
        { code: 'C-002', floor: 0, res: 'Salma Amrani', status: 'Occupé' },
        { code: 'C-104', floor: 1, res: 'Zineb Slaoui', status: 'Occupé' },
        { code: 'C-301', floor: 3, res: 'Youssef Alaoui', status: 'Occupé' },
        { code: 'C-304', floor: 3, res: 'Vacant (Mise en vente)', status: 'Vacant' },
      ]
    }
  ];

  const filteredBuildings =
    selectedBuilding === 'all'
      ? buildingsData
      : buildingsData.filter((b) => b.id === selectedBuilding);

  return (
    <div className="space-y-6 pb-12">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
            Structure Immobilière & Bâtiments
          </h1>
          <p className="text-sm text-slate-500 mt-1">
            Visualisation des 3 blocs, lots privatifs et équipements des parties communes.
          </p>
        </div>

        {/* Filter buttons */}
        <div className="flex bg-white p-1 rounded-xl border border-slate-200 shadow-xs text-xs">
          <button
            onClick={() => setSelectedBuilding('all')}
            className={`px-3 py-1.5 rounded-lg font-semibold transition-all ${
              selectedBuilding === 'all' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'
            }`}
          >
            Tous (3)
          </button>
          <button
            onClick={() => setSelectedBuilding('A')}
            className={`px-3 py-1.5 rounded-lg font-semibold transition-all ${
              selectedBuilding === 'A' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'
            }`}
          >
            Bâtiment A
          </button>
          <button
            onClick={() => setSelectedBuilding('B')}
            className={`px-3 py-1.5 rounded-lg font-semibold transition-all ${
              selectedBuilding === 'B' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'
            }`}
          >
            Bâtiment B
          </button>
          <button
            onClick={() => setSelectedBuilding('C')}
            className={`px-3 py-1.5 rounded-lg font-semibold transition-all ${
              selectedBuilding === 'C' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'
            }`}
          >
            Bâtiment C
          </button>
        </div>
      </div>

      {/* Building Cards */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {filteredBuildings.map((building) => (
          <div
            key={building.id}
            className="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between"
          >
            <div className="p-5 border-b border-slate-100 bg-slate-50/50">
              <div className="flex items-center justify-between">
                <span className="text-xs font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 border border-indigo-200/60 px-2.5 py-0.5 rounded-md">
                  Bloc {building.id}
                </span>
                <span className="text-xs text-slate-500 font-medium">{building.floors} étages</span>
              </div>
              <h3 className="text-lg font-bold text-slate-900 mt-2">{building.name}</h3>
              <p className="text-xs text-slate-500 mt-0.5">16 appartements • Taux : {building.occupancy}</p>
            </div>

            <div className="p-5 space-y-4 flex-1">
              {/* Equipments */}
              <div className="space-y-2">
                <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Équipements</span>
                <div className="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs space-y-1.5">
                  <div className="flex justify-between items-center">
                    <span className="text-slate-600">Ascenseur Schindler</span>
                    <span
                      className={`text-[11px] font-semibold px-2 py-0.5 rounded-full ${
                        building.elevatorStatus === 'Opérationnel'
                          ? 'bg-emerald-50 text-emerald-700'
                          : 'bg-amber-50 text-amber-700'
                      }`}
                    >
                      {building.elevatorStatus}
                    </span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-slate-600">Surveillance</span>
                    <span className="text-slate-800 font-medium">Caméras HD palier & hall</span>
                  </div>
                </div>
              </div>

              {/* Caretaker */}
              <div className="p-3 rounded-xl bg-indigo-50/50 border border-indigo-100 text-xs">
                <div className="flex items-center justify-between">
                  <span className="font-semibold text-indigo-900">{building.caretaker}</span>
                  <a href={`tel:${building.caretakerPhone}`} className="text-indigo-600 font-bold hover:underline">
                    {building.caretakerPhone}
                  </a>
                </div>
              </div>

              {/* Lots sample */}
              <div className="space-y-2">
                <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400">Lots du bâtiment</span>
                <div className="grid grid-cols-2 gap-2">
                  {building.apartments.map((apt) => (
                    <div key={apt.code} className="p-2 rounded-lg border border-slate-100 bg-slate-50 text-xs">
                      <div className="flex justify-between font-bold text-slate-800">
                        <span>{apt.code}</span>
                        <span className="text-[10px] text-slate-400">Ét. {apt.floor}</span>
                      </div>
                      <span className="text-[11px] text-slate-500 truncate block mt-0.5">{apt.res}</span>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            <div className="p-4 border-t border-slate-100 bg-slate-50/50 text-center">
              <button className="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                Gérer tous les lots du {building.name} →
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};
