<?php

namespace Database\Seeders;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Service;
use App\Models\ServicesImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BarberShopServicesSeeder extends Seeder
{
    private const SERVICES = [
        [
            'name' => 'Coupe Homme',
            'description' => 'Une coupe nette et personnalisée, du style classique au dégradé moderne.',
            'price' => 50,
            'duration' => 30,
            'image' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=900&q=85',
        ],
        [
            'name' => 'Coupe + Barbe',
            'description' => 'Le duo essentiel : coupe soignée, barbe sculptée et serviette chaude.',
            'price' => 80,
            'duration' => 45,
            'image' => 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=900&q=85',
        ],
        [
            'name' => 'Dégradé / Fade',
            'description' => 'Un dégradé précis, réalisé selon votre style : low, mid ou high fade.',
            'price' => 70,
            'duration' => 40,
            'image' => 'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=900&q=85',
        ],
        [
            'name' => 'Barbe Seulement',
            'description' => 'Taille, contours définis et soin pour une barbe impeccable.',
            'price' => 30,
            'duration' => 20,
            'image' => 'https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=900&q=85',
        ],
        [
            'name' => 'Coupe Enfant',
            'description' => 'Une coupe confortable et adaptée aux petits, avec douceur et patience.',
            'price' => 40,
            'duration' => 25,
            'image' => 'https://images.unsplash.com/photo-1512690459411-b9245aed614b?w=900&q=85',
        ],
        [
            'name' => 'Soin Visage + Coupe',
            'description' => 'Nettoyage et soin du visage associés à une coupe premium.',
            'price' => 120,
            'duration' => 60,
            'image' => 'https://images.unsplash.com/photo-1517832606299-7ae9b720a186?w=900&q=85',
        ],
        [
            'name' => 'Coloration',
            'description' => 'Une coloration réalisée par un professionnel, adaptée à votre look.',
            'price' => 100,
            'duration' => 50,
            'image' => 'https://images.unsplash.com/photo-1605497788044-5a32c7078486?w=900&q=85',
        ],
    ];

    public function run(): void
    {
        $owner = User::firstOrCreate(
            ['email' => 'demo@barberchop.test'],
            [
                'name' => 'BarberChop Demo',
                'password' => Hash::make(Str::random(40)),
            ]
        );

        $shop = BarberShop::firstOrCreate(
            ['name' => 'BarberChop Centre'],
            [
                'address' => 'Centre-ville',
                'city' => 'Ben Guerir',
                'zip' => '43150',
                'user_id' => $owner->id,
            ]
        );

        BarberMan::firstOrCreate([
            'name' => 'Youssef',
            'barbershop_id' => $shop->id,
        ]);

        foreach (self::SERVICES as $serviceData) {
            $service = Service::updateOrCreate(
                ['name' => $serviceData['name'], 'barbershop_id' => $shop->id],
                [
                    'description' => $serviceData['description'],
                    'price' => $serviceData['price'],
                    'duration' => $serviceData['duration'],
                ]
            );

            ServicesImage::updateOrCreate(
                ['service_id' => $service->id, 'is_primary' => true],
                ['path' => $serviceData['image']]
            );
        }
    }
}
