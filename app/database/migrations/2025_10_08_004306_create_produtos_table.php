<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 120)->unique();
            $table->decimal('preco', 10, 2)->check('preco >= 0');
            $table->integer('estoque')->default(0)->check('estoque >= 0');
            $table->timestamps(); // created_at e updated_at
        });
    }

    public function down(): void {
        Schema::dropIfExists('produtos');
    }
};
