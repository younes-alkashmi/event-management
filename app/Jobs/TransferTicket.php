<?php

namespace App\Jobs;

use App\Models\TicketTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticketId;
    protected $userIds;

    public function __construct($ticketId, $userIds)
    {
        $this->ticketId = $ticketId;
        $this->userIds = $userIds;
    }

    public function handle()
    {
        foreach ($this->userIds as $userId) {
            TicketTransfer::create(['ticket_id' => $this->ticketId, 'user_id' => $userId]);
        }
    }
}
