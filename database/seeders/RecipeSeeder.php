<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipesData = [
            'Risol Mayo Beef & Egg' => [
                'name' => 'Resep Risol Mayo Beef & Egg Lumer',
                'yield' => '10 Pcs',
                'description' => "1. Buat kulit risol: campurkan tepung terigu, telur, susu cair, garam, dan minyak goreng. Aduk dengan whisk hingga licin tanpa gumpalan, lalu saring. Dadar tipis-tipis di teflon panas hingga matang berpori.\n2. Potong smoked beef memanjang dan belah telur rebus menjadi 6 bagian per butir.\n3. Campur mayones dengan susu kental manis dan sedikit keju cheddar parut hingga saus mayo creamy gurih seimbang.\n4. Ambil selembar kulit, susun 1 potong smoked beef, 1 potong telur rebus, dan beri 1-2 sdm saus mayones.\n5. Lipat seperti amplop dan gulung rapat.\n6. Celupkan risol ke larutan terigu cair, lalu balurkan ke tepung panir kasar hingga tertutup rata.\n7. Goreng dengan minyak panas api sedang hingga kuning keemasan renyah (golden crispy). Tiriskan dan sajikan hangat.",
                'notes' => 'Gunakan api sedang saat menggoreng agar kulit renyah matang merata dan saus mayones tidak bocor keluar.',
                'ingredients' => [
                    ['name' => 'Tepung Terigu Protein Sedang', 'quantity' => 250, 'unit' => 'gram'],
                    ['name' => 'Smoked Beef / Daging Asap', 'quantity' => 10, 'unit' => 'lembar'],
                    ['name' => 'Telur Ayam Rebus', 'quantity' => 3, 'unit' => 'butir'],
                    ['name' => 'Telur Ayam (Adonan Kulit)', 'quantity' => 1, 'unit' => 'butir'],
                    ['name' => 'Mayones Premium', 'quantity' => 200, 'unit' => 'gram'],
                    ['name' => 'Susu Kental Manis', 'quantity' => 2, 'unit' => 'sdm'],
                    ['name' => 'Tepung Panir / Roti Kasar', 'quantity' => 150, 'unit' => 'gram'],
                    ['name' => 'Susu Cair Full Cream', 'quantity' => 400, 'unit' => 'ml'],
                    ['name' => 'Minyak Goreng', 'quantity' => 500, 'unit' => 'ml'],
                ]
            ],
            'Pisang Coklat Crispy' => [
                'name' => 'Resep Pisang Coklat Crispy Lumer',
                'yield' => '10 Pcs',
                'description' => "1. Kupas pisang raja/uli yang manis dan matang, belah memanjang menjadi 2 bagian.\n2. Siapkan kulit lumpia renyah.\n3. Letakkan 1 potong pisang di atas kulit lumpia, taburkan dark cooking chocolate cincang / meses premium dan parutan keju.\n4. Olesi pinggiran kulit lumpia dengan larutan tepung terigu sebagai perekat rapat.\n5. Gulung rapat dan rekatkan kedua ujungnya agar coklat tidak bocor saat dipanaskan.\n6. Panaskan minyak di wajan dengan api sedang, goreng piscok hingga kulit berwarna cokelat keemasan garing renyah.\n7. Angkat, tiriskan, dan nikmati sensasi coklat lumer saat digigit.",
                'notes' => 'Pastikan pinggiran kulit lumpia direkatkan rapat dengan larutan terigu agar coklat tidak lumer keluar mengotori minyak.',
                'ingredients' => [
                    ['name' => 'Pisang Raja / Uli Matang', 'quantity' => 5, 'unit' => 'buah'],
                    ['name' => 'Kulit Lumpia Krispi', 'quantity' => 10, 'unit' => 'lembar'],
                    ['name' => 'Coklat Batang / Meses Premium', 'quantity' => 150, 'unit' => 'gram'],
                    ['name' => 'Keju Cheddar Parut', 'quantity' => 50, 'unit' => 'gram'],
                    ['name' => 'Tepung Terigu (Perekat)', 'quantity' => 2, 'unit' => 'sdm'],
                    ['name' => 'Minyak Goreng', 'quantity' => 500, 'unit' => 'ml'],
                ]
            ],
            'Tahu Bakso Kukus / Goreng' => [
                'name' => 'Resep Tahu Bakso Sapi Khas Yan\'s',
                'yield' => '12 Pcs',
                'description' => "1. Haluskan daging sapi giling segar bersama es batu serut di food processor hingga lembut.\n2. Tambahkan putih telur, bawang putih goreng halus, bawang merah goreng, garam, merica, kaldu sapi bubuk, dan tepung tapioka. Proses kembali hingga adonan kenyal homogen.\n3. Sayat satu sisi tahu pong goreng, masukkan adonan bakso sapi ke dalam tahu hingga padat berisi.\n4. Panaskan kukusan, kukus tahu bakso selama 25-30 menit hingga matang kenyal merata.\n5. Untuk varian goreng: celupkan tahu bakso matang ke kocokan putih telur, lalu goreng di minyak panas hingga luarnya renyah garing.\n6. Sajikan hangat dengan gigitan cabai rawit hijau segar.",
                'notes' => 'Gunakan es batu saat menggiling adonan daging agar suhu adonan tetap dingin dan tekstur bakso kenyal alami tanpa pengenyal buatan.',
                'ingredients' => [
                    ['name' => 'Tahu Pong Goreng Segitiga/Kotak', 'quantity' => 12, 'unit' => 'buah'],
                    ['name' => 'Daging Sapi Giling Segar', 'quantity' => 250, 'unit' => 'gram'],
                    ['name' => 'Tepung Tapioka / Sagu Tani', 'quantity' => 75, 'unit' => 'gram'],
                    ['name' => 'Es Batu Serut', 'quantity' => 50, 'unit' => 'gram'],
                    ['name' => 'Putih Telur Ayam', 'quantity' => 1, 'unit' => 'butir'],
                    ['name' => 'Bawang Putih Goreng Halus', 'quantity' => 3, 'unit' => 'siung'],
                    ['name' => 'Bawang Merah Goreng', 'quantity' => 2, 'unit' => 'sdm'],
                    ['name' => 'Garam, Merica & Kaldu Sapi', 'quantity' => 1, 'unit' => 'sdm'],
                    ['name' => 'Minyak Goreng', 'quantity' => 500, 'unit' => 'ml'],
                ]
            ],
            'Nasi Goreng Jadul Yan\'s' => [
                'name' => 'Resep Nasi Goreng Jadul Bumbu Ulek Terasi',
                'yield' => '1 Porsi',
                'description' => "1. Siapkan nasi putih dingin (tekstur pera tidak lembek).\n2. Ulek halus bumbu: cabai merah, cabai rawit, bawang merah, bawang putih, terasi bakar, dan sedikit kemiri sangrai.\n3. Panaskan minyak di wajan (wok) dengan api besar hingga panas berasap.\n4. Tumis bumbu halus hingga harum dan matang sempurna.\n5. Geser bumbu ke tepi wajan, masukkan 1 butir telur dan orak-arik cepat.\n6. Masukkan suwiran ayam goreng, daun bawang iris, dan nasi putih. Aduk cepat dengan teknik oseng wajan panas (wok hei).\n7. Tambahkan kecap manis khas, garam, kecap asin, dan merica bubuk. Aduk rata hingga seluruh nasi terbalut bumbu dan aroma smokey sedap keluar.\n8. Sajikan dengan telur ceplok setengah matang, kerupuk renyah, dan acar timun segar.",
                'notes' => 'Kunci kelezatan nasi goreng jadul adalah terasi udang yang dibakar terlebih dahulu dan teknik menumis di api besar (wok hei).',
                'ingredients' => [
                    ['name' => 'Nasi Putih Pera Dingin', 'quantity' => 250, 'unit' => 'gram'],
                    ['name' => 'Daging Ayam Suwir Goreng', 'quantity' => 40, 'unit' => 'gram'],
                    ['name' => 'Telur Ayam (1 orak-arik, 1 ceplok)', 'quantity' => 2, 'unit' => 'butir'],
                    ['name' => 'Bawang Merah', 'quantity' => 4, 'unit' => 'siung'],
                    ['name' => 'Bawang Putih', 'quantity' => 2, 'unit' => 'siung'],
                    ['name' => 'Cabai Merah & Rawit', 'quantity' => 4, 'unit' => 'buah'],
                    ['name' => 'Terasi Udang Bakar', 'quantity' => 0.5, 'unit' => 'sdt'],
                    ['name' => 'Kecap Manis Khas Yan\'s', 'quantity' => 1.5, 'unit' => 'sdm'],
                    ['name' => 'Daun Bawang Iris', 'quantity' => 1, 'unit' => 'batang'],
                    ['name' => 'Minyak Goreng / Margarin', 'quantity' => 2, 'unit' => 'sdm'],
                    ['name' => 'Kerupuk & Acar Timun', 'quantity' => 1, 'unit' => 'porsi'],
                ]
            ],
            'Nasi Ayam Sambal Korek' => [
                'name' => 'Resep Nasi Ayam Ungkep Sambal Korek Basah',
                'yield' => '1 Porsi',
                'description' => "1. Ungkep potongan ayam dengan bumbu lengkuas, kunyit, bawang putih, ketumbar, daun salam, dan garam hingga air menyusut dan bumbu meresap.\n2. Goreng ayam ungkep di minyak panas sampai berwarna kuning kecokelatan gurih juicy. Angkat dan tiriskan.\n3. Ulek kasar cabai rawit merah segar, cabai rawit hijau, bawang putih, garam, dan sedikit penyedap rasa di cobek batu.\n4. Panaskan 3 sendok makan minyak goreng sisa menggoreng ayam hingga benar-benar panas mendidih.\n5. Siramkan minyak mendidih langsung ke atas sambal korek di cobek hingga mendesis harum semerbak.\n6. Penyet ayam goreng di cobek sambal korek dan lumuri permukaannya dengan sambal melimpah.\n7. Sajikan dengan sepiring nasi putih pulen hangat, lalapan timun, kol, dan daun kemangi segar.",
                'notes' => 'Minyak siraman wajib sangat panas agar aroma bawang putih mentah dan cabai rawit langsung layu harum tanpa langu.',
                'ingredients' => [
                    ['name' => 'Potongan Daging Ayam (Paha/Dada)', 'quantity' => 150, 'unit' => 'gram'],
                    ['name' => 'Nasi Putih Pulen Hangat', 'quantity' => 200, 'unit' => 'gram'],
                    ['name' => 'Cabai Rawit Merah & Hijau', 'quantity' => 10, 'unit' => 'buah'],
                    ['name' => 'Bawang Putih', 'quantity' => 2, 'unit' => 'siung'],
                    ['name' => 'Bumbu Ungkep Lengkuas Rempah', 'quantity' => 2, 'unit' => 'sdm'],
                    ['name' => 'Garam & Kaldu Jamur', 'quantity' => 0.5, 'unit' => 'sdt'],
                    ['name' => 'Minyak Goreng Panas', 'quantity' => 3, 'unit' => 'sdm'],
                    ['name' => 'Lalapan Timun & Kemangi', 'quantity' => 1, 'unit' => 'porsi'],
                ]
            ],
            'Bakmi Goreng Spesial' => [
                'name' => 'Resep Bakmi Goreng Spesial Telur & Bakso',
                'yield' => '1 Porsi',
                'description' => "1. Rebus mie telur hingga kenyal al dente, tiriskan lalu aduk dengan 1 sdm minyak sayur dan 1 sdm kecap manis.\n2. Haluskan bumbu: bawang putih, kemiri sangrai, merica butir, dan sedikit ebi sangrai.\n3. Panaskan minyak di wajan, tumis bumbu halus hingga harum matang.\n4. Masukkan telur, orak-arik hingga berbutir matang. Masukkan irisan bakso sapi.\n5. Masukkan potongan sayur sawi hijau (caisim) dan kol, tumis cepat hingga sayuran layu segar.\n6. Masukkan mie, beri kecap manis, saus tiram, kecap asin, garam, dan sedikit minyak wijen.\n7. Aduk dan oseng cepat di api besar hingga bumbu tercampur rata dan harum terkaramelisasi.\n8. Angkat, sajikan dengan taburan bawang goreng renyah dan acar cabai rawit.",
                'notes' => 'Gunakan sedikit ebi sangrai dalam bumbu halus untuk memberikan rasa umami gurih khas bakmi oriental klasik.',
                'ingredients' => [
                    ['name' => 'Mie Telur Basah/Kering Kenyal', 'quantity' => 150, 'unit' => 'gram'],
                    ['name' => 'Bakso Sapi Iris', 'quantity' => 3, 'unit' => 'butir'],
                    ['name' => 'Telur Ayam', 'quantity' => 1, 'unit' => 'butir'],
                    ['name' => 'Sawi Hijau & Kol Iris', 'quantity' => 50, 'unit' => 'gram'],
                    ['name' => 'Bawang Putih & Kemiri', 'quantity' => 3, 'unit' => 'siung'],
                    ['name' => 'Kecap Manis', 'quantity' => 2, 'unit' => 'sdm'],
                    ['name' => 'Saus Tiram', 'quantity' => 1, 'unit' => 'sdt'],
                    ['name' => 'Minyak Wijen & Bumbu Halus', 'quantity' => 0.5, 'unit' => 'sdt'],
                    ['name' => 'Bawang Goreng & Acar', 'quantity' => 1, 'unit' => 'sdm'],
                ]
            ],
            'Es Kopi Susu Gula Aren' => [
                'name' => 'Resep Es Kopi Susu Gula Aren Creamy',
                'yield' => '1 Cup (16 oz)',
                'description' => "1. Siapkan shot espresso kental (double shot sekitar 35 ml) dari biji kopi blend pilihan.\n2. Masukkan 25-30 ml sirup gula aren murni ke dasar cup 16 oz.\n3. Masukkan es batu kristal higienis hingga 3/4 penuh cup.\n4. Tuangkan 120 ml susu cair UHT full cream dingin secara perlahan, tambahkan 1 sdm susu evaporasi untuk sentuhan gurih lembut.\n5. Tuangkan espresso shot di lapisan paling atas secara perlahan (pour over) hingga terbentuk gradasi warna 3 layer yang estetik.\n6. Tutup cup dan sajikan. Aduk merata sebelum dinikmati.",
                'notes' => 'Tambahan susu evaporasi memberikan tekstur gurih creamy yang mengikat rasa manis aren dan pahit espresso.',
                'ingredients' => [
                    ['name' => 'Espresso Coffee House Blend', 'quantity' => 35, 'unit' => 'ml'],
                    ['name' => 'Susu UHT Full Cream', 'quantity' => 120, 'unit' => 'ml'],
                    ['name' => 'Sirup Gula Aren Murni', 'quantity' => 25, 'unit' => 'ml'],
                    ['name' => 'Susu Evaporasi / Krimer', 'quantity' => 15, 'unit' => 'ml'],
                    ['name' => 'Es Batu Kristal Higienis', 'quantity' => 1, 'unit' => 'cup'],
                ]
            ],
            'Es Teh Manis Melati' => [
                'name' => 'Resep Es Teh Manis Melati Wangi Segar',
                'yield' => '1 Cup (16 oz)',
                'description' => "1. Seduh daun teh melati pilihan dengan air mendidih selama 5 menit hingga pekat dan aroma wangi melati keluar semerbak. Saring ampas teh.\n2. Masukkan gula pasir murni selagi seduhan teh masih panas, aduk hingga gula larut sempurna.\n3. Siapkan cup saji 16 oz, isi dengan es batu kristal higienis hingga penuh.\n4. Tuangkan seduhan teh manis melati ke dalam cup berisi es batu.\n5. Tutup cup rapat dan sajikan dingin segar penghilang dahaga.",
                'notes' => 'Melarutkan gula pasir saat air teh masih panas mencegah terbentuknya endapan gula di dasar cup dingin.',
                'ingredients' => [
                    ['name' => 'Daun Teh Melati (Jasmine Tea)', 'quantity' => 5, 'unit' => 'gram'],
                    ['name' => 'Air Mendidih', 'quantity' => 200, 'unit' => 'ml'],
                    ['name' => 'Gula Pasir Tebu Murni', 'quantity' => 25, 'unit' => 'gram'],
                    ['name' => 'Es Batu Kristal Higienis', 'quantity' => 1, 'unit' => 'cup'],
                ]
            ],
            'batagor' => [
                'name' => 'Resep Batagor Bandung Renyah Saus Kacang Gurih',
                'yield' => '1 Porsi (4 Pcs)',
                'description' => "1. Haluskan daging ikan tenggiri/ayam giling, campur dengan tepung tapioka, irisan daun bawang, bawang putih halus, telur, garam, gula, dan merica hingga menjadi adonan kenyal homogen.\n2. Potong tahu putih menjadi segitiga, beri sayatan di tengah dan isi dengan 1 sdm adonan batagor.\n3. Ambil selembar kulit pangsit goreng, taruh 1 sdm adonan di tengahnya dan lipat mengerut membentuk bunga pangsit batagor.\n4. Panaskan minyak banyak di wajan, goreng tahu dan pangsit batagor dengan api sedang hingga matang kuning kecokelatan dan renyah garing. Angkat dan tiriskan.\n5. Racik bumbu kacang: haluskan kacang tanah goreng bersama cabai, bawang putih, dan gula merah. Masak dengan sedikit air hingga mengental berminyak.\n6. Gunting batagor di piring saji, siramkan saus kacang gurih melimpah, beri kecap manis dan kucuran jeruk limau segar.",
                'notes' => 'Goreng dengan api sedang-kecil agar adonan di dalam tahu matang kenyal merata tanpa membuat kulit pangsit luar cepat gosong.',
                'ingredients' => [
                    ['name' => 'Daging Ikan Tenggiri / Ayam Giling', 'quantity' => 150, 'unit' => 'gram'],
                    ['name' => 'Tepung Tapioka / Sagu', 'quantity' => 100, 'unit' => 'gram'],
                    ['name' => 'Tahu Putih Segar', 'quantity' => 2, 'unit' => 'kotak'],
                    ['name' => 'Kulit Pangsit Goreng', 'quantity' => 4, 'unit' => 'lembar'],
                    ['name' => 'Telur Ayam', 'quantity' => 1, 'unit' => 'butir'],
                    ['name' => 'Daun Bawang Iris', 'quantity' => 1, 'unit' => 'batang'],
                    ['name' => 'Bumbu Halus Bawang & Merica', 'quantity' => 1, 'unit' => 'sdm'],
                    ['name' => 'Saus Bumbu Kacang Matang', 'quantity' => 4, 'unit' => 'sdm'],
                    ['name' => 'Kecap Manis & Jeruk Limau', 'quantity' => 1, 'unit' => 'sdm'],
                    ['name' => 'Minyak Goreng', 'quantity' => 500, 'unit' => 'ml'],
                ]
            ],
        ];

        $products = Product::all();

        foreach ($products as $product) {
            // Cari data resep berdasarkan kecocokan nama produk
            $recipeInfo = null;
            foreach ($recipesData as $prodName => $data) {
                if (stripos($product->name, $prodName) !== false || stripos($prodName, $product->name) !== false) {
                    $recipeInfo = $data;
                    break;
                }
            }

            // Jika produk belum ada di daftar spesifik di atas, gunakan template resep standar dapur
            if (!$recipeInfo) {
                $recipeInfo = [
                    'name' => 'Resep Dapur ' . $product->name,
                    'yield' => '1 ' . ($product->unit ?? 'Porsi'),
                    'description' => "1. Siapkan seluruh bahan baku segar berkualitas untuk membuat {$product->name}.\n2. Olah bahan sesuai standar higienitas dapur Yan's Food.\n3. Masak dengan racikan bumbu khas hingga matang lezat dan harum menggugah selera.\n4. Tata rapi di wadah saji dan sajikan selagi segar/hangat kepada pelanggan.",
                    'notes' => 'Pastikan takaran dan higienitas selalu terjaga sesuai standar rasa dapur Yan\'s Food.',
                    'ingredients' => [
                        ['name' => 'Bahan Utama ' . $product->name, 'quantity' => 1, 'unit' => $product->unit ?? 'porsi'],
                        ['name' => 'Bumbu Racikan Khas Dapur', 'quantity' => 1, 'unit' => 'sdm'],
                        ['name' => 'Minyak / Pelengkap Saji', 'quantity' => 1, 'unit' => 'porsi'],
                    ]
                ];
            }

            // Simpan atau perbarui resep produk
            $recipe = Recipe::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'name' => $recipeInfo['name'],
                    'yield' => $recipeInfo['yield'],
                    'description' => $recipeInfo['description'],
                    'notes' => $recipeInfo['notes'],
                ]
            );

            // Re-populate ingredients
            $recipe->ingredients()->delete();
            foreach ($recipeInfo['ingredients'] as $ing) {
                RecipeIngredient::create([
                    'recipe_id' => $recipe->id,
                    'ingredient_name' => $ing['name'],
                    'quantity' => $ing['quantity'],
                    'unit' => $ing['unit'],
                    'notes' => null,
                ]);
            }
        }
    }
}
