<?php

namespace App\Enums;

enum CategoriesEnum: string
{
    case HOME = 'Home';

    case WORK = 'Work';

    case SCHOOL = 'School';

    case PERSONAL = 'Personal';


    public static function getLabel(self|int $value): string
    {
        if (is_int($value)) {
            $value = self::tryFrom($value);
        }

        return match ($value) {
            self::HOME => 'Home',
            self::WORK => 'Work',
            self::SCHOOL => 'School',
            self::PERSONAL => 'Personal',
            default => 'Unknown',
        };
    }

    public function label(): string
    {
        return self::getLabel($this);
    }
}