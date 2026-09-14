import React, { useState } from 'react';
import {
  User,
  Mail,
  Phone,
  Building,
  Shield,
  CheckCircle2,
  X,
  Lock,
  Save
} from 'lucide-react';
import { UserRole } from '../../types';
import { CURRENT_RESIDENT_PROFILE, RESIDENCE_INFO } from '../../data/mockData';

interface ProfileModalProps {
  role: UserRole;
  isOpen: boolean;
  onClose: () => void;
}

export const ProfileModal: React.FC<ProfileModalProps> = ({
  role,
  isOpen,
  onClose,
}) => {
  const isSyndic = role === 'syndic';
  const [name, setName] = useState(
    isSyndic ? 'Bureau du Syndic — Administration' : CURRENT_RESIDENT_PROFILE.name
  );
  const [email, setEmail] = useState(
    isSyndic ? 'contact@syndic-atlas.ma' : CURRENT_RESIDENT_PROFILE.email
  );
  const [phone, setPhone] = useState(
    isSyndic ? '+212 5 22 99 88 77' : CURRENT_RESIDENT_PROFILE.phone
  );
  const [saved, setSaved] = useState(false);

  if (!isOpen) return null;

  const handleSave = (e: React.FormEvent) => {
    e.preventDefault();
    setSaved(true);
    setTimeout(() => {
      setSaved(false);
      onClose();
    }, 1200);
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
      <div className="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-slate-200 animate-in fade-in zoom-in-95 duration-150">
        <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <User className="w-5 h-5 text-indigo-600" />
            <h3 className="text-base font-bold text-slate-900">
              {isSyndic ? 'Paramètres du Syndic' : 'Mon Profil Résident'}
            </h3>
          </div>
          <button onClick={onClose} className="p-1 rounded-lg text-slate-400 hover:text-slate-600">
            <X className="w-5 h-5" />
          </button>
        </div>

        {saved && (
          <div className="m-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-center space-x-2">
            <CheckCircle2 className="w-4 h-4 text-emerald-600" />
            <span>Vos informations ont été mises à jour avec succès !</span>
          </div>
        )}

        <form onSubmit={handleSave} className="p-6 space-y-4">
          <div className="flex items-center space-x-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
            <div
              className={`w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg ${
                isSyndic ? 'bg-indigo-600' : 'bg-emerald-600'
              }`}
            >
              {isSyndic ? 'SY' : 'FZ'}
            </div>
            <div>
              <h4 className="text-sm font-bold text-slate-900">{name}</h4>
              <p className="text-xs text-slate-500">
                {isSyndic ? 'Syndic légal de la copropriété' : 'Copropriétaire résidente • Bâtiment B'}
              </p>
            </div>
          </div>

          <div>
            <label className="block text-xs font-medium text-slate-700 mb-1">Nom affiché</label>
            <input
              type="text"
              value={name}
              onChange={(e) => setName(e.target.value)}
              className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
            />
          </div>

          <div className="grid grid-cols-2 gap-3">
            <div>
              <label className="block text-xs font-medium text-slate-700 mb-1">Email</label>
              <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
              />
            </div>
            <div>
              <label className="block text-xs font-medium text-slate-700 mb-1">Téléphone</label>
              <input
                type="tel"
                value={phone}
                onChange={(e) => setPhone(e.target.value)}
                className="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200"
              />
            </div>
          </div>

          <div className="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs text-slate-500">
            Copropriété rattachée : <strong className="text-slate-800">{RESIDENCE_INFO.name}</strong>
          </div>

          <div className="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
            <button
              type="button"
              onClick={onClose}
              className="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl"
            >
              Fermer
            </button>
            <button
              type="submit"
              className="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs flex items-center space-x-1.5"
            >
              <Save className="w-3.5 h-3.5" />
              <span>Enregistrer les modifications</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};
