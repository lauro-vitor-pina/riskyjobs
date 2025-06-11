<?php

class RegistrationViewModel
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $desired_job = '';
    public string $resume = '';
    public string $phone = '';

    public string $first_name_error = '';
    public string $last_name_error = '';
    public string $email_error = '';
    public string $desired_job_error = '';
    public string $phone_error = '';
    public string $resume_error = '';

    public bool $output_form = true;
    public bool $has_error = false;
}
