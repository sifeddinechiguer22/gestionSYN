import React from 'react';
import {
  Home,
  Car,
  Box,
  Layers,
  FileCheck,
  Zap,
  Droplets,
  Calendar,
  Users
} from 'lucide-react';
import { CURRENT_RESIDENT_PROFILE, RESIDENCE_INFO } from '../../data/mockData';

export const ResidentApartmentPage: React.FC = () => {
  return (
    <div className="space-y-6 pb-12">
      {/* Header */}
      <div>
        <h1 className="text-2xl font-bold text-slate-900 tracking-tight">
          Mon Appartement & Lots Privatifs
        </h1>
        <p className="text-sm text-slate-500 mt-1">
          Fiche cadastrale, surfaces, quote-part de copropriété et équipements rattachés.
        </p>
      </div>

      {/* Hero Overview */}
      <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
          <div className="flex items-center space-x-3">
            <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center font-bold">
              <Home className="w-6 h-6" />
            </div>
            <div>
              <div className="flex items-center space-x-2">
                <h2 className="text-lg font-bold text-slate-900">
                  Lot n° 204 — {CURRENT_RESIDENT_PROFILE.building}
                </h2>
                <span className="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2 py-0.5 rounded-full">
                  Propriétaire occupant
                </span>
              </div>
              <p className="text-xs text-slate-500 mt-0.5">
                {RESIDENCE_INFO.name}, {RESIDENCE_INFO.address}, {RESIDENCE_INFO.city}
              </p>
            </div>
          </div>

          <div className="text-right sm:border-l sm:border-slate-100 sm:pl-6">
            <span className="text-xs text-slate-400 block">Quote-part tantièmes</span>
            <span className="text-xl font-extrabold text-emerald-700 font-mono">
              {CURRENT_RESIDENT_PROFILE.tantiemes}
            </span>
            <span className="text-[10px] text-slate-500 block">soit 2.45% des voix en AG</span>
          </div>
        </div>

        {/* Detailed specs */}
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100">
            <span className="text-xs text-slate-400 block">Typologie</span>
            <span className="text-base font-bold text-slate-900 mt-1 block">F4 (4 pièces)</span>
            <span className="text-[11px] text-slate-500">Salon + 3 chambres + cuisine</span>
          </div>

          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100">
            <span className="text-xs text-slate-400 block">Surface habitable</span>
            <span className="text-base font-bold text-slate-900 mt-1 block">118 m²</span>
            <span className="text-[11px] text-slate-500">+ 12 m² balcon terrasse</span>
          </div>

          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100">
            <span className="text-xs text-slate-400 block">Niveau & Accès</span>
            <span className="text-base font-bold text-slate-900 mt-1 block">2ème étage</span>
            <span className="text-[11px] text-slate-500">Desservi par ascenseur n° 2</span>
          </div>

          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100">
            <span className="text-xs text-slate-400 block">Charges de copropriété</span>
            <span className="text-base font-bold text-indigo-600 mt-1 block">800 MAD / mois</span>
            <span className="text-[11px] text-slate-500">Payable avant le 10 du mois</span>
          </div>
        </div>
      </div>

      {/* Annexes & Compteurs */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Annexes rattachées */}
        <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
          <h3 className="text-base font-bold text-slate-900 flex items-center space-x-2">
            <Car className="w-5 h-5 text-emerald-600" />
            <span>Dépendances & Stationnement Privatifs</span>
          </h3>

          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-3">
            <div className="flex items-start justify-between">
              <div>
                <span className="text-xs font-bold text-slate-900 block">Place de Parking Sous-sol</span>
                <p className="text-xs text-slate-500 mt-0.5">Emplacement numéroté P-18 (Niveau -1)</p>
                <span className="text-[10px] text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded font-medium mt-1 inline-block">
                  Badge télécommande n° TC-094
                </span>
              </div>
              <span className="text-xs font-bold text-slate-700">Lot #P18</span>
            </div>
          </div>

          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-3">
            <div className="flex items-start justify-between">
              <div>
                <span className="text-xs font-bold text-slate-900 block">Cave & Box de rangement</span>
                <p className="text-xs text-slate-500 mt-0.5">Local fermé en sous-sol n° C-12 (8 m²)</p>
                <span className="text-[10px] text-slate-600 bg-slate-200 px-2 py-0.5 rounded font-medium mt-1 inline-block">
                  Clé sécurisée n° 44-A
                </span>
              </div>
              <span className="text-xs font-bold text-slate-700">Lot #C12</span>
            </div>
          </div>
        </div>

        {/* Compteurs & Installations */}
        <div className="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
          <h3 className="text-base font-bold text-slate-900 flex items-center space-x-2">
            <Zap className="w-5 h-5 text-amber-500" />
            <span>Compteurs Individuels & Références</span>
          </h3>

          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-2 text-xs">
            <div className="flex justify-between items-center">
              <span className="text-slate-600 flex items-center">
                <Droplets className="w-3.5 h-3.5 text-sky-500 mr-1.5" />
                Compteur Eau (LYDEC)
              </span>
              <span className="font-mono font-bold text-slate-800">CPT-EAU-889123</span>
            </div>
            <p className="text-[11px] text-slate-400">Emplacement : Gaine palière droite 2ème étage</p>
          </div>

          <div className="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-2 text-xs">
            <div className="flex justify-between items-center">
              <span className="text-slate-600 flex items-center">
                <Zap className="w-3.5 h-3.5 text-amber-500 mr-1.5" />
                Compteur Électricité (LYDEC)
              </span>
              <span className="font-mono font-bold text-slate-800">CPT-ELEC-440219</span>
            </div>
            <p className="text-[11px] text-slate-400">Puissance souscrite : 6 kVA monophasé</p>
          </div>

          <div className="p-3 bg-indigo-50 border border-indigo-100 rounded-xl text-xs text-indigo-800">
            En cas d'anomalie sur les compteurs privatifs, contactez directement l'astreinte technique ou le syndic.
          </div>
        </div>
      </div>
    </div>
  );
};
