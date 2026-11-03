<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SURVEY_DIR', __DIR__ . '/survey/');

function init_environment() {
    if (!file_exists(SURVEY_DIR)) {
        mkdir(SURVEY_DIR, 0777, true);
    }
}

function login_admin($username, $password) {
    if ($username === 'admin' && $password === 'secretpassword') {
        $_SESSION['is_admin'] = true;
        return true;
    }
    return false;
}

function is_admin_logged_in() {
    return !empty($_SESSION['is_admin']);
}

function logout_admin() {
    unset($_SESSION['is_admin']);
    session_destroy();
}

function get_all_responses() {
    init_environment();
    $files = glob(SURVEY_DIR . '*.json');
    $responses = [];
    if ($files) {
        rsort($files);
        foreach ($files as $file) {
            $content = json_decode(file_get_contents($file), true);
            if ($content) {
                $content['_filename'] = basename($file);
                $responses[] = $content;
            }
        }
    }
    return $responses;
}

function delete_response_file($filename) {
    $filepath = SURVEY_DIR . basename($filename);
    if (file_exists($filepath) && pathinfo($filepath, PATHINFO_EXTENSION) === 'json') {
        unlink($filepath);
    }
}

function export_responses_to_csv() {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=survey_export_' . date('Y-m-d_H-i-s') . '.csv');

    $output = fopen('php://output', 'w');
    fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    fputcsv($output, ['Дата та час', "Ім'я", 'Email', 'Жанр', 'Формат', 'Коментар']);

    $responses = get_all_responses();
    foreach ($responses as $r) {
        fputcsv($output, [
            $r['submitted_at'] ?? '',
            $r['respondent']['name'] ?? '',
            $r['respondent']['email'] ?? '',
            $r['answers']['favorite_genre'] ?? '',
            $r['answers']['reading_format'] ?? '',
            $r['answers']['feedback'] ?? ''
        ]);
    }
    fclose($output);
    exit();
}