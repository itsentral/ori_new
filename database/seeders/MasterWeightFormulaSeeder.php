<?php

namespace Database\Seeders;

use App\Models\MasterWeightFormula;
use Illuminate\Database\Seeder;

class MasterWeightFormulaSeeder extends Seeder
{
    public function run(): void
    {
        // ==============================
        // Formula 1: Pipe Standard (Tipe: Pipe)
        // ==============================
        MasterWeightFormula::updateOrCreate(
            ['formula_code' => 'FRM-001'],
            [
                'formula_name' => 'Pipe Standard',
                'formula_type' => 'pipe',
                'waste_pipe' => [
                    'waste_potongan' => [
                        'rumus' => 'WASTE_LENGTH_LOKAL = 400, WASTE_LENGTH_EKSPOR = 600',
                        'lokal' => 400,
                        'ekspor' => 600,
                    ],
                    'waste_ceceran' => [
                        'rumus' => 'DN 15-80 = 7%, DN 100-350 = 5%, DN 400-3000 = 3%',
                        'ranges' => [
                            ['dn_min' => 15, 'dn_max' => 80, 'value' => 0.07],
                            ['dn_min' => 100, 'dn_max' => 350, 'value' => 0.05],
                            ['dn_min' => 400, 'dn_max' => 3000, 'value' => 0.03],
                        ],
                    ],
                    'waste_diptank' => [
                        'rumus' => 'DN 15-100 = 30%, DN 125-350 = 15%, DN > 350 = 10%',
                        'ranges' => [
                            ['dn_min' => 15, 'dn_max' => 100, 'value' => 0.30],
                            ['dn_min' => 125, 'dn_max' => 350, 'value' => 0.15],
                            ['dn_min' => 351, 'dn_max' => 99999, 'value' => 0.10],
                        ],
                    ],
                    'glass_overlap' => [
                        'rumus' => 'OVERLAP_GLASS = 0.10, FACTOR_OVERLAP_GLASS = 1.1',
                        'overlap_glass' => 0.10,
                        'factor_overlap_glass' => 1.1,
                    ],
                ],
                'luas_area' => [
                    'rumus' => '(3.14 / 1000) * (DIAMETER + THICKNESS) * (panjang_pipa + waste_potongan) / 1000',
                    'note' => 'THICKNESS dari Product Standard',
                ],
                'resin_contain' => [
                    'liner' => [
                        'veil' => '90/10',
                        'csm' => '70/30',
                    ],
                    'structure' => [
                        'csm' => '60/40',
                        'wr' => '50/50',
                        'rooving_1200' => '32/68',
                        'rooving_2400' => '28/72',
                    ],
                ],
                'setting_fw' => [
                    'rumus' => 'Thickness Per Layer berdasarkan Diameter Range',
                    'ranges' => [
                        [
                            'label' => 'DN 15 - DN 125',
                            'thickness_per_layer' => 0.95,
                            'bandwidth' => 50,
                            'jumlah_benang' => 25,
                        ],
                        [
                            'label' => 'DN 150 - DN 350',
                            'thickness_per_layer' => 0.99,
                            'bandwidth' => 100,
                            'jumlah_benang' => 52,
                        ],
                        [
                            'label' => 'DN > 400',
                            'thickness_per_layer' => 1.16,
                            'bandwidth' => 160,
                            'jumlah_benang' => 54,
                        ],
                    ],
                ],
                'glass_config' => [
                    'liner' => [
                        'veil' => 'Tarik dari total layer dari standard liner',
                        'csm' => 'Tarik dari total layer dari standard liner',
                    ],
                    'structure' => [
                        'roving' => 'Tarik dari total layer dari standard structure',
                        'csm' => 'Tarik dari total layer dari standard structure',
                        'wr' => 'Tarik dari total layer dari standard structure',
                    ],
                    'external' => [
                        'veil' => 'Tarik dari total layer dari standard External',
                        'csm' => 'Tarik dari total layer dari standard External',
                    ],
                ],
                'glass_weight' => [
                    'liner' => [
                        'veil' => 'JUMLAH_LAYER_VEIL * BERAT_VEIL * LUAS_AREA / 1000 * OVERLAP_GLASS',
                        'csm' => 'JUMLAH_LAYER_CSM * BERAT_CSM * LUAS_AREA / 1000 * OVERLAP_GLASS',
                    ],
                    'structure' => [
                        'rooving' => 'IF(DN >= 15 AND DN <= 150, 1.2 * ((BERAT_ROVING / 1000) * JUMLAH_BENANG * 100 / (BANDWIDTH / 10)) * 2 / 1000 * JUMLAH_LAYER * LUAS_AREA, 0); IF(DN > 200, 1.15 * ((BERAT_ROVING / 1000) * JUMLAH_BENANG * 100 / (BANDWIDTH / 10)) * 2 / 1000 * JUMLAH_LAYER * LUAS_AREA, 0); IF(DN > 600 AND PINBELT, 1.4 * ((BERAT_ROVING / 1000) * JUMLAH_BENANG * 100 / (BANDWIDTH / 10)) * 2 / 1000 * JUMLAH_LAYER * LUAS_AREA, 0)',
                        'csm' => 'JUMLAH_LAYER * BERAT_CSM * LUAS_AREA / 1000 * OVERLAP_GLASS',
                        'wr' => 'JUMLAH_LAYER * BERAT_WR * LUAS_AREA / 1000 * OVERLAP_GLASS',
                    ],
                    'external' => [
                        'veil' => 'JUMLAH_LAYER * BERAT_VEIL * LUAS_AREA / 1000 * OVERLAP_GLASS',
                        'csm' => 'JUMLAH_LAYER * BERAT_CSM * LUAS_AREA / 1000 * OVERLAP_GLASS',
                    ],
                    'total' => 'Total Glass Liner + Structure + External',
                ],
                'resin_weight' => [
                    'liner' => '(BERAT_GLASS_VEIL * (90 / 10)) + (BERAT_GLASS_CSM * (70 / 30)) + (LUAS_AREA * 0.5 * 1.2)',
                    'structure' => 'IF(DN < 150, (BERAT_GLASS_ROVING * (32/68) + BERAT_CSM * (70/30) + BERAT_WR * (50/50)) * (1.3+0.07), 0); IF(DN >= 150 AND DN <= 350, (BERAT_GLASS_ROVING * (32/68) + BERAT_CSM * (70/30) + BERAT_WR * (50/50)) * (1.15+0.05), 0); IF(DN >= 400 AND DN <= 3000, (BERAT_GLASS_ROVING * (28/72) + BERAT_CSM * (70/30) + BERAT_WR * (50/50)) * (1.1+0.03), 0)',
                    'external' => '(BERAT_GLASS_VEIL * (90 / 10)) + (BERAT_GLASS_CSM * (70 / 30)) + (LUAS_AREA * 0.3 * 1.2)',
                    'top_coat' => 'LUAS_AREA * 0.3 * 1.2 * 2',
                    'total' => 'Total Berat Resin',
                ],
                'additive' => [
                    'katalis' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.02',
                    'cobalt' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.003 * 0.6',
                    'dma' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.003 * 0.4',
                    'hidroquinon' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.002 * 0.1',
                    'methanol' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.002 * 0.9',
                    'styrene_monomer' => 'IF(KATALIS="BPO", TOTAL_BERAT_RESIN * 0.02, TOTAL_BERAT_RESIN * 0.005)',
                    'tinuvin' => '(TOTAL_RESIN_TOP_COAT) * 0.026 * 0.115',
                    'chloroform' => 'TOTAL_RESIN_TOP_COAT * 0.026 * 0.885',
                    'lilin_padat' => 'TOTAL_RESIN_TOP_COAT * 0.3 * 0.1',
                    'styrene_monomer_top_coat' => 'TOTAL_RESIN_TOP_COAT * 0.3 * 0.9',
                    'pigment' => 'TOTAL_RESIN_TOP_COAT * 0.5',
                    'total' => 'Total Berat Additive',
                ],
                'mirror_glaze' => [
                    'rumus' => '(LUAS_AREA * (panjang/1000) * 1.2) * 0.000025 * 800',
                ],
                'additional_additive' => [
                    'abrasive' => [
                        'silica_carbit' => 'TOTAL_BERAT_RESIN_LINER * 0.3',
                    ],
                    'fire_retardant_type_1' => [
                        'antimony' => '(TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.05',
                        'saytex' => '(TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.12',
                    ],
                    'fire_retardant_type_2' => [
                        'antimony' => '(TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.05',
                    ],
                    'conductive_type_1' => [
                        'tubal_matrix' => '(TOTAL_RESIN_LINER) * 0.005',
                    ],
                    'conductive_type_2' => [
                        'tubal_matrix' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_TOP_COAT) * 0.005',
                        'hi_black' => '(TOTAL_RESIN_STRUCTURE + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.15',
                    ],
                    'total' => 'Total Berat Additional Additive',
                ],
                'total_weight' => [
                    'rumus' => 'BERAT_GLASS + BERAT_RESIN + BERAT_ADDITIVE + BERAT_ADDITIONAL_ADDITIVE',
                ],
                'fitting_params' => null,
            ]
        );

        // ==============================
        // Formula 2: End Cap (Tipe: Fitting)
        // ==============================
        MasterWeightFormula::updateOrCreate(
            ['formula_code' => 'FRM-002'],
            [
                'formula_name' => 'End Cap',
                'formula_type' => 'fitting',
                'waste_pipe' => null,
                'luas_area' => [
                    'rumus' => '(((0.5 * 4 * PI * (Radius + (Thickness_Est / 2))^2))) / 1000000 * 1.2',
                    'note' => 'Faktor Waste = 1.2',
                ],
                'resin_contain' => [
                    'liner' => [
                        'veil' => '90/10',
                        'csm' => '70/30',
                    ],
                    'structure' => [
                        'csm' => '60/40',
                        'wr' => '50/50',
                    ],
                ],
                'setting_fw' => null,
                'glass_config' => [
                    'liner' => [
                        'veil' => 'Jumlah layer veil dari susunan layer baru',
                        'csm' => 'Jumlah layer csm dari susunan layer baru',
                    ],
                    'structure' => [
                        'csm' => 'Jumlah layer csm dari susunan layer baru',
                        'wr' => 'Jumlah layer wr dari susunan layer baru',
                    ],
                    'external' => [
                        'csm' => 'Jumlah layer csm external',
                        'veil' => 'Jumlah layer veil external',
                    ],
                ],
                'glass_weight' => [
                    'liner' => [
                        'veil' => 'berat jenis veil (gram/m) / 1000 * jumlah layer veil * luas area',
                        'csm' => 'berat CSM (450 atau 300) gram/m / 1000 * jumlah layer csm * luas area',
                    ],
                    'structure' => [
                        'csm' => 'berat CSM (450 atau 300) gram/m / 1000 * jumlah layer csm * luas area',
                        'wr' => 'berat WR (600 atau 800) gram/m / 1000 * jumlah layer wr * luas area',
                    ],
                    'external' => [
                        'csm' => 'berat CSM (450 atau 300) gram/m / 1000 * jumlah layer csm * luas area',
                        'veil' => 'berat veil gram/m / 1000 * jumlah layer veil * luas area',
                    ],
                    'total' => 'Total Glass Liner + Structure + External',
                ],
                'resin_weight' => [
                    'liner' => '((Berat Veil * 90/10) + (Berat CSM * 70/30)) + (Luas Area * 0.3 * 1.2)',
                    'structure' => '(Berat CSM * 60/40) + (Berat WR * 45/55) + (Luas Area * 0.3 * 1.2 * jumlah stage laminasi)',
                    'external' => '((Berat Veil * 90/10) + (Berat CSM * 70/30)) + (Luas Area * 0.3 * 1.2 * jumlah layer external)',
                    'top_coat' => '(luas area * 0.3 * 1.2) * 2',
                    'total' => 'Total Berat Resin',
                ],
                'additive' => [
                    'katalis' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.02',
                    'cobalt' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.003 * 0.6',
                    'dma' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.003 * 0.4',
                    'hidroquinon' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.002 * 0.1',
                    'methanol' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_STRUKTUR + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.002 * 0.9',
                    'styrene_monomer' => 'IF(KATALIS="BPO", TOTAL_BERAT_RESIN * 0.02, TOTAL_BERAT_RESIN * 0.005)',
                    'tinuvin' => '(TOTAL_RESIN_TOP_COAT) * 0.026 * 0.115',
                    'chloroform' => 'TOTAL_RESIN_TOP_COAT * 0.026 * 0.885',
                    'lilin_padat' => 'TOTAL_RESIN_TOP_COAT * 0.3 * 0.1',
                    'styrene_monomer_top_coat' => 'TOTAL_RESIN_TOP_COAT * 0.3 * 0.9',
                    'pigment' => 'TOTAL_RESIN_TOP_COAT * 0.5',
                    'total' => 'Total Berat Additive',
                ],
                'mirror_glaze' => [
                    'rumus' => '(LUAS_AREA * (panjang/1000) * 1.2) * 0.000025 * 800',
                ],
                'additional_additive' => [
                    'abrasive' => [
                        'silica_carbit' => 'TOTAL_BERAT_RESIN_LINER * 0.3',
                    ],
                    'fire_retardant_type_1' => [
                        'antimony' => '(TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.05',
                        'saytex' => '(TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.12',
                    ],
                    'fire_retardant_type_2' => [
                        'antimony' => '(TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.05',
                    ],
                    'conductive_type_1' => [
                        'tubal_matrix' => '(TOTAL_RESIN_LINER) * 0.005',
                    ],
                    'conductive_type_2' => [
                        'tubal_matrix' => '(TOTAL_RESIN_LINER + TOTAL_RESIN_TOP_COAT) * 0.005',
                        'hi_black' => '(TOTAL_RESIN_STRUCTURE + TOTAL_RESIN_EXTERNAL + TOTAL_RESIN_TOP_COAT) * 0.15',
                    ],
                    'total' => 'Total Berat Additional Additive',
                ],
                'total_weight' => [
                    'rumus' => 'BERAT_GLASS + BERAT_RESIN + BERAT_ADDITIVE + BERAT_ADDITIONAL_ADDITIVE',
                ],
                'fitting_params' => [
                    'radius' => 'Diameter / 2',
                    'faktor_thickness' => '1.25 atau 1.5',
                    'thickness_est' => 'Thickness Fitting Est. x Faktor Thickness',
                    'penyesuaian_structure' => 'Standard Layer Structure Terdekat',
                    'susunan_layer_baru' => 'Mengikuti penyesuaian structure terbaru',
                    'total_thickness_fitting' => 'Liner + Structure Susunan Layer baru + External + Top Coat',
                ],
            ]
        );
    }
}
