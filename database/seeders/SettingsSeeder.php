<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',        'group' => 'general', 'type' => 'text',  'label_ru' => 'Название сайта',   'value' => 'Company Name'],
            ['key' => 'site_logo',        'group' => 'general', 'type' => 'image', 'label_ru' => 'Логотип',          'value' => null],
            ['key' => 'site_favicon',     'group' => 'general', 'type' => 'image', 'label_ru' => 'Favicon',          'value' => null],

            // Contact
            ['key' => 'contact_phone',   'group' => 'contact', 'type' => 'text',     'label_ru' => 'Телефон',        'value' => '+7 (700) 123-45-67'],
            ['key' => 'contact_email',   'group' => 'contact', 'type' => 'text',     'label_ru' => 'Email',          'value' => 'info@company.kz'],
            ['key' => 'contact_address_ru', 'group' => 'contact', 'type' => 'text', 'label_ru' => 'Адрес (RU)',      'value' => 'г. Алматы'],
            ['key' => 'contact_address_kz', 'group' => 'contact', 'type' => 'text', 'label_ru' => 'Адрес (KZ)',      'value' => 'Алматы қ.'],
            ['key' => 'contact_address_en', 'group' => 'contact', 'type' => 'text', 'label_ru' => 'Адрес (EN)',      'value' => 'Almaty, Kazakhstan'],
            ['key' => 'contact_map',     'group' => 'contact', 'type' => 'textarea', 'label_ru' => 'Google Maps URL', 'value' => ''],

            // Social
            ['key' => 'social_instagram', 'group' => 'social', 'type' => 'text', 'label_ru' => 'Instagram URL', 'value' => ''],
            ['key' => 'social_facebook',  'group' => 'social', 'type' => 'text', 'label_ru' => 'Facebook URL',  'value' => ''],
            ['key' => 'social_linkedin',  'group' => 'social', 'type' => 'text', 'label_ru' => 'LinkedIn URL',  'value' => ''],
            ['key' => 'social_telegram',  'group' => 'social', 'type' => 'text', 'label_ru' => 'Telegram URL',  'value' => ''],

            // SEO
            ['key' => 'seo_title_ru',       'group' => 'seo', 'type' => 'text',     'label_ru' => 'SEO Title (RU)',       'value' => 'Company Name'],
            ['key' => 'seo_description_ru', 'group' => 'seo', 'type' => 'textarea', 'label_ru' => 'SEO Description (RU)', 'value' => ''],
            ['key' => 'seo_keywords_ru',    'group' => 'seo', 'type' => 'text',     'label_ru' => 'SEO Keywords (RU)',    'value' => ''],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $this->command->info('Settings seeded successfully.');
    }
}
