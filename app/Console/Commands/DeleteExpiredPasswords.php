<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteExpiredPasswords extends Command
{
    protected $signature = 'passwords:delete-expired';
    protected $description = 'Delete passwords where expires_at is in the past';

    public function handle()
{
    $now = \Carbon\Carbon::now('Europe/Amsterdam');
    $this->info('Current time: ' . $now->toDateTimeString());

    $deleted = \DB::table('passwords')
        ->where('expires_at', '<', $now)
        ->delete();

    $this->info("Deleted {$deleted} expired password records.");
}
}
