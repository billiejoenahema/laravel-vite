<?php

namespace App\Observers;

use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "deleted" event.
     *
     * @param Customer $customer
     */
    public function deleted(Customer $customer): void
    {
        // アイコン画像が存在すれば削除する
        if ($customer->avatar) {
            Storage::disk('s3')->delete($customer->avatar);
        }
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
