<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nim_nis');
        $table->string('tujuan');
        $table->timestamps();
    });
}
};
