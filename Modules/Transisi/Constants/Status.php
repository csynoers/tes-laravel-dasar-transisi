<?php
namespace Modules\Transisi\Constants;

class Status
{
    const ACTIVE = 1;
    const INACTIVE = 2;
    const BLOCK = 3;

    public static function labels(): array
    {
        return [
            self::ACTIVE => "Aktif",
            self::INACTIVE => "Tidak Aktif",
            self::BLOCK => "Di Block",
        ];
    }
}
