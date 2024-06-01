# Daily Tasks
in `frontend/` add file `.env.local` and put into it:
```
NEXT_PUBLIC_BACKEND_URL=<eg. http://localhost/DailyTasks/backend/>
```

in `backend/` change in `cors.php`:
```
$frontendDomain = "<eg. http://localhost:3000>";
```