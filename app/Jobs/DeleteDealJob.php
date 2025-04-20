<?php

namespace App\Jobs;

use App\Models\Deal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteDealJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dealId;

    public function __construct($dealId)
    {
        $this->dealId = $dealId;
    }

    public function handle()
    {
        Log::info('Attempting to delete deal with ID: ' . $this->dealId);
        $deal = Deal::find($this->dealId);

        if ($deal) {
            // Update the deal status and comment
            $deal->status = 'canceled';
            $deal->comment = 'Not Answered';

            // Save the changes
            if (!$deal->save()) {
                Log::error('Failed to update deal before deletion', [
                    'dealId' => $this->dealId,
                    'errors' => $deal->getErrors() // assuming you have this method or handle errors appropriately
                ]);
            }

            // Delete the deal
            $deal->delete();
            Log::info('Successfully deleted deal with ID: ' . $this->dealId);
        } else {
            Log::warning('Deal not found for deletion', ['dealId' => $this->dealId]);
        }
    }
}
