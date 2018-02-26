import fcntl
import struct
import array
import bluetooth
import bluetooth._bluetooth as bt
import time
import datetime
import requests
import btcheck_cfg 

# ------------------------------------------------------------------------------------------
# file btcheck_cfg.py contains two variables:
# 1) array of bluetooth addresses to check
#    addrList=['11:AA:22:BB:33:CC','44:DD:55:EE:66:EE']
#
# 2) URL of the remote php page with the input token to override the authentication
#    cameraURL = 'http://localhost/local/remote.php?token=123abc&action='
# ------------------------------------------------------------------------------------------

# ------------------------------------------------------------------------------------------
# code inspired by this project
# https://github.com/dagar/bluetooth-proximity/blob/master/proximity_dagar.py
# ------------------------------------------------------------------------------------------

# ------------------------------------------------------------------------------------------
def bluetooth_rssi(addr):
    # Open hci socket
    hci_sock = bt.hci_open_dev()
    hci_fd = hci_sock.fileno()

    # Connect to device (to whatever you like)
    bt_sock = bluetooth.BluetoothSocket(bluetooth.L2CAP)
    bt_sock.settimeout(10)
    result = bt_sock.connect_ex((addr, 1))    # PSM 1 - Service Discovery

    try:
        # Get ConnInfo
        reqstr = struct.pack("6sB17s", bt.str2ba(addr), bt.ACL_LINK, "\0" * 17)
        request = array.array("c", reqstr )
        handle = fcntl.ioctl(hci_fd, bt.HCIGETCONNINFO, request, 1)
        handle = struct.unpack("8xH14x", request.tostring())[0]

        # Get RSSI
        cmd_pkt=struct.pack('H', handle)
        rssi = bt.hci_send_req(hci_sock, bt.OGF_STATUS_PARAM, bt.OCF_READ_RSSI, bt.EVT_CMD_COMPLETE, 4, cmd_pkt)
        rssi = struct.unpack('b', rssi[3])[0]

        # Close sockets
        bt_sock.close()
        hci_sock.close()

        return rssi

    except:
        return None
# ------------------------------------------------------------------------------------------

# ------------------------------------------------------------------------------------------
def bt_check(address_list):
    returnValue = None
    for addr in address_list:
        # get rssi reading for address
        if bluetooth_rssi(addr) != None:
            return addr

    return returnValue
# ------------------------------------------------------------------------------------------

# ------------------------------------------------------------------------------------------
def log(text):
    strlog = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S") + ' ' + text
    print strlog

    f = open('btcheck.log', 'a')
    f.write(strlog + '\n')
    f.close()
# ------------------------------------------------------------------------------------------

# ------------------------------------------------------------------------------------------
def changeConfig(cameraEnable):
    action = ''
    if cameraEnable:
        log('Enable camera...')
        action = 'on'
    else:
        log('Disable camera...')
        action = 'off'

    req = requests.get(btcheck_cfg.cameraURL + action)

    if req.status_code == 200:
        log('...success')
    else:
        log('...failure (code: ' + str(req.status_code) + ')')

    #print req.status_code
    #print req.headers
    #print req.content
# ------------------------------------------------------------------------------------------

#print 'Running...'

req = requests.get(btcheck_cfg.cameraURL)

#print req.status_code
#print req.headers
#print req.content

cameraOn = False

if req.content == 'ON':
    cameraOn =True

log('Current camera settings is ' + str(cameraOn))

#while True:
# check if at least one device is in range
addrFound = bt_check(btcheck_cfg.addrList)

if addrFound == None:
    # there's no device available, I enable the camera
    log('No device found')
    if cameraOn == False:
        changeConfig(True)
        cameraOn = True
    else:
        log('Camera already enabled')
else:
    # there's at least one device available, I disable the camera
    log('Address found ' + addrFound)
    if cameraOn:
        changeConfig(False)
        cameraOn = False
    else:
        log('Camera already disabled')
    
#time.sleep(2)