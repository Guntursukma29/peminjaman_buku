<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_buku')->constrained('books', 'id_buku')->onDelete('cascade')->nullable(false);  // Tidak boleh null
            $table->foreignId('id_anggota')->constrained('members', 'id_anggota')->onDelete('cascade')->nullable(false);  // Tidak boleh null
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->timestamps();
        });
    }
    

        public function down()
        {
            Schema::dropIfExists('borrowings');
        }
};
