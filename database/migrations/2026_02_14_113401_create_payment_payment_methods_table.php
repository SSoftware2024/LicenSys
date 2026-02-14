<?php

use App\Models\Payment;
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
        Schema::create('payment_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Payment::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentMethod::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_payment_methods');
    }
};
