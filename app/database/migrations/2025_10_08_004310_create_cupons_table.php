<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // necessário por causa do DB::statement

return new class extends Migration {
    public function up(): void {
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->enum('tipo', ['percentual', 'valor']);
            $table->decimal('valor', 10, 2);
            $table->dateTime('validade')->nullable();
            $table->integer('limite_usos')->nullable()->check('limite_usos IS NULL OR limite_usos >= 0');
            $table->integer('usos')->default(0)->check('usos >= 0');
            $table->timestamps();
        });

        // constraint de validade (opcional)
        DB::statement('ALTER TABLE cupons ADD CONSTRAINT chk_validade CHECK (validade IS NULL OR validade >= created_at)');
    }

    public function down(): void {
        Schema::dropIfExists('cupons');
    }
};
