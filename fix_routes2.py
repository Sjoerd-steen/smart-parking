import re

with open('routes/web.php', 'r') as f:
    content = f.read()

pattern = r'''Route::get\('/reserveren', \[ReservationController::class, 'create'\]\)->name\('reserve'\);'''
replacement = '''Route::get('/reserveren', [ReservationController::class, 'create'])->name('reserve');
    Route::get('/reserveren/status', [ReservationController::class, 'apiStatus'])->name('reserve.status');'''

content = re.sub(pattern, replacement, content)

with open('routes/web.php', 'w') as f:
    f.write(content)
