<?php

class SearchViewModel
{
    public array $rows = [];

    public int $page_number = 0;
    public int $page_size = 5;
    public int $num_pages = 0;
    public int $total = 0;

    public int $sort = 0;

    public string $search = '';

    public function get_sort_config(): array
    {
        $sort_config = [
            'Job Title' => $this->sort == ENUM_SORT_RISKYJOBS['title_asc'] ? ENUM_SORT_RISKYJOBS['title_desc'] : ENUM_SORT_RISKYJOBS['title_asc'],
            'Description' => null,
            'State' => $this->sort == ENUM_SORT_RISKYJOBS['state_asc'] ? ENUM_SORT_RISKYJOBS['state_desc'] : ENUM_SORT_RISKYJOBS['state_asc'],
            'Date Posted' => $this->sort == ENUM_SORT_RISKYJOBS['date_posted_asc'] ? ENUM_SORT_RISKYJOBS['date_posted_desc'] : ENUM_SORT_RISKYJOBS['date_posted_asc'],
        ];

        return $sort_config;
    }
}
