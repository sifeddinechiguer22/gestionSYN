export type UserRole = 'syndic' | 'resident';

export type NavigationItem = {
  id: string;
  label: string;
  icon: string;
  badge?: string | number;
  badgeColor?: 'emerald' | 'amber' | 'rose' | 'blue' | 'slate';
};

export interface Resident {
  id: string;
  firstName: string;
  lastName: string;
  avatar?: string;
  email: string;
  phone: string;
  building: string; // e.g. "Bâtiment A"
  apartment: string; // e.g. "A-102"
  floor: number;
  type: 'Propriétaire' | 'Locataire' | 'Bailleur';
  monthlyDue: number;
  paymentStatus: 'A_JOUR' | 'RETARD_1M' | 'RETARD_PLUS';
  unpaidAmount: number;
  entryDate: string;
}

export interface Payment {
  id: string;
  residentName: string;
  apartment: string;
  building: string;
  month: string;
  amount: number;
  date: string;
  method: 'Virement' | 'Chèque' | 'Espèces' | 'En ligne';
  status: 'Payé' | 'En attente' | 'Rejeté';
  receiptNumber: string;
}

export interface Expense {
  id: string;
  category: 'Gardiennage' | 'Nettoyage' | 'Électricité' | 'Eau' | 'Ascenseur' | 'Jardinage' | 'Travaux';
  title: string;
  amount: number;
  date: string;
  vendor: string;
  status: 'Payé' | 'En attente d approbation';
}

export interface Complaint {
  id: string;
  residentName: string;
  apartment: string;
  title: string;
  category: 'Ascenseur' | 'Plomberie' | 'Éclairage' | 'Bruit / Voisinage' | 'Parking' | 'Autre';
  priority: 'Basse' | 'Moyenne' | 'Haute' | 'Urgente';
  status: 'Nouveau' | 'En cours' | 'Résolu' | 'Rejeté';
  date: string;
  description: string;
}

export interface Announcement {
  id: string;
  title: string;
  date: string;
  author: string;
  category: 'Assemblée Générale' | 'Travaux' | 'Rappel' | 'Événement';
  content: string;
  isPinned?: boolean;
}

export interface ResidenceDocument {
  id: string;
  name: string;
  category: 'Procès-Verbal AG' | 'Règlement' | 'Finances' | 'Contrats';
  size: string;
  date: string;
  downloadUrl?: string;
}

export interface AppNotification {
  id: string;
  title: string;
  message: string;
  time: string;
  read: boolean;
  type: 'payment' | 'complaint' | 'announcement' | 'alert';
}
