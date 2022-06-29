## Projekt rekrutacyjny

### Data rozpoczęcia:

28.06.2022

### Data zakończenia:

29.06.2022

### Instalacja

Zmiana nazwy pliku z .env.example do .env (lotto_app/.env.example)

Uruchomienie komendy <code>docker-compose up -d</code>

Uruchomienie komendy <code>docker exec -it lotto_app_php bash</code>

Uruchomienie komendy <code>composer install</code>

Uruchomienie komendy <code>php artisan key:generate</code>

Uruchomienie komendy <code>php artisan migrate</code>

### Testy:

Uruchomienie komendy <code>docker-compose exec php php artisan test</code>


### Dokumentacja:

- Wyniki losowania po wprowadzeniu jego daty <code>/api/v1/results/get-by-date?date=?</code>
- Ilość wystąpień wprowadzonej liczby oraz wszystkie daty jej wystąpienia w dotychczasowych losowaniach <code>/api/v1/results/get-by-number?number=?</code>
