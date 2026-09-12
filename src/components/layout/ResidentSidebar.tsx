import React from 'react';
import {
  LayoutDashboard,
  Home,
  CreditCard,
  AlertCircle,
  FileText,
  Megaphone,
  Bell,
  User,
  LogOut,
  X,
  KeyRound
} from 'lucide-react';
import { CURRENT_RESIDENT_PROFILE } from '../../data/mockData';

interface ResidentSidebarProps {
  currentTab: string;
  onSelectTab: (tabId: string) => void;
  isOpenMobile: boolean;
  onCloseMobile: () => void;
  onLogout: () => void;
}

export const ResidentSidebar: React.FC<ResidentSidebarProps> = ({
  currentTab,
  onSelectTab,
  isOpenMobile,
  onCloseMobile,
  onLogout,
}) => {
  const residentNavItems = [
    { id: 'dashboard', label: 'Dashboard', icon: LayoutDashboard },
    { id: 'appartement', label: 'Mon appartement', icon: Home, badge: CURRENT_RESIDENT_PROFILE.apartment },
    { id: 'paiements', label: 'Mes paiements', icon: CreditCard, badge: 'À jour', badgeColor: 'bg-emerald-500/20 text-emerald-300' },
    { id: 'reclamations', label: 'Mes réclamations', icon: AlertCircle, badge: '1 en cours', badgeColor: 'bg-amber-500/20 text-amber-300' },
    { id: 'documents', label: 'Documents', icon: FileText },
    { id: 'annonces', label: 'Annonces', icon: Megaphone, badge: 'Nouveau', badgeColor: 'bg-emerald-500/20 text-emerald-300' },
    { id: 'notifications', label: 'Notifications', icon: Bell },
    { id: 'profil', label: 'Profil', icon: User },
  ];

  return (
    <>
      {/* Mobile Backdrop */}
      {isOpenMobile && (
        <div
          className="fixed inset-0 bg-slate-950/70 z-40 lg:hidden backdrop-blur-xs transition-opacity"
          onClick={onCloseMobile}
        />
      )}

      {/* Sidebar Container */}
      <aside
        id="resident-sidebar"
        className={`fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 text-slate-200 flex flex-col border-r border-emerald-950/40 transition-transform duration-300 ease-in-out lg:translate-x-0 ${
          isOpenMobile ? 'translate-x-0' : '-translate-x-full'
        }`}
      >
        {/* Brand Header */}
        <div className="h-16 flex items-center justify-between px-5 border-b border-slate-800 bg-emerald-950/30">
          <div className="flex items-center space-x-3">
            <div className="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold shadow-md shadow-emerald-500/20">
              <KeyRound className="w-5 h-5" />
            </div>
            <div>
              <div className="flex items-center space-x-1.5">
                <span className="font-bold text-white text-base tracking-tight">Espace Résident</span>
              </div>
              <span className="text-xs text-emerald-400 font-medium block truncate max-w-[130px]">
                Jardins d'Atlas
              </span>
            </div>
          </div>

          <button
            onClick={onCloseMobile}
            className="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800"
            aria-label="Fermer le menu"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        {/* Resident Lot Identity Badge */}
        <div className="px-4 py-3 border-b border-slate-800/80 bg-slate-900/60">
          <div className="p-2.5 rounded-xl bg-gradient-to-r from-slate-800/90 to-emerald-950/40 border border-emerald-500/20 text-xs">
            <div className="flex items-center justify-between">
              <span className="text-slate-400 text-[11px] font-medium">Logement</span>
              <span className="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider px-1.5 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20">
                Copropriétaire
              </span>
            </div>
            <div className="mt-1 font-bold text-white text-sm">
              {CURRENT_RESIDENT_PROFILE.building} • {CURRENT_RESIDENT_PROFILE.apartment}
            </div>
            <div className="text-[11px] text-slate-400 mt-0.5">
              Étage {CURRENT_RESIDENT_PROFILE.floor} • 118 m² (F4)
            </div>
          </div>
        </div>

        {/* Navigation Items */}
        <div className="flex-1 overflow-y-auto px-3 py-4 space-y-1 custom-scrollbar">
          <div className="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">
            Menu Résident
          </div>
          {residentNavItems.map((item) => {
            const IconComponent = item.icon;
            const isActive = currentTab === item.id;
            return (
              <button
                key={item.id}
                id={`res-nav-${item.id}`}
                onClick={() => {
                  onSelectTab(item.id);
                  onCloseMobile();
                }}
                className={`w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all group ${
                  isActive
                    ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/30 font-semibold'
                    : 'text-slate-400 hover:text-white hover:bg-slate-800/70'
                }`}
              >
                <div className="flex items-center space-x-3">
                  <IconComponent
                    className={`w-4 h-4 transition-colors ${
                      isActive ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400'
                    }`}
                  />
                  <span>{item.label}</span>
                </div>

                {item.badge && (
                  <span
                    className={`text-[11px] px-2 py-0.5 rounded-full font-medium ${
                      item.badgeColor
                        ? item.badgeColor
                        : isActive
                        ? 'bg-emerald-700 text-white'
                        : 'bg-slate-800 text-slate-300'
                    }`}
                  >
                    {item.badge}
                  </span>
                )}
              </button>
            );
          })}
        </div>

        {/* Resident Footer info & Logout */}
        <div className="p-3 border-t border-slate-800 bg-slate-950/40">
          <div className="flex items-center justify-between p-2 rounded-lg bg-slate-800/40 hover:bg-slate-800/80 transition-colors">
            <div className="flex items-center space-x-3 overflow-hidden">
              <div className="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 flex items-center justify-center font-bold text-xs shrink-0">
                FZ
              </div>
              <div className="truncate text-left">
                <p className="text-xs font-semibold text-white truncate">{CURRENT_RESIDENT_PROFILE.name}</p>
                <p className="text-[11px] text-emerald-400 truncate">Apt. {CURRENT_RESIDENT_PROFILE.apartment}</p>
              </div>
            </div>
            <button
              onClick={onLogout}
              title="Déconnexion"
              className="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-md transition-colors"
              aria-label="Déconnexion"
            >
              <LogOut className="w-4 h-4" />
            </button>
          </div>
        </div>
      </aside>
    </>
  );
};
