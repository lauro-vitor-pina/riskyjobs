<?php
require_once(__DIR__ . '../../enums/enum_sort_riskyjob.php');
require_once(__DIR__ . '../../repositories/riskyjobs_repository.php');
require_once(__DIR__ . '../../viewmodels/SearchViewModel.php');

function riskyjobs_service_get_all(mysqli $dbc, string $search, int $sort, int $page_number, int $page_size): SearchViewModel
{
    $result = riskyjobs_repository_get_all($dbc, $search, $sort, $page_number, $page_size);

    $view_model = new SearchViewModel();

    $view_model->rows = $result['rows'];
    $view_model->total = $result['total'];
    $view_model->num_pages = $result['num_pages'];

    $view_model->search = $search;
    $view_model->sort = $sort;
    $view_model->page_number = $page_number;
    $view_model->page_size = $page_size;

    return $view_model;
}

function riskyjobs_service_registration(mysqli $dbc, $fisrt_name, $last_name, $email, $phone, $desired_job, $resume): RegistrationViewModel
{
    $view_model = new RegistrationViewModel();

    $view_model->first_name = $fisrt_name;
    $view_model->last_name = $last_name;
    $view_model->email = $email;
    $view_model->phone = $phone;
    $view_model->desired_job = $desired_job;
    $view_model->resume = $resume;

    if (empty($view_model->first_name)) {
        $view_model->first_name_error = 'You forgot to enter your first name.';
    }

    if (empty($view_model->last_name)) {
        $view_model->last_name_error = 'You forgot to enter your last name.';
    }

    if (empty($view_model->email)) {
        $view_model->email_error = 'You forgot to enter your email address.';
    }

    $regex_phone = '/^[2-9]\d{2}-\d{3}-\d{4}$/';
    
    if (!preg_match($regex_phone, $view_model->phone)) {
        $view_model->phone_error = 'You your phone number is invalid, must be in XXX-XXX-XXXX format.';
    }

    if (empty($view_model->desired_job)) {
        $view_model->desired_job_error = 'You forgot to enter your desired job.';
    }

    if (empty($view_model->resume)) {
        $view_model->resume_error = 'You forgot to enter your resume.';
    }

    $view_model->has_error =
        !empty($view_model->first_name_error) ||
        !empty($view_model->last_name_error) ||
        !empty($view_model->email_error) ||
        !empty($view_model->phone_error) ||
        !empty($view_model->desired_job_error) ||
        !empty($view_model->resume_error);

    $view_model->output_form = $view_model->has_error;

    //se não tiver error inserir os dados 

    return $view_model;
}
