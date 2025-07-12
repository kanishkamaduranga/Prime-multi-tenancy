<?php

namespace App\Filament\Resources\BasicNotes\EmployeeResource\Pages;

use App\Filament\Resources\BasicNotes\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
