import React, { useState } from 'react';
import {
  Menu,
  Bell,
  Search,
  ChevronDown,
  User,
  LogOut,
  ShieldCheck,
  CheckCircle2,
  AlertTriangle,
  FileText,
  CreditCard,
  Building,
  KeyRound
} from 'lucide-react';
import { MOCK_NOTIFICATIONS, CURRENT_RESIDENT_PROFILE, RESIDENCE_INFO } from '../../data/mockData';
import { UserRole } from '../../types';

interface TopNavbarProps {
  role: UserRole;
  onToggleMobileSidebar: () => void;
  onOpenProfile: () => void;
  onSwitchRole: (role: UserRole) => void;
  onLogout: () => void;
  onSelectTab: (tabId: string) => void;
}

export const TopNavbar: React.FC<TopNavbarProps> = ({
  role,
  onToggleMobileSidebar,
  onOpenProfile,
  onSwitchRole,
  onLogout,
  onSelectTab,
}) => {
  const [showNotifications, setShowNotifications] = useState(false);
  const [showUserMenu, setShowUserMenu] = useState(false);
  const [notifications, setNotifications] = useState(MOCK_NOTIFICATIONS);

  const unreadCount = notifications.filter((n) => !n.read).length;

  const markAllRead = () => {
    setNotifications((prev) => prev.map((n) => ({ ...n, read: true })));
  };

  const isSyndic = role === 'syndic';

  return (
    <header className="sticky top-0 z-30 h-16 bg-white border-b border-slate-200/80 px-4 sm:px-6 flex items-center justify-between shadow-xs">
      {/* Left section: Mobile Hamburger & Search/Breadcrumb */}
      <div className="flex items-center space-x-3 sm:space-x-4">
        <button
          id="mobile-menu-toggle"
          onClick={onToggleMobileSidebar}
          className="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors"
          aria-label="Ouvrir le menu"
        >
          <Menu className="w-5 h-5" />
        </button>

        {/* Residence Tag & Quick info */}
        <div className="hidden sm:flex items-center space-x-2">
          <span className="flex items-center space-x-1.5 text-xs font-medium text-slate-500 bg-slate-100/90 px-2.5 py-1 rounded-full border border-slate-200">
            <Building className="w-3.5 h-3.5 text-slate-500" />
            <span className="text-slate-700 font-semibold">{RESIDENCE_INFO.name}</span>
          </span>
          {isSyndic ? (
            <span className="text-[11px] font-medium bg-indigo-50 text-indigo-700 border border-indigo-200/60 px-2 py-0.5 rounded-md flex items-center space-x-1">
              <ShieldCheck className="w-3 h-3" />
              <span>Administration</span>
            </span>
          ) : (
            <span className="text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-2 py-0.5 rounded-md flex items-center space-x-1">
              <KeyRound className="w-3 h-3" />
              <span>Lot B-204 (2ème ét.)</span>
            </span>
          )}
        </div>
      </div>

      {/* Center: Search input */}
      <div className="hidden md:flex flex-1 max-w-md mx-4">
        <div className="relative w-full">
          <Search className="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
          <input
            type="text"
            placeholder={isSyndic ? "Rechercher un résident, appartement, quittance..." : "Rechercher une annonce, un document..."}
            className="w-full pl-9 pr-4 py-1.5 text-sm rounded-lg bg-slate-100/80 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
          />
        </div>
      </div>

      {/* Right section: Quick actions, Notifications & User Dropdown */}
      <div className="flex items-center space-x-2 sm:space-x-3">
        {/* Role Switcher pill (Instant toggle between Syndic & Resident for preview demo) */}
        <div className="hidden sm:flex items-center bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
          <button
            onClick={() => onSwitchRole('syndic')}
            className={`px-2.5 py-1 rounded-md font-medium transition-all ${
              isSyndic
                ? 'bg-white text-indigo-700 shadow-xs font-semibold'
                : 'text-slate-600 hover:text-slate-900'
            }`}
          >
            Vue Syndic
          </button>
          <button
            onClick={() => onSwitchRole('resident')}
            className={`px-2.5 py-1 rounded-md font-medium transition-all ${
              !isSyndic
                ? 'bg-white text-emerald-700 shadow-xs font-semibold'
                : 'text-slate-600 hover:text-slate-900'
            }`}
          >
            Vue Résident
          </button>
        </div>

        {/* Notifications Dropdown */}
        <div className="relative">
          <button
            id="notifications-button"
            onClick={() => {
              setShowNotifications(!showNotifications);
              setShowUserMenu(false);
            }}
            className="relative p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors"
            aria-label="Notifications"
          >
            <Bell className="w-5 h-5" />
            {unreadCount > 0 && (
              <span className="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
            )}
          </button>

          {showNotifications && (
            <div className="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-50 animate-in fade-in slide-in-from-top-2 duration-150">
              <div className="flex items-center justify-between px-4 py-2 border-b border-slate-100">
                <div className="flex items-center space-x-2">
                  <span className="font-semibold text-sm text-slate-800">Notifications</span>
                  {unreadCount > 0 && (
                    <span className="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full font-medium">
                      {unreadCount} nouvelle{unreadCount > 1 ? 's' : ''}
                    </span>
                  )}
                </div>
                {unreadCount > 0 && (
                  <button
                    onClick={markAllRead}
                    className="text-xs text-indigo-600 hover:text-indigo-800 font-medium"
                  >
                    Tout marquer comme lu
                  </button>
                )}
              </div>

              <div className="max-h-72 overflow-y-auto divide-y divide-slate-100">
                {notifications.map((notif) => (
                  <div
                    key={notif.id}
                    className={`p-3.5 hover:bg-slate-50 transition-colors cursor-pointer flex items-start space-x-3 ${
                      !notif.read ? 'bg-indigo-50/30' : ''
                    }`}
                  >
                    <div
                      className={`w-8 h-8 rounded-lg flex items-center justify-center shrink-0 ${
                        notif.type === 'complaint'
                          ? 'bg-rose-100 text-rose-600'
                          : notif.type === 'payment'
                          ? 'bg-emerald-100 text-emerald-600'
                          : notif.type === 'alert'
                          ? 'bg-amber-100 text-amber-600'
                          : 'bg-indigo-100 text-indigo-600'
                      }`}
                    >
                      {notif.type === 'complaint' && <AlertTriangle className="w-4 h-4" />}
                      {notif.type === 'payment' && <CreditCard className="w-4 h-4" />}
                      {notif.type === 'alert' && <AlertTriangle className="w-4 h-4" />}
                      {notif.type === 'announcement' && <FileText className="w-4 h-4" />}
                    </div>

                    <div className="flex-1 min-w-0">
                      <div className="flex items-center justify-between">
                        <p className={`text-xs font-semibold ${!notif.read ? 'text-slate-900' : 'text-slate-700'}`}>
                          {notif.title}
                        </p>
                        <span className="text-[10px] text-slate-400">{notif.time}</span>
                      </div>
                      <p className="text-xs text-slate-600 mt-0.5 line-clamp-2">{notif.message}</p>
                    </div>
                  </div>
                ))}
              </div>

              <div className="px-4 py-2 border-t border-slate-100 bg-slate-50/50 text-center">
                <button
                  onClick={() => {
                    onSelectTab('notifications');
                    setShowNotifications(false);
                  }}
                  className="text-xs text-indigo-600 hover:text-indigo-800 font-semibold"
                >
                  Voir l'historique complet des notifications
                </button>
              </div>
            </div>
          )}
        </div>

        {/* User Profile Menu */}
        <div className="relative">
          <button
            id="user-profile-menu-button"
            onClick={() => {
              setShowUserMenu(!showUserMenu);
              setShowNotifications(false);
            }}
            className="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-slate-100 transition-colors"
          >
            <div
              className={`w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs text-white ${
                isSyndic ? 'bg-indigo-600 shadow-xs' : 'bg-emerald-600 shadow-xs'
              }`}
            >
              {isSyndic ? 'SY' : 'FZ'}
            </div>
            <div className="hidden sm:block text-left text-xs leading-tight">
              <span className="font-semibold text-slate-800 block">
                {isSyndic ? 'Syndic Pro' : CURRENT_RESIDENT_PROFILE.name.split(' ')[0]}
              </span>
              <span className="text-slate-500 text-[10px] font-medium">
                {isSyndic ? 'Bureau Syndic' : 'Résident B-204'}
              </span>
            </div>
            <ChevronDown className="w-3.5 h-3.5 text-slate-400" />
          </button>

          {showUserMenu && (
            <div className="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-1.5 z-50">
              <div className="px-3.5 py-2 border-b border-slate-100">
                <p className="text-xs font-bold text-slate-900">
                  {isSyndic ? 'Administration Syndic' : CURRENT_RESIDENT_PROFILE.name}
                </p>
                <p className="text-[11px] text-slate-500 truncate">
                  {isSyndic ? 'contact@syndic-atlas.ma' : CURRENT_RESIDENT_PROFILE.email}
                </p>
              </div>

              <div className="py-1">
                <button
                  onClick={() => {
                    onOpenProfile();
                    setShowUserMenu(false);
                  }}
                  className="w-full flex items-center space-x-2.5 px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 font-medium"
                >
                  <User className="w-4 h-4 text-slate-500" />
                  <span>Mon Profil & Paramètres</span>
                </button>

                <button
                  onClick={() => {
                    onSwitchRole(isSyndic ? 'resident' : 'syndic');
                    setShowUserMenu(false);
                  }}
                  className="w-full flex items-center space-x-2.5 px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 font-medium"
                >
                  <Building className="w-4 h-4 text-slate-500" />
                  <span>Basculer vers {isSyndic ? 'Espace Résident' : 'Espace Syndic'}</span>
                </button>
              </div>

              <div className="pt-1 border-t border-slate-100">
                <button
                  onClick={() => {
                    setShowUserMenu(false);
                    onLogout();
                  }}
                  className="w-full flex items-center space-x-2.5 px-3.5 py-2 text-xs text-rose-600 hover:bg-rose-50 font-medium"
                >
                  <LogOut className="w-4 h-4 text-rose-500" />
                  <span>Déconnexion</span>
                </button>
              </div>
            </div>
          )}
        </div>
      </div>
    </header>
  );
};
