#Codeception acceptance tests project

Folder zawiera testy akceptacyjne napisane w Codeception, ver. 4.1 do strony `automationpractice.com`.

Aby uruchomić testy należy:

- w terminalu przejść do folderu z projektem
- uruchomić chromedriver komendą:
```shell script
chromedriver --url-base=/wd/hub
```
- przebudować strukturę plików:
```shell script
vendor/bin/codecept build
```
- odpalić testy za pomocą komendy:
```shell script
vendor/bin/codecept run acceptance
```