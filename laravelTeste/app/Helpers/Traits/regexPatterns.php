<?php

namespace App\Helpers\Traits;

trait RegexPatterns
{
    public string $regex_name_pattern = '/^[a-záéíóúâêôãõç\' ]+$/ui';
    public string $regex_sex_pattern = '/^[FMO]$/';
    public string $regex_cpf_pattern = '/^\d{3}.?\d{3}.?\d{3}-?\d{2}$/';
    public string $regex_phone = '/^\d{4,7}-?\d{4}$/';
}
