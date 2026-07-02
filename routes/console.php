<?php


use Illuminate\Support\Facades\Schedule;

Schedule::command('app:generate-album')->dailyAt('01:00');
Schedule::command('app:import-project-content')->dailyAt('02:00');
Schedule::command('app:generate-sitemap ivnbg --path=../domains/ivnbg.com/public_html')->dailyAt('03:00');
Schedule::command('app:generate-sitemap martinvach --path=../domains/martinvach.com/public_html')->dailyAt('04:00');
Schedule::command('app:generate-sitemap vades --path=../domains/vades.dev/public_html')->dailyAt('05:00');
