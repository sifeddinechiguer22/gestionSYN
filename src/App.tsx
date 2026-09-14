import React, { useState } from 'react';
import { UserRole } from './types';
import { SyndicSidebar } from './components/layout/SyndicSidebar';
import { ResidentSidebar } from './components/layout/ResidentSidebar';
import { TopNavbar } from './components/layout/TopNavbar';
import { AuthLayout } from './components/layout/AuthLayout';

// Syndic pages
import { SyndicDashboard } from './components/syndic/SyndicDashboard';
import { ResidentsPage } from './components/syndic/ResidentsPage';
import { BuildingsPage } from './components/syndic/BuildingsPage';
import { PaymentsPage } from './components/syndic/PaymentsPage';
import { ComplaintsPage } from './components/syndic/ComplaintsPage';
import { DocumentsPage } from './components/syndic/DocumentsPage';
import { AnnouncementsPage } from './components/syndic/AnnouncementsPage';

// Resident pages
import { ResidentDashboard } from './components/resident/ResidentDashboard';
import { ResidentApartmentPage } from './components/resident/ResidentApartmentPage';
import { ResidentPaymentsPage } from './components/resident/ResidentPaymentsPage';
import { ResidentComplaintsPage } from './components/resident/ResidentComplaintsPage';

// Common Modals
import { ProfileModal } from './components/common/ProfileModal';
import { BladeCodeModal } from './components/common/BladeCodeModal';
import { Code, Sparkles, Building, KeyRound, Lock, CheckCircle2 } from 'lucide-react';

export default function App() {
  const [currentRole, setCurrentRole] = useState<UserRole>('syndic');
  const [isAuthMode, setIsAuthMode] = useState<boolean>(false);
  const [syndicTab, setSyndicTab] = useState<string>('dashboard');
  const [residentTab, setResidentTab] = useState<string>('dashboard');
  const [mobileSidebarOpen, setMobileSidebarOpen] = useState<boolean>(false);
  const [isProfileOpen, setIsProfileOpen] = useState<boolean>(false);
  const [isBladeModalOpen, setIsBladeModalOpen] = useState<boolean>(false);

  // Switch between Syndic and Resident views
  const handleSwitchRole = (role: UserRole) => {
    setCurrentRole(role);
    setIsAuthMode(false);
    setMobileSidebarOpen(false);
  };

  const handleLogout = () => {
    setIsAuthMode(true);
  };

  const handleLoginSuccess = (role: UserRole) => {
    setCurrentRole(role);
    setIsAuthMode(false);
  };

  // Render Auth layout if in Auth mode
  if (isAuthMode) {
    return (
      <>
        <AuthLayout
          onLoginSuccess={handleLoginSuccess}
          onCancelAuth={() => setIsAuthMode(false)}
        />
        {/* Floating Quick Blade Code helper */}
        <button
          onClick={() => setIsBladeModalOpen(true)}
          className="fixed bottom-4 right-4 z-50 inline-flex items-center space-x-1.5 px-3 py-2 rounded-xl bg-slate-800/90 text-white text-xs font-semibold shadow-lg border border-slate-700 hover:bg-slate-700 transition-colors"
        >
          <Code className="w-3.5 h-3.5 text-indigo-400" />
          <span>Voir code Blade</span>
        </button>
        <BladeCodeModal
          isOpen={isBladeModalOpen}
          onClose={() => setIsBladeModalOpen(false)}
        />
      </>
    );
  }

  return (
    <div className="min-h-screen bg-slate-50 flex flex-col antialiased font-sans">
      {/* Interactive Demo Switcher Bar (Discreet, fixed top banner for easy evaluation) */}
      <div className="bg-slate-900 text-slate-300 text-xs px-4 py-2 border-b border-slate-800 flex flex-wrap items-center justify-between gap-2 z-40">
        <div className="flex items-center space-x-2">
          <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          <span className="font-bold text-white">Prototype UI Copropriété :</span>
          <span className="text-slate-400 hidden sm:inline">
            Testez les layouts et la navigation
          </span>
        </div>

        <div className="flex items-center space-x-1 sm:space-x-2">
          {/* Quick role switches */}
          <button
            id="switch-syndic-btn"
            onClick={() => handleSwitchRole('syndic')}
            className={`px-2.5 py-1 rounded-lg font-semibold transition-all flex items-center space-x-1 ${
              currentRole === 'syndic'
                ? 'bg-indigo-600 text-white shadow-xs'
                : 'bg-slate-800 hover:bg-slate-700 text-slate-300'
            }`}
          >
            <Building className="w-3 h-3" />
            <span>Layout Syndic</span>
          </button>

          <button
            id="switch-resident-btn"
            onClick={() => handleSwitchRole('resident')}
            className={`px-2.5 py-1 rounded-lg font-semibold transition-all flex items-center space-x-1 ${
              currentRole === 'resident'
                ? 'bg-emerald-600 text-white shadow-xs'
                : 'bg-slate-800 hover:bg-slate-700 text-slate-300'
            }`}
          >
            <KeyRound className="w-3 h-3" />
            <span>Layout Résident</span>
          </button>

          <button
            id="switch-auth-btn"
            onClick={() => setIsAuthMode(true)}
            className="px-2.5 py-1 rounded-lg font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors flex items-center space-x-1"
          >
            <Lock className="w-3 h-3" />
            <span>Layout Auth</span>
          </button>

          {/* Blade Code modal trigger */}
          <button
            id="view-blade-code-btn"
            onClick={() => setIsBladeModalOpen(true)}
            className="px-2.5 py-1 rounded-lg font-bold bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/40 transition-colors flex items-center space-x-1"
          >
            <Code className="w-3 h-3" />
            <span className="hidden sm:inline">Code Blade</span>
          </button>
        </div>
      </div>

      {/* Main Framework Container */}
      <div className="flex-1 flex relative">
        {/* Render Appropriate Sidebar */}
        {currentRole === 'syndic' ? (
          <SyndicSidebar
            currentTab={syndicTab}
            onSelectTab={(tab) => {
              if (tab === 'profil') {
                setIsProfileOpen(true);
              } else {
                setSyndicTab(tab);
              }
            }}
            isOpenMobile={mobileSidebarOpen}
            onCloseMobile={() => setMobileSidebarOpen(false)}
            onLogout={handleLogout}
          />
        ) : (
          <ResidentSidebar
            currentTab={residentTab}
            onSelectTab={(tab) => {
              if (tab === 'profil') {
                setIsProfileOpen(true);
              } else {
                setResidentTab(tab);
              }
            }}
            isOpenMobile={mobileSidebarOpen}
            onCloseMobile={() => setMobileSidebarOpen(false)}
            onLogout={handleLogout}
          />
        )}

        {/* Content Wrapper (Offset for fixed desktop sidebar) */}
        <div className="lg:pl-64 flex-1 flex flex-col min-w-0">
          {/* Top Navbar */}
          <TopNavbar
            role={currentRole}
            onToggleMobileSidebar={() => setMobileSidebarOpen(!mobileSidebarOpen)}
            onOpenProfile={() => setIsProfileOpen(true)}
            onSwitchRole={handleSwitchRole}
            onLogout={handleLogout}
            onSelectTab={(tab) => {
              if (currentRole === 'syndic') setSyndicTab(tab);
              else setResidentTab(tab);
            }}
          />

          {/* Page Body */}
          <main className="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            {currentRole === 'syndic' ? (
              <>
                {syndicTab === 'dashboard' && (
                  <SyndicDashboard
                    onNavigate={(tab) => setSyndicTab(tab)}
                  />
                )}
                {syndicTab === 'residents' && <ResidentsPage />}
                {(syndicTab === 'batiments' || syndicTab === 'residence' || syndicTab === 'appartements') && (
                  <BuildingsPage />
                )}
                {(syndicTab === 'paiements' || syndicTab === 'depenses') && (
                  <PaymentsPage />
                )}
                {syndicTab === 'reclamations' && <ComplaintsPage />}
                {syndicTab === 'documents' && <DocumentsPage />}
                {syndicTab === 'annonces' && <AnnouncementsPage />}
                {syndicTab === 'notifications' && (
                  <div className="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <h2 className="text-xl font-bold text-slate-900">Centre de Notifications & Alertes</h2>
                    <p className="text-xs text-slate-500">Flux d'événements en temps réel pour l'administration de la résidence.</p>
                    <div className="p-4 bg-emerald-50 text-emerald-800 rounded-xl text-xs flex items-center space-x-2">
                      <CheckCircle2 className="w-4 h-4 text-emerald-600" />
                      <span>Toutes les notifications syndic sont synchronisées.</span>
                    </div>
                  </div>
                )}
              </>
            ) : (
              <>
                {residentTab === 'dashboard' && (
                  <ResidentDashboard
                    onNavigate={(tab) => setResidentTab(tab)}
                    onOpenNewComplaint={() => setResidentTab('reclamations')}
                  />
                )}
                {residentTab === 'appartement' && <ResidentApartmentPage />}
                {residentTab === 'paiements' && <ResidentPaymentsPage />}
                {residentTab === 'reclamations' && <ResidentComplaintsPage />}
                {residentTab === 'documents' && <DocumentsPage />}
                {residentTab === 'annonces' && <AnnouncementsPage />}
                {residentTab === 'notifications' && (
                  <div className="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <h2 className="text-xl font-bold text-slate-900">Mes Notifications Résident</h2>
                    <p className="text-xs text-slate-500">Alertes sur vos paiements, réclamations et vie de la copropriété.</p>
                    <div className="p-4 bg-emerald-50 text-emerald-800 rounded-xl text-xs flex items-center space-x-2">
                      <CheckCircle2 className="w-4 h-4 text-emerald-600" />
                      <span>Aucune notification non lue pour le moment.</span>
                    </div>
                  </div>
                )}
              </>
            )}
          </main>
        </div>
      </div>

      {/* Profile Modal */}
      <ProfileModal
        role={currentRole}
        isOpen={isProfileOpen}
        onClose={() => setIsProfileOpen(false)}
      />

      {/* Blade Code Modal */}
      <BladeCodeModal
        isOpen={isBladeModalOpen}
        onClose={() => setIsBladeModalOpen(false)}
      />
    </div>
  );
}
