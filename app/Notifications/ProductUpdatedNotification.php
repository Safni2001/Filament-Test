<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Database notification for product updates
 */
class ProductUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Product $product,
        private readonly string $oldDescription,
        private readonly string $newDescription
    ) {}

    /**
     * Get the notification's delivery channels
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'old_description' => $this->oldDescription,
            'new_description' => $this->newDescription,
            'updated_at' => now()->toISOString(),
            'message' => "Product '{$this->product->name}' description has been updated."
        ];
    }
}