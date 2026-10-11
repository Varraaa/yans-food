Pemodelan Data · Web & Mobile

# ERD Yan's Food

Satu database MySQL yang melayani Admin Web (Filament) dan Admin Mobile (Android) sekaligus — 13 entitas inti, diturunkan langsung dari spesifikasi fungsional dan hasil brainstorming modul Catering.

```mermaid
erDiagram
    USERS ||--o{ TRANSACTIONS : "cashier_id"
    USERS ||--o{ CATERING_ORDERS : "created_by"
    USERS ||--o{ CATERING_PAYMENTS : "received_by"
    USERS ||--o{ EXPENSES : "created_by"

    PRODUCT_CATEGORIES ||--o{ PRODUCTS : "category_id"
    PRODUCTS ||--o{ RECIPES : "product_id"
    RECIPES ||--o{ RECIPE_INGREDIENTS : "recipe_id"
    PRODUCTS ||--o{ TRANSACTION_ITEMS : "product_id"
    TRANSACTIONS ||--o{ TRANSACTION_ITEMS : "transaction_id"
    PRODUCTS ||--o{ CATERING_ORDER_ITEMS : "product_id"
    CATERING_ORDERS ||--o{ CATERING_ORDER_ITEMS : "catering_order_id"
    CATERING_ORDERS ||--o{ CATERING_PAYMENTS : "catering_order_id"
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

    CATERING_ORDERS {
        bigint id PK
        varchar order_number UK
        varchar customer_name
        varchar customer_phone
        text customer_address
        date event_date
        time event_time
        varchar event_purpose
        text notes
        decimal subtotal
        decimal discount
        decimal total
        enum status "PENDING..CANCELLED"
        enum payment_status "UNPAID, DP, PAID"
        bigint created_by FK
        timestamp created_at
        timestamp updated_at
    }

    CATERING_ORDER_ITEMS {
        bigint id PK
        bigint catering_order_id FK
        bigint product_id FK
        varchar product_name "snapshot"
        int quantity
        decimal unit_price "snapshot"
        decimal subtotal
        timestamp created_at
        timestamp updated_at
    }

    CATERING_PAYMENTS {
        bigint id PK
        bigint catering_order_id FK
        varchar payment_number UK
        enum payment_type "CASH, DP, PELUNASAN"
        decimal amount
        varchar payment_method
        date payment_date
        bigint received_by FK
        text notes
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

Setiap aturan di bawah ini berasal langsung dari spesifikasi & brainstorming modul Catering — bukan asumsi tambahan.

SNAPSHOT

`product_name` & `unit_price` disalin ke `transaction_items` dan `catering_order_items` saat transaksi dibuat, bukan di-lookup ulang ke `products` — supaya nota lama tetap akurat walau harga produk berubah di kemudian hari.

NO HARD DELETE

Produk yang sudah pernah terpakai di transaksi tidak boleh dihapus permanen — cukup diubah statusnya ke `unavailable`. Riwayat & laporan tetap utuh.

SERVER-SIDE TOTAL

`subtotal`, `total`, dan `change` selalu dihitung ulang oleh backend dari harga di database — baik di POS maupun form Pesan Katering publik. Client tidak pernah jadi sumber kebenaran angka.

DUA STATUS TERPISAH

`catering_orders.status` (progres pekerjaan) dan `payment_status` (progres pembayaran) independen satu sama lain — order `COMPLETED` tidak otomatis berarti `PAID`.

AGREGAT, BUKAN TABEL BARU

Page *Penghasilan Catering* dan section *Laporan Catering* tidak punya tabel sendiri — keduanya query agregat dari `catering_payments` ⋈ `catering_orders`.

PESAN ONLINE = KONFIG

Link ShopeeFood / GoFood / GrabFood di halaman Pesan & footer bersifat konten statis/pengaturan — sengaja tidak dimodelkan sebagai tabel transaksional karena checkout terjadi sepenuhnya di platform pihak ketiga.

## Kardinalitas Relasi

| Entitas Induk | Relasi | Entitas Anak | Makna |
| --- | --- | --- | --- |
| `product_categories` | 1 : N | `products` | Satu kategori menaungi banyak produk |
| `products` | 1 : N | `recipes` | Satu produk bisa punya beberapa resep/BOM |
| `recipes` | 1 : N | `recipe_ingredients` | Satu resep terdiri dari beberapa bahan |
| `transactions` | 1 : N | `transaction_items` | Satu struk POS berisi beberapa item |
| `products` | 1 : N | `transaction_items` | Satu produk muncul di banyak transaksi |
| `catering_orders` | 1 : N | `catering_order_items` | Satu pesanan katering berisi beberapa produk |
| `catering_orders` | 1 : N | `catering_payments` | Satu pesanan bisa dibayar bertahap (DP + Pelunasan) |
| `expense_categories` | 1 : N | `expenses` | Satu kategori menaungi banyak pengeluaran |
| `users` | 1 : N | `transactions, catering_orders, catering_payments, expenses` | Jejak siapa yang input/terima/mencatat (audit trail) |

Yan's Food — Laravel 13 · Filament v3 · MySQL 8.x · dikonsumsi bersama oleh Admin Web & Mobile via REST API yang sama