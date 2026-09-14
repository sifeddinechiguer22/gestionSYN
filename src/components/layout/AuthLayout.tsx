import React, { useState } from 'react';
import {
  Building2,
  Lock,
  Mail,
  ArrowRight,
  ShieldCheck,
  KeyRound,
  CheckCircle2,
  HelpCircle
} from 'lucide-react';
import { UserRole } from '../../types';
import { RESIDENCE_INFO } from '../../data/mockData';

interface AuthLayoutProps {
  onLoginSuccess: (role: UserRole) => void;
  onCancelAuth: () => void;
}

export const AuthLayout: React.FC<AuthLayoutProps> = ({
  onLoginSuccess,
  onCancelAuth,
}) => {
  const [activeTab, setActiveTab] = useState<'login' | 'register'>('login');
  const [selectedRole, setSelectedRole] = useState<UserRole>('syndic');
  const [email, setEmail] = useState('syndic@residence-atlas.ma');
  const [password, setPassword] = useState('••••••••••••');
  const [apartmentCode, setApartmentCode] = useState('ATLAS-B204-9872');
  const [rememberMe, setRememberMe] = useState(true);
  const [submittedMessage, setSubmittedMessage] = useState<string | null>(null);

  const handleRoleChange = (role: UserRole) => {
    setSelectedRole(role);
    if (role === 'syndic') {
      setEmail('syndic@residence-atlas.ma');
    } else {
      setEmail('fz.elmansouri@email.com');
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setSubmittedMessage('Connexion en cours...');
    setTimeout(() => {
      onLoginSuccess(selectedRole);
    }, 400);
  };

  return (
    <div className="min-h-screen bg-slate-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
      {/* Subtle architectural background texture */}
      <div className="absolute inset-0 opacity-10 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none" />
      
      {/* Decorative gradient glow */}
      <div className="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none" />
      <div className="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none" />

      {/* Return button */}
      <div className="absolute top-6 left-6 z-20">
        <button
          onClick={onCancelAuth}
          className="text-xs font-medium text-slate-400 hover:text-white bg-slate-800/80 hover:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-700 transition-colors flex items-center space-x-1.5"
        >
          <span>← Retour à la démo</span>
        </button>
      </div>

      <div className="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        {/* Brand header */}
        <div className="flex justify-center">
          <div className="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-sky-500 flex items-center justify-center text-white shadow-xl shadow-indigo-600/30">
            <Building2 className="w-8 h-8" />
          </div>
        </div>

        <h2 className="mt-4 text-center text-2xl font-extrabold tracking-tight text-white">
          SyndicPro
        </h2>
        <p className="mt-1 text-center text-sm text-slate-400">
          Plateforme de gestion pour <span className="text-slate-200 font-semibold">{RESIDENCE_INFO.name}</span>
        </p>

        {/* Tab switcher: Connexion vs Activation */}
        <div className="mt-6 flex bg-slate-800/90 p-1 rounded-xl border border-slate-700/80">
          <button
            type="button"
            onClick={() => setActiveTab('login')}
            className={`flex-1 py-2 text-xs font-semibold rounded-lg transition-all ${
              activeTab === 'login'
                ? 'bg-indigo-600 text-white shadow-xs'
                : 'text-slate-400 hover:text-white'
            }`}
          >
            Se connecter
          </button>
          <button
            type="button"
            onClick={() => setActiveTab('register')}
            className={`flex-1 py-2 text-xs font-semibold rounded-lg transition-all ${
              activeTab === 'register'
                ? 'bg-indigo-600 text-white shadow-xs'
                : 'text-slate-400 hover:text-white'
            }`}
          >
            Activer mon logement
          </button>
        </div>
      </div>

      <div className="mt-6 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div className="bg-slate-800/60 backdrop-blur-md py-8 px-6 shadow-2xl shadow-black/40 border border-slate-700/70 sm:rounded-2xl sm:px-10">
          {activeTab === 'login' ? (
            <form className="space-y-5" onSubmit={handleSubmit}>
              {/* Role selection toggle */}
              <div>
                <label className="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                  Type d'accès
                </label>
                <div className="grid grid-cols-2 gap-3">
                  <button
                    type="button"
                    onClick={() => handleRoleChange('syndic')}
                    className={`flex items-center justify-center space-x-2 py-2.5 px-3 rounded-xl border text-xs font-semibold transition-all ${
                      selectedRole === 'syndic'
                        ? 'bg-indigo-600/20 border-indigo-500 text-white ring-1 ring-indigo-500'
                        : 'bg-slate-900/60 border-slate-700 text-slate-400 hover:text-slate-200'
                    }`}
                  >
                    <ShieldCheck className="w-4 h-4 text-indigo-400" />
                    <span>Syndic / Admin</span>
                  </button>

                  <button
                    type="button"
                    onClick={() => handleRoleChange('resident')}
                    className={`flex items-center justify-center space-x-2 py-2.5 px-3 rounded-xl border text-xs font-semibold transition-all ${
                      selectedRole === 'resident'
                        ? 'bg-emerald-600/20 border-emerald-500 text-white ring-1 ring-emerald-500'
                        : 'bg-slate-900/60 border-slate-700 text-slate-400 hover:text-slate-200'
                    }`}
                  >
                    <KeyRound className="w-4 h-4 text-emerald-400" />
                    <span>Copropriétaire / Résident</span>
                  </button>
                </div>
              </div>

              {/* Email */}
              <div>
                <label className="block text-xs font-medium text-slate-300 mb-1.5">
                  Adresse e-mail
                </label>
                <div className="relative">
                  <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <Mail className="w-4 h-4" />
                  </div>
                  <input
                    type="email"
                    required
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="block w-full pl-10 pr-3 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all"
                    placeholder="nom@exemple.com"
                  />
                </div>
              </div>

              {/* Password */}
              <div>
                <div className="flex items-center justify-between mb-1.5">
                  <label className="block text-xs font-medium text-slate-300">
                    Mot de passe
                  </label>
                  <a
                    href="#forgot"
                    onClick={(e) => {
                      e.preventDefault();
                      alert('Un lien de réinitialisation a été envoyé à votre adresse.');
                    }}
                    className="text-xs font-medium text-indigo-400 hover:text-indigo-300 transition-colors"
                  >
                    Mot de passe oublié ?
                  </a>
                </div>
                <div className="relative">
                  <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <Lock className="w-4 h-4" />
                  </div>
                  <input
                    type="password"
                    required
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="block w-full pl-10 pr-3 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all"
                    placeholder="••••••••"
                  />
                </div>
              </div>

              {/* Remember me checkbox */}
              <div className="flex items-center justify-between">
                <label className="flex items-center space-x-2 cursor-pointer">
                  <input
                    type="checkbox"
                    checked={rememberMe}
                    onChange={(e) => setRememberMe(e.target.checked)}
                    className="rounded bg-slate-900 border-slate-700 text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                  />
                  <span className="text-xs text-slate-300">Se souvenir de ma session</span>
                </label>
              </div>

              {/* Submit Button */}
              <div>
                <button
                  type="submit"
                  id="auth-submit-button"
                  className={`w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-bold text-white shadow-lg transition-all ${
                    selectedRole === 'syndic'
                      ? 'bg-indigo-600 hover:bg-indigo-500 shadow-indigo-600/30'
                      : 'bg-emerald-600 hover:bg-emerald-500 shadow-emerald-600/30'
                  }`}
                >
                  <span>Accéder à l'espace {selectedRole === 'syndic' ? 'Syndic' : 'Résident'}</span>
                  <ArrowRight className="w-4 h-4 ml-2" />
                </button>
              </div>

              {/* Quick pre-fill quick jump buttons for fast tester evaluation */}
              <div className="pt-3 border-t border-slate-700/80">
                <p className="text-[11px] text-slate-400 text-center mb-2 font-medium">
                  Raccourcis de test immédiat :
                </p>
                <div className="grid grid-cols-2 gap-2">
                  <button
                    type="button"
                    onClick={() => onLoginSuccess('syndic')}
                    className="py-1.5 px-2 bg-slate-700/60 hover:bg-slate-700 text-slate-200 text-xs rounded-lg border border-slate-600/60 font-medium transition-colors"
                  >
                    ⚡ Ouvrir Vue Syndic
                  </button>
                  <button
                    type="button"
                    onClick={() => onLoginSuccess('resident')}
                    className="py-1.5 px-2 bg-slate-700/60 hover:bg-slate-700 text-slate-200 text-xs rounded-lg border border-slate-600/60 font-medium transition-colors"
                  >
                    ⚡ Ouvrir Vue Résident
                  </button>
                </div>
              </div>
            </form>
          ) : (
            <div className="space-y-4">
              <div className="p-3 bg-indigo-500/10 border border-indigo-500/20 rounded-xl text-xs text-indigo-300 flex items-start space-x-2">
                <HelpCircle className="w-4 h-4 shrink-0 mt-0.5" />
                <span>
                  Le code d'activation vous a été remis par le bureau du syndic lors de la remise des clés ou sur votre appel de fonds.
                </span>
              </div>

              <div>
                <label className="block text-xs font-medium text-slate-300 mb-1.5">
                  Code d'activation du lot
                </label>
                <input
                  type="text"
                  value={apartmentCode}
                  onChange={(e) => setApartmentCode(e.target.value)}
                  className="block w-full px-3 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-sm font-mono text-white tracking-wide uppercase focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
                  placeholder="EX: ATLAS-B204-XXXX"
                />
              </div>

              <div>
                <label className="block text-xs font-medium text-slate-300 mb-1.5">
                  Votre nom complet
                </label>
                <input
                  type="text"
                  defaultValue="Fatima-Zahra El Mansouri"
                  className="block w-full px-3 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
                />
              </div>

              <div>
                <label className="block text-xs font-medium text-slate-300 mb-1.5">
                  Créer un mot de passe sécurisé
                </label>
                <input
                  type="password"
                  defaultValue="Motdepasse123!"
                  className="block w-full px-3 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
                />
              </div>

              <button
                type="button"
                onClick={() => onLoginSuccess('resident')}
                className="w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg shadow-emerald-600/30 transition-all mt-4"
              >
                <span>Valider et accéder à mon espace</span>
                <CheckCircle2 className="w-4 h-4 ml-2" />
              </button>
            </div>
          )}
        </div>

        {/* Footer info */}
        <p className="text-center text-xs text-slate-400 mt-6">
          © 2026 SyndicPro — Développé pour la copropriété {RESIDENCE_INFO.name}.
        </p>
      </div>
    </div>
  );
};
