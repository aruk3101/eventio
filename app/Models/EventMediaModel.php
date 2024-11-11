<?php

namespace App\Models;

use CodeIgniter\Model;

class EventMediaModel extends Model
{
    protected $table = 'eventmedia';
    protected $primaryKey = 'media_id';
    protected $allowedFields = ['event_id', 'media_url', 'media_type', 'uploaded_at'];

    public function getMediaByEvent($eventId)
    {
        return $this->where('event_id', $eventId)->findAll();
    }
}
