<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_contracts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با شرکت
            // ============================================
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');

            $table->string('contract_number', 50)->unique();

            // ============================================
            // تاریخ‌ها
            // ============================================
            $table->date('contract_date');
            $table->date('start_date');
            $table->date('end_date');

            // ============================================
            // نوع قرارداد
            // ============================================
            $table->enum('contract_type', [
                'sales', 'distribution', 'agency', 'partnership', 'custom'
            ])->default('sales');

            // ============================================
            // نمایندگان
            // ============================================
            $table->string('company_representative');
            $table->string('company_representative_title', 100);
            $table->string('manager_representative');
            $table->string('manager_representative_title', 100);

            // ============================================
            // شرایط
            // ============================================
            $table->text('terms')->nullable();
            $table->text('special_conditions')->nullable();
            $table->text('payment_terms')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0);

            // ============================================
            // وضعیت
            // ============================================
            $table->enum('status', [
                'draft', 'pending', 'pending_manager',
                'active', 'expired', 'terminated'
            ])->default('pending');

            // ============================================
            // تاییدها
            // ============================================
            $table->boolean('company_confirmed')->default(false);
            $table->boolean('manager_confirmed')->default(false);
            $table->timestamp('company_confirmed_at')->nullable();
            $table->timestamp('manager_confirmed_at')->nullable();

            $table->text('company_notes')->nullable();
            $table->enum('company_response_status', [
                'pending', 'accepted', 'rejected'
            ])->default('pending');
            $table->timestamp('company_response_date')->nullable();

            $table->timestamp('signed_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('company_id');
            $table->index('status');
            $table->index('contract_number');
            $table->index('contract_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
