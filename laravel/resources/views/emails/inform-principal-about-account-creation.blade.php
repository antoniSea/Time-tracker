# Dzień dobry {{ $principal->name }},
## Konto dla {{ $user->name }} zostało utworzone.
<br>
<br>
## Dane do logowania:
### Login: {{ $user->email }}
### Hasło: Hasło powinno zostać przekazane inną drogą.

@include('emails.reusable.footer')
