<?php

use App\Models\HistoricCompany;
use App\Models\PaymentMethod;
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
        Schema::create('historic_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HistoricCompany::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentMethod::class)->nullable()->constrained();
            $table->decimal('value_paid',6,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historic_payment_methods');
    }
};
