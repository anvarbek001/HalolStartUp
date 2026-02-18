<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TumanSeeder extends Seeder
{
    public function run(): void
    {
        // Viloyat ID larini order bo'yicha olamiz
        $viloyats = DB::table('viloyats')->orderBy('order')->pluck('id', 'order');

        // order => viloyat_id
        $andijon     = $viloyats[1];   // Andijon viloyati
        $buxoro      = $viloyats[2];   // Buxoro viloyati
        $fargona     = $viloyats[3];   // Farg'ona viloyati
        $jizzax      = $viloyats[4];   // Jizzax viloyati
        $namangan    = $viloyats[5];   // Namangan viloyati
        $navoiy      = $viloyats[6];   // Navoiy viloyati
        $qashqa      = $viloyats[7];   // Qashqadaryo viloyati
        $qaraqalpoq  = $viloyats[8];   // Qoraqalpog'iston
        $samarqand   = $viloyats[9];   // Samarqand viloyati
        $sirdaryo    = $viloyats[10];  // Sirdaryo viloyati
        $surxon      = $viloyats[11];  // Surxondaryo viloyati
        $tsh_shahar  = $viloyats[12];  // Toshkent shahri
        $tsh_viloyat = $viloyats[13];  // Toshkent viloyati
        $xorazm      = $viloyats[14];  // Xorazm viloyati

        $tumanlar = [

            // ─── 1. ANDIJON VILOYATI ───────────────────────────────
            ['viloyat_id' => $andijon, 'name' => 'Andijon tumani',        'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Asaka tumani',          'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Baliqchi tumani',       'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Bo\'z tumani',          'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Buloqboshi tumani',     'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Izboskan tumani',       'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Jalaquduq tumani',      'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Xo\'jaobod tumani',     'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Marhamat tumani',       'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Oltinko\'l tumani',     'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Paxtaobod tumani',      'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Qo\'rg\'ontepa tumani', 'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Shahrixon tumani',      'order' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $andijon, 'name' => 'Ulug\'nor tumani',      'order' => 14, 'created_at' => now(), 'updated_at' => now()],

            // ─── 2. BUXORO VILOYATI ────────────────────────────────
            ['viloyat_id' => $buxoro, 'name' => 'Buxoro tumani',          'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'G\'ijduvon tumani',      'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Jondor tumani',          'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Kogon tumani',           'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Olot tumani',            'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Peshku tumani',          'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Qorako\'l tumani',       'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Qorovulbozor tumani',    'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Romitan tumani',         'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Shofirkon tumani',       'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $buxoro, 'name' => 'Vobkent tumani',         'order' => 11, 'created_at' => now(), 'updated_at' => now()],

            // ─── 3. FARG'ONA VILOYATI ──────────────────────────────
            ['viloyat_id' => $fargona, 'name' => 'Oltiariq tumani',       'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Bag\'dod tumani',       'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Beshariq tumani',       'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Buvayda tumani',        'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Dang\'ara tumani',      'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Farg\'ona tumani',      'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Furqat tumani',         'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Qo\'shtepa tumani',     'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Quva tumani',           'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Rishton tumani',        'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'So\'x tumani',          'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Toshloq tumani',        'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Uchko\'prik tumani',    'order' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'O\'zbekiston tumani',   'order' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $fargona, 'name' => 'Yozyovon tumani',       'order' => 15, 'created_at' => now(), 'updated_at' => now()],

            // ─── 4. JIZZAX VILOYATI ────────────────────────────────
            ['viloyat_id' => $jizzax, 'name' => 'Arnasoy tumani',         'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Baxmal tumani',          'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Do\'stlik tumani',       'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Forish tumani',          'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'G\'allaorol tumani',     'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Jizzax tumani',          'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Mirzacho\'l tumani',     'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Paxtakor tumani',        'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Sharof Rashidov tumani', 'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Yangiobod tumani',       'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Zafarobod tumani',       'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $jizzax, 'name' => 'Zarbdor tumani',         'order' => 12, 'created_at' => now(), 'updated_at' => now()],

            // ─── 5. NAMANGAN VILOYATI ──────────────────────────────
            ['viloyat_id' => $namangan, 'name' => 'Chortoq tumani',       'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Chust tumani',         'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Kosonsoy tumani',      'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Mingbuloq tumani',     'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Namangan tumani',      'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Narbuta tumani',       'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Pop tumani',           'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'To\'raqo\'rg\'on tumani', 'order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Uchqo\'rg\'on tumani', 'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Uychi tumani',         'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $namangan, 'name' => 'Yangiqo\'rg\'on tumani', 'order' => 11, 'created_at' => now(), 'updated_at' => now()],

            // ─── 6. NAVOIY VILOYATI ────────────────────────────────
            ['viloyat_id' => $navoiy, 'name' => 'Karmana tumani',         'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Xatirchi tumani',        'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Konimex tumani',         'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Navoiy tumani',          'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Navbahor tumani',        'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Nurota tumani',          'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Qiziltepa tumani',       'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Tomdi tumani',           'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $navoiy, 'name' => 'Uchquduq tumani',        'order' => 9,  'created_at' => now(), 'updated_at' => now()],

            // ─── 7. QASHQADARYO VILOYATI ───────────────────────────
            ['viloyat_id' => $qashqa, 'name' => 'Chiroqchi tumani',       'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Dehqonobod tumani',      'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'G\'uzor tumani',         'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Kasbi tumani',           'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Kitob tumani',           'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Koson tumani',           'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Mirishkor tumani',       'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Muborak tumani',         'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Nishon tumani',          'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Qarshi tumani',          'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Qamashi tumani',         'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Shahrisabz tumani',      'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qashqa, 'name' => 'Yakkabog\' tumani',      'order' => 13, 'created_at' => now(), 'updated_at' => now()],

            // ─── 8. QORAQALPOG'ISTON ───────────────────────────────
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Amudaryo tumani',    'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Beruniy tumani',     'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Chimboy tumani',     'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Ellikkala tumani',   'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Kegeyli tumani',     'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Mo\'ynoq tumani',    'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Nukus tumani',       'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Qanlikol tumani',    'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Qo\'ng\'irot tumani', 'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Qorao\'zak tumani',  'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Shumanay tumani',    'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Taxtako\'pir tumani', 'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'To\'rtko\'l tumani', 'order' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $qaraqalpoq, 'name' => 'Xo\'jayli tumani',   'order' => 14, 'created_at' => now(), 'updated_at' => now()],

            // ─── 9. SAMARQAND VILOYATI ─────────────────────────────
            ['viloyat_id' => $samarqand, 'name' => 'Bulung\'ur tumani',   'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Ishtixon tumani',     'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Jomboy tumani',       'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Kattaqo\'rg\'on tumani', 'order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Narpay tumani',       'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Nurobod tumani',      'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Oqdaryo tumani',      'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Pastdarg\'om tumani', 'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Payariq tumani',      'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Qo\'shrabot tumani',  'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Samarqand tumani',    'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Toyloq tumani',       'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $samarqand, 'name' => 'Urgut tumani',        'order' => 13, 'created_at' => now(), 'updated_at' => now()],

            // ─── 10. SIRDARYO VILOYATI ─────────────────────────────
            ['viloyat_id' => $sirdaryo, 'name' => 'Boyovut tumani',       'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Guliston tumani',      'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Mirzaobod tumani',     'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Oqoltin tumani',       'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Sardoba tumani',       'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Sayxunobod tumani',    'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Sirdaryo tumani',      'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Xovos tumani',         'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $sirdaryo, 'name' => 'Yangiyer tumani',      'order' => 9,  'created_at' => now(), 'updated_at' => now()],

            // ─── 11. SURXONDARYO VILOYATI ──────────────────────────
            ['viloyat_id' => $surxon, 'name' => 'Angor tumani',           'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Bandixon tumani',        'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Boysun tumani',          'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Denov tumani',           'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Jarqo\'rg\'on tumani',   'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Muzrabot tumani',        'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Oltinsoy tumani',        'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Qiziriq tumani',         'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Qumqo\'rg\'on tumani',   'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Sariosiyo tumani',       'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Sherobod tumani',        'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Sho\'rchi tumani',       'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Termiz tumani',          'order' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $surxon, 'name' => 'Uzun tumani',            'order' => 14, 'created_at' => now(), 'updated_at' => now()],

            // ─── 12. TOSHKENT SHAHRI ───────────────────────────────
            ['viloyat_id' => $tsh_shahar, 'name' => 'Bektemir tumani',    'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Chilonzor tumani',   'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Hamza tumani',       'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Mirobod tumani',     'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Mirzo Ulug\'bek tumani', 'order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Olmazor tumani',     'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Sergeli tumani',     'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Shayxontohur tumani', 'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Uchtepa tumani',     'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Yakkasaroy tumani',  'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Yashnobod tumani',   'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_shahar, 'name' => 'Yunusobod tumani',   'order' => 12, 'created_at' => now(), 'updated_at' => now()],

            // ─── 13. TOSHKENT VILOYATI ─────────────────────────────
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Angren tumani',     'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Bekobod tumani',    'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Bo\'stonliq tumani', 'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Bо\'ka tumani',     'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Chinoz tumani',     'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Qibray tumani',     'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Ohangaron tumani',  'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Oqqo\'rg\'on tumani', 'order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Parkent tumani',    'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Piskent tumani',    'order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Toshkent tumani',   'order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'O\'rtachirchiq tumani', 'order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Quyi Chirchiq tumani', 'order' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Yuqori Chirchiq tumani', 'order' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $tsh_viloyat, 'name' => 'Zangiota tumani',   'order' => 15, 'created_at' => now(), 'updated_at' => now()],

            // ─── 14. XORAZM VILOYATI ───────────────────────────────
            ['viloyat_id' => $xorazm, 'name' => 'Bog\'ot tumani',         'order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Gurlan tumani',          'order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Hazorasp tumani',        'order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Xiva tumani',            'order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Xonqa tumani',           'order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Qo\'shko\'pir tumani',   'order' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Urganch tumani',         'order' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Shovot tumani',          'order' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Yangiariq tumani',       'order' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['viloyat_id' => $xorazm, 'name' => 'Yangibozor tumani',      'order' => 10, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('tumen')->insertOrIgnore($tumanlar);
    }
}
