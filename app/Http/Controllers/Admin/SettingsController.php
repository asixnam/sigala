<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Field yang disimpan sebagai JSON array
     */
    private array $jsonFields = [
        'hero_slides',
        'sambutan_slides',
        'features',
        'workflows',
    ];

    /**
     * Menampilkan halaman Settings Admin
     */
    public function index()
    {
        $settingsPath = storage_path('app/settings.json');

        $settings = [];

        if (file_exists($settingsPath)) {
            $json = file_get_contents($settingsPath);

            $settings = json_decode($json, true);

            if (!is_array($settings)) {
                $settings = [];
            }
        }

        return view('admin.settings', compact('settings'));
    }

    /**
     * Menyimpan Settings
     */
    public function update(Request $request)
    {
        $settingsPath = storage_path('app/settings.json');

        /*
         * ==========================================================
         * AMBIL SETTINGS LAMA
         * ==========================================================
         */

        $settings = [];

        if (file_exists($settingsPath)) {
            $json = file_get_contents($settingsPath);

            $settings = json_decode($json, true);

            if (!is_array($settings)) {
                $settings = [];
            }
        }

        /*
         * ==========================================================
         * AMBIL DATA FORM
         * ==========================================================
         */

        $newSettings = $request->except([
            '_token',
            '_method',
        ]);

        /*
         * ==========================================================
         * NORMALISASI JSON FIELD
         * ==========================================================
         *
         * Blade mengirim:
         *
         * hero_slides = JSON.stringify(heroSlides)
         *
         * sehingga Laravel menerima string JSON.
         *
         * Kita ubah kembali menjadi array PHP.
         */

        foreach ($this->jsonFields as $field) {

            if (!$request->has($field)) {
                continue;
            }

            $value = $request->input($field);

            /*
             * Jika string JSON
             */
            if (is_string($value)) {

                $decoded = json_decode($value, true);

                if (
                    json_last_error() === JSON_ERROR_NONE &&
                    is_array($decoded)
                ) {
                    $newSettings[$field] = $decoded;
                } else {
                    /*
                     * Jangan menimpa data lama
                     * jika JSON rusak.
                     */
                    unset($newSettings[$field]);
                }
            }

            /*
             * Jika sudah array
             */
            elseif (is_array($value)) {

                $newSettings[$field] = $value;
            }
        }

        /*
         * ==========================================================
         * NORMALISASI SAMBUTAN SLIDES
         * ==========================================================
         */

        if (
            isset($newSettings['sambutan_slides']) &&
            is_array($newSettings['sambutan_slides'])
        ) {

            foreach (
                $newSettings['sambutan_slides']
                as $index => $slide
            ) {

                if (!is_array($slide)) {
                    continue;
                }

                $newSettings['sambutan_slides'][$index] = array_merge(
                    [
                        'nama'       => '',
                        'jabatan'    => '',
                        'subheading' => '',
                        'title'      => '',
                        'quote'      => '',
                        'desc'       => '',
                        'foto'       => '',
                    ],
                    $slide
                );
            }
        }

        /*
         * ==========================================================
         * NORMALISASI HERO
         * ==========================================================
         */

        if (
            isset($newSettings['hero_slides']) &&
            is_array($newSettings['hero_slides'])
        ) {

            foreach (
                $newSettings['hero_slides']
                as $index => $slide
            ) {

                if (!is_array($slide)) {
                    continue;
                }

                $newSettings['hero_slides'][$index] = array_merge(
                    [
                        'badge'  => '',
                        'title1' => '',
                        'title2' => '',
                        'title3' => '',
                        'desc'   => '',
                        'bg'     => '',
                    ],
                    $slide
                );
            }
        }

        /*
         * ==========================================================
         * NORMALISASI FEATURES
         * ==========================================================
         */

        if (
            isset($newSettings['features']) &&
            is_array($newSettings['features'])
        ) {

            foreach (
                $newSettings['features']
                as $index => $feature
            ) {

                if (!is_array($feature)) {
                    continue;
                }

                $newSettings['features'][$index] = array_merge(
                    [
                        'icon'      => '',
                        'icon_path' => '',
                        'title'     => '',
                        'desc'      => '',
                    ],
                    $feature
                );
            }
        }

        /*
         * ==========================================================
         * NORMALISASI WORKFLOWS
         * ==========================================================
         */

        if (
            isset($newSettings['workflows']) &&
            is_array($newSettings['workflows'])
        ) {

            foreach (
                $newSettings['workflows']
                as $index => $workflow
            ) {

                if (!is_array($workflow)) {
                    continue;
                }

                $newSettings['workflows'][$index] = array_merge(
                    [
                        'badge' => '',
                        'title' => '',
                        'desc'  => '',
                    ],
                    $workflow
                );
            }
        }

        /*
         * ==========================================================
         * SINKRONISASI FOTO BUPATI & KEPALA DINAS
         * ==========================================================
         */

        if (
            isset($newSettings['sambutan_slides']) &&
            is_array($newSettings['sambutan_slides'])
        ) {

            /*
             * Slide pertama = Bupati
             */
            if (
                isset($newSettings['sambutan_slides'][0]) &&
                !empty($newSettings['sambutan_slides'][0]['foto'])
            ) {

                $newSettings['bupati_foto'] =
                    $newSettings['sambutan_slides'][0]['foto'];
            }

            /*
             * Slide kedua = Kepala Dinas
             */
            if (
                isset($newSettings['sambutan_slides'][1]) &&
                !empty($newSettings['sambutan_slides'][1]['foto'])
            ) {

                $newSettings['kadis_foto'] =
                    $newSettings['sambutan_slides'][1]['foto'];
            }
        }

        /*
         * ==========================================================
         * SINKRONISASI SEBALIKNYA
         * ==========================================================
         */

        if (
            isset($newSettings['bupati_foto']) &&
            isset($newSettings['sambutan_slides']) &&
            isset($newSettings['sambutan_slides'][0])
        ) {

            $newSettings['sambutan_slides'][0]['foto'] =
                $newSettings['bupati_foto'];
        }

        if (
            isset($newSettings['kadis_foto']) &&
            isset($newSettings['sambutan_slides']) &&
            isset($newSettings['sambutan_slides'][1])
        ) {

            $newSettings['sambutan_slides'][1]['foto'] =
                $newSettings['kadis_foto'];
        }

        /*
         * ==========================================================
         * GABUNGKAN DATA LAMA + DATA BARU
         * ==========================================================
         */

        $settings = array_merge(
            $settings,
            $newSettings
        );

        /*
         * ==========================================================
         * PASTIKAN FOLDER ADA
         * ==========================================================
         */

        $directory = dirname($settingsPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        /*
         * ==========================================================
         * SIMPAN settings.json
         * ==========================================================
         */

        $saved = file_put_contents(
            $settingsPath,
            json_encode(
                $settings,
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES
            )
        );

        /*
         * Jika gagal menyimpan
         */
        if ($saved === false) {

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan pengaturan.');
        }

        /*
         * ==========================================================
         * SELESAI
         * ==========================================================
         */

        return redirect()
            ->route('admin.settings')
            ->with(
                'success',
                'Pengaturan berhasil disimpan.'
            );
    }
}