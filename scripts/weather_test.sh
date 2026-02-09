#!/bin/bash

echo "sending data through ecowitt end point"
curl -X POST http://weatherstation.test/data/report -d "PASSKEY=0BA6979558C5D2ADB6B20F4B23A685AF@stationtype=GW1000_V1.4.7&dateutc=2019-05-28+07:33:48&tempf=79.3&humidity=70&winddir=277&windspeeddmph=0.00&windgustmph=0.00&solarradiantion=0.00&UV=0&tempinf=78.6&humidityin=71&baromrelin=29.71"

echo ""

echo "sending data through wunderground end point"
curl 'http://weatherstation.test/weatherstation/updateweatherstation.php?ID=IU5E7FU442&PASSWORD=lsrling198&tempf=79.3&humidity=70&dewptf=68.7&windchillf=79.3&winddir=277&windspeedmph=0.00&windgustmph=0.00&rainin=0.000&dailyrainin=0.000&weeklyrainin=0.000&monthlyrainin=0.059&yearlyrainin=6.803&solarradiation=0.00&UV=0&indoortempf=78.6&indoorhumidity=71&baromin=29.71&soilmoisture2=0&soilmoisture3=0&soilmoisture4=8&soilmoisture5=0&lowbatt=1&dateutc=2026-02-08+12:00:00&softwaretype=GW1000_V1.4.7&action=updateraw&realtime=1&rtfreq=5'
