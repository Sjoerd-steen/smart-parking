with open("app/Services/ParkingApiService.php", "r") as f:
    code = f.read()

replacements = """            ['id' => 'rot-26', 'name' => 'Maassluis Centrum', 'lat' => 51.921, 'lng' => 4.255, 'city' => 'Maassluis', 'capacity' => 100, 'price_per_hour' => 1.50],
            ['id' => 'rot-27', 'name' => 'Maassluis West', 'lat' => 51.922, 'lng' => 4.240, 'city' => 'Maassluis', 'capacity' => 120, 'price_per_hour' => 1.50],
            ['id' => 'rot-28', 'name' => 'Maassluis Station', 'lat' => 51.919, 'lng' => 4.250, 'city' => 'Maassluis', 'capacity' => 150, 'price_per_hour' => 1.00],
            ['id' => 'rot-29', 'name' => 'Lely Maassluis', 'lat' => 51.925, 'lng' => 4.260, 'city' => 'Maassluis', 'capacity' => 80, 'price_per_hour' => 1.20],
            ['id' => 'rot-30', 'name' => 'Koningshoek Maassluis', 'lat' => 51.928, 'lng' => 4.245, 'city' => 'Maassluis', 'capacity' => 200, 'price_per_hour' => 2.00],
            ['id' => 'rot-31', 'name' => 'Steendijkpolder', 'lat' => 51.930, 'lng' => 4.250, 'city' => 'Maassluis', 'capacity' => 90, 'price_per_hour' => 1.00],
            ['id' => 'rot-32', 'name' => 'Maassluis Haven', 'lat' => 51.918, 'lng' => 4.252, 'city' => 'Maassluis', 'capacity' => 110, 'price_per_hour' => 1.50],
            ['id' => 'rot-33', 'name' => 'Maassluis Markt', 'lat' => 51.920, 'lng' => 4.254, 'city' => 'Maassluis', 'capacity' => 60, 'price_per_hour' => 1.50],
            ['id' => 'rot-34', 'name' => 'Burgemeesterwijk', 'lat' => 51.923, 'lng' => 4.258, 'city' => 'Maassluis', 'capacity' => 75, 'price_per_hour' => 1.20],
            ['id' => 'rot-35', 'name' => 'Sluispolder', 'lat' => 51.916, 'lng' => 4.248, 'city' => 'Maassluis', 'capacity' => 130, 'price_per_hour' => 1.00],
            ['id' => 'rot-36', 'name' => 'Maassluis Zuid', 'lat' => 51.915, 'lng' => 4.245, 'city' => 'Maassluis', 'capacity' => 140, 'price_per_hour' => 1.00],
            ['id' => 'rot-37', 'name' => 'Maassluis Oost', 'lat' => 51.917, 'lng' => 4.260, 'city' => 'Maassluis', 'capacity' => 100, 'price_per_hour' => 1.00],
            ['id' => 'rot-38', 'name' => 'Vogelwijk', 'lat' => 51.924, 'lng' => 4.242, 'city' => 'Maassluis', 'capacity' => 65, 'price_per_hour' => 1.00],
            ['id' => 'rot-39', 'name' => 'Kapelpolder', 'lat' => 51.926, 'lng' => 4.265, 'city' => 'Maassluis', 'capacity' => 85, 'price_per_hour' => 1.00],
            ['id' => 'rot-40', 'name' => 'Maassluis P1', 'lat' => 51.921, 'lng' => 4.253, 'city' => 'Maassluis', 'capacity' => 200, 'price_per_hour' => 1.50],
            ['id' => 'rot-41', 'name' => 'Maassluis P2', 'lat' => 51.922, 'lng' => 4.256, 'city' => 'Maassluis', 'capacity' => 180, 'price_per_hour' => 1.50],
            ['id' => 'rot-42', 'name' => 'Maassluis P3', 'lat' => 51.920, 'lng' => 4.251, 'city' => 'Maassluis', 'capacity' => 150, 'price_per_hour' => 1.20],
            ['id' => 'rot-43', 'name' => 'Maassluis P4', 'lat' => 51.919, 'lng' => 4.249, 'city' => 'Maassluis', 'capacity' => 120, 'price_per_hour' => 1.20],
            ['id' => 'rot-44', 'name' => 'Maassluis P5', 'lat' => 51.923, 'lng' => 4.246, 'city' => 'Maassluis', 'capacity' => 90, 'price_per_hour' => 1.00],
            ['id' => 'rot-45', 'name' => 'Maassluis P6', 'lat' => 51.924, 'lng' => 4.244, 'city' => 'Maassluis', 'capacity' => 110, 'price_per_hour' => 1.00],
            ['id' => 'rot-46', 'name' => 'Pyongyang Central', 'lat' => 39.019, 'lng' => 125.738, 'city' => 'North Korea', 'capacity' => 250, 'price_per_hour' => 5.00],
            ['id' => 'rot-47', 'name' => 'Kim Il Sung Square', 'lat' => 39.018, 'lng' => 125.753, 'city' => 'North Korea', 'capacity' => 500, 'price_per_hour' => 10.00],
            ['id' => 'rot-48', 'name' => 'Rungrado 1st of May Stadium', 'lat' => 39.049, 'lng' => 125.775, 'city' => 'North Korea', 'capacity' => 400, 'price_per_hour' => 4.00],
            ['id' => 'rot-49', 'name' => 'Juche Tower Parking', 'lat' => 39.017, 'lng' => 125.763, 'city' => 'North Korea', 'capacity' => 150, 'price_per_hour' => 2.00],
            ['id' => 'rot-50', 'name' => 'Indie Central', 'lat' => 20.593, 'lng' => 78.962, 'city' => 'Indie', 'capacity' => 300, 'price_per_hour' => 0.50],"""

import re

# Match everything from rot-26 to rot-50 and replace
pattern = r"(\['id' => 'rot-26'.*?)(?=];\n    }\n)"
code = re.sub(pattern, replacements + "\n        ", code, flags=re.DOTALL)

with open("app/Services/ParkingApiService.php", "w") as f:
    f.write(code)
