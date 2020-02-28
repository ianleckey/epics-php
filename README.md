![PHP Composer](https://github.com/ianleckey/epics-php/workflows/PHP%20Composer/badge.svg)

# epics-php

## Installation

Currently pre-release so no git tags syncing with packagist. Specify `dev-dev` along with the composer require command:

`composer require ianleckey/epics-php dev-dev`

## Authentication

```php
$auth = new Epics\Auth('email', 'password');
```

## Teams

The following properties are available in `Epics\Entity\Team` objects:

| Property | Description |
| --- | --- |
| id | (int) Epics team ID |
| country | (string) ISO 3166-1 alpha-2 two character country code (lowercase) |
| name | (string) Team name |
| active | (boolean) |
| images | (array) team_banner and team_logo images |
| shortName | (string) Short team name, i.e. "NiP" |
| manager | (string) Team manager. Not incredibly useful yet as this seems to always be "N/A" |
| dob | (string) Date the team was founded. YYYY-MM-DD |


To get all teams, call the `getAllTeams()` static method of the Team class:

```php
use Epics\Entity;
$teams = Team::getAllTeams();
```

To get a single team, pass the team ID into the Team class constructor:

```php
use Epics\Entity;
$team = new Team(1);
```

**Note:** `getAllTeams()` will return live, uncached data. Whereas (if caching is enabled), `new Epics\Entity\Team(1)` will return a team from the currently cached team data. Any time `getAllTeams()` is called however, the local cache will be updated.

To get an array of players for a team:

```php
use Epics\Entity;
$team = new Team(1);
$players = $team->getPlayers();
```

This will return an array of `Epics\Entity\Player` objects.

## Players

The following properties are availabe in `Epics\Entity\Player` objects:

| Property | Description |
| --- | --- |
| id | (int) Epics team ID |
| country | (string) ISO 3166-1 alpha-2 two character country code (lowercase) |
| name | (string) Player name |
| active | (boolean) |
| images | (array) |
| dob | (string) Player date of birth. YYYY-MM-DD |
| age | |
| gameId | (int) |
| handle | (string) Player handle/nickname |
| position | (string) Playing position of player, i.e. rifler |
| frameType | |
| lastDate | |
| videos | (array) |
| playerFrames | (array) |

Aside from running `getPlayers()` on an `Epics\Entity\Team` object, you can get individual players by passing a player ID into the Player constructor:

```php
use Epics\Entity;
$player = new Player(665);
```