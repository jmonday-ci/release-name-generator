<?php

function generateName()
{
    $animals = getAnimals();
    $animals = $animals[array_rand($animals)];
    shuffle($animals);

    $adjectives = getJson(__DIR__ . '/lib/adjectives.json');
    shuffle($adjectives);
    $adjective = $adjectives[array_rand($adjectives)];

    foreach ($animals as $animal) {
        if (strtoupper($animal[0]) === strtoupper($adjective[0])) {
            return ucwords(sprintf('%s %s', $adjective, $animal));
        } else  {
            return generateName();
        }
    }

    return null;
}

function getAnimals()
{
    $animals = [];

    foreach (glob(__DIR__ . '/lib/animals/*.json') as $path) {
        $info = pathinfo($path);
        $animals[$info['filename']] = getJson($path);
    }

    return $animals;
}

function getJson($path)
{
    if (file_exists($path)) {
        return json_decode(file_get_contents($path));
    } else {
        return [];
    }
}

$keys = array_keys(getAnimals());
shuffle($keys);
$key = array_pop($keys);

$adjectives = getJson(__DIR__ . '/lib/adjectives.json');
shuffle($adjectives);
$adjective = array_pop($adjectives);

print_r(generateName() . "\n");

