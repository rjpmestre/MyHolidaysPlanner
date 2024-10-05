<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Holiday;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //2024
        Holiday::Create(['date' => '2024-01-01', 'description' => 'Dia de Ano Novo', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-03-29', 'description' => 'Sexta-Feira Santa', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-03-31', 'description' => 'Páscoa', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-04-25', 'description' => '25 de Abril', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-05-01', 'description' => 'Dia do Trabalhador', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-05-30', 'description' => 'Corpo de Deus', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-05-09', 'description' => 'Quinta Feira de Espiga', 'type_id' => 1, 'group_id' => 1 ]);
        Holiday::Create(['date' => '2024-06-10', 'description' => 'Dia de Portugal', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-06-13', 'description' => 'Santo António', 'type_id' => 1, 'group_id' => 1 ]);
        Holiday::Create(['date' => '2024-08-15', 'description' => 'Assunção de Nossa Senhora', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-10-05', 'description' => 'Implantação da República', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-11-01', 'description' => 'Dia de Todos os Santos', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-12-01', 'description' => 'Restauração da Independência', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-12-08', 'description' => 'Dia da Imaculada Conceição', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-12-25', 'description' => 'Natal', 'type_id' => 1]);
        Holiday::Create(['date' => '2024-12-24', 'description' => 'Consoada', 'type_id' => 2]);
        Holiday::Create(['date' => '2024-12-31', 'description' => 'Véspera de Ano Novo', 'type_id' => 2]);

        //2025
        Holiday::Create(['date' => '2025-01-01', 'description' => 'Dia de Ano Novo', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-04-18', 'description' => 'Sexta-Feira Santa', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-04-20', 'description' => 'Páscoa', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-04-25', 'description' => '25 de Abril', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-05-01', 'description' => 'Dia do Trabalhador', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-05-29', 'description' => 'Quinta Feira de Espiga', 'type_id' => 1, 'group_id' => 1 ]);
        Holiday::Create(['date' => '2025-06-10', 'description' => 'Dia de Portugal', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-06-13', 'description' => 'Santo António', 'type_id' => 1, 'group_id' => 1 ]);
        Holiday::Create(['date' => '2025-06-19', 'description' => 'Corpo de Deus', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-08-15', 'description' => 'Assunção de Nossa Senhora', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-10-05', 'description' => 'Implantação da República', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-11-01', 'description' => 'Dia de Todos os Santos', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-12-01', 'description' => 'Restauração da Independência', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-12-08', 'description' => 'Dia da Imaculada Conceição', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-12-25', 'description' => 'Natal', 'type_id' => 1]);
        Holiday::Create(['date' => '2025-12-24', 'description' => 'Consoada', 'type_id' => 2]);
        Holiday::Create(['date' => '2025-12-31', 'description' => 'Véspera de Ano Novo', 'type_id' => 2]);

        //2026
        Holiday::Create(['date' => '2026-01-01', 'description' => 'Dia de Ano Novo', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-04-03', 'description' => 'Sexta-Feira Santa', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-04-05', 'description' => 'Páscoa', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-04-25', 'description' => '25 de Abril', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-05-01', 'description' => 'Dia do Trabalhador', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-05-14', 'description' => 'Quinta Feira de Espiga', 'type_id' => 1, 'group_id' => 1 ]);
        Holiday::Create(['date' => '2026-06-10', 'description' => 'Dia de Portugal', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-06-13', 'description' => 'Santo António', 'type_id' => 1, 'group_id' => 1 ]);
        Holiday::Create(['date' => '2026-06-19', 'description' => 'Corpo de Deus', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-08-15', 'description' => 'Assunção de Nossa Senhora', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-10-05', 'description' => 'Implantação da República', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-11-01', 'description' => 'Dia de Todos os Santos', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-12-01', 'description' => 'Restauração da Independência', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-12-08', 'description' => 'Dia da Imaculada Conceição', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-12-25', 'description' => 'Natal', 'type_id' => 1]);
        Holiday::Create(['date' => '2026-12-24', 'description' => 'Consoada', 'type_id' => 2]);
        Holiday::Create(['date' => '2026-12-31', 'description' => 'Véspera de Ano Novo', 'type_id' => 2]);
    }
}
