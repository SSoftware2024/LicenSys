<?php

use App\Models\Company;
use App\Enum\MonthlyFee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historic_companies', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_paid',6,2)->nullable();
            $table->date('pay_date')->nullable();
            $table->date('date_paid')->nullable();
            $table->boolean('is_free_month')->default(false);
            $table->enum('monthly_fee_status', MonthlyFee::toArrayValues())->default(MonthlyFee::PAY->value);
            $table->foreignIdFor(Company::class)->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historic_companies');
    }
};
