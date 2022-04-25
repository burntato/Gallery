<?php

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // public function refresh() {
    //     shell_exec('php artisan migrate:refresh --seed');
    // }

    public function test_login_admin()
    {

        $this->withoutExceptionHandling();

        $response = $this->get('/login');

        $response = $this->from('/login')->post('/login', [
            'email' => 'superadmin@gmail.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/dashboard');


    }

    public function test_lihat_halaman_image_management() {

        $this->withoutExceptionHandling();

        $this->test_login_admin();

        $response = $this->get('/image-management/image');
        $response->assertSeeText('Image Management');
    }

    public function test_tambah_image() {

        $this->withoutExceptionHandling();

        $this->test_login_admin();
        $this->test_lihat_halaman_image_management();

        $response = $this->get('/image-management/create');
        $response->assertSeeText('Tambah Gambar');

        $response = $this->from('/image-management/create')->post('/image-management/store', [
            'name' => 'imagetest',
            'file_name' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect('/image-management/image');
        $response = $this->get('/image-management/image');

        $response->assertSeeText('imagetest');
    }

    public function test_edit_image() {

        $this->withoutExceptionHandling();

        $this->test_login_admin();
        $this->test_lihat_halaman_image_management();

        $response = $this->get('/image-management/image');

        $response->assertSeeText('imagetest');

        $response = $this->get('/image-management/edit/1');
        $response->assertSeeText('Validasi Edit Data Gambar');

        $response = $this->from('/image-management/edit/1')->put('/image-management/update/1', [
            'name' => 'updatetest',
            'file_name' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect('/image-management/image');
        $response = $this->get('/image-management/image');

        $response->assertSeeText('updatetest');
    }

    public function test_delete_image() {

            $this->withoutExceptionHandling();

            $this->test_login_admin();
            $this->test_lihat_halaman_image_management();

            $response = $this->get('/image-management/image');

            $response->assertSeeText('updatetest');

            $response = $this->delete('/image-management/delete/1');

            $response->assertRedirect('/image-management/image');
            $response = $this->get('/image-management/image');

            $response->assertDontSeeText('updatetest');
    }
}
