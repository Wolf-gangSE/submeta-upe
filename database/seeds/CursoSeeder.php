<?php

use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Computação',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Letras com Habilitação em Língua Portuguesa e Língua Espanhola',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Letras com Habilitação em Língua Portuguesa e Língua Inglesa',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Língua Portuguesa e suas Literaturas',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Pedagogia',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Ciências Biológicas',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Matemática',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Ciências Sociais',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Educação Fisíca',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Geografia',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em História',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Administração',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Direito',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Psicologia',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Serviço Social',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Tecnólogo em Gestão em Logística',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia Civil',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia da Computação',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia de Control e Automação',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia Elétrica Eletrônica',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia Elétrica Eletrotécnica',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia Mecânica',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia Elétrica de Telecomunicações',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Engenharia de Software',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Sistemas de Informação',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Ciências Biológicas',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Educação Física',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Enfermagem',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Fisioterapia',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Medicina',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Nutrição',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Odontologia',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Saúde Coletiva',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Bacharelado em Administração Pública EAD',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em História EAD',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Pedagogia EAD',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Ciências Biológicas EAD',
        ]);

        DB::table('cursos')->insert([
            'nome' => 'Licenciatura em Língua Portuguesa e suas Literaturas EAD',
        ]);
    }
}