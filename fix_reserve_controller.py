with open('app/Http/Controllers/User/ReservationController.php', 'r') as f:
    content = f.read()

content = content.replace("return view('user.reserve', compact('spotsWithStatus', 'selectedSpotId'));", "$vehicles = Auth::user()->vehicles;\n        return view('user.reserve', compact('spotsWithStatus', 'selectedSpotId', 'vehicles'));")
content = content.replace("'voertuig'        => 'required|in:Auto,Motor,Fiets,Elektrisch',", "'voertuig'        => 'required|string|max:50',")

with open('app/Http/Controllers/User/ReservationController.php', 'w') as f:
    f.write(content)
