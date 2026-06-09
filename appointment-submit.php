<?php

require_once __DIR__ . '/includes/data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: appointment.php');
    exit;
}

$allowedReturn = ['appointment.php', 'index.php'];
$returnTo = trim($_POST['return_to'] ?? 'appointment.php');
if (!in_array($returnTo, $allowedReturn, true)) {
    $returnTo = 'appointment.php';
}

$service = trim($_POST['service'] ?? '');
$appointmentDate = trim($_POST['appointment_date'] ?? '');
$appointmentTime = trim($_POST['appointment_time'] ?? '');
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$errors = [];
if ($service === '') {
    $errors[] = 'service';
}
if ($appointmentDate === '') {
    $errors[] = 'date';
}
if ($appointmentTime === '') {
    $errors[] = 'time';
}
if ($name === '') {
    $errors[] = 'name';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'email';
}
if ($phone === '') {
    $errors[] = 'phone';
}

if (!empty($errors)) {
    header('Location: ' . $returnTo . '?booked=error#book-appointment');
    exit;
}

$saved = sum_appointments_add([
    'service' => $service,
    'appointment_date' => $appointmentDate,
    'appointment_time' => $appointmentTime,
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'status' => 'new',
]);

header('Location: ' . $returnTo . '?' . ($saved ? 'booked=success' : 'booked=error') . '#book-appointment');
exit;