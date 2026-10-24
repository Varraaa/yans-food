<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $ringan = ProductCategory::firstOrCreate(['name' => 'Makanan Ringan']);
        $berat  = ProductCategory::firstOrCreate(['name' => 'Makanan Berat']);
        $mie    = ProductCategory::firstOrCreate(['name' => 'Mie Instan']);
        $minum  = ProductCategory::firstOrCreate(['name' => 'Minuman Segar']);

        $products = [
            // 1. Ketan Goreng
            [
                'category_id' => $ringan->id,
                'name' => 'Ketan Goreng',
                'description' => 'Ketan goreng gurih renyah di luar dan lembut di dalam khas racikan bumbu dapur Yan\'s Food.',
                'price' => 12000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 2. Pisang Coklat Lumer
            [
                'category_id' => $ringan->id,
                'name' => 'Pisang Coklat Lumer',
                'description' => 'Pisang manis legit dengan isian cokelat lumer berbalut kulit pastry renyah khas racikan Yan\'s Food.',
                'price' => 14000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDhEq_qfhbhyzfhQayTaoq75HycT7f5SC6DQeMDreglD0Zvhq17xGPZJe1ejQf3tnSRYPDRFrYxFgkPu75dAX0W80yYxNVg_AELoWtWHDypCFtykyNJKV0rm3318FMvSIRN-mD4wSyG1SWpIJpN4AxWc15PB9ObSRXjrfB12Rwaj4pMnQXKuz23o918-tAbM6g5-lBbLo4vIUtnIGfDVzEKMNebYvdIBPwpVDExCZMYmi1Z0ywyuYeX',
                'status' => 'available',
            ],
            // 3. Cireng Rujak
            [
                'category_id' => $ringan->id,
                'name' => 'Cireng Rujak',
                'description' => 'Cireng renyah kenyal dengan cocolan bumbu rujak pedas manis segar. Dapat disajikan matang atau frozen. Gratis saus & mayones.',
                'price' => 10500,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 4. Stik Sosis
            [
                'category_id' => $ringan->id,
                'name' => 'Stik Sosis',
                'description' => 'Satu porsi berisi 5 pcs stik sosis gurih lezat, saus dan mayones, tanpa nasi. Bisa disajikan matang atau frozen.',
                'price' => 10850,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1576082869760-4c4f34d10f88?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 5. Kroket Bihun Sayur
            [
                'category_id' => $ringan->id,
                'name' => 'Kroket Bihun Sayur',
                'description' => 'Kroket renyah isi bihun dan sayuran gurih bergizi. Bisa disajikan frozen atau matang hangat. Gratis saus dan mayones.',
                'price' => 12000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 6. Stik Keju Mozarela Lumer
            [
                'category_id' => $ringan->id,
                'name' => 'Stik Keju Mozarela Lumer',
                'description' => 'Stik camilan renyah dengan keju mozzarella lumer mulur kaya rasa di setiap gigitan.',
                'price' => 20000,
                'stock' => 25,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1531749668029-2db88e4276c7?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 7. Risol Mayo
            [
                'category_id' => $ringan->id,
                'name' => 'Risol Mayo',
                'description' => 'Risol mayo creamy gurih berbalut kulit renyah emas, tersedia pilihan pedas atau original. Gratis saus dan mayones.',
                'price' => 14000,
                'stock' => 40,
                'unit' => 'porsi',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBjfgHLT8kteBQDdMGEQYThIxb74MNHgeJMMckFTZwI0tfkB5PllThnkFkmMUO5Y089SEQcOHCHOw9JYj6LxaQ44donrVlAQKZeLUVnj8oxDimXvxadhnVGnDW2NJHl_tQs3pEacp0T7o_4b-nqDYZRu1G2z4oduRYpzPPtf-3iuN1Cuol6-vvCPun4wS-B4vlw9p3kPKqOZ1jWlOFyt5YPhBhhgmQuii3UUHhbFHAiCHaWLOgPkgHB',
                'status' => 'available',
            ],
            // 8. Dimsum Ayam
            [
                'category_id' => $ringan->id,
                'name' => 'Dimsum Ayam',
                'description' => 'Dimsum ayam lembut gurih juicy. Bisa disajikan hangat matang atau frozen (mentah). Gratis chili oil dan mayones.',
                'price' => 17000,
                'stock' => 35,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 9. Dimsum Udang
            [
                'category_id' => $ringan->id,
                'name' => 'Dimsum Udang',
                'description' => 'Dimsum olahan udang segar gurih bertekstur juicy. Bisa disajikan matang atau frozen. Gratis chili oil dan mayones.',
                'price' => 17000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 10. Dimsum Mix
            [
                'category_id' => $ringan->id,
                'name' => 'Dimsum Mix',
                'description' => 'Paket dimsum campuran aneka varian lezat. Disajikan hangat lengkap dengan siraman chili oil dan mayones gratis.',
                'price' => 17000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1498654896293-37aacf113fd9?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 11. Pangsit Ayam
            [
                'category_id' => $ringan->id,
                'name' => 'Pangsit Ayam',
                'description' => 'Pangsit rebus isi olahan ayam cincang gurih, pilihan kuah segar atau kering. Bisa dimasak atau dibeli frozen.',
                'price' => 20000,
                'stock' => 25,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 12. Dimsum Jamur
            [
                'category_id' => $ringan->id,
                'name' => 'Dimsum Jamur',
                'description' => 'Dimsum varian jamur kenyal gurih lezat dengan paduan rempah lembut, chili oil dan mayones.',
                'price' => 17000,
                'stock' => 25,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1576577445504-6af96477db52?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 13. Nasi + Nugget Ayam + Stick Sosis
            [
                'category_id' => $berat->id,
                'name' => 'Nasi + Nugget Ayam + Stick Sosis',
                'description' => 'Paket komplit nasi pulen dengan nugget ayam renyah dan stik sosis gurih, disertai saus dan mayones lezat.',
                'price' => 28000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1562967914-608f82629710?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 14. Nasi + Chicken Nugget
            [
                'category_id' => $berat->id,
                'name' => 'Nasi + Chicken Nugget',
                'description' => 'Nasi pulen hangat dengan lauk chicken nugget renyah keemasan, saus tomat dan mayones.',
                'price' => 28000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1562967914-608f82629710?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 15. Nasi + Stick Sosis
            [
                'category_id' => $berat->id,
                'name' => 'Nasi + Stick Sosis',
                'description' => 'Nasi pulen hangat dilengkapi 6 pcs stik sosis gurih lezat, disajikan dengan saus dan mayones.',
                'price' => 28000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1576082869760-4c4f34d10f88?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 16. Nasi + Chicken Katsu
            [
                'category_id' => $berat->id,
                'name' => 'Nasi + Chicken Katsu',
                'description' => 'Nasi putih pulen dengan chicken katsu dada ayam renyah (berat 1 ons), salad sayuran segar, saus dan mayones.',
                'price' => 26500,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 17. Nugget Ayam
            [
                'category_id' => $ringan->id,
                'name' => 'Nugget Ayam',
                'description' => 'Nugget olahan ayam pilihan yang digoreng renyah keemasan, disajikan dengan cocolan saus dan mayones.',
                'price' => 13500,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1562967914-608f82629710?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 18. Nasi Goreng Mawut
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Goreng Mawut',
                'description' => 'Nasi goreng mawut perpaduan nasi dan mie bumbu khas gurih lezat, suwiran ayam, sayuran, dan kerupuk renyah.',
                'price' => 24000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 19. Nasi Goreng Cikur
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Goreng Cikur',
                'description' => 'Nasi goreng cikur aromatik khas kencur priangan dengan telur ceplok, lalapan timun, dan kerupuk renyah.',
                'price' => 21000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 20. Nasi Goreng Jadul
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Goreng Jadul',
                'description' => 'Nasi goreng jadul bumbu ulek tradisional dengan 1 butir telur, sayuran, kerupuk, dan kemasan lunchbox higienis.',
                'price' => 21000,
                'stock' => 35,
                'unit' => 'porsi',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB0gFjuwYwzc5byRksAoaPaJCo22HZeR2rTD2kcV7En88UcW7vKVQXq9YS8RXfSwxDMdpiV3U3rvbi8G1OfQbMTfoZAmHnswhGp0WoieoCeNQ8KbJd2HC-yzabd_HDxIAXf658sy5Jn906vGgVVOuiJLKspZ5dt_52kF1IsTKSW7x1eMeywP5Hhz8hNEHbfX4iAk2pDJ1bo9jJHEv-bM2JMOM7AiS6nmi8Qg3jusbDPBLRFGaRDDvp5',
                'status' => 'available',
            ],
            // 21. Nasi Goreng
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng spesial racikan bumbu khas dapur Yan\'s Food dengan telur, kerupuk renyah, dan acar segar.',
                'price' => 21000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 22. Nasi Sosis Saus Tiram
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Sosis Saus Tiram',
                'description' => 'Nasi pulen hangat dengan tumisan potongan sosis berbalut saus tiram gurih manis kaya rempah sedap.',
                'price' => 20000,
                'stock' => 25,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 23. Nasi Telur Sosis Orak Arik
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Telur Sosis Orak Arik',
                'description' => 'Nasi hangat dengan telur dan sosis orak-arik lembut gurih, dilengkapi kerupuk dan lalapan sayur segar.',
                'price' => 20000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 24. Nasi Telur Dadar Sosis
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Telur Dadar Sosis',
                'description' => 'Nasi hangat dengan telur dadar tebal gurih bertabur potongan sosis nikmat dan lalapan segar.',
                'price' => 15000,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 25. Nasi Telur Ceplok Sosis
            [
                'category_id' => $berat->id,
                'name' => 'Nasi Telur Ceplok Sosis',
                'description' => 'Nasi putih pulen dengan telur ceplok mata sapi dan sosis goreng gurih lezat.',
                'price' => 18500,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 26. Teh Manis (Hangat / Dingin)
            [
                'category_id' => $minum->id,
                'name' => 'Teh Manis (Hangat / Dingin)',
                'description' => 'Seduhan teh melati wangi khas Jawa dengan daun teh pilihan, tersedia dalam pilihan hangat atau dingin segar.',
                'price' => 7000,
                'stock' => 50,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 27. Nutrisari Dingin Banyak Rasa
            [
                'category_id' => $minum->id,
                'name' => 'Nutrisari Dingin Banyak Rasa',
                'description' => 'Minuman sari buah Nutrisari dingin menyegarkan dengan aneka pilihan rasa buah kaya vitamin.',
                'price' => 7000,
                'stock' => 50,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 28. Extra Joss (Dingin)
            [
                'category_id' => $minum->id,
                'name' => 'Extra Joss (Dingin)',
                'description' => 'Minuman energi Extra Joss dingin pelepas dahaga dengan sensasi segar dingin mantap.',
                'price' => 7000,
                'stock' => 40,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 29. Susu Milo (Hangat)
            [
                'category_id' => $minum->id,
                'name' => 'Susu Milo (Hangat)',
                'description' => 'Satu porsi susu Milo hangat dengan rasa cokelat malt kaya gizi, dikemas dalam paper cup anti panas higienis.',
                'price' => 8000,
                'stock' => 40,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 30. Susu Kental Manis (Hangat)
            [
                'category_id' => $minum->id,
                'name' => 'Susu Kental Manis (Hangat)',
                'description' => 'Minuman susu kental manis hangat yang manis gurih dan pas untuk menghangatkan suasana.',
                'price' => 9000,
                'stock' => 40,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?auto=format&fit=crop&w=600&q=80',
                'status' => 'available',
            ],
            // 31. Mie Indomie / Sedap Double Mie (Stok Habis)
            [
                'category_id' => $mie->id,
                'name' => 'Mie Indomie / Sedap Double Mie',
                'description' => 'Menu mi instan lezat dengan pilihan Indomie atau Sedap double mie porsi mengenyangkan.',
                'price' => 15000,
                'stock' => 0,
                'unit' => 'porsi',
                'image' => 'https://images.unsplash.com/photo-1612927601601-6638404737ce?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 32. Es Kul Kul Piscok (Stok Habis)
            [
                'category_id' => $ringan->id,
                'name' => 'Es Kul Kul Piscok',
                'description' => 'Es kul-kul buah pisang manis dingin berbalut cokelat beku renyah bertabur topping favorit.',
                'price' => 12000,
                'stock' => 0,
                'unit' => 'pcs',
                'image' => 'https://images.unsplash.com/photo-1481391319762-47dff72954d9?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 33. Kopi Susu ABC (Hangat) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Susu ABC (Hangat)',
                'description' => 'Kopi susu ABC hangat dengan racikan kopi mantap dan manis gurih susu yang seimbang.',
                'price' => 8000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 34. Kopi Good Day Coolin (Hangat / Dingin) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Good Day Coolin (Hangat / Dingin)',
                'description' => 'Minuman kopi Good Day Coolin dengan sensasi mint segar, pilihan hangat atau dingin.',
                'price' => 8000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 35. Kopi Good Day Carrebian Nut (Hangat / Dingin) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Good Day Carrebian Nut (Hangat / Dingin)',
                'description' => 'Minuman kopi Good Day Carrebian Nut beraroma kacang hazelnut harum menggoda, pilihan hangat atau dingin.',
                'price' => 8000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 36. Kopi Good Day Mocaccino (Hangat / Dingin) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Good Day Mocaccino (Hangat / Dingin)',
                'description' => 'Minuman kopi Good Day Mocaccino paduan kopi dan cokelat nikmat berbusa halus, pilihan hangat atau dingin.',
                'price' => 8000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 37. Kopi Good Day Capuccino (Hangat / Dingin) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Good Day Capuccino (Hangat / Dingin)',
                'description' => 'Minuman kopi Good Day Cappuccino dengan foam tebal dan choco granule renyah di atasnya, pilihan hangat atau dingin.',
                'price' => 10000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 38. Kopi Good Day Freeze (Dingin) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Good Day Freeze (Dingin)',
                'description' => 'Minuman kopi Good Day Freeze dingin segar larut seketika dengan es batu untuk kesegaran maksimal.',
                'price' => 11000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 39. Kopi Torabika Creamy Latte (Hangat / Dingin) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Torabika Creamy Latte (Hangat / Dingin)',
                'description' => 'Minuman kopi Torabika Creamy Latte super lembut dengan rasa susu kental gurih, pilihan hangat atau dingin.',
                'price' => 10000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
            // 40. Kopi Torabika Capuccino (Hangat / Dingin) (Stok Habis)
            [
                'category_id' => $minum->id,
                'name' => 'Kopi Torabika Capuccino (Hangat / Dingin)',
                'description' => 'Minuman kopi Torabika Cappuccino berbusa tebal nikmat bertabur butiran choco granule asli, pilihan hangat atau dingin.',
                'price' => 10000,
                'stock' => 0,
                'unit' => 'cup',
                'image' => 'https://images.unsplash.com/photo-1577968897966-3d4325b36b61?auto=format&fit=crop&w=600&q=80',
                'status' => 'unavailable',
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(
                ['name' => $prod['name']],
                $prod
            );
        }
    }
}
