<?php

namespace App\Observers;

use App\Models\BookingInquiry;

class BookingInquiryObserver
{

    // retrieved, creating, created, updating, updated, saving, saved, deleting, deleted,  restoring, restored
    public function created(BookingInquiry $inquiry)
    {
        // Code after save
        // $inquiry->order_no = "ERIC-" . str_pad($inquiry->id, 6, '0', STR_PAD_LEFT);
        // $inquiry->saveQuietly();
    }
}
