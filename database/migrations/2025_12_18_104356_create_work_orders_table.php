<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('requester_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->string('title');
            $table->text('description');
            $table->enum('work_order_type', ['PEMERIKSAAN', 'PERBAIKAN', 'PARTS', 'PEMINDAHAN']);
            $table->text('reject_reason')->nullable();
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED', 'IN_PROGRESS', 'COMPLETED'])->default('SUBMITTED');
            $table->timestampTz('completed_at')->nullable();
            $table->timestampTz('rejected_at')->nullable();
            $table->timestampsTz();
        });

        Schema::create('work_order_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->references('id')->on('work_orders')->onDelete('RESTRICT');
            $table->foreignId('approver_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->integer('sequence')->unsigned();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->timestampTz('approved_at')->nullable();
            $table->timestampTz('rejected_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->timestampsTz();
        });

        Schema::create('work_order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->references('id')->on('work_orders')->onDelete('RESTRICT');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->string('before_status');
            $table->string('after_status');
            $table->string('action');
            $table->timestampsTz();
        });

        Schema::create('work_order_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->references('id')->on('work_orders')->onDelete('RESTRICT');
            $table->string('file_name');
            $table->text('notes')->nullable();
            $table->integer('file_size')->unsigned();
            $table->string('attachment_type');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
        Schema::dropIfExists('work_order_approvals');
        Schema::dropIfExists('work_order_histories');
        Schema::dropIfExists('work_order_attachments');
    }
};
