# hu.es-progress.name-day

This extension creates a new entity (Name days), and creates a daily scheduled job to apply a custom tag to contacts who has name day on the day.

This tag then can be used for further processing. E.g: creating a smart group then a CiviRule to send an email them every day.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM (5.25) might work below, not tested

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl hu.es-progress.name-day@https://github.com/semseysandor/hu.es-progress.name-day/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/semseysandor/hu.es-progress.name-day.git
cv en name_day
```

## Usage

After installation there will be a new entity (`EsProgressNameDay`) where you can store name-day info: first names and dates (format: `mm-dd` e.g. 05-17).

Also it creates a daily scheduled job to put a tag (`name day`) on contacts who has name day that day.

## Known Issues
