<?php

namespace App\Support;

class HexColor
{
    /**
     * Matches a 3- or 6-digit hex color (e.g. #fff or #0a84ff).
     */
    public const REGEX = '/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/';
}
