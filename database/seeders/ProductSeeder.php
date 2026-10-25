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
                'image' => 'images/Menu/Ketan Goreng.png',
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
                'image' => 'images/Menu/Pisang Coklat.png',
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
                'image' => 'images/Menu/Cireng Rujak.png',
                'status' => 'available',
            ],
            // 4. Stik Sosis
            [
                'category_id' => $ringan->id,
                'name' => 'Stik Sosis',
                'description' => 'Satu porsi berisi 5 pcs stik sosis gurih lezat, saus dan mayones, tanpa nasi. Bisa disajikan matang atau frozen.',
                'price' => 10500,
                'stock' => 30,
                'unit' => 'porsi',
                'image' => 'images/Menu/Stick Sosis.png',
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
                'image' => 'images/Menu/Kroket Bihun Sayur.png',
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
                'image' => 'images/Menu/Stick Keju Mozarela.png',
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
                'image' => 'images/Menu/Risol Mayo.png',
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
                'image' => 'images/Menu/Dimsum Ayam.png',
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
                'image' => 'images/Menu/Dimsum Udang.png',
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
                'image' => 'images/Menu/Dimsum Mix.png',
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
                'image' => 'images/Menu/Pangsit Ayam.png',
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
                'image' => 'images/Menu/Dimsum Jamur.png',
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
                'image' => 'images/Menu/Nasi Nugget Stick Sosis.png',
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
                'image' => 'images/Menu/Nasi Chicken Nugget.png',
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
                'image' => 'images/Menu/Nasi Stick Sosis.png',
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
                'image' => 'images/Menu/Nasi Chicken Katsu.png',
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
                'image' => 'images/Menu/Nugget Ayam.png',
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
                'image' => 'images/Menu/Nasi Goreng Mawut.png',
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
                'image' => 'images/Menu/Nasi Goreng Cikur.png',
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
                'image' => 'images/Menu/Nasi Goreng Jadul.png',
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
                'image' => 'images/Menu/Nasi Goreng.png',
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
                'image' => 'images/Menu/Nasi Sosis Saus Tiram.png',
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
                'image' => 'images/Menu/Nasi Telur Sosis Orak Arik.png',
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
                'image' => 'images/Menu/Nasi Telur Dadar Sosis.png',
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
                'image' => 'images/Menu/Nasi Telur Ceplok Sosis.png',
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
                'image' => 'images/Menu/Teh Manis.png',
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
                'image' => 'images/Menu/Nutrisari Dingin.png',
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
                'image' => 'images/Menu/Extra Joss.png',
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
                'image' => 'images/Menu/Susu Milo.png',
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
                'image' => 'images/Menu/Susu Kental Manis.png',
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
                'image' => 'images/Menu/Mie Indomie Double.png',
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
                'image' => 'images/Menu/Es Kul Kul Piscok.png',
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
                'image' => 'images/Menu/Kopi Susu ABC.png',
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
                'image' => 'images/Menu/Kopi Good Day Coolin.png',
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
                'image' => 'images/Menu/Kopi Good Day Carrebian Nut.png',
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
                'image' => 'images/Menu/Kopi Good Day Mocaccino.png',
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
                'image' => 'images/Menu/Kopi Good Day Capuccino.png',
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
                'image' => 'images/Menu/Kopi Good Day Freeze.png',
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
                'image' => 'images/Menu/Kopi Torabika Creamy Latte.png',
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
                'image' => 'images/Menu/Kopi Torabika Capuccino.png',
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
