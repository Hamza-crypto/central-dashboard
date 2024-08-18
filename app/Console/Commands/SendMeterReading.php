<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Telegram\TelegramChannel;

class ProcessFiles extends Command
{
    protected $signature = 'sync-excel';
    protected $description = 'Command description';

    public function handle()
    {

    }
}