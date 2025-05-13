<?php

namespace App\Constants;

class StatusClasses
{
    /**
     * Create a new class instance.
     */
    public const CLASSES = [
        1 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full',
        2 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full',
        3 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full',
        4 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-orange-800 bg-orange-100 rounded-full',
        5 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-purple-800 bg-purple-100 rounded-full',
        6 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-lavender-800 bg-lavender-100 rounded-full',
        7 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-teal-800 bg-teal-100 rounded-full',
        8 => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full',
    ];
    public const enumCLASSES = [
        'active' => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full',
        'pending' => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full',
        'suspended' => 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full',
    ];

    public static function getClass(int $statusId): string
    {
        return self::CLASSES[$statusId] ?? 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full';
    }
    public static function getEnumClass(string $status): string
    {
        return self::enumCLASSES[$status] ?? 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full';
    }
}
