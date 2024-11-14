<?php

namespace App\Models;

use CodeIgniter\Model;

class EventRegistrationModel extends Model
{
    protected $table = 'eventregistrations';
    protected $primaryKey = 'registration_id';
    protected $allowedFields = [
        'event_id',
        'user_id',
        'is_anonymous',
        'created_at',
        'updated_at'
    ];

    // Sprawdzenie, czy użytkownik jest już zapisany na dane wydarzenie
    public function isUserRegistered(int $eventId, int $userId)
    {
        return $this->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();
    }


    public function getEventParticipants($eventId)
    {
        return $this->select('users.username, eventregistrations.is_anonymous')
            ->join('users', 'users.user_id = eventregistrations.user_id')
            ->where('eventregistrations.event_id', $eventId)
            ->findAll();
    }

    public function getRegisteredCount($eventId)
    {
        return $this->where('event_id', $eventId)
            ->countAllResults();
    }
}
