<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleOtpColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id', 100)->nullable()->after('unit_kerja');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar', 500)->nullable()->after('google_id');
            }
            if (!Schema::hasColumn('users', 'reset_otp')) {
                $table->string('reset_otp', 10)->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'reset_otp_expires_at')) {
                $table->timestamp('reset_otp_expires_at')->nullable()->after('reset_otp');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar', 'reset_otp', 'reset_otp_expires_at']);
        });
    }
}

