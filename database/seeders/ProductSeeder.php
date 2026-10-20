<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $ringan = ProductCategory::where('name', 'Makanan Ringan')->first();
        $berat  = ProductCategory::where('name', 'Makanan Berat')->first();
        $mie    = ProductCategory::where('name', 'Mie Instan')->first();
        $minum  = ProductCategory::where('name', 'Minuman Segar')->first();
        $lauk   = ProductCategory::where('name', 'Aneka Lauk')->first() ?? $berat;

        $products = [
            // Makanan Ringan
            [
                'category_id' => $ringan->id,
                'name' => 'Risol Mayo Beef & Egg',
                'description' => 'Mayo homemade creamy gurih berpadu potongan smoked beef dan telur rebus dalam balutan tepung roti emas renyah.',
                'price' => 4500,
                'stock' => 50,
                'unit' => 'pcs',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBjfgHLT8kteBQDdMGEQYThIxb74MNHgeJMMckFTZwI0tfkB5PllThnkFkmMUO5Y089SEQcOHCHOw9JYj6LxaQ44donrVlAQKZeLUVnj8oxDimXvxadhnVGnDW2NJHl_tQs3pEacp0T7o_4b-nqDYZRu1G2z4oduRYpzPPtf-3iuN1Cuol6-vvCPun4wS-B4vlw9p3kPKqOZ1jWlOFyt5YPhBhhgmQuii3UUHhbFHAiCHaWLOgPkgHB',
                'status' => 'available',
            ],
            [
                'category_id' => $ringan->id,
                'name' => 'Pisang Coklat Crispy',
                'description' => 'Pisang manis legit dengan lelehan coklat premium lumer di dalam kulit pastry renyah khas racikan Yan\'s Food.',
                'price' => 3500,
                'stock' => 45,
                'unit' => 'pcs',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDhEq_qfhbhyzfhQayTaoq75HycT7f5SC6DQeMDreglD0Zvhq17xGPZJe1ejQf3tnSRYPDRFrYxFgkPu75dAX0W80yYxNVg_AELoWtWHDypCFtykyNJKV0rm3318FMvSIRN-mD4wSyG1SWpIJpN4AxWc15PB9ObSRXjrfB12Rwaj4pMnQXKuz23o918-tAbM6g5-lBbLo4vIUtnIGfDVzEKMNebYvdIBPwpVDExCZMYmi1Z0ywyuYeX',
                'status' => 'available',
            ],
            [
                'category_id' => $ringan->id,
                'name' => 'Tahu Bakso Kukus / Goreng',
                'description' => 'Olahan daging sapi asli berpadu lembutnya tahu pong gurih, disajikan hangat dengan cabai rawit hijau segar.',
                'price' => 4000,
                'stock' => 40,
                'unit' => 'pcs',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBWCJRdB6spLCGTymtJSbPtZOo9HW9h2e5gDOOhwEBsMleb1NUkgXF2RqgdpqDgWsIiYxLJU-17um6yqSXGfVnPGwhcA2IygU-19yHAwJ6H8ttkpLdFe0g_U7Gabr5SOtTcBleLvWsZ6KOhDrJh1hEyy30IU60mbxUEYVPIIROvocFVMKwDDsiyt7_MiGA16pfu0qPrgAGw3l4iKJgmifbCXjfaPjjJeRokLGbi1mepW0guL4PLjhaF',
                'status' => 'available',
            ],

            // Makanan Berat
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Goreng Jadul Yan\'s',
                'description' => 'Racikan bumbu ulek terasi bakar tempo dulu, suwiran ayam gurih, telur ceplok setengah matang, dan acar timun segar.',
                'price' => 22000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB0gFjuwYwzc5byRksAoaPaJCo22HZeR2rTD2kcV7En88UcW7vKVQXq9YS8RXfSwxDMdpiV3U3rvbi8G1OfQbMTfoZAmHnswhGp0WoieoCeNQ8KbJd2HC-yzabd_HDxIAXf658sy5Jn906vGgVVOuiJLKspZ5dt_52kF1IsTKSW7x1eMeywP5Hhz8hNEHbfX4iAk2pDJ1bo9jJHEv-bM2JMOM7AiS6nmi8Qg3jusbDPBLRFGaRDDvp5',
                'status' => 'available',
            ],
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Ayam Sambal Korek',
                'description' => 'Ayam goreng bumbu ungkep lengkuas gurih berpadu pedasnya sambal korek bawang segar yang disiram minyak panas.',
                'price' => 25000,
                'stock' => 25,
                'unit' => 'porsi',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC0yQ-j1z3AvTOxnG1AkwOJ0fmoq8g9MoW0OcApYSuwOdpLt4FLyDdc2QgEF-ukq3fjIM2dKQHU0UJNThY7N4VTaXisRBgJsC6POPbZxqmyfkqRfvPtbc-jSP_QjJWXgWcIdyWiG1qr5EFYCyICPlpR7qPax3-gh_Dd5sOIJ5Z1Jurn7jRr5iufoXtSWwf4mEGafDRK3Qc2aaIJBIDNbvSSDAlVoK21EfipdBbJizEcd-q3tLdbCeau',
                'status' => 'available',
            ],

            // Mie Instan
            [
                'category_id' => $mie->id,
                'name' => 'Bakmi Goreng Spesial',
                'description' => 'Mie kenyal ditumis dengan bumbu kecap manis harum, sawi hijau segar, potongan bakso sapi, dan telur orak-arik.',
                'price' => 18000,
                'stock' => 35,
                'unit' => 'porsi',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAzRT8g-wzoYqZeUDrksy8MnGbkK54k0QHLwrOQjY9qL7V4Hv8d4qmf1uK3-VgIntBqHioQJRnQkfdGj_qjH9DSll49RWYcUjdTXLsmbLWQtjZrBM4n2M_8YrdNLt7WRiTx-NPA3XFsIZrO03tpGPXefj9O-ho2dweK4X7Uto5vboGOmU_AKp_FnvP8cywJc8JvrIE5MwfDXtglImY-P1_2gpLyDNhQPq-X47HBJXyGn7CweR2D0y6F',
                'status' => 'available',
            ],

            // Minuman Segar
            [
                'category_id' => $minum->id,
                'name' => 'Es Kopi Susu Gula Aren',
                'description' => 'Espresso house blend robusta-arabika dipadu susu segar creamy dan manis gurih alami gula aren murni.',
                'price' => 15000,
                'stock' => 50,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            [
                'category_id' => $minum->id,
                'name' => 'Es Teh Manis Melati',
                'description' => 'Seduhan teh melati wangi khas Jawa dengan daun teh pilihan dan es batu kristal higienis pelepas dahaga.',
                'price' => 5000,
                'stock' => 80,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],

            // Makanan Berat & Aneka Lauk
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Kotak Ayam Bakar Spesial',
                'description' => 'Nasi putih pulen, ayam bakar bumbu kecap manis legit, lalapan segar, sambal korek pedas, dan tahu tempe goreng.',
                'price' => 25000,
                'stock' => 50,
                'unit' => 'porsi',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC0yQ-j1z3AvTOxnG1AkwOJ0fmoq8g9MoW0OcApYSuwOdpLt4FLyDdc2QgEF-ukq3fjIM2dKQHU0UJNThY7N4VTaXisRBgJsC6POPbZxqmyfkqRfvPtbc-jSP_QjJWXgWcIdyWiG1qr5EFYCyICPlpR7qPax3-gh_Dd5sOIJ5Z1Jurn7jRr5iufoXtSWwf4mEGafDRK3Qc2aaIJBIDNbvSSDAlVoK21EfipdBbJizEcd-q3tLdbCeau',
                'status' => 'available',
            ],
            [
                'category_id' => $ringan->id,
                'name' => 'Tahu Bakso Goreng Renyah',
                'description' => 'Tahu pong isi adonan bakso sapi gurih berpadu rempah bawang, digoreng garing keemasan dengan cabe rawit hijau.',
                'price' => 3500,
                'stock' => 60,
                'unit' => 'pcs',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuARZOQ96wet-CMX5rdD7lCFZyLs1EkrpKnlUC0RR99N8F7qRKAtVDp0zOXrFg0euopAroL4wdJES5KEUP4Mc10u-UzZYXlvj3_U850HmHFdI-2qa02DqfAOUMw-0VbCaGvmAt2949p2eWuHqz3RcdS7ODq1G6OninQUnQZKMoxPO6O-lS3WjYQWINUV6vdxskptYAzfbyMOIB5K2-d37eZht5g2KMxF67gGOJStQ-AFmbk3gNEvgEtd',
                'status' => 'available',
            ],
        ];

        foreach ($products as $prod) {
            Product::firstOrCreate(
                ['name' => $prod['name']],
                $prod
            );
        }
    }
}
