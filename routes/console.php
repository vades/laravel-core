<?php


use Illuminate\Support\Facades\Schedule;

Schedule::command('app:generate-album')->dailyAt('01:00');
Schedule::command('app:import-project-content')->dailyAt('02:00');
//Schedule::command('app:generate-sitemap')->dailyAt('04:00');
