<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MasterData;
use App\Models\InjectionDataInput;
use App\Models\AssemblingDataInput;
use App\Models\DeliveryDataInput;
use App\Models\StockWip;
use App\Models\StockFg;
use App\Models\PemakaianMaterial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default users
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@production.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $supervisor = User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@production.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
        ]);

        $operator1 = User::create([
            'name' => 'Operator 1',
            'email' => 'operator1@production.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        $operator2 = User::create([
            'name' => 'Operator 2',
            'email' => 'operator2@production.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        // Create master data
        $masterParts = [
            ['kode_part' => 'PT-001', 'nama_part' => 'Engine Block', 'proses' => 'injection', 'status' => 'active'],
            ['kode_part' => 'PT-002', 'nama_part' => 'Cylinder Head', 'proses' => 'injection', 'status' => 'active'],
            ['kode_part' => 'PT-003', 'nama_part' => 'Piston Assembly', 'proses' => 'assembling', 'status' => 'active'],
            ['kode_part' => 'PT-004', 'nama_part' => 'Valve Cover', 'proses' => 'injection', 'status' => 'active'],
            ['kode_part' => 'PT-005', 'nama_part' => 'Transmission Case', 'proses' => 'injection', 'status' => 'active'],
            ['kode_part' => 'PT-006', 'nama_part' => 'Gear Assembly', 'proses' => 'assembling', 'status' => 'active'],
            ['kode_part' => 'PT-007', 'nama_part' => 'Brake Disc', 'proses' => 'injection', 'status' => 'active'],
            ['kode_part' => 'PT-008', 'nama_part' => 'Wheel Hub', 'proses' => 'assembling', 'status' => 'active'],
            ['kode_part' => 'PT-009', 'nama_part' => 'Suspension Arm', 'proses' => 'injection', 'status' => 'active'],
            ['kode_part' => 'PT-010', 'nama_part' => 'Complete Engine', 'proses' => 'delivery', 'status' => 'active'],
        ];

        foreach ($masterParts as $part) {
            MasterData::create($part);
        }

        // Create stock records for each part
        foreach ($masterParts as $part) {
            StockWip::create([
                'kode_part' => $part['kode_part'],
                'qty_wip' => rand(0, 100),
            ]);

            StockFg::create([
                'kode_part' => $part['kode_part'],
                'qty_fg' => rand(0, 50),
            ]);
        }

        // Create injection data
        $injectionParts = ['PT-001', 'PT-002', 'PT-004', 'PT-005', 'PT-007', 'PT-009'];
        foreach ($injectionParts as $kodePart) {
            for ($i = 0; $i < rand(5, 15); $i++) {
                InjectionDataInput::create([
                    'kode_part' => $kodePart,
                    'qty_hasil' => rand(10, 100),
                    'tanggal_input' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                    'operator_id' => collect([$operator1->id, $operator2->id])->random(),
                ]);
            }
        }

        // Create assembling data
        $assemblingParts = ['PT-003', 'PT-006', 'PT-008'];
        foreach ($assemblingParts as $kodePart) {
            for ($i = 0; $i < rand(3, 10); $i++) {
                AssemblingDataInput::create([
                    'kode_part' => $kodePart,
                    'qty_assembly' => rand(5, 50),
                    'tanggal_input' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                    'operator_id' => collect([$operator1->id, $operator2->id])->random(),
                ]);
            }
        }

        // Create delivery data
        $customers = ['Toyota Motor', 'Honda Manufacturing', 'Nissan Parts', 'Mitsubishi Motors', 'Suzuki Corp'];
        $deliveryParts = ['PT-010', 'PT-003', 'PT-006', 'PT-008'];
        foreach ($deliveryParts as $kodePart) {
            for ($i = 0; $i < rand(2, 8); $i++) {
                DeliveryDataInput::create([
                    'kode_part' => $kodePart,
                    'qty_delivery' => rand(1, 20),
                    'tanggal_delivery' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                    'customer' => collect($customers)->random(),
                    'operator_id' => collect([$operator1->id, $operator2->id])->random(),
                ]);
            }
        }

        // Create material usage data
        $materials = ['Steel', 'Aluminum', 'Plastic', 'Rubber', 'Copper'];
        foreach ($masterParts as $part) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                PemakaianMaterial::create([
                    'kode_part' => $part['kode_part'],
                    'material' => collect($materials)->random(),
                    'jumlah_pakai' => rand(1, 10),
                    'tanggal' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                ]);
            }
        }

        echo "Database seeded successfully!\n";
        echo "Login credentials:\n";
        echo "Admin: admin@production.com / password\n";
        echo "Supervisor: supervisor@production.com / password\n";
        echo "Operator 1: operator1@production.com / password\n";
        echo "Operator 2: operator2@production.com / password\n";
    }
}

