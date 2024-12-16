<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = [
            ['name' => 'John Martyn', 'spotify_id' => '3JulrApLVT81sb2HkfwMks'],
            ['name' => 'Kacey Musgraves', 'spotify_id' => '70kkdajctXSbqSMJbQQ424'],
            ['name' => 'Bon Iver', 'spotify_id' => '4LEiUm1SRDFMgfqnQTwUbQ'],
            ['name' => 'Taylor Swift', 'spotify_id' => '06HL4z0CvFAxyc27GXpf02'],
            ['name' => 'The Weeknd', 'spotify_id' => '1Xyo4u8uXC1ZmMpatF05PJ'],
            ['name' => 'Bruno Mars', 'spotify_id' => '0du5cEVh5yTsAgAOC8UZK2'],
            ['name' => 'Teyana Taylor', 'spotify_id' => '4ULO7IGI3M2boOAp7B9h8a'],
            ['name' => 'Paul Simon', 'spotify_id' => '2CvCyf1gEVhI0mX6aFXmVI'],
            ['name' => 'Simon & Garfunkel', 'spotify_id' => '70cRZdQywnSFp9pnc2WTCE'],
            ['name' => 'Massive Attack', 'spotify_id' => '6FXMGgJwohJLUSr5nVff9X'],
            ['name' => 'Kanye West', 'spotify_id' => '5K4W6rqBFWDnAN6FQUkS6x'],
            ['name' => 'Beyonce', 'spotify_id' => '6BbqU3r1G2mwkRfIbkCek'],
            ['name' => 'Charlie Puth', 'spotify_id' => '6VuMaMtEHYLTBEHjYLi7'],
            ['name' => 'City and Colour', 'spotify_id' => '74gcBzI2za1bSfob90yRhR'],
            ['name' => 'Tom Petty', 'spotify_id' => '2UZMIlwnkgAEDBsw1Rejkn'],
            ['name' => 'Traveling Wilburys', 'spotify_id' => '2hO4YtXUFJiUYS2uYFvHNK'],
            ['name' => 'MIKE DEAN', 'spotify_id' => '5TAIpisiquAkq2o7lzMJyc'],
            ['name' => 'Barenaked Ladies', 'spotify_id' => '0dEvJpkqhrcn64d3oI8v79'],
            ['name' => 'Pink Floyd', 'spotify_id' => '0k17h0D3J5VfsdmQ1TiZiE9'],
            ['name' => 'Leonard Cohen', 'spotify_id' => '5i8VQNuIg0uM21VM9ZV'],
            ['name' => 'Jennifer Warnes', 'spotify_id' => '1BwHztAQKypBuyDWBEdJnG'],
            ['name' => 'Supertramp', 'spotify_id' => '3JsMj0DEzyWc0VDlHuy9Bx'],
            ['name' => 'TesseracT', 'spotify_id' => '23ytwhG1pzX6DIVWRWyW1r'],
            ['name' => 'Outkast', 'spotify_id' => '1G9G7WwrXka3Z1r7aiDlj7'],
            ['name' => 'Peter Gabriel', 'spotify_id' => '7C4sUpWGiTy7IANjrui02I'],
            ['name' => 'Phil Collins', 'spotify_id' => '4IxfqrEsLX6N1N4OCSkiLp'],
            ['name' => 'Genesis', 'spotify_id' => '3CkvROUTQ6nRi9yQOcsB50'],
            ['name' => 'Guns N Roses', 'spotify_id' => '3qm84nBOXUEQ2vnTfUTTFC'],
            ['name' => 'Buckethead', 'spotify_id' => '0IDF0jImdouCIeWhNnbIwV'],
            ['name' => 'My Chemical Romance', 'spotify_id' => '7FBcuc1gsnv6Y1nwFtNRCb'],
            ['name' => 'Bob Marley & The Wailers', 'spotify_id' => '2QsynagSdAqZj3U9HgDzjD'],
            ['name' => 'Radiohead', 'spotify_id' => '4Z8W4fKeB5YxbusRsdQVPb'],
            ['name' => 'Kendrick Lamar', 'spotify_id' => '2Y7yLoL8N0Wb9xBt1NhZWg'],
            ['name' => 'Fleetwood Mac', 'spotify_id' => '08GQAIAeElDnROE0R6E0X'],
            ['name' => 'Nirvana', 'spotify_id' => '6olE6TJLqED3rqDCT0FyPh'],
            ['name' => 'Marvin Gaye', 'spotify_id' => '3koiLjNrgRTNbOWViDiPeA'],
            ['name' => 'The Beach Boys', 'spotify_id' => '3oDbviivRWNXXhXXXwVVKV'],
            ['name' => 'Stevie Wonder', 'spotify_id' => '7guDJrEfX3qb6FbdPA5ql'],
            ['name' => 'Eric Clapton', 'spotify_id' => '6PAt55BZEZl0DmdXInJMgD'],
            ['name' => 'Bob Dylan', 'spotify_id' => '74A8ZWbe4iXauBB36ztrGX'],
            ['name' => 'The Beatles', 'spotify_id' => '3WrFJ7ztbogyGnTHbHJFl2'],
            ['name' => 'Megadeth', 'spotify_id' => '1Yox196W7bzVNZl7RBaPnf'],
            ['name' => 'Rush', 'spotify_id' => '2Hkut4rAAyTQxRdof7FVJq'],
            ['name' => 'Iron Maiden', 'spotify_id' => '6mdiAmATAx73kdxrNrnlao'],
            ['name' => 'Styx', 'spotify_id' => '4saIDzk6mfycRqNUbyBphh'],
            ['name' => 'The Pursuit Of Happiness', 'spotify_id' => '0IVGx5D7ylsycWxIdGXMt0'],
            ['name' => 'Annie Lennox', 'spotify_id' => '5M5pMQqdVbdwVBqXIdGXMt0']
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }
    }
}
