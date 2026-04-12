<?php

use App\Models\Company;
use App\Models\HistoricCompany;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('pix_origin_name')->nullable();
            $table->string('pix_receipt_photo')->nullable();
            $table->string('cause')->nullable();
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(HistoricCompany::class)->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
