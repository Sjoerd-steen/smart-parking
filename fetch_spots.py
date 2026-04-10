import urllib.request
import json
import time

query = """[out:json];
area["name"="Rotterdam"]["admin_level"="8"]->.searchArea;
(
  node["amenity"="parking"](area.searchArea);
  way["amenity"="parking"](area.searchArea);
);
out center 50;"""

url = "https://overpass-api.de/api/interpreter"
data = urllib.parse.urlencode({'data': query}).encode('utf-8')

for i in range(5):
    try:
        req = urllib.request.Request(url, data=data)
        with urllib.request.urlopen(req, timeout=15) as response:
            result = json.loads(response.read().decode('utf-8'))
            if 'elements' in result:
                with open('storage/app/rotterdam_parking.json', 'w') as f:
                    json.dump(result['elements'], f)
                print("Successfully saved spots!")
                break
    except Exception as e:
        print(f"Attempt {i+1} failed: {e}")
        time.sleep(2)
