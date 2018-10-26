## kaskus-ht

Example Code
```php
require "src/KaskusHT.php";
use MuhBayu\KaskusHT;

$kaskusht = new KaskusHT();

print $kaskusht->hotthread()->isJson(); // result json

print_r($kaskusht->hotthread()->isArray()); // result array (default: object)
```

### Result
    {
        "success": true,
        "load_time": 0.4969,
        "page": 1,
        "total_pages": "5205",
        "hot_threads": [
            {
                "position": 1,
                "top_star": true,
                "rating": "5",
                "reply": "17",
                "title": "Bilangin Sama Saudara atau Tetangga, Jangan lupa untuk Vaksin Campak &amp; Rubella",
                "detail": "Pentingnya Vaksin Buat Kita Semua GanSis !!",
                "link": "https:\/\/kaskus.co.id\/forum\/hotthread\/\/thread\/5bd08e7a925233d1228b4567\/bilangin-sama-saudara-atau-tetangga-jangan-lupa-untuk-vaksin-campak-amp-rubella\/?ref=htarchive&med=hot_thread",
                "img": "https:\/\/s.kaskus.id\/r720x720\/img\/hot_thread\/hot_thread_fbz1mqrrstno.jpg",
                "user": {
                    "id": "KASKUS.HQ",
                    "profile": "https:\/\/kaskus.co.id\/forum\/hotthread\/\/profile\/3200297\/?ref=htarchive&med=hot_thread",
                    "avatar": "https:\/\/s.kaskus.id\/user\/avatar\/2011\/07\/16\/avatar3200297_2.gif"
                },
                "forum": {
                    "name": "Indonesia Update",
                    "link": "https:\/\/kaskus.co.id\/forum\/hotthread\/\/forum\/857"
                }
            },
            ..................
        ]
    }

