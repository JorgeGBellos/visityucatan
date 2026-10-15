<?php

namespace App\Support\Cms;

class CmsDefaults
{
    /**
     * Fill blanks from defaults without wiping saved CMS values.
     *
     * @param  array<string, mixed>  $defaults
     * @param  array<string, mixed>  $stored
     * @return array<string, mixed>
     */
    public static function merge(array $defaults, array $stored): array
    {
        foreach ($stored as $key => $value) {
            if (! array_key_exists($key, $defaults)) {
                if (filled($value) || $value === false || $value === 0 || $value === '0') {
                    $defaults[$key] = $value;
                }

                continue;
            }

            if (is_array($value) && is_array($defaults[$key])) {
                if (array_is_list($value) || array_is_list($defaults[$key])) {
                    if ($value === []) {
                        continue;
                    }

                    $defaults[$key] = collect($value)
                        ->map(function (mixed $item, int|string $index) use ($defaults, $key): mixed {
                            $defaultItem = $defaults[$key][$index] ?? (is_array($item) ? [] : $item);

                            if (is_array($item) && is_array($defaultItem)) {
                                return self::merge($defaultItem, $item);
                            }

                            return filled($item) ? $item : $defaultItem;
                        })
                        ->values()
                        ->all();

                    continue;
                }

                $defaults[$key] = self::merge($defaults[$key], $value);

                continue;
            }

            if (filled($value) || $value === false || $value === 0 || $value === '0') {
                $defaults[$key] = $value;
            }
        }

        return $defaults;
    }
}
