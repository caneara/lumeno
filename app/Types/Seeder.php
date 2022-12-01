<?php

namespace App\Types;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder as BaseSeeder;

abstract class Seeder extends BaseSeeder
{
    /**
     * Write a finished seed message to the console for the given resource.
     *
     */
    protected function finished(string $resource, float $start) : void
    {
        $ms = (microtime(true) - $start) * 1000;

        if ($ms >= 60000) {
            $time = number_format($ms / 60000, 2) . 'm';
        } elseif ($ms >= 1000) {
            $time = number_format($ms / 1000, 2) . 's';
        } else {
            $time = number_format($ms, 2) . 'ms';
        }

        $this->command->getOutput()->writeln(
            "<info>Seeded:</info> {$resource} ({$time})"
        );
    }

    /**
     * Seed the database.
     *
     */
    public function run() : void
    {
        cache()->flush();

        Model::preventLazyLoading(false);

        File::deleteDirectory(storage_path('app'), true);
    }

    /**
     * Perform a specific seed operation.
     *
     */
    public function seed(string $resource, string $parameter = '') : void
    {
        $method = (string) str($resource)->plural()->replace(['/', ',', ' or ', ' '], '')->prepend('seed');

        if (! method_exists($this, $method)) {
            $method = (string) str($resource)->replace(['/', ',', ' or ', ' '], '')->prepend('seed');
        }

        $start = $this->starting($resource);

        $this->$method($parameter);

        $this->finished($resource, $start);
    }

    /**
     * Write a starting seed message to the console for the given resource.
     *
     */
    protected function starting(string $resource) : float
    {
        $this->command->getOutput()->writeln(
            "<comment>Seeding:</comment> {$resource}"
        );

        return microtime(true);
    }
}
