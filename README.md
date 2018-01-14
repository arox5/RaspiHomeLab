# RaspiHomeLab
A simple and easy web application for home automation.

Main targets:
1. handle the features provided by DLink DCS-932L IP camera
   - show current picture
   - shot list of pictures created by motion detection
   - change settings
1. handle theft protection system (Olympia Protect 9061)
1. handle themperature sensor (Oregon Scientific EW 93)

System setup:
- Raspberry PI 3 with Raspbian Stretch. Installed software:
  - Web server: Apache with PHP and Curl
  - FTP server: Pure-FTPd
  - Home theater: Kodi
- DLink DCS-932L
  - Firmware downgraded to 1.12.02 (this is required in order to have full control of the camera)
  - Motion detection with upload via FTP to the Raspberry PI
- Modem Fastgate (provided by italian ISP Fastweb)
  - Public IP address
  - Port forwarding enabled to reach the Raspberry PI via port 443
- Website domain name registered for free at http://www.freenom.com/
- HTTPS enabled for free with https://letsencrypt.org/

*in progress*
