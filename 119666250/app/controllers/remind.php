<?php

class remind extends Controller {

    public function index($id = '') {
        $reminder = $this->model('Reminders');
        $list = $reminder->get_reminders();

        if ($id) {
            $item = $user->get_reminder($id);
            $this->view('home/update', ['item' => $item]);
        }

        $this->view('home/index', ['list' => $list]);
    }

    public function update($id = '') {
        $reminder = $this->model('Reminders');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reminder->id = $_POST['reminderId'];
            $reminder->subject = $_POST['subject'];
            $reminder->description = $_POST['description'];
            $reminder->updateItem();
            $this->view("home/reminder", $reminder);
        } else {
            //show edit
            $reminder = $reminder->get_reminder($id);
            $this->view('home/update', $reminder);
        }
    }

    public function remove($id = '') {
        $reminder = $this->model('Reminders');
        $reminder->removeItem($id);
        header('Location: ' . HOME);
    }

    public function create() {
        $user = $this->model('User');
        $user->username = $_SESSION['username'];
        $user = $user->getUser();
        if (empty($user->firstname) || empty($user->lastname) || empty($user->dob) || empty($user->phone)) {
            echo "<script>alert('You need to update profile completely to create a reminder!');</script>";
            $this->view('user/profile', $user);
            die;
        }
        
        $reminders = $this->model('Reminders');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subjects = $_POST['subject'];
            $description = $_POST['description'];
            $reminders->addToTable($_SESSION['username'], $subjects, $description);
        }
        $this->view('home/reminder', $reminders);
    }

}
