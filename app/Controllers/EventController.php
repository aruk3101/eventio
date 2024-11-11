<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\LocationModel;
use App\Models\EventRegistrationModel;
use App\Models\EventMediaModel;

class EventController extends BaseController
{
    public function __construct()
    {
        helper('form');
        helper('url');
    }

    public function returnView($pageName = 'login', $content = array())
    {
        $data =  [
            'header' => view('common/header'),
            'footer' => view('common/footer'),
            'menu' => view('common/menu'),
            'content' => view($pageName, $content),
            'submenu' => '',
            'baseCss' => view('common/baseCss'),
            'css' => ''
        ];

        return view(
            "common/basePage",
            $data
        );
    }

    public function index() {}

    public function myEvents()
    {
        if (!session()->has('loggedUser')) {
            return redirect()->to('/user/login');
        }

        $userId = session()->get('loggedUser');
        $eventModel = new EventModel();

        $data['events'] = $eventModel->getEventsByUser($userId, 10);
        $data['pager'] = $eventModel->pager;

        return $this->returnView('events/myevents', $data);
    }

    public function addEvent()
    {
        return $this->returnView('events/addEvent');
    }

    public function submitAddEvent()
    {
        // Walidacja danych z formularza
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'               => 'required|min_length[3]|max_length[100]',
            'description'        => 'required|min_length[10]',
            'start_datetime'     => 'required',
            'end_datetime'       => 'required',
            'location_name'      => 'required|min_length[3]|max_length[100]',
            'location_address'   => 'required|min_length[5]|max_length[255]',
            'max_participants'   => 'required|integer',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Przekształcenie dat na oczekiwany format
        $startDatetime = date('Y-m-d H:i:s', strtotime($this->request->getPost('start_datetime')));
        $endDatetime = date('Y-m-d H:i:s', strtotime($this->request->getPost('end_datetime')));
        if ($endDatetime <= $startDatetime) {
            return redirect()->back()->withInput()->with('errors', ['end_datetime' => 'Data zakończenia musi być późniejsza niż data rozpoczęcia.']);
        }

        $locationModel = new LocationModel();
        $locationData = [
            'name'    => $this->request->getPost('location_name'),
            'address' => $this->request->getPost('location_address'),
        ];
        $locationModel->save($locationData);

        // Pobierz ID nowo dodanej lokalizacji
        $locationId = $locationModel->getInsertID();


        $eventModel = new EventModel();
        $eventData = [
            'name'               => $this->request->getPost('name'),
            'description'        => $this->request->getPost('description'),
            'start_datetime'     => $startDatetime,
            'end_datetime'       => $endDatetime,
            'location_id'        => $locationId,
            'max_participants'   => $this->request->getPost('max_participants'),
            'created_by_user_id' => session()->get('loggedUser')
        ];

        $eventModel->save($eventData);

        return redirect()->to('/user/events')->with('message', 'Wydarzenie zostało pomyślnie dodane!');
    }


    public function view($id)
    {
        $eventModel = new EventModel();
        $eventMediaModel = new EventMediaModel();
        $userModel = new UserModel();
        $registrationModel = new EventRegistrationModel();

        $event = $eventModel->getEventWithLocation($id);
        $media = $eventMediaModel->getMediaByEvent($id);
        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Wydarzenie o ID $id nie zostało znalezione.");
        }


        $userId = session()->get('loggedUser');
        $registration = $registrationModel->isUserRegistered($id, $userId);

        $organizer = $userModel->find($event['created_by_user_id']);
        $isOrganizer = ($userId == $event['created_by_user_id']);

        $registeredCount = $registrationModel->getRegisteredCount($id);

        $participants = [];
        if ($isOrganizer) {
            $participants = $registrationModel->getEventParticipants($id);
        }

        return $this->returnView('events/event', [
            'event' => $event,
            'registration' => $registration,
            'organizer' => $organizer,
            'isOrganizer' => $isOrganizer,
            'participants' => $participants,
            'media' => $media,
            'registeredCount' => $registeredCount
        ]);
    }

    public function events()
    {
        $eventModel = new EventModel();

        $search = $this->request->getGet('search');

        $data['events'] = $eventModel->getAllEvents($search, 10);
        $data['pager'] = $eventModel->pager;
        $data['search'] = $search;

        return $this->returnView('events/events', $data);
    }


    public function register($eventId)
    {
        $userId = session()->get('loggedUser');
        $registrationModel = new EventRegistrationModel();

        if ($registrationModel->isUserRegistered($eventId, $userId)) {
            return redirect()->back()->with('message', 'Już jesteś zapisany na to wydarzenie.');
        }

        $isAnonymous = $this->request->getPost('is_anonymous') ? 1 : 0;

        $registrationModel->insert([
            'event_id' => $eventId,
            'user_id' => $userId,
            'is_anonymous' => $isAnonymous,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('message', 'Zostałeś zapisany na wydarzenie.');
    }

    public function unregister($eventId)
    {
        $userId = session()->get('loggedUser');
        $registrationModel = new EventRegistrationModel();

        $registrationModel->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->delete();

        return redirect()->back()->with('message', 'Wypisałeś się z wydarzenia.');
    }

    public function edit($id)
    {
        $eventModel = new EventModel();
        $event = $eventModel->getEventWithLocation($id);

        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Wydarzenie o ID $id nie istnieje.");
        }

        $userId = session()->get('loggedUser');
        if ($event['created_by_user_id'] != $userId) {
            return redirect()->to('/user/events')->with('error', 'Nie masz uprawnień do edycji tego wydarzenia.');
        }

        return $this->returnView('events/editEvent', ['event' => $event]);
    }

    public function update($id)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($id);
        $userId = session()->get('loggedUser');
        if (!$event || $event['created_by_user_id'] != $userId) {
            return redirect()->to('/user/events')->with('error', 'Nie masz uprawnień do edycji tego wydarzenia.');
        }

        if (!$this->validate([
            'name'               => 'required|min_length[3]|max_length[100]',
            'description'        => 'required|min_length[10]',
            'start_datetime'     => 'required',
            'end_datetime'       => 'required',
            'location_name'      => 'required|min_length[3]|max_length[100]',
            'location_address'   => 'required|min_length[5]|max_length[255]',
            'max_participants'   => 'required|integer',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $startDatetime = date('Y-m-d H:i:s', strtotime($this->request->getPost('start_datetime')));
        $endDatetime = date('Y-m-d H:i:s', strtotime($this->request->getPost('end_datetime')));
        if ($endDatetime <= $startDatetime) {
            return redirect()->back()->withInput()->with('errors', ['end_datetime' => 'Data zakończenia musi być późniejsza niż data rozpoczęcia.']);
        }


        $locationModel = new LocationModel();
        $locationModel->update(
            $event['location_id'],
            [
                'name'    => $this->request->getPost('location_name'),
                'address' => $this->request->getPost('location_address'),
            ]
        );

        $eventModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
            'max_participants' => $this->request->getPost('max_participants')
        ]);

        return redirect()->to('/user/events')->with('message', 'Wydarzenie zostało pomyślnie zaktualizowane.');
    }

    public function addMedia($eventId)
    {
        $eventModel = new EventModel();
        $eventMediaModel = new EventMediaModel();
        $event = $eventModel->find($eventId);

        // Sprawdzanie, czy użytkownik jest organizatorem
        $userId = session()->get('loggedUser');
        if ($event['created_by_user_id'] != $userId) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do dodawania zdjęć do tego wydarzenia.');
        }

        $rules = [
            'media' => 'uploaded[media]|max_size[media,2048]|is_image[media]|mime_in[media,image/jpg,image/jpeg,image/png]',
        ];

        if ($this->validate($rules)) {
            // Pobranie pliku z formularza
            $file = $this->request->getFile('media');
            if ($file->isValid() && !$file->hasMoved()) {
                // Generowanie unikalnej nazwy pliku
                $newName = $file->getRandomName();
                // Przenieś plik do katalogu public/uploads/event_media
                $file->move(ROOTPATH . 'public/uploads/event_media', $newName);

                // Zapisanie danych w tabeli eventmedia
                $data = [
                    'event_id' => $eventId,
                    'media_url' => 'uploads/event_media/' . $newName,
                    'media_type' => $file->getClientMimeType(),
                ];
                $eventMediaModel->insert($data);

                return redirect()->to(base_url("events/view/{$eventId}"));
            }
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function deleteMedia($mediaId)
    {
        $eventMediaModel = new EventMediaModel();
        $media = $eventMediaModel->find($mediaId);

        $eventModel = new EventModel();
        $event = $eventModel->find($media['event_id']);

        $userId = session()->get('loggedUser');
        if ($event['created_by_user_id'] != $userId) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do usuwania zdjęć z tego wydarzenia.');
        }

        if ($media) {
            $filePath = ROOTPATH . 'public/' . $media['media_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $eventMediaModel->delete($mediaId);
        }

        return redirect()->back();
    }
}
