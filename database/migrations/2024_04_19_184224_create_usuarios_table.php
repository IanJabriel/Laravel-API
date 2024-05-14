<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_curso')->nullable()->default(null);
            $table->foreign('id_curso')->references('id')->on('cursos');
            $table->string('name');
            $table->string('CPF')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('Telefone');
            $table->string('RA')->nullable()->default(null);
            $table->softDeletes(); // Adicionando a coluna deleted_at para habilitar soft deletes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
