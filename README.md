# RaspiHomeLab
A simple and easy web application for general purpose home automation and media center. This is my personal lab.

## Main targets
1. Handle web application authentication (features are provided only to authenticated user)
1. Handle the features provided by DLink DCS-932L IP camera
   - show current picture
   - shot list of pictures created by motion detection
   - change settings
1. Handle theft protection system (Olympia Protect 9061)
1. Handle themperature sensor (Oregon Scientific EW 93)
1. Who knows...

## System setup
- **Raspberry PI 3** with Raspbian Stretch. Installed software:
  - Web server: Apache with PHP
  - FTP server: Pure-FTPd
  - Home theater: Kodi
- **DLink DCS-932L**
  - Firmware downgraded to 1.12.02. Remarks: 
    - This is required in order to have full control of the camera via web requests
    - With this firmware the control from the app is not available
  - Motion detection with upload via FTP to the Raspberry PI
- **Modem Fastgate** (provided by italian ISP Fastweb)
  - Public IP address
  - Port forwarding enabled to reach the Raspberry PI via port 443 (no other port forwarding)
  - UPNP disabled
  - One old 160 GB hard disk attached to a USB port
    - the content is shared as a NAS
    - it contains only music files
    - it can be accessed by Kodi
- Website **domain name** registered for free at http://www.freenom.com/
- **HTTPS enabled** for free with https://letsencrypt.org/
- **Monitoring** with https://www.pingdom.com/ free account
- Exclude the web site from **Google search** using robots.txt and checking the result with https://www.google.com/webmasters/ 
- Windows 10 with Internet Explorer 11 configured in this way (otherwise it's not possible to reach the camera IP address):
  - Open Internet Explorer
  - Click on settings (Gear) option present on the top right corner
  - Select Internet option
  - Go to Security tab, click on green check mark and then Sites
  - Add the camera IP address to the list, uncheck the check box related to "https" and then click OK/Close


*in progress*
