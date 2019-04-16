[![CircleCI build status](https://img.shields.io/circleci/project/github/entrepreneur-interet-general/ma-semaine.svg?style=flat-square)](https://circleci.com/gh/entrepreneur-interet-general/ma-semaine)
[![Software License](https://img.shields.io/badge/License-AGPL-orange.svg?style=flat-square)](https://github.com/entrepreneur-interet-general/ma-semaine/blob/master/LICENSE)

# What is it
$APP_NAME is a weekly retrospective tool for multiple projects or teams. It lets people reflect on their past week with 4 questions which can be answered super quickly:
- What's the team mood?
- What were the main goals this week?
- What worked great and what was harder?
- Do we need help?

It's asynchronous and transparent at its heart. All teams can fill their retrospective when they want through a simple web interface, as long as it's before Friday 3 PM. On Fridays at 3 PM, everyone gets a weekly recap email with all filled retrospectives. The web interface lets everyone browse through previous retrospectives by week or by team.

## Features
$APP_NAME is opinionated on a few things. Here are some principles:
- Retrospectives should be quick. The form has a select and 3 text inputs. Each text input is limited to 300 characters (a bit more than a tweet). Filling a retrospective for a team takes less than 5 minutes per week.
- We don't provide an authentication system. It should be deployed internally or can be secured with something like HTTP Auth Basic.
- Transparency is important. When teams fill their retrospective, it can be read by all other teams. Everyone who has access to the application can browse through previous retrospectives and export them in CSV.
- Teams are free to fill their weekly retrospective when they want between Sunday midnight and Friday 3PM.
- Teams are reminded to fill their weekly retrospective in various ways:
    - a collective Slack reminder on a channel you can define on Fridays at 10 AM
    - by DM on Slack to each member of a team if the retrospective of the team has not be filled yet on Fridays at 2 PM and 2:45 PM
- At 3 PM every Friday, all filled weekly retrospectives are sent to an email address, typically a mailing list where every member of the team can be reached.
- Previous retrospectives can be seen on the web interface after authenticating with a password you can define. You can define a password hint to help people remember the password.
- Each team can share a unique URL which lets anyone see all previous retrospectives of a specific team. It's useful when working with outside people or clients for example.

## Installation
$APP_NAME is a [Laravel](https://laravel.com) 5.8 project. It requires PHP 7.1+ and [Composer](https://getcomposer.org).

A standard installation may look like this:
```
git clone https://github.com/entrepreneur-interet-general/ma-semaine.git
cd ma-semaine
composer install
cp .env.example .env
php artisan key:generate
```

More information can be found on [Laravel's documentation](https://laravel.com/docs/5.8#installation).

### Configuration
Configuration files are located in `.env` and `config/app.php`.

#### Database
First, specify which database you want to use. Laravel supports various engines (SQLite, MySQL, PostgreSQL, SQL Server). You can specify which database you want to use with `config/database.php` and the related environment variables. To learn more, refer to the [Laravel documentation](https://laravel.com/docs/5.8/database#configuration).

When you've set the database engine, create the application tables with the following command:
```
php artisan migrate
```

#### App settings
Regarding `.env` specific to the app, you should file the following variables:

- `REPORT_TIMEZONE`: The timezone to use for reports. Use a time zone name from the IANA database like Europe/Paris.
- `REPORT_EMAIL`: To which email address should weekly reports be sent to. Example: `team@company.com`
- `REPORT_SECRET`: The password to see previous reports in the web interface.
- `REPORTS_PASSWORD_HINT`: An hint to guess the password of the web interface. If you don't want to provide an hint, leave it null.
- `SLACK_GENERAL_CHANNEL`: A Slack channel name where a reminder to fill the reports will be posted on Fridays at 10 AM. Example: #general

#### Defining teams
You can define your various teams / projects in `config/app.php` under the key `projects`.

```php
<?php
return [
    // More configuration

    'projects' => new App\Projects([
      // Define a project named "Project name 1" with reminders on Slack
      // and 2 members in this project. The array are Slack user IDs.
      // The project logo is stored in `public/images/logo/project-logo.png`
      new App\Project('Project name 1', 'slack', ['UEMA8DE8Y', 'UEN897F5K'], 'images/logo/project-logo.png'),
      // A project with no Slack reminders and the same logo
      new App\Project('Project name 2', null, [], 'images/logo/project-logo.png'),
    ]),

    // More configuration
];
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security related issues, please email antoine.augusti@data.gouv.fr instead of using the issue tracker.

## License
GNU Affero General Public License. Please see the [license file](LICENSE) for more information.

2019 Direction interministérielle du numérique et du système d’information et de communication de l'État. Antoine Augusti.

2019 Contributors accessible through the Git history.
