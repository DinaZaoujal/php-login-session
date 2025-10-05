# PHP Login Session Project

Dit project bevat een simpel login-systeem in PHP dat werkt met sessions.

## Bestanden
- `login.php` — loginformulier en verificatie.  
  - Gebruik om in te loggen:
    - **E-mail:** `jenaam@shop.com`
    - **Wachtwoord:** `12345isnotsecure`
  - Bij succesvolle login wordt een session aangemaakt en wordt doorgestuurd naar `index.php`. Bij foutieve inloggegevens wordt een duidelijke foutmelding getoond.

- `index.php` — pagina alleen toegankelijk wanneer je ingelogd bent (controleert `$_SESSION['logged_in']`).  
- `logout.php` — vernietigt de sessie en stuurt terug naar `login.php`.

## Hoe lokaal testen
1. Zorg dat je PHP geïnstalleerd is.
2. Start een lokale server in de projectmap:
   php -S localhost:8000
3. Open in je browser: http://localhost:8000/login.php
4. Log in met bovenstaande e-mail en wachtwoord. Bij succes kom je op index.php.

## Git / GitHub
- Branch: main
- Push je wijzigingen met:
  git add .
  git commit -m "Update: README en kleine fixes"
  git push

## Opmerkingen
- Deze login is voor oefendoeleinden en gebruikt hardcoded credentials — niet voor productie.
- Voor productiewaardige applicaties gebruik je een database en veilige wachtwoordhashing (bijv. password_hash() / password_verify()).
