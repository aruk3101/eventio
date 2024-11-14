<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{

    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected $allowedFields = [
        'name',
        'description',
        'start_datetime',
        'end_datetime',
        'location_id',
        'max_participants',
        'created_at',
        'created_by_user_id',
        'updated_at'
    ];

    public function getEventsByUser(int $userId, int $perPage = 10)
    {
        return $this->join('locations', 'locations.location_id = events.location_id')
            ->select('events.*, locations.name as location_name, locations.address as location_address')
            ->select("CASE WHEN end_datetime < NOW() THEN 1 ELSE 0 END AS is_finished")
            ->where('created_by_user_id', $userId)
            ->paginate($perPage);
    }

    public function getAllEvents($search = null, $perPage = 10)
    {
        // Dołączenie tabeli `locations`
        $this->join('locations', 'locations.location_id = events.location_id')
            ->select('events.*, locations.name as location_name, locations.address as location_address')
            ->select("CASE WHEN end_datetime < NOW() THEN 1 ELSE 0 END AS is_finished");

        // Dodanie warunków wyszukiwania, jeśli jest podane
        if ($search) {
            $this->groupStart()
                ->like('events.name', $search)
                ->orLike('events.description', $search)
                ->groupEnd();
        }

        // Zwracanie wyników z paginacją
        return $this->paginate($perPage);
    }

    public function getEventWithLocation($id)
    {
        return $this->join('locations', 'locations.location_id = events.location_id')
            ->select('events.*, locations.name as location_name, locations.address as location_address')
            ->where('events.event_id', $id)
            ->first();
    }
}
