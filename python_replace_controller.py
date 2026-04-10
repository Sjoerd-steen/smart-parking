import re

with open('app/Http/Controllers/User/ReservationController.php', 'r') as f:
    content = f.read()

content = content.replace(
    "public function create() {",
    "public function create(Request $request) {"
)

content = content.replace(
    "return view('user.reserve', compact('spotsWithStatus'));",
    "$selectedSpotId = $request->query('spot_id');\n        return view('user.reserve', compact('spotsWithStatus', 'selectedSpotId'));"
)

with open('app/Http/Controllers/User/ReservationController.php', 'w') as f:
    f.write(content)
