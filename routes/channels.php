<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('phlebo-tracking.{phleboId}', function ($user, $phleboId) {
    return true ;
});
