import React from 'react';
import {
  LayoutDashboard,
  Building2,
  Building,
  Home,
  Users,
  CreditCard,
  Receipt,
  AlertCircle,
  FileText,
  Megaphone,
  Bell,
  User,
  LogOut,
  X
} from 'lucide-react';

interface SidebarProps {
  currentTab: string;
  onSelectTab: (tabId: string) => void;
  isOpenMobile: boolean;
  onCloseMobile: () => void;
  onLogout: () => void;
}

export const SyndicSidebar: React.FC<SidebarProps> = ({
  currentTab,
  onSelectTab,
  isOpenMobile,
  onCloseMobile,
  onLogout,
}) => {
  const navSections = [
    {
      title: 'Principal',
      items: [
        { id: 'dashboard', label: 'Dashboard', icon: LayoutDashboard },
        { id: 'residence', label: 'Résidence', icon: Building2 },
        { id: 'batiments', label: 'Bâtiments', icon: Building },
        { id: 'appartements', label: 'Appartements', icon: Home },
        { id: 'residents', label: 'Résidents', icon: Users, badge: '84' },
      ],
    },
    {
      title: 'Finances & Incidents',
      items: [
        { id: 'paiements', label: 'Paiements', icon: CreditCard, badge: '38/48' },
        { id: 'depenses', label: 'Dépenses', icon: Receipt },
        { id: 'reclamations', label: 'Réclamations', icon: AlertCircle, badge: '4', badgeColor: 'bg-rose-100 text-rose-700' },
      ],
    },
    {
      title: 'Communication',
      items: [
        { id: 'documents', label: 'Documents', icon: FileText },
        { id: 'annonces', label: 'Annonces', icon: Megaphone, badge: 'Nouveau', badgeColor: 'bg-amber-100 text-amber-800' },
        { id: 'notifications', label: 'Notifications', icon: Bell, badge: '2', badgeColor: 'bg-indigo-100 text-indigo-700' },
      ],
    },
    {
      title: 'Paramètres',
      items: [
        { id: 'profil', label: 'Profil Syndic', icon: User },
      ],
    },
  ];

  return (
    <>
      {/* Mobile Backdrop */}
      {isOpenMobile && (
        <div
          className="fixed inset-0 bg-slate-900/60 z-40 lg:hidden backdrop-blur-xs transition-opacity"
          onClick={onCloseMobile}
        />
      )}

      {/* Sidebar Container */}
      <aside
        id="syndic-sidebar"
        className={`fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col border-r border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0 ${
          isOpenMobile ? 'translate-x-0' : '-translate-x-full'
        }`}
      >
        {/* Brand Header */}
        <div className="h-16 flex items-center justify-between px-5 border-b border-slate-800 bg-slate-950/40">
          <div className="flex items-center space-x-3">
            <div className="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-sky-500 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-500/20">
              <Building2 className="w-5 h-5" />
            </div>
            <div>
              <span className="font-bold text-white text-base tracking-tight block">SyndicPro</span>
              <span className="text-xs text-slate-400 font-medium truncate block max-w-[130px]">
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

        {/* Residence switcher pill */}
        <div className="px-4 py-3 border-b border-slate-800/80 bg-slate-900/50">
          <div className="flex items-center justify-between px-3 py-2 rounded-lg bg-slate-800/80 border border-slate-700/60 text-xs">
            <div className="flex items-center space-x-2">
              <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
              <span className="text-slate-200 font-medium truncate max-w-[140px]">Copropriété Active</span>
            </div>
            <span className="text-slate-400 text-[10px] uppercase font-semibold px-1.5 py-0.5 bg-slate-700 rounded">
              3 BÂT.
            </span>
          </div>
        </div>

        {/* Navigation Items */}
        <div className="flex-1 overflow-y-auto px-3 py-4 space-y-6 custom-scrollbar">
          {navSections.map((section) => (
            <div key={section.title} className="space-y-1">
              <div className="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">
                {section.title}
              </div>
              {section.items.map((item) => {
                const IconComponent = item.icon;
                const isActive = currentTab === item.id;
                return (
                  <button
                    key={item.id}
                    id={`nav-item-${item.id}`}
                    onClick={() => {
                      onSelectTab(item.id);
                      onCloseMobile();
                    }}
                    className={`w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all group ${
                      isActive
                        ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30 font-semibold'
                        : 'text-slate-400 hover:text-white hover:bg-slate-800/70'
                    }`}
                  >
                    <div className="flex items-center space-x-3">
                      <IconComponent
                        className={`w-4 h-4 transition-colors ${
                          isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-200'
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
                            ? 'bg-indigo-700 text-white'
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
          ))}
        </div>

        {/* User Footer & Logout */}
        <div className="p-3 border-t border-slate-800 bg-slate-950/30">
          <div className="flex items-center justify-between p-2 rounded-lg bg-slate-800/40 hover:bg-slate-800/80 transition-colors">
            <div className="flex items-center space-x-3 overflow-hidden">
              <div className="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-bold text-xs shrink-0">
                SY
              </div>
              <div className="truncate text-left">
                <p className="text-xs font-semibold text-white truncate">Admin Syndic</p>
                <p className="text-[11px] text-slate-400 truncate">Bureau Gestionnaire</p>
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
