<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Massenger;
class AddDeleteChatMassage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-delete-chat-massage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Massenger::whereDate('created_at','<=',today()->subMonth()->toDateString())->delete();
    }
}
