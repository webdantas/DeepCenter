<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateDefaultAvatar extends Command
{
    protected $signature = 'make:default-avatar';
    protected $description = 'Create default avatar image';

    public function handle()
    {
        $manager = new ImageManager(new Driver());
        
        // Create a blank image
        $img = $manager->canvas(200, 200, '#EBF4FF');
        
        // Add text
        $img->text('DC', 100, 100, function($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(72);
            $font->color('#7F9CF5');
            $font->align('center');
            $font->valign('middle');
        });
        
        // Save the image
        $path = public_path('images/default-avatar.png');
        $img->save($path);
        
        $this->info('Default avatar created at: ' . $path);
    }
}