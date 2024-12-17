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
            [
                'name' => 'John Martyn',
                'spotify_id' => '7HGNYPmbDrMkylWqeFCOIQ',
                'spotify_uri' => 'spotify:artist:7HGNYPmbDrMkylWqeFCOIQ',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb7a487027eb0c10af725d5410'
            ],
            [
                'name' => 'Kacey Musgraves',
                'spotify_id' => '70kkdajctXSbqSMJbQO424',
                'spotify_uri' => 'spotify:artist:70kkdajctXSbqSMJbQO424',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5ebf6c0bc89c4f8629437852e12'
            ],
            [
                'name' => 'Bon Iver',
                'spotify_id' => '4LEiUm1SRbFMgfqnQTwUbQ',
                'spotify_uri' => 'spotify:artist:4LEiUm1SRbFMgfqnQTwUbQ',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb3f493557c36a93c4c3cf3ee0'
            ],
            [
                'name' => 'Taylor Swift',
                'spotify_id' => '06HL4z0CvFAxyc27GXpf02',
                'spotify_uri' => 'spotify:artist:06HL4z0CvFAxyc27GXpf02',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb6a224073987b930f99adc706'
            ],
            [
                'name' => 'The Weeknd',
                'spotify_id' => '1Xyo4u8uXC1ZmMpatF05PJ',
                'spotify_uri' => 'spotify:artist:1Xyo4u8uXC1ZmMpatF05PJ',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb214f3cf1cbe7139c1e26ffbb'
            ],
            [
                'name' => 'Bruno Mars',
                'spotify_id' => '0du5cEVh5yTK9QJze8zA0C',
                'spotify_uri' => 'spotify:artist:0du5cEVh5yTK9QJze8zA0C',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5ebc36dd9eb55fb0db4911f25dd'
            ],
            [
                'name' => 'Teyana Taylor',
                'spotify_id' => '4ULO7IGI3M2bo0Ap7B9h8A',
                'spotify_uri' => 'spotify:artist:4ULO7IGI3M2bo0Ap7B9h8A',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb0f8b2c5d07d32a7a4caa0424'
            ],
            [
                'name' => 'Paul Simon',
                'spotify_id' => '2CvCyf1gEVhI0mX6aFXmVI',
                'spotify_uri' => 'spotify:artist:2CvCyf1gEVhI0mX6aFXmVI',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb4dab83055bfcf05d5973f9ab'
            ],
            [
                'name' => 'Simon & Garfunkel',
                'spotify_id' => '70cRZdQywnSFp9pnc2WTCE',
                'spotify_uri' => 'spotify:artist:70cRZdQywnSFp9pnc2WTCE',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb9d7ed7d11bdc1f6f6a2236d3'
            ],
            [
                'name' => 'Massive Attack',
                'spotify_id' => '6FXMGgJwohJLUSr5nVlf9X',
                'spotify_uri' => 'spotify:artist:6FXMGgJwohJLUSr5nVlf9X',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb9a25452fe6c987e6ed46e1e8'
            ],
            [
                'name' => 'Kanye West',
                'spotify_id' => '5K4W6rqBFWDnAN6FQUkS6x',
                'spotify_uri' => 'spotify:artist:5K4W6rqBFWDnAN6FQUkS6x',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb867008a971fae0f4d913f63a'
            ],
            [
                'name' => 'Beyonce',
                'spotify_id' => '6vWDO969PvNqNYHIOW5v0m',
                'spotify_uri' => 'spotify:artist:6vWDO969PvNqNYHIOW5v0m',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb12e3f20d05a8d6cfde988715'
            ],
            [
                'name' => 'Charlie Puth',
                'spotify_id' => '6VuMaDnrHyPL1p4EHjYLi7',
                'spotify_uri' => 'spotify:artist:6VuMaDnrHyPL1p4EHjYLi7',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb7a487027eb0c10af725d5410'
            ],
            [
                'name' => 'City and Colour',
                'spotify_id' => '74gcBzlQza1bSfob90yRhR',
                'spotify_uri' => 'spotify:artist:74gcBzlQza1bSfob90yRhR',
                'spotify_image_url' => 'https://i.scdn.co/image/ab6761610000e5eb7a487027eb0c10af725d5410'
            ]
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }
    }
}
