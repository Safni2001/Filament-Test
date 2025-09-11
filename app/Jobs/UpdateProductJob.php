<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

/**
 * Job to update a product's description and send a database notification
 */
class UpdateProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $productId,
        private readonly string $newDescription
    ) {}

    /**
     * Execute the job
     */
    public function handle(): void
    {
        $product = Product::findOrFail($this->productId);
        
        $oldDescription = $product->description;
        $product->update(['description' => $this->newDescription]);

        // Send notification to all users (or you can customize this to specific users)
        $users = User::all();
        
        foreach ($users as $user) {
            $user->notify(new ProductUpdatedNotification($product, $oldDescription, $this->newDescription));
        }
    }
}