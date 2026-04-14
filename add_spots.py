import sys

with open('app/Services/ParkingApiService.php', 'r') as f:
    content = f.read()

spots = """            ['id' => 'rot-11', 'name' => 'Parkeergarage Meent', 'lat' => 51.922, 'lng' => 4.482, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 2.50],
            ['id' => 'rot-12', 'name' => 'Parking Zuidplein', 'lat' => 51.884, 'lng' => 4.488, 'city' => 'Rotterdam', 'capacity' => 1500, 'price_per_hour' => 1.50],
            ['id' => 'rot-13', 'name' => 'Parkhaven P1', 'lat' => 51.906, 'lng' => 4.466, 'city' => 'Rotterdam', 'capacity' => 350, 'price_per_hour' => 2.00],
            ['id' => 'rot-14', 'name' => 'Kuip P2', 'lat' => 51.894, 'lng' => 4.520, 'city' => 'Rotterdam', 'capacity' => 800, 'price_per_hour' => 2.00],
            ['id' => 'rot-15', 'name' => 'Ahoy P1', 'lat' => 51.883, 'lng' => 4.489, 'city' => 'Rotterdam', 'capacity' => 1200, 'price_per_hour' => 3.00],
            ['id' => 'rot-16', 'name' => 'Delfshaven Parking', 'lat' => 51.910, 'lng' => 4.450, 'city' => 'Rotterdam', 'capacity' => 250, 'price_per_hour' => 2.00],
            ['id' => 'rot-17', 'name' => 'Kralingse Zoom', 'lat' => 51.918, 'lng' => 4.530, 'city' => 'Rotterdam', 'capacity' => 600, 'price_per_hour' => 1.50],
            ['id' => 'rot-18', 'name' => 'Slinge Parking', 'lat' => 51.874, 'lng' => 4.482, 'city' => 'Rotterdam', 'capacity' => 850, 'price_per_hour' => 1.00],
            ['id' => 'rot-19', 'name' => 'Capelsebrug', 'lat' => 51.928, 'lng' => 4.550, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 1.50],
            ['id' => 'rot-20', 'name' => 'Meijersplein', 'lat' => 51.956, 'lng' => 4.476, 'city' => 'Rotterdam', 'capacity' => 350, 'price_per_hour' => 1.50],
            ['id' => 'rot-21', 'name' => 'Alexander', 'lat' => 51.956, 'lng' => 4.555, 'city' => 'Rotterdam', 'capacity' => 900, 'price_per_hour' => 1.80],
            ['id' => 'rot-22', 'name' => 'Nesselande P+R', 'lat' => 52.002, 'lng' => 4.582, 'city' => 'Rotterdam', 'capacity' => 500, 'price_per_hour' => 1.00],
            ['id' => 'rot-23', 'name' => 'Beverwaard P+R', 'lat' => 51.890, 'lng' => 4.552, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 1.00],
            ['id' => 'rot-24', 'name' => 'Kralingse Bos N', 'lat' => 51.940, 'lng' => 4.515, 'city' => 'Rotterdam', 'capacity' => 200, 'price_per_hour' => 2.00],
            ['id' => 'rot-25', 'name' => 'Kralingse Bos Z', 'lat' => 51.930, 'lng' => 4.525, 'city' => 'Rotterdam', 'capacity' => 250, 'price_per_hour' => 2.00],
            ['id' => 'rot-26', 'name' => 'Euromast Park', 'lat' => 51.905, 'lng' => 4.467, 'city' => 'Rotterdam', 'capacity' => 300, 'price_per_hour' => 2.50],
            ['id' => 'rot-27', 'name' => 'Nieuwe Binnenweg', 'lat' => 51.916, 'lng' => 4.465, 'city' => 'Rotterdam', 'capacity' => 100, 'price_per_hour' => 2.50],
            ['id' => 'rot-28', 'name' => 'West-Kruiskade', 'lat' => 51.921, 'lng' => 4.469, 'city' => 'Rotterdam', 'capacity' => 120, 'price_per_hour' => 2.50],
            ['id' => 'rot-29', 'name' => 'Botersloot', 'lat' => 51.922, 'lng' => 4.487, 'city' => 'Rotterdam', 'capacity' => 150, 'price_per_hour' => 3.00],
            ['id' => 'rot-30', 'name' => 'Blaak P1', 'lat' => 51.918, 'lng' => 4.487, 'city' => 'Rotterdam', 'capacity' => 600, 'price_per_hour' => 3.50],
            ['id' => 'rot-31', 'name' => 'Goudsesingel P', 'lat' => 51.925, 'lng' => 4.488, 'city' => 'Rotterdam', 'capacity' => 200, 'price_per_hour' => 2.80],
            ['id' => 'rot-32', 'name' => 'Hofplein P2', 'lat' => 51.925, 'lng' => 4.478, 'city' => 'Rotterdam', 'capacity' => 350, 'price_per_hour' => 3.00],
            ['id' => 'rot-33', 'name' => 'Coolsingel P', 'lat' => 51.922, 'lng' => 4.479, 'city' => 'Rotterdam', 'capacity' => 450, 'price_per_hour' => 3.50],
            ['id' => 'rot-34', 'name' => 'Wijnhaven Parking', 'lat' => 51.917, 'lng' => 4.486, 'city' => 'Rotterdam', 'capacity' => 300, 'price_per_hour' => 3.20],
            ['id' => 'rot-35', 'name' => 'Leuvehaven P1', 'lat' => 51.915, 'lng' => 4.482, 'city' => 'Rotterdam', 'capacity' => 250, 'price_per_hour' => 3.00],
            ['id' => 'rot-36', 'name' => 'Boompjes P', 'lat' => 51.913, 'lng' => 4.488, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 3.00],
            ['id' => 'rot-37', 'name' => 'Willemsplein', 'lat' => 51.910, 'lng' => 4.481, 'city' => 'Rotterdam', 'capacity' => 150, 'price_per_hour' => 3.20],
            ['id' => 'rot-38', 'name' => 'Kop van Zuid P', 'lat' => 51.908, 'lng' => 4.492, 'city' => 'Rotterdam', 'capacity' => 500, 'price_per_hour' => 3.50],
            ['id' => 'rot-39', 'name' => 'World Port Center', 'lat' => 51.905, 'lng' => 4.486, 'city' => 'Rotterdam', 'capacity' => 350, 'price_per_hour' => 3.50],
            ['id' => 'rot-40', 'name' => 'De Rotterdam P', 'lat' => 51.907, 'lng' => 4.488, 'city' => 'Rotterdam', 'capacity' => 450, 'price_per_hour' => 3.50],
            ['id' => 'rot-41', 'name' => 'Maashaven P', 'lat' => 51.898, 'lng' => 4.498, 'city' => 'Rotterdam', 'capacity' => 200, 'price_per_hour' => 2.50],
            ['id' => 'rot-42', 'name' => 'Rijnhaven P', 'lat' => 51.902, 'lng' => 4.495, 'city' => 'Rotterdam', 'capacity' => 250, 'price_per_hour' => 2.80],
            ['id' => 'rot-43', 'name' => 'Katendrecht P1', 'lat' => 51.900, 'lng' => 4.480, 'city' => 'Rotterdam', 'capacity' => 300, 'price_per_hour' => 2.50],
            ['id' => 'rot-44', 'name' => 'SS Rotterdam P', 'lat' => 51.900, 'lng' => 4.475, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 3.00],
            ['id' => 'rot-45', 'name' => 'Entrepothaven', 'lat' => 51.908, 'lng' => 4.503, 'city' => 'Rotterdam', 'capacity' => 150, 'price_per_hour' => 2.00],
            ['id' => 'rot-46', 'name' => 'Laan op Zuid P', 'lat' => 51.905, 'lng' => 4.500, 'city' => 'Rotterdam', 'capacity' => 250, 'price_per_hour' => 2.50],
            ['id' => 'rot-47', 'name' => 'Feyenoord Parking', 'lat' => 51.895, 'lng' => 4.515, 'city' => 'Rotterdam', 'capacity' => 1500, 'price_per_hour' => 2.00],
            ['id' => 'rot-48', 'name' => 'Blijdorp Zoo P', 'lat' => 51.928, 'lng' => 4.445, 'city' => 'Rotterdam', 'capacity' => 800, 'price_per_hour' => 4.00],
            ['id' => 'rot-49', 'name' => 'Oceanium P', 'lat' => 51.930, 'lng' => 4.440, 'city' => 'Rotterdam', 'capacity' => 450, 'price_per_hour' => 4.00],
            ['id' => 'rot-50', 'name' => 'Sparta Stadion', 'lat' => 51.919, 'lng' => 4.433, 'city' => 'Rotterdam', 'capacity' => 500, 'price_per_hour' => 1.50],"""

to_replace = "['id' => 'rot-10', 'name' => 'Parkeergarage Oude Haven', 'lat' => 51.919, 'lng' => 4.490, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 2.30],"

if to_replace in content:
    new_content = content.replace(to_replace, to_replace + "\n" + spots)
    with open('app/Services/ParkingApiService.php', 'w') as f:
        f.write(new_content)
    print("Added 40 custom spots")
else:
    print("String not found")
