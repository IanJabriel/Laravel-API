<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\DB;

    return new class extends Migration
    {
        public function up(): void
        {
            // Cria uma nova tabela com a ordem desejada das colunas
            Schema::create('usuarios_new', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_curso')->nullable()->default(null);
                $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('set null');
                $table->string('name');
                $table->string('CPF')->unique();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->string('Telefone');
                $table->string('RA')->nullable()->default(null);
                $table->boolean('is_admin')->default(false); // A coluna is_admin agora aparece aqui
                $table->softDeletes();
                $table->timestamps();
            });

            // Copiar os dados da tabela antiga para a nova tabela
            DB::table('usuarios')->get()->each(function ($row) {
                DB::table('usuarios_new')->insert((array) $row);
            });

            // Dropar a tabela antiga
            Schema::drop('usuarios');

            // Renomear a nova tabela para o nome original
            Schema::rename('usuarios_new', 'usuarios');
        }

        public function down(): void
        {
            // Reverter as mudanças
            Schema::create('usuarios_old', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_curso')->nullable()->default(null);
                $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('set null');
                $table->string('name');
                $table->string('CPF')->unique();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->string('Telefone');
                $table->string('RA')->nullable()->default(null);
                $table->softDeletes();
                $table->timestamps();
                $table->boolean('is_admin')->default(false); // Ordem anterior
            });

            // Copiar os dados da tabela nova para a tabela antiga
            DB::table('usuarios')->get()->each(function ($row) {
                DB::table('usuarios_old')->insert((array) $row);
            });

            // Dropar a tabela nova
            Schema::drop('usuarios');

            // Renomear a tabela antiga para o nome original
            Schema::rename('usuarios_old', 'usuarios');
        }
    }
?>