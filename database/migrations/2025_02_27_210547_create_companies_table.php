<?php

use App\Enum\MonthlyFee;
use App\Models\GroupCompany;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('vinculation_code');
            $table->enum('monthly_fee_status', MonthlyFee::toArray())->default(MonthlyFee::PAY->value);
            $table->date('payment_day');
            $table->decimal('value_monthly_fee',6,2);
            $table->boolean('isFiscal')->default(false);
            $table->boolean('activated')->default(true);
            $table->json('systems_useds')->nullable();
            $table->foreignIdFor(GroupCompany::class)->nullable()->constrained();
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
