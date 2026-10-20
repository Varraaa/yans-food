Pemodelan Data · Web & Mobile

# ERD Yan's Food

Satu database MySQL yang melayani Admin Web dan POS Kasir sekaligus — 10 entitas inti: Pengguna, Kategori Produk, Produk, Resep Dapur, Bahan Baku Resep, Transaksi Kasir POS, Item Transaksi, Kategori Biaya Operasional, Pengeluaran Dapur, dan Konfigurasi Printer Kasir.

```mermaid
erDiagram
    USERS ||--o{ TRANSACTIONS : "cashier_id"
    USERS ||--o{ EXPENSES : "created_by"

    PRODUCT_CATEGORIES ||--o{ PRODUCTS : "category_id"
    PRODUCTS ||--o{ RECIPES : "product_id"
    RECIPES ||--o{ RECIPE_INGREDIENTS : "recipe_id"
    PRODUCTS ||--o{ TRANSACTION_ITEMS : "product_id"
    TRANSACTIONS ||--o{ TRANSACTION_ITEMS : "transaction_id"
    EXPENSE_CATEGORIES ||--o{ EXPENSES : "category_id"

    USERS {
        bigint id PK
        varchar name
        varchar email UK
        varchar password
        enum role "admin, cashier"
        timestamp created_at
        timestamp updated_at
    }

    PRODUCT_CATEGORIES {
        bigint id PK
        varchar name
        timestamp created_at
        timestamp updated_at
    }

    PRODUCTS {
        bigint id PK
        bigint category_id FK
        varchar name
        text description
        decimal price
        int stock
        varchar unit
        varchar image
        enum status "available, unavailable"
        timestamp created_at
        timestamp updated_at
    }

    RECIPES {
        bigint id PK
        bigint product_id FK
        varchar name
        text description
        int yield
        text notes
        timestamp created_at
        timestamp updated_at
    }

    RECIPE_INGREDIENTS {
        bigint id PK
        bigint recipe_id FK
        varchar ingredient_name
        decimal quantity
        varchar unit
        text notes
        timestamp created_at
        timestamp updated_at
    }

    TRANSACTIONS {
        bigint id PK
        varchar transaction_number UK
        date transaction_date
        time transaction_time
        bigint cashier_id FK
        decimal subtotal
        decimal discount
        decimal total
        enum payment_method "CASH"
        decimal amount_paid
        decimal change
        enum status "completed, cancelled"
        timestamp created_at
        timestamp updated_at
    }

    TRANSACTION_ITEMS {
        bigint id PK
        bigint transaction_id FK
        bigint product_id FK
        varchar product_name "snapshot"
        int quantity
        decimal unit_price "snapshot"
        decimal subtotal
        timestamp created_at
        timestamp updated_at
    }

    EXPENSE_CATEGORIES {
        bigint id PK
        varchar name
        timestamp created_at
        timestamp updated_at
    }

    EXPENSES {
        bigint id PK
        varchar expense_number UK
        date expense_date
        enum expense_type "ONE_TIME, RECURRING"
        bigint category_id FK
        varchar name
        decimal amount
        varchar payment_method
        date period_start
        date period_end
        text description
        varchar receipt_image
        varchar status
        bigint created_by FK
        timestamp created_at
        timestamp updated_at
    }

    PRINTERS {
        bigint id PK
        varchar name
        enum connection_type "bluetooth, usb, network"
        enum paper_width "58mm, 80mm"
        enum status "active, inactive"
        json settings
        timestamp created_at
        timestamp updated_at
    }
```

**PK** primary key **FK** foreign key **UK** unique key **||--o{** satu ke banyak (1:N)

## Prinsip Model yang Diterapkan

SNAPSHOT

`product_name` & `unit_price` disalin permanen ke `transaction_items` saat transaksi dibuat, bukan di-lookup ulang ke `products` — supaya nota lama tetap akurat walau harga produk berubah di kemudian hari.

NO HARD DELETE

Produk yang sudah pernah terpakai di transaksi kasir tidak boleh dihapus secara permanen dari database — cukup diubah statusnya menjadi `unavailable`. Seluruh riwayat transaksi kasir dan laporan omset tetap utuh.

SERVER-SIDE TOTAL

`subtotal`, `total`, dan `change` selalu dihitung ulang oleh backend dari harga di database pada POS kasir. Client tidak pernah menjadi sumber kebenaran angka transaksi.

POTONG STOK OTOMATIS

Trigger MySQL `trg_after_transaction_item_insert` secara otomatis memotong stok produk saat detail item transaksi kasir berhasil tersimpan.

PESAN ONLINE & TAKEAWAY = INTEGRASI PLATFORM & WA

Link ShopeeFood / GoFood / GrabFood dan tombol Takeaway WhatsApp pada website company profile publik bersifat direct link & URL generator — tidak memerlukan tabel transaksional di database internal karena transaksi delivery diproses oleh mitra platform dan chat WhatsApp.

## Kardinalitas Relasi

| Entitas Induk | Relasi | Entitas Anak | Makna |
| --- | --- | --- | --- |
| `product_categories` | 1 : N | `products` | Satu kategori menaungi banyak produk |
| `products` | 1 : N | `recipes` | Satu produk bisa punya beberapa resep/BOM |
| `recipes` | 1 : N | `recipe_ingredients` | Satu resep terdiri dari beberapa bahan baku |
| `transactions` | 1 : N | `transaction_items` | Satu struk kasir POS berisi beberapa item menu |
| `products` | 1 : N | `transaction_items` | Satu produk muncul di banyak transaksi |
| `expense_categories` | 1 : N | `expenses` | Satu kategori menaungi banyak pengeluaran operasional |
| `users` | 1 : N | `transactions, expenses` | Jejak kasir/admin yang menginput transaksi & pengeluaran (audit trail) |

Yan's Food — Laravel · MySQL 8.x · POS Kasir, Manajemen Produk & Company Profile