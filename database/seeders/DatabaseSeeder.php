<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Residence;
use App\Models\Building;
use App\Models\Apartment;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Complaint;
use App\Models\ComplaintReply;
use App\Models\Document;
use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Syndic User
        $syndic = User::create([
            'name' => 'Karim Bennani',
            'email' => 'syndic@palmiers.ma',
            'role' => 'syndic',
            'phone' => '+212 6 61 23 45 67',
            'password' => Hash::make('password'),
        ]);

        // 2. Create Resident Users
        $resident1 = User::create([
            'name' => 'Ayoub Tazi',
            'email' => 'resident@palmiers.ma',
            'role' => 'resident',
            'phone' => '+212 6 62 11 22 33',
            'password' => Hash::make('password'),
        ]);

        $resident2 = User::create([
            'name' => 'Fatima Zohra Alami',
            'email' => 'fatima@alami.ma',
            'role' => 'resident',
            'phone' => '+212 6 63 44 55 66',
            'password' => Hash::make('password'),
        ]);

        $resident3 = User::create([
            'name' => 'Omar El Idrissi',
            'email' => 'omar@idrissi.ma',
            'role' => 'resident',
            'phone' => '+212 6 64 77 88 99',
            'password' => Hash::make('password'),
        ]);

        $resident4 = User::create([
            'name' => 'Mehdi Benjaloun',
            'email' => 'mehdi@benjaloun.ma',
            'role' => 'resident',
            'phone' => '+212 6 65 00 11 22',
            'password' => Hash::make('password'),
        ]);

        // 3. Create Residence
        $residence = Residence::create([
            'syndic_id' => $syndic->id,
            'name' => 'Résidence Les Palmiers',
            'address' => '142 Boulevard Ghandi',
            'city' => 'Casablanca',
            'postal_code' => '20000',
            'total_apartments' => 48,
        ]);

        // 4. Create Buildings
        $buildingA = Building::create([
            'residence_id' => $residence->id,
            'name' => 'Bâtiment A',
            'code' => 'BAT-A',
            'floors_count' => 5,
            'apartments_count' => 16,
        ]);

        $buildingB = Building::create([
            'residence_id' => $residence->id,
            'name' => 'Bâtiment B',
            'code' => 'BAT-B',
            'floors_count' => 5,
            'apartments_count' => 16,
        ]);

        $buildingC = Building::create([
            'residence_id' => $residence->id,
            'name' => 'Bâtiment C',
            'code' => 'BAT-C',
            'floors_count' => 4,
            'apartments_count' => 16,
        ]);

        // 5. Create Apartments
        $appt1 = Apartment::create([
            'building_id' => $buildingA->id,
            'user_id' => $resident1->id,
            'number' => '14',
            'floor' => 3,
            'area_sqm' => 115.00,
            'monthly_fee' => 800.00,
            'status' => 'occupied',
        ]);

        $appt2 = Apartment::create([
            'building_id' => $buildingB->id,
            'user_id' => $resident2->id,
            'number' => '08',
            'floor' => 1,
            'area_sqm' => 95.00,
            'monthly_fee' => 800.00,
            'status' => 'occupied',
        ]);

        $appt3 = Apartment::create([
            'building_id' => $buildingA->id,
            'user_id' => $resident3->id,
            'number' => '22',
            'floor' => 4,
            'area_sqm' => 120.00,
            'monthly_fee' => 800.00,
            'status' => 'occupied',
        ]);

        $appt4 = Apartment::create([
            'building_id' => $buildingC->id,
            'user_id' => $resident4->id,
            'number' => '03',
            'floor' => 0,
            'area_sqm' => 110.00,
            'monthly_fee' => 800.00,
            'status' => 'occupied',
        ]);

        // 6. Create Payments
        Payment::create([
            'apartment_id' => $appt1->id,
            'user_id' => $resident1->id,
            'receipt_number' => 'REC-2026-001',
            'amount' => 800.00,
            'month' => '2026-09',
            'payment_date' => '2026-09-05',
            'payment_method' => 'virement',
            'status' => 'paid',
            'reference' => 'VIR-89412',
            'notes' => 'Cotisation mensuelle réglée',
        ]);

        Payment::create([
            'apartment_id' => $appt2->id,
            'user_id' => $resident2->id,
            'receipt_number' => 'REC-2026-002',
            'amount' => 800.00,
            'month' => '2026-09',
            'payment_date' => '2026-09-02',
            'payment_method' => 'especes',
            'status' => 'paid',
            'reference' => 'ESP-412',
            'notes' => 'Reçu rédigé',
        ]);

        Payment::create([
            'apartment_id' => $appt3->id,
            'user_id' => $resident3->id,
            'receipt_number' => 'REC-2026-003',
            'amount' => 800.00,
            'month' => '2026-08',
            'payment_date' => '2026-09-10',
            'payment_method' => 'cheque',
            'status' => 'pending',
            'reference' => 'CHQ-45892',
            'notes' => 'Chèque déposé en attente de compensation',
        ]);

        Payment::create([
            'apartment_id' => $appt4->id,
            'user_id' => $resident4->id,
            'receipt_number' => 'REC-2026-004',
            'amount' => 1600.00,
            'month' => '2026-07',
            'payment_date' => '2026-09-01',
            'payment_method' => 'virement',
            'status' => 'late',
            'reference' => 'IMP-03',
            'notes' => 'Impayé 2 mois',
        ]);

        // 7. Create Expenses
        Expense::create([
            'residence_id' => $residence->id,
            'title' => 'Maintenance Ascenseur OTIS',
            'category' => 'maintenance',
            'amount' => 3500.00,
            'expense_date' => '2026-09-01',
            'vendor_name' => 'OTIS Maroc',
            'description' => 'Visite mensuelle de maintenance préventive',
        ]);

        Expense::create([
            'residence_id' => $residence->id,
            'title' => 'Facture Électricité Communs REDAL/LYDEC',
            'category' => 'electricity',
            'amount' => 4200.00,
            'expense_date' => '2026-09-05',
            'vendor_name' => 'Lydec Casablanca',
            'description' => 'Éclairage public, sous-sol et ascenseurs',
        ]);

        // 8. Create Complaints & Replies
        $complaint = Complaint::create([
            'apartment_id' => $appt1->id,
            'user_id' => $resident1->id,
            'ticket_number' => 'TK-2026-042',
            'title' => "Panne d'ascenseur Bâtiment B",
            'category' => 'elevator',
            'priority' => 'urgent',
            'status' => 'en_attente',
            'description' => "L'ascenseur est bloqué entre le 2ème et le 3ème étage.",
        ]);

        ComplaintReply::create([
            'complaint_id' => $complaint->id,
            'user_id' => $resident1->id,
            'message' => "L'ascenseur fait un bruit anormal et refuse de démarrer. Pouvez-vous contacter le technicien ?",
        ]);

        ComplaintReply::create([
            'complaint_id' => $complaint->id,
            'user_id' => $syndic->id,
            'message' => "Bonjour M. Tazi. La société Otis a été dépêchée sur place.",
        ]);

        Complaint::create([
            'apartment_id' => $appt1->id,
            'user_id' => $resident1->id,
            'ticket_number' => 'TK-2026-015',
            'title' => "Réparation volet roulant privé",
            'category' => 'other',
            'priority' => 'low',
            'status' => 'refusée',
            'description' => "Demande de prise en charge du remplacement de la manivelle du volet roulant du salon.",
            'rejection_reason' => "Les volets roulants privatifs restent à la charge exclusive du copropriétaire conformément à l'article 12 du règlement de copropriété.",
        ]);

        // 9. Create Announcements
        Announcement::create([
            'residence_id' => $residence->id,
            'user_id' => $syndic->id,
            'title' => 'Assemblée Générale Ordinaire',
            'content' => 'Convocation pour l\'assemblée générale annuelle le samedi 25 Septembre à 16h30.',
            'type' => 'urgent',
            'pinned' => true,
        ]);

        // 10. Create Documents
        Document::create([
            'residence_id' => $residence->id,
            'user_id' => $syndic->id,
            'title' => 'Règlement de Copropriété 2026',
            'category' => 'reglement',
            'file_path' => 'documents/reglement_copropriete.pdf',
            'file_size' => '2.4 MB',
            'description' => 'Texte officiel régissant la résidence',
            'is_public' => true,
        ]);
    }
}
