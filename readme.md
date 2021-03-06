# Installation

1. Install [Homebrew](https://brew.sh/)
1. Install composer (`brew install composer`)
1. Install [Valet](https://laravel.com/docs/5.7/valet#installation)

# Setup

1. In the project directory, run `composer install`
1. In the project directory, run `valet link tt`
1. Run `createdb tube_tracker_dev`
1. In the project directory, run `cp .env.example .env`
1. Open `.env` and replace `root` with your computer username
1. In the project directory, run `php artisan migrate`
1. [Optional] In the project directory, run `php artisan db:seed`

# TVDB API setup

1. Sign up for an account on [TheTDVDB](https://www.thetvdb.com/)
1. [Generate an API Key](https://www.thetvdb.com/member/api)
1. Add the API key to your `.env` file


The app will be hosted at `tt.test`.
