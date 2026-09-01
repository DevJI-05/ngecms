<?php

namespace App\Support;

class StrictEmail
{
    /**
     * Requires a TLD after the domain (e.g. rejects "a@b", accepts "a@b.com").
     */
    public const REGEX = '/^[^@\s]+@[^@\s]+\.[^@\s]{2,}$/';
}
